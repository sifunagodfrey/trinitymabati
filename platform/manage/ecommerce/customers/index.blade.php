@extends('manage.layouts.app')

@section('title', 'Customers - Trinity Mabati Factory Admin')

@section('content')

    @php $canDelete = auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'); @endphp

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Customers</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Customer Accounts</h1>
                <p class="text-sm text-muted">View and manage registered buyer accounts.</p>
            </div>
            <p class="text-sm text-muted">{{ number_format($customers->total()) }} total</p>
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
        <form method="GET" action="{{ route('manage.ecommerce.customers.index') }}"
              class="mb-6 flex flex-wrap items-center gap-3">

            <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or email..."
                    class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                @if (request('search'))
                    <a href="{{ route('manage.ecommerce.customers.index', request()->except(['search', 'page'])) }}"
                        class="pr-3 text-muted hover:text-red-400 transition text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <select name="status" onchange="this.form.submit()"
                class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                <option value="">All Statuses</option>
                @foreach (['active', 'suspended', 'pending'] as $s)
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
                <a href="{{ route('manage.ecommerce.customers.index') }}"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-3 text-sm text-muted transition hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i>
                    Clear
                </a>
            @endif

        </form>

        {{-- ---------------
        -- Customers Table
        -- --------------- --}}
        <form id="bulk-delete-form" method="POST" action="{{ route('manage.ecommerce.customers.bulk-destroy') }}">
        @csrf
        @if ($canDelete)
            @include('manage.partials.bulk-delete', ['noun' => 'customers', 'warning' => 'Their orders, quotations and all other account data will be deleted too.'])
        @endif
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[720px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            @if ($canDelete)
                                <th class="w-10 px-4 py-3"><input type="checkbox" class="bulk-check-all" aria-label="Select all customers"></th>
                            @endif
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Phone</th>
                            <th class="px-4 py-3">Registered</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($customers as $customer)
                            @php
                                // ---------------
                                // Status badge colours - su_users.status
                                // ---------------
                                $statusColors = [
                                    'active'    => 'bg-emerald-100 text-emerald-800',
                                    'suspended' => 'bg-rose-100 text-rose-800',
                                    'pending'   => 'bg-amber-100 text-amber-800',
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('manage.ecommerce.customers.show', $customer->id) }}'"  >
                                @if ($canDelete)
                                    <td class="px-4 py-4" onclick="event.stopPropagation()">
                                        <input type="checkbox" name="ids[]" value="{{ $customer->id }}" class="bulk-check" aria-label="Select customer">
                                    </td>
                                @endif
                                <td class="px-4 py-4">
                                    <div class="font-medium text-black">
                                        {{ $customer->first_name }} {{ $customer->last_name }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-black">{{ $customer->email }}</td>
                                <td class="px-4 py-4 text-sm text-black">{{ $customer->phone ?? '-' }}</td>
                                <td class="px-4 py-4 text-xs text-muted whitespace-nowrap">
                                    {{ $customer->created_at?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                                        {{ $statusColors[$customer->status] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($customer->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right" onclick="event.stopPropagation()">
                                    <a href="{{ route('manage.ecommerce.customers.show', $customer->id) }}"
                                        title="View Customer"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $canDelete ? 7 : 6 }}" class="px-4 py-12 text-center text-sm text-muted">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="fa-solid fa-users text-3xl text-slate-300"></i>
                                        <span>No customers found. Try adjusting your filters.</span>
                                        @if (request()->hasAny(['search', 'status']))
                                            <a href="{{ route('manage.ecommerce.customers.index') }}"
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
        </form>

        {{-- ---------------
        -- Pagination
        -- --------------- --}}
        <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-muted">
                Showing {{ $customers->firstItem() ?? 0 }} â€“ {{ $customers->lastItem() ?? 0 }}
                of {{ $customers->total() }} customers
            </p>
            <div>{{ $customers->links() }}</div>
        </div>

    </div>

@endsection
