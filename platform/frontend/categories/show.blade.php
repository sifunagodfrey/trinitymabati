@extends('frontend.layouts.app')

@section('title', $categoryModel->name . ' | ' . config('app.name'))
@section('meta_description', 'Explore ' . $categoryModel->name . ' at Trinity Mabati Factory.')

@section('content')
<div class="border-b border-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-2 text-xs text-muted">
            @foreach ($breadcrumb as $crumb)
                @if (!$loop->first)
                    <i class="fas fa-chevron-right text-[9px]" aria-hidden="true"></i>
                @endif
                @if ($crumb['url'])
                    <a href="{{ $crumb['url'] }}" class="hover:text-primary">{{ $crumb['label'] }}</a>
                @else
                    <span class="font-semibold text-text">{{ $crumb['label'] }}</span>
                @endif
            @endforeach
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
    @if ($sections->isNotEmpty())
        @foreach ($sections as $section)
            @php $railId = 'subcategory-products-' . $section['category']->id; @endphp
            <section class="mb-10 md:mb-14" aria-labelledby="subcategory-title-{{ $section['category']->id }}">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <h1 id="subcategory-title-{{ $section['category']->id }}" class="text-lg sm:text-2xl font-bold text-primary">
                        {{ $section['category']->name }}
                    </h1>
                    <a class="shrink-0 text-xs sm:text-sm font-semibold text-primary hover:underline" href="{{ route('frontend.categories.show', $section['category']->slug) }}">View all <i class="fas fa-arrow-right ml-1" aria-hidden="true"></i></a>
                </div>
                <div class="relative">
                    <button type="button" aria-label="Scroll {{ $section['category']->name }} products left" onclick="document.getElementById('{{ $railId }}').scrollBy({left:-document.getElementById('{{ $railId }}').clientWidth*.8,behavior:'smooth'})" class="absolute -left-2 sm:-left-4 top-1/2 -translate-y-1/2 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white border border-gray-200 shadow text-text hover:text-primary"><i class="fas fa-chevron-left text-xs" aria-hidden="true"></i></button>
                    <div id="{{ $railId }}" class="flex items-stretch gap-3 sm:gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-3 px-1" style="scrollbar-width:none;-ms-overflow-style:none">
                        @foreach ($section['products'] as $product)
                            <div class="shrink-0 snap-start w-[43%] sm:w-[31%] lg:w-[23%] flex flex-col [&>a]:h-full">
                                @include('frontend.partials.product-card', ['product' => $product])
                            </div>
                        @endforeach
                        <a href="{{ route('frontend.categories.show', $section['category']->slug) }}" class="shrink-0 snap-start w-[43%] sm:w-[31%] lg:w-[23%] min-h-[260px] flex flex-col items-center justify-center gap-3 bg-white border border-gray-200 rounded-lg text-primary hover:border-primary hover:shadow-sm transition">
                            <span class="flex items-center justify-center h-12 w-12 rounded-full bg-red-50"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                            <span class="font-bold">View More</span>
                        </a>
                    </div>
                    <button type="button" aria-label="Scroll {{ $section['category']->name }} products right" onclick="document.getElementById('{{ $railId }}').scrollBy({left:document.getElementById('{{ $railId }}').clientWidth*.8,behavior:'smooth'})" class="absolute -right-2 sm:-right-4 top-1/2 -translate-y-1/2 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white border border-gray-200 shadow text-text hover:text-primary"><i class="fas fa-chevron-right text-xs" aria-hidden="true"></i></button>
                </div>
            </section>
        @endforeach
    @elseif ($products)
        <section aria-label="{{ $categoryModel->name }} products">
            <h1 class="text-xl sm:text-2xl font-bold text-primary mb-5">{{ $categoryModel->name }}</h1>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 items-stretch">
                @forelse ($products as $product)
                    <div class="[&>a]:h-full">@include('frontend.partials.product-card', ['product' => $product])</div>
                @empty
                    <div class="col-span-full bg-white text-center text-muted rounded-lg py-14">No products available in this category yet.</div>
                @endforelse
            </div>
            @if ($products->hasPages())
                <div class="mt-8">{{ $products->links() }}</div>
            @endif
        </section>
    @else
        <div class="text-center text-muted py-14">No products available yet.</div>
    @endif
</div>
@endsection
