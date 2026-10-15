@extends('frontend.layouts.app')
@section('title', $project->title.' | Trinity Mabati Factory')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($project->description ?? $project->title), 150))
@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
 <a href="{{ route('frontend.projects') }}" class="text-red-600 text-sm font-semibold">← All client projects</a>
 <h1 class="text-3xl sm:text-4xl font-bold mt-5">{{ $project->title }}</h1>
 <div class="mt-4 flex flex-wrap gap-3 text-gray-600 text-sm">@if($project->location)<span><i class="fas fa-map-marker-alt"></i> {{ $project->location }}</span>@endif @if($project->roofing_profile)<span><i class="fas fa-layer-group"></i> {{ $project->roofing_profile }}</span>@endif @if($project->completion_date)<span>{{ \Carbon\Carbon::parse($project->completion_date)->format('M Y') }}</span>@endif</div>
 @if($project->cover_image)<img src="{{ asset($project->cover_image) }}" alt="{{ $project->title }}" class="w-full max-h-[650px] object-cover rounded-xl mt-8">@endif
 @if($project->description)<p class="mt-8 text-gray-700 leading-8 whitespace-pre-line">{{ $project->description }}</p>@endif
 @if(count($gallery))<h2 class="text-2xl font-bold mt-12 mb-5">Project Gallery</h2><div class="grid grid-cols-2 md:grid-cols-3 gap-4">@foreach($gallery as $photo)<a href="{{ asset($photo) }}" target="_blank" rel="noopener"><img src="{{ asset($photo) }}" alt="{{ $project->title }} gallery photo" loading="lazy" class="w-full aspect-square object-cover rounded-xl"></a>@endforeach</div>@endif
</section>
@include('frontend.partials.page-cta')
@endsection
