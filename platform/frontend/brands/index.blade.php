{{-- ---------------
-- Top Brands Page
-- --------------- --}}
@extends('frontend.layouts.app')

@section('title', 'Top Brands | Trinity Mabati Factory')
@section('meta_description', 'Explore the stationery and office-supply brands available at ' . config('app.name') . '.')

@section('content')

    <div style="background-color: var(--band-grey, #F4F5F4); min-height: 60vh;">

    <section class="mx-auto max-w-7xl px-6 py-12">
        <div class="mb-8">
            <p class="text-xs font-semibold uppercase tracking-wider text-primary" style="font-family: var(--font-ui);">Trusted makes</p>
            <h1 class="text-3xl md:text-4xl text-text mt-1" style="font-family: var(--font-heading); font-weight: 800;">Top Brands</h1>
            <p class="mt-2 text-sm text-muted">Trusted stationery and office-supply brands in one place.</p>
        </div>

        @if ($brands->isEmpty())
            <div class="rounded-[12px] border border-border bg-white p-12 text-center text-muted">
                No brands to show yet.
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach ($brands as $brand)
                    <a href="{{ route('frontend.brands.show', $brand->slug) }}"
                        class="group bg-white border border-border rounded-[12px] overflow-hidden hover:border-primary/40 hover:shadow-lg transition flex flex-col">
                        <span class="flex items-center justify-center h-32 bg-primary-light/30 overflow-hidden" style="aspect-ratio: 2 / 1;">
                            @if ($brand->logo)
                                <img src="{{ asset(str_starts_with($brand->logo, 'uploads/') ? $brand->logo : 'uploads/brands/' . $brand->logo) }}"
                                    alt="{{ $brand->name }}" loading="lazy" onerror="this.remove();"
                                    class="h-16 w-auto object-contain group-hover:scale-105 transition-transform duration-500">
                            @else
                                <span class="w-14 h-14 rounded-[12px] bg-primary/10 flex items-center justify-center">
                                    <i class="fas fa-certificate text-primary text-xl"></i>
                                </span>
                            @endif
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    </div>

@endsection
