{{-- ---------------
-- Single Brand Page
-- --------------- --}}
@extends('frontend.layouts.app')

@section('title', $brand->name . ' | Trinity Mabati Factory')
@section('meta_description', 'Browse ' . $brand->name . ' products available at ' . config('app.name') . '.')

@section('content')

    {{-- Brand banner --}}
    <section class="brand-gradient relative overflow-hidden">
        @if ($brand->banner_image)
            <img src="{{ asset(str_starts_with($brand->banner_image, 'uploads/') ? $brand->banner_image : 'uploads/brands/' . $brand->banner_image) }}"
                alt="{{ $brand->name }}" class="absolute inset-0 w-full h-full object-cover opacity-30" onerror="this.remove();">
        @endif
        <div class="relative mx-auto max-w-7xl px-6 py-14 flex items-center gap-6">
            @if ($brand->logo)
                <span class="hidden sm:flex items-center justify-center w-24 h-24 rounded-[12px] bg-white p-3 flex-shrink-0">
                    <img src="{{ asset(str_starts_with($brand->logo, 'uploads/') ? $brand->logo : 'uploads/brands/' . $brand->logo) }}"
                        alt="{{ $brand->name }}" class="max-h-full max-w-full object-contain" onerror="this.remove();">
                </span>
            @endif
            <div class="text-white">
                <nav class="text-xs text-white/70 mb-2" aria-label="Breadcrumb">
                    <a href="{{ route('frontend.brands') }}" class="hover:text-white">Brands</a>
                </nav>
                <h1 class="text-3xl md:text-4xl" style="font-family: var(--font-heading); font-weight: 800;">{{ $brand->name }}</h1>
                @if ($brand->description)
                    <p class="mt-2 max-w-xl text-sm text-white/80">{{ $brand->description }}</p>
                @endif
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12">
        @if ($products->isEmpty())
            <div class="rounded-[12px] border border-border bg-white p-12 text-center text-muted">
                No models listed for {{ $brand->name }} yet.
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach ($products as $product)
                    @include('frontend.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @endif
    </section>

@endsection
