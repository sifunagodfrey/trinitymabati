@extends('manage.layouts.app')

@section('title', 'Customer Wallets')

@section('content')

    {{-- ---------------
    -- Breadcrumb + Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Customer Wallets</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Customer Wallets</h1>
                <p class="text-sm text-muted">
                    {{ $wallets->total() }} {{ Str::plural('wallet', $wallets->total()) }} found.
                </p>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Search + Filter Bar
    -- --------------- --}}
    <form method="GET" action="{{ route('manage.wallet.index') }}"
          class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center">
        <input type="text"
               name="search"
               value="{{ $search }}"
               placeholder="Search by name or email..."
               class="w-full sm:w-72 rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">

        <select name="status"
                class="rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
            <option value="" {{ $status === '' ? 'selected' : '' }}>All Wallets</option>
            <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
            <option value="frozen" {{ $status === 'frozen' ? 'selected' : '' }}>Frozen</option>
        </select>

        <button type="submit"
                class="rounded-[8px] bg-primary px-5 py-2 text-sm font-medium text-white hover:bg-primary/90">
            Filter
        </button>

        @if ($search !== '' || $status !== '')
            <a href="{{ route('manage.wallet.index') }}"
               class="rounded-[8px] border border-border px-5 py-2 text-sm font-medium text-black hover:bg-slate-50">
                Clear
            </a>
        @endif
    </form>

    {{-- ---------------
    -- Wallets Table
    -- --------------- --}}
    <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[840px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Balance</th>
                        <th class="px-4 py-3">Currency</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Last Updated</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($wallets as $wallet)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 text-muted text-xs">{{ $wallet->id }}</td>
                            <td class="px-4 py-4">
                                <div class="font-medium text-black">{{ $wallet->user_name }}</div>
                                <div class="text-xs text-muted">{{ $wallet->email }}</div>
                            </td>
                            <td class="px-4 py-4 font-semibold text-black">
                                {{ number_format($wallet->balance, 2) }}
                            </td>
                            <td class="px-4 py-4 text-gray-600 text-xs">{{ $wallet->currency }}</td>
                            <td class="px-4 py-4">
                                @if ($wallet->is_active)
                                    <span class="inline-flex rounded-[12px] px-2.5 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex rounded-[12px] px-2.5 py-1 text-xs font-semibold bg-red-100 text-red-700">
                                        Frozen
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-muted text-xs whitespace-nowrap">
                                {{ $wallet->updated_at ? \Carbon\Carbon::parse($wallet->updated_at)->format('M d, Y') : '-' }}
                            </td>
                            <td class="px-4 py-4 text-right">
                                <a href="{{ route('manage.wallet.show', $wallet->id) }}"
                                   class="inline-flex items-center gap-1 rounded-[8px] border border-border px-3 py-1.5 text-xs font-medium text-black hover:bg-slate-50 transition">
                                    <i class="fas fa-eye text-[10px]"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-sm text-muted">
                                No wallets found.
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
    @if ($wallets->hasPages())
        <div class="mt-6">{{ $wallets->links() }}</div>
    @endif

@endsection
