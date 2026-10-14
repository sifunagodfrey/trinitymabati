@extends('frontend.layouts.app')

@section('title', 'Roofing Categories & Products | ' . config('app.name'))
@section('meta_description', 'Browse Trinity Mabati Factory roofing sheets by profile and discover available products.')

@section('content')
<div class="border-b border-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center gap-2 text-xs text-muted" aria-label="Breadcrumb">
            <a href="{{ route('frontend.home') }}" class="hover:text-primary">Home</a>
            <i class="fas fa-chevron-right text-[9px]" aria-hidden="true"></i>
            <span class="font-medium text-text">All Categories</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
    <div class="relative group/rail">
        <button type="button" aria-label="Scroll categories left" onclick="document.getElementById('roof-category-rail').scrollBy({left:-360,behavior:'smooth'})" class="absolute left-0 top-[38%] -translate-y-1/2 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white border border-gray-200 shadow-sm hover:text-primary">
            <i class="fas fa-chevron-left" aria-hidden="true"></i>
        </button>
        <div id="roof-category-rail" class="flex gap-3 overflow-x-auto snap-x snap-mandatory scroll-smooth px-1 pb-3 scrollbar-hide" style="scrollbar-width:none;-ms-overflow-style:none">
            @foreach ($categories as $cat)
                @php
                    $image = null;
                    if ($cat->featured_image) {
                        $image = asset(str_starts_with($cat->featured_image, 'uploads/') ? $cat->featured_image : 'categories/featured/' . $cat->featured_image);
                    } elseif (isset($categoryImages[$cat->id])) {
                        $thumb = $categoryImages[$cat->id];
                        $image = asset(str_starts_with($thumb, 'uploads/') ? $thumb : 'uploads/products/images/' . $thumb);
                    }
                @endphp
                <a href="{{ route('frontend.categories', ['category' => $cat->slug]) }}" class="w-[112px] sm:w-[138px] shrink-0 snap-start group text-center" @if ($selectedSlug === $cat->slug) aria-current="page" @endif>
                    <span class="relative block aspect-square overflow-hidden rounded-lg border-2 {{ $selectedSlug === $cat->slug ? 'border-primary' : 'border-gray-200' }} bg-white group-hover:border-primary/70 transition">
                        @if ($image)
                            <img src="{{ $image }}" alt="{{ $cat->name }}" loading="lazy" class="h-full w-full object-cover" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                            <span style="display:none" class="absolute inset-0 items-center justify-center text-xl font-semibold text-primary">{{ mb_strtoupper(mb_substr($cat->name,0,1)) }}</span>
                        @else
                            <span class="absolute inset-0 flex items-center justify-center text-xl font-semibold text-primary">{{ mb_strtoupper(mb_substr($cat->name,0,1)) }}</span>
                        @endif
                    </span>
                    <span class="mt-2 block truncate whitespace-nowrap text-xs sm:text-sm {{ $selectedSlug === $cat->slug ? 'text-primary font-bold' : 'text-text font-medium' }}" title="{{ $cat->name }}">{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>
        <button type="button" aria-label="Scroll categories right" onclick="document.getElementById('roof-category-rail').scrollBy({left:360,behavior:'smooth'})" class="absolute right-0 top-[38%] -translate-y-1/2 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white border border-gray-200 shadow-sm hover:text-primary">
            <i class="fas fa-chevron-right" aria-hidden="true"></i>
        </button>
    </div>

    <section class="mt-8 md:mt-10" aria-label="Roofing products">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <h1 class="text-lg sm:text-xl font-bold text-primary">{{ $selectedSlug ? ($categories->firstWhere('slug', $selectedSlug)?->name ?? 'Products') : 'All Products' }}</h1>
            <p class="text-sm text-muted">{{ number_format($products->total()) }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }}</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
            @forelse ($products as $product)
                @include('frontend.partials.product-card', ['product' => $product])
            @empty
                <div class="col-span-full rounded-lg bg-white px-6 py-14 text-center text-muted">
                    <i class="fas fa-box-open text-3xl mb-3 block" aria-hidden="true"></i>
                    <p>No products available in this category yet.</p>
                </div>
            @endforelse
        </div>
        @if ($products->hasPages())
            <nav aria-label="Product pages" class="mt-8 flex flex-wrap items-center justify-center gap-3">
                @if ($products->onFirstPage())
                    <span class="px-4 py-2 border border-gray-200 rounded-md text-gray-400">Previous</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="px-4 py-2 border border-gray-200 rounded-md hover:border-primary hover:text-primary">Previous</a>
                @endif
                <span class="text-sm text-muted">Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</span>
                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="px-4 py-2 border border-gray-200 rounded-md hover:border-primary hover:text-primary">Next</a>
                @else
                    <span class="px-4 py-2 border border-gray-200 rounded-md text-gray-400">Next</span>
                @endif
            </nav>
        @endif
    </section>
</div>
@endsection
