<title>{{ $title ? $title . ' | ' : '' }}{{ config('app.name') }}</title>
@if ($description)
    <meta name="description" content="{{ $description }}">
@endif

@if ($author)
    <meta name="author" content="{{ $author }}">
@endif

@if ($keywords)
    <meta name="keywords" content="{{ config('app.name') }}, {{ $keywords }}">
@endif


@if ($robots)
    <meta name="robots" content="{{ $robots }}">
@endif

<meta property="og:title" content="{{ $title ? $title . ' | ' : '' }}{{ config('app.name') }}">
<meta property="og:description" content="{{ $description }}">

<meta property="og:image" content="{{ $image ?? asset('assets/guest/img/seo/og-default.jpg') }}">
<meta property="og:locale" content="id_ID">

@if ($url)
    <meta property="og:url" content="{{ $url }}">
    <link rel="canonical" href="{{ $url }}">
@endif
