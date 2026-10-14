{{-- -------------------
     Site Footer
     Four-column premium footer with brand and navigation columns,
     plus a slim legal bar at the base. Pulls contact details and
     socials from $site.
------------------- --}}
<footer class="site-footer w-full mt-20">

    {{-- Main columns --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 grid gap-10 sm:grid-cols-2 lg:grid-cols-12">

        {{-- Brand --}}
        <div class="lg:col-span-4">
            <img src="{{ $branding['logo_white'] }}" alt="{{ config('app.name') }}" class="h-16 w-auto max-w-full object-contain lg:h-20">
            <p class="mt-4 max-w-xs overflow-hidden text-sm leading-relaxed text-white/70" style="max-height: 3.25em;"
                x-data="{ fullText: '', observer: null, lastWidth: 0,
                    fitText() { const paragraph = this.$el; const copy = this.$refs.footerCopy; const maxHeight = parseFloat(getComputedStyle(paragraph).lineHeight) * 2; copy.textContent = this.fullText + ' '; if (paragraph.scrollHeight &lt;= maxHeight + 1) return; let low = 0, high = this.fullText.length; while (low &lt; high) { const mid = Math.ceil((low + high) / 2); copy.textContent = this.fullText.slice(0, mid).trimEnd() + '… '; if (paragraph.scrollHeight &lt;= maxHeight + 1) low = mid; else high = mid - 1; } copy.textContent = this.fullText.slice(0, low).trimEnd() + '… '; },
                    init() { this.fullText = this.$refs.footerCopy.textContent.trim(); this.$nextTick(() => { this.fitText(); this.observer = new ResizeObserver(entries => { const width = entries[0].contentRect.width; if (width !== this.lastWidth) { this.lastWidth = width; this.fitText(); } }); this.observer.observe(this.$el); document.fonts.ready.then(() => { if (this.$el.isConnected) this.fitText(); }); }); },
                    destroy() { this.observer?.disconnect(); }
                }">
                <span x-ref="footerCopy">Trinity Mabati Factory delivers genuine, KEBS-certified metal roofing sheets with an ironclad 15-year written warranty directly to your construction site. </span><a href="{{ route('frontend.about') }}" class="whitespace-nowrap font-semibold text-white/80 transition hover:text-white">Read more <span aria-hidden="true">&rarr;</span><span class="sr-only"> about Trinity Mabati Factory</span></a>
            </p>
            @php
                $socialIcons = [
                    'facebook' => 'fa-facebook-f',
                    'instagram' => 'fa-instagram',
                    'tiktok' => 'fa-tiktok',
                    'youtube' => 'fa-youtube',
                    'twitter' => 'fa-x-twitter',
                    'linkedin' => 'fa-linkedin-in',
                ];
                $footerSocials = collect($site['socials'] ?? [])
                    ->filter(fn ($url, $network) => filled($url) && isset($socialIcons[$network]))
                    ->take(4);
            @endphp
            @if ($footerSocials->isNotEmpty())
                <div class="mt-5 flex flex-wrap items-center gap-3" aria-label="Social media links">
                    @foreach ($footerSocials as $network => $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                           aria-label="{{ ucfirst($network) }}"
                           class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-white/10 text-white transition hover:bg-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                            <i class="fab {{ $socialIcons[$network] }} text-base" aria-hidden="true"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product categories --}}
        <div class="lg:col-span-2">
            <h4 class="text-white text-sm font-semibold uppercase tracking-wider" style="font-family: var(--font-ui);">Products</h4>
            <ul class="mt-4 space-y-3 text-sm text-white/70">
                <li><a href="{{ route('frontend.categories.show', 'tile-profiles') }}" class="hover:text-white transition">Tile Profiles</a></li>
                <li><a href="{{ route('frontend.categories.show', 'stone-coated-profiles') }}" class="hover:text-white transition">Stone Coated Profiles</a></li>
                <li><a href="{{ route('frontend.categories.show', 'box-profile') }}" class="hover:text-white transition">Box Profile</a></li>
                <li><a href="{{ route('frontend.categories.show', 'corrugated-sheets') }}" class="hover:text-white transition">Corrugated Sheets</a></li>
            </ul>
        </div>

        {{-- Company --}}
        <div class="lg:col-span-2">
            <h4 class="text-white text-sm font-semibold uppercase tracking-wider" style="font-family: var(--font-ui);">
                Company</h4>
            <ul class="mt-4 space-y-3 text-sm text-white/70">
                <li><a href="{{ route('frontend.about') }}" class="hover:text-white transition">About Us</a></li>
                <li><a href="{{ route('frontend.quotation.index') }}" class="hover:text-white transition">Request Quotation</a>
                </li>
                <li><a href="{{ route('frontend.blog') }}" class="hover:text-white transition">Blog &amp; Tips</a></li>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/50">
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
