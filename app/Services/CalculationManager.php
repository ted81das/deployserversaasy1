<?php

namespace App\Services;
use App\Constants\DiscountConstants;
use App\Dto\TotalsDto;
use App\Models\Currency;
use App\Models\Plan;
use App\Models\PlanPrice;
use App\Models\Subscription;
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

    public function calculatePlanTotals(User $user, string $planSlug, string $discountCode = null, string $actionType = DiscountConstants::ACTION_TYPE_ANY): TotalsDto
    {
        $plan = $this->planManager->getActivePlanBySlug($planSlug);

        if ($plan === null) {
            throw new \Exception('Plan not found');
        }

        if ($discountCode !== null && !$this->discountManager->isCodeRedeemable($discountCode, $user, $plan, $actionType)) {
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
}
