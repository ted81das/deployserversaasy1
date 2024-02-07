<footer class="bg-primary-500 text-white mt-12">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="/" class="flex items-center">
                    <img src="{{asset('images/logo-light.svg')}}" class="h-6 me-3" alt="Logo" />
                </a>
            </div>
            <ul class="flex gap-6 text-primary-100 dark:text-gray-400 text-sm mt-2">
{{--                <li class="mb-4">--}}
{{--                    <a href="{{route('blog')}}" class="text-primary-100 hover:text-primary-50">{{ __('Blog') }}</a>--}}
{{--                </li>--}}
                <li class="mb-4">
                    <a href="{{route('privacy-policy')}}" class="text-primary-100 hover:text-primary-50">{{ __('Privacy Policy') }}</a>
                </li>
                <li>
                    <a href="{{route('terms-of-service')}}" class="text-primary-100 hover:hover:text-primary-50">{{ __('Terms of Service') }}</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-primary-300 sm:mx-auto lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-xs text-primary-100 sm:text-center dark:text-gray-400">© {{ date('Y') }} <a href="/" class="hover:underline text-primary-100">{{ config('app.name', 'Laravel') }}™</a>. {{ __('All rights reserved.') }}
          </span>
            <div class="flex gap-3 mt-4 sm:justify-center sm:mt-0">
{{--                <x-link.social-icon name="facebook" title="{{ __('Facebook page') }}" link="#" class="text-primary-100 border-primary-200 hover:text-primary-50"/>--}}
{{--                <x-link.social-icon name="discord" title="{{ __('Discord community') }}" link="#" class="text-primary-100 border-primary-200 hover:text-primary-50"/>--}}
{{--                <x-link.social-icon name="x" title="{{ __('Twitter page') }}" link="#" class="text-primary-100 border-primary-200 hover:text-primary-50"/>--}}
{{--                <x-link.social-icon name="github" title="{{ __('Github page') }}" link="#" class="text-primary-100 border-primary-200 hover:text-primary-50"/>--}}
{{--                <x-link.social-icon name="linkedin" title="{{ __('Linkedin page') }}" link="#" class="text-primary-100 border-primary-200 hover:text-primary-50"/>--}}
            </div>
        </div>
    </div>
</footer>
