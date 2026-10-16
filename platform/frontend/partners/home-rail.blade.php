{{-- ---------------
     Home logo section: centered heading, borderless logos beneath it.
     Mobile: 2-row scroll rail (2 columns visible). Desktop: centered wrapping grid, 3 per row.
     The "See all" tile (when enabled) is the last item, i.e. at the end of the scroll / list.
     Variants ('variant' param):
       centered (default) - heading centered above borderless logos
       split              - heading on the left, logos on the right separated by thin cross lines (desktop)
     Usage: @include('frontend.partners.home-rail', ['items' => $partners, 'heading' => 'Our Partners',
            'id' => 'partners', 'seeAll' => true, 'bg' => 'bg-white', 'variant' => 'centered'])
--------------- --}}
@php
    $items  = $items ?? collect();
    $bg     = $bg ?? 'bg-white';
    $seeAll = $seeAll ?? false;
    $split  = ($variant ?? 'centered') === 'split';
    $total  = $items->count() + ($seeAll ? 1 : 0);
    $rows   = max(1, min(2, $total));
    $lastRowStart = intdiv($total - 1, 3) * 3; // first index of the final desktop row (3 per row)
    $cellClass = fn (int $i) => 'trinity-logo-cell' . ($i % 3 === 2 ? ' is-last-col' : '') . ($i >= $lastRowStart ? ' is-last-row' : '');
@endphp
@if ($items->isNotEmpty())
    <section class="{{ $bg }} py-12 sm:py-16" aria-labelledby="home-{{ $id }}-heading">
        <style>
            /* Mobile / tablet: 2-row rail, 2 columns visible (3 from sm), swipe sideways */
            .trinity-logo-rail { --visible:2; display:grid; grid-auto-flow:column; grid-auto-columns:calc(100% / var(--visible));
                grid-template-rows:repeat(var(--rows, 2), auto);
                overflow-x:auto; scroll-snap-type:x mandatory; scroll-behavior:smooth; scrollbar-width:none; }
            .trinity-logo-rail::-webkit-scrollbar { display:none; }
            @media (min-width:640px) { .trinity-logo-rail { --visible:3; } }
            .trinity-logo-cell { display:flex; align-items:center; justify-content:center; aspect-ratio:3/2; padding:12px; scroll-snap-align:start; min-width:0; }
            .trinity-logo-cell img { display:block; max-width:100%; max-height:100%; object-fit:contain; }
            .trinity-logo-more { flex-direction:column; gap:6px; text-align:center; font-weight:600; color:var(--color-primary, #b91c1c); text-decoration:none; }
            .trinity-logo-more:hover { text-decoration:underline; }
            /* Desktop: centered wrapping grid, 3 per row, last row centered */
            @media (min-width:1024px) {
                .trinity-logo-rail { display:flex; flex-wrap:wrap; justify-content:center; overflow:visible; }
                .trinity-logo-cell { flex:0 0 33.3333%; aspect-ratio:auto; height:120px; padding:24px 32px; }
                /* Split variant: left-aligned grid with thin lines between logos only (no outer border) */
                .trinity-split .trinity-logo-rail { justify-content:flex-start; }
                .trinity-split .trinity-logo-cell { border-right:1px solid #e5e7eb; border-bottom:1px solid #e5e7eb; }
                .trinity-split .trinity-logo-cell.is-last-col { border-right:0; }
                .trinity-split .trinity-logo-cell.is-last-row { border-bottom:0; }
            }
        </style>
        <div x-data="{
                canPrev: false, canNext: false,
                update() { const r = this.$refs.rail; this.canPrev = r.scrollLeft > 4; this.canNext = r.scrollLeft + r.clientWidth < r.scrollWidth - 4; },
                move(dir) { const r = this.$refs.rail; const c = r.firstElementChild; r.scrollBy({ left: dir * (c ? c.offsetWidth : r.clientWidth), behavior: 'smooth' }); }
            }" x-init="$nextTick(() => update())" @resize.window="update()"
            class="mx-auto px-4 sm:px-6 lg:px-8 {{ $split ? 'trinity-split max-w-7xl lg:grid lg:grid-cols-[minmax(0,1fr)_minmax(0,2fr)] lg:items-center lg:gap-14' : 'max-w-4xl' }}">
            <h2 id="home-{{ $id }}-heading" class="text-3xl font-extrabold text-primary sm:text-4xl {{ $split ? 'mb-6 lg:mb-0' : 'mb-8 text-center' }}">{{ $heading }}</h2>
            <div class="relative min-w-0">
                <button type="button" @click="move(-1)" x-show="canPrev" style="display:none" aria-label="Previous {{ strtolower($heading) }}"
                    class="absolute left-0 top-1/2 z-10 hidden h-10 w-10 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white shadow-md hover:border-primary hover:text-primary sm:flex lg:hidden"><i class="fas fa-chevron-left" aria-hidden="true"></i></button>
                <div x-ref="rail" @scroll.passive="update()" tabindex="0" aria-label="{{ $heading }}, swipe or scroll horizontally"
                    class="trinity-logo-rail" style="--rows:{{ $rows }};">
                    @foreach ($items as $item)
                        <div class="{{ $cellClass($loop->index) }}"><img src="{{ asset($item->image) }}" alt="{{ $item->name }}" loading="lazy"></div>
                    @endforeach
                    @if ($seeAll)
                        <a href="{{ route('frontend.partners') }}" class="{{ $cellClass($items->count()) }} trinity-logo-more">
                            <span class="text-sm sm:text-base">See all</span><i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>
                <button type="button" @click="move(1)" x-show="canNext" style="display:none" aria-label="Next {{ strtolower($heading) }}"
                    class="absolute right-0 top-1/2 z-10 hidden h-10 w-10 translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white shadow-md hover:border-primary hover:text-primary sm:flex lg:hidden"><i class="fas fa-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </section>
@endif