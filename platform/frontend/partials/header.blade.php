@php
    $menuParents = collect($parentCategories ?? []);
    $childGroups = $menuParents->isNotEmpty()
        ? \Illuminate\Support\Facades\DB::table('su_product_categories')
            ->whereIn('parent_id', $menuParents->pluck('id')->all())
            ->orderBy('name')->get()->groupBy('parent_id')
        : collect();
@endphp
<header x-data="{ mobileOpen: false, mobileSubmenu: null, desktopMenu: null, headerVisible: true, lastScrollY: 0, onScroll() { const y = window.scrollY || 0; if (this.mobileOpen || y < 90) { this.headerVisible = true; } else if (Math.abs(y - this.lastScrollY) > 5) { this.headerVisible = y < this.lastScrollY; } this.lastScrollY = y; } }" @scroll.window.throttle.50ms="onScroll()" @keydown.escape.window="mobileOpen = false; desktopMenu = null" :class="headerVisible ? 'translate-y-0' : '-translate-y-full'" class="sticky top-0 z-50 border-b border-gray-100 bg-white transition-transform duration-200 ease-out">
    <div class="mx-auto grid min-h-[76px] max-w-7xl grid-cols-[44px_minmax(0,1fr)_44px] items-center gap-2 px-4 sm:px-6 lg:flex lg:min-h-[82px] lg:justify-between lg:gap-4 lg:px-8 xl:gap-6">
        <button type="button" @click="mobileOpen = true" class="flex h-11 w-11 items-center justify-center text-gray-800 lg:hidden" aria-label="Open navigation" :aria-expanded="mobileOpen"><i class="fas fa-bars text-xl" aria-hidden="true"></i></button>
        <a href="{{ route('frontend.home') }}" class="min-w-0 justify-self-center lg:shrink-0" aria-label="Trinity Mabati Factory home">
            <img src="{{ $branding['logo_main'] }}" alt="Trinity Mabati Factory" class="mx-auto h-9 w-auto max-w-[165px] object-contain sm:h-11 lg:mx-0 lg:h-12" />
        </a>

        <nav class="hidden min-w-0 flex-1 items-center justify-center gap-x-3 xl:gap-x-5 lg:flex" aria-label="Main navigation">
            @foreach ($menuParents as $category)
                @php $children = $childGroups->get($category->id, collect()); @endphp
                <div class="relative flex shrink-0 items-center gap-1" @mouseenter="desktopMenu = {{ (int)$category->id }}" @mouseleave="desktopMenu = null">
                    <a href="{{ route('frontend.categories.show', $category->slug) }}" class="border-b py-4 text-sm font-semibold transition hover:text-primary {{ request()->routeIs('frontend.categories.show') && in_array(request()->route('slug'), array_merge([$category->slug], $children->pluck('slug')->all())) ? 'border-primary text-primary' : 'border-transparent text-gray-800' }}">{{ $category->name }}</a>
                    @if ($children->isNotEmpty())
                        <button type="button" @click="desktopMenu = desktopMenu === {{ (int)$category->id }} ? null : {{ (int)$category->id }}" :aria-expanded="desktopMenu === {{ (int)$category->id }}" aria-label="Toggle {{ $category->name }} subcategories" class="p-1 text-gray-600 hover:text-primary"><i class="fas fa-chevron-down text-[10px]" aria-hidden="true"></i></button>
                        <div x-cloak x-show="desktopMenu === {{ (int)$category->id }}" x-transition.opacity @click.outside="desktopMenu = null" class="absolute left-0 top-full z-[70] w-64 overflow-hidden border border-gray-100 bg-white py-2 shadow-xl">
                            @foreach ($children as $child)
                                <a href="{{ route('frontend.categories.show', $child->slug) }}" class="block px-4 py-2.5 text-sm text-gray-800 hover:bg-red-50 hover:text-primary">{{ $child->name }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            <a href="{{ route('frontend.about') }}" class="shrink-0 border-b py-4 text-sm font-semibold transition hover:text-primary {{ request()->routeIs('frontend.about') ? 'border-primary text-primary' : 'border-transparent text-gray-800' }}">About Us</a>
            <a href="{{ route('frontend.contact') }}" class="shrink-0 border-b py-4 text-sm font-semibold transition hover:text-primary {{ request()->routeIs('frontend.contact') ? 'border-primary text-primary' : 'border-transparent text-gray-800' }}">Contact Us</a>
        </nav>

        <div class="flex shrink-0 items-center justify-self-end gap-3 lg:gap-4">
            <a href="{{ route('frontend.cart') }}" class="relative inline-flex h-11 w-11 items-center justify-center text-gray-800 hover:text-primary" aria-label="Shopping cart">
                <i class="fas fa-shopping-cart text-lg" aria-hidden="true"></i>
                <span data-cart-badge class="absolute right-0 top-0 flex h-[18px] w-[18px] items-center justify-center rounded-full bg-primary text-[10px] font-semibold text-white" style="display:none"></span>
            </a>
            <a href="{{ route('frontend.quotation.index') }}" class="hidden whitespace-nowrap rounded-lg bg-primary px-4 py-3 text-sm font-bold text-white transition hover:opacity-90 sm:inline-flex">Get a Quote</a>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="mobileOpen" x-cloak class="fixed inset-0 z-[100] lg:hidden" role="dialog" aria-modal="true" aria-label="Mobile navigation">
            <div class="absolute inset-0 bg-black/50" @click="mobileOpen = false"></div>
            <aside class="absolute left-0 top-0 flex h-full w-[min(88vw,360px)] flex-col overflow-hidden rounded-none bg-white shadow-2xl" x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-5">
                    <img src="{{ $branding['logo_main'] }}" alt="Trinity Mabati Factory" class="h-9 w-auto" />
                    <button type="button" @click="mobileOpen = false" aria-label="Close navigation" class="rounded p-2 text-gray-800"><i class="fas fa-times text-lg"></i></button>
                </div>
                <nav class="min-h-0 flex-1 overflow-hidden px-4 py-2" aria-label="Mobile main navigation">
                    @foreach ($menuParents as $category)
                        @php $children = $childGroups->get($category->id, collect()); @endphp
                        <div class="border-b border-gray-100">
                            <div class="flex items-center justify-between gap-2">
                                <a href="{{ route('frontend.categories.show', $category->slug) }}" class="flex-1 py-3 text-sm font-semibold text-gray-800">{{ $category->name }}</a>
                                @if ($children->isNotEmpty())
                                    <button type="button" @click="mobileSubmenu = mobileSubmenu === {{ (int)$category->id }} ? null : {{ (int)$category->id }}" :aria-expanded="mobileSubmenu === {{ (int)$category->id }}" aria-label="Show {{ $category->name }} subcategories" class="rounded p-3 text-gray-700"><i class="fas fa-chevron-down text-xs" :class="mobileSubmenu === {{ (int)$category->id }} ? 'rotate-180' : ''"></i></button>
                                @endif
                            </div>
                            @if ($children->isNotEmpty())
                                <div x-show="mobileSubmenu === {{ (int)$category->id }}" x-cloak class="space-y-1 pb-3 pl-4">
                                    @foreach ($children as $child)
                                        <a class="block px-3 py-2 text-sm text-gray-600 hover:bg-red-50 hover:text-primary" href="{{ route('frontend.categories.show', $child->slug) }}">{{ $child->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                    <a href="{{ route('frontend.about') }}" class="block border-b border-gray-100 py-3 text-sm font-semibold text-gray-800">About Us</a>
                    <a href="{{ route('frontend.contact') }}" class="block border-b border-gray-100 py-3 text-sm font-semibold text-gray-800">Contact Us</a>
                    <a href="{{ route('frontend.cart') }}" class="block border-b border-gray-100 py-3 text-sm font-semibold text-gray-800">Cart</a>
                </nav>
                <div class="border-t border-gray-100 p-5"><a href="{{ route('frontend.quotation.index') }}" class="block bg-primary px-5 py-3 text-center text-sm font-bold text-white">Get a Quote</a></div>
            </aside>
        </div>
    </template>
</header>
