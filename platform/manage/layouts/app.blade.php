{{-- -------------------
     App Layout (Trinity Mabati Factory Admin)
------------------- --}}
<!DOCTYPE html>
<html lang="en" x-data="layout()" x-init="init()" :class="{ 'dark': darkMode }">

<head>
    {{-- -------------------
         Meta
    ------------------- --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- -------------------
         Title
    ------------------- --}}
    <title>@yield('title', config('app.name') . ' Admin')</title>
    {{-- Favicon --}}
    <link rel="icon" href="{{ $branding['site_icon'] }}">
    <link rel="apple-touch-icon" href="{{ $branding['apple_touch_icon'] }}">
    {{-- -------------------
         Assets (CSS + JS via Vite)
    ------------------- --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.branding')
    {{-- -------------------
         Page Level Styles (Optional)
    ------------------- --}}
    @stack('styles')
</head>

<body class="bg-background text-text overflow-hidden transition-colors duration-300">
    {{-- =========================
         MAIN APP WRAPPER
    ========================= --}}
    <div class="h-screen h-dvh flex" x-data="{ mobileOpen: false }" @keydown.escape.window="mobileOpen = false">
        {{-- -------------------
             Mobile Drawer Backdrop (below lg only)
        ------------------- --}}
        <div x-show="mobileOpen" x-cloak x-transition.opacity @click="mobileOpen = false"
            class="fixed inset-0 z-[450] bg-black/50 lg:hidden"></div>
        {{-- =========================
             SIDEBAR
        ========================= --}}
        <aside class="h-full">
            @include('manage.partials.sidebar')
        </aside>
        {{-- =========================
             MAIN AREA
        ========================= --}}
        <div class="flex-1 min-w-0 flex flex-col h-full">
            {{-- -------------------
                 TOPBAR
            ------------------- --}}
            <div class="shrink-0">
                @include('manage.partials.topbar')
            </div>
            {{-- -------------------
                 CONTENT
            ------------------- --}}
            <main class="admin-main relative flex-1 overflow-y-auto p-4 sm:p-6 no-scrollbar bg-background">
                {{-- =========================
                     PAGE LOADER (content area only)
                ========================= --}}
                <div id="page-loader"
                    class="absolute inset-0 z-[999] flex items-center justify-center
                           bg-background/80 dark:bg-gray-900/80 backdrop-blur-sm
                           transition-opacity duration-300">
                    <div class="w-10 h-10 rounded-[12px] border-4 border-primary/20 border-t-primary animate-spin"></div>
                </div>
                @yield('content')
            </main>
        </div>
    </div>
    {{-- =========================
         GLOBAL SCRIPTS (STACK)
    ========================= --}}
    @stack('scripts')
    {{-- =========================
         PREDICTIVE SEARCH (global)
    ========================= --}}
    @include('manage.partials.searchable')
    {{-- =========================
         PAGE LOADER SCRIPT
    ========================= --}}
    <script>
        const loader = document.getElementById('page-loader');
        // Hide loader when page is fully loaded
        window.addEventListener('load', () => {
            loader.style.opacity = '0';
            loader.style.pointerEvents = 'none';
            setTimeout(() => loader.style.display = 'none', 300);
        });
        // Show loader on every navigable link click
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (
                link &&
                link.href &&
                !link.href.startsWith('#') &&
                !link.href.startsWith('javascript') &&
                link.target !== '_blank'
            ) {
                loader.style.display = 'flex';
                loader.style.opacity = '1';
            }
        });
        // Show loader on form submit
        document.addEventListener('submit', () => {
            loader.style.display = 'flex';
            loader.style.opacity = '1';
        });
    </script>
</body>

</html>
