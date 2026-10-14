{{-- ---------------
-- My Account Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'My Account | Trinity Mabati Factory')
@section('meta_description', 'Access your Trinity Mabati Factory account to manage orders, favorites, quotations, and profile settings.')
@section('meta_keywords', 'Trinity Mabati Factory my account, manage my Trinity Mabati Factory account, Trinity Mabati Factory dashboard')
@section('og_title', 'My Account | Trinity Mabati Factory')
@section('og_description', 'Access your Trinity Mabati Factory account to manage orders, favorites, quotations, and profile settings.')

@section('content')

    {{-- ---------------
    -- Hero Section
    -- --------------- --}}
    <section class="relative py-16 border-b border-border overflow-hidden">

        <div class="absolute inset-0 bg-cover bg-center opacity-[0.15]"
            style="background-image: url('{{ url('public/images/trinity-mabati-factory-online-shopping-card.jpg') }}');">
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-secondary"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">

            <h1 class="text-3xl md:text-4xl font-bold mb-4">My Account</h1>

            <p class="max-w-2xl mx-auto text-white/90">
                Manage your orders, favorites, quotations, and profile settings.
            </p>

        </div>
    </section>

    @auth

        {{-- ---------------
        -- Authenticated: Account Hub
        -- --------------- --}}
        <section class="py-16 bg-gray-50">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Welcome --}}
                <div class="mb-10 text-center">
                    <p class="text-gray-600">Welcome back, <strong>{{ auth()->user()->first_name }}</strong>!</p>
                </div>

                {{-- Account Links Grid --}}
                <div class="grid md:grid-cols-3 gap-6">

                    {{-- My Orders --}}
                    <a href="{{ route('client.orders.index') }}"
                        class="bg-white border border-border rounded-[8px] p-6 text-center hover:shadow-md transition group">
                        <div class="w-14 h-14 mx-auto rounded-[12px] bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 transition">
                            <i class="fas fa-box text-primary text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-lg mb-1">My Orders</h4>
                        <p class="text-gray-500 text-sm">View and track your orders</p>
                    </a>

                    {{-- My Wishlist --}}
                    <a href="{{ route('client.wishlist.index') }}"
                        class="bg-white border border-border rounded-[8px] p-6 text-center hover:shadow-md transition group">
                        <div class="w-14 h-14 mx-auto rounded-[12px] bg-red-50 flex items-center justify-center mb-4 group-hover:bg-red-100 transition">
                            <i class="fas fa-heart text-red-500 text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-lg mb-1">My Wishlist</h4>
                        <p class="text-gray-500 text-sm">Browse your saved products</p>
                    </a>

                    {{-- Quotations --}}

                    {{-- Track Order --}}
                    <a href="{{ route('frontend.track-order') }}"
                        class="bg-white border border-border rounded-[8px] p-6 text-center hover:shadow-md transition group">
                        <div class="w-14 h-14 mx-auto rounded-[12px] bg-yellow-50 flex items-center justify-center mb-4 group-hover:bg-yellow-100 transition">
                            <i class="fas fa-shipping-fast text-yellow-500 text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-lg mb-1">Track Order</h4>
                        <p class="text-gray-500 text-sm">Check your delivery status</p>
                    </a>

                    {{-- Profile Settings --}}
                    <a href="{{ route('client.settings.account') }}"
                        class="bg-white border border-border rounded-[8px] p-6 text-center hover:shadow-md transition group">
                        <div class="w-14 h-14 mx-auto rounded-[12px] bg-green-50 flex items-center justify-center mb-4 group-hover:bg-green-100 transition">
                            <i class="fas fa-user-cog text-green-500 text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-lg mb-1">Profile Settings</h4>
                        <p class="text-gray-500 text-sm">Update your account details</p>
                    </a>

                    {{-- Support --}}
                    <a href="{{ route('frontend.contact') }}"
                        class="bg-white border border-border rounded-[8px] p-6 text-center hover:shadow-md transition group">
                        <div class="w-14 h-14 mx-auto rounded-[12px] bg-purple-50 flex items-center justify-center mb-4 group-hover:bg-purple-100 transition">
                            <i class="fas fa-headset text-purple-500 text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-lg mb-1">Contact Support</h4>
                        <p class="text-gray-500 text-sm">Get help from our team</p>
                    </a>

                </div>

            </div>
        </section>

    @else

        {{-- ---------------
        -- Guest: Login / Register Prompt
        -- --------------- --}}
        <section class="py-16 bg-gray-50">

            <div class="max-w-xl mx-auto px-6">

                <div class="bg-white border border-border rounded-[8px] p-8 text-center shadow-sm">

                    <div class="w-16 h-16 rounded-[12px] bg-primary/10 flex items-center justify-center mx-auto mb-5">
                        <i class="fas fa-user text-primary text-2xl"></i>
                    </div>

                    <h2 class="text-xl font-bold mb-3">Access Your Account</h2>

                    <p class="text-gray-500 mb-8">
                        Log in to manage your orders, favorites, quotations, and profile settings.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">

                        <a href="{{ route('login') }}"
                            class="px-6 py-3 bg-primary text-white rounded-[12px] font-semibold hover:opacity-90 transition">
                            Login to Your Account
                        </a>

                        <a href="{{ route('register') }}"
                            class="px-6 py-3 border border-primary text-primary rounded-[12px] font-semibold hover:bg-primary hover:text-white transition">
                            Create an Account
                        </a>

                    </div>

                </div>

            </div>
        </section>

    @endauth

@endsection
