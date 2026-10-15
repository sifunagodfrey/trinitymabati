<section class="py-12 sm:py-16" aria-labelledby="home-partners-heading">
    <style>
        .trinity-partners-window { overflow:hidden; }
        .trinity-partners-track { display:flex; width:100%; animation:trinity-partners-left 40s linear infinite; }
        .trinity-partners-group { display:flex; flex:0 0 auto; min-width:100%; align-items:center; justify-content:space-around; gap:24px; padding-right:24px; box-sizing:border-box; }
        .trinity-partners-item { flex:0 0 180px; width:180px; }
        @media(min-width:640px) { .trinity-partners-item { flex-basis:240px; width:240px; } }
        .trinity-partners-window:hover .trinity-partners-track,.trinity-partners-window:focus-within .trinity-partners-track { animation-play-state:paused; }
        @keyframes trinity-partners-left { from { transform:translateX(0); } to { transform:translateX(calc(-1 * var(--partner-cycle-width, 100%))); } }
        @media(prefers-reduced-motion:reduce) { .trinity-partners-track { animation:none; } .trinity-partners-window { overflow-x:auto; } .trinity-partners-group[aria-hidden] { display:none; } }
    </style>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" x-data="{ observer:null, measure() { const width=this.$refs.partnerGroup.getBoundingClientRect().width; this.$refs.partnerTrack.style.setProperty('--partner-cycle-width', width+'px'); }, init() { this.$nextTick(() => { this.measure(); this.observer=new ResizeObserver(() => this.measure()); this.observer.observe(this.$refs.partnerGroup); }); }, destroy() { this.observer?.disconnect(); } }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4"><h2 id="home-partners-heading" class="text-2xl font-semibold text-primary sm:text-3xl">Our Partners</h2><div class="flex items-center gap-4"><a href="{{ route('frontend.partners') }}" class="text-sm font-semibold text-primary hover:underline">See all <span aria-hidden="true">→</span></a></div></div>
        <div class="trinity-partners-window" tabindex="0" aria-label="Our partners, images move from right to left">
            <div class="trinity-partners-track" x-ref="partnerTrack">
                <div class="trinity-partners-group" x-ref="partnerGroup">@foreach($partners as $partner)<div class="trinity-partners-item">@include('frontend.partials.partner-card', ['partner' => $partner])</div>@endforeach</div>
                <div class="trinity-partners-group" aria-hidden="true">@foreach($partners as $partner)<div class="trinity-partners-item">@include('frontend.partials.partner-card', ['partner' => $partner, 'duplicate' => true])</div>@endforeach</div>
            </div>
        </div>
    </div>
</section>
