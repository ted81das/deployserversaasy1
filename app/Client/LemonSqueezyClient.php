<?php

namespace App\Client;
use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class LemonSqueezyClient
{
    public function createCheckout(array $attributes, string $variantId): Response
    {
        $testMode = config('services.lemon-squeezy.is_test_mode');
        if ($testMode) {
            $attributes['test_mode'] = true;
        }

        return Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.lemon-squeezy.api_key'),
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ])->post($this->getApiUrl('/v1/checkouts'), [
            'data' => [
                'type' => 'checkouts',
                'attributes' => $attributes,
                'relationships' => [
                    'variant' => [
                        'data' => [
                            'type' => 'variants',
                            'id' => $variantId,
                        ],
                    ],
                    'store' => [
                        'data' => [
                            'type' => 'stores',
                            'id' => config('services.lemon-squeezy.store_id'),
                        ],
                    ],
                ],
            ],
        ]);


    }


//    public function updateSubscription(string $paddleSubscriptionId, string $priceId, bool $withProration, bool $isTrialing = false): Response
//    {
//        $proration = $isTrialing ? 'do_not_bill' : ($withProration ? 'prorated_immediately' : 'full_immediately');
//        $subscriptionObject = [
//            'proration_billing_mode' => $proration,
//            'items' => [
//                [
//                    'price_id' => $priceId,
//                    'quantity' => 1,
//                ],
//            ],
//        ];
//
//        return Http::withHeaders([
//            'Authorization' => 'Bearer ' . config('services.paddle.vendor_auth_code'),
//        ])->patch($this->getApiUrl('/subscriptions/' . $paddleSubscriptionId), $subscriptionObject);
//    }
//
//    public function addDiscountToSubscription(string $paddleSubscriptionId, string $paddleDiscountId, string $effectiveFrom = 'next_billing_period')
//    {
//        $subscriptionObject = [
//            'discount' => [
//                'id' => $paddleDiscountId,
//                'effective_from' => $effectiveFrom,
//            ],
//        ];
//
//        return Http::withHeaders([
//            'Authorization' => 'Bearer ' . config('services.paddle.vendor_auth_code'),
//        ])->patch($this->getApiUrl('/subscriptions/' . $paddleSubscriptionId), $subscriptionObject);
//
//    }
//
//    public function cancelSubscription(string $paddleSubscriptionId)
//    {
//        return Http::withHeaders([
//            'Authorization' => 'Bearer ' . config('services.paddle.vendor_auth_code'),
//        ])->post($this->getApiUrl('/subscriptions/' . $paddleSubscriptionId . '/cancel'), ['cancel_at_end' => true]);
//    }
//
//    public function discardSubscriptionCancellation(string $paddleSubscriptionId)
//    {
//        return Http::withHeaders([
//            'Authorization' => 'Bearer ' . config('services.paddle.vendor_auth_code'),
//        ])->patch($this->getApiUrl('/subscriptions/' . $paddleSubscriptionId), [
//            "scheduled_change" => null,
//        ]);
//    }
//
    public function createDiscount(
        string $name,
        string $couponCode,
        int $amount,
        string $amountType,
        int $maxRedemptions = null,
        string $duration = 'forever',
        string $durationInMonths = null,
        Carbon $expiresAt = null,
    ) {
        $attributes = [
            'name' => $name,
            'code' => $couponCode,
            'amount' => $amount,
            'amount_type' => $amountType,
            'duration' => $duration,
        ];

        if ($expiresAt !== null) {
            $attributes['expires_at'] = $expiresAt->toISOString();
        }

        if ($duration === 'repeating') {
            $attributes['duration_in_months'] = $durationInMonths;
        }

        if ($maxRedemptions !== null) {
            $attributes['is_limited_redemptions'] = true;
            $attributes['max_redemptions'] = $maxRedemptions;
        }

        $testMode = config('services.lemon-squeezy.is_test_mode');
        if ($testMode) {
            $attributes['test_mode'] = true;
        }

        return Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.lemon-squeezy.api_key'),
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ])->post($this->getApiUrl('/v1/discounts'), [
            'data' => [
                'type' => 'discounts',
                'attributes' => $attributes,
                'relationships' => [
                    'store' => [
                        'data' => [
                            'type' => 'stores',
                            'id' => config('services.lemon-squeezy.store_id'),
                        ],
                    ],
                ],
            ],
        ]);
    }
//
//    public function getPaymentMethodUpdateTransaction(
//        string $paddleSubscriptionId,
//    ) {
//        return Http::withHeaders([
//            'Authorization' => 'Bearer ' . config('services.paddle.vendor_auth_code'),
//        ])->get($this->getApiUrl('/subscriptions/' . $paddleSubscriptionId . '/update-payment-method-transaction'));
//    }

    private function getApiUrl(string $endpoint): string
    {
        return 'https://api.lemonsqueezy.com' . $endpoint;
    }
}
