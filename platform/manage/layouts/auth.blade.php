{{-- ---------------
-- Auth Layout
-- Standalone layout for login and 2FA pages.
-- No sidebar/topbar - pre-authentication context.
-- --------------- --}}
<!DOCTYPE html>
<html lang="en" class="h-full overflow-hidden">

<head>

    {{-- ---------------
    -- Meta
    -- --------------- --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ $branding['site_icon'] }}">
    <link rel="apple-touch-icon" href="{{ $branding['apple_touch_icon'] }}">

    {{-- ---------------
    -- Assets (CSS + JS via Vite)
    -- --------------- --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.branding')

    {{-- ---------------
    -- Page-level styles
    -- --------------- --}}
    @stack('styles')

</head>

<body class="h-full m-0 overflow-hidden">

    @yield('content')

    {{-- ---------------
    -- Scripts
    -- --------------- --}}
    @stack('scripts')

</body>

</html>
