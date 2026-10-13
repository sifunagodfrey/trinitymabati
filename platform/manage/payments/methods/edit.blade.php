@extends('manage.layouts.app')

@section('title', 'Edit Payment Method')
@section('meta-description', 'Edit settings for ' . $method->name)

@section('content')
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.payments.transactions.index') }}" class="hover:text-primary">Payments</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.payments.methods.index') }}" class="hover:text-primary">Payment Methods</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Edit: {{ $method->name }}</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Edit Payment Method</h1>
                <p class="text-sm text-muted">Update configuration and settings for {{ $method->name }}.</p>
            </div>
        </div>
    </div>

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
        <form method="POST" action="{{ route('manage.payments.methods.update', $method->id) }}">
            @csrf
            @method('PUT')

            {{-- Basic Information --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-black mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-black mb-1.5">Method Name</label>
                        <input type="text" name="name" value="{{ old('name', $method->name) }}"
                               class="w-full rounded-[8px] border border-border bg-white px-3 py-2.5 text-sm text-black outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                               required>
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-black mb-1.5">Slug (read-only)</label>
                        <input type="text" value="{{ $method->slug }}" disabled
                               class="w-full rounded-[8px] border border-border bg-slate-50 px-3 py-2.5 text-sm text-slate-500">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-black mb-1.5">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full rounded-[8px] border border-border bg-white px-3 py-2.5 text-sm text-black outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">{{ old('description', $method->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4 flex items-center gap-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               @checked(old('is_active', $method->is_active))
                               class="w-4 h-4 text-primary border-border rounded focus:ring-primary">
                    </div>
                    <label for="is_active" class="text-sm text-black">Enable this payment method</label>
                </div>

                <div class="mt-4 flex items-start gap-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_default" id="is_default" value="1"
                               @checked(old('is_default', $method->is_default))
                               class="w-4 h-4 text-primary border-border rounded focus:ring-primary">
                    </div>
                    <label for="is_default" class="text-sm text-black">
                        Set as default payment method
                        <span class="block text-xs text-muted mt-0.5">Pre-selected on the checkout payment page. Only one method can be the default, and it must be enabled.</span>
                    </label>
                </div>
            </div>

            {{-- Configuration Fields --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-black mb-4">Configuration</h3>
                <p class="text-sm text-muted mb-4">Add key-value pairs required for this payment gateway (e.g., API keys, URLs).</p>

                <div id="configFields" class="space-y-3">
                    @forelse(($method->config ?? []) as $key => $value)
                        <div class="config-row flex flex-wrap items-center gap-3">
                            <div class="flex-1 min-w-[150px]">
                                <input type="text" name="config_key[]" value="{{ $key }}"
                                       class="w-full rounded-[8px] border border-border bg-white px-3 py-2.5 text-sm text-black outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                       placeholder="Key (e.g., api_key)">
                            </div>
                            <div class="flex-[2] min-w-[200px]">
                                <input type="text" name="config_value[]" value="{{ $value }}"
                                       class="w-full rounded-[8px] border border-border bg-white px-3 py-2.5 text-sm text-black outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                       placeholder="Value">
                            </div>
                            <button type="button" class="remove-field text-red-500 hover:text-red-700 transition">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    @empty
                        <div class="config-row flex flex-wrap items-center gap-3">
                            <div class="flex-1 min-w-[150px]">
                                <input type="text" name="config_key[]" class="w-full rounded-[8px] border border-border bg-white px-3 py-2.5 text-sm text-black outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition" placeholder="Key (e.g., api_key)">
                            </div>
                            <div class="flex-[2] min-w-[200px]">
                                <input type="text" name="config_value[]" class="w-full rounded-[8px] border border-border bg-white px-3 py-2.5 text-sm text-black outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition" placeholder="Value">
                            </div>
                            <button type="button" class="remove-field text-red-500 hover:text-red-700 transition">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    @endforelse
                </div>

                <button type="button" id="addConfigBtn"
                        class="mt-3 inline-flex items-center gap-2 rounded-[8px] bg-slate-100 px-4 py-2 text-sm font-medium text-black hover:bg-slate-200 transition">
                    <i class="fa-solid fa-plus"></i> Add Configuration Field
                </button>
            </div>

            {{-- User Input Fields (for frontend checkout) --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-black mb-4">Checkout User Input</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-black mb-1.5">Input Field Label</label>
                        <input type="text" name="user_input_label" value="{{ old('user_input_label', $method->user_input_label) }}"
                               class="w-full rounded-[8px] border border-border bg-white px-3 py-2.5 text-sm text-black outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                               placeholder="e.g., M-Pesa number, Email address">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-black mb-1.5">Input Field Description</label>
                        <input type="text" name="user_input_description" value="{{ old('user_input_description', $method->user_input_description) }}"
                               class="w-full rounded-[8px] border border-border bg-white px-3 py-2.5 text-sm text-black outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                               placeholder="Helper text shown below the input">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-black mb-1.5">Thumbnail (icon path/URL)</label>
                    <input type="text" name="thumbnail" value="{{ old('thumbnail', $method->thumbnail) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-3 py-2.5 text-sm text-black outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                           placeholder="e.g., mpesa-logo.png">
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center gap-3 pt-4 border-t border-border">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-[8px] bg-primary px-6 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                    <i class="fa-solid fa-floppy-disk"></i> Save Changes
                </button>
                <a href="{{ route('manage.payments.methods.index') }}"
                   class="inline-flex items-center gap-2 rounded-[8px] border border-border bg-white px-6 py-2.5 text-sm font-medium text-black transition hover:bg-slate-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.getElementById('addConfigBtn').addEventListener('click', function() {
            const container = document.getElementById('configFields');
            const row = document.createElement('div');
            row.className = 'config-row flex flex-wrap items-center gap-3';
            row.innerHTML = `
                <div class="flex-1 min-w-[150px]">
                    <input type="text" name="config_key[]" class="w-full rounded-[8px] border border-border bg-white px-3 py-2.5 text-sm text-black outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition" placeholder="Key (e.g., api_key)">
                </div>
                <div class="flex-[2] min-w-[200px]">
                    <input type="text" name="config_value[]" class="w-full rounded-[8px] border border-border bg-white px-3 py-2.5 text-sm text-black outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition" placeholder="Value">
                </div>
                <button type="button" class="remove-field text-red-500 hover:text-red-700 transition">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `;
            container.appendChild(row);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-field') || e.target.closest('.remove-field')) {
                const btn = e.target.closest('.remove-field');
                if (btn) {
                    btn.closest('.config-row').remove();
                }
            }
        });
    </script>
    @endpush
@endsection