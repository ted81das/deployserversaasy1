<?php

namespace App\Services\PaymentProviders;
use App\Models\Discount;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Transaction;

interface PaymentProviderInterface
{
    public function getSlug(): string;

    public function getName(): string;
    public function createSubscriptionRedirectLink(Plan $plan, Subscription $subscription, Discount $discount = null): string;
    public function init(Plan $plan, Subscription $subscription, Discount $discount = null): array;

    public function isRedirectProvider(): bool;

    public function isOverlayProvider(): bool;

    public function changePlan(Subscription $subscription, Plan $newPlan, bool $withProration = false): bool;
    public function cancelSubscription(Subscription $subscription): bool;
    public function discardSubscriptionCancellation(Subscription $subscription): bool;
    public function getChangePaymentMethodLink(Subscription $subscription): string;
    public function addDiscountToSubscription(Subscription $subscription, Discount $discount): bool;
}
