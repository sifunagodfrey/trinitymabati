@extends('manage.layouts.app')

@section('title', 'Review #' . $review->id . ' - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.reviews.index') }}" class="hover:text-primary">Reviews</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Review #{{ $review->id }}</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('manage.ecommerce.reviews.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back
                </a>
                <div>
                    <h1 class="text-2xl font-semibold text-black">Review #{{ $review->id }}</h1>
                    <p class="text-sm text-muted">Submitted {{ $review->created_at?->format('d M Y, H:i') ?? '-' }}</p>
                </div>
            </div>

            {{-- ---------------
            -- Status Badge
            -- --------------- --}}
            @php
                $statusColors = [
                    'pending'  => 'bg-amber-100 text-amber-800',
                    'approved' => 'bg-emerald-100 text-emerald-800',
                    'rejected' => 'bg-rose-100 text-rose-800',
                ];
            @endphp
            <span class="inline-flex rounded-[12px] px-4 py-1.5 text-xs font-semibold
                {{ $statusColors[$review->status] ?? 'bg-slate-100 text-slate-600' }}">
                {{ ucfirst($review->status ?? 'pending') }}
            </span>
        </div>
    </div>

    {{-- ---------------
    -- Session Alerts
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-6">

        {{-- ---------------
        -- Review Content & Actions
        -- --------------- --}}
        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Review Body --}}
            <div class="lg:col-span-2 bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">
                    <i class="fa-solid fa-star text-muted mr-2"></i>Review Content
                </h2>

                {{-- Star Rating --}}
                <div class="flex items-center gap-1 mb-4">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star text-lg
                            {{ $i <= ($review->rating ?? 0) ? 'text-amber-400' : 'text-slate-200' }}"></i>
                    @endfor
                    <span class="ml-2 text-sm font-semibold text-black">{{ $review->rating }}/5</span>
                </div>

                {{-- Comment --}}
                <div class="rounded-[12px] bg-slate-50 px-4 py-4 text-sm text-black leading-relaxed">
                    {{ $review->comment ?? 'No comment provided.' }}
                </div>
            </div>

            {{-- Sidebar Actions --}}
            <div class="space-y-4">

                {{-- Approve / Reject (only when pending) --}}
                @if ($review->status === 'pending')
                    <div class="bg-background border border-border rounded-[12px] p-5 shadow-sm space-y-3">
                        <h3 class="text-sm font-semibold text-black">Actions</h3>

                        <form method="POST" action="{{ route('manage.ecommerce.reviews.approve', $review->id) }}">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-[12px] bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-emerald-700">
                                <i class="fa-solid fa-check"></i>
                                Approve Review
                            </button>
                        </form>

                        <form method="POST" action="{{ route('manage.ecommerce.reviews.reject', $review->id) }}"
                              onsubmit="return confirm('Reject this review?')">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-[12px] border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-medium text-rose-700 transition hover:bg-rose-100">
                                <i class="fa-solid fa-xmark"></i>
                                Reject Review
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Delete --}}
                <div class="bg-background border border-border rounded-[12px] p-5 shadow-sm">
                    <h3 class="text-sm font-semibold text-black mb-3">Danger Zone</h3>
                    <form method="POST" action="{{ route('manage.ecommerce.reviews.destroy', $review->id) }}"
                          onsubmit="return confirm('Permanently delete this review? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-[12px] border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-medium text-red-700 transition hover:bg-red-100">
                            <i class="fa-solid fa-trash"></i>
                            Delete Review
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- ---------------
        -- Product & Reviewer Info
        -- --------------- --}}
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Product --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">
                    <i class="fa-solid fa-box text-muted mr-2"></i>Product
                </h2>
                @if ($review->product)
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">Name</span>
                            <span class="font-medium text-black">{{ $review->product->name }}</span>
                        </div>
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">SKU</span>
                            <span class="font-medium text-black">{{ $review->product->sku ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">Price</span>
                            <span class="font-medium text-black">KES {{ number_format($review->product->price ?? 0, 2) }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-muted">Product no longer available.</p>
                @endif
            </div>

            {{-- Reviewer --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">
                    <i class="fa-solid fa-user text-muted mr-2"></i>Reviewer
                </h2>
                @if ($review->user)
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">Name</span>
                            <span class="font-medium text-black">{{ $review->user->first_name }} {{ $review->user->last_name }}</span>
                        </div>
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">Email</span>
                            <span class="font-medium text-black">{{ $review->user->email }}</span>
                        </div>
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">Phone</span>
                            <span class="font-medium text-black">{{ $review->user->phone ?? '-' }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-muted">Reviewer not found.</p>
                @endif
            </div>

        </div>

    </div>

@endsection
