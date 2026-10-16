{{-- -------------------
     Frontend App Layout - Trinity Mabati Factory
------------------- --}}
<!DOCTYPE html>
<html lang="en">

<head>

    {{-- Meta --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('frontend.partials.seo-head')

    <link rel="icon" href="{{ $branding['site_icon'] }}">
    <link rel="apple-touch-icon" href="{{ $branding['apple_touch_icon'] }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.branding')
    @include('frontend.partners.styles')

    {{-- Primary-coloured scrollbar at the browser's default width (kept inline so it applies regardless of the build) --}}
    <style>
        html {
            scrollbar-color: var(--primary-color) transparent;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: var(--primary-color);
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: var(--primary-dark);
        }
    </style>

</head>

<body class="bg-background text-gray-800 flex flex-col min-h-screen">

    {{-- Topbar --}}
    @include('frontend.partials.topbar')

    {{-- Header --}}
    @include('frontend.partials.header')

    {{-- Page Content --}}
    <main class="storefront-main flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.partials.footer')

    {{-- Page scripts pushed by child views --}}
    @stack('scripts')

    {{-- @include('frontend.partials.bottom-nav') --}}
    @include('frontend.partials.cart-runtime')
</body>

</html>
