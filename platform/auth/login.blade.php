{{-- -------------------
     Login Page
------------------- --}}
@extends('frontend.layouts.app')

@section('title', 'Login - ' . config('app.name'))

@section('content')

    <div class="min-h-[70vh] flex items-center justify-center px-4 py-12 bg-gray-50">

        <div class="w-full max-w-md">

            {{-- Logo + heading --}}
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
                <p class="text-sm text-gray-500 mt-1">Login to your {{ config('app.name') }} account</p>
            </div>

            <div class="bg-white border border-border rounded-[12px] p-8 shadow-sm">

                {{-- Session status --}}
                @if (session('status'))
                    <div class="mb-5 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-[8px] text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Email address
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            autocomplete="email"
                            class="w-full px-4 py-2.5 border border-border rounded-[8px] text-sm text-gray-900
                                      outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition
                                      @error('email') border-red-400 @enderror">
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mt-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-semibold text-gray-700">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-xs text-primary hover:underline font-medium">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full px-4 py-2.5 border border-border rounded-[8px] text-sm text-gray-900
                                      outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition
                                      @error('password') border-red-400 @enderror">
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember me --}}
                    <div class="mt-4 flex items-center gap-2">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/30">
                        <label for="remember_me" class="text-sm text-gray-600 cursor-pointer">
                            Keep me signed in
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="mt-6 w-full py-3 bg-primary text-white text-sm font-semibold rounded-[12px]
                                   hover:opacity-90 transition">
                        Log in
                    </button>

                </form>

                {{-- Divider --}}
                <div class="my-6 flex items-center gap-3">
                    <div class="flex-1 border-t border-gray-100"></div>
                    <span class="text-xs text-gray-400">or</span>
                    <div class="flex-1 border-t border-gray-100"></div>
                </div>

                {{-- Register CTA --}}
                <p class="text-center text-sm text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">
                        Create one free
                    </a>
                </p>

            </div>

            {{-- Footer note --}}
            <p class="mt-6 text-center text-xs text-gray-400">
                By logging in you agree to {{ config('app.name') }}'s
                <a href="#" class="hover:underline">Terms of Service</a> and
                <a href="#" class="hover:underline">Privacy Policy</a>.
            </p>

        </div>

    </div>

@endsection
