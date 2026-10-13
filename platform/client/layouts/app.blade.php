{{-- -------------------
     Client Layout
------------------- --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My ' . config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.branding')
    <link rel="icon" href="{{ $branding['site_icon'] }}">
    <link rel="apple-touch-icon" href="{{ $branding['apple_touch_icon'] }}">
</head>

<body class="bg-gray-50 text-gray-800">

    {{-- Site Topbar & Header --}}
    @include('frontend.partials.topbar')
    @include('frontend.partials.header')

    @php
        // Determine which tab is active
        $isDashboardTab =
            request()->routeIs('client.dashboard') ||
            request()->routeIs('client.orders.*') ||
            request()->routeIs('client.quotation.*') ||
            request()->routeIs('client.wallet.*') ||
            request()->routeIs('client.loyalty.*') ||
            request()->routeIs('client.address.*') ||
            request()->routeIs('client.contract.*') ||
            request()->routeIs('client.wishlist.*');

        $isMessagesTab = request()->routeIs('client.inbox.*');

        $isAccountTab = request()->routeIs('client.settings.*') || request()->routeIs('client.newsletter.*');

        // Determine if we are on a root/index page (no back button needed)
        $isRootPage =
            request()->routeIs('client.dashboard') ||
            request()->routeIs('client.inbox.index') ||
            request()->routeIs('client.settings.account') ||
            request()->routeIs('client.wishlist.index');

        // Resolve back URL for sub-pages
        $backUrl = null;
        if (!$isRootPage) {
            if ($isDashboardTab) {
                $backUrl = route('client.dashboard');
            } elseif ($isMessagesTab) {
                $backUrl = route('client.inbox.index');
            } elseif ($isAccountTab) {
                $backUrl = route('client.settings.account');
            }
        }
    @endphp

    {{-- ================================
         MOBILE SIDEBAR OVERLAY + DRAWER
    ================================= --}}
    {{-- Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="closeSidebar()">
    </div>

    {{-- Drawer --}}
    <div id="sidebar-drawer"
        class="fixed top-0 left-0 h-full w-64 bg-white z-50 shadow-xl
               transform -translate-x-full transition-transform duration-300 ease-in-out
               md:hidden overflow-y-auto">

        {{-- Drawer Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <span class="font-bold text-gray-900 text-sm">My {{ config('app.name') }}</span>
            <button onclick="closeSidebar()"
                class="w-8 h-8 flex items-center justify-center rounded-[12px] hover:bg-gray-100 text-gray-500 transition">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        {{-- Drawer Sidebar Links --}}
        <div class="p-4">
            @include('client.partials.sidebar')
        </div>

    </div>

    {{-- ================================
         MAIN PORTAL WRAPPER
    ================================= --}}
    <div class="max-w-7xl mx-auto px-4 md:px-6 pt-6 pb-16">

        {{-- Page Title --}}
        <h1 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 md:mb-5">My {{ config('app.name') }}</h1>

        {{-- ========================
             TOP TAB NAVIGATION
             Scrollable on mobile
        ========================= --}}
        <div class="border-b border-gray-200 mb-6">
            <nav class="flex gap-6 overflow-x-auto scrollbar-none -mb-px">

                {{-- Dashboard --}}
                <a href="{{ route('client.dashboard') }}"
                    class="whitespace-nowrap pb-3 text-sm font-medium border-b-2 transition-colors flex-shrink-0
                    {{ $isDashboardTab
                        ? 'border-gray-900 text-gray-900'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Dashboard
                </a>

                {{-- Messages --}}
                <a href="{{ route('client.inbox.index') }}"
                    class="whitespace-nowrap pb-3 text-sm font-medium border-b-2 transition-colors flex-shrink-0
                    {{ $isMessagesTab
                        ? 'border-gray-900 text-gray-900'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Messages
                </a>

                {{-- Account --}}
                <a href="{{ route('client.settings.account') }}"
                    class="whitespace-nowrap pb-3 text-sm font-medium border-b-2 transition-colors flex-shrink-0
                    {{ $isAccountTab
                        ? 'border-gray-900 text-gray-900'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Account
                </a>

            </nav>
        </div>

        {{-- ========================
             MOBILE TOOLBAR
             Hamburger + Back button
        ========================= --}}
        <div class="flex items-center justify-between mb-5 md:hidden">

            {{-- Back button (sub-pages only) --}}
            @if ($backUrl)
                <a href="{{ $backUrl }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Back
                </a>
            @else
                <span></span>
            @endif

            {{-- Hamburger --}}
            <button onclick="openSidebar()"
                class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700
                       bg-white border border-gray-200 rounded-[8px] hover:bg-gray-50 transition shadow-sm">
                <i class="fas fa-bars text-sm"></i>
                Menu
            </button>

        </div>

        {{-- ========================
             DESKTOP BACK BUTTON
        ========================= --}}
        @if ($backUrl)
            <div class="hidden md:block mb-5">
                <a href="{{ $backUrl }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-900 transition">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Back
                </a>
            </div>
        @endif

        {{-- ========================
             SIDEBAR + CONTENT
        ========================= --}}
        <div class="flex gap-10">

            {{-- Desktop Sidebar (hidden on mobile - shown in drawer instead) --}}
            <div class="hidden md:block w-48 flex-shrink-0">
                @include('client.partials.sidebar')
            </div>

            {{-- Main Content --}}
            <main class="flex-1 min-w-0">
                @yield('content')
            </main>

        </div>

    </div>

    {{-- Footer --}}
    @include('frontend.partials.footer')

    {{-- ========================
         PAGE-LEVEL SCRIPTS
    ========================= --}}
    @stack('scripts')

    {{-- ========================
         SIDEBAR TOGGLE SCRIPT
    ========================= --}}
    <script>
        const drawer = document.getElementById('sidebar-drawer');
        const overlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            drawer.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            drawer.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSidebar();
        });
    </script>

    @include('frontend.partials.bottom-nav')
    @include('frontend.partials.cart-runtime')
</body>

</html>
