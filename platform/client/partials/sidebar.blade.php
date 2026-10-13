{{-- -------------------
     Client Sidebar
     Rendered in both desktop inline & mobile drawer
------------------- --}}

<aside class="w-full">

    @php
        $isDashboard =
            request()->routeIs('client.dashboard') ||
            request()->routeIs('client.orders.*') ||
            request()->routeIs('client.address.*') ||
            request()->routeIs('client.wishlist.*');

        $isMessages = request()->routeIs('client.inbox.*');

        $isAccount = request()->routeIs('client.settings.*') || request()->routeIs('client.newsletter.*');

    @endphp

    {{-- ========================
         DASHBOARD SIDEBAR
    ========================= --}}
    @if ($isDashboard)
        <nav class="space-y-0.5">
            @php
                $links = [
                    [
                        'route' => 'client.dashboard',
                        'pattern' => 'client.dashboard',
                        'label' => 'Summary',
                        'icon' => 'fa-th-large',
                    ],
                    [
                        'route' => 'client.orders.index',
                        'pattern' => 'client.orders.*',
                        'label' => 'Orders',
                        'icon' => 'fa-shopping-bag',
                    ],
                    [
                        'route' => 'client.address.index',
                        'pattern' => 'client.address.*',
                        'label' => 'Addresses',
                        'icon' => 'fa-map-marker-alt',
                    ],
                    [
                        'route' => 'client.wishlist.index',
                        'pattern' => 'client.wishlist.*',
                        'label' => 'Wishlist',
                        'icon' => 'fa-heart',
                    ],
                ];
            @endphp

            @foreach ($links as $link)
                @php $active = request()->routeIs($link['pattern']); @endphp
                <a href="{{ route($link['route']) }}" onclick="closeSidebar()"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-sm transition-colors
                    {{ $active
                        ? 'bg-gray-100 font-bold text-gray-900'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <i
                        class="fas {{ $link['icon'] }} w-4 text-center
                        {{ $active ? 'text-gray-900' : 'text-gray-400' }}"></i>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- ========================
         MESSAGES SIDEBAR
    ========================= --}}
    @elseif($isMessages)
        <nav class="space-y-0.5">
            @php
                $links = [
                    [
                        'route' => 'client.inbox.index',
                        'pattern' => 'client.inbox.*',
                        'label' => 'Inbox',
                        'icon' => 'fa-envelope',
                    ],
                ];
            @endphp

            @foreach ($links as $link)
                @php $active = $link['pattern'] && request()->routeIs($link['pattern']); @endphp
                <a href="{{ route($link['route']) }}" onclick="closeSidebar()"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-sm transition-colors
                    {{ $active
                        ? 'bg-gray-100 font-bold text-gray-900'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <i
                        class="fas {{ $link['icon'] }} w-4 text-center
                        {{ $active ? 'text-gray-900' : 'text-gray-400' }}"></i>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- ========================
         ACCOUNT SIDEBAR
    ========================= --}}
    @elseif($isAccount)
        <nav class="space-y-0.5">
            @php
                $links = [
                    [
                        'route' => 'client.settings.account',
                        'pattern' => 'client.settings.account',
                        'label' => 'Account Settings',
                        'icon' => 'fa-user-cog',
                    ],
                    [
                        'route' => 'client.settings.payment',
                        'pattern' => 'client.settings.payment',
                        'label' => 'Payment Settings',
                        'icon' => 'fa-credit-card',
                    ],
                    [
                        'route' => 'client.newsletter.index',
                        'pattern' => 'client.newsletter.*',
                        'label' => 'Newsletter',
                        'icon' => 'fa-envelope-open-text',
                    ],
                ];
            @endphp

            @foreach ($links as $link)
                @php $active = request()->routeIs($link['pattern']); @endphp
                <a href="{{ route($link['route']) }}" onclick="closeSidebar()"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-sm transition-colors
                    {{ $active
                        ? 'bg-gray-100 font-bold text-gray-900'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <i
                        class="fas {{ $link['icon'] }} w-4 text-center
                        {{ $active ? 'text-gray-900' : 'text-gray-400' }}"></i>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

    @endif

</aside>
