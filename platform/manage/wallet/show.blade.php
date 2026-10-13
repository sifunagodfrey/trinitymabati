@extends('manage.layouts.app')

@section('title', 'Wallet - ' . $wallet->user_name)

@section('content')

    {{-- ---------------
    -- Breadcrumb + Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.wallet.index') }}" class="hover:text-primary">Customer Wallets</a></li>
                <li>/</li>
                <li class="text-black font-semibold">{{ $wallet->user_name }}</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('manage.wallet.index') }}"
               class="inline-flex items-center gap-1 text-sm text-muted hover:text-primary transition">
                <i class="fas fa-arrow-left text-xs"></i> Back
            </a>
        </div>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">{{ $wallet->user_name }}</h1>
                <p class="text-sm text-muted">{{ $wallet->email }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('manage.wallet.adjust', $wallet->id) }}"
                   class="inline-flex items-center gap-2 rounded-[8px] bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary/90">
                    <i class="fas fa-sliders-h text-xs"></i> Adjust Balance
                </a>
                <form method="POST" action="{{ route('manage.wallet.freeze', $wallet->id) }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-[8px] border border-border px-4 py-2 text-sm font-medium
                                   {{ $wallet->is_active ? 'text-red-600 hover:bg-red-50' : 'text-emerald-700 hover:bg-emerald-50' }} transition">
                        <i class="fas {{ $wallet->is_active ? 'fa-lock' : 'fa-lock-open' }} text-xs"></i>
                        {{ $wallet->is_active ? 'Freeze Wallet' : 'Unfreeze Wallet' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Alerts
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- ---------------
    -- Wallet Summary Cards
    -- --------------- --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="rounded-[12px] border border-border bg-surface shadow-sm p-5">
            <p class="text-xs text-muted uppercase tracking-wide mb-1">Balance</p>
            <p class="text-2xl font-bold text-black">
                {{ $wallet->currency }} {{ number_format($wallet->balance, 2) }}
            </p>
        </div>
        <div class="rounded-[12px] border border-border bg-surface shadow-sm p-5">
            <p class="text-xs text-muted uppercase tracking-wide mb-1">Status</p>
            @if ($wallet->is_active)
                <span class="inline-flex rounded-[12px] px-3 py-1.5 text-sm font-semibold bg-emerald-100 text-emerald-800">
                    Active
                </span>
            @else
                <span class="inline-flex rounded-[12px] px-3 py-1.5 text-sm font-semibold bg-red-100 text-red-700">
                    Frozen
                </span>
            @endif
        </div>
        <div class="rounded-[12px] border border-border bg-surface shadow-sm p-5">
            <p class="text-xs text-muted uppercase tracking-wide mb-1">Wallet ID</p>
            <p class="text-2xl font-bold text-black">#{{ $wallet->id }}</p>
        </div>
    </div>

    {{-- ---------------
    -- Transactions Table
    -- --------------- --}}
    <div class="mb-3">
        <h2 class="text-lg font-semibold text-black">Transaction History</h2>
        <p class="text-sm text-muted">{{ $transactions->total() }} {{ Str::plural('transaction', $transactions->total()) }} recorded.</p>
    </div>

    <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[960px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Balance After</th>
                        <th class="px-4 py-3">Reference</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @php
                        $typeConfig = [
                            'credit'   => ['bg-emerald-100 text-emerald-800', 'Credit'],
                            'debit'    => ['bg-red-100 text-red-700',         'Debit'],
                            'refund'   => ['bg-blue-100 text-blue-800',       'Refund'],
                            'reversal' => ['bg-orange-100 text-orange-800',   'Reversal'],
                        ];
                    @endphp
                    @forelse ($transactions as $tx)
                        @php
                            [$typeCls, $typeLabel] = $typeConfig[$tx->type] ?? ['bg-slate-100 text-slate-700', ucfirst($tx->type)];
                            $isCredit = in_array($tx->type, ['credit', 'refund', 'reversal']);
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 text-muted text-xs">{{ $tx->id }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-[12px] px-2.5 py-1 text-xs font-semibold {{ $typeCls }}">
                                    {{ $typeLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-4 font-semibold {{ $isCredit ? 'text-emerald-700' : 'text-red-600' }}">
                                {{ $isCredit ? '+' : '-' }}{{ number_format($tx->amount, 2) }}
                            </td>
                            <td class="px-4 py-4 text-gray-700">
                                {{ number_format($tx->balance_after, 2) }}
                            </td>
                            <td class="px-4 py-4 text-muted text-xs font-mono">
                                {{ $tx->reference ?? '-' }}
                            </td>
                            <td class="px-4 py-4 text-gray-600 max-w-xs truncate">
                                {{ $tx->description ?? '-' }}
                            </td>
                            <td class="px-4 py-4 text-muted text-xs">
                                {{ $tx->order_id ? '#' . $tx->order_id : '-' }}
                            </td>
                            <td class="px-4 py-4 text-muted text-xs whitespace-nowrap">
                                {{ $tx->created_at ? \Carbon\Carbon::parse($tx->created_at)->format('M d, Y H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center text-sm text-muted">
                                No transactions recorded for this wallet.
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
    @if ($transactions->hasPages())
        <div class="mt-6">{{ $transactions->links() }}</div>
    @endif

@endsection
