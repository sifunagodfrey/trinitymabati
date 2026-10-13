{{-- -------------------
     Floating WhatsApp Button
     Links out to WhatsApp using the configured number. Hidden when no
     number is set. Sits clear of the mobile bottom nav.
------------------- --}}
@if (($site['whatsapp_url'] ?? null))
    <a href="{{ $site['whatsapp_url'] }}" target="_blank" rel="noopener"
       aria-label="Chat with us on WhatsApp"
       class="fixed right-5 z-40 flex items-center gap-2 group"
       style="bottom: calc(1.25rem + env(safe-area-inset-bottom));">
        <span class="hidden sm:inline-block bg-white text-text text-sm font-semibold px-4 py-2 rounded-[12px] shadow-lg border border-border whitespace-nowrap"
              style="font-family: var(--font-ui);">
            Chat with us
        </span>
        <span class="w-14 h-14 rounded-[12px] flex items-center justify-center shadow-xl transition group-hover:scale-105"
              style="background-color: #25D366;">
            <i class="fab fa-whatsapp text-white text-2xl"></i>
        </span>
    </a>
@endif
