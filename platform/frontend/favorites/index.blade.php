{{-- ---------------
-- My Favorites / Wishlist Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'My Favorites | Trinity Mabati Factory')
@section('meta_description', 'View and manage your favorite products on Trinity Mabati Factory. Save items to easily access them later.')
@section('meta_keywords', 'Trinity Mabati Factory wishlist, my favorites Trinity Mabati Factory, saved products Trinity Mabati Factory')
@section('og_title', 'My Favorites | Trinity Mabati Factory')
@section('og_description', 'View and manage your favorite products on Trinity Mabati Factory.')

@section('content')

    {{-- ---------------
    -- Hero Section
    -- --------------- --}}
    <section class="relative py-16 border-b border-border overflow-hidden">

        <div class="absolute inset-0 bg-cover bg-center opacity-[0.15]"
            style="background-image: url('{{ url('public/images/trinity-mabati-factory-online-shopping.jpg') }}');">
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-secondary"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">

            <h1 class="text-3xl md:text-4xl font-bold mb-4">My Favorites</h1>

            <p class="max-w-2xl mx-auto text-white/90">
                View and manage your saved products.
            </p>

        </div>
    </section>

    {{-- ---------------
    -- Favorites Content
    -- --------------- --}}
    <section class="py-16 bg-gray-50">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @guest

                {{-- ---------------
                -- Guest: Login Gate
                -- --------------- --}}
                <div class="max-w-md mx-auto text-center py-12">

                    <div class="w-20 h-20 rounded-[12px] bg-primary/10 flex items-center justify-center mx-auto mb-5">
                        <i class="fas fa-heart text-3xl text-primary"></i>
                    </div>

                    <h3 class="text-xl font-bold mb-3">Login to View Your Favorites</h3>

                    <p class="text-gray-500 mb-6">
                        You need to be logged in to see your saved products.
                    </p>

                    <a href="{{ route('login') }}"
                        class="inline-block px-6 py-3 bg-primary text-white rounded-[12px] font-semibold hover:opacity-90 transition">
                        Login to Continue
                    </a>

                </div>

            @else

                @if(isset($favorites) && count($favorites) > 0)

                    {{-- ---------------
                    -- Favorites Grid
                    -- --------------- --}}
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                        @foreach($favorites as $product)
                            <div class="bg-white border border-border rounded-[8px] overflow-hidden shadow-sm hover:shadow-md transition">

                                <a href="{{ route('frontend.products.show', $product->slug) }}">
                                    <img src="{{ url('uploads/' . ($product->thumbnail ?: 'product-placeholder.jpg')) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-48 object-cover">
                                </a>

                                <div class="p-4 flex flex-col justify-between gap-3">

                                    <div>
                                        <a href="{{ route('frontend.products.show', $product->slug) }}"
                                            class="text-sm font-medium text-gray-800 hover:text-primary line-clamp-2">
                                            {{ $product->name }}
                                        </a>
                                        <p class="text-primary font-bold mt-1">@price($product->price)</p>
                                    </div>

                                    <div class="flex gap-2">

                                        <a href="{{ route('frontend.products.show', $product->slug) }}"
                                            class="flex-1 text-center text-sm px-3 py-2 border border-primary text-primary rounded-[8px] hover:bg-primary hover:text-white transition">
                                            Buy
                                        </a>

                                        <form method="POST" action="">
                                            @csrf
                                            <input type="hidden" name="remove_product_id" value="{{ $product->id }}">
                                            <button type="submit"
                                                class="text-sm px-3 py-2 border border-red-200 text-red-600 rounded-[8px] hover:bg-red-50 transition">
                                                Remove
                                            </button>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>

                @else

                    {{-- ---------------
                    -- Empty State
                    -- --------------- --}}
                    <div class="text-center py-16">

                        <i class="fas fa-heart text-5xl text-red-300 mb-5"></i>

                        <h3 class="text-xl font-bold mb-3">You don't have any favorites at the moment</h3>

                        <p class="text-gray-500 mb-6 max-w-sm mx-auto">
                            Start browsing and click the heart icon on products you like. They'll appear here for easy
                            access.
                        </p>

                        <a href="{{ route('frontend.products') }}"
                            class="inline-block px-6 py-3 border border-primary text-primary rounded-[12px] font-semibold hover:bg-primary hover:text-white transition">
                            Browse Products
                        </a>

                    </div>

                @endif

            @endguest

        </div>
    </section>

@endsection
