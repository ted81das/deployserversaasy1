<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCodeRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_id',
        'subscription_id',
        'user_id',
        'order_id',
    ];

    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
