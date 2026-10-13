{{-- -------------------
     Site Footer
     Four-column premium footer with brand and navigation columns,
     plus a slim legal bar at the base. Pulls contact details and
     socials from $site.
------------------- --}}
<footer class="site-footer w-full mt-20">

    {{-- Main columns --}}
    <div class="max-w-7xl mx-auto px-6 py-14 grid gap-10 sm:grid-cols-2 lg:grid-cols-12">

        {{-- Brand --}}
        <div class="lg:col-span-4">
            <img src="{{ $branding['logo_white'] }}" alt="{{ config('app.name') }}" class="h-10 w-auto">
            <p class="mt-4 text-sm leading-relaxed max-w-xs text-white/70">
                Reliable stationery and office supplies for work, school and everyday creativity.
            </p>
            @if (!empty($site['socials']))
                <div class="flex items-center gap-3 mt-6">
                    @foreach ($site['socials'] as $network => $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener"
                            aria-label="{{ ucfirst($network) }}"
                            class="w-9 h-9 rounded-[12px] flex items-center justify-center transition hover:bg-primary"
                            style="background-color: rgba(255,255,255,0.06);">
                            <i class="fab fa-{{ $network }} text-sm text-white"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Shop --}}
        <div class="lg:col-span-2">
            <h4 class="text-white text-sm font-semibold uppercase tracking-wider" style="font-family: var(--font-ui);">
                Shop</h4>
            <ul class="mt-4 space-y-3 text-sm text-white/70">
                <li><a href="{{ route('frontend.products') }}" class="hover:text-white transition">All Products</a></li>
                <li><a href="{{ route('frontend.categories') }}" class="hover:text-white transition">Top Categories</a></li>
                <li><a href="{{ route('frontend.brands') }}" class="hover:text-white transition">Top Brands</a></li>
                <li><a href="#" class="hover:text-white transition">Print Services</a></li>
            </ul>
        </div>

        {{-- Company --}}
        <div class="lg:col-span-2">
            <h4 class="text-white text-sm font-semibold uppercase tracking-wider" style="font-family: var(--font-ui);">
                Company</h4>
            <ul class="mt-4 space-y-3 text-sm text-white/70">
                <li><a href="{{ route('frontend.about') }}" class="hover:text-white transition">About Us</a></li>
                <li><a href="{{ route('frontend.track-order') }}" class="hover:text-white transition">Track Order</a>
                </li>
                <li><a href="{{ route('frontend.blog') }}" class="hover:text-white transition">Blog</a></li>
                <li><a href="{{ route('frontend.contact') }}" class="hover:text-white transition">Contact Us</a></li>
            </ul>
        </div>

        {{-- Contact --}}
        <div class="lg:col-span-4">
            <h4 class="text-white text-sm font-semibold uppercase tracking-wider" style="font-family: var(--font-ui);">
                Get in Touch</h4>
            <ul class="mt-4 space-y-3 text-sm text-white/70">
                @if ($site['address'] ?? null)
                    <li class="flex items-start gap-3">
                        <i class="fas fa-location-dot mt-1 text-primary"></i>
                        <span>{{ $site['address'] }}</span>
                    </li>
                @endif
                @if ($site['phone'] ?? null)
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone-alt text-primary"></i>
                        <a href="{{ $site['phone_href'] }}"
                            class="hover:text-white transition">{{ $site['phone'] }}</a>
                    </li>
                @endif
                @if ($site['email'] ?? null)
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-primary"></i>
                        <a href="mailto:{{ $site['email'] }}"
                            class="hover:text-white transition">{{ $site['email'] }}</a>
                    </li>
                @endif
                @if ($site['whatsapp_url'] ?? null)
                    <li class="flex items-center gap-3">
                        <i class="fab fa-whatsapp text-primary"></i>
                        <a href="{{ $site['whatsapp_url'] }}" target="_blank" rel="noopener"
                            class="hover:text-white transition">Chat on WhatsApp</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    {{-- Legal bar --}}
    <div class="border-t" style="border-color: rgba(255,255,255,0.08);">
        <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/50">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <div class="flex items-center gap-5">
                <a href="{{ route('frontend.privacy-policy.public') }}"
                    class="hover:text-white transition">Privacy</a>
                <a href="{{ route('frontend.terms') }}" class="hover:text-white transition">Terms</a>
                <a href="{{ route('frontend.refund-policy') }}" class="hover:text-white transition">Refunds</a>
            </div>
        </div>
    </div>
</footer>
