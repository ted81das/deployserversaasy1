<x-layouts.app>
    <x-slot name="title">{{ $post->title }}</x-slot>

    <x-blog.post :post="$post" />

    <div class="text-center">
        <x-section.outro>
            <x-heading.h6 class="text-primary-50">
                {{ __('Stay up-to-date') }}
            </x-heading.h6>
            <x-heading.h2 class="text-primary-50">
                {{ __('Subscribe to our newsletter') }}
            </x-heading.h2>

            <x-input.field labelClass="text-primary-50" inputClass="bg-transparent placeholder-primary-100 text-primary-50" placeholder="{{ __('Your email address') }}" class="mx-auto mt-6" />

            <div class="mt-10">
                <x-button-link.secondary href="{{route('blog')}}">
                    {{ __('Subscribe') }}
                </x-button-link.secondary>
            </div>
        </x-section.outro>
    </div>

    <div class="text-center">
        <x-heading.h6 class="text-primary-500">
            {{ __('Don\'t miss this') }}
        </x-heading.h6>
        <x-heading.h2>
            {{ __('You might also like') }}
        </x-heading.h2>
    </div>

    <x-blog.post-cards :posts="$morePosts" link-to-more-posts="true"/>

</x-layouts.app>
