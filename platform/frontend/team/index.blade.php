@extends('frontend.layouts.app')
@section('title', 'Our Team | Trinity Mabati Factory')
@section('meta_description', 'Meet the people behind Trinity Mabati Factory and our commitment to quality roofing.')
@section('content')
<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-16 lg:px-8">
    <header class="mb-10 text-center">
        <h1 class="text-3xl font-semibold text-primary sm:text-4xl">Our Team</h1>
        <p class="mt-3 text-sm leading-relaxed text-gray-500">Meet the people behind our commitment to quality roofing.</p>
    </header>
    <style>
        .trinity-team-page-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; }
        @media(min-width:640px) { .trinity-team-page-grid { grid-template-columns:repeat(3,minmax(0,1fr)); gap:24px; } }
        @media(min-width:1024px) { .trinity-team-page-grid { grid-template-columns:repeat(4,minmax(0,1fr)); } }
    </style>
    <div class="trinity-team-page-grid">
        @forelse($members as $member)
            @include('frontend.partials.team-card', ['member' => $member])
        @empty
            <p class="col-span-full rounded-xl border border-gray-200 bg-white p-10 text-center text-gray-500">Our team profiles will be available here soon.</p>
        @endforelse
    </div>
    <div class="mt-8">{{ $members->links() }}</div>
</section>
@include('frontend.partials.page-cta')
@endsection
