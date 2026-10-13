@extends('manage.layouts.app')

@section('title', 'Product Reviews - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Product Reviews</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Product Reviews</h1>
                <p class="text-sm text-muted">Moderate customer reviews - approve, reject, or delete.</p>
            </div>
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

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        {{-- ---------------
        -- Search + Status Filter
        -- --------------- --}}
        <form method="GET" action="{{ route('manage.ecommerce.reviews.index') }}"
              class="mb-6 flex flex-wrap items-center gap-3">

            <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search by product or customer name..."
                    class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                @if (request('search'))
                    <a href="{{ route('manage.ecommerce.reviews.index', request()->except(['search', 'page'])) }}"
                        class="pr-3 text-muted hover:text-red-400 transition text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <select name="status" onchange="this.form.submit()"
                class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                <option value="">All Statuses</option>
                @foreach (['pending', 'approved', 'rejected'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-magnifying-glass"></i>
                Search
            </button>

            @if (request()->hasAny(['search', 'status']))
                <a href="{{ route('manage.ecommerce.reviews.index') }}"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-3 text-sm text-muted transition hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i>
                    Clear
                </a>
            @endif

        </form>

        {{-- ---------------
        -- Reviews Table
        -- --------------- --}}
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[840px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Rating</th>
                            <th class="px-4 py-3">Review</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($reviews as $review)
                            @php
                                // ---------------
                                // Status badge colours
                                // ---------------
                                $statusColors = [
                                    'approved' => 'bg-emerald-100 text-emerald-800',
                                    'pending'  => 'bg-amber-100 text-amber-800',
                                    'rejected' => 'bg-slate-100 text-slate-600',
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('manage.ecommerce.reviews.show', $review->id) }}'"  >
                                <td class="px-4 py-4">
                                    <div class="font-medium text-black">
                                        {{ optional($review->product)->name ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    @if ($review->user)
                                        <div class="font-medium text-black">
                                            {{ $review->user->first_name }} {{ $review->user->last_name }}
                                        </div>
                                        <div class="text-xs text-muted">{{ $review->user->email }}</div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex gap-0.5 text-amber-400 text-sm">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-black max-w-xs">
                                    <p class="line-clamp-2">{{ $review->comment ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                                        {{ $statusColors[$review->status] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($review->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-xs text-muted whitespace-nowrap">
                                    {{ $review->created_at?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="px-4 py-4 text-right" onclick="event.stopPropagation()">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="{{ route('manage.ecommerce.reviews.show', $review->id) }}"
                                            title="View"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                        @if ($review->status === 'pending')
                                            <form method="POST" action="{{ route('manage.ecommerce.reviews.approve', $review->id) }}">
                                                @csrf
                                                <button type="submit" title="Approve"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-emerald-200 bg-emerald-50 text-emerald-700 transition hover:bg-emerald-100">
                                                    <i class="fa-solid fa-check text-xs"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('manage.ecommerce.reviews.reject', $review->id) }}">
                                                @csrf
                                                <button type="submit" title="Reject"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-amber-200 bg-amber-50 text-amber-700 transition hover:bg-amber-100">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('manage.ecommerce.reviews.destroy', $review->id) }}"
                                              onsubmit="return confirm('Delete this review permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-rose-200 bg-rose-50 text-rose-600 transition hover:bg-rose-100">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-sm text-muted">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="fa-solid fa-star text-3xl text-slate-300"></i>
                                        <span>No reviews found. Try adjusting your filters.</span>
                                        @if (request()->hasAny(['search', 'status']))
                                            <a href="{{ route('manage.ecommerce.reviews.index') }}"
                                                class="text-xs text-primary hover:underline">Clear filters</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ---------------
        -- Pagination
        -- --------------- --}}
        <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-muted">
                Showing {{ $reviews->firstItem() ?? 0 }} – {{ $reviews->lastItem() ?? 0 }}
                of {{ $reviews->total() }} reviews
            </p>
            <div>{{ $reviews->links() }}</div>
        </div>

    </div>

@endsection
