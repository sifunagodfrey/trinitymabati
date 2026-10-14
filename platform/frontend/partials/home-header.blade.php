{{-- -------------------
     Site Header (Home)
     Transparent while it overlays the hero, then condenses into a
     sticky translucent white bar once the page is scrolled. The top
     utility strip is hidden once scrolled. The search control expands
     to full width on click and uses the predictive suggestions
     endpoint.
------------------- --}}
<div x-data="homeHeader()" x-init="init()" @keydown.escape.window="searchOpen = false; mobileOpen = false"
    class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
    :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm border-b border-black/5' : 'bg-transparent'">

    {{-- Top utility strip: hidden once scrolled --}}
    <div class="hidden lg:block overflow-hidden transition-all duration-300"
        :class="scrolled ? 'max-h-0 opacity-0' : 'max-h-12 opacity-100'">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-9 text-xs text-white border-b border-white/15">
            <div class="flex items-center gap-5">
                @if ($site['phone'] ?? null)
                    <a href="{{ $site['phone_href'] }}" class="flex items-center gap-1.5 hover:opacity-70 transition">
                        <i class="fas fa-phone-alt text-[10px]"></i>
                        <span>{{ $site['phone'] }}</span>
                    </a>
                @endif
                @if ($site['email'] ?? null)
                    <a href="mailto:{{ $site['email'] }}" class="flex items-center gap-1.5 hover:opacity-70 transition">
                        <i class="fas fa-envelope text-[10px]"></i>
                        <span>{{ $site['email'] }}</span>
                    </a>
                @endif
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('frontend.track-order') }}" class="hover:opacity-70 transition">Track Order</a>
                <span class="opacity-30">|</span>
                <a href="{{ route('frontend.about') }}" class="hover:opacity-70 transition">About</a>
                @if (!empty($site['socials']))
                    <span class="opacity-30">|</span>
                    <span class="flex items-center gap-3">
                        @foreach ($site['socials'] as $network => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener"
                                aria-label="{{ ucfirst($network) }}" class="hover:opacity-70 transition"><i
                                    class="fab fa-{{ $network }} text-xs"></i></a>
                        @endforeach
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Main bar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" :class="scrolled ? '' : 'border-b border-white/15'">
        <div class="flex items-center justify-between gap-6 h-[72px]">

            {{-- Logo --}}
            <a href="{{ route('frontend.home') }}" class="flex items-center flex-shrink-0" x-show="!searchOpen">
                <img src="{{ $branding['logo_white'] }}" alt="{{ config('app.name') }}"
                    class="h-9 w-auto" x-show="!scrolled" x-cloak>
                <img src="{{ $branding['logo_dark'] }}" alt="{{ config('app.name') }}" class="h-9 w-auto"
                    x-show="scrolled" x-cloak>
                <img src="{{ $branding['logo_main'] }}" alt="{{ config('app.name') }}"
                    class="h-9 w-auto" x-show="false">
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden lg:flex items-center gap-7 text-sm font-medium transition-colors duration-300"
                x-show="!searchOpen" :class="scrolled ? 'text-text' : 'text-white'"
                style="font-family: var(--font-ui);">
                <a href="{{ route('frontend.products') }}" class="hover:text-primary transition">Products</a>
                <a href="{{ route('frontend.categories') }}" class="hover:text-primary transition">Categories</a>
                <a href="{{ route('frontend.brands') }}" class="hover:text-primary transition">Top Brands</a>
                <a href="{{ route('frontend.about') }}" class="hover:text-primary transition">About Us</a>
                <a href="{{ route('frontend.contact') }}" class="hover:text-primary transition">Contact Us</a>
            </nav>

            {{-- Expanding search field (grows to fill the bar when open) --}}
            <div class="relative flex-1 mx-2" x-show="searchOpen" x-cloak
                @click.outside="searchOpen = false; sugOpen = false">
                <form action="{{ route('frontend.search') }}" method="GET" @submit="sugOpen = false"
                    class="flex items-center">
                    <input type="text" name="q" x-model="q" @input="fetchSuggestions()" x-ref="searchInput"
                        placeholder="Search products or categories..." autocomplete="off"
                        class="flex-1 px-5 py-2.5 rounded-[8px]-full border border-border bg-white text-sm text-text outline-none focus:border-primary">
                    <button type="submit"
                        class="px-5 py-2.5 bg-primary text-white rounded-r-full hover:bg-primary-dark transition flex-shrink-0">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                {{-- Predictive dropdown --}}
                <div x-show="sugOpen" x-cloak
                    class="absolute top-full left-0 right-0 mt-2 bg-white border border-border rounded-[12px] shadow-xl z-[200] overflow-hidden">
                    <template x-for="item in results" :key="item.id">
                        <a :href="'{{ url('products') }}/' + item.slug"
                            class="flex items-center gap-3 px-4 py-2.5 hover:bg-primary-light transition group">
                            <span
                                class="w-10 h-10 rounded-[8px] bg-gray-100 flex-shrink-0 overflow-hidden flex items-center justify-center">
                                <img x-show="item.thumb" :src="item.thumb" :alt="item.name"
                                    class="w-full h-full object-cover">
                                <i x-show="!item.thumb" class="fas fa-box-open text-gray-300 text-xs"></i>
                            </span>
                            <span class="flex-1 min-w-0">
                                <span
                                    class="block text-sm font-medium text-text truncate group-hover:text-primary transition"
                                    x-text="item.name"></span>
                                <span class="block text-xs text-muted truncate" x-show="item.category"
                                    x-text="item.category"></span>
                            </span>
                            <span class="text-xs font-semibold text-primary flex-shrink-0"
                                x-text="item.price_display"></span>
                        </a>
                    </template>
                    <a :href="'{{ route('frontend.search') }}?q=' + encodeURIComponent(q)"
                        class="flex items-center gap-2 px-4 py-3 border-t border-border text-xs font-semibold text-primary hover:bg-primary-light transition">
                        <i class="fas fa-search text-[10px]"></i>
                        <span>See all results for &ldquo;<span x-text="q"></span>&rdquo;</span>
                    </a>
                </div>
            </div>

            {{-- Right actions: search icon, login, cart --}}
            <div class="flex items-center gap-4 flex-shrink-0" x-show="!searchOpen">

                {{-- Search icon --}}
                <button @click="openSearch()" aria-label="Search"
                    class="transition-colors duration-300 hover:text-primary"
                    :class="scrolled ? 'text-text' : 'text-white'">
                    <i class="fas fa-search text-lg"></i>
                </button>

                {{-- Login / Account --}}
                @auth
                    <div class="relative hidden sm:block" x-data="{ accountOpen: false }" @click.away="accountOpen = false">
                        <button @click="accountOpen = !accountOpen"
                            class="flex items-center gap-2 text-sm font-medium transition-colors duration-300 hover:text-primary"
                            :class="scrolled ? 'text-text' : 'text-white'">
                            <i class="fas fa-user-circle text-lg"></i>
                            <span class="hidden md:inline">{{ Auth::user()->first_name ?? 'Account' }}</span>
                            <i class="fas fa-chevron-down text-[10px]"></i>
                        </button>
                        <div x-show="accountOpen" x-cloak x-transition
                            class="absolute right-0 mt-3 w-48 bg-white border border-border rounded-[12px] shadow-xl py-2 z-50">
                            <a href="{{ route('client.dashboard') }}"
                                class="block px-4 py-2 text-sm text-text hover:bg-primary-light transition">Dashboard</a>
                            <a href="{{ route('client.orders.index') }}"
                                class="block px-4 py-2 text-sm text-text hover:bg-primary-light transition">My Orders</a>
                            <a href="{{ route('client.wishlist.index') }}"
                                class="block px-4 py-2 text-sm text-text hover:bg-primary-light transition">Saved Items</a>
                            <hr class="my-1 border-border">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-text hover:bg-primary-light transition">Log
                                    Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-1.5 text-sm font-medium transition-colors duration-300 hover:text-primary"
                        :class="scrolled ? 'text-text' : 'text-white'">
                        <i class="fas fa-user-circle text-lg sm:hidden"></i>
                        <span class="hidden sm:inline">Log In</span>
                    </a>
                @endauth

                {{-- Cart --}}
                <a href="{{ route('frontend.cart') }}" aria-label="Cart"
                    class="relative transition-colors duration-300 hover:text-primary"
                    :class="scrolled ? 'text-text' : 'text-white'">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span data-cart-badge
                        class="absolute -top-2 -right-2 w-[18px] h-[18px] rounded-[12px] bg-secondary text-white text-[10px] font-bold leading-none"
                        style="display:none; align-items:center; justify-content:center; text-align:center;"></span>
                </a>

                {{-- Mobile toggle --}}
                <button @click="mobileOpen = true" class="lg:hidden transition-colors duration-300"
                    :class="scrolled ? 'text-text' : 'text-white'" aria-label="Open menu">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            {{-- Close-search button (only while search open) --}}
            <button x-show="searchOpen" x-cloak @click="searchOpen = false; sugOpen = false"
                class="flex-shrink-0 transition-colors duration-300 hover:text-primary"
                :class="scrolled ? 'text-text' : 'text-white'" aria-label="Close search">
                <i class="fas fa-xmark text-xl"></i>
            </button>
        </div>
    </div>

    {{-- Mobile drawer (teleported to body so the scrolled header's
         backdrop-filter does not trap its fixed positioning) --}}
    <template x-teleport="body">
        <div x-show="mobileOpen" x-cloak class="lg:hidden fixed inset-0 z-[60]" x-transition.opacity>
            <div class="absolute inset-0 bg-black/40" @click="mobileOpen = false"></div>
            <div class="absolute top-0 left-0 h-full w-80 max-w-[85%] bg-white shadow-2xl flex flex-col"
                x-show="mobileOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full">

                <div class="flex items-center justify-between px-6 h-[72px] border-b border-border">
                    <img src="{{ $branding['logo_dark'] }}" alt="{{ config('app.name') }}"
                        class="h-8 w-auto">
                    <button @click="mobileOpen = false" aria-label="Close menu" class="text-text"><i
                            class="fas fa-xmark text-xl"></i></button>
                </div>

                <nav class="flex flex-col px-6 py-5 gap-1 text-sm" style="font-family: var(--font-ui);">
                    <a href="{{ route('frontend.products') }}"
                        class="py-3 border-b border-border/60 text-text hover:text-primary transition">Products</a>
                    <a href="{{ route('frontend.categories') }}"
                        class="py-3 border-b border-border/60 text-text hover:text-primary transition">Pick
                        Category</a>
                    <a href="{{ route('frontend.brands') }}"
                        class="py-3 border-b border-border/60 text-text hover:text-primary transition">Top Brands</a>
                    <a href="{{ route('frontend.about') }}"
                        class="py-3 border-b border-border/60 text-text hover:text-primary transition">About Us</a>
                    <a href="{{ route('frontend.contact') }}"
                        class="py-3 border-b border-border/60 text-text hover:text-primary transition">Contact Us</a>
                </nav>

                <div class="mt-auto px-6 py-5 border-t border-border space-y-3">
                    @auth
                        <a href="{{ route('client.dashboard') }}"
                            class="block text-sm text-text hover:text-primary transition">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-text hover:text-primary transition">Log
                                Out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full text-center border border-primary text-primary font-semibold rounded-[12px] py-2.5 text-sm transition hover:bg-primary-light">Log
                            In</a>
                    @endauth
                    <a href="{{ route('frontend.cart') }}"
                        class="block w-full text-center bg-primary hover:bg-primary-dark text-white font-semibold rounded-[12px] py-2.5 text-sm transition">View
                        Cart</a>
                </div>
            </div>
        </div>
    </template>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function() {
            if (window.__haromiHeaderRegistered) return;
            window.__haromiHeaderRegistered = true;

            Alpine.data('homeHeader', function() {
                return {
                    scrolled: false,
                    mobileOpen: false,
                    searchOpen: false,
                    q: '',
                    results: [],
                    sugOpen: false,
                    timer: null,
                    init() {
                        this.scrolled = window.scrollY > 24;
                        window.addEventListener('scroll', () => {
                            this.scrolled = window.scrollY > 24;
                        }, {
                            passive: true
                        });
                    },
                    openSearch() {
                        this.searchOpen = true;
                        this.$nextTick(() => {
                            this.$refs.searchInput && this.$refs.searchInput.focus();
                        });
                    },
                    fetchSuggestions() {
                        clearTimeout(this.timer);
                        if (this.q.length < 2) {
                            this.results = [];
                            this.sugOpen = false;
                            return;
                        }
                        this.timer = setTimeout(() => {
                            if (typeof axios === 'undefined') return;
                            axios.get('{{ route('frontend.search.suggestions') }}', {
                                    params: {
                                        q: this.q
                                    }
                                })
                                .then(r => {
                                    this.results = r.data;
                                    this.sugOpen = this.results.length > 0;
                                })
                                .catch(() => {});
                        }, 280);
                    }
                };
            });
        });
    </script>
@endpush
