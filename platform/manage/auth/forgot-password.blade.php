{{-- ---------------
-- Forgot Password - Step 1: Enter Email
-- --------------- --}}
@extends('manage.layouts.auth')

@section('title', 'Forgot Password - ' . config('app.name'))

@section('content')

    {{-- ---------------
    -- Split Screen Layout
    -- --------------- --}}
    <div class="h-screen h-dvh w-full flex overflow-hidden">

        {{-- ---------------
        -- Left Panel: Image with overlay
        -- --------------- --}}
        <div class="hidden lg:block lg:w-1/2 h-full relative">
            <img src="{{ url('public/images/trinity-mabati-factory-main-banner-image.jpg') }}"
                 alt="{{ config('app.name') }}"
                 class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(15,26,20,0.15) 0%, rgba(15,26,20,0.75) 100%);"></div>

            <div class="relative z-10 flex h-full flex-col justify-between p-12">
                <img src="{{ url('public/images/trinity-mabati-factory-logo.png') }}"
                     alt="{{ config('app.name') }} Logo"
                     onerror="this.style.display='none'"
                     class="h-9 w-auto brightness-0 invert">

                <div class="max-w-md">
                    <h2 class="text-3xl font-bold text-white leading-tight" style="font-family: var(--font-heading);">
                        Account Recovery
                    </h2>
                    <p class="mt-3 text-white/80 leading-relaxed">
                        A verification code will be sent to your registered email
                    </p>
                </div>
            </div>
        </div>

        {{-- ---------------
        -- Right Panel: Form
        -- --------------- --}}
        <div class="flex w-full lg:w-1/2 h-full overflow-y-auto bg-white px-6 py-12">
            <div class="w-full max-w-sm m-auto">

                <div class="lg:hidden mb-8 text-center">
                    <img src="{{ url('public/images/trinity-mabati-factory-logo.png') }}"
                         alt="{{ config('app.name') }} Logo"
                         onerror="this.style.display='none'"
                         class="h-9 w-auto mx-auto">
                </div>

                <h1 class="text-2xl font-bold text-gray-900" style="font-family: var(--font-heading);">
                    Reset Password
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Enter your email and we will send you a reset code.
                </p>

                {{-- ---------------
                -- Error Alert
                -- --------------- --}}
                @if ($errors->any())
                    <div class="mt-6 flex items-start gap-2 rounded-[8px] border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                        <i class="fas fa-circle-exclamation mt-0.5 text-red-500"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('manage.auth.forgot-password.send') }}" class="mt-8 space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email address <span class="text-primary">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email') }}"
                                   placeholder="you@example.com"
                                   required autofocus
                                   class="w-full rounded-[8px] border border-gray-200 bg-gray-50 pl-10 pr-3.5 py-2.5 text-sm text-gray-900 transition focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full rounded-[8px] bg-primary py-3 text-sm font-semibold text-white transition hover:opacity-90">
                        Send Reset Code
                    </button>

                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    <a href="{{ route('manage.auth.login') }}" class="font-medium text-primary hover:underline">
                        Back to login
                    </a>
                </p>

            </div>
        </div>

    </div>

@endsection
