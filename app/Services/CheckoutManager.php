<?php

namespace App\Services;
use App\Dto\CartDto;
use App\Dto\CheckoutDto;


class CheckoutManager
{
    public function __construct(
        private SubscriptionManager $subscriptionManager,
        private OrderManager $orderManager,
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

    public function initProductCheckout(CartDto $cartDto)
    {
        $user = auth()->user();
        $order = $this->orderManager->findNewForUser($user->id);

        if ($order === null) {
            $order = $this->orderManager->create($user);
        }

        $totals = $this->orderManager->refreshOrder($cartDto, $order);

        return [$order, $totals];
    }
}
