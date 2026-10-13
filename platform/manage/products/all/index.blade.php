@extends('manage.layouts.app')

@section('title', 'All Products')

@section('content')
    {{-- manage/products/all/index.blade.php --}}

    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.products.all.index') }}" class="hover:text-primary">Products</a></li>
                <li>/</li>
                <li class="text-black font-semibold">All Products</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">All Products</h1>
                <p class="text-sm text-muted">View and manage every product listed in the marketplace.</p>
            </div>

            <a href="{{ route('manage.products.add.create') }}"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-plus"></i>
                Add Product
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        {{-- Search + Filter Bar (unchanged) --}}
        <div x-data="{
                open: {{ (request('category_id') || request('brand_id') || request('label_id')) ? 'true' : 'false' }}
            }"
            class="mb-6">

            <form id="productsFilterForm" method="GET" action="{{ route('manage.products.all.index') }}">

                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                        <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                        <input type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search by product name or SKU..."
                            class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                        @if (request('search'))
                            <a href="{{ route('manage.products.all.index', request()->except(['search', 'page'])) }}"
                                class="pr-3 text-muted hover:text-red-400 transition text-xs">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </div>

                    <select name="sort" onchange="this.form.submit()"
                        class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                        <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A–Z</option>
                        <option value="stock_asc" {{ request('sort') === 'stock_asc' ? 'selected' : '' }}>Stock: Low to High</option>
                    </select>

                    <select name="per_page" onchange="this.form.submit()"
                        class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20 / page</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / page</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / page</option>
                    </select>

                    <button type="button" @click="open = !open"
                        class="relative inline-flex items-center justify-center w-11 h-11 rounded-[12px] border transition
                               focus:outline-none focus:ring-2 focus:ring-primary/20"
                        :class="open ? 'bg-primary text-white border-primary' : 'bg-white text-black border-border hover:border-primary hover:text-primary'"
                        title="Toggle filters">
                        <i class="fa-solid fa-sliders text-sm"></i>
                        @php $activeFilterCount = (request('category_id') ? 1 : 0) + (request('brand_id') ? 1 : 0) + (request('label_id') ? 1 : 0); @endphp
                        @if ($activeFilterCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 w-4 h-4 rounded-[12px] bg-red-500 text-white text-[9px] font-bold flex items-center justify-center">
                                {{ $activeFilterCount }}
                            </span>
                        @endif
                    </button>

                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Search
                    </button>
                </div>

                <div x-show="open"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4 rounded-[12px] border border-border bg-white p-4">

                    <div>
                        <label class="block text-xs font-semibold text-black uppercase tracking-wide mb-1.5">Category</label>
                        <select name="category_id"
                            class="w-full rounded-[8px] border border-border bg-background px-3 py-2.5 text-sm text-text outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-black uppercase tracking-wide mb-1.5">Brand</label>
                        <select name="brand_id"
                            class="w-full rounded-[8px] border border-border bg-background px-3 py-2.5 text-sm text-text outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            <option value="">All Brands</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }} ({{ $brand->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-black uppercase tracking-wide mb-1.5">Label</label>
                        <select name="label_id"
                            class="w-full rounded-[8px] border border-border bg-background px-3 py-2.5 text-sm text-text outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                            <option value="">All Labels</option>
                            @foreach ($labels as $label)
                                <option value="{{ $label->id }}" {{ request('label_id') == $label->id ? 'selected' : '' }}>
                                    {{ $label->name }} ({{ $label->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-3 flex items-center justify-end gap-3 pt-2 border-t border-border">
                        <a href="{{ route('manage.products.all.index', request()->only(['search', 'sort', 'per_page'])) }}"
                            class="text-xs text-black hover:text-black transition">Clear Filters</a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-[8px] bg-primary px-4 py-2 text-xs font-medium text-white transition hover:bg-primary-dark">Apply Filters</button>
                    </div>
                </div>

            </form>
        </div>

        {{-- Active Filter Tags --}}
        @if (request('category_id') || request('brand_id') || request('label_id') || request('search') || request('stock_status') === 'low')
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="text-xs text-muted">Filtered by:</span>
                @if (request('stock_status') === 'low')
                    <a href="{{ route('manage.products.all.index', request()->except(['stock_status', 'page'])) }}"
                        class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-medium px-3 py-1 rounded-[12px] hover:bg-primary/20 transition">
                        Low stock only
                        <i class="fa-solid fa-xmark text-[9px]"></i>
                    </a>
                @endif
                @if (request('category_id') && $categories->find(request('category_id')))
                    <a href="{{ route('manage.products.all.index', request()->except(['category_id', 'page'])) }}"
                        class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-medium px-3 py-1 rounded-[12px] hover:bg-primary/20 transition">
                        Category: {{ $categories->find(request('category_id'))->name }}
                        <i class="fa-solid fa-xmark text-[9px]"></i>
                    </a>
                @endif
                @if (request('brand_id') && $brands->find(request('brand_id')))
                    <a href="{{ route('manage.products.all.index', request()->except(['brand_id', 'page'])) }}"
                        class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-medium px-3 py-1 rounded-[12px] hover:bg-primary/20 transition">
                        Brand: {{ $brands->find(request('brand_id'))->name }}
                        <i class="fa-solid fa-xmark text-[9px]"></i>
                    </a>
                @endif
                @if (request('label_id') && $labels->find(request('label_id')))
                    <a href="{{ route('manage.products.all.index', request()->except(['label_id', 'page'])) }}"
                        class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-medium px-3 py-1 rounded-[12px] hover:bg-primary/20 transition">
                        Label: {{ $labels->find(request('label_id'))->name }}
                        <i class="fa-solid fa-xmark text-[9px]"></i>
                    </a>
                @endif
                @if (request('search'))
                    <a href="{{ route('manage.products.all.index', request()->except(['search', 'page'])) }}"
                        class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-medium px-3 py-1 rounded-[12px] hover:bg-primary/20 transition">
                        "{{ request('search') }}"
                        <i class="fa-solid fa-xmark text-[9px]"></i>
                    </a>
                @endif
                <a href="{{ route('manage.products.all.index') }}" class="text-xs text-muted hover:text-text underline transition">Clear all</a>
            </div>
        @endif

        {{-- Products Table (unchanged) --}}
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($products as $product)
                        <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('manage.products.all.show', $product->id) }}'">
                            <td class="px-4 py-4 font-medium text-black">{{ $product->id }}</td>
                            <td class="px-4 py-4">
                                <div class="h-14 w-14 overflow-hidden rounded-[12px] bg-slate-100">
                                    @if ($product->thumbnail)
                                        <img src="{{ asset(str_starts_with($product->thumbnail, 'uploads/') || str_starts_with($product->thumbnail, 'storage/') ? $product->thumbnail : (str_starts_with($product->thumbnail, 'products/') ? 'storage/' . $product->thumbnail : 'uploads/products/images/' . $product->thumbnail)) }}"
                                            alt="{{ $product->name }}" class="h-full w-full object-cover" />
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <i class="fa-solid fa-image text-slate-300 text-lg"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-black">{{ Str::limit($product->name, 40) }}</div>
                                <div class="text-xs text-muted">SKU: {{ $product->sku ?? '-' }}</div>
                                @if ($product->labels->isNotEmpty())
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        @foreach ($product->labels as $label)
                                            <span class="inline-flex items-center text-[10px] font-medium text-white px-1.5 py-0.5 rounded-[12px]"
                                                style="background-color: {{ $label->color_code ?? '#9ca3af' }}">
                                                {{ $label->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-black">
                                {{ $product->categories->isNotEmpty() ? $product->categories->pluck('name')->join(', ') : '-' }}
                            </td>                  
                            <td class="px-4 py-4 text-sm text-black">
                                @php
                                    $priceDisplay  = null;
                                    $priceSubLabel = null;
                                    if ($product->is_variant && $product->variants->isNotEmpty()) {
                                        $vMin = (float) $product->variants->min('price');
                                        $vMax = (float) $product->variants->max('price');
                                        $priceDisplay  = $vMin === $vMax ? 'KES ' . number_format($vMin, 2) : 'KES ' . number_format($vMin, 2) . ' – ' . number_format($vMax, 2);
                                        $priceSubLabel = 'variant';
                                    }
                                @endphp
                                @if ($priceDisplay)
                                    <span class="font-semibold">{{ $priceDisplay }}</span>
                                    <div class="text-xs text-muted">{{ $priceSubLabel }}</div>
                                @elseif ($product->sale_price && $product->sale_price < $product->price)
                                    <span class="font-semibold">KES {{ number_format($product->sale_price, 2) }}</span>
                                    <div class="text-xs text-muted line-through">KES {{ number_format($product->price, 2) }}</div>
                                @else
                                    KES {{ number_format($product->price, 2) }}
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm">
                                @php $displayStock = ($product->is_variant && $product->variants->isNotEmpty()) ? $product->variants->sum('stock_quantity') : $product->stock_quantity; @endphp
                                <span class="{{ $displayStock > 0 ? 'text-black' : 'text-rose-600 font-semibold' }}">{{ $displayStock }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold {{ $product->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right" onclick="event.stopPropagation()">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('manage.products.all.show', $product->id) }}"
                                        title="View"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('manage.products.all.edit', $product->id) }}"
                                        title="Edit"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    {{-- Activate / Deactivate button --}}
                                    <form action="{{ route('manage.products.all.toggle-active', $product->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            title="{{ $product->is_active ? 'Deactivate' : 'Activate' }}"
                                            onclick="return confirm('Are you sure you want to {{ $product->is_active ? 'deactivate' : 'activate' }} this product?')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] transition
                                                {{ $product->is_active
                                                    ? 'border border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100'
                                                    : 'border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                            <i class="fa-solid {{ $product->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-xs"></i>
                                        </button>
                                    </form>
                                    <form id="product-delete-{{ $product->id }}"
                                        action="{{ route('manage.products.all.destroy', $product->id) }}"
                                        method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            title="Delete"
                                            onclick="confirmProductDelete('product-delete-{{ $product->id }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-rose-200 bg-rose-50 text-rose-700 transition hover:bg-rose-100">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center text-sm text-muted">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fa-solid fa-box-open text-3xl text-slate-300"></i>
                                    <span>No products found. Try adjusting your search or filters.</span>
                                    @if (request()->hasAny(['search', 'category_id', 'brand_id', 'label_id']))
                                        <a href="{{ route('manage.products.all.index') }}" class="text-xs text-primary hover:underline">Clear all filters</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        {{-- Pagination (unchanged) --}}
        <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-muted">
                Showing {{ $products->firstItem() ?? 0 }} – {{ $products->lastItem() ?? 0 }}
                of {{ $products->total() }} products
            </p>
            <div>{{ $products->links() }}</div>
        </div>

    </div>


@endsection

@push('scripts')
    <script>
        function confirmProductDelete(formId) {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                document.getElementById(formId).submit();
            }
        }

    </script>
@endpush
