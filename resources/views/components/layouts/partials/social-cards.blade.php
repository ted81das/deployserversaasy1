<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ !empty($title) ? $title : config('app.name', 'SaaSykit') }}" />
<meta name="twitter:description" content="{{ !empty($description) ? $description : config('app.description', 'SaaSykit') }}" />
<meta name="twitter:image" content="{{!empty($socialCard) ? $socialCard : asset('images/twitter-card.png')}}" />

<meta property="og:title" content="{{ !empty($title) ? $title : config('app.name', 'SaaSykit') }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{route('home')}}" />
<meta property="og:image" content="{{ !empty($socialCard) ? $socialCard : asset('images/facebook-card.png')}}" />
<meta property="og:description" content="{{ !empty($description) ? $description : config('app.description', 'SaaSykit') }}" />
