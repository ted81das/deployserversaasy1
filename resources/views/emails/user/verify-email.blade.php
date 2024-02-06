<x-layouts.email>
    <h1 class="text-2xl font-bold">
        {{ __('Verify your email address') }}
    </h1>
    <div class="mt-4 ">
        <p>
            {{ __('Thanks for signing up for :app_name! Before getting started, could you verify your email address by clicking on the link below?', ['app_name' => config('app.name')]) }}
        </p>

        <div class="text-center">
            <a href ="{{ $url }}" class="bg-primary-500 hover:text-white text-primary-50 p-2 px-6 rounded-lg my-6 inline-block">
                {{ __('Verify Email Address') }}
            </a>
        </div>

        <hr class="my-4">

        <p class="text-sm">
            {{ __('If you\'re having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:') }}
            <a href="{{ $url }}" class="text-primary-500 hover:text-primary-600">
                {{ $url }}
            </a>
        </p>
    </div>
</x-layouts.email>
