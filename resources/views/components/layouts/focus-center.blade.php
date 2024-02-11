<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @isset($title)
            {{ $title }} | {{ config('app.name', 'SaaSykit') }}
        @else
            {{ config('app.name', 'SaaSykit') }}
        @endisset
    </title>

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">

    @include('components.layouts.partials.social-cards')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('head')
    @include('components.layouts.partials.analytics')
</head>
<body class="text-primary-900">
    <div id="app">

        <div class="w-full">
            <div class="flex justify-between">
                <a href="{{route('home')}}">
                    <img src="{{asset('images/logo-dark.png')}}" class="inline-block h-6 m-6" alt="Logo" />
                </a>

                <div class="self-end text-primary-300 m-4 text-xs">
                    <x-link href="{{route('home')}}" class="flex items-center text-primary-100">{{__('back')}}</x-link>
                </div>
            </div>

            <div>
                {{$slot}}
            </div>
        </div>

        @stack('tail')
    </div>
</body>
</html>
