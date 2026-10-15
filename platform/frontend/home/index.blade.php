@extends('frontend.layouts.app')

@section('title', 'Trinity Mabati Factory | Quality Roofing Sheets in Kenya')
@section('meta_description', 'Trinity Mabati Factory delivers genuine, KEBS-certified metal roofing sheets with an ironclad 15-year written warranty directly to your construction site.')
@section('og_title', 'Trinity Mabati Factory')
@section('og_description', 'Trinity Mabati Factory delivers genuine, KEBS-certified metal roofing sheets with an ironclad 15-year written warranty directly to your construction site.')
@section('og_image', url('public/images/trinity-mabati-home-seo.jpg'))

@section('content')
    @php
        $roofingImages = [
            'tile-profiles' => 'trinity-mabati-product-1.webp',
            'corrugated-sheets' => 'trinity-mabati-product-2.webp',
            'stone-coated-profiles' => 'trinity-mabati-product-3.webp',
            'box-profiles' => 'trinity-mabati-product-4.webp',
        ];
        $roofingGroups = [
            ['slug' => 'tile-profiles', 'heading' => 'Tile Profiles', 'image' => 'trinity-mabati-product-1.webp'],
            [
                'slug' => 'corrugated-sheets',
                'heading' => 'Corrugated Sheets',
                'image' => 'trinity-mabati-product-2.webp',
            ],
        ];
    @endphp

    <section class="relative isolate min-h-[440px] overflow-hidden bg-gray-900 sm:min-h-[470px] lg:min-h-[520px]"
        aria-label="Trinity Mabati Factory roofing">
        {{-- Keep the image visible immediately while the video buffers or when autoplay is unavailable. --}}
        <img src="{{ url('public/images/hrinity-mabati-hero.webp') }}" alt="Trinity Mabati roofing sheets"
            class="absolute inset-0 h-full w-full object-cover" fetchpriority="high" decoding="async">
        {{-- Desktop video (768px and up) --}}
        <video class="absolute inset-0 hidden h-full w-full object-cover opacity-0 transition-opacity duration-700 md:block"
            data-video-src="{{ url('public/videos/trinity-mabati-hero-desktop.mp4') }}"
            poster="{{ url('public/images/hrinity-mabati-hero.webp') }}" muted loop playsinline preload="none"
            aria-hidden="true" tabindex="-1"
            onplaying="this.classList.remove('opacity-0');this.classList.add('opacity-100')"
            onerror="this.classList.remove('opacity-100');this.classList.add('opacity-0')"></video>

        {{-- Mobile video (below 768px) --}}
        <video class="absolute inset-0 block h-full w-full object-cover opacity-0 transition-opacity duration-700 md:hidden"
            data-video-src="{{ url('public/videos/trinity-mabati-hero-mobile.mp4') }}"
            poster="{{ url('public/images/hrinity-mabati-hero.webp') }}" muted loop playsinline preload="none"
            aria-hidden="true" tabindex="-1"
            onplaying="this.classList.remove('opacity-0');this.classList.add('opacity-100')"
            onerror="this.classList.remove('opacity-100');this.classList.add('opacity-0')"></video>
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-black/80 via-black/55 to-black/15"></div>
        <div
            class="relative mx-auto flex min-h-[440px] max-w-7xl items-center px-4 py-20 sm:min-h-[470px] sm:px-6 sm:py-16 lg:min-h-[520px] lg:px-8">
            <div class="w-full max-w-[980px] text-white">
                <h1
                    class="max-w-[720px] text-[clamp(1.9rem,3.1vw,2.8rem)] font-semibold uppercase leading-[1.14] tracking-tight text-white">
                    <span class="inline sm:block">Quality Roofing Sheets,</span>
                    <span class="inline sm:block">Delivered with a Smile</span>
                </h1>
                <p class="mt-5 max-w-xl text-base leading-relaxed text-white/90 sm:text-lg">Trinity Mabati Factory delivers
                    genuine, KEBS-certified metal roofing sheets with an ironclad 15-year written warranty directly to your
                    construction site.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('frontend.products') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3.5 text-sm font-bold text-white transition hover:brightness-110">Explore
                        Our Mabati <i class="fas fa-arrow-right"></i></a>
                    <a href="{{ route('frontend.quotation.index') }}"
                        class="hidden items-center justify-center rounded-lg border-2 border-white bg-transparent px-6 py-3 text-sm font-bold text-white transition hover:bg-white hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white sm:inline-flex">Get a Quote</a>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 sm:px-6 lg:px-8" aria-label="Why choose Trinity Mabati">
        <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
            @foreach ([['fa-medal', 'Premium Quality Steel', 'Durable roofing materials'], ['fa-truck-fast', 'Free Delivery Nationwide', 'Delivery across Kenya'], ['fa-shield-halved', '15 Years Warranty', 'Long-term peace of mind'], ['fa-certificate', 'KEBS Certified', 'Quality you can trust']] as [$icon, $name, $sub])
                <div
                    class="flex min-h-[110px] flex-col items-start gap-3 rounded-[4px] border border-gray-100 bg-white p-4 shadow-lg sm:flex-row sm:items-center sm:p-5">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-red-50 text-primary"><i
                            class="fas {{ $icon }} text-lg"></i></span>
                    <div>
                        <h2 class="text-sm font-bold text-gray-900">{{ $name }}</h2>
                        <p class="mt-1 text-xs text-gray-500">{{ $sub }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    @if ($mainCategories->isNotEmpty())
        <section class="py-12 sm:py-16" aria-label="Browse roofing categories" x-data="{ move(dir) { $refs.categories.scrollBy({ left: dir * 310, behavior: 'smooth' }) } }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative">
                    <button type="button" @click="move(-1)" aria-label="Previous categories"
                        class="absolute left-0 top-1/2 z-10 hidden sm:flex h-10 w-10 -translate-x-1/3 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white shadow-md hover:border-primary hover:text-primary"><i
                            class="fas fa-chevron-left"></i></button>
                    <div x-ref="categories"
                        class="flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth pb-4 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                        @foreach ($mainCategories as $category)
                            <a href="{{ route('frontend.categories.show', $category->slug) }}"
                                class="group relative w-[220px] shrink-0 snap-start overflow-hidden rounded-xl bg-gray-100 sm:w-[260px]">
                                @php
                                    $featured = trim((string) ($category->featured_image ?? ''));
                                    $categoryFallback = url(
                                        'public/images/' .
                                            ($roofingImages[$category->slug] ?? 'trinity-mabati-product-5.webp'),
                                    );
                                    $featuredUrl =
                                        $featured === ''
                                            ? $categoryFallback
                                            : (preg_match('~^https?://~i', $featured)
                                                ? $featured
                                                : (str_starts_with(ltrim($featured, '/'), 'categories/') ||
                                                str_starts_with(ltrim($featured, '/'), 'uploads/') ||
                                                str_starts_with(ltrim($featured, '/'), 'storage/')
                                                    ? asset(ltrim($featured, '/'))
                                                    : asset('categories/featured/' . $featured)));
                                @endphp
                                <div class="aspect-[4/5] overflow-hidden"><img src="{{ $featuredUrl }}"
                                        alt="{{ $category->name }}" loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ $categoryFallback }}'"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                </div>
                                <div
                                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/85 to-transparent px-5 pb-5 pt-14 text-white">
                                    <h2 class="text-lg font-bold">{{ $category->name }}</h2><span
                                        class="mt-2 inline-block text-xs font-semibold">Explore category <i
                                            class="fas fa-arrow-right ml-1"></i></span>
                                </div>
                            </a>
                        @endforeach
                        <a href="{{ route('frontend.categories') }}"
                            class="flex w-[220px] shrink-0 snap-start flex-col items-center justify-center gap-3 rounded-xl border border-primary/20 bg-red-50 p-6 text-center text-primary transition hover:bg-red-100 sm:w-[260px]">
                            <span class="flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl"><i
                                    class="fas fa-arrow-right"></i></span>
                            <span class="text-xl font-extrabold">See More</span><span class="text-sm">Browse all roofing
                                categories</span>
                        </a>
                    </div>
                    <button type="button" @click="move(1)" aria-label="Next categories"
                        class="absolute right-0 top-1/2 z-10 hidden sm:flex h-10 w-10 translate-x-1/3 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white shadow-md hover:border-primary hover:text-primary"><i
                            class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </section>
    @endif


    <section class="bg-[#FCFAF9] py-14 sm:py-20" aria-labelledby="google-reviews-heading" x-data="{
        paused: false,
        timer: null,
        init() {
            this.timer = setInterval(() => {
                if (this.paused || document.hidden || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                this.scrollReviews(1);
            }, 3000);
        },
        destroy() { if (this.timer) clearInterval(this.timer); },
        scrollReviews(direction) {
            const rail = this.$refs.reviewsRail;
            const card = rail.querySelector('article');
            if (!card) return;
            const gap = parseFloat(getComputedStyle(rail).columnGap) || 16;
            const step = card.getBoundingClientRect().width + gap;
            if (direction > 0 && rail.scrollLeft + rail.clientWidth >= rail.scrollWidth - 8) {
                rail.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                rail.scrollBy({ left: direction * step, behavior: 'smooth' });
            }
        }
    }"
        @mouseenter="paused = true" @mouseleave="paused = false" @focusin="paused = true" @focusout="paused = false">
        <style>
            .trinity-review-excerpt {
                display: -webkit-box !important;
                -webkit-box-orient: vertical !important;
                -webkit-line-clamp: 4 !important;
                line-clamp: 4;
                overflow: hidden !important;
                max-height: 6rem;
                flex: none !important;
            }

            @media (min-width: 640px) {
                .trinity-review-card {
                    flex-basis: 44% !important;
                }
            }

            @media (min-width: 1024px) {
                .trinity-review-card {
                    flex-basis: calc((100% - 4rem) / 4.5) !important;
                }
            }

            @media (max-width: 639px) {
                .trinity-review-card {
                    flex-basis: calc((100% - 0.75rem) / 2) !important;
                }
            }
        </style>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-7 flex items-end justify-between gap-4">
                <div>

                    <h2 id="google-reviews-heading" class="text-3xl font-extrabold text-primary sm:text-4xl">Google Reviews
                    </h2>

                </div>
            </div>
            <div class="relative">
                <button type="button" @click="scrollReviews(-1)" aria-label="Previous Google reviews"
                    class="absolute left-0 top-1/2 z-10 hidden h-11 w-11 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-800 shadow-md transition hover:border-primary hover:text-primary sm:flex"><i
                        class="fas fa-chevron-left" aria-hidden="true"></i></button>
                <div x-ref="reviewsRail" tabindex="0" aria-label="Google reviews, swipe or scroll horizontally"
                    class="flex snap-x snap-mandatory gap-3 sm:gap-4 overflow-x-auto scroll-smooth pb-5 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    <article
                        class="trinity-review-card flex h-[240px] shrink-0 snap-start flex-col rounded-[8px] border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate text-sm font-bold text-gray-900">Sue Wahome</h3>
                                <p class="mt-0.5 flex items-center gap-1.5 whitespace-nowrap text-xs text-gray-500"><span>4 reviews</span><span aria-hidden="true">·</span><span class="inline-flex items-center gap-0.5" style="color: #fbbc04;" role="img" aria-label="5 out of 5 stars"><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i></span></p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22"
                                role="img" aria-label="Google" class="shrink-0">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6C44.4 38.03 46.98 31.86 46.98 24.55z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59A14.41 14.41 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A23.93 23.93 0 0 0 0 24c0 3.87.93 7.51 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.92-2.13 15.89-5.8l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </div>
                        <p class="mt-4 trinity-review-excerpt overflow-hidden text-sm leading-6 text-gray-700">I had a
                            great experience with Trinity Mabati. Their roofing materials are of high quality, durable, and
                            competitively priced. The staff were professional, knowledgeable, and guided me through the
                            selection process with patience. Delivery …</p>
                        <a href="https://share.google/C6lAHDiyMhSuFqLKh" target="_blank" rel="noopener noreferrer"
                            class="mt-auto pt-3 inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">Read
                            on Google <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    </article>
                    <article
                        class="trinity-review-card flex h-[240px] shrink-0 snap-start flex-col rounded-[8px] border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate text-sm font-bold text-gray-900">Iven</h3>
                                <p class="mt-0.5 flex items-center gap-1.5 whitespace-nowrap text-xs text-gray-500"><span>1 review</span><span aria-hidden="true">·</span><span class="inline-flex items-center gap-0.5" style="color: #fbbc04;" role="img" aria-label="5 out of 5 stars"><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i></span></p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22"
                                role="img" aria-label="Google" class="shrink-0">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6C44.4 38.03 46.98 31.86 46.98 24.55z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59A14.41 14.41 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A23.93 23.93 0 0 0 0 24c0 3.87.93 7.51 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.92-2.13 15.89-5.8l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </div>
                        <p class="mt-4 trinity-review-excerpt overflow-hidden text-sm leading-6 text-gray-700">Trinity
                            Mabati is the go-to place for quality roofing solutions. They offer durable products, excellent
                            customer service, and professional guidance throughout the process. Highly recommend them to
                            anyone looking for reliable roofing materials and solutions. Keep up the great work! 👏🏽🏠</p>
                        <a href="https://share.google/C6lAHDiyMhSuFqLKh" target="_blank" rel="noopener noreferrer"
                            class="mt-auto pt-3 inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">Read
                            on Google <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    </article>
                    <article
                        class="trinity-review-card flex h-[240px] shrink-0 snap-start flex-col rounded-[8px] border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate text-sm font-bold text-gray-900">Safari na Simon Mungai</h3>
                                <p class="mt-0.5 flex items-center gap-1.5 whitespace-nowrap text-xs text-gray-500"><span>35 reviews</span><span aria-hidden="true">·</span><span class="inline-flex items-center gap-0.5" style="color: #fbbc04;" role="img" aria-label="5 out of 5 stars"><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i></span></p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22"
                                role="img" aria-label="Google" class="shrink-0">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6C44.4 38.03 46.98 31.86 46.98 24.55z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59A14.41 14.41 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A23.93 23.93 0 0 0 0 24c0 3.87.93 7.51 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.92-2.13 15.89-5.8l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </div>
                        <p class="mt-4 trinity-review-excerpt overflow-hidden text-sm leading-6 text-gray-700">I had a
                            project in my upcountry home and Trinity Mabati team delivered some of the best roofing
                            materials I&#x27;ve ever seen. Their services were timely and products affordable. They offered
                            transport at a …</p>
                        <a href="https://share.google/C6lAHDiyMhSuFqLKh" target="_blank" rel="noopener noreferrer"
                            class="mt-auto pt-3 inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">Read
                            on Google <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    </article>
                    <article
                        class="trinity-review-card flex h-[240px] shrink-0 snap-start flex-col rounded-[8px] border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate text-sm font-bold text-gray-900">Sarah Musyimi</h3>
                                <p class="mt-0.5 flex items-center gap-1.5 whitespace-nowrap text-xs text-gray-500"><span>42 reviews</span><span aria-hidden="true">·</span><span class="inline-flex items-center gap-0.5" style="color: #fbbc04;" role="img" aria-label="5 out of 5 stars"><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i></span></p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22"
                                role="img" aria-label="Google" class="shrink-0">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6C44.4 38.03 46.98 31.86 46.98 24.55z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59A14.41 14.41 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A23.93 23.93 0 0 0 0 24c0 3.87.93 7.51 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.92-2.13 15.89-5.8l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </div>
                        <p class="mt-4 trinity-review-excerpt overflow-hidden text-sm leading-6 text-gray-700">I was
                            reffered by a friend who had bought Iron sheets and they were very good quality so i wanted
                            exactly the same. I am a happy client as the team gave me good service from placing my order all
                            …</p>
                        <a href="https://share.google/C6lAHDiyMhSuFqLKh" target="_blank" rel="noopener noreferrer"
                            class="mt-auto pt-3 inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">Read
                            on Google <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    </article>
                    <article
                        class="trinity-review-card flex h-[240px] shrink-0 snap-start flex-col rounded-[8px] border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate text-sm font-bold text-gray-900">Chinku Travels</h3>
                                <p class="mt-0.5 flex items-center gap-1.5 whitespace-nowrap text-xs text-gray-500"><span>105 reviews</span><span aria-hidden="true">·</span><span class="inline-flex items-center gap-0.5" style="color: #fbbc04;" role="img" aria-label="5 out of 5 stars"><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i></span></p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22"
                                role="img" aria-label="Google" class="shrink-0">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6C44.4 38.03 46.98 31.86 46.98 24.55z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59A14.41 14.41 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A23.93 23.93 0 0 0 0 24c0 3.87.93 7.51 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.92-2.13 15.89-5.8l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </div>
                        <p class="mt-4 trinity-review-excerpt overflow-hidden text-sm leading-6 text-gray-700">Looking for
                            your best Roofing mabati? I would recommend none other than them. From your 1st call of inquiry
                            they take it so personal to the point of delivery making you feel like real partners which you
                            become as soon as you see their …</p>
                        <a href="https://share.google/C6lAHDiyMhSuFqLKh" target="_blank" rel="noopener noreferrer"
                            class="mt-auto pt-3 inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">Read
                            on Google <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    </article>
                    <article
                        class="trinity-review-card flex h-[240px] shrink-0 snap-start flex-col rounded-[8px] border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate text-sm font-bold text-gray-900">Mercy Daniel</h3>
                                <p class="mt-0.5 flex items-center gap-1.5 whitespace-nowrap text-xs text-gray-500"><span>5 reviews</span><span aria-hidden="true">·</span><span class="inline-flex items-center gap-0.5" style="color: #fbbc04;" role="img" aria-label="5 out of 5 stars"><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i></span></p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22"
                                role="img" aria-label="Google" class="shrink-0">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6C44.4 38.03 46.98 31.86 46.98 24.55z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59A14.41 14.41 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A23.93 23.93 0 0 0 0 24c0 3.87.93 7.51 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.92-2.13 15.89-5.8l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </div>
                        <p class="mt-4 trinity-review-excerpt overflow-hidden text-sm leading-6 text-gray-700">High-Quality
                            Iron Sheets and Excellent Service! I ordered iron sheets online through their website and
                            received them exactly as agreed. The quality is outstanding — strong, well-finished, and perfect
                            for my …</p>
                        <a href="https://share.google/C6lAHDiyMhSuFqLKh" target="_blank" rel="noopener noreferrer"
                            class="mt-auto pt-3 inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">Read
                            on Google <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    </article>
                    <article
                        class="trinity-review-card flex h-[240px] shrink-0 snap-start flex-col rounded-[8px] border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate text-sm font-bold text-gray-900">Wakio Kanyi</h3>
                                <p class="mt-0.5 flex items-center gap-1.5 whitespace-nowrap text-xs text-gray-500"><span>2 reviews</span><span aria-hidden="true">·</span><span class="inline-flex items-center gap-0.5" style="color: #fbbc04;" role="img" aria-label="5 out of 5 stars"><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i></span></p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22"
                                role="img" aria-label="Google" class="shrink-0">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6C44.4 38.03 46.98 31.86 46.98 24.55z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59A14.41 14.41 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A23.93 23.93 0 0 0 0 24c0 3.87.93 7.51 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.92-2.13 15.89-5.8l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </div>
                        <p class="mt-4 trinity-review-excerpt overflow-hidden text-sm leading-6 text-gray-700">during my
                            grandma’s house renovations, we ordered mabatis from them and the service was excellent,
                            seamless ordering process, and they were delivered the next day in a new county. …</p>
                        <a href="https://share.google/C6lAHDiyMhSuFqLKh" target="_blank" rel="noopener noreferrer"
                            class="mt-auto pt-3 inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">Read
                            on Google <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    </article>
                    <article
                        class="trinity-review-card flex h-[240px] shrink-0 snap-start flex-col rounded-[8px] border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate text-sm font-bold text-gray-900">Ndiema Kwemoi</h3>
                                <p class="mt-0.5 flex items-center gap-1.5 whitespace-nowrap text-xs text-gray-500"><span>1 review</span><span aria-hidden="true">·</span><span class="inline-flex items-center gap-0.5" style="color: #fbbc04;" role="img" aria-label="5 out of 5 stars"><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i></span></p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22"
                                role="img" aria-label="Google" class="shrink-0">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6C44.4 38.03 46.98 31.86 46.98 24.55z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59A14.41 14.41 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A23.93 23.93 0 0 0 0 24c0 3.87.93 7.51 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.92-2.13 15.89-5.8l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </div>
                        <p class="mt-4 trinity-review-excerpt overflow-hidden text-sm leading-6 text-gray-700">The team was
                            knowledgeable and helpful, explaining the different types of mabati and their uses. The factory
                            was clean and well-organized, and I saw firsthand the attention to detail that goes into each
                            product. Would definitely recommend their products to others looking for quality mabati
                            solutions.&quot; 😊</p>
                        <a href="https://share.google/C6lAHDiyMhSuFqLKh" target="_blank" rel="noopener noreferrer"
                            class="mt-auto pt-3 inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">Read
                            on Google <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    </article>
                    <article
                        class="trinity-review-card flex h-[240px] shrink-0 snap-start flex-col rounded-[8px] border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate text-sm font-bold text-gray-900">Sylvester Junior</h3>
                                <p class="mt-0.5 flex items-center gap-1.5 whitespace-nowrap text-xs text-gray-500"><span>1 review</span><span aria-hidden="true">·</span><span class="inline-flex items-center gap-0.5" style="color: #fbbc04;" role="img" aria-label="5 out of 5 stars"><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i></span></p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22"
                                role="img" aria-label="Google" class="shrink-0">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6C44.4 38.03 46.98 31.86 46.98 24.55z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59A14.41 14.41 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A23.93 23.93 0 0 0 0 24c0 3.87.93 7.51 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.92-2.13 15.89-5.8l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </div>
                        <p class="mt-4 trinity-review-excerpt overflow-hidden text-sm leading-6 text-gray-700">Your
                            services are superb. The team is up to task. Delivery is also faster and very reliable. Trinity
                            Mabati anytime any day</p>
                        <a href="https://share.google/C6lAHDiyMhSuFqLKh" target="_blank" rel="noopener noreferrer"
                            class="mt-auto pt-3 inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">Read
                            on Google <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    </article>
                    <article
                        class="trinity-review-card flex h-[240px] shrink-0 snap-start flex-col rounded-[8px] border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate text-sm font-bold text-gray-900">Wambui Mugo</h3>
                                <p class="mt-0.5 flex items-center gap-1.5 whitespace-nowrap text-xs text-gray-500"><span>3 reviews</span><span aria-hidden="true">·</span><span class="inline-flex items-center gap-0.5" style="color: #fbbc04;" role="img" aria-label="5 out of 5 stars"><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i></span></p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22"
                                role="img" aria-label="Google" class="shrink-0">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6C44.4 38.03 46.98 31.86 46.98 24.55z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59A14.41 14.41 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A23.93 23.93 0 0 0 0 24c0 3.87.93 7.51 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.92-2.13 15.89-5.8l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </div>
                        <p class="mt-4 trinity-review-excerpt overflow-hidden text-sm leading-6 text-gray-700">I had a
                            great experience with Trinity Mabati! Special thanks to Carol, whose exceptional service and
                            expertise made the process so easy. She was always responsive and guided me in choosing the best
                            materials. Highly recommended for top-quality mabati and excellent customer service!</p>
                        <a href="https://share.google/C6lAHDiyMhSuFqLKh" target="_blank" rel="noopener noreferrer"
                            class="mt-auto pt-3 inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">Read
                            on Google <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    </article>
                    <a href="https://share.google/C6lAHDiyMhSuFqLKh" target="_blank" rel="noopener noreferrer"
                        class="trinity-review-card flex h-[240px]  shrink-0 snap-start flex-col items-center justify-center gap-4 rounded-[8px] border border-primary/20 bg-red-50 p-7 text-center text-primary transition hover:bg-red-100">
                        <span class="flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22"
                                role="img" aria-label="Google" class="shrink-0">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6C44.4 38.03 46.98 31.86 46.98 24.55z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59A14.41 14.41 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A23.93 23.93 0 0 0 0 24c0 3.87.93 7.51 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.92-2.13 15.89-5.8l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg></span>
                        <span class="text-xl font-bold">See All Google Reviews</span>
                        <span class="text-sm">Read more customer experiences on Google <i
                                class="fas fa-arrow-up-right-from-square ml-1" aria-hidden="true"></i></span>
                    </a>
                    <button type="button" @click="scrollReviews(1)" aria-label="Next Google reviews"
                        class="absolute right-0 top-1/2 z-10 hidden h-11 w-11 translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-800 shadow-md transition hover:border-primary hover:text-primary sm:flex"><i
                            class="fas fa-chevron-right" aria-hidden="true"></i></button>
                </div>
            </div>
    </section>

    @if(isset($partners) && $partners->isNotEmpty())
        @include('frontend.partners.home-rail', ['partners' => $partners])
    @endif

    <section class="bg-white py-14 sm:py-20" aria-labelledby="how-to-order-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 max-w-3xl">
                <h2 id="how-to-order-heading" class="text-3xl font-extrabold text-primary sm:text-4xl">How to Order</h2>
                <p class="mt-3 text-lg font-medium text-gray-600">Your Path to a Perfect Roof in 3 Simple Steps</p>
            </div>
            <div class="grid gap-5 md:grid-cols-3">
                <article class="relative rounded-2xl border border-gray-100 bg-[#FCFAF9] p-7 shadow-sm">
                    <span
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary text-xl font-extrabold text-white">1</span>
                    <h3 class="mt-6 text-xl font-bold text-gray-900">Build Your Quote</h3>
                    <p class="mt-3 text-sm leading-7 text-gray-600">Browse our selection, specify your gauge, finish, and
                        sheet length. Add your custom specifications to your quote list to see an instant price estimate.
                    </p>
                </article>
                <article class="relative rounded-2xl border border-gray-100 bg-[#FCFAF9] p-7 shadow-sm">
                    <span
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary text-xl font-extrabold text-white">2</span>
                    <h3 class="mt-6 text-xl font-bold text-gray-900">Submit Inquiry &amp; Details</h3>
                    <p class="mt-3 text-sm leading-7 text-gray-600">Proceed to submit your inquiry with your contact
                        information and delivery address. No payment or upfront commitment is required at this stage.</p>
                </article>
                <article class="relative rounded-2xl border border-gray-100 bg-[#FCFAF9] p-7 shadow-sm">
                    <span
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary text-xl font-extrabold text-white">3</span>
                    <h3 class="mt-6 text-xl font-bold text-gray-900">Confirmation &amp; Delivery</h3>
                    <p class="mt-3 text-sm leading-7 text-gray-600">We'll promptly call you to confirm the final order
                        details, arrange payment, and finalize the delivery schedule. We then process your custom sheets and
                        ensure quick delivery directly to your site.</p>
                </article>
            </div>
            <a href="{{ route('frontend.quotation.index') }}"
                class="mt-8 inline-flex items-center gap-2 rounded-lg bg-primary px-7 py-3.5 text-sm font-bold text-white hover:brightness-110">Build
                Your Quote <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </section>

    @foreach (array_slice($roofingGroups, 0, 1) as $index => $group)
        @php
            $category = $mainCategories->firstWhere('slug', $group['slug']);
            $products = $sections->get($group['slug'], collect());
            $categoryUrl = $category
                ? route('frontend.categories.show', $category->slug)
                : route('frontend.categories');
        @endphp
        <section class="py-14 sm:py-16 {{ $index % 2 ? 'bg-white' : 'bg-[#FAF5F3]' }}"
            aria-label="{{ $group['heading'] }}" x-data="{ move(dir) { $refs.products.scrollBy({ left: dir * Math.min(700, $refs.products.clientWidth * .85), behavior: 'smooth' }) } }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-6 text-2xl font-extrabold text-primary sm:text-3xl">{{ $group['heading'] }}</h2>
                <div class="relative">
                    <button type="button" @click="move(-1)" aria-label="Scroll {{ $group['heading'] }} left"
                        class="absolute left-0 top-1/2 z-10 hidden sm:flex h-10 w-10 -translate-x-1/3 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-800 shadow-md transition hover:border-primary hover:text-primary"><i
                            class="fas fa-chevron-left"></i></button>
                    <div x-ref="products" tabindex="0"
                        aria-label="{{ $group['heading'] }} products, scroll horizontally"
                        class="flex snap-x snap-mandatory items-start sm:items-stretch gap-3 overflow-x-auto scroll-smooth pb-4 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden sm:gap-4">
                        @foreach ($products as $product)
                            <div class="flex trinity-mobile-product-rail-item shrink-0 snap-start flex-col sm:w-[32%] lg:w-[23%]">
                                @include('frontend.partials.product-card', ['product' => $product])
                            </div>
                        @endforeach
                        <a href="{{ $categoryUrl }}"
                            class="flex sm:min-h-[250px] trinity-mobile-product-rail-item shrink-0 snap-start flex-col items-center justify-center gap-3 rounded-xl border border-primary/20 bg-white p-3 text-center text-primary transition hover:bg-red-50 sm:w-[32%] sm:p-5 lg:w-[23%]">
                            <span
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-red-50 text-xl sm:h-16 sm:w-16"><i
                                    class="fas fa-arrow-right"></i></span>
                            <span class="text-base font-extrabold sm:text-lg">View More</span>
                            <span class="text-xs text-gray-600 sm:text-sm">Explore all {{ $group['heading'] }}</span>
                        </a>
                    </div>
                    <button type="button" @click="move(1)" aria-label="Scroll {{ $group['heading'] }} right"
                        class="absolute right-0 top-1/2 z-10 hidden sm:flex h-10 w-10 translate-x-1/3 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-800 shadow-md transition hover:border-primary hover:text-primary"><i
                            class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </section>
    @endforeach

    <section class="bg-[#FAF5F3] py-14 sm:py-20" aria-labelledby="getting-to-know-heading">
        <div class="mx-auto grid max-w-7xl items-center gap-9 px-4 sm:px-6 lg:grid-cols-2 lg:gap-14 lg:px-8">
            <div>
                <h2 id="getting-to-know-heading" class="text-3xl font-extrabold text-primary sm:text-4xl">Getting to Know
                    Us</h2>
                <p class="mt-6 text-base leading-8 text-gray-700"><strong>Trinity Mabati Factory</strong> is a leading
                    supplier in the roofing sheet industry, built on over 5 years of experience providing quality products
                    and exceptional service. We are committed to supplying high-grade roofing sheet products tailored for
                    both commercial and residential projects.</p>
                <p class="mt-4 text-base leading-8 text-gray-700">Our inventory serves all trades as well as the general
                    public across Kenya. You can visit us at our main outlets in <strong>Nairobi</strong> and
                    <strong>Migori</strong> for dedicated service and expert advice.</p>
            </div>
            <img src="{{ url('public/images/trinity-mabati-product-5.webp') }}"
                alt="Trinity Mabati Factory roofing products" loading="lazy"
                class="aspect-[4/3] w-full rounded-2xl object-cover">
        </div>
    </section>

    @foreach (array_slice($roofingGroups, 1, null, true) as $index => $group)
        @php
            $category = $mainCategories->firstWhere('slug', $group['slug']);
            $products = $sections->get($group['slug'], collect());
            $categoryUrl = $category
                ? route('frontend.categories.show', $category->slug)
                : route('frontend.categories');
        @endphp
        <section class="py-14 sm:py-16 {{ $index % 2 ? 'bg-white' : 'bg-[#FAF5F3]' }}"
            aria-label="{{ $group['heading'] }}" x-data="{ move(dir) { $refs.products.scrollBy({ left: dir * Math.min(700, $refs.products.clientWidth * .85), behavior: 'smooth' }) } }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-6 text-2xl font-extrabold text-primary sm:text-3xl">{{ $group['heading'] }}</h2>
                <div class="relative">
                    <button type="button" @click="move(-1)" aria-label="Scroll {{ $group['heading'] }} left"
                        class="absolute left-0 top-1/2 z-10 hidden sm:flex h-10 w-10 -translate-x-1/3 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-800 shadow-md transition hover:border-primary hover:text-primary"><i
                            class="fas fa-chevron-left"></i></button>
                    <div x-ref="products" tabindex="0"
                        aria-label="{{ $group['heading'] }} products, scroll horizontally"
                        class="flex snap-x snap-mandatory items-start sm:items-stretch gap-3 overflow-x-auto scroll-smooth pb-4 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden sm:gap-4">
                        @foreach ($products as $product)
                            <div class="flex trinity-mobile-product-rail-item shrink-0 snap-start flex-col sm:w-[32%] lg:w-[23%]">
                                @include('frontend.partials.product-card', ['product' => $product])
                            </div>
                        @endforeach
                        <a href="{{ $categoryUrl }}"
                            class="flex sm:min-h-[250px] trinity-mobile-product-rail-item shrink-0 snap-start flex-col items-center justify-center gap-3 rounded-xl border border-primary/20 bg-white p-3 text-center text-primary transition hover:bg-red-50 sm:w-[32%] sm:p-5 lg:w-[23%]">
                            <span
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-red-50 text-xl sm:h-16 sm:w-16"><i
                                    class="fas fa-arrow-right"></i></span>
                            <span class="text-base font-extrabold sm:text-lg">View More</span>
                            <span class="text-xs text-gray-600 sm:text-sm">Explore all {{ $group['heading'] }}</span>
                        </a>
                    </div>
                    <button type="button" @click="move(1)" aria-label="Scroll {{ $group['heading'] }} right"
                        class="absolute right-0 top-1/2 z-10 hidden sm:flex h-10 w-10 translate-x-1/3 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-800 shadow-md transition hover:border-primary hover:text-primary"><i
                            class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </section>
    @endforeach

    @if(isset($teamMembers) && $teamMembers->isNotEmpty())
        @include('frontend.team.home-rail', ['members' => $teamMembers])
    @endif

    <section class="bg-white py-16 sm:py-20" aria-labelledby="home-faq-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto mb-10 max-w-2xl text-center">
                <h2 id="home-faq-heading" class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Frequently Asked
                    Question</h2>
            </div>
            <div class="grid items-start gap-5 lg:grid-cols-2">
                <details
                    class="group rounded-xl border border-gray-200 bg-[#FCFAF9] p-6 open:border-primary/40 open:shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-start justify-between gap-4 text-base font-bold text-gray-900 [&::-webkit-details-marker]:hidden">
                        <span>Do you sell &quot;reject,&quot; factory-seconds, or substandard mabatis at a discount?</span>
                        <i class="fas fa-plus mt-1 shrink-0 text-primary transition-transform group-open:rotate-45"
                            aria-hidden="true"></i>
                    </summary>
                    <p class="mt-5 text-sm leading-7 text-gray-600">No. We are committed to supplying only 100% verified,
                        first-grade quality roofing materials that meet or exceed KEBS standards. We do not stock or sell
                        &quot;reject&quot; sheets, factory seconds, or any substandard materials. While some cheaper
                        alternatives might be available in the market, we prioritize our customers' safety and the long-term
                        value of their investment, ensuring all sheets come with a full product warranty.</p>
                </details>
                <details
                    class="group rounded-xl border border-gray-200 bg-[#FCFAF9] p-6 open:border-primary/40 open:shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-start justify-between gap-4 text-base font-bold text-gray-900 [&::-webkit-details-marker]:hidden">
                        <span>Do you offer delivery services?</span>
                        <i class="fas fa-plus mt-1 shrink-0 text-primary transition-transform group-open:rotate-45"
                            aria-hidden="true"></i>
                    </summary>
                    <p class="mt-5 text-sm leading-7 text-gray-600">Yes, we offer free and reliable logistics to sites
                        across all regions of Kenya, including remote areas. Our main dispatch points are in Nairobi and
                        Migori, but we arrange transport to major hubs like Mombasa, Kisumu, Eldoret, Nakuru, and beyond.
                    </p>
                </details>
                <details
                    class="group rounded-xl border border-gray-200 bg-[#FCFAF9] p-6 open:border-primary/40 open:shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-start justify-between gap-4 text-base font-bold text-gray-900 [&::-webkit-details-marker]:hidden">
                        <span>Are your roofing products certified, and do they come with a warranty?</span>
                        <i class="fas fa-plus mt-1 shrink-0 text-primary transition-transform group-open:rotate-45"
                            aria-hidden="true"></i>
                    </summary>
                    <p class="mt-5 text-sm leading-7 text-gray-600">Yes, all our roofing sheets raw materials are sourced
                        from reputable manufacturers and comply with the quality standards set by the Kenya Bureau of
                        Standards (KEBS). We provide warranties against manufacturing defects and premature corrosion or
                        fading, with the duration varying based on the specific material (e.g., stone-coated vs.
                        galvanized). Please check the warranty documentation for your chosen product.</p>
                </details>
                <details
                    class="group rounded-xl border border-gray-200 bg-[#FCFAF9] p-6 open:border-primary/40 open:shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-start justify-between gap-4 text-base font-bold text-gray-900 [&::-webkit-details-marker]:hidden">
                        <span>How can I get a quotation for my roofing project?</span>
                        <i class="fas fa-plus mt-1 shrink-0 text-primary transition-transform group-open:rotate-45"
                            aria-hidden="true"></i>
                    </summary>
                    <p class="mt-5 text-sm leading-7 text-gray-600">Browse our selection, specify your gauge, finish, and
                        sheet length. Add your custom specifications to your quote list to see an instant price estimate.
                        Proceed to submit your inquiry with your contact information and delivery address. No payment or
                        upfront commitment is required at this stage.</p>
                </details>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
(function () {
    function startHeroVideo() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || navigator.connection?.saveData) return;
        const selector = window.matchMedia('(min-width: 768px)').matches
            ? 'video[data-video-src].md\\:block' : 'video[data-video-src].md\\:hidden';
        const video = document.querySelector(selector);
        if (!video) return;
        video.src = video.dataset.videoSrc;
        video.load();
        const play = video.play();
        if (play && play.catch) play.catch(function () {});
    }
    if (document.readyState === 'complete') startHeroVideo();
    else window.addEventListener('load', startHeroVideo, {once: true});
})();
</script>
@endpush
