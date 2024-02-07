<x-layouts.app container="false">
    <x-section.hero class="w-full mb-8 md:mb-80">

        <div class="mx-auto text-center h-180">
            <x-pill class="text-primary-500 bg-primary-50">{{ __('Launch your Business') }}</x-pill>
            <x-heading.h1 class="mt-3 text-primary-50 font-bold">
                {{ __('Your ultimate AI') }}
                <br class="hidden sm:block">
                {{ __('image Creator.') }}
            </x-heading.h1>

            <p class="text-primary-50 m-3">{{ __('Build your own SaaS and start earning money.') }}</p>

            <div class="flex flex-wrap gap-4 justify-center flex-col md:flex-row mt-6">
                <x-effect.glow></x-effect.glow>

                <x-button-link.secondary href="{{route('register')}}" class="self-center !py-3" elementType="a">
                    {{ __('Get Started Now') }}
                </x-button-link.secondary>
                <x-button-link.primary-outline href="{{route('register')}}" class=" bg-transparent self-center !py-3 text-white border-white">
                    {{ __('Watch Video') }}
                </x-button-link.primary-outline>

            </div>

            <p class="text-primary-100 text-xs m-4">{{ __('* no credit card required.') }}</p>

            <img class="mx-auto drop-shadow-2xl mt-8" src="{{URL::asset('/images/ipad.png')}}" />

        </div>
    </x-section.hero>

    <x-section.columns class="max-w-none md:max-w-6xl" >
        <x-section.column>
            <div x-intersect="$el.classList.add('slide-in-top')">
                <x-heading.h6 class="text-primary-500">
                    {{ __('Stay up-to-date') }}
                </x-heading.h6>
                <x-heading.h2 class="text-primary-900">
                    {{ __('Transform The Way you work with AI.') }}
                </x-heading.h2>
            </div>

            <p class="mt-4">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </p>
        </x-section.column>

        <x-section.column>
            <x-image.fancy src="{{URL::asset('/images/ipad.png')}}" dir="right" ></x-image.fancy>
        </x-section.column>

    </x-section.columns>

    <x-section.columns class="max-w-none md:max-w-6xl mt-16 flex-wrap-reverse">
        <x-section.column >
            <x-image.fancy src="{{URL::asset('/images/ipad.png')}}" dir="left"></x-image.fancy>
        </x-section.column>

        <x-section.column>
            <div x-intersect="$el.classList.add('slide-in-top')">
                <x-heading.h6 class="text-primary-500">
                    {{ __('Stay up-to-date') }}
                </x-heading.h6>
                <x-heading.h2 class="text-primary-900">
                    {{ __('Transform The Way you work with AI.') }}
                </x-heading.h2>
            </div>

            <p class="mt-4">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </p>
        </x-section.column>

    </x-section.columns>

    <div class="text-center mt-16" x-intersect="$el.classList.add('slide-in-top')">
        <x-heading.h6 class="text-primary-500">
            {{ __('Stay up-to-date') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('Transform The Way you work with AI.') }}
        </x-heading.h2>
    </div>

    <x-section.columns class="max-w-none md:max-w-6xl mt-6">
        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="drop" class="w-2/5 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('Easy to use') }}
            </x-heading.h3>
            <p class="mt-2">Lorem Ipsum is simply dummy text of the printing.</p>
        </x-section.column>

        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="drop" class="w-2/5 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('Easy to use') }}
            </x-heading.h3>
            <p class="mt-2">Lorem Ipsum is simply dummy text of the printing.</p>
        </x-section.column>

        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="drop" class="w-2/5 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('Easy to use') }}
            </x-heading.h3>
            <p class="mt-2">Lorem Ipsum is simply dummy text of the printing.</p>
        </x-section.column>

    </x-section.columns>



    <div class="text-center mt-16">
        <x-heading.h6 class="text-primary-500">
            {{ __('Stay up-to-date') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('Transform The Way you work with AI.') }}
        </x-heading.h2>
    </div>

    <x-section.columns class="max-w-none md:max-w-6xl mt-6">
        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="one" type="secondary" class="w-1/4 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('Easy to use') }}
            </x-heading.h3>
            <p class="mt-2">Lorem Ipsum is simply dummy text of the printing.</p>
        </x-section.column>

        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="two" type="secondary" class="w-1/4 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('Easy to use') }}
            </x-heading.h3>
            <p class="mt-2">Lorem Ipsum is simply dummy text of the printing.</p>
        </x-section.column>

        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="three" type="secondary" class="w-1/4 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('Easy to use') }}
            </x-heading.h3>
            <p class="mt-2">Lorem Ipsum is simply dummy text of the printing.</p>
        </x-section.column>

    </x-section.columns>


    <div class="text-center mt-16">
        <x-heading.h6 class="text-primary-500">
            {{ __('Comprehensive') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('Full of features.') }}
        </x-heading.h2>
    </div>


    <x-tab-slider class="mt-6 md:max-w-6xl">
        <x-slot name="tabNames">
            <x-tab-slider.tab-name controls="tab-1" active="true">{{ __('Awesome Feature 1') }}</x-tab-slider.tab-name>
            <x-tab-slider.tab-name controls="tab-2">{{ __('Awesome Feature 2') }}</x-tab-slider.tab-name>
            <x-tab-slider.tab-name controls="tab-3">{{ __('Awesome Feature 3') }}</x-tab-slider.tab-name>
        </x-slot>

        <x-tab-slider.tab-content id="tab-1">
            <x-section.columns class="max-w-none md:max-w-6xl mt-6">
                <x-section.column>
                    <x-heading.h6 class="text-primary-500">
                        {{ __('Stay awesome') }}
                    </x-heading.h6>
                    <x-heading.h3 class="text-primary-900">
                        {{ __('This is the most awesome thing ever! ') }}
                    </x-heading.h3>

                    <p class="mt-4">
                        {{ __(' From its innovative design to its seamless functionality, every aspect exudes excellence. Its cutting-edge features not only meet but exceed expectations, offering users an unparalleled experience that sets a new standard for excellence.') }}
                    </p>
                </x-section.column>

                <x-section.column>
                    <img src="{{URL::asset('/images/ipad.png')}}" dir="right"></img>
                </x-section.column>
            </x-section.columns>
        </x-tab-slider.tab-content>

        <x-tab-slider.tab-content id="tab-2">
            <x-heading.h3 class="text-primary-900">
                {{ __('Tab 1') }}
            </x-heading.h3>
            <p class="mt-2">Lorem Ipsum is simply dummy text of the printing.</p>
        </x-tab-slider.tab-content>

        <x-tab-slider.tab-content id="tab-3">
            <x-heading.h3 class="text-primary-900">
                {{ __('Tab 3') }}
            </x-heading.h3>
            <p class="mt-2">Lorem Ipsum is simply dummy text of the printing.</p>
        </x-tab-slider.tab-content>
    </x-tab-slider>



    <div class="text-center mt-16 mx-4">
        <x-heading.h6 class="text-primary-500">
            {{ __('Testimonials') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('Customers love it.') }}
        </x-heading.h2>
    </div>

    <x-testimonial image="https://unsplash.com/photos/iEEBWgY_6lA/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA3MDU0Njg2fA&force=true&w=640">
        <x-slot name="name">{{ __('Michael Gough') }}</x-slot>
        <x-slot name="position">{{ __('Solo Maker') }}</x-slot>
        {{ __('"SaaSykit is just awesome. It comes with tons of predesigned components that save us time."') }}
    </x-testimonial>

    <x-section.columns class="md:max-w-6xl">
        <x-section.columns>
            <x-testimonial image="https://unsplash.com/photos/IF9TK5Uy-KI/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA3MDU4OTQ3fA&force=true&w=640">
                <x-slot name="name">{{ __('Barbara Doe') }}</x-slot>
                <x-slot name="position">{{ __('CEO at Fantasia') }}</x-slot>
                {{ __('"I\'m completely blown away by SaaSykit. This product saved me hours of work!"') }}
            </x-testimonial>
        </x-section.columns>

        <x-section.columns>
            <x-testimonial image="https://unsplash.com/photos/6qf1uljGpU4/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA3MDU5MTUwfA&force=true&w=640">
                <x-slot name="name">{{ __('Anna Smith') }}</x-slot>
                <x-slot name="position">{{ __('Solopreneur') }}</x-slot>
                {{ __('"This is the best starting point for building a SaaS. It saves me time and money."') }}
            </x-testimonial>
        </x-section.columns>

        <x-section.columns>
            <x-testimonial image="https://unsplash.com/photos/MTZTGvDsHFY/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA3MDU3ODk0fA&force=true&w=640">
                <x-slot name="name">{{ __('Erik Johnson') }}</x-slot>
                <x-slot name="position">{{ __('Maker') }}</x-slot>
                {{ __('"I used SaaSykit to start 3 SaaS products so far. I am a happy customer."') }}
            </x-testimonial>
        </x-section.columns>
    </x-section.columns>

    <div class="text-center mt-8">
        <x-heading.h6 class="text-primary-500">
            {{ __('Trusted by Leading Brands ') }}
        </x-heading.h6>
    </div>

    <x-icon-strip class="mt-12 grayscale">
        <x-icon-strip.item>
            @svg('booking', 'h-8')
        </x-icon-strip.item>
        <x-icon-strip.item>
            @svg('ibm', 'h-8')
        </x-icon-strip.item>
        <x-icon-strip.item>
            @svg('logi', 'h-8')
        </x-icon-strip.item>
        <x-icon-strip.item>
            @svg('netflix', 'h-8')
        </x-icon-strip.item>
        <x-icon-strip.item>
            @svg('spotify', 'h-8')
        </x-icon-strip.item>
        <x-icon-strip.item>
            @svg('t-mobile', 'h-8')
        </x-icon-strip.item>
        <x-icon-strip.item>
            @svg('fortinet', 'h-8')
        </x-icon-strip.item>
    </x-icon-strip>


    <div class="text-center mt-16 mx-4" id="faq">
        <x-heading.h6 class="text-primary-500">
            {{ __('FAQ') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('Got a Question?') }}
        </x-heading.h2>
        <p>Here is a list of the most common questions to help you with your decision. </p>
    </div>

    <div class="max-w-none md:max-w-6xl mx-auto">
        <x-accordion class="mt-4 p-8">
            <x-accordion.item active="true" name="faqs">
                <x-slot name="title">What is Flowbite?</x-slot>

                Flowbite is a free open source framework based on TailwindCSS that helps you build fast and beautiful responsive websites.

            </x-accordion.item>

            <x-accordion.item active="false" name="faqs">
                <x-slot name="title">What is Flowbite?</x-slot>

                Flowbite is a free open source framework based on TailwindCSS that helps you build fast and beautiful responsive websites.
            </x-accordion.item>

            <x-accordion.item active="false" name="faqs">
                <x-slot name="title">What is Flowbite?</x-slot>

                Flowbite is a free open source framework based on TailwindCSS that helps you build fast and beautiful responsive websites.
            </x-accordion.item>
        </x-accordion>
    </div>


    <div class="text-center mt-16" id="plans">
        <x-heading.h6 class="text-primary-500">
            {{ __('Pricing') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('Flexible Plans') }}
        </x-heading.h2>
    </div>

    <x-plans.all calculate-saving-rates="true" preselected-interval="year"></x-plans.all>

</x-layouts.app>
