<nav class="relative bg-primary-500 text-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{asset('images/logo-light.png')}}" class="h-6" alt="Logo" />
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse gap-1">
            @auth
                <x-layouts.app.user-menu></x-layouts.app.user-menu>
            @else
                <x-link class="hidden md:block text-primary-50" href="{{route('login')}}">{{ __('Login') }}</x-link>
                <x-button-link.secondary elementType="a" href="#plans">{{ __('Get started') }}</x-button-link.secondary>
            @endauth

            <button data-collapse-toggle="navbar-cta" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-primary-50 rounded-lg md:hidden hover:bg-primary-50 hover:text-primary-500  focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-cta" aria-expanded="false">
                <span class="sr-only">{{ __('Open menu') }}</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>
        <x-nav>
            <x-nav.item route="#">{{ __('Features') }}</x-nav.item>
            <x-nav.item route="#">{{ __('How it works') }}</x-nav.item>
            <x-nav.item route="#plans">{{ __('Pricing') }}</x-nav.item>
            <x-nav.item route="#faq">{{ __('FAQ') }}</x-nav.item>
            <x-nav.item route="blog">{{ __('Blog') }}</x-nav.item>
            @guest
                <x-nav.item route="login" class="md:hidden">{{ __('Login') }}</x-nav.item>
            @endguest

        </x-nav>
    </div>
</nav>
