<?php

namespace App\Services;

use App\Constants\DiscountConstants;
use App\Models\Discount;
use App\Models\DiscountCode;
use App\Models\DiscountPaymentProviderData;
use App\Models\PaymentProvider;
use App\Models\Plan;
use App\Models\SubscriptionDiscount;
use App\Models\User;
use Carbon\Carbon;

class DiscountManager
{
    public function isCodeRedeemable(string $code, User $user, Plan $plan, string $actionType = DiscountConstants::ACTION_TYPE_ANY)
    {
        $discountCode = DiscountCode::where('code', $code)->first();

        if ($discountCode === null) {
            return false;
        }

        $discount = $discountCode->discount;

        if (!$discount->is_active) {
            return false;
        }

        // valid_until
        if ($discount->valid_until !== null) {
            $carbon = Carbon::parse($discount->valid_until);

            if ($carbon->isPast()) {
                return false;
            }
        }

        if ($discount->action_type !== null && $discount->action_type !== $actionType) {
            return false;
        }

        if ($discount->max_redemptions != -1 && $discount->redemptions >= $discount->max_redemptions) {
            return false;
        }

        // redemptions for this user
        if ($discount->max_redemptions_per_user !== null && $discount->max_redemptions_per_user != -1) {
            $redemptions = $discountCode->redemptions()->where('user_id', $user->id)->count();

            if ($redemptions >= $discount->max_redemptions_per_user) {
                return false;
            }
        }

        // plans check
        if ($discount->plans()->count() > 0) {
            if (!$discount->plans()->where('plan_id', $plan->id)->exists()) {
                return false;
            }
        }

        return true;
    }

    public function redeemCode(string $code, User $user, string $subscriptionId = null): void
    {
        $discountCode = DiscountCode::where('code', $code)->firstOrFail();

        $discountCode->redemptions()->create([
            'user_id' => $user->id,
            'subscription_id' => $subscriptionId,
        ]);

        // increase redemption count using query
        Discount::where('id', $discountCode->discount_id)->increment('redemptions');

        if ($subscriptionId !== null) {

            $discount = $discountCode->discount;
            SubscriptionDiscount::create([
                'subscription_id' => $subscriptionId,
                'discount_id' => $discount->id,
                'type' => $discount->type,
                'amount' => $discount->amount,
                'valid_until' => $discount->valid_until,
                'is_recurring' => $discount->is_recurring,
            ]);
        }

    }

    public function getDiscountAmount(string $discountCode, int $subtotal): int
    {
        $discountCode = DiscountCode::where('code', $discountCode)->firstOrFail();

        $discount = $discountCode->discount;

        if ($discount->type === DiscountConstants::TYPE_FIXED) {
            return intval($discount->amount);
        }

        if ($discount->type === DiscountConstants::TYPE_PERCENTAGE) {
            return intval($subtotal * ($discount->amount / 100));
        }

        return 0;
    }

    public function getPaymentProviderDiscountId(Discount $discount, PaymentProvider $paymentProvider)
    {
        $result = DiscountPaymentProviderData::where('discount_id', $discount->id)
            ->where('payment_provider_id', $paymentProvider->id)
            ->first();

        if ($result) {
            return $result->payment_provider_discount_id;
        }

        return null;
    }

    public function addPaymentProviderDiscountId (Discount $discount, PaymentProvider $paymentProvider, string $paymentProviderDiscountId): void
    {
        DiscountPaymentProviderData::create([
            'discount_id' => $discount->id,
            'payment_provider_id' => $paymentProvider->id,
            'payment_provider_discount_id' => $paymentProviderDiscountId,
        ]);
    }

    public function getActiveDiscountByCode(string $code): ?Discount
    {
        $discountCode = DiscountCode::with('discount')
            ->where('code', $code)
            ->whereRelation('discount', 'is_active', true)
            ->first();

        return $discountCode?->discount;
    }
}
