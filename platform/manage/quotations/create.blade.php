@extends('manage.layouts.app')

@section('title', 'New Quotation - Admin')

@section('content')

    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.quotations.index') }}" class="hover:text-primary">Quotations</a></li>
                <li>/</li>
                <li class="text-black font-semibold">New</li>
            </ol>
        </nav>

        <h1 class="text-2xl font-semibold text-black">New Quotation</h1>
        <p class="text-sm text-muted">Build an itemized quote for a customer.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('manage.quotations.store') }}" x-data="quotationForm()">
        @csrf

        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-black mb-1">Customer</label>
                    <select id="user_id" name="user_id" required
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                        <option value="" disabled selected>Select customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                {{ trim($customer->first_name . ' ' . $customer->last_name) }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="valid_until" class="block text-sm font-medium text-black mb-1">
                        Valid Until <span class="text-muted font-normal">(optional)</span>
                    </label>
                    <input type="date" id="valid_until" name="valid_until" value="{{ old('valid_until') }}"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-black mb-1">
                    Notes <span class="text-muted font-normal">(optional)</span>
                </label>
                <textarea id="notes" name="notes" rows="2"
                    class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-black">Line Items</h2>
                <button type="button" @click="addItem()"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border px-3 py-2 text-sm text-black transition hover:bg-slate-100">
                    <i class="fa-solid fa-plus"></i>
                    Add Item
                </button>
            </div>

            <template x-for="(item, index) in items" :key="index">
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 mb-3 items-start">
                    <div class="sm:col-span-5">
                        <input type="text" :name="`items[${index}][item_name]`" x-model="item.item_name"
                            placeholder="Item description" required
                            class="w-full rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none transition focus:border-primary">
                    </div>
                    <div class="sm:col-span-3">
                        <select :name="`items[${index}][product_id]`" x-model="item.product_id"
                            @change="onProductChange(index)"
                            class="w-full rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none transition focus:border-primary">
                            <option value="">Custom item (no catalog link)</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->sale_price ?? $product->price }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <input type="number" :name="`items[${index}][quantity]`" x-model.number="item.quantity"
                            min="1" placeholder="Qty" required
                            class="w-full rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none transition focus:border-primary">
                    </div>
                    <div class="sm:col-span-1">
                        <input type="number" :name="`items[${index}][unit_price]`" x-model.number="item.unit_price"
                            min="0" step="0.01" placeholder="Price" required
                            class="w-full rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none transition focus:border-primary">
                    </div>
                    <div class="sm:col-span-1 flex items-center h-full">
                        <button type="button" @click="removeItem(index)"
                            class="rounded-[8px] border border-red-200 bg-red-50 px-3 py-2.5 text-xs text-red-700 transition hover:bg-red-100">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="tax" class="block text-sm font-medium text-black mb-1">
                        Tax (KES) <span class="text-muted font-normal">(optional)</span>
                    </label>
                    <input type="number" id="tax" name="tax" min="0" step="0.01" value="{{ old('tax', 0) }}"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                </div>
                <div>
                    <label for="discount" class="block text-sm font-medium text-black mb-1">
                        Discount (KES) <span class="text-muted font-normal">(optional)</span>
                    </label>
                    <input type="number" id="discount" name="discount" min="0" step="0.01" value="{{ old('discount', 0) }}"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                </div>
            </div>
            <p class="text-sm text-muted mt-4">
                Subtotal: KES <span x-text="subtotal().toLocaleString(undefined, {minimumFractionDigits: 2})"></span>
            </p>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('manage.quotations.index') }}"
                class="inline-flex items-center gap-2 rounded-[12px] border border-border px-4 py-2.5 text-sm text-muted transition hover:bg-slate-100">
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-check"></i>
                Save Quotation
            </button>
        </div>
    </form>

    <script>
        function quotationForm() {
            return {
                items: [
                    { item_name: '', product_id: '', quantity: 1, unit_price: 0 }
                ],
                addItem() {
                    this.items.push({ item_name: '', product_id: '', quantity: 1, unit_price: 0 });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                onProductChange(index) {
                    const select = event.target;
                    const option = select.options[select.selectedIndex];
                    if (option && option.dataset.name) {
                        this.items[index].item_name = option.dataset.name;
                        this.items[index].unit_price = parseFloat(option.dataset.price || 0);
                    }
                },
                subtotal() {
                    return this.items.reduce((sum, item) => sum + (item.quantity * item.unit_price || 0), 0);
                }
            }
        }
    </script>

@endsection
