@extends('manage.layouts.app')

@section('title', 'Adjust Wallet - ' . $wallet->user_name)

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
                <li><a href="{{ route('manage.wallet.show', $wallet->id) }}" class="hover:text-primary">{{ $wallet->user_name }}</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Adjust Balance</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('manage.wallet.show', $wallet->id) }}"
               class="inline-flex items-center gap-1 text-sm text-muted hover:text-primary transition">
                <i class="fas fa-arrow-left text-xs"></i> Back
            </a>
        </div>

        <h1 class="text-2xl font-semibold text-black">Adjust Wallet Balance</h1>
        <p class="text-sm text-muted">
            Manually credit or debit <strong>{{ $wallet->user_name }}</strong>'s wallet.
            All adjustments are logged in the transaction history.
        </p>
    </div>

    {{-- ---------------
    -- Alerts
    -- --------------- --}}
    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ---------------
    -- Current Balance Card
    -- --------------- --}}
    <div class="mb-6 rounded-[12px] border border-border bg-surface shadow-sm p-5 max-w-xl">
        <p class="text-xs text-muted uppercase tracking-wide mb-1">Current Balance</p>
        <p class="text-3xl font-bold text-black">
            {{ $wallet->currency }} {{ number_format($wallet->balance, 2) }}
        </p>
        <p class="text-xs text-muted mt-1">
            Status:
            @if ($wallet->is_active)
                <span class="text-emerald-700 font-semibold">Active</span>
            @else
                <span class="text-red-600 font-semibold">Frozen</span>
                &mdash; Debit will fail on a frozen wallet.
            @endif
        </p>
    </div>

    {{-- ---------------
    -- Adjustment Form
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm max-w-xl">
        <form method="POST" action="{{ route('manage.wallet.adjust.apply', $wallet->id) }}">
            @csrf

            <div class="space-y-5 mb-6">

                {{-- Transaction Type --}}
                <div>
                    <label class="block text-sm font-medium text-black mb-2">
                        Transaction Type <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="credit"
                                   {{ old('type', 'credit') === 'credit' ? 'checked' : '' }}
                                   class="text-primary focus:ring-primary">
                            <span class="text-sm font-medium text-emerald-700">
                                <i class="fas fa-plus-circle mr-1"></i> Credit
                            </span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="debit"
                                   {{ old('type') === 'debit' ? 'checked' : '' }}
                                   class="text-primary focus:ring-primary">
                            <span class="text-sm font-medium text-red-600">
                                <i class="fas fa-minus-circle mr-1"></i> Debit
                            </span>
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-muted">
                        Credit adds funds to the wallet. Debit removes funds (wallet must have sufficient balance and be active).
                    </p>
                </div>

                {{-- Amount --}}
                <div>
                    <label for="amount" class="block text-sm font-medium text-black mb-1">
                        Amount ({{ $wallet->currency }}) <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           min="1"
                           step="0.01"
                           id="amount"
                           name="amount"
                           value="{{ old('amount') }}"
                           placeholder="e.g. 500.00"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-black mb-1">
                        Reason / Description <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="description"
                           name="description"
                           maxlength="255"
                           value="{{ old('description') }}"
                           placeholder="e.g. Goodwill credit for service disruption"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                </div>

            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('manage.wallet.show', $wallet->id) }}"
                   class="rounded-[8px] border border-border px-5 py-2 text-sm font-medium text-black hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                        class="rounded-[8px] bg-primary px-5 py-2 text-sm font-medium text-white hover:bg-primary/90">
                    Apply Adjustment
                </button>
            </div>
        </form>
    </div>

@endsection
