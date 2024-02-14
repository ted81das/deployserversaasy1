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
}
