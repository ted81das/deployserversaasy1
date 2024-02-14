<?php

namespace App\Services;
use App\Constants\TransactionStatus;
use App\Dto\CheckoutDto;
use App\Models\Plan;
use App\Models\Transaction;


class CheckoutManager
{
    public function __construct(
        private SubscriptionManager $subscriptionManager,
    ) {

    }

    public function initSubscriptionCheckout(string $planSlug)
    {
        $subscription = $this->subscriptionManager->findNewByPlanSlugAndUser($planSlug, auth()->id());
        if ($subscription === null) {
            $subscription = $this->subscriptionManager->create($planSlug, auth()->id());
        }

        return $subscription;
    }
}
