{{-- ---------------
-- Set / Update Delivery Address
-- --------------- --}}
@extends('client.layouts.app')

@section('title', 'Set Delivery Address | Haromi')

@section('content')

    {{-- ---------------
    -- Page Header
    -- --------------- --}}
    <div class="mb-6">
        <h2 class="text-lg font-bold text-gray-900">Set Delivery Address</h2>
        <p class="text-sm text-gray-500 mt-0.5">Select your county and the delivery location within it.</p>
    </div>

    {{-- ---------------
    -- Validation Errors
    -- --------------- --}}
    @if ($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-[8px] px-4 py-3 space-y-1">
            @foreach ($errors->all() as $error)
                <p class="flex items-start gap-2">
                    <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                    {{ $error }}
                </p>
            @endforeach
        </div>
    @endif

    {{-- ---------------
    -- Address Form
    -- --------------- --}}
    <div class="bg-white border border-gray-200 rounded-[8px] shadow-sm p-6 max-w-lg"
        x-data="addressForm()"
        x-init="init()">

        <form method="POST" action="{{ route('client.address.store') }}">
            @csrf

            {{-- ---------------
            -- County Select
            -- --------------- --}}
            <div class="mb-5">
                <label for="county_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                    County <span class="text-red-500">*</span>
                </label>
                <select
                    id="county_id"
                    name="county_id"
                    x-model="county_id"
                    @change="fetchLocations()"
                    class="w-full rounded-[8px] border border-gray-300 px-3 py-2.5 text-sm text-gray-900
                           focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent
                           bg-white">
                    <option value="">-- Select county --</option>
                    @foreach ($counties as $county)
                        <option value="{{ $county->id }}">{{ $county->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- ---------------
            -- Location Select (AJAX loaded)
            -- --------------- --}}
            <div class="mb-6">
                <label for="location_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Delivery Location <span class="text-red-500">*</span>
                </label>

                <p x-show="loading" class="text-sm text-gray-400 py-2.5">
                    <i class="fas fa-spinner fa-spin mr-1"></i> Loading locations…
                </p>

                <select
                    id="location_id"
                    name="location_id"
                    x-show="!loading"
                    x-model="location_id"
                    :disabled="!locations.length"
                    class="w-full rounded-[8px] border border-gray-300 px-3 py-2.5 text-sm text-gray-900
                           focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent
                           bg-white disabled:bg-gray-50 disabled:text-gray-400">
                    <template x-if="!county_id">
                        <option value="">-- Select a county first --</option>
                    </template>
                    <template x-if="county_id && !locations.length">
                        <option value="">-- No locations available --</option>
                    </template>
                    <template x-if="county_id && locations.length">
                        <option value="">-- Select location --</option>
                    </template>
                    <template x-for="loc in locations" :key="loc.id">
                        <option
                            :value="loc.id"
                            :selected="loc.id == preselectedLocationId"
                            x-text="loc.location_name">
                        </option>
                    </template>
                </select>

                {{-- Delivery info for selected location --}}
                <template x-if="selectedLocation">
                    <p class="mt-2 text-xs text-gray-500 flex items-center gap-3">
                        <span>
                            <i class="fas fa-truck text-gray-400 mr-0.5"></i>
                            KES <span x-text="parseFloat(selectedLocation.price).toLocaleString()"></span>
                        </span>
                        <template x-if="selectedLocation.estimated_delivery">
                            <span>
                                <i class="fas fa-clock text-gray-400 mr-0.5"></i>
                                ~<span x-text="selectedLocation.estimated_delivery"></span> day(s)
                            </span>
                        </template>
                    </p>
                </template>
            </div>

            {{-- ---------------
            -- Form Actions (right-aligned)
            -- --------------- --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('client.address.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300
                           rounded-[8px] hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="px-5 py-2 text-sm font-semibold text-white bg-gray-900 rounded-[8px]
                           hover:bg-gray-700 transition">
                    Save Address
                </button>
            </div>

        </form>
    </div>

    {{-- ---------------
    -- Alpine.js Address Form Logic
    -- --------------- --}}
    <script>
    // ---------------
    // Address Form Component
    // ---------------
    function addressForm() {
        return {
            county_id:           '{{ old('county_id', $currentCountyId ?? '') }}',
            locations:           [],
            location_id:         '',
            preselectedLocationId: {{ $currentLocationId ?? 'null' }},
            loading:             false,

            get selectedLocation() {
                return this.locations.find(l => String(l.id) === String(this.location_id)) || null;
            },

            init() {
                if (this.county_id) {
                    this.fetchLocations(true);
                }
            },

            // ---------------
            // Fetch locations for the selected county via AJAX
            // ---------------
            fetchLocations(preselect = false) {
                if (!this.county_id) {
                    this.locations   = [];
                    this.location_id = '';
                    return;
                }

                this.loading = true;
                if (!preselect) {
                    this.location_id         = '';
                    this.preselectedLocationId = null;
                }

                axios.get('{{ route('client.address.locations') }}', {
                    params: { county_id: this.county_id }
                })
                .then(res => {
                    this.locations = res.data;
                    if (preselect && this.preselectedLocationId) {
                        this.location_id = String(this.preselectedLocationId);
                    }
                })
                .catch(() => {
                    this.locations = [];
                })
                .finally(() => {
                    this.loading = false;
                });
            }
        };
    }
    </script>

@endsection
