<?php

namespace App\Providers;

use App\Models\User;
use App\Services\PaymentProviders\LemonSqueezy\LemonSqueezyProvider;
use App\Services\PaymentProviders\Paddle\PaddleProvider;
use App\Services\PaymentProviders\PaymentManager;
use App\Services\PaymentProviders\Stripe\StripeProvider;
use App\Services\SubscriptionManager;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->tag([
            StripeProvider::class,
            PaddleProvider::class,
            LemonSqueezyProvider::class,
        ], 'payment-providers');

        $this->app->bind(PaymentManager::class, function () {
            return new PaymentManager(...$this->app->tagged('payment-providers'));
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Js::make('components-script', __DIR__.'/../../resources/js/components.js'),
        ]);

        Blade::if('subscribed', function (?string $productSlug = null) {
            /** @var User $user */
            $user = auth()->user();

            /** @var SubscriptionManager $subscriptionManager */
            $subscriptionManager = app(SubscriptionManager::class);

            return $subscriptionManager->isUserSubscribed($user, $productSlug);
        });

        Blade::if('notsubscribed', function (?string $productSlug = null) {
            /** @var User $user */
            $user = auth()->user();

            /** @var SubscriptionManager $subscriptionManager */
            $subscriptionManager = app(SubscriptionManager::class);

            return ! $subscriptionManager->isUserSubscribed($user, $productSlug);
        });

        Blade::if('trialing', function (?string $productSlug = null) {
            /** @var User $user */
            $user = auth()->user();

            /** @var SubscriptionManager $subscriptionManager */
            $subscriptionManager = app(SubscriptionManager::class);

            return $subscriptionManager->isUserTrialing($user, $productSlug);
        });

    }
}
