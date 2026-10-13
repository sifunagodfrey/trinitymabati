{{-- ---------------
-- Buy on Cash Page
-- --------------- --}}
@extends('frontend.layouts.app')

@section('title', 'Buy on Cash | Trinity Mabati Factory')
@section('meta_description', 'Pay in full and ride away today. Learn how buying your electric boda on cash works with Trinity Mabati Factory.')
@section('og_title', 'Buy on Cash | Trinity Mabati Factory')
@section('og_description', 'Own your electric boda outright with a single payment and ride away today.')

@section('content')

    {{-- ---------------
    -- Hero
    -- --------------- --}}
    <section class="relative overflow-hidden py-20 md:py-24">
        <div class="absolute inset-0" style="background: linear-gradient(135deg, #5A32A5 0%, #713FCE 55%, #AD70D4 100%);"></div>
        <i class="fas fa-money-bill-wave absolute -right-8 -bottom-10 text-[12rem] md:text-[18rem]" style="color: rgba(255,255,255,0.08);"></i>

        <div class="relative mx-auto max-w-4xl px-6 text-center text-white">
            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-white/80" style="font-family: var(--font-ui);">
                Outright ownership
            </p>
            <h1 class="mt-4 text-4xl md:text-5xl leading-tight" style="font-family: var(--font-heading); font-weight: 800;">
                Buy on Cash
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-sm md:text-base text-white/85 leading-relaxed">
                Buying on cash is the simplest way to own your electric boda. Pay the full price once, with no monthly
                instalments, and the boda is yours from day one.
            </p>
        </div>
    </section>

    {{-- ---------------
    -- How it works
    -- --------------- --}}
    <section class="py-16 md:py-20" style="background-color: #F4F5F4;">
        <div class="mx-auto max-w-5xl px-6">
            <div class="mb-12 text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-primary" style="font-family: var(--font-ui);">How it works</p>
                <h2 class="mt-2 text-2xl md:text-3xl" style="font-family: var(--font-heading); font-weight: 800; color: var(--primary-dark);">
                    Three simple steps
                </h2>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                @php
                    $steps = [
                        ['icon' => 'fa-magnifying-glass', 'title' => 'Choose your boda', 'text' => 'Browse the range and pick the electric boda that fits your needs.'],
                        ['icon' => 'fa-money-bill-wave', 'title' => 'Pay in full', 'text' => 'Settle the full price in one payment, securely via M-Pesa or other methods.'],
                        ['icon' => 'fa-key', 'title' => 'Ride away', 'text' => 'Take ownership immediately, with no instalments to track.'],
                    ];
                @endphp
                @foreach ($steps as $i => $step)
                    <div class="relative rounded-[12px] border border-border bg-white p-6 shadow-sm">
                        <span class="absolute right-5 top-5 text-3xl font-extrabold text-primary/10" style="font-family: var(--font-heading);">{{ $i + 1 }}</span>
                        <span class="mb-4 flex h-12 w-12 items-center justify-center rounded-[12px] bg-primary-light">
                            <i class="fas {{ $step['icon'] }} text-primary text-lg"></i>
                        </span>
                        <h3 class="text-base font-bold text-text" style="font-family: var(--font-heading);">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm text-muted leading-relaxed">{{ $step['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ---------------
    -- Benefits
    -- --------------- --}}
    <section class="py-16 md:py-20" style="background-color: #F4F5F4;">
        <div class="mx-auto max-w-5xl px-6">
            <div class="mb-12 text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-primary" style="font-family: var(--font-ui);">Why pay on cash</p>
                <h2 class="mt-2 text-2xl md:text-3xl" style="font-family: var(--font-heading); font-weight: 800; color: var(--primary-dark);">
                    The benefits of buying on cash
                </h2>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @php
                    $benefits = [
                        ['icon' => 'fa-circle-check', 'title' => 'Full ownership now', 'text' => 'The boda is yours outright the moment you pay, with no balance owing.'],
                        ['icon' => 'fa-piggy-bank', 'title' => 'No interest or fees', 'text' => 'Skip financing costs and instalment charges entirely.'],
                        ['icon' => 'fa-clock', 'title' => 'Quick and simple', 'text' => 'One payment, no paperwork to track, and you are on the road.'],
                    ];
                @endphp
                @foreach ($benefits as $b)
                    <div class="rounded-[12px] border border-border bg-white p-6 shadow-sm">
                        <span class="mb-4 flex h-12 w-12 items-center justify-center rounded-[12px] bg-primary-light">
                            <i class="fas {{ $b['icon'] }} text-primary text-lg"></i>
                        </span>
                        <h3 class="text-base font-bold text-text" style="font-family: var(--font-heading);">{{ $b['title'] }}</h3>
                        <p class="mt-2 text-sm text-muted leading-relaxed">{{ $b['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ---------------
    -- Call to action
    -- --------------- --}}
    <section class="py-16" style="background-color: #F4F5F4;">
        <div class="mx-auto max-w-7xl px-6">
            <div class="relative overflow-hidden rounded-[12px] px-8 py-12 md:px-14 md:py-16" style="background-color: #0F1A14;">
                <div class="relative z-10 max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em]" style="color:#AD70D4; font-family: var(--font-ui);">Ready when you are</p>
                    <h2 class="mt-3 text-white text-3xl md:text-4xl leading-tight" style="font-family: var(--font-heading); font-weight: 800;">
                        Find the boda that is right for you
                    </h2>
                    <p class="mt-4 text-white/80 text-sm md:text-base leading-relaxed">
                        Browse the full range to compare models, or reach out to our team for help choosing the right
                        electric boda to buy on cash.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('frontend.products') }}"
                            class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-7 py-3.5 rounded-[12px] transition"
                            style="font-family: var(--font-ui);">
                            Browse Products <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ route('frontend.contact') }}"
                            class="inline-flex items-center gap-2 text-white text-sm font-semibold px-7 py-3.5 rounded-[12px] transition border border-white/25 hover:bg-white/5"
                            style="font-family: var(--font-ui);">
                            Contact Us
                        </a>
                    </div>
                </div>
                <i class="fas fa-money-bill-wave absolute -right-6 -bottom-8 text-[12rem] md:text-[16rem]" style="color: rgba(127,191,63,0.10);"></i>
            </div>
        </div>
    </section>

@endsection
