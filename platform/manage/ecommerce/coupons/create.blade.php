{{-- -------------------
     Admin Coupons - Create
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'Add Coupon Code - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.coupons.index') }}" class="hover:text-primary">Coupon Codes</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Add Coupon</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('manage.ecommerce.coupons.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-black">Add Coupon Code</h1>
                <p class="text-sm text-muted">Create a new promotional code for customers.</p>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Session Alerts
    -- --------------- --}}
    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('manage.ecommerce.coupons.store') }}"
          class="bg-background border border-border rounded-[12px] p-6 shadow-sm space-y-6">
        @csrf

        <div class="grid gap-5 sm:grid-cols-2">

            {{-- Code --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                    Code <span class="text-rose-500">*</span>
                </label>
                <div class="flex gap-2">
                    <input type="text" name="code" id="coupon-code" value="{{ old('code') }}" required
                        placeholder="e.g. SAVE20"
                        class="flex-1 rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black uppercase outline-none focus:border-primary @error('code') border-red-400 @enderror" />
                    <button type="button" onclick="generateCode()"
                        class="inline-flex items-center gap-1.5 rounded-[12px] border border-border bg-background px-3 py-2.5 text-xs font-medium text-muted transition hover:bg-slate-100">
                        <i class="fa-solid fa-arrows-rotate"></i>
                        Auto
                    </button>
                </div>
                @error('code')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                    Discount Type <span class="text-rose-500">*</span>
                </label>
                <select name="discount_type" required
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary @error('discount_type') border-red-400 @enderror">
                    <option value="percent" {{ old('discount_type') === 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                    <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Fixed Amount (KES)</option>
                </select>
                @error('discount_type')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Value --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                    Discount Value <span class="text-rose-500">*</span>
                </label>
                <input type="number" name="value" value="{{ old('value') }}" required min="0" step="0.01"
                    placeholder="e.g. 20 for 20% or 500 for KES 500"
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary @error('value') border-red-400 @enderror" />
                @error('value')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Usage Limit --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-muted uppercase tracking-wide">Usage Limit</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" min="1"
                    placeholder="Leave blank for unlimited"
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
                <p class="text-xs text-muted">Leave blank for unlimited uses.</p>
            </div>

            {{-- Start Date --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-muted uppercase tracking-wide">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}"
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
            </div>

            {{-- End Date --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-muted uppercase tracking-wide">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}"
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
            </div>

            {{-- Status --}}
            <div class="flex flex-col gap-1 sm:col-span-2">
                <label class="text-xs font-semibold text-muted uppercase tracking-wide">Status</label>
                <select name="status"
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary">
                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

        </div>

        {{-- ---------------
        -- Form Actions
        -- --------------- --}}
        <div class="flex items-center justify-end gap-3 pt-2 border-t border-border">
            <a href="{{ route('manage.ecommerce.coupons.index') }}"
                class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-5 py-2.5 text-sm font-medium text-muted transition hover:bg-slate-100">
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-floppy-disk"></i>
                Save Code
            </button>
        </div>

    </form>

@endsection

@push('scripts')
<script>
// ---------------
// Auto-generate coupon code
// ---------------
function generateCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = 'NAW';
    for (let i = 0; i < 6; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('coupon-code').value = code;
}
</script>
@endpush
