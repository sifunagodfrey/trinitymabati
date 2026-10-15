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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('frontend.partials.seo-head')

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
