{{-- ---------------
-- Client Delivery Address
-- --------------- --}}
@extends('client.layouts.app')

@section('title', 'Delivery Address | Haromi')

@section('content')

    {{-- ---------------
    -- Page Header
    -- --------------- --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Delivery Address</h2>
            <p class="text-sm text-gray-500 mt-0.5">Your saved delivery location.</p>
        </div>
        <a href="{{ route('client.address.create') }}"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-900 text-white text-sm font-semibold
                   rounded-[8px] hover:bg-gray-700 transition">
            <i class="fas fa-pen text-xs"></i>
            {{ $profile?->county ? 'Update' : 'Set Address' }}
        </a>
    </div>

    {{-- ---------------
    -- Flash Messages
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-[8px] px-4 py-3">
            <i class="fas fa-check-circle text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($profile?->county && $profile?->delivery_location)

        {{-- ---------------
        -- Address Card
        -- --------------- --}}
        <div class="bg-white border border-gray-200 rounded-[8px] shadow-sm p-6 max-w-md">

            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-[12px] bg-gray-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-map-marker-alt text-gray-500"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm leading-snug">
                        {{ $profile->delivery_location }}
                    </p>
                    <p class="text-sm text-gray-500 mt-0.5">
                        {{ $profile->county }} County
                    </p>
                    <a href="{{ route('client.address.create') }}"
                        class="inline-flex items-center gap-1 mt-3 text-xs font-medium text-gray-500
                               hover:text-gray-900 transition">
                        <i class="fas fa-pen text-[10px]"></i>
                        Change location
                    </a>
                </div>
            </div>

        </div>

    @else

        {{-- ---------------
        -- Empty State
        -- --------------- --}}
        <div class="text-center py-20">
            <div class="w-20 h-20 rounded-[12px] bg-gray-100 flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-map-marker-alt text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No delivery address set</h3>
            <p class="text-sm text-gray-500 mb-6 max-w-sm mx-auto">
                Set your delivery location to speed up checkout.
            </p>
            <a href="{{ route('client.address.create') }}"
                class="inline-block px-6 py-3 bg-gray-900 text-white rounded-[12px] text-sm font-semibold
                       hover:bg-gray-700 transition">
                Set Address
            </a>
        </div>

    @endif

@endsection
