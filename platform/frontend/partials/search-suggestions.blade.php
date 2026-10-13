<div x-show="sugOpen" x-cloak class="absolute left-0 right-0 top-full z-[200] mt-2 overflow-hidden rounded-[8px] border border-border bg-white shadow-xl">
    <template x-for="item in results" :key="item.id">
        <a :href="'{{ url('products') }}/' + item.slug" class="group flex items-center gap-3 px-4 py-2.5 transition hover:bg-primary-light">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-[8px] bg-background">
                <img x-show="item.thumb" :src="item.thumb" :alt="item.name" class="h-full w-full object-cover"><i x-show="!item.thumb" class="fas fa-box-open text-xs text-muted"></i>
            </span>
            <span class="min-w-0 flex-1"><span class="block truncate text-sm font-medium text-text" x-text="item.name"></span><span class="block truncate text-xs text-muted" x-text="item.category"></span></span>
            <span class="shrink-0 text-xs font-semibold text-primary" x-text="item.price_display"></span>
        </a>
    </template>
    <a :href="'{{ route('frontend.search') }}?q=' + encodeURIComponent(q)" class="flex items-center gap-2 border-t border-border px-4 py-3 text-xs font-semibold text-primary hover:bg-primary-light"><i class="fas fa-search"></i>See all results for “<span x-text="q"></span>”</a>
</div>
