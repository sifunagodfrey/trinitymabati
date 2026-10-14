@extends('frontend.layouts.app')
@section('title', 'Client Projects | Trinity Mabati Factory')
@section('meta_description', 'Explore roofing projects completed with Trinity Mabati Factory products.')
@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
 <div class="text-center mb-10"><p class="uppercase tracking-widest text-red-600 text-sm font-semibold">Our work</p><h1 class="text-3xl sm:text-4xl font-bold mt-2">Client Projects</h1><p class="text-gray-600 mt-3">Explore roofing projects featuring Trinity Mabati products.</p></div>
 <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
 @forelse($projects as $p)
 <a href="{{ route('frontend.projects.show', $p->slug) }}" class="group block rounded-xl border border-gray-200 bg-white overflow-hidden hover:shadow-lg transition">
  @if($p->cover_image)<img src="{{ asset($p->cover_image) }}" alt="{{ $p->title }}" class="w-full aspect-[4/3] object-cover">@else<div class="w-full aspect-[4/3] bg-gray-100 flex items-center justify-center text-gray-400 text-5xl"><i class="fas fa-house"></i></div>@endif
  <div class="p-5"><h2 class="font-bold text-lg group-hover:text-red-600">{{ $p->title }}</h2><p class="text-sm text-gray-500 mt-2">{{ collect([$p->location, $p->roofing_profile])->filter()->implode(' · ') }}</p><span class="inline-block mt-4 text-red-600 font-semibold text-sm">View project →</span></div>
 </a>
 @empty <div class="col-span-full text-center bg-white border rounded-xl p-12 text-gray-500">Client projects will be published here soon.</div>
 @endforelse
 </div><div class="mt-8">{{ $projects->links() }}</div>
</section>
@endsection
