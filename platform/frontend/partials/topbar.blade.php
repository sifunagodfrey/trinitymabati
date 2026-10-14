@php
    $nairobiPhone = trim((string) \App\Models\Core\Setting::get('branch_nairobi_phone', ''));
    $migoriPhone = trim((string) \App\Models\Core\Setting::get('branch_migori_phone', ''));
    $supportEmail = trim((string) \App\Models\Core\Setting::get('contact_email', ''));
    $topSocials = collect($site['socials'] ?? [])
        ->filter()
        ->take(4);
@endphp

<div class="w-full bg-primary text-white">
    <div class="mx-auto flex min-h-10 max-w-7xl items-center justify-between gap-4 px-4 py-2 text-[13px] font-medium sm:px-6 sm:text-sm lg:px-8"
        style="font-weight: 500;">
        <div class="flex w-full min-w-0 items-center justify-between gap-x-2 gap-y-2 sm:w-auto sm:flex-wrap sm:justify-start sm:gap-x-5">
            @if ($nairobiPhone !== '')
                <a href="tel:{{ preg_replace('/[^+0-9]/', '', $nairobiPhone) }}"
                    class="inline-flex items-center gap-2 whitespace-nowrap hover:text-white/80"
                    aria-label="Call Nairobi outlet">
                    <i class="fas fa-phone-alt fa-flip-horizontal text-xs sm:text-sm" aria-hidden="true"></i>
                    <span>{{ $nairobiPhone }}</span>
                </a>
            @endif

            @if ($migoriPhone !== '')
                @if ($nairobiPhone !== '')
                    <span class="hidden text-white/60 sm:inline" aria-hidden="true">|</span>
                @endif
                <a href="tel:{{ preg_replace('/[^+0-9]/', '', $migoriPhone) }}"
                    class="ml-auto inline-flex items-center gap-2 whitespace-nowrap hover:text-white/80 sm:ml-0"
                    aria-label="Call Migori outlet">
                    <i class="fas fa-phone-alt fa-flip-horizontal text-xs sm:text-sm" aria-hidden="true"></i>
                    <span>{{ $migoriPhone }}</span>
                </a>
            @endif

            @if ($supportEmail !== '')
                @if ($nairobiPhone !== '' || $migoriPhone !== '')
                    <span class="hidden text-white/60 sm:inline" aria-hidden="true">|</span>
                @endif
                <a href="mailto:{{ $supportEmail }}"
                    class="hidden items-center gap-2 hover:text-white/80 sm:inline-flex">
                    <i class="fas fa-envelope text-xs sm:text-sm" aria-hidden="true"></i>
                    <span class="whitespace-nowrap">{{ $supportEmail }}</span>
                </a>
            @endif
        </div>

        @if ($topSocials->isNotEmpty())
            <div class="hidden shrink-0 items-center gap-4 md:flex" aria-label="Social media">
                @foreach ($topSocials as $network => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                        class="text-white transition hover:text-white/70" aria-label="{{ ucfirst($network) }}">
                        <i class="fab fa-{{ $network }} text-sm" aria-hidden="true"></i>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
