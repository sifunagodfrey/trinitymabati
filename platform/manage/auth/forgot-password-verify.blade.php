{{-- ---------------
-- Forgot Password - Step 2: Enter Reset Code
-- --------------- --}}
@extends('manage.layouts.auth')

@section('title', 'Enter Reset Code - ' . config('app.name'))

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
                        Check Your Inbox
                    </h2>
                    <p class="mt-3 text-white/80 leading-relaxed">
                        Enter the 6-digit code sent to your email
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
                    <img src="{{ url('public/images/trinity-mabati-factory-logo.png') }}" alt="{{ config('app.name') }} Logo"
                        onerror="this.style.display='none'" class="h-9 w-auto mx-auto">
                </div>

                <h1 class="text-2xl font-bold text-gray-900" style="font-family: var(--font-heading);">
                    Verification Code
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Sent to <strong>{{ $email }}</strong>
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

                <form method="POST" action="{{ route('manage.auth.forgot-password.verify.submit') }}" class="mt-8 space-y-5">
                    @csrf

                    {{-- Code --}}
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Reset code <span class="text-primary">*</span>
                        </label>
                        <input type="text"
                               name="code"
                               id="code"
                               value="{{ old('code') }}"
                               required autofocus
                               maxlength="6"
                               inputmode="numeric"
                               autocomplete="one-time-code"
                               placeholder="000000"
                               class="w-full rounded-[8px] border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-center text-sm font-mono tracking-widest text-gray-900 transition focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
                        <p class="mt-1.5 text-xs text-gray-400">The code expires in 15 minutes.</p>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full rounded-[8px] bg-primary py-3 text-sm font-semibold text-white transition hover:opacity-90">
                        Verify Code
                    </button>

                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Didn't receive a code?
                    <a href="{{ route('manage.auth.forgot-password') }}" class="font-medium text-primary hover:underline">
                        Try again
                    </a>
                </p>

            </div>
        </div>

    </div>

@endsection
