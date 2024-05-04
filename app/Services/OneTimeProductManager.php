<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\OneTimeProduct;
use App\Models\OneTimeProductPaymentProviderData;
use App\Models\OneTimeProductPrice;
use App\Models\OneTimeProductPricePaymentProviderData;
use App\Models\PaymentProvider;

class OneTimeProductManager
{
    public function getOneTimeProductById(?int $id): OneTimeProduct
    {
        return OneTimeProduct::findOrFail($id);
    }

    public function findByPaymentProviderProductId(PaymentProvider $paymentProvider, string $paymentProviderProductId): ?OneTimeProduct
    {
        $result = OneTimeProductPaymentProviderData::where('payment_provider_id', $paymentProvider->id)
            ->where('payment_provider_product_id', $paymentProviderProductId)
            ->first();

        if ($result) {
            return OneTimeProduct::find($result->one_time_product_id);
        }

        return null;
    }

    public function getProductWithPriceBySlug(string $slug): ?OneTimeProduct
    {
        $defaultCurrency = config('app.default_currency');

        $defaultCurrencyObject = Currency::where('code', $defaultCurrency)->first();

        if (! $defaultCurrencyObject) {
            return null;
        }

        return OneTimeProduct::where('slug', $slug)
            ->whereHas('prices', function ($query) use ($defaultCurrencyObject) {
                $query->where('currency_id', $defaultCurrencyObject->id);
            })
            ->with(['prices' => function ($query) use ($defaultCurrencyObject) {
                $query->where('currency_id', $defaultCurrencyObject->id);
            }])
            ->first();
    }

    public function getPaymentProviderProductId(OneTimeProduct $oneTimeProduct, PaymentProvider $paymentProvider): ?string
    {
        $result = OneTimeProductPaymentProviderData::where('one_time_product_id', $oneTimeProduct->id)
            ->where('payment_provider_id', $paymentProvider->id)
            ->first();

        if ($result) {
            return $result->payment_provider_product_id;
        }

        return null;
    }

    public function addPaymentProviderProductId(OneTimeProduct $oneTimeProduct, PaymentProvider $paymentProvider, string $paymentProviderProductId): void
    {
        OneTimeProductPaymentProviderData::create([
            'one_time_product_id' => $oneTimeProduct->id,
            'payment_provider_id' => $paymentProvider->id,
            'payment_provider_product_id' => $paymentProviderProductId,
        ]);
    }

    public function getPaymentProviderPriceId(OneTimeProductPrice $oneTimeProductPrice, PaymentProvider $paymentProvider): ?string
    {
        $result = OneTimeProductPricePaymentProviderData::where('one_time_product_price_id', $oneTimeProductPrice->id)
            ->where('payment_provider_id', $paymentProvider->id)
            ->first();

        if ($result) {
            return $result->payment_provider_price_id;
        }

        return null;
    }

    public function addPaymentProviderPriceId(OneTimeProductPrice $oneTimeProductPrice, PaymentProvider $paymentProvider, string $paymentProviderPriceId): void
    {
        OneTimeProductPricePaymentProviderData::create([
            'one_time_product_price_id' => $oneTimeProductPrice->id,
            'payment_provider_id' => $paymentProvider->id,
            'payment_provider_price_id' => $paymentProviderPriceId,
        ]);
    }
}
