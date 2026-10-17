{{-- Shared WhatsApp contact panel. Uses the existing configured site WhatsApp URL. --}}
@if ($site['whatsapp_url'] ?? null)
@once
<style>
    .trinity-chat { position:fixed; right:20px; bottom:calc(20px + env(safe-area-inset-bottom, 0px)); z-index:45; font-family:var(--font-ui, sans-serif); color:#25312c; }
    .trinity-chat *, .trinity-chat *::before, .trinity-chat *::after { box-sizing:border-box; }
    .trinity-chat button, .trinity-chat a { -webkit-tap-highlight-color:transparent; }
    .trinity-chat__launch-row { display:flex; align-items:center; gap:12px; }
    .trinity-chat__label { padding:10px 14px; border:1px solid #e3ece6; border-radius:4px; background:rgba(255,255,255,.85); color:#25312c; box-shadow:0 3px 12px #132c2414; white-space:nowrap; cursor:pointer; font:400 14px/1.4 var(--font-ui, sans-serif); }
    .trinity-chat__launcher { display:grid; place-items:center; width:56px; height:56px; padding:0; border:0; border-radius:50%; background:#25d366; color:#fff; box-shadow:0 5px 20px #075e5433; cursor:pointer; }
    .trinity-chat__orb { display:grid; place-items:center; width:56px; height:56px; border-radius:50%; background:#25d366; animation:trinity-chat-glow 2.6s ease-in-out infinite; }
    .trinity-chat svg { display:block; width:26px; height:26px; flex-shrink:0; }
    .trinity-chat__panel { position:absolute; right:0; bottom:70px; width:350px; max-width:calc(100vw - 32px); max-height:calc(100dvh - 118px - env(safe-area-inset-bottom, 0px)); overflow-y:auto; background:#fff; border:1px solid #e6ece8; border-radius:8px; box-shadow:0 14px 45px #132c2429; }
    .trinity-chat__header { display:flex; align-items:flex-start; gap:12px; padding:22px 18px; background:#128c46; color:#fff; }
    .trinity-chat__header > svg { margin-top:2px; width:30px; height:30px; }
    .trinity-chat__heading { margin:0; color:#fff; font:600 17px/1.4 var(--font-heading, sans-serif); }
    .trinity-chat__message { margin:5px 0 0; color:#ffffffeb; font-size:13px; line-height:1.6; }
    .trinity-chat__close { display:grid; place-items:center; flex-shrink:0; width:32px; height:32px; margin:-6px -7px 0 auto; border:0; border-radius:4px; background:transparent; color:#fff; cursor:pointer; }
    .trinity-chat__close svg { width:20px; height:20px; }
    .trinity-chat__body { padding:18px; }
    .trinity-chat__note { margin:0 0 12px; font-size:12px; line-height:1.6; color:#66756c; }
    .trinity-chat__contact { display:flex; align-items:center; gap:12px; padding:14px; border:1px solid #e3ece6; border-left:3px solid #25d366; border-radius:4px; background:#f5f8f6; color:#25312c; text-decoration:none; transition:background .15s; }
    .trinity-chat__contact:hover { background:#eaf6ee; }
    .trinity-chat__avatar { display:grid; place-items:center; flex-shrink:0; width:44px; height:44px; border-radius:50%; background:#25d366; color:#fff; }
    .trinity-chat__name { display:block; font-size:14px; font-weight:600; line-height:1.5; }
    .trinity-chat__action { display:block; margin-top:2px; font-size:12px; line-height:1.5; color:#596b60; }
    .trinity-chat__arrow { margin-left:auto; color:#128c46; font-size:21px; }
    .trinity-chat :is(button,a):focus-visible { outline:3px solid #064e3b; outline-offset:3px; }
    .trinity-chat__close:focus-visible { outline-color:#fff; outline-offset:0; }
    @keyframes trinity-chat-glow { 0%,100% { box-shadow:0 0 0 0 #25d36600; } 50% { box-shadow:0 0 0 7px #25d36630,0 0 18px #25d36670; } }
    @media (max-width:639px) { .trinity-chat { right:16px; bottom:calc(16px + env(safe-area-inset-bottom, 0px)); } }
    @media (prefers-reduced-motion:reduce) { .trinity-chat__orb { animation:none; } .trinity-chat * { transition:none !important; } }
</style>
<div class="trinity-chat"
    x-data="{
        open: false,
        show() { this.open = true; this.$nextTick(() => this.$refs.close.focus()); },
        close(restoreFocus = true) { this.open = false; if (restoreFocus) this.$refs.launcher.focus(); }
    }"
    @click.outside="if (open) close(false)"
    @keydown.escape.window="if (open) { $event.preventDefault(); close(); }">
    <section id="trinity-whatsapp-panel" class="trinity-chat__panel" role="dialog" aria-labelledby="trinity-whatsapp-title" aria-describedby="trinity-whatsapp-message"
        x-show="open" x-transition.opacity.duration.150ms style="display:none">
        <header class="trinity-chat__header">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.5 3.5A11.8 11.8 0 0 0 12.1 0C5.5 0 .1 5.4.1 12c0 2.1.5 4.2 1.6 6L0 24l6.2-1.6a12 12 0 0 0 5.9 1.5h.1C18.7 23.9 24 18.5 24 12c0-3.2-1.2-6.2-3.5-8.5ZM12.1 21.9a9.9 9.9 0 0 1-5-1.4l-.4-.2-3.7 1 1-3.6-.3-.4a10 10 0 1 1 8.4 4.6Zm5.5-7.5c-.3-.1-1.8-.9-2.1-1s-.5-.1-.7.2-.8 1-.9 1.2-.3.2-.6.1a8.1 8.1 0 0 1-4-3.5c-.3-.5.3-.5.9-1.7.1-.2 0-.4 0-.6L9.2 6.9c-.3-.6-.5-.5-.7-.5H8c-.2 0-.5.1-.8.4s-1 1-1 2.4 1 2.8 1.2 3 2.1 3.3 5.1 4.6c1.9.8 2.6.9 3.6.8.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4s-.4-.2-.7-.4Z"/></svg>
            <div>
                <h2 id="trinity-whatsapp-title" class="trinity-chat__heading">Chat with Trinity</h2>
                <p id="trinity-whatsapp-message" class="trinity-chat__message">Roofing questions? We’re here to help.</p>
            </div>
            <button x-ref="close" type="button" class="trinity-chat__close" @click="close()" aria-label="Close WhatsApp chat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </header>
        <div class="trinity-chat__body">
            <p class="trinity-chat__note">Talk to our sales team.</p>
            <a class="trinity-chat__contact" href="{{ $site['whatsapp_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Chat with Trinity Sales on WhatsApp (opens in a new tab)">
                <span class="trinity-chat__avatar" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7 3h3l1.5 5-2 1.5a14 14 0 0 0 5 5L16 12.5l5 1.5v3a4 4 0 0 1-4 4A18 18 0 0 1 3 7a4 4 0 0 1 4-4Z"/></svg>
                </span>
                <span><span class="trinity-chat__name">Trinity Sales</span><span class="trinity-chat__action">Start on WhatsApp</span></span>
                <span class="trinity-chat__arrow" aria-hidden="true">↗</span>
            </a>
        </div>
    </section>
    <div class="trinity-chat__launch-row">
        <button type="button" class="trinity-chat__label" @click="show()" :aria-expanded="open.toString()" aria-expanded="false" aria-controls="trinity-whatsapp-panel" aria-haspopup="dialog">Let’s Chat</button>
    <button x-ref="launcher" type="button" class="trinity-chat__launcher" @click="open ? close() : show()" :aria-expanded="open.toString()" aria-expanded="false" aria-controls="trinity-whatsapp-panel" aria-haspopup="dialog" aria-label="Open WhatsApp chat">
        <span class="trinity-chat__orb" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11.8 11.8 0 0 0 12.1 0C5.5 0 .1 5.4.1 12c0 2.1.5 4.2 1.6 6L0 24l6.2-1.6a12 12 0 0 0 5.9 1.5h.1C18.7 23.9 24 18.5 24 12c0-3.2-1.2-6.2-3.5-8.5ZM12.1 21.9a9.9 9.9 0 0 1-5-1.4l-.4-.2-3.7 1 1-3.6-.3-.4a10 10 0 1 1 8.4 4.6Zm5.5-7.5c-.3-.1-1.8-.9-2.1-1s-.5-.1-.7.2-.8 1-.9 1.2-.3.2-.6.1a8.1 8.1 0 0 1-4-3.5c-.3-.5.3-.5.9-1.7.1-.2 0-.4 0-.6L9.2 6.9c-.3-.6-.5-.5-.7-.5H8c-.2 0-.5.1-.8.4s-1 1-1 2.4 1 2.8 1.2 3 2.1 3.3 5.1 4.6c1.9.8 2.6.9 3.6.8.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4s-.4-.2-.7-.4Z"/></svg>
        </span>
    </button>
    </div>
</div>
@endonce
@endif
