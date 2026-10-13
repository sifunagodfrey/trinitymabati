@extends('manage.layouts.app')

@section('title', 'Currency Settings')
@section('meta-description', 'Configure manual exchange rates for KES, USD, and EUR.')

@section('content')
    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.settings.currency.index') }}" class="hover:text-primary">Settings</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Currency Settings</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Currency Configuration</h1>
                <p class="text-sm text-muted">
                    Configure manual exchange rates relative to <strong>KES</strong>.
                    These settings affect product prices, vendor payouts, and checkout conversions.
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
    -- Update Currency Form
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6"
         x-data="currencyForm()">
        <h2 class="text-base font-semibold text-black mb-4">Update Exchange Rate</h2>

        <form method="POST" action="{{ route('manage.settings.currency.update') }}">
            @csrf

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">

                {{-- Currency Code --}}
                <div>
                    <label for="code" class="block text-sm font-medium text-black mb-1">Currency Code</label>
                    <select id="code" name="code" required
                            x-on:change="fillSymbol($event.target.value)"
                            class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                        <option value="">Select...</option>
                        <option value="KES" {{ old('code') === 'KES' ? 'selected' : '' }}>KES</option>
                        <option value="USD" {{ old('code') === 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="EUR" {{ old('code') === 'EUR' ? 'selected' : '' }}>EUR</option>
                    </select>
                    @error('code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Rate --}}
                <div>
                    <label for="rate" class="block text-sm font-medium text-black mb-1">Rate (per 1 KES)</label>
                    <input type="number" step="0.000001" min="0.000001" id="rate" name="rate"
                           value="{{ old('rate') }}" required
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                    @error('rate') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Symbol --}}
                <div>
                    <label for="symbol" class="block text-sm font-medium text-black mb-1">Symbol</label>
                    <input type="text" id="symbol" name="symbol"
                           value="{{ old('symbol') }}" placeholder="e.g. KSh, $, €"
                           x-ref="symbolInput"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                    @error('symbol') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Submit --}}
                <div class="flex items-end">
                    <button type="submit"
                            class="w-full rounded-[8px] bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark">
                        Save Currency
                    </button>
                </div>

            </div>
        </form>
    </div>

    {{-- ---------------
    -- Current Currency Settings Table
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
        <h2 class="text-base font-semibold text-black mb-4">Current Currency Settings</h2>

        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
            <table class="min-w-[600px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3">Rate (per 1 KES)</th>
                        <th class="px-4 py-3">Symbol</th>
                        <th class="px-4 py-3">Last Updated</th>
                        <th class="px-4 py-3">Updated By</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($currencySettings as $row)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-semibold text-black">{{ $row->code }}</td>
                            <td class="px-4 py-4 text-black">{{ $row->rate }}</td>
                            <td class="px-4 py-4 text-black">{{ $row->symbol }}</td>
                            <td class="px-4 py-4 text-black">{{ $row->updated_at?->format('d M Y, H:i') }}</td>
                            <td class="px-4 py-4 text-black">{{ $row->updatedBy?->name ?: 'System' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-muted">No currency settings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Currency Change Log Table
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
        <h2 class="text-base font-semibold text-black mb-4">Recent Currency Changes</h2>

        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
            <table class="min-w-[720px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Currency</th>
                        <th class="px-4 py-3">Old Rate</th>
                        <th class="px-4 py-3">New Rate</th>
                        <th class="px-4 py-3">Updated By</th>
                        <th class="px-4 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($currencyLogs as $log)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-medium text-black">{{ $log->id }}</td>
                            <td class="px-4 py-4 font-semibold text-black">{{ $log->currency_code }}</td>
                            <td class="px-4 py-4 text-black">{{ $log->old_rate ?? 'N/A' }}</td>
                            <td class="px-4 py-4 text-black">{{ $log->new_rate }}</td>
                            <td class="px-4 py-4 text-black">{{ $log->updatedBy?->name ?: 'System' }}</td>
                            <td class="px-4 py-4 text-black">{{ $log->created_at?->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-muted">No changes logged.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- ---------------
    -- Auto-fill symbol when currency code is selected
    -- --------------- --}}
    <script>
        function currencyForm() {
            return {
                fillSymbol(code) {
                    const symbols = { KES: 'KSh', USD: '$', EUR: '€' };
                    this.$refs.symbolInput.value = symbols[code] ?? '';
                }
            };
        }
    </script>
@endpush
