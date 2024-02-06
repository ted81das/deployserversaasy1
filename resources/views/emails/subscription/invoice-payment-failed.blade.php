<x-layouts.email>
    <h1 class="text-2xl font-bold">
        {{ __('Don\'t lose your subscription!') }}
    </h1>
    <div class="mt-3">
        <p class="pt-2">
            {{ __('Hi :name,', ['name' => $subscription->user->name]) }}
        </p>

        <p class="py-2">
            {{ __('We were unable to process your payment for your :plan subscription. Please update your payment details to avoid losing access to your account.', ['plan' => $subscription->plan->name]) }}
        </p>

        <div class="text-center">
            <a href ="{{ route('filament.dashboard.resources.subscriptions.index') }}" class="bg-primary-500 hover:text-white text-primary-50 p-2 px-6 rounded-lg my-6 inline-block">
                {{ __('Fix Problem') }}
            </a>
        </div>

        <p class="py-3">
            {{ __('If you have any questions, please contact us at ') }}
            <a href="mailto:{{ config('app.support_email') }}" class="text-primary-500 hover:text-primary-600">
                {{ config('app.support_email') }}
            </a>
        </p>

    </div>
</x-layouts.email>
