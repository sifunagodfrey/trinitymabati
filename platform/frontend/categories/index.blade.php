{{-- -------------------
     All Categories
     Clean image-card grid of categories that contain products. No search
     hero and no A-Z filter - tapping a card opens that category.
------------------- --}}
@extends('frontend.layouts.app')

@section('title', 'Shop by Category | ' . config('app.name'))
@section('meta_description', 'Browse stationery, office supplies, school essentials and workplace accessories at ' . config('app.name') . '.')

@section('content')

    <style>
        .cat-grid-item {
            width: 88px;
        }

        @media (min-width: 768px) {
            .cat-grid-item {
                width: 104px;
            }
        }
    </style>

    {{-- Breadcrumb (on the page background) --}}
    <div class="border-b border-border">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-3">
            <nav class="text-xs text-muted flex items-center gap-2" aria-label="Breadcrumb">
                <a href="{{ route('frontend.home') }}" class="hover:text-primary transition">Home</a>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <span class="text-text font-medium">All Categories</span>
            </nav>
        </div>
    </div>

    {{-- Grey band: starts at the Shop by Category header --}}
    <div class="bg-primary-light/30">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-6 md:py-8">

            {{-- Header --}}
            <div class="flex items-end justify-between gap-3 mb-6">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-text">Shop by Category</h1>
                    <p class="text-sm text-muted mt-0.5">Everything for school, work and creative projects</p>
                </div>
                <a href="{{ route('frontend.products') }}"
                    class="text-xs text-primary font-semibold hover:underline whitespace-nowrap">
                    View All Products
                </a>
            </div>

            {{-- =========================
             CATEGORY GRID (image cards, 8 per row desktop / 4 mobile)
        ========================= --}}
            <div class="flex flex-wrap gap-2.5 md:gap-3">
                @forelse ($categories as $cat)
                    @php
                        $catImage = null;
                        if ($cat->featured_image) {
                            $catImage = asset(
                                str_starts_with($cat->featured_image, 'uploads/')
                                    ? $cat->featured_image
                                    : 'categories/featured/' . $cat->featured_image,
                            );
                        } elseif (isset($categoryImages[$cat->id])) {
                            $thumb = $categoryImages[$cat->id];
                            $catImage = asset(
                                str_starts_with($thumb, 'uploads/') ? $thumb : 'uploads/products/images/' . $thumb,
                            );
                        }
                        $initial = mb_strtoupper(mb_substr($cat->name, 0, 1));
                    @endphp
                    <a href="{{ route('frontend.categories.show', $cat->slug) }}"
                        class="cat-grid-item group flex flex-col transition">
                        <span
                            class="relative block w-full rounded-[12px] overflow-hidden border-2 border-border bg-white group-hover:border-primary/50 group-hover:shadow-md transition"
                            style="aspect-ratio: 1 / 1;">
                            <span class="absolute inset-0 overflow-hidden">
                                @if ($catImage)
                                    <img src="{{ $catImage }}" alt="{{ $cat->name }}" loading="lazy"
                                        onerror="this.replaceWith(Object.assign(document.createElement('span'),{className:'absolute inset-0 flex items-center justify-center text-2xl font-extrabold text-primary/30',textContent:'{{ $initial }}'}));"
                                        class="absolute inset-0 w-full h-full object-cover">
                                @else
                                    <span
                                        class="absolute inset-0 flex items-center justify-center text-2xl font-extrabold text-primary/40">{{ $initial }}</span>
                                @endif
                            </span>
                        </span>
                        <span
                            class="mt-1.5 h-8 flex items-start justify-center text-center text-[11px] md:text-xs font-medium text-text leading-tight line-clamp-2 group-hover:text-primary transition">
                            {{ $cat->name }}
                        </span>
                    </a>
                @empty
                    <p class="w-full text-sm text-gray-400 text-center py-12">No categories available yet.</p>
                @endforelse
            </div>

            {{-- =========================
             POPULAR SEARCHES
        ========================= --}}
            <section class="mt-12 pb-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Popular Searches</h2>
                <div class="flex flex-wrap gap-2">
                    @php
                        $tags = [
                            'Exercise books',
                            'Printer paper',
                            'Pens and pencils',
                            'Files and folders',
                            'Desk organizers',
                            'Art supplies',
                            'School bags',
                            'Calculators',
                            'Office furniture',
                            'Printer supplies',
                            'Packaging supplies',
                            'Cleaning supplies',
                        ];
                    @endphp
                    @foreach ($tags as $tag)
                        <a href="{{ route('frontend.search', ['q' => $tag]) }}"
                            class="px-3.5 py-1.5 bg-white border border-gray-200 rounded-[12px] text-xs text-gray-600
                               font-medium hover:border-primary hover:text-primary hover:bg-primary/5
                               transition-all duration-200">
                            {{ $tag }}
                        </a>
                    @endforeach
                </div>
            </section>

        </div>
    </div>

@endsection
