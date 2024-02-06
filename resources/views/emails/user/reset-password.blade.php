<x-layouts.email>
    <h1 class="text-2xl font-bold">
        {{ __('Reset your password') }}
    </h1>
    <div class="mt-4 ">
        <p>
            {{ __('You are receiving this email because we received a password reset request for your account.') }}
        </p>

        <div class="text-center">
            <a href ="{{ $url }}" class="bg-primary-500 hover:text-white text-primary-50 p-2 px-6 rounded-lg my-6 inline-block">
                {{ __('Reset Password') }}
            </a>
        </div>

        <p>
            {{ __('This password reset link will expire in 60 minutes.') }}

            {{ __('If you did not request a password reset, no further action is required.') }}
        </p>

        <hr class="my-4">

        <p class="text-sm">
            {{ __('If you\'re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:') }}
            <a href="{{ $url }}" class="text-primary-500 hover:text-primary-600">
                {{ $url }}
            </a>
        </p>
    </div>
</x-layouts.email>
