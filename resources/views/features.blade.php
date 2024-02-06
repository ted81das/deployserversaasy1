<x-layouts.app container="false">
    <x-section.hero class="w-full mb-8 md:mb-72">

        <div class="mx-auto text-center h-180">
            <x-pill class="text-primary-500 bg-primary-50">{{ __('Launch your Business') }}</x-pill>
            <x-heading.h1 class="mt-3 text-primary-50 font-bold">
                {{ __('Build your SaaS') }}
                <br class="hidden sm:block">
                {{ __('with SaaSykit') }}

            </x-heading.h1>

            <p class="text-primary-50 m-3">{{ __('A Laravel boilerplate with everything you need to build an awesome SaaS.') }}</p>

            <div class="flex flex-wrap gap-4 justify-center flex-col md:flex-row mt-6">
                <x-effect.glow></x-effect.glow>

                <x-button-link.secondary href="{{route('register')}}" class="self-center !py-3" elementType="a">
                    {{ __('Buy SaaSykit') }}
                </x-button-link.secondary>
                <x-button-link.primary-outline href="{{route('register')}}" class=" bg-transparent self-center !py-3 text-white border-white">
                    {{ __('See Demo') }}
                </x-button-link.primary-outline>

            </div>

            <img class="mx-auto drop-shadow-2xl mt-8 md:max-w-3xl lg:max-w-5xl transition hover:scale-101  rounded-2xl" src="{{URL::asset('/images/features/hero-image.png')}}" />

        </div>
    </x-section.hero>

    <x-section.columns class="max-w-none md:max-w-6xl" >
        <x-section.column>
            <div x-intersect="$el.classList.add('slide-in-top')">
                <x-heading.h6 class="text-primary-500">
                    {{ __('a solid SaaS') }}
                </x-heading.h6>
                <x-heading.h2 class="text-primary-900">
                    {{ __('Subscriptions made easy.') }}
                </x-heading.h2>
            </div>

            <p class="mt-4">
                {{ __('Easily offer your customers subscription-based services with SaaSykit. All the webhook handling, subscription management, and billing are already set up for you in a beautiful and easy-to-use admin panel.') }}
            </p>
            <p class="mt-4">
                {{ __('Collect payments with Stripe and Paddle, and manage your customers with ease.') }}
            </p>
            <p class="pt-4">
                {{ __('Powered by:') }}
            </p>
            <div class="flex gap-3 pt-1">
                <a href="https://stripe.com/" target="_blank">
                    <img src="{{URL::asset('/images/payment-providers/stripe.png')}}" class="h-12 py-2 px-2 border border-primary-50 rounded-lg" />
                </a>
                <a href="https://www.paddle.com/" target="_blank">
                    <img src="{{URL::asset('/images/payment-providers/paddle.png')}}" class="h-12 py-2 px-2 border border-primary-50 rounded-lg" />
                </a>
            </div>
        </x-section.column>

        <x-section.column>
            <img src="{{URL::asset('/images/features/payments.png')}}" dir="right" ></img>
        </x-section.column>

    </x-section.columns>

    <x-section.columns class="max-w-none md:max-w-6xl mt-16 flex-wrap-reverse">
        <x-section.column >
            <img src="{{URL::asset('/images/features/colors.png')}}" />
        </x-section.column>

        <x-section.column>
            <div x-intersect="$el.classList.add('slide-in-top')">
                <x-heading.h6 class="text-primary-500">
                    {{ __('Your Brand, Your Colors') }}
                </x-heading.h6>
                <x-heading.h2 class="text-primary-900">
                    {{ __('Customize Everything.') }}
                </x-heading.h2>
            </div>

            <p class="mt-4">
                {{ __('Customize the primary & secondary colors of your website, error pages, email templates, fonts, social sharing cards, favicons, and more.') }}
            </p>

            <p class="mt-4">
                {{ __('Based on the popular TailwindCSS, you can easily customize the look and feel of your SaaS application.') }}
            </p>
        </x-section.column>

    </x-section.columns>

    <x-section.columns class="max-w-none md:max-w-6xl" >
        <x-section.column>
            <div x-intersect="$el.classList.add('slide-in-top')">
                <x-heading.h6 class="text-primary-500">
                    {{ __('At your fingertips') }}
                </x-heading.h6>
                <x-heading.h2 class="text-primary-900">
                    {{ __('Product, Plans & Pricing.') }}
                </x-heading.h2>
            </div>

            <p class="mt-4">
                {{ __('Create and manage your products, plans, and pricing, set features for each plan, mark a plan as featured, and more.') }}
            </p>

            <p class="mt-4">
                {{ __('Rewards your customers with discounts and manage all that from a beautiful admin panel.') }}
            </p>
        </x-section.column>

        <x-section.column>
            <img src="{{URL::asset('/images/features/plans.png')}}" class="rounded-2xl"/>
        </x-section.column>

    </x-section.columns>

    <x-section.columns class="max-w-none md:max-w-6xl mt-16 flex-wrap-reverse">
        <x-section.column >
            <img src="{{URL::asset('/images/features/checkout.png')}}" class="rounded-2xl" />
        </x-section.column>

        <x-section.column>
            <div x-intersect="$el.classList.add('slide-in-top')">
                <x-heading.h6 class="text-primary-500">
                    {{ __('Buttery smooth') }}
                </x-heading.h6>
                <x-heading.h2 class="text-primary-900">
                    {{ __('Beautiful checkout process.') }}
                </x-heading.h2>
            </div>

            <p class="mt-4">
                {{ __('In a few clicks, your customers can subscribe to your service using a beautiful checkout page that shows all the details of the plan they are subscribing to, allowing them to add a coupon code if they have one, and choose their payment method.') }}
            </p>
        </x-section.column>

    </x-section.columns>

