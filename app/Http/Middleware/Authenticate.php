<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        $route = $request->route()->getName();

        // If the user is trying to access the checkout page, we redirect them to the register page to create an account.
        if ($route === 'checkout.subscription') {
            return route('register');
        }

        return route('login');
    }
}
