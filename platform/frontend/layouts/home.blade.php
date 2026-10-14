{{-- -------------------
     Home Layout
     Used only by the landing page. The header is fixed and transparent
     so the hero can sit behind it, so this layout does not reserve top
     space; the hero handles its own top padding.
------------------- --}}
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO --}}
    <meta name="description" content="@yield('meta_description', config('app.name') . ' offers convenient online shopping and delivery.')">
    <meta name="keywords" content="@yield('meta_keywords', 'stationery, office supplies, school supplies, notebooks, pens')">
    <meta name="author" content="{{ config('app.name') }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'Shop stationery, school essentials and office supplies with convenient delivery.')">
    <meta property="og:image" content="@yield('og_image', url('public/images/haromi-home-seo-image.jpg'))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('og_description', 'Shop stationery, school essentials and office supplies online.')">
    <meta name="twitter:image" content="@yield('og_image', url('public/images/haromi-home-seo-image.jpg'))">

    <title>@yield('title', config('app.name'))</title>

    <link rel="icon" href="{{ $branding['site_icon'] }}">
    <link rel="apple-touch-icon" href="{{ $branding['apple_touch_icon'] }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.branding')

</head>

<body class="bg-background text-text flex flex-col min-h-screen">

    {{-- Header (fixed, transparent over hero) --}}
    @include('frontend.partials.topbar')
    @include('frontend.partials.header')

    {{-- Page Content --}}
    <main class="storefront-main flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.partials.footer')

    {{-- Page scripts --}}
    @stack('scripts')

    @include('frontend.partials.whatsapp-float')
    {{-- @include('frontend.partials.bottom-nav') --}}
    @include('frontend.partials.cart-runtime')
</body>

</html>
