<?php

namespace App\Services;
use App\Constants\PaymentProviderConstants;
use App\Constants\SubscriptionStatus;
use App\Events\Subscription\InvoicePaymentFailed;
use App\Events\Subscription\Subscribed;
use App\Events\Subscription\SubscriptionCancelled;
use App\Exceptions\SubscriptionCreationNotAllowedException;
use App\Models\PaymentProvider;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use App\Services\PaymentProviders\PaymentProviderInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubscriptionManager
{
    public function __construct(
        private CalculationManager $calculationManager,
        private PlanManager $planManager,
    ) {

    }
    public function create(string $planSlug, int $userId, ?PaymentProvider $paymentProvider = null, ?string $paymentProviderSubscriptionId = null): Subscription
    {
        $plan = Plan::where('slug', $planSlug)->where('is_active', true)->firstOrFail();

        $notDeadSubscriptions = $this->findAllSubscriptionsThatAreNotDead($userId);

        if (count($notDeadSubscriptions) > 0) {
            throw new SubscriptionCreationNotAllowedException('You already have subscription.');
        }

        $newSubscription = null;
        DB::transaction(function () use ($plan, $userId, &$newSubscription, $paymentProvider, $paymentProviderSubscriptionId) {
            $this->deleteAllNewSubscriptions($userId);

            $planPrice = $this->calculationManager->getPlanPrice($plan);

            $subscriptionAttributes = [
                'uuid' => (string) Str::uuid(),
                'user_id' => $userId,
                'plan_id' => $plan->id,
                'price' => $planPrice->price,
                'currency_id' => $planPrice->currency_id,
                'status' => SubscriptionStatus::NEW->value,
                'interval_id' => $plan->interval_id,
                'interval_count' => $plan->interval_count,
            ];

            if ($paymentProvider) {
                $subscriptionAttributes['payment_provider_id'] = $paymentProvider->id;
            }

            if ($paymentProviderSubscriptionId) {
                $subscriptionAttributes['payment_provider_subscription_id'] = $paymentProviderSubscriptionId;
            }

            $newSubscription = Subscription::create($subscriptionAttributes);
        });

        return $newSubscription;
    }

    public function findAllSubscriptionsThatAreNotDead(int $userId): array
    {
        return Subscription::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('status', SubscriptionStatus::ACTIVE->value)
                    ->orWhere('status', SubscriptionStatus::PENDING->value)
                    ->orWhere('status', SubscriptionStatus::PAUSED->value)
                    ->orWhere('status', SubscriptionStatus::PAST_DUE->value);
            })
            ->get()
            ->toArray();
    }

    public function setAsPending(int $subscriptionId): void
    {
        // make it all in one statement to avoid overwriting webhook status updates
        Subscription::where('id', $subscriptionId)
            ->where('status', SubscriptionStatus::NEW->value)
            ->update([
                'status' => SubscriptionStatus::PENDING->value,
            ]);
    }

    public function deleteAllNewSubscriptions(int $userId): void
    {
        Subscription::where('user_id', $userId)
            ->where('status', SubscriptionStatus::NEW->value)
            ->delete();
    }

    public function findActiveUserSubscription(int $userId): ?Subscription
    {
        return Subscription::where('user_id', $userId)
            ->where('status', '=', SubscriptionStatus::ACTIVE->value)
            ->first();
    }

    public function findActiveByUserAndSubscriptionUuid(int $userId, string $subscriptionUuid): ?Subscription
    {
        return Subscription::where('user_id', $userId)
            ->where('uuid', $subscriptionUuid)
            ->where('status', '=', SubscriptionStatus::ACTIVE->value)
            ->first();
    }

    public function findNewByPlanSlugAndUser(string $planSlug, int $userId): ?Subscription
    {
        $plan = Plan::where('slug', $planSlug)->where('is_active', true)->firstOrFail();

        return Subscription::where('user_id', $userId)
            ->where('plan_id', $plan->id)
            ->where('status', SubscriptionStatus::NEW->value)
            ->first();
    }

    public function findByUuidOrFail(string $uuid): Subscription
    {
        return Subscription::where('uuid', $uuid)->firstOrFail();
    }

    public function findByPaymentProviderId(PaymentProvider $paymentProvider, string $paymentProviderSubscriptionId): ?Subscription
    {
        return Subscription::where('payment_provider_id', $paymentProvider->id)
            ->where('payment_provider_subscription_id', $paymentProviderSubscriptionId)
            ->first();
    }

    public function updateSubscription(
        Subscription $subscription,
        array $data
    ): Subscription {
        $oldStatus = $subscription->status;
        $newStatus = $data['status'] ?? $oldStatus;
        $oldEndsAt = $subscription->ends_at;
        $newEndsAt = $data['ends_at'] ?? $oldEndsAt;
        $subscription->update($data);

        $this->handleDispatchingEvents(
            $oldStatus,
            $newStatus,
            $oldEndsAt,
            $newEndsAt,
            $subscription
        );

        return $subscription;
    }

    private function handleDispatchingEvents(
        string $oldStatus,
        string|SubscriptionStatus $newStatus,
        Carbon|string|null $oldEndsAt,
        Carbon|string|null $newEndsAt,
        Subscription $subscription
    ): void {
        $newStatus = $newStatus instanceof SubscriptionStatus ? $newStatus->value : $newStatus;

        if ($oldStatus !== $newStatus) {
            switch ($newStatus) {
                case SubscriptionStatus::ACTIVE->value:
                    Subscribed::dispatch($subscription);
                    break;
                case SubscriptionStatus::CANCELED->value:
                    SubscriptionCancelled::dispatch($subscription);
                    break;
            }
        }

        // if $oldEndsAt is string, convert it to Carbon
        if (is_string($oldEndsAt)) {
            $oldEndsAt = Carbon::parse($oldEndsAt);
        }

        // if $newEndsAt is string, convert it to Carbon
        if (is_string($newEndsAt)) {
            $newEndsAt = Carbon::parse($newEndsAt);
        }

        // if $newEndsAt > $oldEndsAt, then subscription is renewed
        if ($newEndsAt && $oldEndsAt && $newEndsAt->greaterThan($oldEndsAt)) {
            Subscribed::dispatch($subscription);
        }
    }

    public function handleInvoicePaymentFailed(Subscription $subscription)
    {
        InvoicePaymentFailed::dispatch($subscription);
    }


    public function calculateSubscriptionTrialDays(Plan $plan): int
    {
        if (!$plan->has_trial) {
            return 0;
        }

        $interval = $plan->trialInterval()->firstOrFail();
        $intervalCount = $plan->trial_interval_count;

        $now = Carbon::now();

        return now()->add($interval->date_identifier, $intervalCount)->diff($now)->days;
    }

    public function changePlan(Subscription $subscription, PaymentProviderInterface $paymentProviderStrategy, string $newPlanSlug, bool $isProrated = false): bool
    {
        if ($subscription->plan->slug === $newPlanSlug) {
            return false;
        }

        $newPlan = $this->planManager->getActivePlanBySlug($newPlanSlug);

        if (!$newPlan) {
            return false;
        }

        $changeResult = $paymentProviderStrategy->changePlan($subscription, $newPlan, $isProrated);

        if ($changeResult) {
            Subscribed::dispatch($subscription);

            return true;
        }

        return false;
    }

    public function canAddDiscount(Subscription $subscription)
    {
        return ($subscription->status === SubscriptionStatus::ACTIVE->value ||
            $subscription->status === SubscriptionStatus::PAST_DUE->value)
            && $subscription->price > 0
            && $subscription->discounts()->count() === 0  // only one discount per subscription for now
            && $subscription->paymentProvider->slug !== PaymentProviderConstants::LEMON_SQUEEZY_SLUG; // LemonSqueezy does not support discounts for active subscriptions
    }

    public function cancelSubscription(
        Subscription $subscription,
        PaymentProviderInterface $paymentProviderStrategy,
        string $reason,
        ?string $additionalInfo = null

    ): bool {
        $result = $paymentProviderStrategy->cancelSubscription($subscription);

        if ($result) {
            $this->updateSubscription($subscription, [
                'is_canceled_at_end_of_cycle' => true,
                'cancellation_reason' => $reason,
                'cancellation_additional_info' => $additionalInfo,
            ]);
        }

        return $result;
    }

    public function discardSubscriptionCancellation(Subscription $subscription, PaymentProviderInterface $paymentProviderStrategy): bool
    {
        $result = $paymentProviderStrategy->discardSubscriptionCancellation($subscription);

        if ($result) {
            $this->updateSubscription($subscription, [
                'is_canceled_at_end_of_cycle' => false,
                'cancellation_reason' => null,
                'cancellation_additional_info' => null,
            ]);
        }

        return $result;
    }

    public function isUserSubscribed(?User $user, string $productSlug = null): bool
    {
        if (!$user) {
            return false;
        }

        $subscriptions = $user->subscriptions()
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->where('ends_at', '>', Carbon::now())
            ->get();

        if ($productSlug) {
            $subscriptions = $subscriptions->filter(function (Subscription $subscription) use ($productSlug) {
                return $subscription->plan->product->slug === $productSlug;
            });
        }

        return $subscriptions->count() > 0;
    }

    public function isUserTrialing(?User $user, string $productSlug = null): bool
    {
        if (!$user) {
            return false;
        }

        $subscriptions = $user->subscriptions()
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->where('trial_ends_at', '>', Carbon::now())
            ->get();

        if ($productSlug) {
            $subscriptions = $subscriptions->filter(function (Subscription $subscription) use ($productSlug) {
                return $subscription->plan->product->slug === $productSlug;
            });
        }

        return $subscriptions->count() > 0;
    }

    public function getUserSubscriptionProductMetadata(?User $user): array
    {
        if (!$user) {
            return [];
        }

        $subscription = $user->subscriptions()
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->where('ends_at', '>', Carbon::now())
            ->first();

        if (!$subscription) {
            // if there is no active subscription, return metadata of default product
            $defaultProduct = Product::where('is_default', true)->first();

            if (!$defaultProduct) {
                return [];
            }

            return $defaultProduct->metadata ?? [];
        }

        return $subscription->plan->product->metadata ?? [];
    }

    public function canEditSubscriptionPaymentDetails(Subscription $subscription)
    {
        return $subscription->status === SubscriptionStatus::ACTIVE->value || $subscription->status === SubscriptionStatus::PAST_DUE->value;

    }

    public function canCancelSubscription(Subscription $subscription)
    {
        return !$subscription->is_canceled_at_end_of_cycle && $subscription->status === SubscriptionStatus::ACTIVE->value;
    }

    public function canDiscardSubscriptionCancellation(Subscription $subscription)
    {
        return $subscription->is_canceled_at_end_of_cycle && $subscription->status === SubscriptionStatus::ACTIVE->value;
    }


}
