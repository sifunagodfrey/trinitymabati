{{-- --------------- --}}
{{-- Home: Partners (left, larger) + Associations (right) --}}
{{-- --------------- --}}
@php
    $partners     = $partners ?? collect();
    $associations = $associations ?? collect();
    $split        = $partners->isNotEmpty() && $associations->isNotEmpty();
@endphp
<section class="py-12 sm:py-16">
    <style>
        /* --------------- */
        /* Layout: 3:1 columns on desktop, stacked on mobile */
        /* --------------- */
        .trinity-rail-split { display:grid; gap:40px; }
        @media(min-width:1024px) { .trinity-rail-split { grid-template-columns:minmax(0,3fr) minmax(0,1fr); gap:32px; } }
        .trinity-rail { min-width:0; }

        /* --------------- */
        /* Images visible per view (same 16px gap as the category rails) */
        /* --------------- */
        .trinity-rail-scroller { --rail-gap:16px; --rail-visible:2; }
        @media(min-width:640px) { .trinity-rail--wide, .trinity-rail--left { --rail-visible:3; } }
        @media(min-width:1024px) { .trinity-rail--wide { --rail-visible:5; } .trinity-rail--right { --rail-visible:1; } }
        .trinity-rail-item { flex:0 0 calc((100% - (var(--rail-visible) - 1) * var(--rail-gap)) / var(--rail-visible)); min-width:0; }
    </style>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="{{ $split ? 'trinity-rail-split' : '' }}">
            @if($partners->isNotEmpty())
                @include('frontend.partners.rail', ['items' => $partners, 'heading' => 'Our Partners', 'id' => 'partners', 'mode' => $split ? 'left' : 'wide', 'seeAll' => true])
            @endif
            @if($associations->isNotEmpty())
                @include('frontend.partners.rail', ['items' => $associations, 'heading' => 'Our Associations', 'id' => 'associations', 'mode' => $split ? 'right' : 'wide', 'seeAll' => false])
            @endif
        </div>
    </div>
</section>