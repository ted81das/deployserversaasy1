@php
    use Illuminate\Support\Facades\Vite;
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
{{--  If you do changes to this file (add styles), you need to run `npm run build` because this is the only way to get the styles inlined in the email. --}}
        {!! Vite::content('resources/sass/email.scss') !!}
    </style>

{{--    @vite(['resources/sass/email.scss'])--}}

</head>
<body class="text-primary-900">
<div id="app">
    <div class="max-w-3xl mx-auto">
        <div class="flex flex-col p-4 items-center justify-center">
            <a href="{{route('home')}}">
                <img src="{{ asset('images/logo-dark.svg') }}" class="h-6" alt="Logo" />
            </a>
            <div class="p-4 mt-4">
                <div class="rounded border border-t-2 border-t-primary-500 shadow w-full p-4">
                    {{$slot}}
                </div>
            </div>
        </div>
        <div class="text-neutral-400 text-sm mb-4 text-center">
            {{ __('© :year :app. All rights reserved.', ['year' => date('Y'), 'app' => config('app.name')]) }}
        </div>

    </div>

</div>
</body>
</html>
