{{-- ---------------
-- Forgot Password - Step 1: Enter Email
-- --------------- --}}
@extends('frontend.layouts.app')

@section('title', 'Forgot Password - ' . config('app.name'))

@section('content')

    <div class="min-h-[70vh] flex items-center justify-center px-4 py-12 bg-gray-50">
        <div class="w-full max-w-md">

            {{-- Heading --}}
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Forgot your password?</h2>
                <p class="text-sm text-gray-500 mt-1">Enter your email and we'll send you a reset code</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-[12px] p-8 shadow-sm">

                {{-- Status --}}
                @if (session('status'))
                    <div class="mb-5 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-[8px] text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Email address
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            autocomplete="email"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-[8px] text-sm text-gray-900
                                   outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition
                                   @error('email') border-red-400 @enderror">
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="mt-6 w-full py-3 bg-primary text-white text-sm font-semibold rounded-[12px]
                               hover:opacity-90 transition">
                        Send Reset Code
                    </button>

                </form>

                {{-- Back to login --}}
                <p class="mt-5 text-center text-sm text-gray-500">
                    Remembered your password?
                    <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">
                        Back to login
                    </a>
                </p>

            </div>

        </div>
    </div>

@endsection
