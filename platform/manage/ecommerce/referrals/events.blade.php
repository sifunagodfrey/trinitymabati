{{-- -------------------
     Admin Referrals - Signup Events
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'Referral Signups - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.referrals.index') }}" class="hover:text-primary">Referral Codes</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Signups</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Referral Signups</h1>
                <p class="text-sm text-muted">Accounts created through customer referral links.</p>
            </div>
            <form method="GET">
                <select name="status" onchange="this.form.submit()"
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary">
                    <option value="">All statuses</option>
                    @foreach (['pending', 'qualified', 'rewarded', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </form>
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

    {{-- ---------------
    -- Events Table
    -- --------------- --}}
    <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[840px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3">Referrer</th>
                        <th class="px-4 py-3">New Customer</th>
                        <th class="px-4 py-3">Signed Up</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Reward</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($events as $event)
                        @php
                            $statusColors = [
                                'pending'   => 'bg-amber-100 text-amber-800',
                                'qualified' => 'bg-blue-100 text-blue-800',
                                'rewarded'  => 'bg-emerald-100 text-emerald-800',
                                'cancelled' => 'bg-slate-100 text-slate-600',
                            ];
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4">
                                <span class="font-mono text-sm font-semibold text-black">{{ $event->code?->code }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-sm font-medium text-black">{{ $event->referrer?->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-muted">{{ $event->referrer?->email }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-sm font-medium text-black">{{ $event->referred?->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-muted">{{ $event->referred?->email }}</p>
                            </td>
                            <td class="px-4 py-4 text-xs text-muted">
                                {{ $event->created_at?->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                                    {{ $statusColors[$event->status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right font-semibold text-black">
                                @if ($event->status === 'rewarded')
                                    KES {{ number_format($event->reward_amount, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-4 text-right">
                                @if ($event->status !== 'rewarded' && $event->status !== 'cancelled')
                                    <form method="POST" action="{{ route('manage.ecommerce.referrals.reward', $event->id) }}"
                                          onsubmit="return confirm('Issue the referral reward to {{ $event->referrer?->name }}?')"
                                          class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 rounded-[12px] border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 transition hover:bg-emerald-100">
                                            <i class="fa-solid fa-gift"></i>
                                            Reward
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-sm text-muted">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fa-solid fa-user-plus text-3xl text-slate-300"></i>
                                    <span>No referral signups recorded yet.</span>
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
            Showing {{ $events->firstItem() ?? 0 }} – {{ $events->lastItem() ?? 0 }}
            of {{ $events->total() }} signups
        </p>
        <div>{{ $events->links() }}</div>
    </div>

@endsection
