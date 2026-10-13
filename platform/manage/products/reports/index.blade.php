@extends('manage.layouts.app')

@section('title', 'Product Reports')

@section('content')
    {{-- ---------------
    -- manage/products/reports/index.blade.php
    -- --------------- --}}

    {{-- ---------------
    -- Breadcrumb & Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.products.all.index') }}" class="hover:text-primary">Products</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Reports</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Product Performance Reports</h1>
                <p class="text-sm text-muted">Track individual product metrics, stock levels, and sales revenue.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('manage.products.all.index') }}"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-white px-4 py-2 text-sm font-medium text-black transition hover:bg-slate-50">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back to Products
                </a>
                <a href="{{ route('manage.products.reports.index', array_merge(request()->except('page'), ['export' => 'csv'])) }}"
                    class="inline-flex items-center gap-2 rounded-[12px] bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700">
                    <i class="fa-solid fa-file-csv text-xs"></i>
                    Export CSV
                </a>
                <a href="{{ route('manage.products.reports.index', array_merge(request()->except('page'), ['export' => 'pdf'])) }}"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2 text-sm font-medium text-black transition hover:bg-slate-100">
                    <i class="fa-solid fa-file-pdf text-xs text-red-600"></i>
                    Export PDF
                </a>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Summary Cards
    -- --------------- --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        {{-- Total Products --}}
        <a href="{{ route('manage.products.all.index') }}" class="block">
            <div class="bg-white border border-border rounded-[8px] p-5 flex items-center justify-between shadow-sm hover:shadow-md transition">
                <div>
                    <p class="text-xs text-muted uppercase tracking-wide">Total Products</p>
                    <p class="text-2xl font-bold text-text mt-1">{{ number_format($stats['total']) }}</p>
                    <p class="text-xs text-muted mt-1">{{ number_format($stats['active']) }} active</p>
                </div>
                <div class="w-12 h-12 rounded-[12px] bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-box text-blue-500 text-lg"></i>
                </div>
            </div>
        </a>

        {{-- Out of Stock --}}
        <a href="{{ route('manage.products.all.index') }}" class="block">
            <div class="bg-white border border-border rounded-[8px] p-5 flex items-center justify-between shadow-sm hover:shadow-md transition">
                <div>
                    <p class="text-xs text-muted uppercase tracking-wide">Out of Stock</p>
                    <p class="text-2xl font-bold text-text mt-1">{{ number_format($stats['out_of_stock']) }}</p>
                    <p class="text-xs text-orange-500 mt-1">{{ number_format($stats['low_stock']) }} low stock</p>
                </div>
                <div class="w-12 h-12 rounded-[12px] bg-red-500/10 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-lg"></i>
                </div>
            </div>
        </a>

        {{-- Top Seller This Month --}}
        <div class="bg-white border border-border rounded-[8px] p-5 flex items-center justify-between shadow-sm">
            <div class="min-w-0 flex-1 pr-3">
                <p class="text-xs text-muted uppercase tracking-wide">Top Seller (This Month)</p>
                @if ($topSeller)
                    <a href="{{ route('manage.products.all.show', $topSeller->id) }}"
                        class="block text-base font-bold text-green-600 mt-1 truncate hover:underline"
                        title="{{ $topSeller->name }}">
                        {{ $topSeller->name }}
                    </a>
                    <p class="text-xs text-muted mt-1">By units sold</p>
                @else
                    <p class="text-2xl font-bold text-text mt-1">N/A</p>
                    <p class="text-xs text-muted mt-1">No sales this month</p>
                @endif
            </div>
            <div class="w-12 h-12 rounded-[12px] bg-green-500/10 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-star text-green-500 text-lg"></i>
            </div>
        </div>

        {{-- Most Viewed Product --}}
        <div class="bg-white border border-border rounded-[8px] p-5 flex items-center justify-between shadow-sm">
            <div class="min-w-0 flex-1 pr-3">
                <p class="text-xs text-muted uppercase tracking-wide">Most Viewed</p>
                @if ($mostViewed)
                    <a href="{{ route('manage.products.all.show', $mostViewed->id) }}"
                        class="block text-base font-bold text-purple-600 mt-1 truncate hover:underline"
                        title="{{ $mostViewed->name }}">
                        {{ $mostViewed->name }}
                    </a>
                    <p class="text-xs text-muted mt-1">{{ number_format($mostViewed->views) }} views</p>
                @else
                    <p class="text-2xl font-bold text-text mt-1">N/A</p>
                    <p class="text-xs text-muted mt-1">No views recorded</p>
                @endif
            </div>
            <div class="w-12 h-12 rounded-[12px] bg-purple-500/10 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-eye text-purple-500 text-lg"></i>
            </div>
        </div>

    </div>

    {{-- ---------------
    -- Detailed Product Report Table
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-5">
            <h2 class="text-lg font-semibold text-black">Detailed Product Report</h2>
            <span class="text-sm text-muted">{{ $products->total() }} products found</span>
        </div>

        {{-- ---------------
        -- Search Bar
        -- --------------- --}}
        <form method="GET" action="{{ route('manage.products.reports.index') }}" class="mb-5">
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                    <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                    <input type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search by product name..."
                        class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                    @if ($search)
                        <a href="{{ route('manage.products.reports.index') }}"
                            class="pr-3 text-muted hover:text-red-400 transition text-xs">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    Search
                </button>
            </div>
        </form>

        {{-- ---------------
        -- Products Table
        -- --------------- --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[960px]">
                <thead>
                    <tr class="border-b border-border text-xs text-muted uppercase tracking-wide">
                        <th class="pb-3 pl-2 text-left font-medium w-8">#</th>
                        <th class="pb-3 text-left font-medium">Product</th>
                        <th class="pb-3 text-left font-medium">Category</th>
                        <th class="pb-3 text-right font-medium">Units Sold</th>
                        <th class="pb-3 text-right font-medium">Revenue (KES)</th>
                        <th class="pb-3 text-right font-medium">Est. Cost (KES)</th>
                        <th class="pb-3 text-right font-medium">Est. Profit (KES)</th>
                        <th class="pb-3 text-right font-medium">Views</th>
                        <th class="pb-3 text-right font-medium">Stock</th>
                        <th class="pb-3 text-center font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($products as $index => $product)
                        <tr class="hover:bg-slate-50 cursor-pointer transition"
                            onclick="window.location='{{ route('manage.products.all.show', $product->id) }}'">

                            <td class="py-3 pl-2 text-muted text-xs">
                                {{ $products->firstItem() + $index }}
                            </td>

                            <td class="py-3 pr-4 max-w-[220px]">
                                <a href="{{ route('manage.products.all.show', $product->id) }}"
                                    onclick="event.stopPropagation();"
                                    class="font-semibold text-black hover:text-primary truncate block"
                                    title="{{ $product->name }}">
                                    {{ $product->name }}
                                </a>
                                @if ($product->is_variant)
                                    <span class="text-xs text-muted">Has variants</span>
                                @endif
                            </td>

                            <td class="py-3 pr-4 text-muted">
                                {{ $product->category?->name ?? 'Uncategorized' }}
                            </td>

                            <td class="py-3 pr-4 text-right tabular-nums">
                                {{ number_format((int) $product->units_sold) }}
                            </td>

                            <td class="py-3 pr-4 text-right tabular-nums">
                                {{ number_format((float) $product->revenue, 2) }}
                            </td>

                            <td class="py-3 pr-4 text-right tabular-nums text-muted">
                                {{ $product->est_cost > 0 ? number_format((float) $product->est_cost, 2) : '-' }}
                            </td>

                            @php $estProfit = (float) $product->revenue - (float) $product->est_cost; @endphp
                            <td class="py-3 pr-4 text-right tabular-nums font-semibold {{ $estProfit >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $product->est_cost > 0 ? number_format($estProfit, 2) : '-' }}
                            </td>

                            <td class="py-3 pr-4 text-right tabular-nums text-muted">
                                {{ number_format((int) $product->views) }}
                            </td>

                            <td class="py-3 pr-4 text-right tabular-nums">
                                @if ($product->is_variant)
                                    <span class="text-xs text-muted italic">per variant</span>
                                @else
                                    {{ number_format((int) $product->stock_quantity) }}
                                @endif
                            </td>

                            <td class="py-3 text-center">
                                @if ($product->is_variant)
                                    <span class="inline-flex items-center rounded-[12px] px-2.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-800">
                                        Variants
                                    </span>
                                @elseif ((int) $product->stock_quantity <= 0)
                                    <span class="inline-flex items-center rounded-[12px] px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800">
                                        Out of Stock
                                    </span>
                                @elseif ((int) $product->stock_quantity < 10)
                                    <span class="inline-flex items-center rounded-[12px] px-2.5 py-0.5 text-xs font-medium bg-orange-100 text-orange-800">
                                        Low Stock
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-[12px] px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-12 text-center text-muted text-sm">
                                <i class="fa-solid fa-box-open text-3xl mb-3 block opacity-30"></i>
                                No products found
                                @if ($search)
                                    for &ldquo;{{ $search }}&rdquo;
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ---------------
        -- Pagination
        -- --------------- --}}
        @if ($products->hasPages())
            <div class="mt-5 border-t border-border pt-5">
                {{ $products->links() }}
            </div>
        @endif

    </div>

    {{-- ---------------
    -- Category & Brand Breakdown
    -- --------------- --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- By Category --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-black mb-4">Products by Category</h2>
            @forelse ($byCategory as $cat)
                <div class="flex items-center justify-between py-2 border-b border-border last:border-0">
                    <a href="{{ route('manage.products.all.index', ['category_id' => $cat->id]) }}"
                        class="text-sm text-black hover:text-primary truncate max-w-[65%]">
                        {{ $cat->name }}
                    </a>
                    <span class="text-sm font-semibold text-text tabular-nums">
                        {{ number_format($cat->products_count) }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-muted">No category data available.</p>
            @endforelse
        </div>

        {{-- By Brand --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-black mb-4">Products by Brand</h2>
            @forelse ($byBrand as $brand)
                <div class="flex items-center justify-between py-2 border-b border-border last:border-0">
                    <a href="{{ route('manage.products.all.index', ['brand_id' => $brand->id]) }}"
                        class="text-sm text-black hover:text-primary truncate max-w-[65%]">
                        {{ $brand->name }}
                    </a>
                    <span class="text-sm font-semibold text-text tabular-nums">
                        {{ number_format($brand->products_count) }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-muted">No brand data available.</p>
            @endforelse
        </div>

    </div>

@endsection
