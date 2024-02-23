<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneTimeProductPaymentProviderData extends Model
{
    use HasFactory;

    protected $fillable = [
        'one_time_product_id',
        'payment_provider_id',
        'payment_provider_product_id',
    ];
}
