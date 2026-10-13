@extends('manage.layouts.app')

@section('title', 'Adjust Loyalty Points')

@section('content')

    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.loyalty.members.index') }}" class="hover:text-primary">Loyalty Points</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Adjust Points</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('manage.loyalty.members.index') }}"
               class="inline-flex items-center gap-1 text-sm text-muted hover:text-primary transition">
                <i class="fas fa-arrow-left text-xs"></i> Back
            </a>
        </div>

        <h1 class="text-2xl font-semibold text-black">Adjust Loyalty Points</h1>
        <p class="text-sm text-muted">
            Manually add or deduct points for a specific client. All adjustments are logged in the transactions audit trail.
        </p>
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
    -- Adjust Form
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm max-w-xl">
        <form method="POST" action="{{ route('manage.loyalty.adjust.store') }}">
            @csrf

            <div class="space-y-5 mb-6">

                {{-- User ID --}}
                <div>
                    <label for="user_id" class="block text-sm font-medium text-black mb-1">
                        User ID <span class="text-red-500">*</span>
                    </label>
                    <input type="number" min="1" id="user_id" name="user_id"
                           value="{{ old('user_id', request('user_id')) }}"
                           placeholder="Enter the client's user ID"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                    <p class="mt-1 text-xs text-muted">You can find the user ID on the Customers or Members list.</p>
                </div>

                {{-- Adjustment Type --}}
                <div>
                    <label class="block text-sm font-medium text-black mb-2">
                        Adjustment Type <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="adjustment_type" value="add"
                                   {{ old('adjustment_type', 'add') === 'add' ? 'checked' : '' }}
                                   class="text-primary focus:ring-primary">
                            <span class="text-sm font-medium text-emerald-700">
                                <i class="fas fa-plus-circle mr-1"></i> Add Points
                            </span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="adjustment_type" value="deduct"
                                   {{ old('adjustment_type') === 'deduct' ? 'checked' : '' }}
                                   class="text-primary focus:ring-primary">
                            <span class="text-sm font-medium text-red-600">
                                <i class="fas fa-minus-circle mr-1"></i> Deduct Points
                            </span>
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-muted">
                        Adding points increments both balance and lifetime points (may trigger tier upgrade).
                        Deductions only reduce the redeemable balance.
                    </p>
                </div>

                {{-- Points amount --}}
                <div>
                    <label for="points" class="block text-sm font-medium text-black mb-1">
                        Points <span class="text-red-500">*</span>
                    </label>
                    <input type="number" min="1" id="points" name="points"
                           value="{{ old('points') }}"
                           placeholder="e.g. 100"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-black mb-1">
                        Reason / Description <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="description" name="description" maxlength="255"
                           value="{{ old('description') }}"
                           placeholder="e.g. Goodwill credit for delayed delivery"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                </div>

            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('manage.loyalty.members.index') }}"
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
