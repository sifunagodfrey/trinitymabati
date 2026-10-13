@extends('manage.layouts.app')

@section('title', 'Shipping Settings - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.shipping.settings.index') }}" class="hover:text-primary">Shipping</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Settings</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Shipping Settings</h1>
                <p class="text-sm text-muted">Configure the shipping cost formula and global delivery preferences.</p>
            </div>
            <a href="{{ route('manage.shipping.pricing.index') }}"
                class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm text-muted transition hover:bg-slate-100">
                <i class="fa-solid fa-map-location-dot"></i>
                Location Pricing
            </a>
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
    -- Formula Explanation Banner
    -- --------------- --}}
    <div class="mb-6 rounded-[12px] border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900">
        <p class="font-semibold mb-1">Shipping Formula</p>
        <code class="block text-xs font-mono mb-2 bg-blue-100 rounded-[8px] px-3 py-1 inline-block">
            Total = Base Rate + Weight Charges + Volume Charges + Distance Charges
        </code>
        <ul class="text-xs list-disc list-inside space-y-0.5 mt-1">
            <li>Weight Charges: If weight &gt; threshold, (weight &minus; threshold) &times; weight rate</li>
            <li>Volume Charges: (volume cm&sup3; &divide; divisor) &times; multiplier</li>
            <li>Distance Charges: (distance &minus; 10 km) &times; distance rate &mdash; applied only when distance &gt; 10 km</li>
        </ul>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ---------------
        -- Settings Form
        -- --------------- --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-black mb-5">Formula Configuration</h2>

            <form method="POST" action="{{ route('manage.shipping.settings.update') }}">
                @csrf

                {{-- Base Rate --}}
                <div class="mb-4">
                    <label for="base_rate" class="block text-sm font-medium text-black mb-1">Base Rate (KES)</label>
                    <input type="number" id="base_rate" name="base_rate" step="0.01" min="0"
                        value="{{ old('base_rate', $settings->base_rate) }}"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary"
                        required>
                    @error('base_rate')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Weight Threshold --}}
                <div class="mb-4">
                    <label for="weight_threshold" class="block text-sm font-medium text-black mb-1">Weight Threshold (kg)</label>
                    <input type="number" id="weight_threshold" name="weight_threshold" step="0.1" min="0"
                        value="{{ old('weight_threshold', $settings->weight_threshold) }}"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                    @error('weight_threshold')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Weight Rate --}}
                <div class="mb-4">
                    <label for="weight_rate" class="block text-sm font-medium text-black mb-1">Rate per Kg Above Threshold (KES)</label>
                    <input type="number" id="weight_rate" name="weight_rate" step="0.01" min="0"
                        value="{{ old('weight_rate', $settings->weight_rate) }}"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                    @error('weight_rate')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Volume Divisor --}}
                <div class="mb-4">
                    <label for="volume_divisor" class="block text-sm font-medium text-black mb-1">Volume Divisor (cm&sup3;)</label>
                    <input type="number" id="volume_divisor" name="volume_divisor" min="1"
                        value="{{ old('volume_divisor', $settings->volume_divisor) }}"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                    @error('volume_divisor')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Volume Multiplier --}}
                <div class="mb-4">
                    <label for="volume_multiplier" class="block text-sm font-medium text-black mb-1">Volume Multiplier</label>
                    <input type="number" id="volume_multiplier" name="volume_multiplier" step="0.01" min="0"
                        value="{{ old('volume_multiplier', $settings->volume_multiplier) }}"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                    @error('volume_multiplier')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Distance Rate --}}
                <div class="mb-4">
                    <label for="distance_rate" class="block text-sm font-medium text-black mb-1">Rate per Km Beyond 10 km (KES)</label>
                    <input type="number" id="distance_rate" name="distance_rate" step="0.01" min="0"
                        value="{{ old('distance_rate', $settings->distance_rate) }}"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                    @error('distance_rate')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Distance Note --}}
                <div class="mb-4">
                    <label for="distance_note" class="block text-sm font-medium text-black mb-1">
                        Distance Charge Notes <span class="text-muted font-normal">(optional)</span>
                    </label>
                    <textarea id="distance_note" name="distance_note" rows="2"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary resize-none">{{ old('distance_note', $settings->distance_note) }}</textarea>
                    @error('distance_note')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Free Shipping Threshold --}}
                <div class="mb-4">
                    <label for="free_shipping_threshold" class="block text-sm font-medium text-black mb-1">Free Shipping Threshold (KES)</label>
                    <input type="number" id="free_shipping_threshold" name="free_shipping_threshold" min="0"
                        value="{{ old('free_shipping_threshold', $settings->free_shipping_threshold) }}"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                    @error('free_shipping_threshold')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tracking Enabled --}}
                <div class="mb-6">
                    <label for="tracking_enabled" class="block text-sm font-medium text-black mb-1">Enable Shipping Tracking</label>
                    <select id="tracking_enabled" name="tracking_enabled"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                        <option value="1" {{ old('tracking_enabled', $settings->tracking_enabled) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('tracking_enabled', $settings->tracking_enabled) ? 'selected' : '' }}>No</option>
                    </select>
                    @error('tracking_enabled')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('manage.shipping.settings.index') }}"
                        class="inline-flex items-center gap-2 rounded-[12px] border border-border px-4 py-2.5 text-sm text-muted transition hover:bg-slate-100">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save Settings
                    </button>
                </div>

            </form>
        </div>

        {{-- ---------------
        -- Test Formula Calculator (Alpine.js - client-side)
        -- --------------- --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm"
             x-data="{
                weight: '',
                volume: '',
                distance: '',
                result: null,
                base:        {{ (float) $settings->base_rate }},
                wThreshold:  {{ (float) $settings->weight_threshold }},
                wRate:       {{ (float) $settings->weight_rate }},
                vDivisor:    {{ (float) ($settings->volume_divisor ?: 1) }},
                vMultiplier: {{ (float) $settings->volume_multiplier }},
                dRate:       {{ (float) $settings->distance_rate }},
                calculate() {
                    const w = parseFloat(this.weight)   || 0;
                    const v = parseFloat(this.volume)   || 0;
                    const d = parseFloat(this.distance) || 0;
                    const wCharge = w > this.wThreshold
                        ? (w - this.wThreshold) * this.wRate
                        : 0;
                    const vCharge = this.vDivisor > 0
                        ? (v / this.vDivisor) * this.vMultiplier
                        : 0;
                    const dCharge = d > 10
                        ? (d - 10) * this.dRate
                        : 0;
                    const total = this.base + wCharge + vCharge + dCharge;
                    this.result = {
                        total:    total.toFixed(2),
                        base:     this.base.toFixed(2),
                        weight:   wCharge.toFixed(2),
                        volume:   vCharge.toFixed(2),
                        distance: dCharge.toFixed(2),
                    };
                }
             }">

            <h2 class="text-base font-semibold text-black mb-1">Test Shipping Formula</h2>
            <p class="text-sm text-muted mb-5">
                Calculate an estimated shipping cost using the currently saved formula values.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">

                <div>
                    <label class="block text-sm font-medium text-black mb-1">Weight (kg)</label>
                    <input type="number" x-model="weight" step="0.1" min="0" placeholder="e.g. 3"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-black mb-1">Volume (cm&sup3;)</label>
                    <input type="number" x-model="volume" min="0" placeholder="e.g. 2000"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-black mb-1">Distance (km)</label>
                    <input type="number" x-model="distance" step="0.1" min="0" placeholder="e.g. 25"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                </div>

            </div>

            <button type="button" @click="calculate()"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-calculator"></i>
                Calculate
            </button>

            <template x-if="result">
                <div class="mt-5 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4">
                    <p class="text-sm font-semibold text-emerald-900 mb-3">
                        Estimated Cost: KES <span x-text="result.total" class="text-lg"></span>
                    </p>
                    <div class="grid grid-cols-2 gap-x-8 gap-y-1 text-xs text-emerald-800">
                        <span>Base Rate</span>
                        <span class="font-medium text-right">KES <span x-text="result.base"></span></span>
                        <span>Weight Charge</span>
                        <span class="font-medium text-right">KES <span x-text="result.weight"></span></span>
                        <span>Volume Charge</span>
                        <span class="font-medium text-right">KES <span x-text="result.volume"></span></span>
                        <span>Distance Charge</span>
                        <span class="font-medium text-right">KES <span x-text="result.distance"></span></span>
                    </div>
                </div>
            </template>

        </div>

    </div>

@endsection
