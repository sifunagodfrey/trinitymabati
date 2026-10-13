<div class="hidden w-full border-y border-gray-200 bg-white text-xs text-text lg:block">
    <div class="mx-auto grid h-10 max-w-[1440px] grid-cols-3 items-center px-20">
        <div class="flex items-center gap-5">
            @if (($site['phone'] ?? null))
                <a href="{{ $site['phone_href'] }}" class="group flex items-center gap-1.5 text-text transition hover:text-secondary">
                    <i class="fas fa-phone-alt text-[10px] text-primary transition group-hover:text-secondary"></i>
                    <span>{{ $site['phone'] }}</span>
                </a>
            @endif
            @if (($site['email'] ?? null))
                <a href="mailto:{{ $site['email'] }}" class="group flex items-center gap-1.5 text-text transition hover:text-secondary">
                    <i class="fas fa-envelope text-[10px] text-primary transition group-hover:text-secondary"></i>
                    <span>{{ $site['email'] }}</span>
                </a>
            @endif
        </div>
        <p class="text-center font-medium text-muted">Quality stationery and office supplies in one place.</p>
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('frontend.track-order') }}" class="text-text transition hover:text-secondary">Track Order</a>
            <span class="text-border">|</span>
            <a href="{{ route('frontend.about') }}" class="text-text transition hover:text-secondary">About</a>
            @if (!empty($site['socials']))
                <span class="text-border">|</span>
                <span class="flex items-center gap-3">
                    @foreach ($site['socials'] as $network => $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($network) }}"
                           class="text-primary transition hover:text-secondary"><i class="fab fa-{{ $network }} text-xs"></i></a>
                    @endforeach
                </span>
            @endif
        </div>
    </div>
</div>

{{-- <div class="w-full border-y border-gray-200 bg-primary text-xs text-white lg:bg-white lg:text-text"> --}}
    {{-- <div class="mx-auto flex h-9 max-w-[1440px] items-center justify-center gap-4 px-4 lg:grid lg:h-10 lg:grid-cols-3 lg:justify-normal lg:px-7"> --}}

        {{-- Left: contact links --}}
        {{-- <div class="flex items-center gap-4 lg:gap-5">
            @if (($site['phone'] ?? null))
                <a href="{{ $site['phone_href'] }}" class="group flex items-center gap-1.5 text-white transition hover:text-white/80 lg:text-text lg:hover:text-secondary">
                    <i class="fas fa-phone-alt text-[10px] text-white transition group-hover:text-white/80 lg:text-primary lg:group-hover:text-secondary"></i>
                    <span>{{ $site['phone'] }}</span>
                </a>
            @endif
            @if (($site['email'] ?? null))
                <a href="mailto:{{ $site['email'] }}" class="group hidden items-center gap-1.5 text-text transition hover:text-secondary lg:flex">
                    <i class="fas fa-envelope text-[10px] text-primary transition group-hover:text-secondary"></i>
                    <span>{{ $site['email'] }}</span>
                </a>
            @endif
        </div> --}}

        {{-- Center: tagline (visible at all sizes) --}}
        {{-- <p class="text-center font-medium text-white/90 lg:text-muted">Quality stationery and office supplies in one place.</p> --}}

        {{-- Right: links + socials (desktop only) --}}
        {{-- <div class="hidden items-center justify-end gap-4 lg:flex">
            <a href="{{ route('frontend.track-order') }}" class="text-text transition hover:text-secondary">Track Order</a>
            <span class="text-border">|</span>
            <a href="{{ route('frontend.about') }}" class="text-text transition hover:text-secondary">About</a>
            @if (!empty($site['socials']))
                <span class="text-border">|</span>
                <span class="flex items-center gap-3">
                    @foreach ($site['socials'] as $network => $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($network) }}"
                           class="text-primary transition hover:text-secondary"><i class="fab fa-{{ $network }} text-xs"></i></a>
                    @endforeach
                </span>
            @endif
        </div> --}}
    {{-- </div>
</div> --}}