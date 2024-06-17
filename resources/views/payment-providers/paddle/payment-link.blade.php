@extends('layouts.app')

@push('head')
    <script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>
    <script>
        @if(config('services.paddle.is_sandbox'))
            Paddle.Environment.set("sandbox");
        @endif

        document.addEventListener("DOMContentLoaded", (event) => {
            Paddle.Setup({
                token: '{{ config('services.paddle.client_side_token') }}',
                checkout: {
                    settings: {
                        displayMode: "overlay",
                        theme: "light",
                    }
                }
            });
        });

    </script>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


            </div>
        </div>
    </div>
@endsection



