<header x-data="siteHeader()" x-init="init()" @keydown.escape.window="sugOpen = false; mobileOpen = false"
    class="relative z-50 bg-white">

    {{-- Logo, search and account actions --}}
    <div class="border-b border-border">
        <div class="mx-auto grid h-14 max-w-[1440px] grid-cols-[auto_1fr_auto] items-center px-4 lg:flex lg:h-[86px] lg:gap-7 lg:px-20">

            {{-- Mobile/tablet: hamburger on the left --}}
            <button @click="mobileOpen = true" class="text-primary transition hover:text-secondary lg:hidden" aria-label="Open menu">
                <i class="fas fa-bars text-xl"></i>
            </button>

            {{-- Logo: true-centered on mobile/tablet via grid, left-aligned on desktop --}}
            <a href="{{ route('frontend.home') }}" class="col-start-2 flex shrink-0 items-center justify-self-center lg:col-auto lg:justify-self-auto">
                <img src="{{ $branding['logo_main'] }}" alt="{{ config('app.name') }}" class="h-9 w-auto lg:h-11">
            </a>

            {{-- Desktop search bar (unchanged) --}}
            <div class="relative mx-auto hidden max-w-2xl flex-1 md:block" @click.outside="sugOpen = false">
                <form action="{{ route('frontend.search') }}" method="GET" @submit="sugOpen = false"
                    class="flex h-12 items-center overflow-hidden rounded-[12px] bg-background ring-1 ring-border focus-within:ring-2 focus-within:ring-primary/30">
                    <input type="text" name="q" x-model="q" @input="fetchSuggestions()"
                        placeholder="Search products, brands or categories..." autocomplete="off"
                        class="min-w-0 flex-1 border-0 bg-transparent px-6 text-sm text-text outline-none focus:ring-0">
                    <button type="submit" aria-label="Search" class="flex h-12 w-14 items-center justify-center text-primary transition hover:text-secondary">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                </form>
                @include('frontend.partials.search-suggestions')
            </div>

            {{-- Right side: full icon set on desktop, just cart on mobile/tablet --}}
            <div class="col-start-3 flex shrink-0 items-center justify-end gap-4 text-text lg:col-auto lg:ml-auto">
                @auth
                    <div class="relative hidden sm:block" x-data="{ accountOpen: false }" @click.away="accountOpen = false">
                        <button @click="accountOpen = !accountOpen" class="group flex items-center gap-2 text-sm font-semibold transition hover:text-secondary">
                            <i class="far fa-user text-xl text-primary transition group-hover:text-secondary"></i><span class="hidden lg:inline">{{ Auth::user()->first_name ?? 'Account' }}</span><i class="fas fa-chevron-down text-[9px] text-primary transition group-hover:text-secondary"></i>
                        </button>
                        <div x-show="accountOpen" x-cloak x-transition class="absolute right-0 mt-4 w-48 rounded-[8px] border border-border bg-white py-2 shadow-xl z-50">                            <a href="{{ route('client.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-primary-light">Dashboard</a>
                            <a href="{{ route('client.orders.index') }}" class="block px-4 py-2 text-sm hover:bg-primary-light">My Orders</a>
                            <a href="{{ route('client.wishlist.index') }}" class="block px-4 py-2 text-sm hover:bg-primary-light">Saved Items</a>
                            <hr class="my-1 border-border">
                            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full px-4 py-2 text-left text-sm hover:bg-primary-light">Log Out</button></form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden text-sm font-semibold uppercase transition hover:text-secondary lg:inline">Login / Register</a>
                    <a href="{{ route('login') }}" class="hidden text-primary transition hover:text-secondary sm:block lg:hidden" aria-label="Login"><i class="far fa-user text-xl"></i></a>
                @endauth

                <a href="{{ route('client.wishlist.index') }}" aria-label="Saved items" class="hidden text-primary transition hover:text-secondary sm:block"><i class="far fa-heart text-xl"></i></a>
                @auth
                    <a href="{{ route('client.dashboard') }}" aria-label="My Account" class="block text-primary transition hover:text-secondary sm:hidden"><i class="far fa-user text-xl"></i></a>
                @else
                    <a href="{{ route('login') }}" aria-label="Login" class="block text-primary transition hover:text-secondary sm:hidden"><i class="far fa-user text-xl"></i></a>
                @endauth
                <a href="{{ route('frontend.cart') }}" aria-label="Cart" class="relative text-primary transition hover:text-secondary">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span data-cart-badge class="absolute -right-2 -top-2 h-[18px] w-[18px] rounded-[12px] bg-secondary text-[10px] font-bold leading-none text-white" style="display:none; align-items:center; justify-content:center;"></span>
                </a>
            </div>
        </div>

        {{-- Mobile search (unchanged — stays underneath) --}}
        <div class="relative px-4 pb-3 md:hidden" @click.outside="sugOpen = false">
            <form action="{{ route('frontend.search') }}" method="GET" class="flex h-11 items-center overflow-hidden rounded-[12px] bg-background ring-1 ring-border">
                <input type="text" name="q" x-model="q" @input="fetchSuggestions()" placeholder="Search products..." autocomplete="off" class="min-w-0 flex-1 border-0 bg-transparent px-5 text-sm focus:ring-0">
                <button type="submit" class="h-11 w-12 text-primary transition hover:text-secondary"><i class="fas fa-search"></i></button>
            </form>
            @include('frontend.partials.search-suggestions')
        </div>
    </div>

    {{-- Category and main navigation row --}}
    <div class="hidden h-[62px]" :class="{ 'lg:block': menuFixed }"></div>
    <div x-ref="mainMenu" class="hidden border-b border-border bg-white transition-transform duration-300 ease-out lg:block"
        :class="{ 'fixed inset-x-0 top-0 z-50 shadow-md': menuFixed, '-translate-y-full': menuFixed && !menuVisible, 'translate-y-0': !menuFixed || menuVisible }">
        <div class="mx-auto grid h-[62px] max-w-[1440px] grid-cols-1 items-center px-7">
            <div class="relative group" x-data="{
                scrollLeft() { this.$refs.catScroll.scrollBy({ left: -240, behavior: 'smooth' }) },
                scrollRight() { this.$refs.catScroll.scrollBy({ left: 240, behavior: 'smooth' }) }
            }">
                {{-- Left arrow --}}
                <button @click="scrollLeft()" type="button" aria-label="Scroll categories left"
                    class="absolute left-0 top-1/2 z-10 hidden h-8 w-8 -translate-y-1/2 items-center justify-center rounded-[12px] bg-white text-primary opacity-0 shadow-md ring-1 ring-border transition hover:text-secondary group-hover:flex group-hover:opacity-100">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>

                <nav x-ref="catScroll"
                    class="flex items-center justify-center gap-8 overflow-x-auto scroll-smooth px-8 text-sm font-normal text-text [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden"
                    style="font-family: var(--font-ui);">
                    @foreach ($parentCategories as $category)
                        @php
                            $isActiveCategory = request()->routeIs('frontend.categories.show')
                                && request()->segment(count(request()->segments())) === $category->slug;
                        @endphp
                        <a href="{{ route('frontend.categories.show', $category->slug) }}"
                           class="whitespace-nowrap border-b-2 py-1 transition {{ $isActiveCategory ? 'border-secondary font-semibold text-secondary' : 'border-transparent hover:text-secondary' }}">{{ $category->name }}</a>
                    @endforeach
                </nav>

                {{-- Right arrow --}}
                <button @click="scrollRight()" type="button" aria-label="Scroll categories right"
                    class="absolute right-0 top-1/2 z-10 hidden h-8 w-8 -translate-y-1/2 items-center justify-center rounded-[12px] bg-white text-primary opacity-0 shadow-md ring-1 ring-border transition hover:text-secondary group-hover:flex group-hover:opacity-100">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile drawer --}}
    <div x-show="mobileOpen" x-cloak class="fixed inset-0 z-[60] lg:hidden" x-transition.opacity>
        <div class="absolute inset-0 bg-black/40" @click="mobileOpen = false"></div>
        <div class="absolute left-0 top-0 flex h-full w-80 max-w-[85%] flex-col bg-white shadow-2xl" x-show="mobileOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0">
            <div class="flex h-[68px] items-center justify-between border-b border-border px-6"><img src="{{ $branding['logo_main'] }}" alt="{{ config('app.name') }}" class="h-8 w-auto"><button @click="mobileOpen = false"><i class="fas fa-xmark text-xl"></i></button></div>
            <nav class="flex flex-col px-6 py-5 text-sm font-normal text-text">
                @foreach ($parentCategories->take(8) as $category)
                    @php
                        $isActiveCategory = request()->routeIs('frontend.categories.show')
                            && request()->segment(count(request()->segments())) === $category->slug;
                    @endphp
                    <a href="{{ route('frontend.categories.show', $category->slug) }}"
                       class="border-b border-border/60 py-3 transition {{ $isActiveCategory ? 'font-semibold text-secondary' : 'hover:text-secondary' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
                @auth
                    <a href="{{ route('client.dashboard') }}"
                       class="mt-2 block rounded-[8px] bg-primary px-4 py-2.5 text-center font-semibold text-white transition hover:bg-secondary">
                        My Account
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="mt-2 block rounded-[8px] bg-primary px-4 py-2.5 text-center font-semibold text-white transition hover:bg-secondary">
                        Login / Sign Up
                    </a>
                @endauth
            </nav>
        </div>
    </div>
