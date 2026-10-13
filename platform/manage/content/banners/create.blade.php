{{-- -------------------
     Admin Content - Create Banner
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'Add Banner - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.content.banners.index') }}" class="hover:text-primary">Hero Banners</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Add Banner</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('manage.content.banners.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-black">Add Banner</h1>
                <p class="text-sm text-muted">Upload a new homepage slide.</p>
            </div>
        </div>
    </div>

    @include('manage.content.banners.partials.form', [
        'action' => route('manage.content.banners.store'),
        'method' => 'POST',
        'banner' => null,
    ])

@endsection
