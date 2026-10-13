{{-- -------------------
     Topbar (Trinity Mabati Factory Admin)
------------------- --}}
@php
    $adminRoutes = [
        ['label' => 'Dashboard', 'group' => 'Overview', 'icon' => 'fa-gauge-high', 'url' => url('/manage/dashboard')],
        ['label' => 'All Products', 'group' => 'Products', 'icon' => 'fa-boxes-stacked', 'url' => url('/manage/products/all')],
        ['label' => 'Add Product', 'group' => 'Products', 'icon' => 'fa-square-plus', 'url' => url('/manage/products/add')],
        ['label' => 'Product Categories', 'group' => 'Products', 'icon' => 'fa-layer-group', 'url' => url('/manage/products/categories')],
        ['label' => 'Brands', 'group' => 'Products', 'icon' => 'fa-tags', 'url' => url('/manage/products/brands')],
        ['label' => 'Orders', 'group' => 'Ecommerce', 'icon' => 'fa-cart-shopping', 'url' => url('/manage/ecommerce/orders')],
        ['label' => 'Customers', 'group' => 'Ecommerce', 'icon' => 'fa-users', 'url' => url('/manage/ecommerce/customers')],
        ['label' => 'Payment Transactions', 'group' => 'Payments', 'icon' => 'fa-credit-card', 'url' => url('/manage/payments/transactions')],
        ['label' => 'Payment Methods', 'group' => 'Payments', 'icon' => 'fa-money-check-dollar', 'url' => url('/manage/payments/methods')],
        ['label' => 'Shipping Settings', 'group' => 'Shipping', 'icon' => 'fa-truck', 'url' => url('/manage/shipping/settings')],
        ['label' => 'Shipping Pricing', 'group' => 'Shipping', 'icon' => 'fa-map-location-dot', 'url' => url('/manage/shipping/pricing')],
        ['label' => 'Site Branding', 'group' => 'Settings', 'icon' => 'fa-palette', 'url' => url('/manage/settings/branding')],
        ['label' => 'Email Settings', 'group' => 'Settings', 'icon' => 'fa-envelope', 'url' => url('/manage/settings/email')],
        ['label' => 'SMS Settings', 'group' => 'Settings', 'icon' => 'fa-comment-sms', 'url' => url('/manage/settings/sms')],
        ['label' => 'Contact & Social Settings', 'group' => 'Settings', 'icon' => 'fa-address-book', 'url' => url('/manage/settings/contact')],
        ['label' => 'Login Security', 'group' => 'Settings', 'icon' => 'fa-shield-halved', 'url' => url('/manage/settings/security')],
        ['label' => 'VAT Settings', 'group' => 'Settings', 'icon' => 'fa-percent', 'url' => url('/manage/settings/vat')],
        ['label' => 'Optimization', 'group' => 'Settings', 'icon' => 'fa-gauge', 'url' => url('/manage/settings/optimization')],
        ['label' => 'Newsletters', 'group' => 'Content', 'icon' => 'fa-envelope-open-text', 'url' => url('/manage/newsletters')],
        ['label' => 'Media Library', 'group' => 'Content', 'icon' => 'fa-photo-film', 'url' => url('/manage/media')],
        ['label' => 'System Users', 'group' => 'System', 'icon' => 'fa-user-gear', 'url' => url('/manage/system-users')],
        ['label' => 'User Permissions', 'group' => 'System', 'icon' => 'fa-key', 'url' => url('/manage/permissions')],
    ];
