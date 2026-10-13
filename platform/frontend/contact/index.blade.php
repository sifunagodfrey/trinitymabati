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
            border-radius: 1.5rem;
            padding: 1.75rem;
        }

        @media (min-width: 768px) {
            .contact-card {
                padding: 2.25rem;
            }
        }
    </style>

    {{-- Breadcrumb --}}
    <div class="border-b border-border">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-3">
            <nav class="text-xs text-muted flex items-center gap-2" aria-label="Breadcrumb">
                <a href="{{ route('frontend.home') }}" class="hover:text-primary transition">Home</a>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <span class="text-text font-medium">Contact Us</span>
            </nav>
        </div>
    </div>

    {{-- Page body --}}
    <div style="background-color: var(--background-color);">
        <div class="max-w-6xl mx-auto px-4 md:px-6 py-10 md:py-14">

            <div class="text-center mb-10">
                <h1 class="text-2xl md:text-3xl font-bold text-text">Get in Touch</h1>
                <p class="text-sm text-muted mt-2 max-w-xl mx-auto">
                    We are here to help with anything you need - questions, orders, or just a friendly hello.
                    Reach us through any of the options below.
                </p>
            </div>

            <div class="contact-grid">

                {{-- ===============================
                     LEFT: Contact details
                =============================== --}}
                <div class="contact-card brand-gradient relative overflow-hidden text-white shadow-xl">

                    {{-- Decorative circles --}}
                    <div class="absolute -top-12 -right-12 w-44 h-44 rounded-[12px] bg-white/10"></div>
                    <div class="absolute -bottom-16 -left-10 w-52 h-52 rounded-[12px] bg-white/5"></div>

                    <div class="relative">
                        <h2 class="text-xl font-bold mb-1.5">Contact Information</h2>
                        <p class="text-sm text-white/80 mb-8">Our team typically replies within a few hours.</p>

                        <ul class="space-y-6">
                            @if ($site['phone'] ?? null)
                                <li>
                                    <a href="{{ $site['phone_href'] }}" class="flex items-start gap-4 group">
                                        <span
                                            class="w-11 h-11 rounded-[12px] bg-white/15 flex items-center justify-center flex-shrink-0 group-hover:bg-white group-hover:text-primary transition">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <span>
                                            <span class="block text-xs uppercase tracking-wide text-white/70">Call Us</span>
                                            <span class="block text-sm font-semibold mt-0.5">{{ $site['phone'] }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif

                            @if ($site['whatsapp_url'] ?? null)
                                <li>
                                    <a href="{{ $site['whatsapp_url'] }}" target="_blank" rel="noopener"
                                        class="flex items-start gap-4 group">
                                        <span
                                            class="w-11 h-11 rounded-[12px] bg-white/15 flex items-center justify-center flex-shrink-0 group-hover:bg-white group-hover:text-green-600 transition">
                                            <i class="fab fa-whatsapp text-lg"></i>
                                        </span>
                                        <span>
                                            <span
                                                class="block text-xs uppercase tracking-wide text-white/70">WhatsApp</span>
                                            <span class="block text-sm font-semibold mt-0.5">Chat with us instantly</span>
                                        </span>
                                    </a>
                                </li>
                            @endif

                            @if ($site['email'] ?? null)
                                <li>
                                    <a href="mailto:{{ $site['email'] }}" class="flex items-start gap-4 group">
                                        <span
                                            class="w-11 h-11 rounded-[12px] bg-white/15 flex items-center justify-center flex-shrink-0 group-hover:bg-white group-hover:text-primary transition">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <span>
                                            <span class="block text-xs uppercase tracking-wide text-white/70">Email</span>
                                            <span
                                                class="block text-sm font-semibold mt-0.5 break-all">{{ $site['email'] }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif

                            @if ($site['address'] ?? null)
                                <li class="flex items-start gap-4">
                                    <span
                                        class="w-11 h-11 rounded-[12px] bg-white/15 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-location-dot"></i>
                                    </span>
                                    <span>
                                        <span class="block text-xs uppercase tracking-wide text-white/70">Location</span>
                                        <span class="block text-sm font-semibold mt-0.5">{{ $site['address'] }}</span>
                                    </span>
                                </li>
                            @endif
                        </ul>

                        {{-- Socials --}}
                        @if (!empty($site['socials'] ?? []))
                            <div class="mt-9 pt-6 border-t border-white/15">
                                <p class="text-xs uppercase tracking-wide text-white/70 mb-3">Follow Us</p>
                                <div class="flex items-center gap-2.5">
                                    @php
                                        $socialIcons = [
                                            'facebook' => 'fab fa-facebook-f',
                                            'instagram' => 'fab fa-instagram',
                                            'twitter' => 'fab fa-x-twitter',
                                            'tiktok' => 'fab fa-tiktok',
                                            'youtube' => 'fab fa-youtube',
                                            'linkedin' => 'fab fa-linkedin-in',
                                        ];
                                    @endphp
                                    @foreach ($site['socials'] as $network => $url)
                                        <a href="{{ $url }}" target="_blank" rel="noopener"
                                            aria-label="{{ ucfirst($network) }}"
                                            class="w-9 h-9 rounded-[12px] bg-white/15 flex items-center justify-center hover:bg-white hover:text-primary hover:-translate-y-0.5 transition-all">
                                            <i class="{{ $socialIcons[$network] ?? 'fas fa-link' }} text-sm"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
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