</header>

@push('scripts')
<script>
document.addEventListener('alpine:init', function () {
    if (window.__storefrontHeaderRegistered) return;
    window.__storefrontHeaderRegistered = true;
    Alpine.data('siteHeader', () => ({
        mobileOpen: false, q: '', results: [], sugOpen: false, timer: null,
        menuFixed: false, menuVisible: true, menuOffset: 0, lastScrollY: 0,
        init() {
            this.$nextTick(() => {
                this.menuOffset = this.$refs.mainMenu.getBoundingClientRect().top + window.scrollY;
                this.lastScrollY = window.scrollY;
                window.addEventListener('scroll', () => this.handleScroll(), { passive: true });
            });
        },
        handleScroll() {
            const currentY = Math.max(window.scrollY, 0);
            this.menuFixed = currentY >= this.menuOffset;

            if (!this.menuFixed) {
                this.menuVisible = true;
            } else if (currentY > this.lastScrollY + 4) {
                this.menuVisible = false;
            } else if (currentY < this.lastScrollY - 4) {
                this.menuVisible = true;
            }

            this.lastScrollY = currentY;
        },
        fetchSuggestions() {
            clearTimeout(this.timer);
            if (this.q.trim().length < 2) { this.results = []; this.sugOpen = false; return; }
            this.timer = setTimeout(() => {
                if (typeof axios === 'undefined') return;
                axios.get('{{ route('frontend.search.suggestions') }}', { params: { q: this.q } })
                    .then(response => { this.results = response.data; this.sugOpen = this.results.length > 0; })
                    .catch(() => { this.sugOpen = false; });
            }, 280);
        }
    }));
});
</script>
@endpush
