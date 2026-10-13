@extends('manage.layouts.app')

@section('title', 'Initiate Return - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.returns.index') }}" class="hover:text-primary">Order Returns</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Initiate Return</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('manage.ecommerce.returns.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-black">Initiate Return</h1>
                <p class="text-sm text-muted">Look up an order and log a return on behalf of a customer.</p>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Validation Errors
    -- --------------- --}}
    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            <p class="font-semibold mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ---------------
    -- Alpine.js Return Form
    -- --------------- --}}
    <div x-data="returnForm()" class="space-y-6">

        {{-- ---------------
        -- Step 1: Order Lookup
        -- --------------- --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-black mb-4">
                <i class="fa-solid fa-magnifying-glass text-muted mr-2"></i>Step 1 - Look Up Order
            </h2>

            <div class="flex flex-wrap items-start gap-3">
                <div class="flex-1 min-w-[260px] flex flex-col gap-1">
                    <label class="text-xs font-semibold text-muted uppercase tracking-wide">Order Code</label>
                    <input type="text" x-model="orderCode" @keyup.enter="lookupOrder"
                        placeholder="e.g. NAW20250707123045321"
                        class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary uppercase"
                        :class="{ 'border-red-400': lookupError }" />
                    <p x-show="lookupError" class="text-xs text-red-600" x-text="lookupError"></p>
                </div>

                <div class="pt-6">
                    <button type="button" @click="lookupOrder"
                        :disabled="loading"
                        class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark disabled:opacity-50">
                        <i class="fa-solid fa-search" :class="{ 'fa-spin': loading }"></i>
                        <span x-text="loading ? 'Looking up…' : 'Look Up'"></span>
                    </button>
                </div>
            </div>
        </div>

        {{-- ---------------
        -- Step 2: Return Details (shown after order is found)
        -- --------------- --}}
        <template x-if="order">
            <form method="POST" action="{{ route('manage.ecommerce.returns.store') }}"
                  class="space-y-6">
                @csrf

                {{-- Hidden order & customer fields --}}
                <input type="hidden" name="order_id" :value="order.id">
                <input type="hidden" name="user_id"  :value="customer.id">

                {{-- ---------------
                -- Order & Customer Summary
                -- --------------- --}}
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-black mb-4">
                        <i class="fa-solid fa-receipt text-muted mr-2"></i>Step 2 - Order & Customer
                    </h2>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-2 text-sm">
                            <p class="text-xs font-semibold text-muted uppercase tracking-wide mb-2">Order</p>
                            <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                                <span class="text-muted">Order Code</span>
                                <span class="font-mono font-semibold text-black" x-text="order.order_code"></span>
                            </div>
                            <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                                <span class="text-muted">Order ID</span>
                                <span class="font-medium text-black" x-text="'#' + order.id"></span>
                            </div>
                        </div>

                        <div class="space-y-2 text-sm">
                            <p class="text-xs font-semibold text-muted uppercase tracking-wide mb-2">Customer</p>
                            <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                                <span class="text-muted">Name</span>
                                <span class="font-medium text-black" x-text="customer.name"></span>
                            </div>
                            <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                                <span class="text-muted">Email</span>
                                <span class="font-medium text-black" x-text="customer.email"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ---------------
                -- Step 3: Return Fields
                -- --------------- --}}
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm space-y-5">
                    <h2 class="text-base font-semibold text-black">
                        <i class="fa-solid fa-rotate-left text-muted mr-2"></i>Step 3 - Return Details
                    </h2>

                    {{-- Product Selection --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                            Product Being Returned <span class="text-rose-500">*</span>
                        </label>
                        <select name="product_id" required data-no-search
                            class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary @error('product_id') border-red-400 @enderror">
                            <option value="">- Select a product from this order -</option>
                            <template x-for="item in items" :key="item.product_id">
                                <option :value="item.product_id"
                                    :selected="'{{ old('product_id') }}' == item.product_id"
                                    x-text="item.product_name + (item.variant_label ? ' (' + item.variant_label + ')' : '') + ' - Qty: ' + item.quantity">
                                </option>
                            </template>
                        </select>
                        @error('product_id')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Return Reason --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                            Return Reason <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="reason" rows="4" required maxlength="1000"
                            placeholder="Describe the reason for the return…"
                            class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary resize-none @error('reason') border-red-400 @enderror">{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Initial Status --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                            Initial Status <span class="text-rose-500">*</span>
                        </label>
                        <select name="status" required
                            class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary @error('status') border-red-400 @enderror">
                            <option value="requested" {{ old('status', 'requested') === 'requested' ? 'selected' : '' }}>Requested</option>
                            <option value="approved"  {{ old('status') === 'approved'  ? 'selected' : '' }}>Approved</option>
                            <option value="rejected"  {{ old('status') === 'rejected'  ? 'selected' : '' }}>Rejected</option>
                            <option value="refunded"  {{ old('status') === 'refunded'  ? 'selected' : '' }}>Refunded</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ---------------
                    -- Form Actions
                    -- --------------- --}}
                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-border">
                        <a href="{{ route('manage.ecommerce.returns.index') }}"
                            class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-5 py-2.5 text-sm font-medium text-muted transition hover:bg-slate-100">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Submit Return
                        </button>
                    </div>
                </div>

            </form>
        </template>

    </div>

@endsection

@push('scripts')
<script>
// ---------------
// Alpine.js component for order lookup and return form
// ---------------
function returnForm() {
    return {
        orderCode: '{{ old('order_code', '') }}',
        loading: false,
        lookupError: null,
        order: null,
        customer: null,
        items: [],

        async lookupOrder() {
            const code = this.orderCode.trim().toUpperCase();
            if (!code) {
                this.lookupError = 'Please enter an order code.';
                return;
            }

            this.loading = true;
            this.lookupError = null;
            this.order = null;
            this.customer = null;
            this.items = [];

            try {
                const response = await fetch(
                    '{{ route('manage.ecommerce.returns.order-items') }}?order_code=' + encodeURIComponent(code),
                    { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } }
                );

                const data = await response.json();

                if (!response.ok) {
                    this.lookupError = data.error ?? 'Order not found.';
                    return;
                }

                if (!data.items || data.items.length === 0) {
                    this.lookupError = 'This order has no items.';
                    return;
                }

                this.order    = data.order;
                this.customer = data.customer;
                this.items    = data.items;

            } catch (e) {
                this.lookupError = 'An error occurred while looking up the order. Please try again.';
            } finally {
                this.loading = false;
            }
        },
    };
}
</script>
@endpush
