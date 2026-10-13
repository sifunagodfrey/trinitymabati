{{-- ---------------
-- Create Account / Register Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'Create Account | ' . config('app.name'))
@section('meta_description', 'Create your free ' . config('app.name') . ' account to start shopping, track orders, and save favorites.')
@section('meta_keywords', config('app.name') . ' create account, register, sign up Kenya marketplace')

@section('content')

    {{-- ---------------
    -- Registration Form
    -- --------------- --}}
    <section class="py-16 bg-gray-50">

        <div class="max-w-lg mx-auto px-6">

            {{-- Header --}}
            <div class="text-center mb-8">

                <div class="w-16 h-16 rounded-[12px] bg-primary/10 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-primary text-2xl"></i>
                </div>

                <h1 class="text-2xl font-bold mb-2">Create Your Account</h1>

                <p class="text-gray-500 text-sm">
                    Join thousands of shoppers and sellers on {{ config('app.name') }}.
                </p>

            </div>

            {{-- ---------------
            -- Session Status
            -- --------------- --}}
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-[8px] text-sm">
                    {{ session('status') }}
                </div>
            @endif

            {{-- ---------------
            -- Validation Error Summary
            -- --------------- --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-[8px] text-sm">
                    <p class="font-semibold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ---------------
            -- Registration Form
            -- --------------- --}}
            <form method="POST" action="{{ route('register') }}"
                class="bg-white border border-border rounded-[8px] p-8 space-y-5 shadow-sm">
                @csrf

                {{-- First Name --}}
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus
                        autocomplete="given-name"
                        class="w-full border border-border rounded-[8px] px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Last Name --}}
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}"
                        autocomplete="family-name"
                        class="w-full border border-border rounded-[8px] px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="username" placeholder="you@example.com"
                        class="w-full border border-border rounded-[8px] px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required
                        autocomplete="tel" placeholder="07XX XXX XXX"
                        class="w-full border border-border rounded-[8px] px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary">
                    <p class="mt-1 text-xs text-gray-400">We send a verification code to this number to secure your account.</p>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full border border-border rounded-[8px] px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirm Password *
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password"
                        class="w-full border border-border rounded-[8px] px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary">
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full px-6 py-3 bg-primary text-white rounded-[8px] font-semibold hover:opacity-90 transition">
                    Create Account
                </button>

                {{-- Login Link --}}
                <p class="text-center text-sm text-gray-500">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Login</a>
                </p>

            </form>

        </div>
    </section>

@endsection
