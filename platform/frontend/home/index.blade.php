@extends('frontend.layouts.app')

@section('title', config('app.name') . ' | Stationery & Office Supplies')
@section('meta_description', 'Shop stationery, office supplies, school essentials and workplace products from ' . config('app.name') . '.')

@section('content')
    <section class="w-full bg-background">
        <div class="w-full">
            <div class="relative h-[390px] w-full overflow-hidden bg-secondary-light bg-cover bg-center md:h-[410px]"
                style="background-image: url('{{ url('public/images/stationery-office-hero.png') }}');">
                <div class="absolute inset-y-0 left-0 flex w-full items-center px-4 py-5 sm:px-8 lg:w-[55%] lg:px-12">
                    <div class="hero-copy-panel max-w-lg rounded-[12px] p-6 text-white shadow-2xl sm:p-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/80">Work · School · Creativity</p>
                        <h1 class="mt-3 text-3xl font-extrabold leading-tight sm:text-4xl lg:text-5xl">Everything you need to get things done.</h1>
                        <p class="mt-4 max-w-lg text-sm leading-relaxed text-white/85">Shop dependable stationery, office essentials, paper products and everyday supplies in one place.</p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('frontend.products') }}" class="inline-flex items-center gap-2 rounded-[12px] bg-white px-6 py-3 text-sm font-semibold text-primary transition hover:bg-primary-light">Shop products <i class="fas fa-arrow-right text-xs"></i></a>
                            <a href="{{ route('frontend.categories') }}" class="inline-flex items-center gap-2 rounded-[12px] border border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Browse categories</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-y border-border bg-white">
        <div class="mx-auto grid max-w-7xl gap-px bg-border sm:grid-cols-3">
            @foreach ([
                ['fa-box-open', 'Wide selection', 'Office, school and creative essentials'],
                ['fa-truck-fast', 'Reliable delivery', 'Convenient delivery across Kenya'],
                ['fa-shield-halved', 'Secure shopping', 'Trusted checkout and helpful support'],
            ] as [$icon, $title, $text])
                <div class="flex items-center gap-4 bg-white px-6 py-6">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[12px] bg-primary-light text-primary"><i class="fas {{ $icon }}"></i></span>
                    <div><h2 class="text-sm font-bold text-text">{{ $title }}</h2><p class="mt-1 text-xs text-muted">{{ $text }}</p></div>
                </div>
            @endforeach
        </div>
    </section>

    @if ($mainCategories->isNotEmpty())
        <section class="py-14 lg:py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-8 flex items-end justify-between gap-4">
                    <div><p class="text-xs font-semibold uppercase tracking-[0.16em] text-primary">Shop by department</p><h2 class="mt-2 text-3xl font-extrabold text-text">Popular categories</h2></div>
                    <a href="{{ route('frontend.categories') }}" class="text-sm font-semibold text-primary hover:text-primary-dark">View all <i class="fas fa-arrow-right ml-1 text-xs"></i></a>
                </div>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                    @foreach ($mainCategories->take(12) as $cat)
                        @php
                            $catImage = null;
                            if ($cat->featured_image) {
                                $catImage = asset(str_starts_with($cat->featured_image, 'uploads/') ? $cat->featured_image : 'categories/featured/' . $cat->featured_image);
                            } elseif (isset($categoryImages[$cat->id])) {
                                $thumb = $categoryImages[$cat->id];
                                $catImage = asset(str_starts_with($thumb, 'uploads/') ? $thumb : 'uploads/products/images/' . $thumb);
                            }
                        @endphp
                        <a href="{{ route('frontend.categories.show', $cat->slug) }}" class="group overflow-hidden rounded-[12px] border border-border bg-white transition hover:-translate-y-1 hover:border-primary hover:shadow-lg">
                            <span class="relative block aspect-square overflow-hidden bg-primary-light">
                                @if ($catImage)
                                    <img src="{{ $catImage }}" alt="{{ $cat->name }}" loading="lazy" class="absolute inset-0 h-full w-full object-contain transition duration-500 group-hover:scale-105">
                                @else
                                    <span class="absolute inset-0 flex items-center justify-center text-3xl text-primary/50"><i class="{{ $cat->icon ?: 'fas fa-pen-ruler' }}"></i></span>
                                @endif
                            </span>
                            <span class="block truncate px-3 py-3 text-center text-sm font-semibold text-text group-hover:text-primary">{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg-secondary-light py-14 lg:py-20">
        <div class="mx-auto grid max-w-7xl gap-5 px-6 md:grid-cols-3">
            <a href="{{ route('frontend.products') }}" class="brand-gradient group rounded-[12px] p-8 text-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl md:col-span-2">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-white/75">Workplace essentials</p>
                <h2 class="mt-3 max-w-lg text-3xl font-extrabold">Stock your office with everyday must-haves.</h2>
                <span class="mt-7 inline-flex items-center gap-2 text-sm font-semibold">Shop office supplies <i class="fas fa-arrow-right transition group-hover:translate-x-1"></i></span>
            </a>
            <a href="{{ route('frontend.categories') }}" class="group rounded-[12px] border border-primary/15 bg-white p-8 transition hover:-translate-y-1 hover:border-primary hover:shadow-xl">
                <span class="flex h-12 w-12 items-center justify-center rounded-[12px] bg-primary-light text-primary"><i class="fas fa-graduation-cap"></i></span>
                <p class="mt-6 text-xs font-semibold uppercase tracking-[0.16em] text-primary">School supplies</p>
                <h2 class="mt-2 text-2xl font-extrabold text-text">Ready for every lesson.</h2>
                <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-primary">Explore categories <i class="fas fa-arrow-right transition group-hover:translate-x-1"></i></span>
            </a>
        </div>
    </section>

    @if ($topSelling->isNotEmpty())
        <section class="py-14 lg:py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-8 flex items-end justify-between gap-4"><div><p class="text-xs font-semibold uppercase tracking-[0.16em] text-primary">Customer favourites</p><h2 class="mt-2 text-3xl font-extrabold text-text">Featured products</h2></div><a href="{{ route('frontend.products') }}" class="text-sm font-semibold text-primary hover:text-primary-dark">Shop all <i class="fas fa-arrow-right ml-1 text-xs"></i></a></div>
                <div class="relative group" x-data="{
                    scrollLeft() { this.$refs.topSellingRail.scrollBy({ left: -300, behavior: 'smooth' }) },
                    scrollRight() { this.$refs.topSellingRail.scrollBy({ left: 300, behavior: 'smooth' }) }
                }">
                    <button @click="scrollLeft()" type="button" aria-label="Scroll left"
                        class="absolute left-0 top-1/2 z-10 hidden h-8 w-8 -translate-y-1/2 items-center justify-center rounded-[12px] bg-white text-primary opacity-0 shadow-md ring-1 ring-border transition hover:text-secondary group-hover:flex group-hover:opacity-100">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <div x-ref="topSellingRail" class="hm-rail">@foreach ($topSelling as $product)<div class="hm-card">@include('frontend.partials.product-card', ['product' => $product])</div>@endforeach</div>
                    <button @click="scrollRight()" type="button" aria-label="Scroll right"
                        class="absolute right-0 top-1/2 z-10 hidden h-8 w-8 -translate-y-1/2 items-center justify-center rounded-[12px] bg-white text-primary opacity-0 shadow-md ring-1 ring-border transition hover:text-secondary group-hover:flex group-hover:opacity-100">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>
        </section>
    @endif

    @if ($newArrivals->isNotEmpty())
        <section class="bg-primary-light py-14 lg:py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-8 flex items-end justify-between gap-4"><div><p class="text-xs font-semibold uppercase tracking-[0.16em] text-primary">Fresh for your desk</p><h2 class="mt-2 text-3xl font-extrabold text-text">New arrivals</h2></div><a href="{{ route('frontend.products') }}" class="text-sm font-semibold text-primary hover:text-primary-dark">View all <i class="fas fa-arrow-right ml-1 text-xs"></i></a></div>
                <div class="relative group" x-data="{
                    scrollLeft() { this.$refs.newArrivalsRail.scrollBy({ left: -300, behavior: 'smooth' }) },
                    scrollRight() { this.$refs.newArrivalsRail.scrollBy({ left: 300, behavior: 'smooth' }) }
                }">
                    <button @click="scrollLeft()" type="button" aria-label="Scroll left"
                        class="absolute left-0 top-1/2 z-10 hidden h-8 w-8 -translate-y-1/2 items-center justify-center rounded-[12px] bg-white text-primary opacity-0 shadow-md ring-1 ring-border transition hover:text-secondary group-hover:flex group-hover:opacity-100">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <div x-ref="newArrivalsRail" class="hm-rail">@foreach ($newArrivals as $product)<div class="hm-card">@include('frontend.partials.product-card', ['product' => $product])</div>@endforeach</div>
                    <button @click="scrollRight()" type="button" aria-label="Scroll right"
                        class="absolute right-0 top-1/2 z-10 hidden h-8 w-8 -translate-y-1/2 items-center justify-center rounded-[12px] bg-white text-primary opacity-0 shadow-md ring-1 ring-border transition hover:text-secondary group-hover:flex group-hover:opacity-100">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>
        </section>
    @endif

    @if ($brands->isNotEmpty())
        <section class="py-14 lg:py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-8 text-center"><p class="text-xs font-semibold uppercase tracking-[0.16em] text-primary">Brands you can trust</p><h2 class="mt-2 text-3xl font-extrabold text-text">Shop top brands</h2></div>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                    @foreach ($brands as $brand)
                        <a href="{{ route('frontend.brands.show', $brand->slug) }}" class="flex h-28 flex-col items-center justify-center gap-2 rounded-[12px] border border-border bg-white p-4 transition hover:border-primary hover:shadow-md">
                            @if ($brand->logo)<img src="{{ asset(str_starts_with($brand->logo, 'uploads/') ? $brand->logo : 'uploads/brands/' . $brand->logo) }}" alt="{{ $brand->name }}" loading="lazy" class="h-12 w-auto object-contain">@else<span class="flex h-10 w-10 items-center justify-center rounded-[12px] bg-primary-light text-primary"><i class="fas fa-certificate"></i></span>@endif
                            <span class="line-clamp-1 text-center text-xs font-semibold text-text">{{ $brand->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
