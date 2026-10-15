@extends('frontend.layouts.app')
@section('title', 'Project Gallery | Trinity Mabati Factory')
@section('meta_description', 'Explore roofing projects from Trinity Mabati Factory.')
@section('content')
<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-16 lg:px-8" x-data="{
    galleries: [], galleryIndex: 0, photos: [], photoIndex: 0, projectTitle: '', previousFocus: null, previousOverflow: '',
    selectGallery(index) { const gallery = this.galleries[index]; if (!gallery) return; this.galleryIndex = index; this.photos = [...gallery.photos]; this.photoIndex = 0; this.projectTitle = gallery.title; },
    openGallery(trigger) { this.galleries = Array.from(this.$root.querySelectorAll('[data-project-gallery]')).map(button => ({ id: button.dataset.projectGallery, title: button.dataset.title, photos: JSON.parse(button.dataset.gallery || '[]') })).filter(gallery => gallery.photos.length); const index = this.galleries.findIndex(gallery => gallery.id === trigger.dataset.projectGallery); if (index < 0) return; this.selectGallery(index); this.previousFocus = trigger; this.previousOverflow = document.body.style.overflow; this.$refs.galleryDialog.showModal(); document.body.style.overflow = 'hidden'; },
    step(direction) { if (this.galleries.length > 1) this.selectGallery((this.galleryIndex + direction + this.galleries.length) % this.galleries.length); },
    closeGallery() { this.$refs.galleryDialog.close(); },
    finishClose() { document.body.style.overflow = this.previousOverflow; this.previousFocus?.focus(); },
    destroy() { if (this.$refs.galleryDialog.open) { this.$refs.galleryDialog.close(); document.body.style.overflow = this.previousOverflow; } }
}">
    <header class="mb-8 text-center"><h1 class="text-3xl font-semibold text-primary sm:text-4xl">Project Gallery</h1><p class="mt-3 text-sm text-gray-600">Latest projects we have worked on.</p></header>
    @if($showFilters)
    <form method="GET" action="{{ route('frontend.project-gallery') }}" class="mb-8 grid gap-4 rounded-xl border border-gray-200 bg-white p-4 sm:grid-cols-2 sm:p-5 lg:grid-cols-4">
        <div><label for="gallery-search" class="mb-2 block text-sm font-semibold text-gray-700">Search projects</label><input id="gallery-search" name="q" value="{{ $filters['q'] ?? '' }}" maxlength="160" placeholder="Search by project name" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
        <div><label for="gallery-profile" class="mb-2 block text-sm font-semibold text-gray-700">Roofing profile</label><select id="gallery-profile" name="profile" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-primary"><option value="">All profiles</option>@foreach($profiles as $profile)<option value="{{ $profile }}" @selected(($filters['profile'] ?? '') === $profile)>{{ $profile }}</option>@endforeach</select></div>
        <div><label for="gallery-location" class="mb-2 block text-sm font-semibold text-gray-700">Location</label><select id="gallery-location" name="location" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-primary"><option value="">All locations</option>@foreach($locations as $location)<option value="{{ $location }}" @selected(($filters['location'] ?? '') === $location)>{{ $location }}</option>@endforeach</select></div>
        <div class="flex items-end gap-3"><button type="submit" class="flex-1 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:opacity-90">Filter projects</button><a href="{{ route('frontend.project-gallery') }}" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-600 hover:text-primary">Reset</a></div>
    </form>
    @endif
    <style>
        .trinity-gallery-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; }
        @media(min-width:640px) { .trinity-gallery-grid { grid-template-columns:repeat(3,minmax(0,1fr)); gap:20px; } }
        @media(min-width:1024px) { .trinity-gallery-grid { grid-template-columns:repeat(4,minmax(0,1fr)); gap:24px; } }
        .trinity-gallery-dialog { width:min(1040px,calc(100vw - 24px)); max-height:calc(100dvh - 24px); padding:0; border:0; border-radius:8px; background:#fff; color:#111827; }
        .trinity-gallery-dialog::backdrop { background:rgba(0,0,0,.8); }
        .trinity-gallery-main-image { display:block; width:100%; height:min(62vh,640px); object-fit:contain; }
    </style>
    <div class="trinity-gallery-grid">
        @forelse($projects as $project)
            @php
                $galleryPhotos = json_decode($project->gallery ?: '[]', true);
                $galleryPhotos = is_array($galleryPhotos) ? $galleryPhotos : [];
                $images = collect(array_merge([$project->cover_image], $galleryPhotos))
                    ->filter(fn ($path) => is_string($path) && trim($path) !== '')
                    ->unique()->map(fn ($path) => asset($path))->values()->all();
            @endphp
            <article class="min-w-0">
                <button type="button" @disabled(count($images) === 0) data-project-gallery="{{ $project->id }}" data-gallery="{{ json_encode($images) }}" data-title="{{ $project->title }}" @click="openGallery($el)" aria-label="View photos of {{ $project->title }}" class="block w-full overflow-hidden rounded-lg border border-gray-200 bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary" style="aspect-ratio:4/3;border-radius:8px;">
                    @if(count($images))<img src="{{ $images[0] }}" alt="{{ $project->title }}" loading="lazy" style="display:block;width:100%;height:100%;object-fit:cover;">@else<span class="flex h-full items-center justify-center bg-gray-100 text-3xl text-gray-400"><i class="fas fa-image" aria-hidden="true"></i></span>@endif
                </button>
            </article>
        @empty
            <p class="col-span-full py-10 text-center text-sm text-gray-500">No projects to display.</p>
        @endforelse
    </div>
    @if($projects->hasPages())<div class="mt-8">{{ $projects->links() }}</div>@endif
    <dialog x-ref="galleryDialog" class="trinity-gallery-dialog" aria-labelledby="gallery-dialog-title" @cancel.prevent="closeGallery()" @close="finishClose()" @click="closeGallery()" @keydown.left.prevent="step(-1)" @keydown.right.prevent="step(1)">
        <div class="p-4 sm:p-5">
            <div class="mb-4 flex items-center justify-between gap-4"><h2 id="gallery-dialog-title" class="sr-only">Project gallery photos</h2><button type="button" @click.stop="closeGallery()" autofocus class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100" aria-label="Close gallery"><i class="fas fa-times" aria-hidden="true"></i></button></div>
            <div class="relative rounded-lg bg-gray-50">
                <template x-if="photos.length"><img class="trinity-gallery-main-image" :src="photos[photoIndex]" :alt="projectTitle + ' — photo ' + (photoIndex + 1)"></template>
                <button type="button" x-show="galleries.length > 1" @click.stop="step(-1)" aria-label="Previous gallery" class="absolute left-2 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-primary shadow"><i class="fas fa-chevron-left" aria-hidden="true"></i></button>
                <button type="button" x-show="galleries.length > 1" @click.stop="step(1)" aria-label="Next gallery" class="absolute right-2 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-primary shadow"><i class="fas fa-chevron-right" aria-hidden="true"></i></button>
            </div>
            <p class="mt-3 text-center text-xs text-gray-500" aria-live="polite" x-text="photos.length ? (photoIndex + 1) + ' / ' + photos.length : ''"></p>
            <div class="mt-3 flex gap-2 overflow-x-auto pb-1" x-show="photos.length > 1" aria-label="Project photo thumbnails">
                <template x-for="(photo, index) in photos" :key="photo"><button type="button" @click.stop="photoIndex=index" :aria-label="'View photo ' + (index + 1)" :aria-pressed="photoIndex === index" class="shrink-0 overflow-hidden rounded-md border-2" :class="photoIndex === index ? 'border-primary' : 'border-transparent'" style="width:72px;height:56px;"><img :src="photo" alt="" loading="lazy" style="width:100%;height:100%;object-fit:cover;"></button></template>
            </div>
        </div>
    </dialog>
</section>
@include('frontend.partials.page-cta')
@endsection
