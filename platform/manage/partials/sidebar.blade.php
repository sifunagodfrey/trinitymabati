{{-- -------------------
     Sidebar (Trinity Mabati Factory Admin)
     UI styled to match the Bootstrap PHP sidebar:
     - White background, gray-200 right border
     - Colored icons per section (primary/warning/danger/success/info/secondary)
     - List-group style items with bottom dividers
     - Gray-50 hover, gray-100 active
     - Chevron-right indicator (rotates on open)
     - Sub-items indented with left border accent
------------------- --}}

@php
    $user = auth()->user();

    $navLink =
        'flex items-center justify-between w-full px-4 py-3 text-sm text-white/75 font-medium hover:bg-white/10 hover:text-white transition-colors';
    $navActive =
        'flex items-center justify-between w-full px-4 py-3 text-sm font-semibold bg-primary text-white';
    $subLink =
        'flex items-center gap-2 px-4 py-2.5 text-sm text-white/65 hover:bg-white/10 hover:text-white transition-colors rounded-[8px]';
@endphp

{{-- -------------------
     Mobile: off-canvas drawer (fixed, slides in via mobileOpen)
     Desktop (lg+): static sidebar, collapsible to icon rail
------------------- --}}
<aside :class="[collapsed ? 'lg:w-16' : 'lg:w-64', mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0']"
    class="admin-sidebar text-white w-64 fixed inset-y-0 left-0 z-[500] lg:static lg:z-40
           transition-all duration-300 h-full lg:h-screen flex flex-col shadow-sm">

    {{-- LOGO --}}
    <div class="h-16 flex items-center justify-center border-b border-white/10 px-3">
        <a href="{{ route('manage.dashboard.index') }}" x-show="!collapsed" class="flex items-center">
            <img src="{{ $branding['logo_white'] }}" alt="{{ config('app.name') }} Admin" class="h-9 w-auto">
        </a>
        <a href="{{ route('manage.dashboard.index') }}" x-show="collapsed">
            <img src="{{ $branding['site_icon'] }}" alt="{{ config('app.name') }} Admin" class="h-8 w-auto">
        </a>
    </div>

    {{-- NAVIGATION --}}
    <nav class="flex-1 overflow-y-auto no-scrollbar py-2">

        {{-- DASHBOARD – always visible --}}
        @php $isDashboard = request()->routeIs('manage.dashboard.*'); @endphp
        <a href="{{ route('manage.dashboard.index') }}" class="{{ $isDashboard ? $navActive : $navLink }}">
            <div class="flex items-center gap-3">
                <i class="fas fa-tachometer-alt w-4 text-primary"></i>
                <span x-show="!collapsed">Dashboard</span>
            </div>
        </a>

        {{-- MESSAGES – permission: send_notifications --}}
        @if ($user->hasPermission('send_notifications'))
            @php $isMessages = request()->routeIs('manage.messages.*'); @endphp
            <a href="{{ route('manage.messages.index') }}" class="{{ $isMessages ? $navActive : $navLink }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-envelope w-4 text-primary"></i>
                    <span x-show="!collapsed">Messages</span>
                </div>
                @if ($unreadMessages > 0)
                    <span
                        class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-[12px] min-w-[18px] text-center"
                        x-show="!collapsed">
                        {{ $unreadMessages > 99 ? '99+' : $unreadMessages }}
                    </span>
                @endif
            </a>
        @endif

        {{-- ECOMMERCE – requires at least one of: view_orders, view_payments, view_invoices, moderate_reviews, view_users, view_reports --}}
        @php
            $ecommercePerms = [
                'view_orders',
                'view_payments',
                'view_invoices',
                'moderate_reviews',
                'view_users',
                'view_reports',
            ];
            $showEcommerce = $user->hasAnyPermission($ecommercePerms);
        @endphp
        @if ($showEcommerce)
            @php $isEcommerce = request()->routeIs('manage.ecommerce.*'); @endphp
            <div x-data="menuState('ecommerce', {{ $isEcommerce ? 'true' : 'false' }})" x-init="init()">
                <button @click="toggle()" class="{{ $isEcommerce ? $navActive : $navLink }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-shopping-cart w-4 text-primary"></i>
                        <span x-show="!collapsed">Ecommerce</span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" x-show="!collapsed"></i>
                </button>
                <div x-show="!collapsed && open" class="bg-gray-50 border-b border-gray-100 pl-4 py-1 space-y-0.5">
                    @if ($user->hasPermission('view_orders'))
                        <a href="{{ route('manage.ecommerce.orders.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-clock w-3.5 text-warning"></i> Orders</a>
                    @endif
                    @if ($user->hasPermission('view_orders') || $user->hasPermission('view_payments'))
                        <a href="{{ route('manage.ecommerce.returns.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-undo-alt w-3.5 text-info"></i> Order Returns</a>
                    @endif
                    @if ($user->hasPermission('view_invoices'))
                        <a href="{{ route('manage.ecommerce.invoices.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-file-invoice w-3.5 text-primary"></i> Invoices</a>
                    @endif
                    @if ($user->hasPermission('moderate_reviews'))
                        <a href="{{ route('manage.ecommerce.reviews.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-star w-3.5 text-warning"></i> Reviews</a>
                    @endif
                    @if ($user->hasPermission('view_users'))
                        <a href="{{ route('manage.ecommerce.customers.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-users w-3.5 text-secondary"></i> Customers</a>
                    @endif
                    @if ($user->hasPermission('view_orders'))
                        <a href="{{ route('manage.ecommerce.abandoned-carts.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-shopping-cart w-3.5 text-info"></i> Abandoned Carts</a>
                    @endif
                    @if ($user->hasPermission('view_reports'))
                        <a href="{{ route('manage.ecommerce.reports.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-chart-line w-3.5 text-primary"></i> Reports</a>
                    @endif
                </div>
            </div>
        @endif

        {{-- PRODUCTS – requires view_products or create_products or manage_categories or view_reports --}}
        @php
            $productsPerms = ['view_products', 'create_products', 'manage_categories', 'view_reports'];
            $showProducts = $user->hasAnyPermission($productsPerms);
        @endphp
        @if ($showProducts)
            @php $isProducts = request()->routeIs('manage.products.*'); @endphp
            <div x-data="menuState('products', {{ $isProducts ? 'true' : 'false' }})" x-init="init()">
                <button @click="toggle()" class="{{ $isProducts ? $navActive : $navLink }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-box-open w-4 text-primary"></i>
                        <span x-show="!collapsed">Products</span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" x-show="!collapsed"></i>
                </button>
                <div x-show="!collapsed && open" class="bg-gray-50 border-b border-gray-100 pl-4 py-1 space-y-0.5">
                    @if ($user->hasPermission('view_products'))
                        <a href="{{ route('manage.products.all.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-boxes w-3.5 text-primary"></i> All Products</a>
                    @endif
                    @if ($user->hasPermission('create_products'))
                        <a href="{{ route('manage.products.add.create') }}" class="{{ $subLink }}"><i
                                class="fas fa-plus-square w-3.5 text-success"></i> Add Product</a>
                    @endif
                    @if ($user->hasPermission('manage_categories'))
                        <a href="{{ route('manage.products.categories.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-th-large w-3.5 text-info"></i> Categories</a>
                        <a href="{{ route('manage.products.brands.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-tags w-3.5 text-warning"></i> Brands</a>
                        <a href="{{ route('manage.products.labels.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-tag w-3.5 text-secondary"></i> Labels</a>
                    @endif
                    @if ($user->hasPermission('view_reports'))
                        <a href="{{ route('manage.products.reports.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-chart-bar w-3.5 text-primary"></i> Reports</a>
                    @endif
                </div>
            </div>
        @endif

        {{-- BLOGS – uses manage_categories as proxy --}}
        @if ($user->hasPermission('manage_categories'))
            @php $isBlogs = request()->routeIs('manage.blogs.*'); @endphp
            <div x-data="menuState('blogs', {{ $isBlogs ? 'true' : 'false' }})" x-init="init()">
                <button @click="toggle()" class="{{ $isBlogs ? $navActive : $navLink }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-blog w-4 text-primary"></i>
                        <span x-show="!collapsed">Blogs</span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" x-show="!collapsed"></i>
                </button>
                <div x-show="!collapsed && open" class="bg-gray-50 border-b border-gray-100 pl-4 py-1 space-y-0.5">
                    <a href="{{ route('manage.blogs.posts.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-pen-nib w-3.5 text-primary"></i> Posts</a>
                    <a href="{{ route('manage.blogs.categories.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-folder-open w-3.5 text-info"></i> Categories</a>
                    <a href="{{ route('manage.blogs.tags.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-tags w-3.5 text-warning"></i> Tags</a>
                </div>
            </div>
        @endif

        {{-- CONTENT – uses manage_categories as proxy --}}
        @if ($user->hasPermission('manage_pages'))
            @php $isContent = (request()->routeIs('manage.content.*')); @endphp
            <div x-data="menuState('content', {{ $isContent ? 'true' : 'false' }})" x-init="init()">
                <button @click="toggle()" class="{{ $isContent ? $navActive : $navLink }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-lines w-4 text-primary"></i>
                        <span x-show="!collapsed">Content</span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" x-show="!collapsed"></i>
                </button>
                <div x-show="!collapsed && open" class="bg-gray-50 border-b border-gray-100 pl-4 py-1 space-y-0.5">
                    {{-- <a href="{{ route('manage.content.banners.index') }}" class="{{ $subLink }}"><i --}}
                            {{-- class="fas fa-image w-3.5 text-warning"></i> Hero Banners</a> --}}
                    <a href="{{ route('manage.content.pages.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-file-alt w-3.5 text-primary"></i> Pages</a>
                    <a href="{{ route('manage.content.faqs.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-circle-question w-3.5 text-info"></i> FAQs</a>
                    <a href="{{ route('manage.content.client-stories.index', 'testimonials') }}" class="{{ $subLink }}"><i class="fas fa-quote-left w-3.5"></i> Client Testimonials</a>
                    <a href="{{ route('manage.content.client-stories.index', 'projects') }}" class="{{ $subLink }}"><i class="fas fa-helmet-safety w-3.5"></i> Client Projects</a>
                </div>
            </div>
        @endif

        {{-- PAYMENTS – requires view_payments --}}
        @if ($user->hasPermission('view_payments'))
            @php $isPayments = request()->routeIs('manage.payments.*'); @endphp
            <div x-data="menuState('payments', {{ $isPayments ? 'true' : 'false' }})" x-init="init()">
                <button @click="toggle()" class="{{ $isPayments ? $navActive : $navLink }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-credit-card w-4 text-primary"></i>
                        <span x-show="!collapsed">Payments</span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" x-show="!collapsed"></i>
                </button>
                <div x-show="!collapsed && open" class="bg-gray-50 border-b border-gray-100 pl-4 py-1 space-y-0.5">
                    <a href="{{ route('manage.payments.transactions.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-exchange-alt w-3.5 text-success"></i> Transactions</a>
                    <a href="{{ route('manage.payments.logs.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-file-alt w-3.5 text-warning"></i> Payment Logs</a>
                    <a href="{{ route('manage.payments.methods.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-money-check-alt w-3.5 text-info"></i> Payment Methods</a>
                </div>
            </div>
        @endif

        {{-- QUOTATIONS – requires manage_quotations or view_quotations --}}
        @if ($user->hasAnyPermission(['manage_quotations', 'view_quotations']))
            @php $isQuotations = request()->routeIs('manage.quotations.*'); @endphp
            <a href="{{ route('manage.quotations.index') }}" class="{{ $isQuotations ? $navActive : $navLink }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-invoice-dollar w-4 text-primary"></i>
                    <span x-show="!collapsed">Quotations</span>
                </div>
            </a>
        @endif

        {{-- SHIPPING – requires shipping_settings or location_pricing --}}
        @php
            $shippingPerms = ['shipping_settings', 'location_pricing'];
            $showShipping = $user->hasAnyPermission($shippingPerms);
        @endphp
        @if ($showShipping)
            @php $isShipping = request()->routeIs('manage.shipping.*'); @endphp
            <div x-data="menuState('shipping', {{ $isShipping ? 'true' : 'false' }})" x-init="init()">
                <button @click="toggle()" class="{{ $isShipping ? $navActive : $navLink }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-truck w-4 text-primary"></i>
                        <span x-show="!collapsed">Shipping</span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" x-show="!collapsed"></i>
                </button>
                <div x-show="!collapsed && open" class="bg-gray-50 border-b border-gray-100 pl-4 py-1 space-y-0.5">
                    @if ($user->hasPermission('shipping_settings'))
                        <a href="{{ route('manage.shipping.settings.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-cogs w-3.5 text-secondary"></i> Shipping Settings</a>
                    @endif
                    @if ($user->hasPermission('location_pricing'))
                        <a href="{{ route('manage.shipping.pricing.index') }}" class="{{ $subLink }}"><i
                                class="fas fa-map-marked-alt w-3.5 text-info"></i> Location Pricing</a>
                    @endif
                </div>
            </div>
        @endif

        {{-- NEWSLETTERS – requires newsletters --}}
        @if ($user->hasPermission('newsletters'))
            @php $isNewsletters = request()->routeIs('manage.newsletters.*'); @endphp
            <a href="{{ route('manage.newsletters.index') }}" class="{{ $isNewsletters ? $navActive : $navLink }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-envelope-open-text w-4 text-primary"></i>
                    <span x-show="!collapsed">Newsletters</span>
                </div>
            </a>
        @endif

        {{-- MEDIA – requires media --}}
        @if ($user->hasPermission('media'))
            @php $isMedia = request()->routeIs('manage.media.*'); @endphp
            <a href="{{ route('manage.media.index') }}" class="{{ $isMedia ? $navActive : $navLink }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-photo-video w-4 text-primary"></i>
                    <span x-show="!collapsed">Media</span>
                </div>
            </a>
        @endif

        {{-- SETTINGS – requires manage_settings --}}
        @if ($user->hasPermission('manage_settings'))
            @php $isSettings = request()->routeIs('manage.settings.*'); @endphp
            <div x-data="menuState('settings', {{ $isSettings ? 'true' : 'false' }})" x-init="init()">
                <button @click="toggle()" class="{{ $isSettings ? $navActive : $navLink }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-cog w-4 text-primary"></i>
                        <span x-show="!collapsed">Settings</span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" x-show="!collapsed"></i>
                </button>
                <div x-show="!collapsed && open" class="bg-gray-50 border-b border-gray-100 pl-4 py-1 space-y-0.5">
                    <a href="{{ route('manage.settings.branding.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-palette w-3.5 text-primary"></i> Site Branding</a>
                    <a href="{{ route('manage.settings.email.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-envelope w-3.5 text-primary"></i> Email Settings</a>
                    <a href="{{ route('manage.settings.sms.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-comment-sms w-3.5 text-secondary"></i> SMS Settings</a>
                    <a href="{{ route('manage.settings.contact.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-address-book w-3.5 text-success"></i> Contact &amp; Social</a>
                    <a href="{{ route('manage.settings.security.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-shield-halved w-3.5 text-primary"></i> Login Security</a>
                    <a href="{{ route('manage.settings.optimization.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-tachometer-alt w-3.5 text-success"></i> Optimization</a>
                    <a href="{{ route('manage.settings.vat.index') }}" class="{{ $subLink }}"><i
                            class="fas fa-percent w-3.5 text-warning"></i> VAT Settings</a>
                </div>
            </div>
        @endif

        {{-- VISITORS LOG – uses view_system_logs as proxy --}}
        @if ($user->hasPermission('view_system_logs'))
            @php $isVisitors = request()->routeIs('manage.visitors-log.*'); @endphp
            <a href="{{ route('manage.visitors-log.index') }}" class="{{ $isVisitors ? $navActive : $navLink }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-route w-4 text-primary"></i>
                    <span x-show="!collapsed">Visitors Log</span>
                </div>
            </a>
        @endif

        {{-- SYSTEM USERS – uses view_users as proxy --}}
        @if ($user->hasPermission('view_users'))
            @php $isSystemUsers = request()->routeIs('manage.system-users.*'); @endphp
            <a href="{{ route('manage.system-users.index') }}"
                class="{{ $isSystemUsers ? $navActive : $navLink }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-users w-4 text-primary"></i>
                    <span x-show="!collapsed">System Users</span>
                </div>
            </a>
        @endif

        {{-- PERMISSIONS – requires user_permissions --}}
        @if ($user->hasPermission('user_permissions'))
            @php $isPermissions = request()->routeIs('manage.permissions.*'); @endphp
            <a href="{{ route('manage.permissions.index') }}"
                class="{{ $isPermissions ? $navActive : $navLink }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-key w-4 text-primary"></i>
                    <span x-show="!collapsed">User Permissions</span>
                </div>
            </a>
        @endif

        {{-- CONTACT – requires contact_us --}}
        @if ($user->hasPermission('contact_us'))
            @php $isContact = request()->routeIs('manage.contact.*'); @endphp
            <a href="{{ route('manage.contact.index') }}" class="{{ $isContact ? $navActive : $navLink }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-envelope w-4 text-primary"></i>
                    <span x-show="!collapsed">Contact</span>
                </div>
            </a>
        @endif

    </nav>

    {{-- LOGOUT --}}
    <div class="border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-3 text-sm font-medium text-danger hover:bg-red-50 transition-colors">
                <i class="fas fa-sign-out-alt w-4 text-danger"></i>
                <span x-show="!collapsed">Logout</span>
            </button>
        </form>
    </div>

</aside>
