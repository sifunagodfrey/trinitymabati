{{-- -------------------
     Site Page
     Generic renderer for editable pages stored in su_pages
------------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', ($page->meta_title ?: $page->title) . ' | Trinity Mabati Factory')
@section('meta_description', $page->meta_description ?? '')
@section('og_title', $page->meta_title ?: $page->title)
@section('og_description', $page->meta_description ?? '')

@section('content')

    {{-- ---------------
    -- Hero Section
    -- --------------- --}}
    <section class="relative py-20 border-b border-border overflow-hidden">

        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-secondary"></div>

        <div class="relative max-w-7xl mx-auto px-6 text-center text-white">

            <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $page->title }}</h1>

            @if ($page->meta_description)
                <p class="max-w-2xl mx-auto text-white/90">{{ $page->meta_description }}</p>
            @endif

        </div>
    </section>

    {{-- ---------------
    -- Page Content
    -- --------------- --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-sm text-gray-700 leading-relaxed [&_p]:mb-4 [&_p:last-child]:mb-0 [&_h1]:text-2xl [&_h1]:font-bold [&_h1]:text-gray-900 [&_h1]:mt-8 [&_h1]:mb-3 [&_h2]:text-xl [&_h2]:font-bold [&_h2]:text-gray-900 [&_h2]:mt-8 [&_h2]:mb-3 [&_h3]:text-base [&_h3]:font-semibold [&_h3]:text-gray-900 [&_h3]:mt-6 [&_h3]:mb-2 [&_ul]:list-disc [&_ul]:pl-6 [&_ul]:mb-4 [&_ul]:space-y-1.5 [&_ol]:list-decimal [&_ol]:pl-6 [&_ol]:mb-4 [&_ol]:space-y-1.5 [&_li]:text-sm [&_strong]:font-semibold [&_b]:font-semibold [&_em]:italic [&_i]:italic [&_a]:text-primary [&_a]:underline [&_a:hover]:opacity-80 [&_blockquote]:border-l-4 [&_blockquote]:border-gray-200 [&_blockquote]:pl-4 [&_blockquote]:italic [&_blockquote]:text-gray-500 [&_blockquote]:my-4 [&_hr]:my-6 [&_hr]:border-gray-200 [&_table]:w-full [&_table]:text-left [&_table]:mb-4 [&_th]:py-2 [&_th]:px-3 [&_th]:bg-gray-50 [&_th]:font-semibold [&_td]:py-2 [&_td]:px-3 [&_td]:border-t [&_td]:border-gray-100">
                {!! $page->content !!}
            </div>

            <p class="mt-10 text-xs text-gray-400">
                Last updated {{ optional($page->updated_at ?? $page->created_at)->format('d M Y') }}
            </p>
        </div>
    </section>

    {{-- ---------------
    -- CTA Section
    -- --------------- --}}
    <section class="py-16 bg-gray-50 text-center">
        <div class="max-w-3xl mx-auto px-6">
            <h2 class="text-2xl font-bold mb-4">Need More Help?</h2>
            <p class="text-gray-500 mb-8">Our support team is ready to assist you anytime.</p>
            <a href="{{ route('frontend.contact') }}"
                class="inline-block px-8 py-3 bg-primary text-white rounded-[12px] font-semibold hover:opacity-90 transition">
                Contact Support
            </a>
        </div>
    </section>

@endsection