{{--    ////////////--}}
{{--    Slider      --}}
{{--    ////////////--}}

    <div class="text-center mt-16">
        <x-heading.h6 class="text-primary-500">
            {{ __('All Inclusive') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('Huge list of ready-to-use components.') }}
        </x-heading.h2>
    </div>


    <div class="mx-4">
    <x-tab-slider class="mt-6 md:max-w-6xl border-2 border-neutral-100 py-8 rounded-2xl">
        <x-slot name="tabNames">
            <x-tab-slider.tab-name controls="tab-1" active="true">{{ __('Testimonials') }}</x-tab-slider.tab-name>
            <x-tab-slider.tab-name controls="tab-2">{{ __('Plans & Pricing') }}</x-tab-slider.tab-name>
            <x-tab-slider.tab-name controls="tab-3">{{ __('Hero section') }}</x-tab-slider.tab-name>
            <x-tab-slider.tab-name controls="tab-4">{{ __('FAQ') }}</x-tab-slider.tab-name>
            <x-tab-slider.tab-name controls="tab-5">{{ __('Call to action') }}</x-tab-slider.tab-name>
            <x-tab-slider.tab-name controls="tab-6">{{ __('Tab slider') }}</x-tab-slider.tab-name>
            <x-tab-slider.tab-name controls="tab-7">{{ __('and more') }}</x-tab-slider.tab-name>
        </x-slot>

        <x-tab-slider.tab-content id="tab-1">
            <div class="text-center mt-8">
                <x-heading.h4 class="text-primary-900 !font-semibold">
                    {{ __('Testimonials') }}
                </x-heading.h4>

                <div class="mx-auto max-w-2xl">
                    <p class="mt-4">
                        {{ __('Display testimonials from your customers on your website and build trust with your potential customers.') }}
                    </p>
                </div>
            </div>

            <div class="m-10 mx-auto max-w-4xl mt-12">
                <img src="{{URL::asset('/images/features/testimonials.png')}}" class="drop-shadow-xl rounded-2xl" />
            </div>

        </x-tab-slider.tab-content>

        <x-tab-slider.tab-content id="tab-2">
            <div class="text-center mt-8">
                <x-heading.h4 class="text-primary-900 !font-semibold">
                    {{ __('Plans & Pricing Component') }}
                </x-heading.h4>

                <div class="mx-auto max-w-2xl">
                    <p class="mt-4">
                        {{ __('This component is magical in that it will read the plans you defined in your admin panel, group them, calculate potential discount amount if user chooses a longer plan, and display all that in a beautiful way for your users. ') }}
                    </p>
                </div>
            </div>

            <div class="m-10 mx-auto max-w-4xl mt-12">
                <img src="{{URL::asset('/images/features/plans-component.png')}}" class="drop-shadow-xl rounded-2xl" />
            </div>

        </x-tab-slider.tab-content>

        <x-tab-slider.tab-content id="tab-3">
            <div class="text-center mt-8">
                <x-heading.h4 class="text-primary-900 !font-semibold">
                    {{ __('Hero section Component') }}
                </x-heading.h4>

                <div class="mx-auto max-w-2xl">
                    <p class="mt-4">
                        {{ __('A ready-to-use hero section component to display your hero image, title, and call to action button.') }}
                    </p>
                </div>
            </div>

            <div class="m-10 mx-auto max-w-4xl mt-12">
                <img src="{{URL::asset('/images/features/hero-component.png')}}" class="drop-shadow-xl rounded-2xl" />
            </div>

        </x-tab-slider.tab-content>

        <x-tab-slider.tab-content id="tab-4">
            <div class="text-center mt-8">
                <x-heading.h4 class="text-primary-900 !font-semibold">
                    {{ __('FAQ Component') }}
                </x-heading.h4>

                <div class="mx-auto max-w-2xl">
                    <p class="mt-4">
                        {{ __('An accordion component that you can use to display your FAQ in an intuitive way.') }}
                    </p>
                </div>
            </div>

            <div class="m-10 mx-auto max-w-4xl mt-12">
                <img src="{{URL::asset('/images/features/faqs-component.png')}}" class="drop-shadow-xl rounded-2xl" />
            </div>

        </x-tab-slider.tab-content>

        <x-tab-slider.tab-content id="tab-5">
            <div class="text-center mt-8">
                <x-heading.h4 class="text-primary-900 !font-semibold">
                    {{ __('Call to action component') }}
                </x-heading.h4>

                <div class="mx-auto max-w-2xl">
                    <p class="mt-4">
                        {{ __('A focused component the brings attention to your call to action.') }}
                    </p>
                </div>
            </div>

            <div class="m-10 mx-auto max-w-4xl mt-12">
                <img src="{{URL::asset('/images/features/call-to-action-component.png')}}" class="drop-shadow-xl rounded-2xl">
            </div>

        </x-tab-slider.tab-content>

        <x-tab-slider.tab-content id="tab-6">
            <div class="text-center mt-8">
                <x-heading.h4 class="text-primary-900 !font-semibold">
                    {{ __('Tab Slider Component') }}
                </x-heading.h4>

                <div class="mx-auto max-w-2xl">
                    <p class="mt-4">
                        {{ __('Tab slider component displays your content in a beautiful and organized way into separate tabs.') }}
                    </p>
                </div>
            </div>

            <div class="m-10 mx-auto max-w-4xl mt-12">
                <img src="{{URL::asset('/images/features/tab-slider-component.png')}}" class="drop-shadow-xl rounded-2xl">
            </div>

        </x-tab-slider.tab-content>

        <x-tab-slider.tab-content id="tab-7">

            <div class="m-10 mx-auto max-w-4xl mt-6">
                <x-section.columns class="max-w-none md:max-w-6xl mt-6">
                    <x-section.column class="flex flex-col items-center justify-center text-center">
                        <x-icon.fancy name="nav" class="w-2/5 mx-auto" type="secondary" />
                        <x-heading.h3 class="mx-auto pt-2">
                            {{ __('Header & Footer') }}
                        </x-heading.h3>
                        <p class="mt-2">{{ __('Easily customize your header and footer.') }}</p>
                    </x-section.column>

                    <x-section.column class="flex flex-col items-center justify-center text-center">
                        <x-icon.fancy name="button-ok" class="w-2/5 mx-auto" type="secondary" />
                        <x-heading.h3 class="mx-auto pt-2">
                            {{ __('Buttons') }}
                        </x-heading.h3>
                        <p class="mt-2">{{ __('Beautiful buttons to use in your application.') }}</p>
                    </x-section.column>

                    <x-section.column class="flex flex-col items-center justify-center text-center">
                        <x-icon.fancy name="pill" class="w-2/5 mx-auto" type="secondary" />
                        <x-heading.h3 class="mx-auto pt-2">
                            {{ __('Pill') }}
                        </x-heading.h3>
                        <p class="mt-2">{{ __('Pills to highlight your content where you need to.') }}</p>
                    </x-section.column>

                </x-section.columns>

                <p class="text-center mt-4">
                    {{ __('and much more...') }}
                </p>
            </div>

        </x-tab-slider.tab-content>



    </x-tab-slider>
    </div>



    <x-section.columns class="max-w-none md:max-w-6xl mt-12" >
        <x-section.column>
            <div x-intersect="$el.classList.add('slide-in-top')">
                <x-heading.h6 class="text-primary-500">
                    {{ __('Know your numbers') }}
                </x-heading.h6>
                <x-heading.h2 class="text-primary-900">
                    {{ __('SaaS Stats.') }}
                </x-heading.h2>
            </div>

            <p class="mt-4">
                {{ __('View your MRR (monthly recurring revenue), Churn rates, ARPU (average revenue per user), and other SaaS metrics right inside your admin panel.') }}
            </p>
        </x-section.column>

        <x-section.column>
            <img src="{{URL::asset('/images/features/stats.png')}}" >
        </x-section.column>

    </x-section.columns>

    <x-section.columns class="max-w-none md:max-w-6xl mt-16 flex-wrap-reverse">
        <x-section.column >
            <img src="{{URL::asset('/images/features/email.png')}}"  />
        </x-section.column>

        <x-section.column>
            <div x-intersect="$el.classList.add('slide-in-top')">
                <x-heading.h6 class="text-primary-500">
                    {{ __('Connect with customers') }}
                </x-heading.h6>
                <x-heading.h2 class="text-primary-900">
                    {{ __('Send & Customize Emails.') }}
                </x-heading.h2>
            </div>

            <p class="mt-4">
                {{ __('Choose your preferred email service from options like Mailgun, Postmark, and Amazon SES to communicate with your customers.') }}
            </p>
            <p class="mt-4">
                {{ __('SaaSykit comes with a beautiful email template out of the box that takes your brand colors into consideration, along with the typical emails for customer registration, verification, resetting password, etc set up for you.') }}
            </p>

            <p class="pt-4">
                {{ __('Supported email providers:') }}
            </p>
            <div class="flex gap-3 pt-1">
                <a href="https://postmarkapp.com/" target="_blank">
                    @svg('colored/postmark', 'h-12 w-12 py-2 px-2 border border-primary-50 rounded-lg')
                </a>

                <a href="https://www.mailgun.com/" target="_blank">
                    @svg('colored/mailgun', 'h-12 w-12 py-2 px-2 border border-primary-50 rounded-lg')
                </a>

                <a href="https://aws.amazon.com/ses/" target="_blank">
                    @svg('colored/ses', 'h-12 w-12 py-2 px-2 border border-primary-50 rounded-lg')
                </a>
            </div>
        </x-section.column>

    </x-section.columns>

    <x-section.columns class="max-w-none md:max-w-6xl" >
        <x-section.column>
            <div x-intersect="$el.classList.add('slide-in-top')">
                <x-heading.h6 class="text-primary-500">
                    {{ __('Content is king') }}
                </x-heading.h6>
                <x-heading.h2 class="text-primary-900">
                    {{ __('A ready Blog.') }}
                </x-heading.h2>
            </div>

            <p class="mt-4">
                {{ __('When it comes to reaching customer, nothing beats SEO.') }}
            </p>
            <p class="mt-4">
                {{ __('SaaSykit comes with a ready blog system that you can use to publish articles and tutorials for your customers about your SaaS, which will help you with your SEO.') }}
            </p>
        </x-section.column>

        <x-section.column>
            <img src="{{URL::asset('/images/features/blog.png')}}" />
        </x-section.column>

    </x-section.columns>

    <x-section.columns class="max-w-none md:max-w-6xl mt-16 flex-wrap-reverse">
        <x-section.column >
            <img src="{{URL::asset('/images/features/login.png')}}" />
        </x-section.column>

        <x-section.column>
            <div x-intersect="$el.classList.add('slide-in-top')">
                <x-heading.h6 class="text-primary-500">
                    {{ __('Modern Authentication') }}
                </x-heading.h6>
                <x-heading.h2 class="text-primary-900">
                    {{ __('Login, Registration & Social login.') }}
                </x-heading.h2>
            </div>

            <p class="mt-4">
                {{ __('SaaSykit includes built-in user authentication, supporting both traditional email/password authentication and social login options such as Google, Facebook, Twitter, Github, LinkedIn, and more.') }}
            </p>

            <p class="pt-4">
                {{ __('Supported login providers:') }}
            </p>
            <div class="flex gap-3 pt-1 flex-wrap">
                @svg('colored/google', 'h-12 w-12 py-2 px-2 border border-primary-50 rounded-lg')
                @svg('colored/facebook', 'h-12 w-12 py-2 px-2 border border-primary-50 rounded-lg')
                @svg('colored/twitter-oauth-2', 'h-12 w-12 py-2 px-2 border border-primary-50 rounded-lg')
                @svg('colored/linkedin', 'h-12 w-12 py-2 px-2 border border-primary-50 rounded-lg')
                @svg('colored/github', 'h-12 w-12 py-2 px-2 border border-primary-50 rounded-lg')
                @svg('colored/gitlab', 'h-12 w-12 py-2 px-2 border border-primary-50 rounded-lg')
                @svg('colored/bitbucket', 'h-12 w-12 py-2 px-2 border border-primary-50 rounded-lg')
            </div>
        </x-section.column>

    </x-section.columns>


    <div class="text-center mt-16" x-intersect="$el.classList.add('slide-in-top')">
        <x-heading.h6 class="text-primary-500">
            {{ __('Can\'t get more beautiful') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('A stunning Admin Panel.') }}
        </x-heading.h2>
    </div>

    <p class="text-center py-4">{{ __('Manage your SaaS application from a beautiful admin panel powered by Filament') }}</p>

    <div class="text-center pt-6 mx-auto max-w-5xl ">
        <img src="{{URL::asset('/images/features/admin-panel.png')}}" >
    </div>


    <div class="text-center mt-16" x-intersect="$el.classList.add('slide-in-top')">
        <x-heading.h6 class="text-primary-500">
            {{ __('Oh, we\'re not done yet') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('And a whole lot more') }}
        </x-heading.h2>
    </div>

    <x-section.columns class="max-w-none md:max-w-6xl mt-6">
        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="users" class="w-2/5 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('Users & Roles') }}
            </x-heading.h3>
            <p class="mt-2">{{ __('Manage your users, create roles and assign permissions to your users.') }}</p>
        </x-section.column>

        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="translatable" class="w-2/5 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('Fully translatable') }}
            </x-heading.h3>
            <p class="mt-2">{{ __('Translate your application to any language you want.') }}</p>
        </x-section.column>

        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="seo" class="w-2/5 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('Sitemap & SEO') }}
            </x-heading.h3>
            <p class="mt-2">{{ __('Auto-generated sitemap and SEO optimization out of the box.') }}</p>
        </x-section.column>

    </x-section.columns>

    <x-section.columns class="max-w-none md:max-w-6xl mt-6">
        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="user-dashboard" class="w-2/5 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('User Dashboard') }}
            </x-heading.h3>
            <p class="mt-2">{{ __('Users can manage their subscriptions, change payment method, upgrade plan, cancel subscription alone.') }}</p>
        </x-section.column>

        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="tool" class="w-2/5 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('Highly customizable') }}
            </x-heading.h3>
            <p class="mt-2">{{ __('Manage your SaaS settings from within the admin panel. No need to redeploy app for simple changes anymore.') }}</p>
        </x-section.column>

        <x-section.column class="flex flex-col items-center justify-center text-center">
            <x-icon.fancy name="development" class="w-2/5 mx-auto" />
            <x-heading.h3 class="mx-auto pt-2">
                {{ __('Developer-friendly') }}
            </x-heading.h3>
            <p class="mt-2">{{ __('Built with developers in mind, uses best coding practices. Offers handlers & events and automated tests covering critical components of the application.') }}</p>
        </x-section.column>

    </x-section.columns>


    <div class="text-center mt-16 mx-4">
        <x-heading.h6 class="text-primary-500">
            {{ __('Start to end') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('1-command deployment & Server provisioning') }}
        </x-heading.h2>
    </div>

    <p class="text-center py-4">{{ __('Deploy your SaaS application to your server with a single command, powered by') }} <a href="https://deployer.org/" target="_blank" class="text-primary-500 hover:underline">{{ __('PHP Deployer') }}</a>. </p>

    <div class="max-w-fit mx-auto mt-6">
        <span class="border border-neutral-300 bg-neutral-100 p-6 rounded-2xl mt-4">
            $ ./vendor/bin/dep deploy
        </span>
        <span class="text-4xl ms-3 -mt-2"> 🚀</span>
    </div>

    <div class="text-center mt-32 mx-4" id="faq">
        <x-heading.h6 class="text-primary-500">
            {{ __('FAQ') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-900">
            {{ __('Got a Question?') }}
        </x-heading.h2>
        <p>{{ __('Here are the most common questions to help you with your decision.') }}</p>
    </div>

    <div class="max-w-none md:max-w-6xl mx-auto">
        <x-accordion class="mt-4 p-8">
            <x-accordion.item active="true" name="faqs">
                <x-slot name="title">{{ __('What is SaaSykit?') }}</x-slot>

                <p>
                {{ __('SaaSykit is a complete SaaS starter kit that includes everything you need to start your SaaS business. It comes ready with a huge list of reusable components, a complete admin panel, user dashboard, user authentication, user & role management, plans & pricing, subscriptions, payments, emails, and more.') }}
                </p>

            </x-accordion.item>

            <x-accordion.item active="false" name="faqs">
                <x-slot name="title">{{ __('What features does SaaSykit offer?') }}</x-slot>

                <p class="mt-4">
                    {{ __('Here are some of the features included in SaaSykit in a nutshell:') }}
                </p>

                <ul class="mt-4 list-disc ms-4 ps-4">
                    <li>{{ __('Customize Styles: Customize the styles &amp; colors, error page of your application to fit your brand.') }}</li>
                    <li>{{ __('Product, Plans &amp; Pricing: Create and manage your products, plans, and pricing from a beautiful and easy-to-use admin panel.') }}</li>
                    <li>{{ __('Beautiful checkout process: Your customers can subscribe to your plans from a beautiful checkout process.') }}</li>
                    <li>{{ __('Huge list of ready-to-use components: Plans &amp; Pricing, hero section, features section, testimonials, FAQ, Call to action, tab slider, and much more.') }}</li>
                    <li>{{ __('User authentication: Comes with user authentication out of the box, whether classic email/password or social login (Google, Facebook, Twitter, Github, LinkedIn, and more).') }}</li>
                    <li>{{ __('Discounts: Create and manage your discounts and reward your customers.') }}</li>
                    <li>{{ __('SaaS metric stats: View your MRR, Churn rates, ARPU, and other SaaS metrics.') }}</li>
                    <li>{{ __('Multiple payment providers: Stripe, Paddle, and more coming soon.') }}</li>
                    <li>{{ __('Multiple email providers: Mailgun, Postmark, Amazon SES, and more coming soon.') }}</li>
                    <li>{{ __('Blog: Create and manage your blog posts.') }}</li>
                    <li>{{ __('User &amp; Role Management: Create and manage your users and roles, and assign permissions to your users.') }}</li>
                    <li>{{ __('Fully translatable: Translate your application to any language you want.') }}</li>
                    <li>{{ __('Sitemap &amp; SEO: Sitemap and SEO optimization out of the box.') }}</li>
                    <li>{{ __('Admin Panel: Manage your SaaS application from a beautiful admin panel powered by ') }} <a href="https://filamentphp.com/" target="_blank" rel="noopener noreferrer">Filament</a>.</li>
                    <li>{{ __('User Dashboard: Your customers can manage their subscriptions, change payment method, upgrade plan, cancel subscription, and more from a beautiful user dashboard powered by') }} <a href="https://filamentphp.com/" target="_blank" rel="noopener noreferrer">Filament</a>.</li>
                    <li>{{ __('Automated Tests: Comes with automated tests for critical components of the application.') }}</li>
                    <li>{{ __('One-line deployment: Provision your server and deploy your application easily with integrated') }} <a href="https://deployer.org/" target="_blank" rel="noopener noreferrer">Deployer</a> {{ __('  support.') }}</li>
                    <li>{{ __('Developer-friendly: Built with developers in mind, uses best coding practices.') }}</li>
                    <li>{{ __('And much more...') }}</li>
                </ul>

            </x-accordion.item>

            <x-accordion.item active="false" name="faqs">
                <x-slot name="title">{{ __('Which payment providers are supported?') }}</x-slot>

                <p>
                    {{ __('SaaSykit supports Stripe and Paddle out of the box. You can easily add more payment providers by extending the code. More payment method will be added in the future as well (e.g. Lemon Squeezy)') }}
                </p>

            </x-accordion.item>

            <x-accordion.item active="false" name="faqs">
                <x-slot name="title">{{'What Tech stack is used?'}}</x-slot>

                <p>
                    {{ __('SaaSykit is built on top of') }} <a href="https://laravel.com" target="_blank">Laravel</a> {{ __('Laravel, the most popular PHP framework, and') }} <a target="_blank" href="https://filamentphp.com/">Filament</a> {{ __(', a beautiful and powerful admin panel for Laravel. It also uses TailwindCSS, AlpineJS, and Livewire.')}}
                </p>
                <p class="mt-4">
                    {{ __('You can use your favourite database (MySQL, PostgreSQL, SQLite) and your favourite queue driver (Redis, Amazon SQS, etc).')}}
                </p>

            </x-accordion.item>

            <x-accordion.item active="false" name="faqs">
                <x-slot name="title">{{'How often is SaaSykit updated?'}}</x-slot>

                <p>
                    {{ __('SaaSykit is updated regularly to keep up with the latest Laravel and Filament versions, and to add new features and improvements.')}}
                </p>

            </x-accordion.item>

            <x-accordion.item active="false" name="faqs">
                <x-slot name="title">{{'Do you offer refunds?'}}</x-slot>

                <p>
                    {{ __('Yes, we offer a 14-day money-back guarantee. If you are not satisfied with SaaSykit, you can request a refund within 14 days of your purchase.')}}
                </p>

            </x-accordion.item>

            <x-accordion.item active="false" name="faqs">
                <x-slot name="title">{{'Where can I host my SaaS application?'}}</x-slot>

                <p>
                    {{ __('You can host your SaaS application on any server that supports PHP, such as DigitalOcean, AWS, Hetzner, Linode, and more. You can also use a platform like Laravel Forge to manage your server and deploy your application.')}}
                </p>

            </x-accordion.item>

            <x-accordion.item active="false" name="faqs">
                <x-slot name="title">{{'Is there a demo available?'}}</x-slot>

                <p>
                    {{ __('Yes, you can check the demo here: ')}} <a href="https://demo.saasykit.com" target="_blank">demo.saasykit.com</a>
                </p>

            </x-accordion.item>

            <x-accordion.item active="false" name="faqs">
                <x-slot name="title">{{'Is there documentation available?'}}</x-slot>

                <p>
                    {{ __('Yes, an extensive documentation is available to help you get started with SaaSykit. You can find the documentation ')}} <a href="https://saasykit.com/docs" target="_blank">here</a>.
                </p>

            </x-accordion.item>

            <x-accordion.item active="false" name="faqs">
                <x-slot name="title">{{'How is SaaSykit different from just using Laravel directly?'}}</x-slot>

                <p>
                    {{__('SaaSykit is built on top of Laravel with the intention to save you time and effort by not having to build everything needed for a modern SaaS from scratch, like payment provider integration, subscription management, user authentication, user & role management, having a beautiful admin panel, a user dashboard to manage their subscriptions/payments, and more.')}}
                </p>
                <p class="mt-4">
                    {{__('You can choose to base your SaaS on vanilla Laravel and build everything from scratch if you prefer and that is totally fine, but you will need a few months to build what SaaSykit offers out of the box, then on top of that, you will need to start to build your actual SaaS application.')}}
                </p>

                <p class="mt-4">
                    {{__('SaaSykit is a great starting point for your SaaS application, it is built with best coding practices, and it is developer-friendly. It is also built with the intention to be easily customizable and extendable. Any developer who is familiar with Laravel will feel right at home.')}}
                </p>

            </x-accordion.item>
        </x-accordion>
    </div>

    <x-section.outro class="text-center">
        <x-heading.h6 class="text-primary-50">
            {{ __('Come closer to your dream SaaS') }}
        </x-heading.h6>
        <x-heading.h2 class="text-primary-50">
            {{ __('Know when SaaSykit is live') }}
        </x-heading.h2>


        <div class="mt-4 max-w-3xl text-primary-100 mx-auto">
            <p>
                {{ __('We are working hard to make SaaSykit available to you. Sign up to our newsletter to be the first to know when it is live. No spam, we promise.')}}
            </p>
        </div>

        <x-input.field labelClass="text-primary-50" inputClass="bg-transparent placeholder-primary-100 text-primary-50" placeholder="{{ __('Your email address') }}" class="mx-auto mt-8" />

        <div class="mt-6">
            <x-button-link.secondary href="{{route('register')}}" class="self-center !py-3" elementType="a">
                {{ __('Keep me informed') }}
            </x-button-link.secondary>
        </div>





        <style type="text/css">@import url("https://assets.mlcdn.com/fonts.css?version=1705921");</style>
        <style type="text/css">
            /* LOADER */
            .ml-form-embedSubmitLoad {
                display: inline-block;
                width: 20px;
                height: 20px;
            }

            .g-recaptcha {
                transform: scale(1);
                -webkit-transform: scale(1);
                transform-origin: 0 0;
                -webkit-transform-origin: 0 0;
                height: ;
            }

            .sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0,0,0,0);
                border: 0;
            }

            .ml-form-embedSubmitLoad:after {
                content: " ";
                display: block;
                width: 11px;
                height: 11px;
                margin: 1px;
                border-radius: 50%;
                border: 4px solid #fff;
                border-color: #3f5d6b #3f5d6b #3f5d6b transparent;
                animation: ml-form-embedSubmitLoad 1.2s linear infinite;
            }
            @keyframes ml-form-embedSubmitLoad {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }
            #mlb2-12114309.ml-form-embedContainer {
                box-sizing: border-box;
                display: table;
                margin: 0 auto;
                position: static;
                width: 100% !important;
            }
            #mlb2-12114309.ml-form-embedContainer h4,
            #mlb2-12114309.ml-form-embedContainer p,
            #mlb2-12114309.ml-form-embedContainer span,
            #mlb2-12114309.ml-form-embedContainer button {
                text-transform: none !important;
                letter-spacing: normal !important;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper {

                border-width: 0px;
                border-color: transparent;
                border-radius: 4px;
                border-style: solid;
                box-sizing: border-box;
                display: inline-block !important;
                margin: 0;
                padding: 0;
                position: relative;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper.embedPopup,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper.embedDefault { width: 400px; }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper.embedForm { max-width: 400px; width: 100%; }
            #mlb2-12114309.ml-form-embedContainer .ml-form-align-left { text-align: left; }
            #mlb2-12114309.ml-form-embedContainer .ml-form-align-center { text-align: center; }
            #mlb2-12114309.ml-form-embedContainer .ml-form-align-default { display: table-cell !important; vertical-align: middle !important; text-align: center !important; }
            #mlb2-12114309.ml-form-embedContainer .ml-form-align-right { text-align: right; }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedHeader img {
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
                height: auto;
                margin: 0 auto !important;
                max-width: 100%;
                width: undefinedpx;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-successBody {
                padding: 20px 20px 0 20px;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody.ml-form-embedBodyHorizontal {
                padding-bottom: 0;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedContent,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-successBody .ml-form-successContent {
                text-align: left;
                margin: 0 0 20px 0;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedContent h4,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-successBody .ml-form-successContent h4 {
                color: #000000;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif;
                font-size: 30px;
                font-weight: 400;
                margin: 0 0 10px 0;
                text-align: left;
                word-break: break-word;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedContent p,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-successBody .ml-form-successContent p {
                color: #000000;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif;
                font-size: 14px;
                font-weight: 400;
                line-height: 20px;
                margin: 0 0 10px 0;
                text-align: left;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedContent ul,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedContent ol,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-successBody .ml-form-successContent ul,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-successBody .ml-form-successContent ol {
                color: #000000;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif;
                font-size: 14px;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedContent ol ol,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-successBody .ml-form-successContent ol ol {
                list-style-type: lower-alpha;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedContent ol ol ol,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-successBody .ml-form-successContent ol ol ol {
                list-style-type: lower-roman;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedContent p a,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-successBody .ml-form-successContent p a {
                color: #000000;
                text-decoration: underline;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-block-form .ml-field-group {
                text-align: left!important;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-block-form .ml-field-group label {
                margin-bottom: 5px;
                color: #333333;
                font-size: 14px;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif;
                font-weight: bold; font-style: normal; text-decoration: none;;
                display: inline-block;
                line-height: 20px;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedContent p:last-child,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-successBody .ml-form-successContent p:last-child {
                margin: 0;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody form {
                margin: 0;
                width: 100%;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-formContent,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow {
                margin: 0 0 20px 0;
                width: 100%;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow {
                float: left;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-formContent.horozintalForm {
                margin: 0;
                padding: 0 0 20px 0;
                width: 100%;
                height: auto;
                float: left;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow {
                margin: 0 0 10px 0;
                width: 100%;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow.ml-last-item {
                margin: 0;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow.ml-formfieldHorizintal {
                margin: 0;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow input {
                background-color: #ffffff !important;
                color: #333333 !important;
                border-color: #cccccc;
                border-radius: 8px !important;
                border-style: solid !important;
                border-width: 1px !important;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif;
                font-size: 14px !important;
                height: auto;
                line-height: 21px !important;
                margin-bottom: 0;
                margin-top: 0;
                margin-left: 0;
                margin-right: 0;
                padding: 10px 10px !important;
                width: 100% !important;
                box-sizing: border-box !important;
                max-width: 100% !important;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow input::-webkit-input-placeholder,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow input::-webkit-input-placeholder { color: #333333; }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow input::-moz-placeholder,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow input::-moz-placeholder { color: #333333; }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow input:-ms-input-placeholder,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow input:-ms-input-placeholder { color: #333333; }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow input:-moz-placeholder,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow input:-moz-placeholder { color: #333333; }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow textarea, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow textarea {
                background-color: #ffffff !important;
                color: #333333 !important;
                border-color: #cccccc;
                border-radius: 8px !important;
                border-style: solid !important;
                border-width: 1px !important;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif;
                font-size: 14px !important;
                height: auto;
                line-height: 21px !important;
                margin-bottom: 0;
                margin-top: 0;
                padding: 10px 10px !important;
                width: 100% !important;
                box-sizing: border-box !important;
                max-width: 100% !important;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-radio .custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-radio .custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-checkbox .custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-checkbox .custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedPermissions .ml-form-embedPermissionsOptionsCheckbox .label-description::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-interestGroupsRow .ml-form-interestGroupsRowCheckbox .label-description::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow .label-description::before {
                border-color: #cccccc!important;
                background-color: #ffffff!important;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow input.custom-control-input[type="checkbox"]{
                box-sizing: border-box;
                padding: 0;
                position: absolute;
                z-index: -1;
                opacity: 0;
                margin-top: 5px;
                margin-left: -1.5rem;
                overflow: visible;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-checkbox .custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-checkbox .custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedPermissions .ml-form-embedPermissionsOptionsCheckbox .label-description::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-interestGroupsRow .ml-form-interestGroupsRowCheckbox .label-description::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow .label-description::before {
                border-radius: 4px!important;
            }


            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow input[type=checkbox]:checked~.label-description::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedPermissions .ml-form-embedPermissionsOptionsCheckbox input[type=checkbox]:checked~.label-description::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-checkbox .custom-control-input:checked~.custom-control-label::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-checkbox .custom-control-input:checked~.custom-control-label::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-interestGroupsRow .ml-form-interestGroupsRowCheckbox input[type=checkbox]:checked~.label-description::after {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-radio .custom-control-input:checked~.custom-control-label::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-radio .custom-control-input:checked~.custom-control-label::after {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-radio .custom-control-input:checked~.custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-radio .custom-control-input:checked~.custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-checkbox .custom-control-input:checked~.custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-checkbox .custom-control-input:checked~.custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedPermissions .ml-form-embedPermissionsOptionsCheckbox input[type=checkbox]:checked~.label-description::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-interestGroupsRow .ml-form-interestGroupsRowCheckbox input[type=checkbox]:checked~.label-description::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow input[type=checkbox]:checked~.label-description::before  {
                border-color: #000000!important;
                background-color: #000000!important;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-radio .custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-radio .custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-radio .custom-control-label::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-radio .custom-control-label::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-checkbox .custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-checkbox .custom-control-label::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-checkbox .custom-control-label::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-checkbox .custom-control-label::after {
                top: 2px;
                box-sizing: border-box;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedPermissions .ml-form-embedPermissionsOptionsCheckbox .label-description::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedPermissions .ml-form-embedPermissionsOptionsCheckbox .label-description::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow .label-description::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow .label-description::after {
                top: 0px!important;
                box-sizing: border-box!important;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow .label-description::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow .label-description::after {
                top: 0px!important;
                box-sizing: border-box!important;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-interestGroupsRow .ml-form-interestGroupsRowCheckbox .label-description::after {
                top: 0px!important;
                box-sizing: border-box!important;
                position: absolute;
                left: -1.5rem;
                display: block;
                width: 1rem;
                height: 1rem;
                content: "";
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-interestGroupsRow .ml-form-interestGroupsRowCheckbox .label-description::before {
                top: 0px!important;
                box-sizing: border-box!important;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .custom-control-label::before {
                position: absolute;
                top: 4px;
                left: -1.5rem;
                display: block;
                width: 16px;
                height: 16px;
                pointer-events: none;
                content: "";
                background-color: #ffffff;
                border: #adb5bd solid 1px;
                border-radius: 50%;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .custom-control-label::after {
                position: absolute;
                top: 2px!important;
                left: -1.5rem;
                display: block;
                width: 1rem;
                height: 1rem;
                content: "";
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedPermissions .ml-form-embedPermissionsOptionsCheckbox .label-description::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-interestGroupsRow .ml-form-interestGroupsRowCheckbox .label-description::before, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow .label-description::before {
                position: absolute;
                top: 4px;
                left: -1.5rem;
                display: block;
                width: 16px;
                height: 16px;
                pointer-events: none;
                content: "";
                background-color: #ffffff;
                border: #adb5bd solid 1px;
                border-radius: 50%;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedPermissions .ml-form-embedPermissionsOptionsCheckbox .label-description::after {
                position: absolute;
                top: 0px!important;
                left: -1.5rem;
                display: block;
                width: 1rem;
                height: 1rem;
                content: "";
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow .label-description::after {
                position: absolute;
                top: 0px!important;
                left: -1.5rem;
                display: block;
                width: 1rem;
                height: 1rem;
                content: "";
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .custom-radio .custom-control-label::after {
                background: no-repeat 50%/50% 50%;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .custom-checkbox .custom-control-label::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedPermissions .ml-form-embedPermissionsOptionsCheckbox .label-description::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-interestGroupsRow .ml-form-interestGroupsRowCheckbox .label-description::after, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow .label-description::after {
                background: no-repeat 50%/50% 50%;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-control, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-control {
                position: relative;
                display: block;
                min-height: 1.5rem;
                padding-left: 1.5rem;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-radio .custom-control-input, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-radio .custom-control-input, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-checkbox .custom-control-input, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-checkbox .custom-control-input {
                position: absolute;
                z-index: -1;
                opacity: 0;
                box-sizing: border-box;
                padding: 0;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-radio .custom-control-label, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-radio .custom-control-label, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-checkbox .custom-control-label, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-checkbox .custom-control-label {
                color: #000000;
                font-size: 12px!important;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif;
                line-height: 22px;
                margin-bottom: 0;
                position: relative;
                vertical-align: top;
                font-style: normal;
                font-weight: 700;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-fieldRow .custom-select, #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow .custom-select {
                background-color: #ffffff !important;
                color: #333333 !important;
                border-color: #cccccc;
                border-radius: 8px !important;
                border-style: solid !important;
                border-width: 1px !important;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif;
                font-size: 14px !important;
                line-height: 20px !important;
                margin-bottom: 0;
                margin-top: 0;
                padding: 10px 28px 10px 12px !important;
                width: 100% !important;
                box-sizing: border-box !important;
                max-width: 100% !important;
                height: auto;
                display: inline-block;
                vertical-align: middle;
                background: url('https://assets.mlcdn.com/ml/images/default/dropdown.svg') no-repeat right .75rem center/8px 10px;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
            }


            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow {
                height: auto;
                width: 100%;
                float: left;
            }
            .ml-form-formContent.horozintalForm .ml-form-horizontalRow .ml-input-horizontal { width: 70%; float: left; }
            .ml-form-formContent.horozintalForm .ml-form-horizontalRow .ml-button-horizontal { width: 30%; float: left; }
            .ml-form-formContent.horozintalForm .ml-form-horizontalRow .ml-button-horizontal.labelsOn { padding-top: 25px;  }
            .ml-form-formContent.horozintalForm .ml-form-horizontalRow .horizontal-fields { box-sizing: border-box; float: left; padding-right: 10px;  }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow input {
                background-color: #ffffff;
                color: #333333;
                border-color: #cccccc;
                border-radius: 8px;
                border-style: solid;
                border-width: 1px;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif;
                font-size: 14px;
                line-height: 20px;
                margin-bottom: 0;
                margin-top: 0;
                padding: 10px 10px;
                width: 100%;
                box-sizing: border-box;
                overflow-y: initial;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow button {
                background-color: #97deff !important;
                border-color: #97deff;
                border-style: solid;
                border-width: 1px;
                border-radius: 23px;
                box-shadow: none;
                color: #3f5d6b !important;
                cursor: pointer;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif;
                font-size: 14px !important;
                font-weight: 700;
                line-height: 20px;
                margin: 0 !important;
                padding: 10px !important;
                width: 100%;
                height: auto;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-horizontalRow button:hover {
                background-color: #89cae8 !important;
                border-color: #89cae8 !important;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow input[type="checkbox"] {
                box-sizing: border-box;
                padding: 0;
                position: absolute;
                z-index: -1;
                opacity: 0;
                margin-top: 5px;
                margin-left: -1.5rem;
                overflow: visible;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow .label-description {
                color: #000000;
                display: block;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif;
                font-size: 12px;
                text-align: left;
                margin-bottom: 0;
                position: relative;
                vertical-align: top;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow label {
                font-weight: normal;
                margin: 0;
                padding: 0;
                position: relative;
                display: block;
                min-height: 24px;
                padding-left: 24px;

            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow label a {
                color: #000000;
                text-decoration: underline;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow label p {
                color: #000000 !important;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif !important;
                font-size: 12px !important;
                font-weight: normal !important;
                line-height: 18px !important;
                padding: 0 !important;
                margin: 0 5px 0 0 !important;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow label p:last-child {
                margin: 0;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedSubmit {
                margin: 0 0 20px 0;
                float: left;
                width: 100%;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedSubmit button {
                background-color: #97deff !important;
                border: none !important;
                border-radius: 23px !important;
                box-shadow: none !important;
                color: #3f5d6b !important;
                cursor: pointer;
                font-family: 'Open Sans', Arial, Helvetica, sans-serif !important;
                font-size: 14px !important;
                font-weight: 700 !important;
                line-height: 21px !important;
                height: auto;
                padding: 10px !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedSubmit button.loading {
                display: none;
            }
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-embedSubmit button:hover {
                background-color: #89cae8 !important;
            }
            .ml-subscribe-close {
                width: 30px;
                height: 30px;
                background: url('https://assets.mlcdn.com/ml/images/default/modal_close.png') no-repeat;
                background-size: 30px;
                cursor: pointer;
                margin-top: -10px;
                margin-right: -10px;
                position: absolute;
                top: 0;
                right: 0;
            }
            .ml-error input, .ml-error textarea, .ml-error select {
                border-color: red!important;
            }

            .ml-error .custom-checkbox-radio-list {
                border: 1px solid red !important;
                border-radius: 4px;
                padding: 10px;
            }

            .ml-error .label-description,
            .ml-error .label-description p,
            .ml-error .label-description p a,
            .ml-error label:first-child {
                color: #ff0000 !important;
            }

            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow.ml-error .label-description p,
            #mlb2-12114309.ml-form-embedContainer .ml-form-embedWrapper .ml-form-embedBody .ml-form-checkboxRow.ml-error .label-description p:first-letter {
                color: #ff0000 !important;
            }
            @media only screen and (max-width: 400px){

                .ml-form-embedWrapper.embedDefault, .ml-form-embedWrapper.embedPopup { width: 100%!important; }
                .ml-form-formContent.horozintalForm { float: left!important; }
                .ml-form-formContent.horozintalForm .ml-form-horizontalRow { height: auto!important; width: 100%!important; float: left!important; }
                .ml-form-formContent.horozintalForm .ml-form-horizontalRow .ml-input-horizontal { width: 100%!important; }
                .ml-form-formContent.horozintalForm .ml-form-horizontalRow .ml-input-horizontal > div { padding-right: 0px!important; padding-bottom: 10px; }
                .ml-form-formContent.horozintalForm .ml-button-horizontal { width: 100%!important; }
                .ml-form-formContent.horozintalForm .ml-button-horizontal.labelsOn { padding-top: 0px!important; }

            }
        </style>



































































































































































        <div id="mlb2-12114309" class="ml-form-embedContainer ml-subscribe-form ml-subscribe-form-12114309">
            <div class="ml-form-align-center ">
                <div class="ml-form-embedWrapper embedForm">




                    <div class="ml-form-embedBody ml-form-embedBodyDefault row-form">

                        <div class="ml-form-embedContent" style="margin-bottom: 0px; ">

                        </div>

                        <form class="ml-block-form" action="https://assets.mailerlite.com/jsonp/394029/forms/112420222890149046/subscribe" data-code="" method="post" target="_blank">
                            <div class="ml-form-formContent">



                                <div class="ml-form-fieldRow ml-last-item">
                                    <div class="ml-field-group ml-field-email ml-validate-email ml-validate-required">




                                        <!-- input -->
                                        <input aria-label="email" aria-required="true" type="email" class="form-control" data-inputmask="" name="fields[email]" placeholder="Email" autocomplete="email">
                                        <!-- /input -->

                                        <!-- textarea -->

                                        <!-- /textarea -->

                                        <!-- select -->

                                        <!-- /select -->

                                        <!-- checkboxes -->

                                        <!-- /checkboxes -->

                                        <!-- radio -->

                                        <!-- /radio -->

                                        <!-- countries -->

                                        <!-- /countries -->





                                    </div>
                                </div>

                            </div>



                            <!-- Privacy policy -->

                            <!-- /Privacy policy -->













                            <input type="hidden" name="ml-submit" value="1">

                            <div class="ml-form-embedSubmit">

                                <button type="submit" class="primary">Keep me informed</button>

                                <button disabled="disabled" style="display: none;" type="button" class="loading">
                                    <div class="ml-form-embedSubmitLoad"></div>
                                    <span class="sr-only">Loading...</span>
                                </button>
                            </div>


                            <input type="hidden" name="anticsrf" value="true">
                        </form>
                    </div>

                    <div class="ml-form-successBody row-success" style="display: none">

                        <div class="ml-form-successContent">

                            <h4>Thank you!</h4>

                            <p>You have successfully joined our subscriber list.</p>


                        </div>

                    </div>
                </div>
            </div>
        </div>





        <script>
            function ml_webform_success_12114309() {
                var $ = ml_jQuery || jQuery;
                $('.ml-subscribe-form-12114309 .row-success').show();
                $('.ml-subscribe-form-12114309 .row-form').hide();
            }
        </script>


        <script src="https://groot.mailerlite.com/js/w/webforms.min.js?v2d8fb22bb5b3677f161552cd9e774127" type="text/javascript"></script>
        <script>
            fetch("https://assets.mailerlite.com/jsonp/394029/forms/112420222890149046/takel")
        </script>




    </x-section.outro>

</x-layouts.app>
