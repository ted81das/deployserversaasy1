<x-layouts.email>
    <h1 class="text-2xl font-bold">
        {{ __('Sorry to see you go! :(') }}
    </h1>
    <div class="mt-3">
        <p class="pt-2">
            {{ __('Hi :name,', ['name' => $subscription->user->name]) }}
        </p>

        <p class="py-2">
            {{ __('We are sad to see you go. Please let us know if there is anything we can do to improve our service.') }}
        </p>

        <p class="py-3">
            {{ __('Please drop us an email if you have any suggestions or feedback that you would like to share with us at') }}
            <a href="mailto:{{ config('app.support_email') }}" class="text-primary-500 hover:text-primary-600">
                {{ config('app.support_email') }}.
            </a>
        </p>

        <p class="py-3">
            {{ __('If you change your mind in the future, you can always subscribe again from your account dashboard.') }}
        </p>

        <p class="py-3">
            {{ __('Thank you for being a part of our community. We hope to see you again soon!') }}
        </p>

        <p class="py-3">
            {{ __('Sincerely,') }}<br>
            {{ config('app.name') }} {{ __('Team') }}
        </p>

    </div>
</x-layouts.email>
