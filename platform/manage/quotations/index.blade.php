@extends('manage.layouts.app')

@section('title', 'Quotations - Admin')

@section('content')

    @php $canDelete = auth()->user()->hasPermission('manage_quotations'); @endphp

    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Quotations</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Quotations</h1>
                <p class="text-sm text-muted">Itemized price quotes prepared for customers.</p>
            </div>
            @if (auth()->user()->hasPermission('manage_quotations'))
                <a href="{{ route('manage.quotations.create') }}"
                    class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                    <i class="fa-solid fa-plus"></i>
                    New Quotation
                </a>
            @endif
        </div>
    </div>

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

    <div class="bg-background border border-border rounded-[12px] shadow-sm overflow-hidden">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between p-5 border-b border-border">
            <h2 class="text-base font-semibold text-black">All Quotations</h2>

            <form method="GET" action="{{ route('manage.quotations.index') }}" class="flex flex-wrap items-center gap-2">
                <select name="status" onchange="this.form.submit()"
                    class="rounded-[12px] border border-border bg-white px-3 py-2 text-sm text-black outline-none transition focus:border-primary">
                    <option value="">All Statuses</option>
                    @foreach (['draft', 'sent', 'accepted', 'rejected', 'expired', 'converted'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                <div class="relative w-full sm:w-auto">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-muted text-xs"></i>
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search code or customerâ€¦"
                        class="rounded-[12px] border border-border bg-white pl-8 pr-4 py-2 text-sm text-black outline-none transition focus:border-primary w-full sm:w-56">
                </div>

                <button type="submit"
                    class="rounded-[12px] border border-border px-4 py-2 text-sm text-muted transition hover:bg-slate-100">
                    Filter
                </button>
            </form>
        </div>

        <form id="bulk-delete-form" method="POST" action="{{ route('manage.quotations.bulk-destroy') }}">
        @csrf
        @if ($canDelete)
            <div class="px-5 pt-4">
                @include('manage.partials.bulk-delete', ['noun' => 'quotations', 'warning' => 'Their line items will be deleted too.'])
            </div>
        @endif
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[840px]">
                <thead class="bg-slate-50 border-b border-border">
                    <tr>
                        @if ($canDelete)
                            <th class="w-10 px-5 py-3"><input type="checkbox" class="bulk-check-all" aria-label="Select all quotations"></th>
                        @endif
                        <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">Code</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">Customer</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">Prepared By</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">Total (KES)</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">Created</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-muted uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($quotations as $quotation)
                        <tr class="hover:bg-slate-50 transition">
                            @if ($canDelete)
                                <td class="px-5 py-3"><input type="checkbox" name="ids[]" value="{{ $quotation->id }}" class="bulk-check" aria-label="Select quotation"></td>
                            @endif
                            <td class="px-5 py-3 text-black font-medium">{{ $quotation->quotation_code }}</td>
                            <td class="px-5 py-3 text-black">
                                {{ trim(($quotation->customer_first_name ?? $quotation->customer->first_name ?? '') . ' ' . ($quotation->customer_last_name ?? $quotation->customer->last_name ?? '')) ?: 'â€”' }}
                            </td>
                            <td class="px-5 py-3 text-muted">
                                {{ trim(($quotation->preparedBy->first_name ?? '') . ' ' . ($quotation->preparedBy->last_name ?? '')) ?: 'â€”' }}
                            </td>
                            <td class="px-5 py-3 text-black font-medium">{{ number_format($quotation->total, 2) }}</td>
                            <td class="px-5 py-3">
                                @php
                                    $statusColors = [
                                        'draft'     => 'bg-slate-100 text-slate-700',
                                        'sent'      => 'bg-blue-100 text-blue-700',
                                        'accepted'  => 'bg-emerald-100 text-emerald-700',
                                        'rejected'  => 'bg-red-100 text-red-700',
                                        'expired'   => 'bg-amber-100 text-amber-700',
                                        'converted' => 'bg-purple-100 text-purple-700',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-[12px] text-xs font-medium {{ $statusColors[$quotation->status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($quotation->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-muted">{{ $quotation->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('manage.quotations.show', $quotation->id) }}"
                                    class="inline-flex items-center gap-1 rounded-[8px] border border-border bg-white px-3 py-1.5 text-xs font-medium text-black transition hover:bg-slate-100">
                                    <i class="fa-solid fa-eye"></i>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $canDelete ? 8 : 7 }}" class="px-5 py-10 text-center text-sm text-muted">
                                No quotations found.
                                {{ request('status') || request('search') ? 'Try adjusting your filters.' : 'Create one to get started.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </form>

        @if ($quotations->hasPages())
            <div class="px-5 py-4 border-t border-border">
                {{ $quotations->links() }}
            </div>
        @endif

    </div>

@endsection
