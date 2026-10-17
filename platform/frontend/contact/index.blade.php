{{-- ---------------
-- Contact Us Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'Contact Us | Trinity Mabati Factory')
@section('meta_description',
    'Reach out to Trinity Mabati Factory for support, product questions, or any help you need on your
    shopping experience.')
@section('meta_keywords', 'Trinity Mabati Factory contact, support Trinity Mabati Factory, Trinity Mabati Factory customer care')
@section('og_title', 'Contact Us | Trinity Mabati Factory')
@section('og_description', 'Reach out to Trinity Mabati Factory for support, product questions, or any help you need.')

@section('content')

    <style>
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        .contact-two {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }

        @media (min-width: 640px) {
            .contact-two {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (min-width: 1024px) {
            .contact-grid {
                grid-template-columns: 1fr 1.25fr;
                gap: 2rem;
            }
        }

        .contact-card {
            border-radius: 4px;
            padding: 1.75rem;
        }

        @media (min-width: 768px) {
            .contact-card {
                padding: 2.25rem;
            }
        }
    </style>

    {{-- Page body --}}
    <div style="background-color: var(--background-color);">
        <div class="max-w-6xl mx-auto px-4 md:px-6 py-10 md:py-14">

            <div class="text-center mb-10">
                <h1 class="text-2xl md:text-3xl font-bold text-primary">Get in Touch</h1>
                <p class="text-sm text-muted mt-2 max-w-xl mx-auto">
                    Reach us through any of the options below.
                </p>
            </div>

            <div class="contact-grid">

                {{-- Left: call center, email, Nairobi and Migori locations --}}
                <div class="grid gap-4 self-start">
                    @if (!empty($site['phone']))
                        <section class="rounded-[4px] border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                            <div class="flex items-start gap-4">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-[4px] bg-red-50 text-primary"><i class="fas fa-headset text-lg" aria-hidden="true"></i></span>
                                <div class="min-w-0">
                                    <h2 class="text-lg font-bold text-gray-900">Call Center</h2>
                                    <p class="mt-2 text-sm leading-6 text-gray-600">Call us for sales and support.</p>
                                    <a href="{{ $site['phone_href'] }}" class="mt-2 inline-block text-base font-bold text-primary hover:underline">{{ $site['phone'] }}</a>
                                </div>
                            </div>
                        </section>
                    @endif
                    @if (!empty($site['email']))
                        <section class="rounded-[4px] border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                            <div class="flex items-start gap-4">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-[4px] bg-red-50 text-primary"><i class="fas fa-envelope text-lg" aria-hidden="true"></i></span>
                                <div class="min-w-0">
                                    <h2 class="text-lg font-bold text-gray-900">Email</h2>
                                    <a href="mailto:{{ $site['email'] }}" class="mt-2 inline-block text-sm text-primary hover:underline" style="overflow-wrap:anywhere;">{{ $site['email'] }}</a>
                                </div>
                            </div>
                        </section>
                    @endif
                    @foreach (($site['branches'] ?? []) as $branch)
                        @if (!empty($branch['name']) && !empty($branch['address']))
                            <section class="rounded-[4px] border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                                <div class="flex items-start gap-4">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-[4px] bg-red-50 text-primary"><i class="fas fa-location-dot text-lg" aria-hidden="true"></i></span>
                                    <div class="min-w-0">
                                        <h2 class="text-lg font-bold text-gray-900">{{ $branch['name'] }}</h2>
                                        @if (!empty($branch['address']))
                                            <p class="mt-2 text-sm leading-6 text-gray-600">{{ $branch['address'] }}</p>
                                        @endif
                                        @if (!empty($branch['phone']))
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $branch['phone']) }}" class="mt-2 inline-block text-base font-bold text-primary hover:underline">{{ $branch['phone'] }}</a>
                                        @endif
                                    </div>
                                </div>
                            </section>
                        @endif
                    @endforeach
                </div>

                {{-- ===============================
                     RIGHT: Message form
                =============================== --}}
                <div class="contact-card bg-white"
                    style="border:1px solid var(--border-color, #e5e7eb); box-shadow: 0 1px 3px rgba(0,0,0,.06);">

                    <h2 class="text-xl font-bold text-text mb-1.5">Send Us a Message</h2>
                    <p class="text-sm text-muted mb-6">Fill in the form and we will get back to you shortly.</p>

                    {{-- Flash Messages --}}
                    @if (session('success'))
                        <div class="mb-5 rounded-[8px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-5 rounded-[8px] border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('frontend.contact.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="contact-two">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name
                                    *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="w-full border border-border rounded-[8px] px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                    required>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Your Email
                                    *</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    class="w-full border border-border rounded-[8px] px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                    required>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number
                                *</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                placeholder="0710444627"
                                class="w-full border border-border rounded-[8px] px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                required>
                            <p class="text-xs text-gray-500 mt-1">A valid Kenyan number, e.g. 0710444627 or 254710444627</p>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                            <textarea name="message" id="message" rows="5"
                                class="w-full border border-border rounded-[8px] px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                required>{{ old('message') }}</textarea>
                        </div>

                        {{-- Captcha --}}
                        <div>
                            <label for="captcha" class="block text-sm font-medium text-gray-700 mb-1">What is 4 + 7?
                                *</label>
                            <input type="number" name="captcha" id="captcha"
                                class="w-full border border-border rounded-[8px] px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                required>
                            <p class="text-xs text-gray-500 mt-1">This helps us prevent spam.</p>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-primary text-white rounded-[12px] font-bold text-sm hover:opacity-90 transition shadow-sm">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>

@endsection
