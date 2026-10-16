{{-- A single row at every breakpoint. Partners: 4 desktop columns; associations: 3.
     Native scrolling works without JavaScript. Alpine adds controls and homepage autoplay. --}}
@php
    $items = $items ?? collect();
    $isAssociation = ($variant ?? 'centered') === 'split';
    $seeAll = $seeAll ?? false;
    $isPage = $isPage ?? false;
    $headingTag = $isPage ? 'h1' : 'h2';
    $directoryRoute = $isAssociation ? 'frontend.associations' : 'frontend.partners';
    $description = $isAssociation
        ? 'Building stronger connections across our industry.'
        : 'Working together to bring quality to every project.';
@endphp
@if ($items->isNotEmpty() || $isPage)
<section class="trinity-network {{ !$isPage ? 'trinity-network--home' : '' }} {{ $isAssociation ? 'trinity-network--associations' : '' }}" aria-labelledby="{{ $id }}-heading"
    data-autoplay="{{ $isPage ? 'false' : 'true' }}"
    x-data="{
        canPrev: false, canNext: false,
        paused: false, touching: false, timer: null,
        init() {
            if (this.$el.dataset.autoplay !== 'true') return;
            this.timer = setInterval(() => {
                if (this.paused || this.touching || document.hidden || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                this.move(1);
            }, 3000);
        },
        destroy() { if (this.timer) clearInterval(this.timer); },
        update() {
            const rail = this.$refs.rail;
            if (!rail) return;
            this.canPrev = rail.scrollLeft > 4;
            this.canNext = rail.scrollLeft + rail.clientWidth &lt; rail.scrollWidth - 4;
        },
        move(direction) {
            const rail = this.$refs.rail;
            if (!rail || rail.scrollWidth &lt;= rail.clientWidth + 4) return;
            const card = rail.firstElementChild;
            if (!card) return;
            const step = card.getBoundingClientRect().width + (parseFloat(getComputedStyle(rail).columnGap) || 0);
            const behavior = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth';
            if (direction > 0 &amp;&amp; rail.scrollLeft + rail.clientWidth >= rail.scrollWidth - 8) {
                rail.scrollTo({ left: 0, behavior });
            } else {
                rail.scrollBy({ left: direction * step, behavior });
            }
        }
    }" x-init="$nextTick(() => update())" @resize.window.debounce.100ms="$nextTick(() => update())"
    @mouseenter="paused = true" @mouseleave="paused = $el.contains(document.activeElement)"
    @focusin="paused = true" @focusout="paused = $el.matches(':hover') || $el.contains($event.relatedTarget)"
    @touchstart.passive="touching = true" @touchend.passive="touching = false" @touchcancel.passive="touching = false">
    <div class="trinity-network__inner">
        <header class="trinity-network__header">
            <div class="trinity-network__intro">
                @if ($isPage)
                <span class="trinity-network__eyebrow">{{ $isAssociation ? 'Industry connections' : 'Stronger together' }}</span>
                @endif
                <{{ $headingTag }} id="{{ $id }}-heading" class="trinity-network__title">{{ $heading }}</{{ $headingTag }}>
                <p class="trinity-network__description">{{ $description }}</p>
            </div>
            @if ($items->isNotEmpty())
            <div class="trinity-network__actions">
                @if ($seeAll)
                    <a href="{{ route($directoryRoute) }}" class="trinity-network__link">View all {{ $isAssociation ? 'associations' : 'partners' }} <span aria-hidden="true">&rarr;</span></a>
                @endif
                <div class="trinity-network__controls" x-show="canPrev || canNext" style="display:none">
                    <button type="button" class="trinity-network__button" @click="move(-1)" :disabled="!canPrev" aria-controls="{{ $id }}-rail" aria-label="Previous {{ $isAssociation ? 'associations' : 'partners' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="m14 6-6 6 6 6"/></svg>
                    </button>
                    <button type="button" class="trinity-network__button" @click="move(1)" :disabled="!canNext" aria-controls="{{ $id }}-rail" aria-label="Next {{ $isAssociation ? 'associations' : 'partners' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="m10 6 6 6-6 6"/></svg>
                    </button>
                </div>
            </div>
            @endif
        </header>
        @if ($items->isNotEmpty())
            <div id="{{ $id }}-rail" class="trinity-network__rail" x-ref="rail" @scroll.passive="update()" tabindex="0" role="region" aria-labelledby="{{ $id }}-heading" @if ($isPage) aria-describedby="{{ $id }}-hint" @endif>
                @foreach ($items as $item)
                    @include('frontend.partials.partner-card', ['partner' => $item])
                @endforeach
            </div>
            @if ($isPage)
            <p id="{{ $id }}-hint" class="trinity-network__hint">Swipe or scroll to explore. Use the arrow keys when the row is focused.</p>
            @endif
        @else
            <p class="trinity-network__empty">Our {{ $isAssociation ? 'associations' : 'partners' }} will be featured here soon.</p>
        @endif
        @if ($isPage && method_exists($items, 'links'))
            <div class="trinity-network__pagination">{{ $items->links() }}</div>
        @endif
    </div>
</section>
@endif
