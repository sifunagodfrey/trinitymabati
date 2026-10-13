{{-- -------------------
     Frontend App Layout - Trinity Mabati Factory
------------------- --}}
<!DOCTYPE html>
<html lang="en">

<head>

    {{-- Meta --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Defaults --}}
    <meta name="description" content="@yield('meta_description', config('app.name') . ' offers convenient online shopping with M-Pesa checkout.')">
    <meta name="keywords" content="@yield('meta_keywords', config('app.name') . ', online shopping Kenya, ecommerce, M-Pesa')">
    <meta name="author" content="{{ config('app.name') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', config('app.name') . ' offers convenient online shopping with M-Pesa checkout.')">
    <meta property="og:image" content="@yield('og_image', url('public/images/haromi-home-seo-image.jpg'))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('og_description', 'Stationery and office supplies with convenient M-Pesa checkout.')">
    <meta name="twitter:image" content="@yield('og_image', url('public/images/haromi-home-seo-image.jpg'))">

    {{-- Structured Data (encoded in PHP so Blade never parses the JSON-LD keys) --}}
    <script type="application/ld+json">{!! json_encode([
        '@context'    => 'https://schema.org',
        '@type'       => 'Organization',
        'name'        => config('app.name'),
        'url'         => url('/'),
        'logo'        => $branding['logo_main'],
        'image'       => url('public/images/haromi-home-seo-image.jpg'),
        'description' => config('app.name') . ' offers convenient online shopping across Kenya.',
    ], JSON_UNESCAPED_SLASHES) !!}</script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6ND2P69LZS"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-6ND2P69LZS');
    </script>

    {{-- Title --}}
    <title>@yield('title', config('app.name'))</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ $branding['site_icon'] }}">
    <link rel="apple-touch-icon" href="{{ $branding['apple_touch_icon'] }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.branding')

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
