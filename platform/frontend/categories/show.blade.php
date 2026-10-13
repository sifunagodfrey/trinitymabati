{{-- -------------------
     Category Page
     Top scrollable parent categories, an optional left sub-category
     sidebar (only when sub-categories with products exist), and the
     product grid. Switching categories and sub-categories is AJAX, so
     the page never reloads.
------------------- --}}
@extends('frontend.layouts.app')

@section('title', $category['name'] . ' | ' . config('app.name'))
@section('meta_description', 'Shop ' . $category['name'] . ' stationery and office supplies at ' . config('app.name') . '.')

@section('content')

    <style>
        .cat-rail-item { width: auto; }
    </style>

    <div x-data="categoryBrowser({
            base: '{{ url('/categories') }}',
            current: '{{ $slug }}',
            hasSub: {{ $hasSubcategories ? 'true' : 'false' }}
         })">

        {{-- Breadcrumb (on the page background) --}}
        <div class="border-b border-border">
            <div class="max-w-7xl mx-auto px-3 md:px-6 py-3">
                <nav class="text-xs text-muted flex items-center gap-2" aria-label="Breadcrumb">
                    <a href="{{ route('frontend.home') }}" class="hover:text-primary">Home</a>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <a href="{{ route('frontend.categories') }}" class="hover:text-primary">Categories</a>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-text font-semibold" x-text="title">{{ $category['name'] }}</span>
                </nav>
            </div>
        </div>

        {{-- Grey band: starts at the category title --}}
        <div class="bg-primary-light/30">
        <div class="max-w-7xl mx-auto px-3 md:px-6 py-5">

        {{-- Title + sort --}}
        <div class="flex items-center justify-between gap-3 mb-4">
            <div class="flex items-center gap-2">
                <span class="hidden sm:inline text-xs text-muted">Sort by</span>
                <select x-model="sort" @change="load()"
                        class="text-xs border border-border rounded-[8px] px-3 py-2 text-gray-600 outline-none focus:border-primary bg-white">
                    <option value="">Relevance</option>
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                    <option value="newest">Newest First</option>
                    <option value="top_rated">Top Rated</option>
                </select>
            </div>
        </div>

        {{-- -------------------
             Top scrollable parent categories
        ------------------- --}}
        @if (! empty($topCategories))
            <div class="relative mb-6" x-data="productRail()">
                <button @click="prev()" aria-label="Scroll left"
                    class="hidden md:flex absolute -left-3 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-[12px] bg-white border border-border shadow text-text hover:text-primary items-center justify-center">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>

                <div x-ref="track" class="overflow-x-auto no-scrollbar">
                    <div class="flex gap-2.5 md:gap-3 pb-1">
                        @foreach ($topCategories as $top)
                            <button type="button"
                                @click="open('{{ $top['slug'] }}', '{{ addslashes($top['label']) }}')"
                                class="cat-rail-item group flex flex-col items-center flex-shrink-0 transition"
                                data-top-slug="{{ $top['slug'] }}">
                                <span class="relative block w-20 h-20 md:w-24 md:h-24 rounded-[12px] overflow-hidden border-2 transition bg-white"
                                      :class="current === '{{ $top['slug'] }}' ? 'border-primary' : 'border-border group-hover:border-primary/50'">
                                    <span class="absolute inset-0 overflow-hidden">
                                        @if ($top['image'])
                                            <img src="{{ $top['image'] }}" alt="{{ $top['label'] }}" loading="lazy"
                                                 onerror="this.replaceWith(Object.assign(document.createElement('span'),{className:'absolute inset-0 flex items-center justify-center text-2xl font-extrabold text-primary/30',textContent:'{{ $top['initial'] }}'}));"
                                                 class="absolute inset-0 w-full h-full object-cover">
                                        @else
                                            <span class="absolute inset-0 flex items-center justify-center text-2xl font-extrabold text-primary/40">{{ $top['initial'] }}</span>
                                        @endif
                                    </span>
                                </span>
                                <span class="mt-1.5 text-center text-[11px] md:text-xs font-medium whitespace-nowrap transition"
                                      :class="current === '{{ $top['slug'] }}' ? 'text-primary font-semibold' : 'text-text'">{{ $top['label'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <button @click="next()" aria-label="Scroll right"
                    class="hidden md:flex absolute -right-3 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-[12px] bg-white border border-border shadow text-text hover:text-primary items-center justify-center">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </div>
        @endif

        {{-- -------------------
             Body: optional sub-category sidebar + products
        ------------------- --}}
        <div class="flex gap-5">

            {{-- Left sub-category sidebar: only when sub-categories exist --}}
            @if ($hasSubcategories)
                <aside class="hidden md:block w-52 flex-shrink-0">
                    <div class="bg-white border border-border rounded-[12px] p-3 sticky top-24">
                        <h3 class="text-xs font-bold text-text uppercase tracking-wide px-2 mb-2">Browse</h3>
                        <ul class="space-y-0.5">
                            <li>
                                <button type="button" @click="open('{{ $slug }}', title)"
                                    :class="current === '{{ $slug }}' ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-600 hover:bg-gray-50'"
                                    class="w-full text-left text-sm rounded-[8px] px-3 py-2 transition">
                                    All {{ $category['name'] }}
                                </button>
                            </li>
                            @foreach ($subcategories as $sub)
                                <li>
                                    <button type="button"
                                        @click="open('{{ $sub['slug'] }}', '{{ addslashes($sub['label']) }}')"
                                        :class="current === '{{ $sub['slug'] }}' ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-600 hover:bg-gray-50'"
                                        class="w-full flex items-center justify-between text-sm rounded-[8px] px-3 py-2 transition">
                                        <span>{{ $sub['label'] }}</span>
                                        <span class="text-[10px] text-muted">{{ $sub['count'] }}</span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>

                {{-- Mobile sub-category chips --}}
                <div class="md:hidden w-full">
                    <div class="overflow-x-auto no-scrollbar mb-3">
                        <div class="flex gap-2">
                            <button type="button" @click="open('{{ $slug }}', title)"
                                :class="current === '{{ $slug }}' ? 'bg-primary text-white border-primary' : 'bg-white text-gray-600 border-border'"
                                class="flex-shrink-0 text-xs font-medium rounded-[12px] border px-3.5 py-1.5 transition">
                                All
                            </button>
                            @foreach ($subcategories as $sub)
                                <button type="button"
                                    @click="open('{{ $sub['slug'] }}', '{{ addslashes($sub['label']) }}')"
                                    :class="current === '{{ $sub['slug'] }}' ? 'bg-primary text-white border-primary' : 'bg-white text-gray-600 border-border'"
                                    class="flex-shrink-0 text-xs font-medium rounded-[12px] border px-3.5 py-1.5 transition">
                                    {{ $sub['label'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Products column --}}
            <div class="flex-1 min-w-0">
                {{-- Loading overlay --}}
                <div class="relative">
                    <div x-show="loading" x-cloak
                         class="absolute inset-0 z-10 bg-white/60 flex items-start justify-center pt-20">
                        <i class="fas fa-spinner fa-spin text-2xl text-primary"></i>
                    </div>

                    <div id="category-results">
                        @include('frontend.categories.partials.product-results')
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </div>

    {{-- -------------------
         AJAX category browser
    ------------------- --}}
    @push('scripts')
    <script>
        // Fallback registration so the top-category rail arrows work even
        // if the compiled bundle predates the productRail component.
        document.addEventListener('alpine:init', function () {
            if (window.__railRegistered) return;
            window.__railRegistered = true;
            if (typeof Alpine !== 'undefined' && typeof Alpine.data === 'function') {
                Alpine.data('productRail', function () {
                    return {
                        prev: function () { this.$refs.track.scrollBy({ left: -this.$refs.track.clientWidth * 0.8, behavior: 'smooth' }); },
                        next: function () { this.$refs.track.scrollBy({ left: this.$refs.track.clientWidth * 0.8, behavior: 'smooth' }); }
                    };
                });
            }
        });

        function categoryBrowser(config) {
            return {
                base: config.base,
                current: config.current,
                title: @js($category['name']),
                sort: '',
                loading: false,

                open(slug, label) {
                    if (slug === this.current && !this.sort) {
                        // still allow re-fetch, but update label
                    }
                    this.current = slug;
                    if (label) this.title = label;
                    this.load();
                },

                load() {
                    this.loading = true;
                    var url = this.base + '/' + this.current + '?ajax=1' +
                              (this.sort ? '&sort=' + encodeURIComponent(this.sort) : '');

                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(function (r) { return r.text(); })
                        .then((html) => {
                            var target = document.getElementById('category-results');
                            if (target) target.innerHTML = html;
                            // Update the browser URL without reloading
                            var pretty = this.base + '/' + this.current +
                                         (this.sort ? '?sort=' + encodeURIComponent(this.sort) : '');
                            window.history.replaceState({}, '', pretty);
                            this.refreshCartBadges();
                        })
                        .catch(() => {})
                        .finally(() => { this.loading = false; });
                },

                refreshCartBadges() {
                    // Re-seed the View Cart / Add buttons already rendered server-side
                    if (typeof window.updateCartBadges === 'function' && typeof window.__cartCount === 'number') {
                        window.updateCartBadges(window.__cartCount);
                    }
                }
            };
        }
    </script>
    @endpush

@endsection
