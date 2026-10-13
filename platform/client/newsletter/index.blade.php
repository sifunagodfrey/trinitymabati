{{-- ---------------
-- Client Newsletter Preferences
-- --------------- --}}
@extends('client.layouts.app')

@section('title', 'Newsletter Preferences')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
        <a href="{{ route('client.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Newsletter Preferences</span>
    </div>

    {{-- ---------------
    -- Flash Messages
    -- --------------- --}}
    @if (session('success'))
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-[8px] px-4 py-3 mb-6">
            <i class="fas fa-check-circle text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 text-sm rounded-[8px] px-4 py-3 mb-6">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- ---------------
    -- Preferences Card
    -- --------------- --}}
    <div class="bg-white border border-gray-200 rounded-[8px] overflow-hidden shadow-sm">

        <div class="px-6 py-5 border-b border-gray-100">
            <h1 class="text-lg font-semibold text-gray-900">Newsletter Preferences</h1>
            <p class="text-sm text-gray-500 mt-1">Choose which emails you'd like to receive from Haromi.</p>
        </div>

        <form method="POST" action="{{ route('client.newsletter.update') }}" class="p-6 space-y-5">
            @csrf

            {{-- ---------------
            -- Promotions
            -- --------------- --}}
            <label class="flex items-start gap-4 cursor-pointer group">
                <div class="flex-shrink-0 pt-0.5">
                    <input
                        type="checkbox"
                        name="receive_promotions"
                        value="1"
                        {{ $subscriber->receive_promotions ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition">Promotions &amp; Deals</p>
                    <p class="text-xs text-gray-500 mt-0.5">Exclusive discounts, flash sales, and seasonal offers.</p>
                </div>
            </label>

            <hr class="border-gray-100">

            {{-- ---------------
            -- Suggestions / Recommendations
            -- --------------- --}}
            <label class="flex items-start gap-4 cursor-pointer group">
                <div class="flex-shrink-0 pt-0.5">
                    <input
                        type="checkbox"
                        name="receive_suggestions"
                        value="1"
                        {{ $subscriber->receive_suggestions ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition">Suggestions &amp; Recommendations</p>
                    <p class="text-xs text-gray-500 mt-0.5">Product recommendations and personalised picks based on your activity.</p>
                </div>
            </label>

            <hr class="border-gray-100">

            {{-- ---------------
            -- Order Updates
            -- --------------- --}}
            <label class="flex items-start gap-4 cursor-pointer group">
                <div class="flex-shrink-0 pt-0.5">
                    <input
                        type="checkbox"
                        name="receive_order_updates"
                        value="1"
                        {{ $subscriber->receive_order_updates ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition">Order &amp; Delivery Updates</p>
                    <p class="text-xs text-gray-500 mt-0.5">Shipping updates, delivery notifications, and order digests.</p>
                </div>
            </label>

            <hr class="border-gray-100">

            {{-- ---------------
            -- News Updates
            -- --------------- --}}
            <label class="flex items-start gap-4 cursor-pointer group">
                <div class="flex-shrink-0 pt-0.5">
                    <input
                        type="checkbox"
                        name="receive_news_updates"
                        value="1"
                        {{ $subscriber->receive_news_updates ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition">News &amp; Platform Updates</p>
                    <p class="text-xs text-gray-500 mt-0.5">Product news, new features, and Haromi announcements.</p>
                </div>
            </label>

            {{-- ---------------
            -- Submit
            -- --------------- --}}
            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('client.dashboard') }}"
                    class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 rounded-[8px] hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-[8px] hover:bg-blue-700 transition">
                    Save Preferences
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
