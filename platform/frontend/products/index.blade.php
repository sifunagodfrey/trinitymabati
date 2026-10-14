@extends('frontend.layouts.app')

@section('title', 'Products - Trinity Mabati Factory')

@section('content')
    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="bg-gray-50 border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5 text-xs text-gray-500 flex items-center gap-2">
            <a href="{{ route('frontend.home') }}" class="hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right text-gray-300 text-[10px]"></i>
            <span class="text-gray-800 font-medium">Products</span>
            @if (request('category_id') && $categories->find(request('category_id')))
                <i class="fas fa-chevron-right text-gray-300 text-[10px]"></i>
                <span class="text-gray-800 font-medium">{{ $categories->find(request('category_id'))->name }}</span>
            @endif
        </div>
    </div>

    {{-- Grey band: page content sits on a soft grey so white cards stand out --}}
    <div style="background-color: var(--background-color);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- ---------------
        -- Search + Sort Bar
        -- --------------- --}}
        <form method="GET" action="{{ route('frontend.products') }}"
            class="flex flex-wrap items-center gap-3 mb-6">

            {{-- Preserve active sidebar filters --}}
            @if (request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
            @if (request('brand_id'))
                <input type="hidden" name="brand_id" value="{{ request('brand_id') }}">
            @endif
            @if (request('label_id'))
                <input type="hidden" name="label_id" value="{{ request('label_id') }}">
            @endif
            @if ($filters['min_price'] !== '')
                <input type="hidden" name="min_price" value="{{ $filters['min_price'] }}">
            @endif
            @if ($filters['max_price'] !== '')
                <input type="hidden" name="max_price" value="{{ $filters['max_price'] }}">
            @endif
            @if ($filters['price_range'] !== '')
                <input type="hidden" name="price_range" value="{{ $filters['price_range'] }}">
            @endif

            {{-- Search --}}
            <div class="flex-1 min-w-[200px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden shadow-sm">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search products..."
                    class="flex-1 px-2 py-2.5 text-sm text-gray-800 outline-none bg-transparent border-0" >
                @if (request('search'))
                    <a href="{{ route('frontend.products', request()->except(['search', 'page'])) }}"
                        class="pr-3 text-gray-400 hover:text-red-400 transition text-xs">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>

            {{-- Sort --}}
            <select name="sort" onchange="this.form.submit()"
                class="text-xs border border-border rounded-[12px] px-4 py-2.5 text-gray-600 outline-none bg-white shadow-sm focus:border-primary">
                <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Newest First</option>
                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A–Z</option>
                <option value="top_rated" {{ request('sort') === 'top_rated' ? 'selected' : '' }}>Top Rated</option>
                <option value="most_reviews" {{ request('sort') === 'most_reviews' ? 'selected' : '' }}>Most Reviews</option>
            </select>

            {{-- Search button (for keyboard users) --}}
            <button type="submit"
                class="bg-primary text-white text-xs font-semibold px-5 py-2.5 rounded-[12px] hover:opacity-90 transition shadow-sm">
                Search
            </button>
        </form>

        {{-- ---------------
        -- Active Filters Strip
        -- --------------- --}}
        @if (request('category_id') || request('brand_id') || request('label_id') || request('search') || request('min_price') || request('max_price') || request('price_range'))
            <div class="flex flex-wrap items-center gap-2 mb-5">
                <span class="text-xs text-muted">Active filters:</span>
                @if (request('category_id') && $categories->find(request('category_id')))
                    <a href="{{ route('frontend.products', request()->except(['category_id', 'page'])) }}"
                        class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-medium px-3 py-1 rounded-[12px] hover:bg-primary/20 transition">
                        Category: {{ $categories->find(request('category_id'))->name }}
                        <i class="fas fa-times text-[9px]"></i>
                    </a>
                @endif
                @if (request('brand_id') && $brands->find(request('brand_id')))
                    <a href="{{ route('frontend.products', request()->except(['brand_id', 'page'])) }}"
                        class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-medium px-3 py-1 rounded-[12px] hover:bg-primary/20 transition">
                        Brand: {{ $brands->find(request('brand_id'))->name }}
                        <i class="fas fa-times text-[9px]"></i>
                    </a>
                @endif
                @if (request('label_id') && $labels->find(request('label_id')))
                    <a href="{{ route('frontend.products', request()->except(['label_id', 'page'])) }}"
                        class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-medium px-3 py-1 rounded-[12px] hover:bg-primary/20 transition">
                        Label: {{ $labels->find(request('label_id'))->name }}
                        <i class="fas fa-times text-[9px]"></i>
                    </a>
                @endif
                @if (request('search'))
                    <a href="{{ route('frontend.products', request()->except(['search', 'page'])) }}"
                        class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-medium px-3 py-1 rounded-[12px] hover:bg-primary/20 transition">
                        "{{ request('search') }}"
                        <i class="fas fa-times text-[9px]"></i>
                    </a>
                @endif
                @if ($filters['price_range'] !== '' || $filters['min_price'] !== '' || $filters['max_price'] !== '')
                    <a href="{{ route('frontend.products', request()->except(['min_price', 'max_price', 'price_range', 'page'])) }}"
                        class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-medium px-3 py-1 rounded-[12px] hover:bg-primary/20 transition">
                        @if ($filters['price_range'] !== '')
                            Price: {{ match ($filters['price_range']) { '0-5000' => 'Under KSh 5K', '5000-20000' => 'KSh 5K–20K', '20000-50000' => 'KSh 20K–50K', '50000-100000' => 'KSh 50K–100K', '100000+' => 'Over KSh 100K', default => $filters['price_range'] } }}
                        @else
                            Price: KSh {{ $filters['min_price'] ?: '0' }} – {{ $filters['max_price'] ?: '∞' }}
                        @endif
                        <i class="fas fa-times text-[9px]"></i>
                    </a>
                @endif
                <a href="{{ route('frontend.products') }}"
                    class="text-xs text-muted underline hover:text-primary transition">
                    Clear all
                </a>
            </div>
        @endif

        {{-- ---------------
        -- Product Count
        -- --------------- --}}
        <p class="text-sm text-muted mb-5">
            Showing <span class="font-semibold text-text">{{ $products->total() }}</span>
            {{ Str::plural('product', $products->total()) }}
        </p>

        {{-- ---------------
        -- Main Layout: Sidebar + Grid
        -- --------------- --}}
        <div class="flex gap-6">

            {{-- Sidebar Filters (desktop) --}}
            <aside class="hidden md:block w-56 flex-shrink-0 space-y-4">

                {{-- ---------------
                -- Categories Filter
                -- --------------- --}}
                <div class="bg-white border border-border rounded-[12px] p-4">
                    <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Category</h4>
                    <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                        @foreach ($categories as $category)
                            @php
                                $isActive  = request('category_id') == $category->id;
                                $filterUrl = $isActive
                                    ? route('frontend.products', request()->except(['category_id', 'page']))
                                    : route('frontend.products', array_merge(request()->except(['category_id', 'page']), ['category_id' => $category->id]));
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

                {{-- ---------------
                -- Brands Filter
                -- --------------- --}}
                @if ($brands->isNotEmpty())
                    <div class="bg-white border border-border rounded-[12px] p-4">
                        <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Brand</h4>
                        <div class="space-y-2 max-h-52 overflow-y-auto pr-1">
                            @foreach ($brands as $brand)
                                @php
                                    $isActive  = request('brand_id') == $brand->id;
                                    $filterUrl = $isActive
                                        ? route('frontend.products', request()->except(['brand_id', 'page']))
                                        : route('frontend.products', array_merge(request()->except(['brand_id', 'page']), ['brand_id' => $brand->id]));
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

                {{-- ---------------
                -- Labels Filter
                -- --------------- --}}
                @if ($labels->isNotEmpty())
                    <div class="bg-white border border-border rounded-[12px] p-4">
                        <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Label</h4>
                        <div class="space-y-2">
                            @foreach ($labels as $label)
                                @php
                                    $isActive  = request('label_id') == $label->id;
                                    $filterUrl = $isActive
                                        ? route('frontend.products', request()->except(['label_id', 'page']))
                                        : route('frontend.products', array_merge(request()->except(['label_id', 'page']), ['label_id' => $label->id]));
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
                                            <span class="inline-block w-2 h-2 rounded-[12px] mr-1 flex-shrink-0"
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

                {{-- ---------------
                -- Price Range Filter
                -- --------------- --}}
                <form method="GET" action="{{ route('frontend.products') }}" id="price-form">
                    @foreach (request()->except(['min_price', 'max_price', 'price_range', 'condition', 'page']) as $key => $value)
                        @if (is_array($value))
                            @foreach ($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <div class="bg-white border border-border rounded-[12px] p-4">
                        <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Price (KSh)</h4>
                        <div class="flex items-center gap-2 mb-2">
                            <input type="number" name="min_price" placeholder="Min"
                                   value="{{ $filters['min_price'] }}"
                                   class="w-full text-xs border border-border rounded-[8px] px-2 py-1.5 outline-none focus:border-primary">
                            <span class="text-muted text-xs">–</span>
                            <input type="number" name="max_price" placeholder="Max"
                                   value="{{ $filters['max_price'] }}"
                                   class="w-full text-xs border border-border rounded-[8px] px-2 py-1.5 outline-none focus:border-primary">
                        </div>
                        <button type="submit"
                                class="w-full text-[10px] font-bold bg-primary text-white rounded-[8px] py-1.5 mb-3 hover:opacity-90 transition">
                            Apply Price
                        </button>
                        <div class="space-y-1.5">
                            @foreach (['0-5000' => 'Under KSh 5,000', '5000-20000' => 'KSh 5,000 – 20,000', '20000-50000' => 'KSh 20,000 – 50,000', '50000-100000' => 'KSh 50,000 – 100,000', '100000+' => 'Over KSh 100,000'] as $val => $lbl)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="price_range" value="{{ $val }}"
                                           class="accent-primary"
                                           {{ $filters['price_range'] === $val ? 'checked' : '' }}
                                           onchange="this.closest('form').submit()">
                                    <span class="text-xs text-gray-600 group-hover:text-primary transition">{{ $lbl }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                </form>

            </aside>

            {{-- ---------------
            -- Product Grid
            -- --------------- --}}
            <div class="flex-1 min-w-0">

                {{-- Mobile filter toggle --}}
                <div class="md:hidden mb-4" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 text-xs border border-border rounded-[12px] px-4 py-2 bg-white text-gray-600 shadow-sm">
                        <i class="fas fa-sliders-h"></i>
                        Filters
                        @if (request('category_id') || request('brand_id') || request('label_id'))
                            <span class="bg-primary text-white text-[10px] rounded-[12px] w-4 h-4 flex items-center justify-center">
                                {{ (request('category_id') ? 1 : 0) + (request('brand_id') ? 1 : 0) + (request('label_id') ? 1 : 0) }}
                            </span>
                        @endif
                    </button>

                    <div x-show="open" x-transition class="mt-3 space-y-3">
                        {{-- Categories --}}
                        <div class="bg-white border border-border rounded-[12px] p-4">
                            <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Category</h4>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($categories as $category)
                                    @php
                                        $isActive  = request('category_id') == $category->id;
                                        $filterUrl = $isActive
                                            ? route('frontend.products', request()->except(['category_id', 'page']))
                                            : route('frontend.products', array_merge(request()->except(['category_id', 'page']), ['category_id' => $category->id]));
                                    @endphp
                                    <a href="{{ $filterUrl }}"
                                        class="text-xs px-3 py-1.5 rounded-[12px] border transition text-center
                                        {{ $isActive ? 'bg-primary text-white border-primary' : 'border-border text-gray-600 hover:border-primary hover:text-primary' }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- Brands --}}
                        @if ($brands->isNotEmpty())
                            <div class="bg-white border border-border rounded-[12px] p-4">
                                <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Brand</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach ($brands as $brand)
                                        @php
                                            $isActive  = request('brand_id') == $brand->id;
                                            $filterUrl = $isActive
                                                ? route('frontend.products', request()->except(['brand_id', 'page']))
                                                : route('frontend.products', array_merge(request()->except(['brand_id', 'page']), ['brand_id' => $brand->id]));
                                        @endphp
                                        <a href="{{ $filterUrl }}"
                                            class="text-xs px-3 py-1.5 rounded-[12px] border transition text-center
                                            {{ $isActive ? 'bg-primary text-white border-primary' : 'border-border text-gray-600 hover:border-primary hover:text-primary' }}">
                                            {{ $brand->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Labels --}}
                        @if ($labels->isNotEmpty())
                            <div class="bg-white border border-border rounded-[12px] p-4">
                                <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Label</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach ($labels as $label)
                                        @php
                                            $isActive  = request('label_id') == $label->id;
                                            $filterUrl = $isActive
                                                ? route('frontend.products', request()->except(['label_id', 'page']))
                                                : route('frontend.products', array_merge(request()->except(['label_id', 'page']), ['label_id' => $label->id]));
                                        @endphp
                                        <a href="{{ $filterUrl }}"
                                            class="flex items-center justify-center gap-1.5 text-xs px-3 py-1.5 rounded-[12px] border transition text-center
                                            {{ $isActive ? 'bg-primary text-white border-primary' : 'border-border text-gray-600 hover:border-primary hover:text-primary' }}">
                                            <span class="inline-block w-2 h-2 rounded-[12px] flex-shrink-0"
                                                style="background-color: {{ $label->color_code ?? '#9ca3af' }}"></span>
                                            {{ $label->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Price Range (mobile) --}}
                        <form method="GET" action="{{ route('frontend.products') }}">
                            @foreach (request()->except(['min_price', 'max_price', 'price_range', 'condition', 'page']) as $key => $value)
                                @if (is_array($value))
                                    @foreach ($value as $v)
                                        <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <div class="bg-white border border-border rounded-[12px] p-4">
                                <h4 class="text-xs font-bold text-text uppercase tracking-wide mb-3">Price (KSh)</h4>
                                <div class="flex items-center gap-2 mb-2">
                                    <input type="number" name="min_price" placeholder="Min" value="{{ $filters['min_price'] }}"
                                           class="w-full text-xs border border-border rounded-[8px] px-2 py-1.5 outline-none focus:border-primary">
                                    <span class="text-muted text-xs">–</span>
                                    <input type="number" name="max_price" placeholder="Max" value="{{ $filters['max_price'] }}"
                                           class="w-full text-xs border border-border rounded-[8px] px-2 py-1.5 outline-none focus:border-primary">
                                </div>
                                <button type="submit" class="w-full text-[10px] font-bold bg-primary text-white rounded-[8px] py-1.5 mb-3 hover:opacity-90 transition">Apply Price</button>
                                <div class="grid grid-cols-2 gap-1.5">
                                    @foreach (['0-5000' => 'Under KSh 5K', '5000-20000' => 'KSh 5K–20K', '20000-50000' => 'KSh 20K–50K', '50000-100000' => 'KSh 50K–100K', '100000+' => 'Over KSh 100K'] as $val => $lbl)
                                        <label class="flex items-center gap-1.5 text-xs px-2 py-1.5 rounded-[12px] border cursor-pointer transition
                                            {{ $filters['price_range'] === $val ? 'bg-primary text-white border-primary' : 'border-border text-gray-600' }}">
                                            <input type="radio" name="price_range" value="{{ $val }}" class="hidden"
                                                   {{ $filters['price_range'] === $val ? 'checked' : '' }}
                                                   onchange="this.closest('form').submit()">
                                            {{ $lbl }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 md:gap-4">
                    @forelse ($products as $product)
                        @include('frontend.partials.product-card', ['product' => $product])
                    @empty
                        <div class="col-span-full text-center py-16">
                            <i class="fas fa-box-open text-4xl text-gray-200 mb-4 block"></i>
                            <p class="text-sm font-semibold text-text mb-1">No products found</p>
                            <p class="text-xs text-muted">Try adjusting your filters.</p>
                        </div>
                    @endforelse
                </div>

                {{-- ---------------
                -- Pagination
                -- --------------- --}}
                @if ($products->hasPages())
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>
    </div>

@endsection
