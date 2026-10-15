@extends('manage.layouts.app')

@section('title', 'Transactions')
@section('meta-description', 'View and manage all financial transactions on the Trinity Mabati Factory.')

@section('content')
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.payments.transactions.index') }}" class="hover:text-primary">Payments</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Transactions</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Platform Transactions</h1>
                <p class="text-sm text-muted">All payment transactions - orders, contracts, auctions, and vendor subscriptions.</p>
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
        -- Transactions Table
        -- --------------- --}}
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[960px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Reference</th>
                            <th class="px-4 py-3">Order / Ref</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Amount (KES)</th>
                            <th class="px-4 py-3">Method</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse($transactions as $index => $txn)
                            <tr class="hover:bg-slate-50">

                                {{-- Row number --}}
                                <td class="px-4 py-4 font-medium text-black">
                                    {{ $transactions->firstItem() + $index }}
                                </td>

                                {{-- Reference --}}
                                <td class="px-4 py-4 text-xs text-muted font-mono max-w-[160px] truncate" title="{{ $txn->reference }}">
                                    <a href="{{ route('manage.payments.transactions.show', $txn->id) }}" class="font-semibold text-primary hover:underline">{{ $txn->reference }}</a>
                                </td>

                                {{-- Order / Plan ref --}}
                                <td class="px-4 py-4 text-black text-xs">
                                    {{ $txn->order_ref ?: '-' }}
                                </td>

                                {{-- Type badge --}}
                                <td class="px-4 py-4">
                                    @php
                                        $typeBadge = match($txn->source) {
                                            'order'        => 'bg-blue-100 text-blue-800',
                                            'contract'     => 'bg-purple-100 text-purple-800',
                                            'auction'      => 'bg-orange-100 text-orange-800',
                                            'subscription' => 'bg-indigo-100 text-indigo-800',
                                            default        => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold {{ $typeBadge }}">
                                        {{ $txn->type_label }}
                                    </span>
                                </td>

                                {{-- User --}}
                                <td class="px-4 py-4">
                                    <p class="text-black font-medium text-sm leading-tight">
                                        {{ trim($txn->user_name) ?: '-' }}
                                    </p>
                                    @if($txn->user_email)
                                        <p class="text-xs text-muted">{{ $txn->user_email }}</p>
                                    @endif
                                </td>

                                {{-- Amount --}}
                                <td class="px-4 py-4 text-black font-semibold whitespace-nowrap">
                                    KES {{ number_format((float) $txn->amount, 2) }}
                                </td>

                                {{-- Method --}}
                                <td class="px-4 py-4 text-black text-sm">
                                    {{ $txn->method_name }}
                                </td>

                                {{-- Status badge --}}
                                <td class="px-4 py-4">
                                    @php
                                        $statusBadge = match(strtolower($txn->status_normalized)) {
                                            'paid', 'successful' => 'bg-emerald-100 text-emerald-800',
                                            'pending'            => 'bg-amber-100 text-amber-800',
                                            'failed'             => 'bg-red-100 text-red-800',
                                            'cancelled'          => 'bg-gray-100 text-gray-600',
                                            'refunded'           => 'bg-rose-100 text-rose-800',
                                            default              => 'bg-slate-100 text-slate-600',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold {{ $statusBadge }}">
                                        {{ ucfirst($txn->status_normalized) }}
                                    </span>
                                </td>

                                {{-- Date --}}
                                <td class="px-4 py-4 text-muted text-xs whitespace-nowrap">
                                    {{ $txn->created_at ? \Carbon\Carbon::parse($txn->created_at)->format('d M Y, H:i') : '-' }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center text-sm text-muted">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="fa-solid fa-credit-card text-3xl text-slate-300"></i>
                                        <span>No transactions found.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ---------------
        -- Legend + Pagination
        -- --------------- --}}
        <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

            {{-- Source legend --}}
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <span class="inline-flex rounded-[12px] px-3 py-1 font-semibold bg-blue-100 text-blue-800">Order Payment</span>
                <span class="inline-flex rounded-[12px] px-3 py-1 font-semibold bg-purple-100 text-purple-800">Contract Payment</span>
                <span class="inline-flex rounded-[12px] px-3 py-1 font-semibold bg-orange-100 text-orange-800">Auction Payment</span>
                <span class="inline-flex rounded-[12px] px-3 py-1 font-semibold bg-indigo-100 text-indigo-800">Subscription</span>
            </div>

            <div class="flex flex-col items-end gap-2">
                <p class="text-sm text-muted">
                    Showing {{ $transactions->firstItem() ?? 0 }}–{{ $transactions->lastItem() ?? 0 }}
                    of {{ $transactions->total() }} transactions
                </p>
                {{ $transactions->links() }}
            </div>

        </div>
    </div>
@endsection
