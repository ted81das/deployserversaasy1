<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mpociot\Versionable\VersionableTrait;

class Transaction extends Model
{
    use HasFactory, VersionableTrait;
    protected string $versionClass = TransactionVersion::class;

    protected $fillable = [
        'uuid',
        'user_id',
        'plan_id',
        'amount',
        'total_tax',
        'total_discount',
        'total_fees',
        'currency_id',
        'status',
        'payment_provider_id',
        'payment_provider_status',
        'payment_provider_transaction_id',
        'subscription_id',
        'error_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function paymentProvider()
    {
        return $this->belongsTo(PaymentProvider::class);
    }

}
