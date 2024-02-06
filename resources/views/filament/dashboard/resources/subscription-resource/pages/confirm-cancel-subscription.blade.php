<x-filament-panels::page>

    <x-filament::card>
        <p class="mb-3">
            {{ __('It seems you are insisting. We are very sorry for that. Please tell us why you are leaving.') }}
        </p>

        @livewire('cancel-subscription-form')

    </x-filament::card>

</x-filament-panels::page>
