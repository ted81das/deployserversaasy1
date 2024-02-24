<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('components.layouts.partials.head')
</head>
<body class="text-primary-900" x-data>
    <div id="app">
        <x-layouts.app.header />

        @php($container = $container ?? 'container')
        <div class="mx-auto {{$container}}">
            {{ $slot }}
        </div>

        <x-layouts.app.footer />

        @stack('tail')
    </div>
</body>
</html>
