{{-- ---------------
-- Forgot Password - Step 3: Set New Password
-- --------------- --}}
@extends('frontend.layouts.app')

@section('title', 'Set New Password - ' . config('app.name'))

@section('content')

    <div class="min-h-[70vh] flex items-center justify-center px-4 py-12 bg-gray-50">
        <div class="w-full max-w-md">

            {{-- Heading --}}
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Set a new password</h2>
                <p class="text-sm text-gray-500 mt-1">Choose a strong password for your account</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-[12px] p-8 shadow-sm">

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-5 p-3 bg-red-50 border border-red-200 text-red-700 rounded-[8px] text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.do-reset.submit') }}">
                    @csrf

                    {{-- New Password --}}
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            New password
                        </label>
                        <input id="password" type="password" name="password" required autofocus
                            autocomplete="new-password"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-[8px] text-sm text-gray-900
                                   outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition
                                   @error('password') border-red-400 @enderror">
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-gray-400">Minimum 8 characters</p>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mt-4">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Confirm new password
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-[8px] text-sm text-gray-900
                                   outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition
                                   @error('password_confirmation') border-red-400 @enderror">
                        @error('password_confirmation')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="mt-6 w-full py-3 bg-primary text-white text-sm font-semibold rounded-[12px]
                               hover:opacity-90 transition">
                        Reset Password
                    </button>

                </form>

            </div>

        </div>
    </div>

@endsection