@endphp
<header class="admin-topbar bg-white text-text border-b border-border px-4 sm:px-6 h-16 flex items-center justify-between gap-3 sm:gap-6">

    {{-- =====================================================
         LEFT SECTION
    ===================================================== --}}
    <div class="flex items-center gap-3 sm:gap-4 min-w-0 flex-1 max-w-5xl">

        {{-- -------------------
             Sidebar Toggle
             Below lg: opens the mobile drawer (always expanded)
             lg+: collapses/expands the desktop sidebar
        ------------------- --}}
        <button @click="window.innerWidth < 1024 ? (collapsed = false, mobileOpen = !mobileOpen) : toggleSidebar()"
            aria-label="Toggle sidebar" class="shrink-0 text-text hover:text-primary transition">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>

        {{-- Search --}}
        <div class="relative w-full min-w-0 max-w-3xl" x-data="{ query: '', open: false, routes: @js($adminRoutes), get results() { const q = this.query.toLowerCase().trim(); return q ? this.routes.filter(item => (item.label + ' ' + item.group).toLowerCase().includes(q)).slice(0, 8) : []; } }" @click.outside="open = false">
            <input type="search" placeholder="Search pages and settings..." x-model="query" @focus="open = true" @input="open = true" @keydown.escape="open = false"
                class="w-full pl-10 pr-4 py-2 rounded-[8px]
                       bg-background text-text placeholder-muted
                       border border-border
                       focus:outline-none focus:ring-2 focus:ring-primary/30">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-muted"></i>
            <div x-show="open && query.length" x-cloak x-transition class="absolute left-0 right-0 top-full z-[300] mt-2 max-h-96 overflow-y-auto rounded-[12px] border border-border bg-white p-2 shadow-2xl">
                <template x-for="item in results" :key="item.url">
                    <a :href="item.url" class="flex items-center gap-3 rounded-[8px] px-3 py-2.5 hover:bg-primary-light transition">
                        <span class="flex h-9 w-9 items-center justify-center rounded-[8px] bg-primary-light text-primary"><i class="fa-solid" :class="item.icon"></i></span>
                        <span class="min-w-0"><strong class="block truncate text-sm text-text" x-text="item.label"></strong><small class="text-xs text-muted" x-text="item.group"></small></span>
                    </a>
                </template>
                <p x-show="results.length === 0" class="px-3 py-4 text-center text-xs text-muted">No matching admin page.</p>
            </div>
        </div>

    </div>

    {{-- =====================================================
         RIGHT SECTION
    ===================================================== --}}
    <div class="flex shrink-0 items-center gap-3 sm:gap-5">

        {{-- ---------------
             Messages - badge shows real unread count
        --------------- --}}
        <a href="{{ route('manage.messages.index') }}" class="relative text-primary hover:text-primary/80 transition">
            <i class="fa-regular fa-envelope text-lg"></i>
            @if ($unreadMessages > 0)
                <span
                    class="absolute -top-1.5 -right-1.5 min-w-[16px] h-4 bg-red-500 rounded-[12px]
                             text-white text-[10px] font-bold flex items-center justify-center px-0.5">
                    {{ $unreadMessages > 99 ? '99+' : $unreadMessages }}
                </span>
            @endif
        </a>

        {{-- -------------------
             USER DROPDOWN
        ------------------- --}}
        <div x-data="{ open: false }" class="relative">

            <button @click="open = !open" class="flex items-center gap-2 text-text hover:text-primary transition">
                <div class="w-8 h-8 rounded-[12px] bg-border flex items-center justify-center">
                    <i class="fa-regular fa-user text-sm"></i>
                </div>
                <span class="hidden md:inline text-sm font-medium">
                    {{ Auth::user()->name ?? 'Admin' }}
                </span>
                <i class="fa-solid fa-chevron-down text-xs text-muted"></i>
            </button>

            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0 mt-2 w-48 bg-background border border-border
                       rounded-[8px] shadow-lg z-50 text-text overflow-hidden">

                <a href="{{ route('manage.system-users.show', Auth::id()) }}"
                    class="block px-4 py-2 hover:bg-border transition text-sm">
                    <i class="fa-regular fa-user w-4 mr-1"></i> Profile
                </a>
                <a href="{{ route('manage.settings.email.index') }}"
                    class="block px-4 py-2 hover:bg-border transition text-sm">
                    <i class="fa-solid fa-sliders w-4 mr-1"></i> Settings
                </a>
                <a href="{{ route('manage.visitors-log.index') }}"
                    class="block px-4 py-2 hover:bg-border transition text-sm">
                    <i class="fa-solid fa-route w-4 mr-1"></i> Visitors Log
                </a>

                <hr class="border-border">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-red-500 hover:bg-border transition text-sm">
                        <i class="fa-solid fa-right-from-bracket w-4 mr-1"></i> Logout
                    </button>
                </form>

            </div>
        </div>

    </div>

</header>
