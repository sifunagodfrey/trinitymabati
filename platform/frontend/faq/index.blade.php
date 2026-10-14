{{-- ---------------
-- FAQs Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'Frequently Asked Questions | Trinity Mabati Factory')
@section('meta_description', 'Find answers to the most common questions about shopping, payments, and delivery on Trinity Mabati Factory.')
@section('meta_keywords', 'Trinity Mabati Factory FAQ, mother and baby store questions Kenya, how to shop Trinity Mabati Factory, Trinity Mabati Factory delivery')
@section('og_title', 'Frequently Asked Questions | Trinity Mabati Factory')
@section('og_description', 'Find answers to common questions about shopping, payments, and delivery on Trinity Mabati Factory.')

@section('content')

    {{-- ---------------
    -- Hero Section
    -- --------------- --}}
    <section class="relative py-20 border-b border-border overflow-hidden">

        <div class="absolute inset-0 bg-cover bg-center opacity-[0.10]"
            style="background-image: url('{{ url('public/images/trinity-mabati-factory-faq.jpg') }}');">
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-secondary"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">

            <h1 class="text-3xl md:text-4xl font-bold mb-4">Frequently Asked Questions</h1>

            <p class="max-w-2xl mx-auto text-white/90">
                Find answers to the most common questions about shopping, payments, and delivery on Trinity Mabati Factory.
            </p>

        </div>
    </section>

    {{-- ---------------
    -- FAQ Accordion
    -- --------------- --}}
    <section class="py-20 bg-white">

        <div class="max-w-4xl mx-auto px-6">

            <div x-data="{ open: null }" class="space-y-4">

                @forelse ($faqs as $faq)
                    <div class="border border-border rounded-[8px] overflow-hidden">
                        <button @click="open = open === {{ $faq->id }} ? null : {{ $faq->id }}"
                            class="w-full flex justify-between items-center px-6 py-4 text-left font-semibold hover:bg-gray-50 transition">
                            {{ $loop->iteration }}. {{ $faq->question }}
                            <i class="fas" :class="open === {{ $faq->id }} ? 'fa-minus' : 'fa-plus'"></i>
                        </button>
                        <div x-show="open === {{ $faq->id }}" x-collapse class="px-6 pb-4 text-gray-600">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-gray-400">
                        <i class="fas fa-circle-question text-3xl mb-3 block"></i>
                        No questions published yet. Please check back soon.
                    </div>
                @endforelse

            </div>

        </div>
    </section>

    {{-- ---------------
    -- CTA Section
    -- --------------- --}}
    <section class="py-16 bg-gray-50 text-center">

        <div class="max-w-3xl mx-auto px-6">

            <h2 class="text-2xl font-bold mb-4">Still Have Questions?</h2>

            <p class="text-gray-500 mb-8">Our support team is ready to help you anytime.</p>

            <a href="{{ route('frontend.contact') }}"
                class="inline-block px-8 py-3 bg-primary text-white rounded-[12px] font-semibold hover:opacity-90 transition">
                Contact Support
            </a>

        </div>
    </section>

@endsection
