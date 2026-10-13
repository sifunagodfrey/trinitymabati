@extends('manage.layouts.app')

@section('title', 'VAT Settings')
@section('meta-description', 'Configure VAT rate for Trinity Mabati Factory marketplace transactions.')

@section('content')
    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.settings.vat.index') }}" class="hover:text-primary">Settings</a></li>
                <li>/</li>
                <li class="text-black font-semibold">VAT Settings</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">VAT Configuration</h1>
                <p class="text-sm text-muted">
                    The rate set here is applied to product prices, vendor earnings, and checkout calculations across the platform.
                </p>
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
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ---------------
    -- Set New VAT Rate Form
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
        <h2 class="text-base font-semibold text-black mb-4">Set New VAT Rate</h2>

        <form method="POST" action="{{ route('manage.settings.vat.store') }}">
            @csrf

            <div class="max-w-sm mb-4">
                <label for="vat_rate" class="block text-sm font-medium text-black mb-1">VAT Rate (%)</label>
                <input type="number" step="0.01" min="0" max="100"
                       id="vat_rate" name="vat_rate"
                       value="{{ old('vat_rate', $activeVat?->rate ?? '16.00') }}"
                       class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                       required>
                <p class="mt-1 text-xs text-muted">Enter the VAT percentage (e.g., 16 for 16%).</p>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('manage.settings.vat.index') }}"
                   class="rounded-[8px] border border-border px-5 py-2 text-sm font-medium text-black hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                        class="rounded-[8px] bg-primary px-5 py-2 text-sm font-medium text-white hover:bg-primary-dark">
                    Save VAT Rate
                </button>
            </div>
        </form>
    </div>

    {{-- ---------------
    -- VAT History Table
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
        <h2 class="text-base font-semibold text-black mb-4">VAT History</h2>

        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
            <table class="min-w-[600px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Rate (%)</th>
                        <th class="px-4 py-3">Start Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($vatHistory as $row)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-medium text-black">{{ $row->id }}</td>
                            <td class="px-4 py-4 text-black">{{ $row->rate }}%</td>
                            <td class="px-4 py-4 text-black">{{ $row->start_date }}</td>
                            <td class="px-4 py-4">
                                @if ($row->is_active)
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800">Active</span>
                                @else
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-600">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-right">
                                @if (!$row->is_active)
                                    <form method="POST"
                                          action="{{ route('manage.settings.vat.apply', $row->id) }}"
                                          onsubmit="return confirm('Apply this VAT rate as the active one?');">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-[8px] border border-primary px-4 py-2 text-xs font-medium text-primary hover:bg-primary hover:text-white transition">
                                            Apply This
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-muted">In use</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-muted">No VAT history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
@endsection
