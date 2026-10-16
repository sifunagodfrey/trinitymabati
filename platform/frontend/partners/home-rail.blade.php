{{-- ---------------
     Home logo section: title on the left, logos in a bordered 2-row scroll rail on the right.
     The "See all" tile (when enabled) is the last cell, so it sits at the end of the scroll.
     Usage: @include('frontend.partners.home-rail', ['items' => $partners, 'heading' => 'Our Partners',
            'id' => 'partners', 'seeAll' => true, 'bg' => 'bg-white'])
--------------- --}}
@php
    $items  = $items ?? collect();
    $bg     = $bg ?? 'bg-white';
    $seeAll = $seeAll ?? false;
    $rows   = max(1, min(2, $items->count() + ($seeAll ? 1 : 0)));
@endphp
@if ($items->isNotEmpty())
    <section class="{{ $bg }} py-12 sm:py-16" aria-labelledby="home-{{ $id }}-heading">
        <style>
            /* Rail: 2 rows, columns flow left to right; 2 columns visible on mobile, 3 from sm up */
            .trinity-logo-rail { --visible:2; display:grid; grid-auto-flow:column; grid-auto-columns:calc(100% / var(--visible));
                overflow-x:auto; scroll-snap-type:x mandatory; scroll-behavior:smooth; scrollbar-width:none;
                border-top:1px solid #e5e7eb; border-left:1px solid #e5e7eb; }
            .trinity-logo-rail::-webkit-scrollbar { display:none; }
            @media (min-width:640px) { .trinity-logo-rail { --visible:3; } }
            .trinity-logo-cell { display:flex; align-items:center; justify-content:center; aspect-ratio:3/2; padding:14px; scroll-snap-align:start;
                border-right:1px solid #e5e7eb; border-bottom:1px solid #e5e7eb; background:#fff; min-width:0; }
            .trinity-logo-cell img { display:block; max-width:100%; max-height:100%; object-fit:contain; }
            @media (min-width:1024px) { .trinity-logo-cell { padding:20px; } }
            .trinity-logo-more { flex-direction:column; gap:6px; text-align:center; font-weight:700; color:var(--color-primary, #b91c1c); text-decoration:none; background:#fef2f2; }
            .trinity-logo-more:hover { background:#fee2e2; }
        </style>
        <div x-data="{
                canPrev: false, canNext: false,
                update() { const r = this.$refs.rail; this.canPrev = r.scrollLeft > 4; this.canNext = r.scrollLeft + r.clientWidth < r.scrollWidth - 4; },
                move(dir) { const r = this.$refs.rail; const c = r.firstElementChild; r.scrollBy({ left: dir * (c ? c.offsetWidth : r.clientWidth), behavior: 'smooth' }); }
            }" x-init="$nextTick(() => update())" @resize.window="update()"
            class="mx-auto grid max-w-7xl items-center gap-8 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_minmax(0,2fr)] lg:gap-14 lg:px-8">
            <h2 id="home-{{ $id }}-heading" class="text-3xl font-extrabold text-primary sm:text-4xl">{{ $heading }}</h2>
            <div class="relative min-w-0">
                <button type="button" @click="move(-1)" x-show="canPrev" style="display:none" aria-label="Previous {{ strtolower($heading) }}"
                    class="absolute left-0 top-1/2 z-10 hidden h-10 w-10 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white shadow-md hover:border-primary hover:text-primary sm:flex"><i class="fas fa-chevron-left" aria-hidden="true"></i></button>
                <div x-ref="rail" @scroll.passive="update()" tabindex="0" aria-label="{{ $heading }}, swipe or scroll horizontally"
                    class="trinity-logo-rail" style="grid-template-rows:repeat({{ $rows }}, auto);">
                    @foreach ($items as $item)
                        <div class="trinity-logo-cell"><img src="{{ asset($item->image) }}" alt="{{ $item->name }}" loading="lazy"></div>
                    @endforeach
                    @if ($seeAll)
                        <a href="{{ route('frontend.partners') }}" class="trinity-logo-cell trinity-logo-more">
                            <span class="text-sm sm:text-base">See all</span><i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>
                <button type="button" @click="move(1)" x-show="canNext" style="display:none" aria-label="Next {{ strtolower($heading) }}"
                    class="absolute right-0 top-1/2 z-10 hidden h-10 w-10 translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white shadow-md hover:border-primary hover:text-primary sm:flex"><i class="fas fa-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </section>
@endif
