<x-layouts.email>
    <h1 class="text-2xl font-bold">
        {{ __('Welcome to :app!', ['app' => config('app.name')]) }}
    </h1>
    <div class="mt-3">
        <p class="py-4">
            {{ __('Welcome aboard! We are thrilled to have you as a valued member of :app. Your subscription to our ":plan_name" plan has been successfully processed, and we\'re excited to help you unlock the full potential of our platform.', ['app' => config('app.name'), 'plan_name' => $subscription->plan->name]) }}
        </p>

        <p class="py-3">
            {{ __('Our support team is here to assist you with any questions or concerns. Feel free to reach out to us at ') }}
            <a href="mailto:{{ config('app.support_email') }}" class="text-primary-500 hover:text-primary-600">
                {{ config('app.support_email') }}
            </a>
        </p>

        <p class="py-3">
            {{ __('Your feedback is essential to us. If you have any suggestions, feature requests, or thoughts on how we can enhance your experience, please don\'t hesitate to let us know. We value your input.') }}
        </p>

        <p class="py-3">
            {{ __('Sincerely,') }}<br>
            {{ config('app.name') }} {{ __('Team') }}
        </p>

    </div>
</x-layouts.email>
