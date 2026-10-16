{{-- --------------- --}}
{{-- One heading + multi-row manual snap rail (same controls as the category rails) --}}
{{-- --------------- --}}
{{-- --------------- --}}
{{-- Rows: capped by the number of images so no empty rows are left --}}
{{-- --------------- --}}
@php
    $rowsMobile  = min($mobileRows ?? 2, $items->count());
    $rowsDesktop = min(2, $items->count());
@endphp
<div class="trinity-rail {{ !empty($firstOnMobile) ? 'trinity-rail--first-mobile' : '' }}" role="group" aria-labelledby="home-{{ $id }}-heading"
     x-data="{
         canPrev: false,
         canNext: false,
         update() {
             const rail = this.$refs.rail;
             this.canPrev = rail.scrollLeft > 4;
             this.canNext = rail.scrollLeft + rail.clientWidth < rail.scrollWidth - 4;
         },
         move(dir) {
             const rail = this.$refs.rail;
             const item = rail.firstElementChild;
             const step = item ? item.offsetWidth + (parseFloat(getComputedStyle(rail).columnGap) || 16) : rail.clientWidth;
             rail.scrollBy({ left: dir * step, behavior: 'smooth' });
         }
     }"
     x-init="$nextTick(() => update())"
     @resize.window="update()">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <h2 id="home-{{ $id }}-heading" class="text-2xl font-semibold text-primary sm:text-3xl">{{ $heading }}</h2>
        @if(!empty($seeAll))
            <a href="{{ route('frontend.partners') }}" class="text-sm font-semibold text-primary hover:underline">See all <span aria-hidden="true">&rarr;</span></a>
        @endif
    </div>
    <div class="relative">
        <button type="button" @click="move(-1)" x-show="canPrev" style="display:none" aria-label="Previous {{ strtolower($heading) }}"
            class="absolute left-0 top-1/2 z-10 hidden sm:flex h-10 w-10 -translate-x-1/3 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white shadow-md hover:border-primary hover:text-primary"><i
                class="fas fa-chevron-left" aria-hidden="true"></i></button>
        <div x-ref="rail" @scroll.passive="update()" tabindex="0" aria-label="{{ $heading }}, swipe or scroll horizontally"
            class="trinity-rail-scroller trinity-rail--{{ $mode }} trinity-rows-m{{ $rowsMobile }} trinity-rows-d{{ $rowsDesktop }}">
            @foreach($items as $item)
                <div class="trinity-rail-item">@include('frontend.partials.partner-card', ['partner' => $item])</div>
            @endforeach
        </div>
        <button type="button" @click="move(1)" x-show="canNext" style="display:none" aria-label="Next {{ strtolower($heading) }}"
            class="absolute right-0 top-1/2 z-10 hidden sm:flex h-10 w-10 translate-x-1/3 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white shadow-md hover:border-primary hover:text-primary"><i
                class="fas fa-chevron-right" aria-hidden="true"></i></button>
    </div>
</div>