{{-- ---------------
-- Client Wishlist
-- --------------- --}}
@extends('client.layouts.app')

@section('title', 'My Wishlist | Haromi')

@section('content')

    {{-- ---------------
    -- Page Header
    -- --------------- --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-900">My Wishlist</h2>
            <p class="text-sm text-gray-500 mt-0.5">
                {{ $items->count() }} {{ Str::plural('item', $items->count()) }} saved
            </p>
        </div>
        <a href="{{ route('frontend.products') }}"
            class="text-sm font-medium text-primary hover:underline flex items-center gap-1.5">
            <i class="fas fa-plus text-xs"></i>
            Browse Products
        </a>
    </div>

    {{-- ---------------
    -- Flash Message
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-[8px] px-4 py-3">
            <i class="fas fa-check-circle text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ---------------
    -- Wishlist Items
    -- --------------- --}}
    @if ($items->isNotEmpty())

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            @foreach ($items as $item)

                @php
                    $product = $item->product;
                @endphp

                @if ($product)

                    <div class="bg-white border border-border rounded-[8px] overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">

                        {{-- ---------------
                        -- Product Image
                        -- --------------- --}}
                        <a href="{{ route('frontend.products.show', $product->slug) }}" class="block overflow-hidden">
                            <img src="{{ $product->thumbnail ? asset(str_starts_with($product->thumbnail, 'uploads/') ? $product->thumbnail : 'uploads/products/images/' . $product->thumbnail) : asset('public/images/placeholder.png') }}"
                                alt="{{ $product->name }}"
                                class="w-full h-44 object-cover hover:scale-105 transition duration-300">
                        </a>

                        <div class="p-4 flex flex-col gap-3 flex-1">

                            {{-- ---------------
                            -- Product Info
                            -- --------------- --}}
                            <div class="flex-1">
                                <a href="{{ route('frontend.products.show', $product->slug) }}"
                                    class="text-sm font-semibold text-gray-800 hover:text-primary line-clamp-2 leading-snug">
                                    {{ $product->name }}
                                </a>

                                @php
                                    $displayPrice = ($product->sale_price && $product->sale_price < $product->price)
                                        ? $product->sale_price
                                        : $product->price;
                                @endphp

                                <div class="mt-1.5 flex items-center gap-2">
                                    <span class="text-primary font-bold text-sm">
                                        @price($displayPrice)
                                    </span>
                                    @if ($product->sale_price && $product->sale_price < $product->price)
                                        <span class="text-xs text-gray-400 line-through">
                                            @price($product->price)
                                        </span>
                                    @endif
                                </div>

                                @if ($product->brand)
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $product->brand->name }}</p>
                                @endif
                            </div>

                            {{-- ---------------
                            -- Actions
                            -- --------------- --}}
                            <div class="flex items-center gap-2 mt-auto pt-2 border-t border-gray-100">

                                <a href="{{ route('frontend.products.show', $product->slug) }}"
                                    class="flex-1 text-center text-xs font-bold bg-primary text-white rounded-[12px] py-2.5 hover:opacity-90 transition">
                                    View Product
                                </a>

                                <form method="POST"
                                    action="{{ route('client.wishlist.remove', $product->id) }}">
                                    @csrf
                                    <button type="submit"
                                        title="Remove from wishlist"
                                        class="w-9 h-9 rounded-[12px] border border-red-200 text-red-500 flex items-center justify-center hover:bg-red-50 transition flex-shrink-0">
                                        <i class="fas fa-heart text-xs"></i>
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                @endif

            @endforeach

        </div>

    @else

        {{-- ---------------
        -- Empty State
        -- --------------- --}}
        <div class="text-center py-20">

            <div class="w-20 h-20 rounded-[12px] bg-red-50 flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-heart text-3xl text-red-300"></i>
            </div>

            <h3 class="text-lg font-bold text-gray-900 mb-2">Your wishlist is empty</h3>

            <p class="text-sm text-gray-500 mb-6 max-w-sm mx-auto">
                Browse products and click the heart icon to save items you love.
                They'll show up here for easy access.
            </p>

            <a href="{{ route('frontend.products') }}"
                class="inline-block px-6 py-3 bg-primary text-white rounded-[12px] text-sm font-semibold hover:opacity-90 transition">
                Browse Products
            </a>

        </div>

    @endif

@endsection
