@php
    // ---------------
    // Hide these top-level categories from the storefront header menu.
    // They remain available on the /categories pages and in the admin.
    // ---------------
    $excludedSlugs = ['industrial-sheets', 'roofing-accessories', 'uncategorized'];

    $menuParents = collect($parentCategories ?? [])
        ->reject(fn ($category) => in_array($category->slug, $excludedSlugs, true))
        ->values();

    $childGroups = $menuParents->isNotEmpty()
        ? \Illuminate\Support\Facades\DB::table('su_product_categories')
            ->whereIn('parent_id', $menuParents->pluck('id')->all())
            ->orderBy('name')->get()->groupBy('parent_id')
        : collect();
@endphp

<header x-data="{ mobileOpen: false, mobileSubmenu: null, desktopMenu: null, searchOpen: false, searchTrigger: null, q: '', results: [], loading: false, searchError: false, searchErrorMessage: '', searchTimer: null, searchController: null, searchVersion: 0,
    openSearch(trigger = null) { this.searchTrigger = trigger || this.$refs.searchToggle; this.mobileOpen = false; this.searchOpen = true; this.headerVisible = true; this.desktopMenu = null; this.$dispatch('storefront-search-state', { open: true }); this.$nextTick(() => this.$refs.searchInput.focus()); this.scheduleSearch(); },
    closeSearch(restoreFocus = false) { this.searchOpen = false; clearTimeout(this.searchTimer); this.searchController?.abort(); this.searchVersion++; this.loading = false; this.$dispatch('storefront-search-state', { open: false }); if (restoreFocus) (this.searchTrigger || this.$refs.searchToggle)?.focus(); },
    scheduleSearch() { clearTimeout(this.searchTimer); this.searchController?.abort(); const version = ++this.searchVersion; this.results = []; this.loading = false; this.searchError = false; this.searchErrorMessage = ''; if (!this.q.trim()) return; this.loading = true; this.searchTimer = setTimeout(() => this.loadSearch(version), 200); },
    async loadSearch(version) { const controller = new AbortController(); this.searchController = controller; try { const url = new URL(this.$root.dataset.suggestionsUrl, window.location.origin); url.searchParams.set('q', this.q.trim()); const response = await fetch(url, { signal: controller.signal, headers: { Accept: 'application/json' } }); if (!response.ok) throw new Error('HTTP ' + response.status); if (!response.headers.get('content-type')?.includes('application/json')) throw new Error('Unexpected server response'); const data = await response.json(); if (!Array.isArray(data)) throw new Error('Unexpected product data'); if (version === this.searchVersion) this.results = Array.isArray(data) ? data.slice(0, 10) : []; } catch (error) { if (error.name !== 'AbortError' && version === this.searchVersion) { this.searchError = true; this.searchErrorMessage = 'Search is temporarily unavailable (' + error.message + '). Please try again.'; console.error('Product search failed:', error); } } finally { if (version === this.searchVersion) this.loading = false; } },
    destroy() { clearTimeout(this.searchTimer); this.searchController?.abort(); },
    headerVisible: true, lastScrollY: 0, onScroll() { const y = window.scrollY || 0; if (this.mobileOpen || this.searchOpen || y < 90) { this.headerVisible = true; } else if (Math.abs(y - this.lastScrollY) > 5) { this.headerVisible = y < this.lastScrollY; } this.lastScrollY = y; } }" @storefront-search-toggle.window="searchOpen ? closeSearch(true) : openSearch($event.detail.trigger)" @scroll.window.throttle.50ms="onScroll()" @keydown.escape.window="mobileOpen = false; desktopMenu = null; if (searchOpen) closeSearch(true)" @click.outside="if (searchOpen) closeSearch()" data-suggestions-url="{{ route('frontend.search.suggestions') }}" :class="headerVisible ? 'translate-y-0' : '-translate-y-full'" class="sticky top-0 z-50 border-b border-gray-100 bg-white transition-transform duration-200 ease-out">
    <div class="mx-auto grid min-h-[88px] max-w-7xl grid-cols-[44px_minmax(0,1fr)_44px] sm:grid-cols-[44px_minmax(0,1fr)_auto] items-center gap-2 px-4 sm:px-6 lg:flex lg:min-h-[96px] lg:justify-between lg:gap-4 lg:px-8 xl:gap-6">
        <button type="button" @click="closeSearch(); mobileOpen = true" class="flex h-11 w-11 items-center justify-center text-gray-800 lg:hidden" aria-label="Open navigation" :aria-expanded="mobileOpen"><i class="fas fa-bars text-xl" aria-hidden="true"></i></button>
        <a href="{{ route('frontend.home') }}" class="min-w-0 justify-self-center lg:shrink-0" aria-label="Trinity Mabati Factory home">
            <img src="{{ $branding['logo_main'] }}" alt="Trinity Mabati Factory" class="mx-auto h-14 w-auto max-w-full object-contain sm:h-16 sm:max-w-[190px] lg:mx-0 lg:h-[72px] lg:max-w-[210px]" />
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

        <div class="flex shrink-0 items-center justify-self-end gap-2 lg:gap-4">
            <button type="button" x-ref="searchToggle" @click="searchOpen ? closeSearch(true) : openSearch($el)" class="hidden h-11 w-11 sm:inline-flex items-center justify-center text-gray-800 hover:text-primary" aria-label="Search products" aria-controls="header-product-search" :aria-expanded="searchOpen">
                <i class="fas fa-search text-lg" aria-hidden="true"></i>
            </button>
            <a href="{{ route('frontend.cart') }}" class="relative inline-flex h-11 w-11 items-center justify-center text-gray-800 hover:text-primary" aria-label="Shopping cart">
                <i class="fas fa-shopping-cart text-lg" aria-hidden="true"></i>
                <span data-cart-badge class="absolute right-0 top-0 flex h-[18px] w-[18px] items-center justify-center rounded-full bg-primary text-[10px] font-semibold text-white" style="display:none"></span>
            </a>
            <a href="{{ route('frontend.quotation.index') }}" class="hidden whitespace-nowrap rounded-lg bg-primary px-4 py-3 text-sm font-bold text-white transition hover:opacity-90 sm:inline-flex">Get a Quote</a>
        </div>
    </div>

    <div id="header-product-search" x-show="searchOpen" x-cloak x-transition.opacity class="absolute inset-x-0 top-full z-[80] border-t border-gray-100 bg-background shadow-xl" role="search" aria-label="Product search">
        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
            <form action="{{ route('frontend.search') }}" method="GET" class="flex items-center gap-3">
                <div class="relative min-w-0 flex-1">
                    <label for="header-search-query" class="sr-only">Search roofing products</label>
                    <i class="fas fa-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" aria-hidden="true"></i>
                    <input id="header-search-query" type="search" name="q" x-ref="searchInput" x-model="q" @input="scheduleSearch()" placeholder="Search roofing products…" autocomplete="off" class="w-full rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-4 text-base text-gray-900 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" aria-controls="header-search-results">
                </div>
                <button type="submit" class="hidden rounded-lg bg-primary px-5 py-3 font-semibold text-white sm:inline-flex">Search</button>
                <button type="button" @click="closeSearch(true)" class="inline-flex h-11 w-11 shrink-0 items-center justify-center text-gray-600 hover:text-primary" aria-label="Close search"><i class="fas fa-times text-lg" aria-hidden="true"></i></button>
            </form>
            <div class="mt-4 text-sm text-gray-500" role="status" aria-live="polite">
                <p x-show="loading">Searching products…</p>
                <p x-show="!loading && searchError" x-text="searchErrorMessage"></p>
                <p x-show="q.trim() && !loading && !searchError && results.length === 0">No products found. Try a different search.</p>
                <p x-show="!loading && !searchError && results.length > 0" x-text="q.trim() ? results.length + (results.length === 1 ? ' matching product' : ' matching products') : 'Browse products or type to narrow your search'"></p>
            </div>
            <div id="header-search-results" class="mt-2 max-h-[55vh] overflow-y-auto divide-y divide-gray-100" :aria-busy="loading">
                <template x-for="item in results" :key="item.id">
                    <a :href="item.url" class="flex items-center gap-3 rounded-md px-2 py-3 transition hover:bg-red-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-md bg-gray-100">
                            <template x-if="item.thumb"><img :src="item.thumb" :alt="item.name" class="h-full w-full object-cover" loading="lazy"></template>
                            <i x-show="!item.thumb" class="fas fa-box-open text-gray-400" aria-hidden="true"></i>
                        </span>
                        <span class="min-w-0 flex-1"><span class="block text-sm font-semibold text-gray-900" x-text="item.name"></span><span class="block text-xs text-gray-500" x-text="item.category"></span></span>
                        <span class="shrink-0 text-right text-xs font-semibold text-primary sm:text-sm" x-text="item.price_display"></span>
                    </a>
                </template>
            </div>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="mobileOpen" x-cloak class="fixed inset-0 z-[100] lg:hidden" role="dialog" aria-modal="true" aria-label="Mobile navigation">
            <div class="absolute inset-0 bg-black/50" @click="mobileOpen = false"></div>
            <aside class="absolute left-0 top-0 flex h-full w-[min(88vw,360px)] flex-col overflow-hidden rounded-none bg-white shadow-2xl" x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-5">
                    <img src="{{ $branding['logo_main'] }}" alt="Trinity Mabati Factory" class="h-14 w-auto max-w-[200px] object-contain" />
                    <button type="button" @click="mobileOpen = false" aria-label="Close navigation" class="rounded p-2 text-gray-800"><i class="fas fa-times text-lg"></i></button>
                </div>
                <nav class="min-h-0 flex-1 overflow-y-auto overscroll-contain px-4 py-2" aria-label="Mobile main navigation">
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
                    <a href="{{ route('frontend.cart') }}" class="flex items-center justify-between gap-3 border-b border-gray-100 py-3 text-sm font-semibold text-gray-800">
                        <span><i class="fas fa-shopping-cart mr-2 text-primary" aria-hidden="true"></i>Shopping Cart</span>
                        <span class="inline-flex min-w-6 items-center justify-center rounded-full bg-primary px-2 py-0.5 text-xs font-semibold text-white"
                            x-text="$store.cart?.count ?? window.__cartCount ?? 0" aria-label="Items in cart">0</span>
                    </a>
                </nav>
                <div class="shrink-0 space-y-3 border-t border-gray-100 p-5">
                    @auth
                        <a href="{{ route('client.dashboard') }}" class="flex items-center justify-center gap-2 rounded-lg border border-primary px-5 py-3 text-sm font-semibold text-primary hover:bg-primary/5"><i class="fas fa-user" aria-hidden="true"></i>My Account</a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 rounded-lg border border-primary px-5 py-3 text-sm font-semibold text-primary hover:bg-primary/5"><i class="fas fa-sign-in-alt" aria-hidden="true"></i>Login</a>
                    @endauth
                    <a href="{{ route('frontend.quotation.index') }}" class="block bg-primary px-5 py-3 text-center text-sm font-bold text-white">Get a Quote</a>
                </div>
            </aside>
        </div>
    </template>
</header>