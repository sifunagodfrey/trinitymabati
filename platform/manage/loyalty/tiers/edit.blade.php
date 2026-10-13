@extends('manage.layouts.app')

@section('title', 'Edit Loyalty Tier - ' . $tier->name)

@section('content')

    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.loyalty.tiers.index') }}" class="hover:text-primary">Tiers</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Edit {{ $tier->name }}</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('manage.loyalty.tiers.index') }}"
               class="inline-flex items-center gap-1 text-sm text-muted hover:text-primary transition">
                <i class="fas fa-arrow-left text-xs"></i> Back
            </a>
        </div>

        <h1 class="text-2xl font-semibold text-black">Edit Tier: {{ $tier->name }}</h1>
        <p class="text-sm text-muted">Update thresholds, multipliers, and discount for this tier.</p>
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
    -- Edit Form
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
        <form method="POST" action="{{ route('manage.loyalty.tiers.update', $tier->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">

                <div>
                    <label for="name" class="block text-sm font-medium text-black mb-1">
                        Tier Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" maxlength="50"
                           value="{{ old('name', $tier->name) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                </div>

                <div>
                    <label for="min_points" class="block text-sm font-medium text-black mb-1">
                        Min Lifetime Points <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="min_points" name="min_points" min="0"
                           value="{{ old('min_points', $tier->min_points) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                    <p class="mt-1 text-xs text-muted">Lifetime points required to reach this tier.</p>
                </div>

                <div>
                    <label for="points_multiplier" class="block text-sm font-medium text-black mb-1">
                        Earn Multiplier <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" min="0.1" max="10"
                           id="points_multiplier" name="points_multiplier"
                           value="{{ old('points_multiplier', $tier->points_multiplier) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                    <p class="mt-1 text-xs text-muted">E.g. 1.5 = clients earn 1.5× base points per order.</p>
                </div>

                <div>
                    <label for="discount_percent" class="block text-sm font-medium text-black mb-1">
                        Auto Discount (%) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" min="0" max="100"
                           id="discount_percent" name="discount_percent"
                           value="{{ old('discount_percent', $tier->discount_percent) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                    <p class="mt-1 text-xs text-muted">Automatic order discount granted to all members in this tier.</p>
                </div>

                <div>
                    <label for="badge_icon" class="block text-sm font-medium text-black mb-1">Badge Icon Filename</label>
                    <input type="text" id="badge_icon" name="badge_icon" maxlength="100"
                           value="{{ old('badge_icon', $tier->badge_icon) }}"
                           placeholder="e.g. bronze-badge.svg"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                    <p class="mt-1 text-xs text-muted">Optional icon filename shown next to the tier name in the UI.</p>
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               class="h-4 w-4 rounded border-border text-primary focus:ring-primary"
                               {{ old('is_active', $tier->is_active) ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-black">Tier is Active</span>
                    </label>
                </div>

            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('manage.loyalty.tiers.index') }}"
                   class="rounded-[8px] border border-border px-5 py-2 text-sm font-medium text-black hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                        class="rounded-[8px] bg-primary px-5 py-2 text-sm font-medium text-white hover:bg-primary/90">
                    Save Tier
                </button>
            </div>
        </form>
    </div>

@endsection
