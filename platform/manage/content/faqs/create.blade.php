{{-- -------------------
     Admin Content - Create FAQ
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'Add Question - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.content.faqs.index') }}" class="hover:text-primary">FAQs</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Add Question</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('manage.content.faqs.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-black">Add Question</h1>
                <p class="text-sm text-muted">Add a new question to the public FAQ page.</p>
            </div>
        </div>
    </div>

    @include('manage.content.faqs.partials.form', [
        'action' => route('manage.content.faqs.store'),
        'method' => 'POST',
        'faq'    => null,
    ])

@endsection
