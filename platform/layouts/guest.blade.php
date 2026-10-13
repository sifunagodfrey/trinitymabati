{{-- -------------------
     Guest Layout
     Minimal centered card layout for standalone auth pages
------------------- --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Trinity Mabati Factory') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.branding')
    <link rel="icon" href="{{ $branding['site_icon'] }}">
    <link rel="apple-touch-icon" href="{{ $branding['apple_touch_icon'] }}">
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50">
        <div>
            <a href="{{ url('/') }}" class="text-2xl font-extrabold text-primary">
                {{ config('app.name', 'Trinity Mabati Factory') }}
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white shadow-sm border border-gray-200 overflow-hidden sm:rounded-[12px]">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
