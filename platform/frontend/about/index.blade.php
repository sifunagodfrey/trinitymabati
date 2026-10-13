{{-- ---------------
-- About Haromi Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'About ' . config('app.name'))
@section('meta_description',
    config('app.name') . ' is a digital platform that connects customers with products through
    innovative ownership solutions.')
@section('meta_keywords', config('app.name') . ', online shopping, ecommerce Kenya')
@section('og_title', 'About ' . config('app.name'))
@section('og_description', 'Connecting People. Creating Owners. Powering Progress.')

@section('content')

    {{-- ---------------
    -- Hero: split layout, copy on the left, image fills the right
    -- --------------- --}}
    <section class="relative overflow-hidden">
        <div class="grid lg:grid-cols-2">

            {{-- Left: gradient panel with heading --}}
            <div class="brand-gradient relative flex items-center px-6 py-20 md:px-12 lg:px-16 lg:py-28">
                <div class="relative z-10 max-w-xl text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/80"
                        style="font-family: var(--font-ui);">
                        About {{ config('app.name') }}
                    </p>
                    <h1 class="mt-4 text-3xl md:text-5xl leading-tight"
                        style="font-family: var(--font-heading); font-weight: 800;">
                        Redefining How People Access and Own Productive Assets
                    </h1>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('frontend.products') }}"
                            class="inline-flex items-center gap-2 rounded-[12px] bg-white px-6 py-3 text-sm font-semibold text-primary transition hover:bg-white/90"
                            style="font-family: var(--font-ui);">
                            Browse Products <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ route('frontend.contact') }}"
                            class="inline-flex items-center gap-2 rounded-[12px] border border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                            style="font-family: var(--font-ui);">
                            Talk to Support
                        </a>
                    </div>
                </div>
                <i class="fas fa-bolt absolute -right-6 -bottom-8 text-[12rem] md:text-[16rem]"
                    style="color: rgba(255,255,255,0.08);"></i>
            </div>

            {{-- Right: image fills the panel via object-cover on a fixed-height box --}}
            <div class="relative min-h-[300px] lg:min-h-full">
                <img src="{{ url('public/images/trinity-mabati-factory-main-banner-image.jpg') }}" alt="{{ config('app.name') }}"
                    class="absolute inset-0 h-full w-full object-cover">
            </div>
        </div>
    </section>

    {{-- ---------------
    -- Intro statement
    -- --------------- --}}
    <section class="bg-white py-16 md:py-20">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <p class="text-lg md:text-xl leading-relaxed text-gray-700">
                {{ config('app.name') }} is a digital platform that connects customers with products through
                innovative ownership solutions. We make it easier for people to discover, access, and own the
                productive assets that power their livelihoods.
            </p>
        </div>
    </section>

    {{-- ---------------
    -- Vision + Mission (two cards)
    -- --------------- --}}
    <section class="py-16 md:py-20" style="background-color: var(--background-color);">
        <div class="mx-auto max-w-5xl px-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="rounded-[12px] border border-border bg-white p-8 shadow-sm">
                    <span class="mb-5 flex h-16 w-16 items-center justify-center rounded-[12px] bg-primary/10">
                        <i class="fas fa-eye text-2xl text-primary"></i>
                    </span>
                    <h3 class="text-xl font-bold text-primary">Our Vision</h3>
                    <p class="mt-3 text-gray-600 leading-relaxed">
                        To create a future where every rider has the opportunity to turn their daily work and
                        earnings into ownership of the transportation assets that power their livelihoods.
                    </p>
                </div>
                <div class="rounded-[12px] border border-border bg-white p-8 shadow-sm">
                    <span class="mb-5 flex h-16 w-16 items-center justify-center rounded-[12px] bg-primary/10">
                        <i class="fas fa-bullseye text-2xl text-primary"></i>
                    </span>
                    <h3 class="text-xl font-bold text-primary">Our Mission</h3>
                    <p class="mt-3 text-gray-600 leading-relaxed">
                        To connect customers with trusted manufacturers and innovative ownership solutions through a
                        digital platform that makes productive asset ownership simple, transparent, and accessible.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ---------------
    -- Platform pillars: image left (fills section), pillars right
    -- --------------- --}}
    <section class="bg-white py-16 md:py-20">
        <div class="mx-auto max-w-6xl px-6">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-stretch">

                {{-- Image fills its half via object-cover --}}
                <div class="relative overflow-hidden rounded-[12px] shadow-sm min-h-[280px] lg:min-h-[420px]">
                    <img src="{{ url('public/images/trinity-mabati-factory-aboout.jpg') }}" alt="{{ config('app.name') }}"
                        onerror="this.src='{{ url('public/images/trinity-mabati-factory-main-banner-image.jpg') }}'"
                        class="absolute inset-0 h-full w-full object-cover">
                </div>

                <div class="flex flex-col justify-center gap-8">
                    <div>
                        <h3 class="text-xl font-bold" style="font-family: var(--font-heading); color: var(--primary-dark);">
                            A Digital Marketplace
                        </h3>
                        <p class="mt-3 text-gray-600 leading-relaxed">
                            {{ config('app.name') }} gives customers access to quality products
                            through a simple, digital experience.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold" style="font-family: var(--font-heading); color: var(--primary-dark);">
                            Connecting Sellers with Buyers
                        </h3>
                        <p class="mt-3 text-gray-600 leading-relaxed">
                            We bridge the gap between sellers and customers by creating a seamless digital
                            marketplace. Our platform helps businesses reach more buyers while offering customers
                            greater choice, convenience, and flexible ownership options.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold" style="font-family: var(--font-heading); color: var(--primary-dark);">
                            A Convenient Shopping Platform
                        </h3>
                        <p class="mt-3 text-gray-600 leading-relaxed">
                            Convenience is at the heart of everything we do. We help customers discover products,
                            order securely and receive dependable support throughout their shopping journey.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold" style="font-family: var(--font-heading); color: var(--primary-dark);">
                            Powered by Technology
                        </h3>
                        <p class="mt-3 text-gray-600 leading-relaxed">
                            Our platform simplifies the entire ownership journey, from onboarding and applications to
                            progress tracking, payments, and customer support, making ownership transparent,
                            convenient, and accessible.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ---------------
    -- Tagline banner
    -- --------------- --}}
    <section class="py-16 md:py-20" style="background-color: var(--background-color);">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <h2 class="text-2xl md:text-3xl font-bold"
                style="font-family: var(--font-heading); color: var(--primary-dark);">
                {{ config('app.name') }}: Quality Products. Convenient Shopping. Reliable Service.
            </h2>
        </div>
    </section>

    {{-- ---------------
    -- Closing CTA
    -- --------------- --}}
    <section class="mx-auto max-w-7xl px-6 py-16">
        <div class="brand-gradient relative overflow-hidden rounded-[12px] px-8 py-14 text-center md:px-14 md:py-16">
            <div class="relative z-10 mx-auto max-w-2xl">
                <h3 class="text-white text-2xl md:text-3xl leading-tight"
                    style="font-family: var(--font-heading); font-weight: 800;">
                    Shop with {{ config('app.name') }} Today
                </h3>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('frontend.products') }}"
                        class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-7 py-3.5 text-sm font-semibold text-white transition hover:opacity-90"
                        style="font-family: var(--font-ui);">
                        Browse Products <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                    <a href="{{ route('frontend.contact') }}"
                        class="inline-flex items-center gap-2 rounded-[12px] border border-white/25 px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-white/5"
                        style="font-family: var(--font-ui);">
                        Talk to Support
                    </a>
                </div>
            </div>
            <i class="fas fa-bolt absolute -right-6 -bottom-8 text-[12rem] md:text-[16rem]"
                style="color: rgba(127,191,63,0.10);"></i>
        </div>
    </section>

@endsection
