@if (!empty(config('app.google_tracking_id')))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{config('app.google_tracking_id')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{config('app.google_tracking_id')}}');
    </script>
@endif

@if (!empty(config('app.posthog_html_snippet')))
    {!! config('app.posthog_html_snippet') !!}
@endif
