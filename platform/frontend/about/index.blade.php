@extends('frontend.layouts.app')

@section('title', 'About Us | Trinity Mabati Factory')
@section('meta_description', 'Learn about Trinity Mabati Factory, a Kenyan roofing sheet supplier with over 5 years of experience and outlets in Nairobi and Migori.')
@section('og_title', 'About Trinity Mabati Factory')
@section('og_description', 'Quality roofing sheets and dedicated service across Kenya.')

@section('content')
<section class="relative isolate overflow-hidden bg-gray-950">
    <img src="{{ url('public/images/trinity-mabati-product-5.webp') }}" alt="Trinity Mabati roofing projects" class="absolute inset-0 h-full w-full object-cover opacity-45">
    <video class="absolute inset-0 h-full w-full object-cover opacity-0 transition-opacity duration-700" muted loop playsinline autoplay preload="metadata" poster="{{ url('public/images/trinity-mabati-product-5.webp') }}" aria-hidden="true" onplaying="this.classList.remove('opacity-0');this.classList.add('opacity-50')" onerror="this.classList.remove('opacity-50');this.classList.add('opacity-0')">
        <source src="{{ url('public/videos/trinity-mabati-hero-video.mp4') }}" type="video/mp4">
    </video>
    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/65 to-black/20"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-24 lg:px-8">
        <span class="text-sm font-bold uppercase tracking-widest text-red-200">About Us</span>
        <h1 class="mt-4 max-w-2xl text-4xl font-semibold leading-tight text-white sm:text-5xl">Getting to Know Us</h1>
        <p class="mt-5 max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">Your trusted source for quality roofing sheets and accessories across Kenya.</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('frontend.products') }}" class="inline-flex items-center gap-2 rounded-[4px] bg-primary px-6 py-3 font-bold text-white transition hover:brightness-110">Explore Our Mabati <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            <a href="{{ route('frontend.quotation.index') }}" class="inline-flex items-center gap-2 rounded-[4px] border border-white/70 px-6 py-3 font-bold text-white transition hover:bg-white/10">Request a Quote</a>
        </div>
    </div>
</section>

<section class="bg-white py-14 sm:py-20">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:items-center lg:gap-16 lg:px-8">
        <div>
            <p class="text-sm font-bold uppercase tracking-widest text-primary">Trinity Mabati Factory</p>
            <h2 class="mt-3 text-3xl font-bold leading-tight text-gray-900 sm:text-4xl">Built around quality and exceptional service</h2>
            <div class="mt-6 space-y-5 text-base leading-relaxed text-gray-600">
                <p><strong>Trinity Mabati Factory</strong> is a leading supplier in the roofing sheet industry, built on over 5 years of experience providing quality products and exceptional service. We are committed to supplying high-grade roofing sheet products tailored for both commercial and residential projects.</p>
                <p>Our inventory serves all trades as well as the general public across Kenya. You can visit us at our main outlets in <strong>Nairobi</strong> and <strong>Migori</strong> for dedicated service and expert advice.</p>
            </div>
        </div>
        <div class="aspect-[4/3] overflow-hidden rounded-[4px] bg-gray-100">
            <img src="{{ url('public/images/trinity-mabati-product-6.webp') }}" alt="Quality roofing sheets from Trinity Mabati Factory" class="h-full w-full object-cover" loading="lazy" onerror="this.src='{{ url('public/images/trinity-mabati-product.webp') }}'">
        </div>
    </div>
</section>

<section class="bg-[#fff8f6] py-14 sm:py-20" aria-label="Why choose Trinity Mabati Factory">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-primary">Why Choose Trinity Mabati Factory?</h2>
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['fa-medal', 'Premium Quality Steel', 'Roofing materials chosen for reliable performance.'],
                ['fa-truck-fast', 'Free Delivery Nationwide', 'Convenient delivery arrangements across Kenya.'],
                ['fa-shield-halved', '15 Years Warranty', 'Written warranty terms for eligible products.'],
                ['fa-certificate', 'KEBS Certified', 'A commitment to materials that meet applicable KEBS standards.'],
            ] as [$icon, $title, $description])
                <div class="rounded-[4px] border border-gray-100 bg-white p-6 shadow-sm">
                    <i class="fas {{ $icon }} text-2xl text-primary" aria-hidden="true"></i>
                    <h3 class="mt-5 text-lg font-bold text-gray-900">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">{{ $description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-14 sm:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-primary">Find us</p>
                <h2 class="mt-2 text-3xl font-bold text-gray-900">Our Outlets</h2>
            </div>
            <a href="{{ route('frontend.contact') }}" class="font-semibold text-primary hover:underline">Contact Us <i class="fas fa-arrow-right ml-1" aria-hidden="true"></i></a>
        </div>
        <div class="grid gap-5 md:grid-cols-2">
            <div class="rounded-[4px] border border-gray-200 p-6 sm:p-8">
                <div class="flex items-start gap-4">
                    <i class="fas fa-location-dot mt-1 text-xl text-primary" aria-hidden="true"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Nairobi Outlet</h3>
                        <p class="mt-2 text-gray-600">Enterprise Road, B. Binico Enterprises, Nairobi, Kenya.</p>
                        <a class="mt-3 inline-flex items-center gap-2 font-semibold text-primary hover:underline" href="tel:+254740550105"><i class="fas fa-mobile-screen-button" aria-hidden="true"></i> +254 740 550 105</a>
                    </div>
                </div>
            </div>
            <div class="rounded-[4px] border border-gray-200 p-6 sm:p-8">
                <div class="flex items-start gap-4">
                    <i class="fas fa-location-dot mt-1 text-xl text-primary" aria-hidden="true"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Migori Outlet</h3>
                        <p class="mt-2 text-gray-600">Kimaiga, next to Dolion Hotel</p>
                        <a class="mt-3 inline-flex items-center gap-2 font-semibold text-primary hover:underline" href="tel:+254796593842"><i class="fas fa-mobile-screen-button" aria-hidden="true"></i> +254 796 593 842</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fff8f6] py-14 text-center sm:py-20">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <h2 class="text-3xl font-bold text-gray-900">Ready to plan your roof?</h2>
        <p class="mt-4 text-gray-600">Browse our roofing profiles and request a quotation with your preferred gauge, finish and sheet length.</p>
        <a href="{{ route('frontend.quotation.index') }}" class="mt-7 inline-flex items-center gap-2 rounded-[4px] bg-primary px-7 py-3.5 font-bold text-white transition hover:brightness-110">Request a Quotation <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
    </div>
</section>
@endsection
