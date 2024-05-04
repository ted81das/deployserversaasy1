<?php

namespace App\Http\Controllers;

use App\Constants\SessionConstants;
use App\Dto\SubscriptionCheckoutDto;
use App\Models\Plan;
use App\Services\CalculationManager;
use App\Services\CheckoutManager;
use App\Services\DiscountManager;
use App\Services\PaymentProviders\PaymentManager;
use App\Services\PaymentProviders\PaymentProviderInterface;
use App\Services\SubscriptionManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionCheckoutController extends Controller
{
    public function __construct(
        private CheckoutManager $checkoutManager,
        private PaymentManager $paymentManager,
        private DiscountManager $discountManager,
        private CalculationManager $calculationManager,
        private SubscriptionManager $subscriptionManager,
    ) {

    }

    public function subscriptionCheckout(string $planSlug, Request $request)
    {
        $plan = Plan::where('slug', $planSlug)->where('is_active', true)->firstOrFail();
        $checkoutDto = $this->getSubscriptionCheckoutDto();

        if ($checkoutDto->planSlug !== $planSlug) {
            $checkoutDto = $this->resetSubscriptionCheckoutDto();
        }

        $subscription = $this->checkoutManager->initSubscriptionCheckout($planSlug);

        $discount = null;
        if ($checkoutDto->discountCode !== null) {
            $discount = $this->discountManager->getActiveDiscountByCode($checkoutDto->discountCode);
        }

        $checkoutDto->subscriptionId = $subscription->id;
        $this->saveSubscriptionCheckoutDto($checkoutDto);

        if ($request->isMethod('post')) {

            $paymentProvider = $this->paymentManager->getPaymentProviderBySlug(
                $request->get('payment-provider')
            );

            $link = $paymentProvider->createSubscriptionCheckoutRedirectLink(
                $plan,
                $subscription,
                $discount,
            );

            return redirect()->away($link);
        }

        $paymentProviders = $this->paymentManager->getActivePaymentProviders();
        $totals = $this->calculationManager->calculatePlanTotals(
            auth()->user(),
            $planSlug,
            $checkoutDto?->discountCode,
        );

        $initializedPaymentProviders = [];
        $providerInitData = [];
        /** @var PaymentProviderInterface $paymentProvider */
        foreach ($paymentProviders as $paymentProvider) {
            try {
                $providerInitData[$paymentProvider->getSlug()] = $paymentProvider->initSubscriptionCheckout($plan, $subscription, $discount);
                $initializedPaymentProviders[] = $paymentProvider;
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [
                    'exception' => $e,
                ]);
            }
        }

        return view('checkout.subscription', [
            'paymentProviders' => $initializedPaymentProviders,
            'providerInitData' => $providerInitData,
            'subscription' => $subscription,
            'plan' => $plan,
            'totals' => $totals,
            'checkoutDto' => $checkoutDto,
            'successUrl' => route('checkout.subscription.success'),
            'user' => auth()->user(),
        ]);
    }

    public function subscriptionCheckoutSuccess()
    {
        $checkoutDto = $this->getSubscriptionCheckoutDto();

        if ($checkoutDto->subscriptionId === null) {
            return redirect()->route('home');
        }

        $this->subscriptionManager->setAsPending($checkoutDto->subscriptionId);

        if ($checkoutDto->discountCode !== null) {
            $this->discountManager->redeemCodeForSubscription($checkoutDto->discountCode, auth()->user(), $checkoutDto->subscriptionId);
        }

        $this->resetSubscriptionCheckoutDto();

        return view('checkout.subscription-thank-you', [
        ]);
    }

    private function saveSubscriptionCheckoutDto(SubscriptionCheckoutDto $subscriptionCheckoutDto): void
    {
        session()->put(SessionConstants::SUBSCRIPTION_CHECKOUT_DTO, $subscriptionCheckoutDto);
    }

    private function getSubscriptionCheckoutDto(): SubscriptionCheckoutDto
    {
        return session()->get(SessionConstants::SUBSCRIPTION_CHECKOUT_DTO) ?? new SubscriptionCheckoutDto();
    }

    private function resetSubscriptionCheckoutDto(): SubscriptionCheckoutDto
    {
        session()->forget(SessionConstants::SUBSCRIPTION_CHECKOUT_DTO);

        return new SubscriptionCheckoutDto();
    }
}
