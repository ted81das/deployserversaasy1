<x-layouts.app>
    <div class="text-center pt-4 pb-0 md:pt-16 md:mb-10">
        <x-heading.h1 class="font-semibold">
            {{ __('From our blog') }}
        </x-heading.h1>
        <p class="pt-4">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
        </p>

        <div class="flex gap-3 justify-center pt-6">
            <x-link.social-icon name="facebook" title="{{ __('Facebook page') }}" link="#" class="hover:text-primary-500"/>
            <x-link.social-icon name="discord" title="{{ __('Discord community') }}" link="#" class="hover:text-primary-500"/>
            <x-link.social-icon name="x" title="{{ __('Twitter page') }}" link="#" class="hover:text-primary-500"/>
        </div>
    </div>

    <x-blog.post-cards :posts="$posts" />

    <div class="mx-auto text-center p-4 md:max-w-lg">
        {{ $posts->links() }}
    </div>

</x-layouts.app>
