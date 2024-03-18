<?php

namespace App\Services;
use App\Constants\DiscountConstants;
use App\Dto\TotalsDto;
use App\Models\Currency;
use App\Models\OneTimeProduct;
use App\Models\OneTimeProductPrice;
use App\Models\Order;
use App\Models\Plan;
use App\Models\PlanPrice;
use App\Models\User;

class CalculationManager
{
    public function __construct(
        private PlanManager $planManager,
        private DiscountManager $discountManager,
    ) {

    }
    /**
     * Subscription price equals to the plan price
     */
    public function getPlanPrice(Plan $plan): PlanPrice
    {
        $defaultCurrencyConfig = config('app.default_currency');
        $defaultCurrency = Currency::where('code', $defaultCurrencyConfig)->firstOrFail();

        $planPrice = $plan->prices()->where('currency_id', $defaultCurrency->id)->firstOrFail();

        return $planPrice;
    }

    public function getOneTimeProductPrice(OneTimeProduct $oneTimeProduct): OneTimeProductPrice
    {
        $defaultCurrencyConfig = config('app.default_currency');
        $defaultCurrency = Currency::where('code', $defaultCurrencyConfig)->firstOrFail();

        return $oneTimeProduct->prices()->where('currency_id', $defaultCurrency->id)->firstOrFail();
    }

    public function calculatePlanTotals(User $user, string $planSlug, string $discountCode = null, string $actionType = DiscountConstants::ACTION_TYPE_ANY): TotalsDto
    {
        $plan = $this->planManager->getActivePlanBySlug($planSlug);

        if ($plan === null) {
            throw new \Exception('Plan not found');
        }

        if ($discountCode !== null && !$this->discountManager->isCodeRedeemableForPlan($discountCode, $user, $plan, $actionType)) {
            throw new \Exception('Discount code is not redeemable');
        }

        $planPrice = $this->getPlanPrice($plan);
        $currencyCode = $planPrice->currency->code;
        $totalsDto = new TotalsDto();

        $totalsDto->currencyCode = $currencyCode;

        $totalsDto->subtotal = $planPrice->price;

        $totalsDto->discountAmount = 0;
        if ($discountCode !== null) {
            $totalsDto->discountAmount = $this->discountManager->getDiscountAmount($discountCode, $totalsDto->subtotal);
        }

        $totalsDto->amountDue = max(0, $totalsDto->subtotal - $totalsDto->discountAmount);

        return $totalsDto;
    }

    public function calculateNewPlanTotals (User $user, string $planSlug, bool $withProration = false): TotalsDto
    {
        $plan = $this->planManager->getActivePlanBySlug($planSlug);

        if ($plan === null) {
            throw new \Exception('Plan not found');
        }

        $planPrice = $this->getPlanPrice($plan);
        $currencyCode = $planPrice->currency->code;
        $totalsDto = new TotalsDto();

        $totalsDto->currencyCode = $currencyCode;

        $totalsDto->subtotal = $planPrice->price;

        $totalsDto->discountAmount = 0;

        if (!$withProration) {
            $totalsDto->amountDue = max(0, $totalsDto->subtotal - $totalsDto->discountAmount);
        }

        return $totalsDto;
    }

    public function calculateOrderTotals (Order $order, User $user, string $discountCode = null): TotalsDto
    {
        $totalsDto = new TotalsDto();
        $totalsDto->currencyCode = config('app.default_currency');
        $currency = Currency::where('code', $totalsDto->currencyCode)->firstOrFail();

        $totalAmount = 0;
        $totalAmountAfterDiscount = 0;

        $orderItems = $order->items()->get();

        foreach ($orderItems as $orderItem) {

            $product = $orderItem->oneTimeProduct()->firstOrFail();
            $productPrice = $product->prices()->where('currency_id', $currency->id)->firstOrFail();

            $orderItem->price_per_unit = $productPrice->price;

            $totalAmount += $orderItem->price_per_unit * $orderItem->quantity;

            $itemDiscountedPrice = $orderItem->price_per_unit;
            if ($discountCode !== null && $this->discountManager->isCodeRedeemableForOneTimeProduct($discountCode, $user, $product)) {
                $discountAmount = $this->discountManager->getDiscountAmount($discountCode, $orderItem->price_per_unit);
                $itemDiscountedPrice = max(0, $orderItem->price_per_unit - $discountAmount);
            }

            $orderItem->price_per_unit_after_discount = $itemDiscountedPrice;
            $orderItem->discount_per_unit = max(0, $orderItem->price_per_unit - $itemDiscountedPrice);

            $totalAmountAfterDiscount += $itemDiscountedPrice * $orderItem->quantity;
            $orderItem->currency_id = $currency->id;

            $orderItem->save();
        }

        $order->total_amount = $totalAmount;
        $order->total_amount_after_discount = $totalAmountAfterDiscount;
        $order->total_discount_amount = max(0, $totalAmount - $totalAmountAfterDiscount);
        $order->currency_id = $currency->id;

        $order->save();

        $totalsDto->subtotal = $totalAmount;
        $totalsDto->amountDue = $totalAmountAfterDiscount;
        $totalsDto->discountAmount = max(0, $totalAmount - $totalAmountAfterDiscount);

        return $totalsDto;
    }
}
