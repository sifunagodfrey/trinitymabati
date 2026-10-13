@extends('manage.layouts.app')

@section('title', 'Location-Based Pricing - Trinity Mabati Factory Admin')

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
                <li class="text-black font-semibold">Location Pricing</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Location-Based Pricing</h1>
                <p class="text-sm text-muted">Set custom delivery fees per delivery location. These override default shipping settings.</p>
            </div>
            <a href="{{ route('manage.shipping.settings.index') }}"
                class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm text-muted transition hover:bg-slate-100">
                <i class="fa-solid fa-sliders"></i>
                Shipping Settings
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
    -- Add New Pricing Form
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
        <h2 class="text-base font-semibold text-black mb-5">Add New Delivery Location Pricing</h2>

        <form method="POST" action="{{ route('manage.shipping.pricing.store') }}">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">

                {{-- County --}}
                <div>
                    <label for="county_id" class="block text-sm font-medium text-black mb-1">County</label>
                    <select id="county_id" name="county_id"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary"
                        required>
                        <option value="" disabled selected>Select County</option>
                        @foreach ($counties as $county)
                            <option value="{{ $county->id }}"
                                {{ old('county_id') == $county->id ? 'selected' : '' }}>
                                {{ $county->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('county_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location Name --}}
                <div>
                    <label for="location_name" class="block text-sm font-medium text-black mb-1">Delivery Location Name</label>
                    <input type="text" id="location_name" name="location_name"
                        value="{{ old('location_name') }}"
                        placeholder="e.g. Kasarani, Ruaka, etc."
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary"
                        required>
                    @error('location_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-black mb-1">Price (KES)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0"
                        value="{{ old('price') }}"
                        placeholder="e.g. 200"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary"
                        required>
                    @error('price')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Distance --}}
                <div>
                    <label for="distance" class="block text-sm font-medium text-black mb-1">
                        Distance (km) <span class="text-muted font-normal">(optional)</span>
                    </label>
                    <input type="number" id="distance" name="distance" step="0.1" min="0"
                        value="{{ old('distance') }}"
                        placeholder="e.g. 15"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                    @error('distance')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estimated Delivery --}}
                <div>
                    <label for="estimated_delivery" class="block text-sm font-medium text-black mb-1">
                        Estimated Delivery (days) <span class="text-muted font-normal">(optional)</span>
                    </label>
                    <input type="number" id="estimated_delivery" name="estimated_delivery" min="1"
                        value="{{ old('estimated_delivery') }}"
                        placeholder="e.g. 2"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                    @error('estimated_delivery')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('manage.shipping.pricing.index') }}"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border px-4 py-2.5 text-sm text-muted transition hover:bg-slate-100">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                    <i class="fa-solid fa-plus"></i>
                    Save Pricing
                </button>
            </div>

        </form>
    </div>

    {{-- ---------------
    -- Existing Pricing Table
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] shadow-sm overflow-hidden">

        {{-- Table Header: Filters --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between p-5 border-b border-border">
            <h2 class="text-base font-semibold text-black">Existing Delivery Pricing</h2>

            <form method="GET" action="{{ route('manage.shipping.pricing.index') }}"
                class="flex flex-wrap items-center gap-2">

                {{-- County Filter --}}
                <select name="county" onchange="this.form.submit()"
                    class="rounded-[12px] border border-border bg-white px-3 py-2 text-sm text-black outline-none transition focus:border-primary">
                    <option value="">All Counties</option>
                    @foreach ($counties as $county)
                        <option value="{{ $county->id }}"
                            {{ request('county') == $county->id ? 'selected' : '' }}>
                            {{ $county->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Sort --}}
                <select name="sort" onchange="this.form.submit()"
                    class="rounded-[12px] border border-border bg-white px-3 py-2 text-sm text-black outline-none transition focus:border-primary">
                    <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>Sort A–Z</option>
                    <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Sort Z–A</option>
                </select>

                {{-- Search --}}
                <div class="relative w-full sm:w-auto">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-muted text-xs"></i>
                    <input type="search" name="search" id="pricingSearch"
                        value="{{ request('search') }}"
                        placeholder="Search location…"
                        class="rounded-[12px] border border-border bg-white pl-8 pr-4 py-2 text-sm text-black outline-none transition focus:border-primary w-full sm:w-48">
                </div>

            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[720px]" id="pricingTable">
                <thead class="bg-slate-50 border-b border-border">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">County</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">Location</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">Price (KES)</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">Distance (km)</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">Delivery (days)</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-muted uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($pricingEntries as $entry)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3 text-black">{{ $entry->county_name }}</td>
                            <td class="px-5 py-3 text-black">{{ $entry->location_name }}</td>
                            <td class="px-5 py-3 text-black font-medium">{{ number_format($entry->price, 2) }}</td>
                            <td class="px-5 py-3 text-muted">{{ $entry->distance ?? '-' }}</td>
                            <td class="px-5 py-3 text-muted">{{ $entry->estimated_delivery ?? '-' }}</td>
                            <td class="px-5 py-3 text-right">
                                <form method="POST"
                                    action="{{ route('manage.shipping.pricing.destroy', $entry->id) }}"
                                    onsubmit="return confirm('Delete pricing for {{ addslashes($entry->location_name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 rounded-[8px] border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 transition hover:bg-red-100">
                                        <i class="fa-solid fa-trash-can"></i>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-sm text-muted">
                                No pricing entries found.
                                {{ request('county') || request('search') ? 'Try adjusting your filters.' : 'Add one above to get started.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ---------------
        -- Pagination
        -- --------------- --}}
        @if ($pricingEntries->hasPages())
            <div class="px-5 py-4 border-t border-border flex items-center justify-between text-sm text-muted">
                <span>
                    Showing {{ $pricingEntries->firstItem() }}–{{ $pricingEntries->lastItem() }}
                    of {{ $pricingEntries->total() }} entries
                </span>
                <div class="flex items-center gap-1">
                    @if ($pricingEntries->onFirstPage())
                        <span class="rounded-[8px] border border-border px-3 py-1.5 text-xs opacity-40 cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $pricingEntries->previousPageUrl() }}"
                            class="rounded-[8px] border border-border px-3 py-1.5 text-xs transition hover:bg-slate-100">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    @endif

                    @foreach ($pricingEntries->getUrlRange(1, $pricingEntries->lastPage()) as $page => $url)
                        @if ($page == $pricingEntries->currentPage())
                            <span class="rounded-[8px] bg-primary px-3 py-1.5 text-xs font-medium text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="rounded-[8px] border border-border px-3 py-1.5 text-xs transition hover:bg-slate-100">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($pricingEntries->hasMorePages())
                        <a href="{{ $pricingEntries->nextPageUrl() }}"
                            class="rounded-[8px] border border-border px-3 py-1.5 text-xs transition hover:bg-slate-100">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="rounded-[8px] border border-border px-3 py-1.5 text-xs opacity-40 cursor-not-allowed">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif

    </div>

    {{-- ---------------
    -- Client-Side Search Script
    -- --------------- --}}
    <script>
        // ---------------
        // Live filter table rows by location name (client-side, on top of server search)
        // ---------------
        document.getElementById('pricingSearch').addEventListener('keyup', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#pricingTable tbody tr').forEach(function (row) {
                row.style.display = row.innerText.toLowerCase().includes(term) ? '' : 'none';
            });
        });
    </script>

@endsection
