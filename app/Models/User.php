<?php

namespace App\Models;

use App\Mail\User\VerifyEmail;
use App\Notifications\Auth\QueuedVerifyEmail;
use App\Services\SubscriptionManager;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'public_name',
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userParameters(): HasMany
    {
        return $this->hasMany(UserParameter::class);
    }

    public function stripeData(): HasMany
    {
        return $this->hasMany(UserStripeData::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() == 'admin' && !$this->is_admin) {
            return false;
        }

        return true;
    }

    public function getPublicName()
    {
        return $this->public_name ?? $this->name;
    }

    public function scopeAdmin($query)
    {
        return $query->where('is_admin', true);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isSubscribed(string $productSlug = null): bool
    {
        /** @var SubscriptionManager $subscriptionManager */
        $subscriptionManager = app(SubscriptionManager::class);

        return $subscriptionManager->isUserSubscribed($this, $productSlug);
    }

    public function isTrialing(string $productSlug = null): bool
    {
        /** @var SubscriptionManager $subscriptionManager */
        $subscriptionManager = app(SubscriptionManager::class);

        return $subscriptionManager->isUserTrialing($this, $productSlug);
    }

    public function productMetadata()
    {
        /** @var SubscriptionManager $subscriptionManager */
        $subscriptionManager = app(SubscriptionManager::class);

        return $subscriptionManager->getUserSubscriptionProductMetadata($this);

    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new QueuedVerifyEmail());
    }
}
