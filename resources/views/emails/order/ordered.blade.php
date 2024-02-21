<x-layouts.email>
    <h1 class="text-2xl font-bold">
        {{ __('Thanks for your order at :app!', ['app' => config('app.name')]) }}
    </h1>
    <div class="mt-3">
        <p class="py-4">
            {{ __('Thank you for your purchase! Here are the details of your order:') }}
        </p>

        <h2 class="text-sm">
            {{ __('Order number:') }} <span class="font-semibold">{{$order->uuid}}</span>
        </h2>

        <hr class="my-4" />
        @foreach ($order->items as $item)
            <div class="flex flex-row gap-3 mt-4">
                <div class="rounded-2xl text-5xl bg-primary-50 p-2 text-center w-24 h-24 text-primary-500 justify-center items-center flex">
                    <span>
                        {{ substr($item->oneTimeProduct->name, 0, 1) }}
                    </span>
                </div>
                <div class="flex flex-col gap-1">
                        <span class="text-xl font-semibold flex flex-row md:gap-2 flex-wrap">
                            <span class="py-1">
                                {{ $item->oneTimeProduct->name }}
                            </span>
                        </span>

                    @if ($item->oneTimeProduct->description)
                        <span class="text-xs">{{ $item->oneTimeProduct->description }}</span>
                    @endif

                    <span class="text-xs">
                            {{ __('Quantity:') }} {{ $item->quantity }}
                    </span>

                </div>
            </div>
        @endforeach

        <hr class="mt-4"/>
        <div class="flex flex-row justify-between text-lg font-bold p-4">
            <div class="text-primary-900 ">
                {{ __('Total') }}
            </div>
            <div class="text-primary-900">
                @money($order->total_amount, $order->currency->code)
            </div>
        </div>
        <hr/>

        <p class="py-3 mt-4">
            {{ __('Our support team is here to assist you with any questions or concerns. Feel free to reach out to us at ') }}
            <a href="mailto:{{ config('app.support_email') }}" class="text-primary-500 hover:text-primary-600">
                {{ config('app.support_email') }}
            </a>
        </p>

        <p class="py-3">
            {{ __('Sincerely,') }}<br>
            {{ config('app.name') }} {{ __('Team') }}
        </p>

    </div>
</x-layouts.email>
