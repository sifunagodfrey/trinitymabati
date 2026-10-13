{{-- ---------------
-- Login Page
-- --------------- --}}
@extends('manage.layouts.auth')

{{-- ---------------
-- Title
-- --------------- --}}
@section('title', 'Login - ' . config('app.name'))

@section('content')

    {{-- ---------------
    -- Split Screen Layout
    -- --------------- --}}
    <div class="h-screen h-dvh w-full flex overflow-hidden">

        {{-- ---------------
        -- Left Panel: Image with overlay
        -- --------------- --}}
        <div class="hidden lg:block lg:w-1/2 h-full relative">
            <img src="{{ url('public/images/trinity-mabati-factory-main-banner-image.jpg') }}" alt="{{ config('app.name') }}"
                class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0"
                style="background: linear-gradient(180deg, rgba(15,26,20,0.15) 0%, rgba(15,26,20,0.75) 100%);"></div>

            <div class="relative z-10 flex h-full flex-col justify-between p-12">
                <img src="{{ url('public/images/trinity-mabati-factory-logo.png') }}" alt="{{ config('app.name') }} Logo"
                    onerror="this.style.display='none'" class="h-9 w-auto brightness-0 invert">

                <div class="max-w-md">
                    <h2 class="text-3xl font-bold text-white leading-tight" style="font-family: var(--font-heading);">
                        Welcome to {{ config('app.name') }}
                    </h2>
                    <p class="mt-3 text-white/80 leading-relaxed">
                        Sign in to continue to your account
                    </p>
                </div>
            </div>
        </div>

        {{-- ---------------
        -- Right Panel: Login Form
        -- --------------- --}}
        <div class="flex w-full lg:w-1/2 h-full overflow-y-auto bg-white px-6 py-12">
            <div class="w-full max-w-sm m-auto">

                <div class="lg:hidden mb-8 text-center">
                    <img src="{{ url('public/images/trinity-mabati-factory-logo.png') }}" alt="{{ config('app.name') }} Logo"
                        onerror="this.style.display='none'" class="h-9 w-auto mx-auto">
                </div>

                <h1 class="text-2xl font-bold text-gray-900" style="font-family: var(--font-heading);">
                    Login
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Enter your details below to sign in.
                </p>

                {{-- ---------------
                -- Error Alert
                -- --------------- --}}
                @if ($errors->any())
                    <div
                        class="mt-6 flex items-start gap-2 rounded-[8px] border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                        <i class="fas fa-circle-exclamation mt-0.5 text-red-500"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- ---------------
                -- Login Form
                -- --------------- --}}
                <form method="POST" action="{{ route('manage.auth.login.submit') }}" class="mt-8 space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email address <span class="text-primary">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                placeholder="you@example.com" required
                                class="w-full rounded-[8px] border border-gray-200 bg-gray-50 pl-10 pr-3.5 py-2.5 text-sm text-gray-900 transition focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Password <span class="text-primary">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" name="password" id="password" required
                                class="w-full rounded-[8px] border border-gray-200 bg-gray-50 pl-10 pr-3.5 py-2.5 text-sm text-gray-900 transition focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
                        </div>
                    </div>

                    {{-- Remember Me + Forgot Password --}}
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="rounded border-gray-300 text-primary focus:ring-primary/30">
                            Remember me
                        </label>
                        <a href="{{ route('manage.auth.forgot-password') }}"
                            class="text-sm font-medium text-primary hover:underline">
                            Forgot Password?
                        </a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full rounded-[8px] bg-primary py-3 text-sm font-semibold text-white transition hover:opacity-90">
                        Login
                    </button>

                </form>

            </div>
        </div>

    </div>

@endsection
