<x-layouts.focus-center>

    <div class="text-center my-4">
        <x-heading.h6 class="text-primary-500">
            {{ __('Pay securely.') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('Complete your purchase') }}
        </x-heading.h2>
    </div>


    <x-section.columns class="max-w-none md:max-w-6xl flex-wrap-reverse">
        <x-section.column>
            <form action="" method="post" id="checkout-form">
                @csrf

                    <x-heading.h2 class="text-primary-900 !text-xl">
                        {{ __('Pay with') }}
                    </x-heading.h2>

                    <div class="rounded-2xl border border-natural-300 mt-4 overflow-hidden">

                        @php $first = true; @endphp
                        @foreach($paymentProviders as $paymentProvider)
                            <div class="border-b border-natural-300 p-4">
                                <div class="form-control">
                                    <label class="label cursor-pointer">
                                    <span class="label-text ps-4 flex flex-col gap-3">
                                        <span class="text-xl flex flex-row gap-3">
                                            <span>
                                                {{ $paymentProvider->getName() }}
                                            </span>
                                            <span class="-m-2">
                                                <img src="{{asset('images/payment-providers/' . $paymentProvider->getSlug() . '.png')}}" alt="{{ $paymentProvider->getName() }}" class="h-6 grayscale">
                                            </span>
                                        </span>
                                        @if ($paymentProvider->isRedirectProvider())
                                            <span class="">{{ __('You will be redirected to complete your payment.') }}</span>
                                        @endif
                                        @if ($paymentProvider->isOverlayProvider())
                                            <span class="">{{ __('You will be asked to enter your payment details in a secure overlay.') }}</span>
                                        @endif
                                    </span>
                                        <input type="radio"
                                               data-is-redirect-provider="{{$paymentProvider->isRedirectProvider()}}"
                                               data-is-overlay-provider="{{$paymentProvider->isOverlayProvider()}}"
                                               value="{{ $paymentProvider->getSlug() }}"
                                               name="payment-provider" class="radio checked:bg-primary-500"
                                                @if($first) checked @endif
                                        />
                                    </label>
                                </div>
                            </div>

                            @php $first = false; @endphp
                        @endforeach


                        @foreach($paymentProviders as $paymentProvider)
                            @includeIf('payment-providers.' . $paymentProvider->getSlug(), ['data' => $providerInitData[$paymentProvider->getSlug()] ?? []])
                        @endforeach

                    </div>

                    <p class="text-xs text-neutral-600 p-4">
                        {{ __('By continuing, you agree to our') }} <a target="_blank" href="{{route('terms-of-service')}}" class="text-primary-900 underline">{{ __('Terms of Service') }}</a> {{ __('and') }} <a target="_blank" href="{{route('privacy-policy')}}" class="text-primary-900 underline">{{ __('Privacy Policy') }}</a>.
                    </p>

                    <x-button-link.primary class="inline-block !w-full my-4" elementType="button" type="submit">
                        {{ __('Confirm & Pay') }}
                    </x-button-link.primary>
            </form>
        </x-section.column>


        <x-section.column>
            <x-heading.h2 class="text-primary-900 !text-xl">
                {{ __('Product Details') }}
            </x-heading.h2>

            <div class="rounded-2xl border border-natural-300 mt-4 overflow-hidden p-6">
                @php
                    $orderItem = $order->items()->first();
                    $product = $orderItem->oneTimeProduct()->first();
                @endphp

                <div class="flex flex-row gap-3">
                    <div class="rounded-2xl text-5xl bg-primary-50 p-2 text-center w-24 h-24 text-primary-500 justify-self-center self-center">
                        {{ substr($product->name, 0, 1) }}
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-xl font-semibold flex flex-row md:gap-2 flex-wrap">
                            <span class="py-1">
                                {{ $product->name }}
                            </span>
                        </span>

                        @if ($product->description)
                            <span class="text-xs">{{ $product->description }}</span>
                        @endif

                        <span class="text-xs">
                            {{ __('Quantity:') }} {{ $orderItem->quantity }}
                        </span>

                    </div>
                </div>

                <div class="text-primary-900 my-4">
                    {{ __('What you get:') }}
                </div>
                <div>
                    <ul class="flex flex-col items-start gap-3">
                        @if ($product->features)
                            @foreach($product->features as $feature)
                                <x-features.li-item>{{ $feature['feature'] }}</x-features.li-item>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <livewire:checkout.product-totals :totals="$totals" :order="$order" :product="$product" page="{{request()->fullUrl()}}"/>

            </div>

        </x-section.column>

    </x-section.columns>



    @push('head')
        <script>
            let successUrl = '{{ $successUrl }}';
            let orderUuid = '{{ $order->uuid }}';
            let userEmail = '{{ $user->email ?? '' }}';
        </script>
        @vite(['resources/js/checkout.js'])
    @endpush
</x-layouts.focus-center>
