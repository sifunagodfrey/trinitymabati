{{-- -------------------
     Mobile Bottom Navigation
     App-style sticky tab bar shown on small screens only
------------------- --}}
@php
    $navItem = 'flex flex-col items-center justify-center gap-0.5 flex-1 py-1 text-[10px] font-semibold transition';
    $navActive = 'text-primary';
    $navIdle = 'text-gray-400 hover:text-primary';
@endphp

<nav class="md:hidden fixed bottom-0 inset-x-0 w-full z-50 bg-white border-t border-border shadow-[0_-2px_10px_rgba(0,0,0,0.06)]"
    style="padding-bottom: env(safe-area-inset-bottom);">
    <div class="flex items-stretch h-14">

        {{-- Home --}}
        <a href="{{ route('frontend.home') }}"
            class="{{ $navItem }} {{ request()->routeIs('frontend.home') ? $navActive : $navIdle }}">
            <i class="fas fa-house text-base"></i>
            <span>Home</span>
        </a>

        {{-- Categories --}}
        <a href="{{ route('frontend.categories') }}"
            class="{{ $navItem }} {{ request()->routeIs('frontend.categories', 'frontend.categories.show') ? $navActive : $navIdle }}">
            <i class="fas fa-table-cells-large text-base"></i>
            <span>Categories</span>
        </a>

        {{-- Cart with live badge --}}
        <a href="{{ route('frontend.cart') }}"
            class="{{ $navItem }} {{ request()->routeIs('frontend.cart') ? $navActive : $navIdle }} relative">
            <span class="relative">
                <i class="fas fa-cart-shopping text-base"></i>
                <span data-cart-badge
                    class="absolute -top-1.5 -right-1.5 w-[18px] h-[18px] rounded-[12px] bg-secondary text-white
                             text-[10px] font-bold flex items-center justify-center leading-none"
                    style="display:none;"></span>
            </span>
            <span>Cart</span>
        </a>

        {{-- Wishlist --}}
        <a href="{{ route('client.wishlist.index') }}"
            class="{{ $navItem }} {{ request()->routeIs('client.wishlist.*') ? $navActive : $navIdle }}">
            <i class="fas fa-heart text-base"></i>
            <span>Wishlist</span>
        </a>

        {{-- Account --}}
        <a href="{{ auth()->check() ? route('client.dashboard') : route('login') }}"
            class="{{ $navItem }} {{ request()->routeIs('client.*') && !request()->routeIs('client.wishlist.*') ? $navActive : $navIdle }}">
            <i class="fas fa-user text-base"></i>
            <span>Account</span>
        </a>

    </div>
</nav>

{{-- Spacer so page content is not hidden behind the fixed bar --}}
<div class="md:hidden h-14" aria-hidden="true"></div>
