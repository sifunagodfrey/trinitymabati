{{-- ---------------
-- 404 Not Found Error Page
-- --------------- --}}
@extends('frontend.layouts.app')

@section('title', 'Page Not Found - Nawani Marketplace')
@section('meta_description', 'The page you are looking for does not exist on Nawani Marketplace.')

@section('content')

    {{-- ---------------
    -- 404 Hero Section
    -- --------------- --}}
    <section class="flex-1 flex items-center justify-center py-20 px-4 bg-gray-50 min-h-[70vh]">

        <div class="max-w-xl w-full text-center">

            {{-- ---------------
            -- Error Illustration / Icon
            -- --------------- --}}
            <div class="mb-6 flex justify-center">
                <div class="w-28 h-28 rounded-[12px] bg-primary/10 flex items-center justify-center">
                    <i class="fas fa-map-signs text-primary text-5xl"></i>
                </div>
            </div>

            {{-- ---------------
            -- Error Code
            -- --------------- --}}
            <h1 class="text-8xl font-extrabold text-primary tracking-tight leading-none mb-2">404</h1>

            {{-- ---------------
            -- Error Heading
            -- --------------- --}}
            <h2 class="text-2xl font-semibold text-gray-800 mb-3">Oops! Page not found</h2>

            {{-- ---------------
            -- Error Description
            -- --------------- --}}
            <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                The page you are looking for might have been removed, had its name changed,
                or is temporarily unavailable. Let's get you back on track.
            </p>

            {{-- ---------------
            -- Action Buttons
            -- --------------- --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">

                {{-- Go Back --}}
                <button onclick="window.history.back()"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 border border-gray-300 rounded-[12px] text-sm font-medium text-gray-700 bg-white hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Go Back
                </button>

                {{-- Home --}}
                <a href="{{ route('frontend.home') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-primary text-white rounded-[12px] text-sm font-medium hover:opacity-90 transition">
                    <i class="fas fa-home text-xs"></i>
                    Back to Home
                </a>

                {{-- Browse Products --}}
                <a href="{{ route('frontend.products') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-secondary text-text rounded-[12px] text-sm font-medium hover:opacity-90 transition">
                    <i class="fas fa-shopping-bag text-xs"></i>
                    Browse Products
                </a>

            </div>

            {{-- ---------------
            -- Helpful Links
            -- --------------- --}}
            <div class="mt-10 border-t border-gray-200 pt-6">

                <p class="text-xs text-gray-400 uppercase tracking-wide mb-3 font-semibold">You might be looking for</p>

                <div class="flex flex-wrap justify-center gap-3">


                    <a href="{{ route('frontend.blog') }}"
                        class="text-sm text-primary hover:underline flex items-center gap-1">
                        <i class="fas fa-newspaper text-xs"></i> Blog
                    </a>

                    <a href="{{ route('frontend.contact') }}"
                        class="text-sm text-primary hover:underline flex items-center gap-1">
                        <i class="fas fa-envelope text-xs"></i> Contact Us
                    </a>

                    <a href="{{ route('frontend.faq') }}"
                        class="text-sm text-primary hover:underline flex items-center gap-1">
                        <i class="fas fa-circle-question text-xs"></i> FAQ
                    </a>

                </div>

            </div>

        </div>

    </section>

@endsection
