{{-- -------------------------------------------------- --}}
{{-- Client Payment Settings                            --}}
{{-- Allows user to choose a preferred payment method --}}
{{-- -------------------------------------------------- --}}
@extends('client.layouts.app')

@section('title', 'Payment Settings')
@section('page-title', 'Payment Settings')

@section('breadcrumbs')
<div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
    <a href="{{ route('client.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('client.settings.account') }}" class="hover:text-primary-600">Account Settings</a>
    <span>/</span>
    <span class="text-gray-800">Payment Settings</span>
</div>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Success / Error messages --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-[8px]">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-[8px]">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-[8px] shadow-md overflow-hidden">

        {{-- Header --}}
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Preferred Payment Method</h3>
            <p class="text-sm text-gray-600 mt-1">
                Select your favourite payment method. It will be pre‑selected during checkout.
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('client.settings.payment.update') }}" method="POST" class="p-6 space-y-6">
            @csrf

            {{-- Current preference indicator --}}
            @if($currentPreference && $currentPreference->paymentMethod)
                <div class="bg-blue-50 border border-blue-200 rounded-[8px] p-4">
                    <p class="text-sm text-blue-800 mb-1">Your current preferred method:</p>
                    <p class="font-semibold text-blue-900">
                        {{ $currentPreference->paymentMethod->name }}
                    </p>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-[8px] p-4">
                    <p class="text-sm text-yellow-800">
                        You haven't set a preferred payment method yet. Choose one below to speed up checkout.
                    </p>
                </div>
            @endif

            {{-- Payment method selection --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Select Payment Method
                </label>
                <select name="preferred_method_id"
                        class="mt-1 w-full rounded-[8px] border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">-- Choose a method --</option>
                    @foreach($methods as $method)
                        <option value="{{ $method->id }}"
                            {{ ($currentPreference && $currentPreference->payment_method_id == $method->id) ? 'selected' : '' }}>
                            {{ $method->name }}
                        </option>
                    @endforeach
                </select>
                @error('preferred_method_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-[8px] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    Save Preference
                </button>
            </div>
        </form>
    </div>

    {{-- Optional note --}}
    <p class="text-xs text-gray-500 text-center mt-6">
        You can always change this later. Your saved method will be used as default during checkout.
    </p>
</div>
@endsection