@extends('manage.layouts.app')

@section('title', 'Payment Logs')
@section('meta-description', 'View detailed logs of all payment-related system events for audit and debugging.')

@section('content')
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.payments.transactions.index') }}" class="hover:text-primary">Payments</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Payment Logs</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Payment Logs</h1>
                <p class="text-sm text-muted">Detailed audit trail of all payment gateway interactions.</p>
            </div>
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

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
        {{-- ---------------
        -- Logs Table
        -- --------------- --}}
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
            <table class="min-w-[840px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Log ID</th>
                        <th class="px-4 py-3">Event</th>
                        <th class="px-4 py-3">Source</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Message</th>
                        <th class="px-4 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($logs as $index => $log)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-medium text-black">{{ $logs->firstItem() + $index }}</td>
                            <td class="px-4 py-4 text-black">{{ $log->id }}</td>
                            <td class="px-4 py-4 text-black">{{ $log->event_type ?? 'Payment callback' }}</td>
                            <td class="px-4 py-4 text-black">{{ $log->source ?? 'M-Pesa' }}</td>
                            <td class="px-4 py-4">
                                @php
                                    $status = strtolower($log->status);
                                    $badgeColor = match($status) {
                                        'success', 'processed' => 'bg-emerald-100 text-emerald-800',
                                        'failed' => 'bg-rose-100 text-rose-800',
                                        'retrying' => 'bg-amber-100 text-amber-800',
                                        default => 'bg-slate-100 text-slate-600',
                                    };
                                @endphp
                                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold {{ $badgeColor }}">
                                    {{ ucfirst($log->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-black max-w-md truncate">{{ $log->message ?? $log->status }}</td>
                            <td class="px-4 py-4 text-black">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-sm text-muted">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fa-solid fa-receipt text-3xl text-slate-300"></i>
                                    <span>No payment logs found. Try adjusting your search or filters.</span>
                                    @if (request()->hasAny(['search', 'status', 'message', 'from_date', 'to_date']))
                                        <a href="{{ route('manage.payments.logs.index') }}"
                                            class="text-xs text-primary hover:underline">Clear all filters</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-muted">
                Showing {{ $logs->firstItem() ?? 0 }} – {{ $logs->lastItem() ?? 0 }}
                of {{ $logs->total() }} logs
            </p>
            <div>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection