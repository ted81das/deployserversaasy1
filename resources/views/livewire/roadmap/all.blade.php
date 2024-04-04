<div>
    <div class="max-w-none md:max-w-4xl mx-auto">

        <div class="text-end mx-4 my-6">
            <x-button-link.primary-outline href="{{route('roadmap.suggest')}}">{{ __('+ Suggest a feature') }}</x-button-link.primary-outline>
        </div>

        @foreach($items as $item)
            <x-roadmap.item :item="$item"></x-roadmap.item>
        @endforeach

    </div>

    <div class="mx-auto text-center p-4 md:max-w-lg">
        {{ $items->links() }}
    </div>
</div>
