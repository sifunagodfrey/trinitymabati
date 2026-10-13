@extends('frontend.layouts.app')

@section('title', 'Search: "' . $q . '" - ' . config('app.name'))

@section('content')

    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="bg-gray-50 border-b border-border">
        <div class="max-w-7xl mx-auto px-4 py-2.5 text-xs text-gray-500 flex items-center gap-2">
            <a href="{{ route('frontend.home') }}" class="hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right text-gray-300 text-[10px]"></i>
            <span class="text-gray-800 font-medium">Search Results</span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6"
         x-data="{ showFilters: false }">

        {{-- ---------------
        -- Search + Sort Bar
        -- --------------- --}}
        <form method="GET" action="{{ route('frontend.search') }}" id="filter-form">

            {{-- Preserve search query and filters --}}
            <input type="hidden" name="q" value="{{ $q }}">

            <div class="flex flex-wrap items-center gap-3 mb-6">

                {{-- Search input (already hidden above, but we keep it for UX) --}}
                <div class="flex-1 min-w-[200px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden shadow-sm">
                    <input type="text" name="q" value="{{ $q }}"
                        placeholder="Search products..."
                        class="flex-1 px-2 py-2.5 text-sm text-gray-800 outline-none bg-transparent border-0">
                    @if ($q)
                        <a href="{{ route('frontend.products') }}"
                            class="pr-3 text-gray-400 hover:text-red-400 transition text-xs">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>

                {{-- Sort --}}
                <select name="sort" onchange="this.form.submit()"
                    class="text-xs border border-border rounded-[12px] px-4 py-2.5 text-gray-600 outline-none bg-white shadow-sm focus:border-primary">
                    <option value="relevance" {{ !in_array(request('sort'), ['price_asc', 'price_desc', 'name_asc', 'top_rated', 'most_reviews', 'newest']) ? 'selected' : '' }}>Most Relevant</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A–Z</option>
                    <option value="top_rated" {{ request('sort') === 'top_rated' ? 'selected' : '' }}>Top Rated</option>
                    <option value="most_reviews" {{ request('sort') === 'most_reviews' ? 'selected' : '' }}>Most Reviews</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                </select>

                <button type="submit"
                    class="bg-primary text-white text-xs font-semibold px-5 py-2.5 rounded-[12px] hover:opacity-90 transition shadow-sm">
                    Search
                </button>
            </div>

            {{-- ---------------
            -- Active Filters Strip
            -- --------------- --}}
            <div class="bg-secondary/20 border border-secondary rounded-[8px] p-3 mb-5">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-xs font-bold text-text">Active Filters</h4>
                    @if ($filters['min_price'] !== '' || $filters['max_price'] !== '' || $filters['price_range'] || !empty($filters['seller']) || $filters['min_rating'] !== '')
                        <a href="{{ route('frontend.search', ['q' => $q]) }}"
                           class="text-[10px] text-red-500 hover:underline">Clear All</a>
                    @endif
                </div>
                <div class="flex flex-wrap gap-1.5">

                    {{-- Price preset tag --}}
                    @if ($filters['price_range'])
                        <span class="inline-flex items-center gap-1 text-[10px] bg-primary text-white rounded-[12px] px-2 py-0.5 font-semibold">
                            {{ match ($filters['price_range']) {
                                '0-5000'       => 'Under KSh 5K',
                                '5000-20000'   => 'KSh 5K–20K',
                                '20000-50000'  => 'KSh 20K–50K',
                                '50000-100000' => 'KSh 50K–100K',
                                '100000+'      => 'Over KSh 100K',
                                default        => $filters['price_range'],
                            } }}
                            <i class="fas fa-times cursor-pointer ml-0.5"
                               onclick="document.querySelector('[name=price_range]').checked = false; document.getElementById('filter-form').submit()"></i>
                        </span>
                    @endif

                    {{-- Custom price range tag --}}
                    @if ($filters['min_price'] !== '' || $filters['max_price'] !== '')
                        <span class="inline-flex items-center gap-1 text-[10px] bg-primary text-white rounded-[12px] px-2 py-0.5 font-semibold">
                            KSh {{ $filters['min_price'] !== '' ? number_format($filters['min_price']) : '0' }}
                            –
                            {{ $filters['max_price'] !== '' ? number_format($filters['max_price']) : '∞' }}
                            <i class="fas fa-times cursor-pointer ml-0.5"
                               onclick="document.querySelector('[name=min_price]').value = ''; document.querySelector('[name=max_price]').value = ''; document.getElementById('filter-form').submit()"></i>
                        </span>
                    @endif

                    {{-- Seller tags --}}
                    @foreach ($filters['seller'] as $selVal)
                        <span class="inline-flex items-center gap-1 text-[10px] bg-primary text-white rounded-[12px] px-2 py-0.5 font-semibold">
                            {{ match ($selVal) { 'verified' => 'Verified', 'wholesale' => 'Wholesale', 'brand' => 'Official Brand', default => $selVal } }}
                            <i class="fas fa-times cursor-pointer ml-0.5"
                               onclick="document.querySelector('input[name=\'seller[]\'][value=\'{{ $selVal }}\']').checked = false; document.getElementById('filter-form').submit()"></i>
                        </span>
                    @endforeach

                    {{-- Rating tag --}}
                    @if ($filters['min_rating'] !== '')
                        <span class="inline-flex items-center gap-1 text-[10px] bg-primary text-white rounded-[12px] px-2 py-0.5 font-semibold">
                            {{ $filters['min_rating'] }}+ stars
                            <i class="fas fa-times cursor-pointer ml-0.5"
                               onclick="document.querySelectorAll('[name=min_rating]').forEach(r => r.checked = false); document.getElementById('filter-form').submit()"></i>
                        </span>
                    @endif

                    {{-- Empty state --}}
                    @if ($filters['min_price'] === '' && $filters['max_price'] === '' && !$filters['price_range'] && empty($filters['seller']) && $filters['min_rating'] === '')
                        <p class="text-[10px] text-muted">No active filters</p>
                    @endif

                </div>
            </div>

            {{-- ---------------
            -- Main Layout: Sidebar + Grid
            -- --------------- --}}
            <div class="flex gap-6">

                {{-- ---------------
                -- Sidebar Filters (desktop)
                -- --------------- --}}
                <aside class="w-52 flex-shrink-0 space-y-4"
                       :class="showFilters ? 'block' : 'hidden md:block'">

                    {{-- Price Range --}}
                    <div class="bg-white border border-border rounded-[8px] p-4">
                        <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Price (KSh)</h4>
                        <div class="flex items-center gap-2 mb-2">
                            <input type="number" name="min_price" placeholder="Min"
                                   value="{{ $filters['min_price'] }}"
                                   class="w-full text-xs border border-border rounded-[8px] px-2 py-1.5
                                          outline-none focus:border-primary">
                            <span class="text-muted text-xs">–</span>
                            <input type="number" name="max_price" placeholder="Max"
                                   value="{{ $filters['max_price'] }}"
                                   class="w-full text-xs border border-border rounded-[8px] px-2 py-1.5
                                          outline-none focus:border-primary">
                        </div>
                        <button type="submit"
                                class="w-full text-[10px] font-bold bg-primary text-white rounded-[8px]
                                       py-1.5 mb-3 hover:opacity-90 transition">
                            Apply Price
                        </button>
                        <div class="space-y-1.5">
                            @foreach ([
                                '0-5000'       => 'Under KSh 5,000',
                                '5000-20000'   => 'KSh 5,000 – 20,000',
                                '20000-50000'  => 'KSh 20,000 – 50,000',
                                '50000-100000' => 'KSh 50,000 – 100,000',
                                '100000+'      => 'Over KSh 100,000',
                            ] as $val => $label)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="price_range" value="{{ $val }}"
                                           class="accent-primary"
                                           {{ $filters['price_range'] === $val ? 'checked' : '' }}
                                           @change="$el.closest('form').submit()">
                                    <span class="text-xs text-gray-600 group-hover:text-primary transition">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Seller Type --}}
                    <div class="bg-white border border-border rounded-[8px] p-4">
                        <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Seller Type</h4>
                        <div class="space-y-1.5">
                            @foreach ([
                                'verified'  => 'Verified Seller',
                                'wholesale' => 'Wholesale Only',
                                'brand'     => 'Official Brand',
                            ] as $val => $label)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="seller[]" value="{{ $val }}"
                                           class="accent-primary"
                                           {{ in_array($val, $filters['seller']) ? 'checked' : '' }}
                                           @change="$el.closest('form').submit()">
                                    <span class="text-xs text-gray-600 group-hover:text-primary transition">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Rating --}}
                    <div class="bg-white border border-border rounded-[8px] p-4">
                        <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Minimum Rating</h4>
                        <div class="space-y-1.5">
                            @foreach ([4, 3, 2, 1] as $stars)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="min_rating" value="{{ $stars }}"
                                           class="accent-primary"
                                           {{ $filters['min_rating'] == $stars ? 'checked' : '' }}
                                           @change="$el.closest('form').submit()">
                                    <div class="flex items-center gap-0.5">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-[10px] {{ $i <= $stars ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                        @endfor
                                        <span class="text-xs text-gray-600 ml-1">& up</span>
                                    </div>
                                </label>
                            @endforeach
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="min_rating" value=""
                                       class="accent-primary"
                                       {{ $filters['min_rating'] == '' ? 'checked' : '' }}
                                       @change="$el.closest('form').submit()">
                                <span class="text-xs text-gray-600">Any Rating</span>
                            </label>
                        </div>
                    </div>

                    {{-- Categories (existing) --}}
                    <div class="bg-white border border-border rounded-[8px] p-4">
                        <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Category</h4>
                        <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                            @foreach ($categories as $category)
                                @php
                                    $isActive = request('category_id') == $category->id;
                                    $filterUrl = $isActive
                                        ? route('frontend.search', array_merge(['q' => $q], request()->except(['category_id', 'page'])))
                                        : route('frontend.search', array_merge(['q' => $q], request()->except(['category_id', 'page']), ['category_id' => $category->id]));
                                @endphp
                                <a href="{{ $filterUrl }}"
                                   class="flex items-center justify-between gap-2 group cursor-pointer">
                                    <div class="flex items-center gap-2">
                                        <span class="w-4 h-4 rounded flex-shrink-0 border-2 flex items-center justify-center transition
                                            {{ $isActive ? 'bg-primary border-primary' : 'border-gray-300 group-hover:border-primary' }}">
                                            @if ($isActive)
                                                <i class="fas fa-check text-white text-[8px]"></i>
                                            @endif
                                        </span>
                                        <span class="text-xs text-gray-600 group-hover:text-primary transition leading-tight">
                                            {{ $category->name }}
                                        </span>
                                    </div>
                                    <span class="text-[10px] text-muted flex-shrink-0">{{ $category->products_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Brands --}}
                    @if ($brands->isNotEmpty())
                        <div class="bg-white border border-border rounded-[8px] p-4">
                            <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Brand</h4>
                            <div class="space-y-2 max-h-52 overflow-y-auto pr-1">
                                @foreach ($brands as $brand)
                                    @php
                                        $isActive = request('brand_id') == $brand->id;
                                        $filterUrl = $isActive
                                            ? route('frontend.search', array_merge(['q' => $q], request()->except(['brand_id', 'page'])))
                                            : route('frontend.search', array_merge(['q' => $q], request()->except(['brand_id', 'page']), ['brand_id' => $brand->id]));
                                    @endphp
                                    <a href="{{ $filterUrl }}"
                                       class="flex items-center justify-between gap-2 group cursor-pointer">
                                        <div class="flex items-center gap-2">
                                            <span class="w-4 h-4 rounded flex-shrink-0 border-2 flex items-center justify-center transition
                                                {{ $isActive ? 'bg-primary border-primary' : 'border-gray-300 group-hover:border-primary' }}">
                                                @if ($isActive)
                                                    <i class="fas fa-check text-white text-[8px]"></i>
                                                @endif
                                            </span>
                                            <span class="text-xs text-gray-600 group-hover:text-primary transition leading-tight">
                                                {{ $brand->name }}
                                            </span>
                                        </div>
                                        <span class="text-[10px] text-muted flex-shrink-0">{{ $brand->products_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Labels (optional) --}}
                    @if ($labels->isNotEmpty())
                        <div class="bg-white border border-border rounded-[8px] p-4">
                            <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Label</h4>
                            <div class="space-y-2">
                                @foreach ($labels as $label)
                                    @php
                                        $isActive = request('label_id') == $label->id;
                                        $filterUrl = $isActive
                                            ? route('frontend.search', array_merge(['q' => $q], request()->except(['label_id', 'page'])))
                                            : route('frontend.search', array_merge(['q' => $q], request()->except(['label_id', 'page']), ['label_id' => $label->id]));
                                    @endphp
                                    <a href="{{ $filterUrl }}"
                                       class="flex items-center justify-between gap-2 group cursor-pointer">
                                        <div class="flex items-center gap-2">
                                            <span class="w-4 h-4 rounded flex-shrink-0 border-2 flex items-center justify-center transition
                                                {{ $isActive ? 'bg-primary border-primary' : 'border-gray-300 group-hover:border-primary' }}">
                                                @if ($isActive)
                                                    <i class="fas fa-check text-white text-[8px]"></i>
                                                @endif
                                            </span>
                                            <span class="text-xs text-gray-600 group-hover:text-primary transition leading-tight flex items-center gap-1">
                                                <span class="inline-block w-2 h-2 rounded-[12px] flex-shrink-0"
                                                      style="background-color: {{ $label->color_code ?? '#9ca3af' }}"></span>
                                                {{ $label->name }}
                                            </span>
                                        </div>
                                        <span class="text-[10px] text-muted flex-shrink-0">{{ $label->products_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </aside>

                {{-- ---------------
                -- Product Grid
                -- --------------- --}}
                <div class="flex-1 min-w-0">

                    {{-- Result count heading --}}
                    <div class="mb-5">
                        <h1 class="text-lg font-bold text-text">
                            Results for <span class="text-primary">"{{ $q }}"</span>
                        </h1>
                        <p class="text-sm text-muted mt-0.5">
                            {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found
                        </p>
                    </div>

                    {{-- Matching categories quick-filter row --}}
                    @if ($matchingCategories->isNotEmpty())
                        <div class="mb-5">
                            <p class="text-xs text-muted mb-2">Browse by category:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($matchingCategories as $cat)
                                    @php
                                        $isActive = request('category_id') == $cat->id;
                                        $catUrl = $isActive
                                            ? route('frontend.search', array_merge(['q' => $q], request()->except(['category_id', 'page'])))
                                            : route('frontend.search', array_merge(['q' => $q], request()->except(['category_id', 'page']), ['category_id' => $cat->id]));
                                    @endphp
                                    <a href="{{ $catUrl }}"
                                        class="inline-flex items-center gap-1 text-xs px-3 py-1.5 rounded-[12px] border transition
                                            {{ $isActive
                                                ? 'bg-primary text-white border-primary'
                                                : 'border-border text-gray-600 hover:border-primary hover:text-primary bg-white' }}">
                                        {{ $cat->name }}
                                        <span class="opacity-60">({{ $cat->products_count }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Sort + Filter Bar --}}
                    <div class="flex items-center justify-between gap-3 flex-wrap mb-4">
                        <p class="text-sm text-muted">
                            <span class="font-semibold text-text">{{ $products->total() }}</span> results
                            for <span class="font-semibold text-text">"{{ $q }}"</span>
                        </p>
                        <div class="flex items-center gap-2">

                            {{-- Sort --}}
                            <select name="sort"
                                    class="text-xs border border-border rounded-[8px] px-3 py-2 text-gray-600
                                           outline-none focus:border-primary bg-white"
                                    @change="$el.closest('form').submit()">
                                <option value=""              {{ request('sort', '') === ''             ? 'selected' : '' }}>Best Match</option>
                                <option value="price_asc"    {{ request('sort') === 'price_asc'    ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc"   {{ request('sort') === 'price_desc'   ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="top_rated"    {{ request('sort') === 'top_rated'    ? 'selected' : '' }}>Top Rated</option>
                                <option value="newest"       {{ request('sort') === 'newest'       ? 'selected' : '' }}>Newest First</option>
                                <option value="most_reviews" {{ request('sort') === 'most_reviews' ? 'selected' : '' }}>Most Reviews</option>
                            </select>

                            {{-- Mobile Filter button --}}
                            <button type="button"
                                    class="md:hidden flex items-center gap-1.5 text-xs border border-border
                                           rounded-[8px] px-3 py-2 text-gray-600 bg-white"
                                    @click="showFilters = !showFilters">
                                <i class="fas fa-sliders-h"></i>
                                <span x-text="showFilters ? 'Hide' : 'Filter'">Filter</span>
                            </button>
                        </div>
                    </div>

                    {{-- Product Grid / List --}}
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2.5 md:gap-4">

                        @forelse ($products as $product)
                            @include('frontend.partials.product-card', ['product' => $product])
                        @empty
                            <div class="col-span-full text-center py-16">
                                <i class="fas fa-magnifying-glass text-4xl text-gray-200 mb-4 block"></i>
                                <p class="text-sm font-semibold text-text mb-1">No products found</p>
                                <p class="text-xs text-muted">Try a different keyword or remove some filters.</p>
                            </div>
                        @endforelse

                    </div>

                    {{-- Pagination --}}
                    @if ($products->hasPages())
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </form>
    </div>

@endsection
