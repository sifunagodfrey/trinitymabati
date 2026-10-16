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
        /* Layout: 3:1 columns on desktop, stacked on mobile (associations first) */
        /* --------------- */
        .trinity-rail-split { display:grid; gap:40px; }
        @media(min-width:1024px) { .trinity-rail-split { grid-template-columns:minmax(0,3fr) minmax(0,1fr); gap:32px; } }
        .trinity-rail { min-width:0; }
        .trinity-rail--first-mobile { order:-1; }
        @media(min-width:1024px) { .trinity-rail--first-mobile { order:0; } }

        /* --------------- */
        /* Multi-row snap rail, images visible per view */
        /* --------------- */
        .trinity-rail-scroller {
            --rail-gap:16px; --rail-visible:2;
            display:grid; grid-auto-flow:column; gap:var(--rail-gap);
            grid-auto-columns:calc((100% - (var(--rail-visible) - 1) * var(--rail-gap)) / var(--rail-visible));
            overflow-x:auto; padding-bottom:16px;
            scroll-snap-type:x mandatory; scroll-behavior:smooth; scrollbar-width:none;
        }
        .trinity-rail-scroller::-webkit-scrollbar { display:none; }
        .trinity-rail-item { min-width:0; scroll-snap-align:start; }
        @media(min-width:640px) { .trinity-rail--wide, .trinity-rail--left { --rail-visible:3; } }
        @media(min-width:1024px) { .trinity-rail--wide { --rail-visible:5; } .trinity-rail--right { --rail-visible:1; } }

        /* --------------- */
        /* Rows per rail: mobile value first, desktop (lg+) value overrides */
        /* --------------- */
        .trinity-rows-m1 { grid-template-rows:repeat(1, auto); }
        .trinity-rows-m2 { grid-template-rows:repeat(2, auto); }
        .trinity-rows-m3 { grid-template-rows:repeat(3, auto); }
        @media(min-width:1024px) {
            .trinity-rows-d1 { grid-template-rows:repeat(1, auto); }
            .trinity-rows-d2 { grid-template-rows:repeat(2, auto); }
        }
    </style>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="{{ $split ? 'trinity-rail-split' : '' }}">
            @if($partners->isNotEmpty())
                @include('frontend.partners.rail', ['items' => $partners, 'heading' => 'Our Partners', 'id' => 'partners', 'mode' => $split ? 'left' : 'wide', 'seeAll' => true, 'mobileRows' => 3])
            @endif
            @if($associations->isNotEmpty())
                @include('frontend.partners.rail', ['items' => $associations, 'heading' => 'Our Associations', 'id' => 'associations', 'mode' => $split ? 'right' : 'wide', 'seeAll' => false, 'firstOnMobile' => $split, 'mobileRows' => 1])
            @endif
        </div>
    </div>
</section>