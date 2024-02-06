<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'price',
        'currency_id',
    ];

    protected static function booted(): void
    {
        static::updated(function (PlanPrice $planPrice) {
            // delete plan_price_payment_provider_data when plan price is updated to recreate provider prices when plan price is updated
             $planPrice->planPricePaymentProviderData()->delete();
        });

        static::deleted(function (PlanPrice $planPrice) {
            // delete plan_price_payment_provider_data when plan price is deleted to recreate provider prices when plan price is deleted
             $planPrice->planPricePaymentProviderData()->delete();
        });
    }


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function planPricePaymentProviderData()
    {
        return $this->hasMany(PlanPricePaymentProviderData::class);
    }
}
