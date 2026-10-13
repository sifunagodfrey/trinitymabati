{{-- ---------------
-- Forgot Password - Step 2: Enter Reset Code
-- --------------- --}}
@extends('frontend.layouts.app')

@section('title', 'Enter Reset Code - ' . config('app.name'))

@section('content')

    <div class="min-h-[70vh] flex items-center justify-center px-4 py-12 bg-gray-50">
        <div class="w-full max-w-md">

            {{-- Heading --}}
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Check your inbox</h2>
                <p class="text-sm text-gray-500 mt-1">
                    We sent a 6-digit code to <strong>{{ $email }}</strong>
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-[12px] p-8 shadow-sm">

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-5 p-3 bg-red-50 border border-red-200 text-red-700 rounded-[8px] text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.verify.submit') }}">
                    @csrf

                    {{-- Code --}}
                    <div>
                        <label for="code" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Reset code
                        </label>
                        <input id="code" type="text" name="code" value="{{ old('code') }}"
                            required autofocus maxlength="6" inputmode="numeric" autocomplete="one-time-code"
                            placeholder="000000"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-[8px] text-sm text-gray-900
                                   tracking-widest text-center font-mono outline-none
                                   focus:border-primary focus:ring-2 focus:ring-primary/20 transition
                                   @error('code') border-red-400 @enderror">
                        @error('code')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <p class="mt-2 text-xs text-gray-400 text-center">
                        The code expires in 15 minutes. Check your spam folder if you don't see it.
                    </p>

                    {{-- Submit --}}
                    <button type="submit"
                        class="mt-6 w-full py-3 bg-primary text-white text-sm font-semibold rounded-[12px]
                               hover:opacity-90 transition">
                        Verify Code
                    </button>

                </form>

                {{-- Resend --}}
                <p class="mt-5 text-center text-sm text-gray-500">
                    Didn't receive a code?
                    <a href="{{ route('password.request') }}" class="text-primary font-semibold hover:underline">
                        Try again
                    </a>
                </p>

            </div>

        </div>
    </div>

@endsection
