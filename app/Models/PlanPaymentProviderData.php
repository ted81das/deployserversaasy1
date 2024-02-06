<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPaymentProviderData extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'payment_provider_id',
        'payment_provider_product_id',
    ];
}
