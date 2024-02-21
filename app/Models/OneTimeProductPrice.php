<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneTimeProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'one_time_product_id',
        'currency_id',
        'price',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    protected static function booted(): void
    {
        static::updating(function (OneTimeProductPrice $oneTimeProductPrice) {
            // delete one_time_product_payment_provider_data when one time product price is updated to recreate provider prices when one time product price is updated
            if ($oneTimeProductPrice->getOriginal('price') !== $oneTimeProductPrice->price) {
                $oneTimeProductPrice->pricePaymentProviderData()->delete();
            }
        });

        static::deleting(function (OneTimeProductPrice $oneTimeProductPrice) {
            // delete one_time_product_payment_provider_data when one time product price is deleted to recreate provider prices when one time product price is deleted
            $oneTimeProductPrice->pricePaymentProviderData()->delete();
        });
    }

    public function pricePaymentProviderData()
    {
        return $this->hasMany(OneTimeProductPricePaymentProviderData::class);
    }
}
