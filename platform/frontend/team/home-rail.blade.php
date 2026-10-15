<section class="py-14 sm:py-16" aria-labelledby="home-team-heading" x-data="{ move(direction) { this.$refs.teamRail.scrollBy({ left: direction * this.$refs.teamRail.clientWidth * 0.8, behavior: 'smooth' }); } }">
    <style>
        .trinity-team-rail { display:flex; gap:12px; overflow-x:auto; padding-bottom:16px; scroll-snap-type:x mandatory; scroll-behavior:smooth; scrollbar-width:none; }
        .trinity-team-rail::-webkit-scrollbar { display:none; }
        .trinity-team-rail-item { flex:0 0 calc((100% - 12px) / 2); min-width:0; scroll-snap-align:start; }
        @media(min-width:640px) { .trinity-team-rail { gap:16px; } .trinity-team-rail-item { flex-basis:calc((100% - 48px) / 3.5); } }
        @media(min-width:1024px) { .trinity-team-rail-item { flex-basis:calc((100% - 64px) / 4.5); } }
    </style>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between gap-4"><h2 id="home-team-heading" class="text-2xl font-semibold text-primary sm:text-3xl">Our Team</h2><a href="{{ route('frontend.team') }}" class="shrink-0 text-sm font-semibold text-primary hover:underline">See all <span aria-hidden="true">→</span><span class="sr-only"> team members</span></a></div>
        <div class="relative">
            <button type="button" @click="move(-1)" aria-label="Previous team members" class="absolute -left-3 top-1/2 z-10 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-primary shadow-md"><i class="fas fa-chevron-left" aria-hidden="true"></i></button>
            <div class="trinity-team-rail" x-ref="teamRail" tabindex="0" aria-label="Our team, scroll horizontally">
                @foreach($members as $member)<div class="trinity-team-rail-item">@include('frontend.partials.team-card', ['member' => $member])</div>@endforeach
            </div>
            <button type="button" @click="move(1)" aria-label="Next team members" class="absolute -right-3 top-1/2 z-10 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-primary shadow-md"><i class="fas fa-chevron-right" aria-hidden="true"></i></button>
        </div>
    </div>
</section>
