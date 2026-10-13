{{-- --------------------------------------------------
     Client Account Settings
     Two tabs: Profile and Password, each its own form
     with its own save button, submitted independently.
-------------------------------------------------- --}}
@extends('client.layouts.app')

@section('title', 'Account Settings')
@section('page-title', 'Account Settings')

@section('breadcrumbs')
<div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
    <a href="{{ route('client.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span>/</span>
    <span class="text-gray-800">Account Settings</span>
</div>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Success / Error messages --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-[8px]">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-[8px]">{{ session('error') }}</div>
    @endif

    <div x-data="{ tab: '{{ $errors->has('password') || $errors->has('password_confirmation') ? 'password' : 'profile' }}' }"
        class="bg-white rounded-[8px] shadow-md overflow-hidden">

        {{-- Tabs --}}
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <button type="button" @click="tab = 'profile'"
                    class="flex-1 text-center py-2 border-b-2 transition-colors"
                    :class="tab === 'profile' ? 'border-primary text-primary font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    Profile
                </button>
                <button type="button" @click="tab = 'password'"
                    class="flex-1 text-center py-2 border-b-2 transition-colors"
                    :class="tab === 'password' ? 'border-primary text-primary font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    Password
                </button>
            </div>
        </div>

        {{-- Profile Form --}}
        <form x-show="tab === 'profile'" x-cloak
            action="{{ route('client.settings.account.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="p-6 space-y-6">
                <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>

                {{-- Profile Photo --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    <div class="flex-shrink-0">
                        @if($profile && $profile->profile_photo)
                            <img src="{{ $profile->profile_photo_url }}" alt="Profile photo" class="w-24 h-24 rounded-[12px] object-cover border-2 border-gray-200">
                        @else
                            <div class="w-24 h-24 rounded-[12px] bg-gray-200 flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
                        <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/jpg" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-[8px] file:border-0 file:text-sm file:font-semibold file:bg-primary-light file:text-primary hover:file:opacity-90">
                        <p class="mt-1 text-xs text-gray-500">JPEG, PNG. Max 2MB.</p>
                        @error('profile_photo')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">First Name *</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="mt-1 w-full rounded-[8px] border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        @error('first_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Name *</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="mt-1 w-full rounded-[8px] border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        @error('last_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email (read only)</label>
                    <input type="email" value="{{ $user->email }}" disabled class="mt-1 w-full rounded-[8px] bg-gray-100 border-gray-300 text-gray-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number *</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full rounded-[8px] border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender" class="mt-1 w-full rounded-[8px] border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Prefer not to say</option>
                            <option value="male" @selected(old('gender', optional($profile)->gender) === 'male')>Male</option>
                            <option value="female" @selected(old('gender', optional($profile)->gender) === 'female')>Female</option>
                            <option value="other" @selected(old('gender', optional($profile)->gender) === 'other')>Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="date_of_birth"
                            value="{{ old('date_of_birth', optional($profile)->date_of_birth ? optional($profile)->date_of_birth->format('Y-m-d') : '') }}"
                            class="mt-1 w-full rounded-[8px] border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        @error('date_of_birth')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-primary text-white font-semibold rounded-[8px] hover:opacity-90 transition shadow-sm">
                    Save Profile
                </button>
            </div>
        </form>

        {{-- Password Form --}}
        <form x-show="tab === 'password'" x-cloak
            x-data="{ showPassword: false, showPasswordConfirmation: false }"
            action="{{ route('client.settings.password.update') }}" method="POST">
            @csrf

            <div class="p-6 space-y-6">
                <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
                <p class="text-sm text-gray-600">Enter a new password below.</p>

                {{-- New Password with Toggle --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">New Password</label>
                    <div class="relative mt-1">
                        <input :type="showPassword ? 'text' : 'password'"
                               name="password"
                               class="w-full rounded-[8px] border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 pr-10">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password with Toggle --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <div class="relative mt-1">
                        <input :type="showPasswordConfirmation ? 'text' : 'password'"
                               name="password_confirmation"
                               class="w-full rounded-[8px] border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 pr-10">
                        <button type="button"
                                @click="showPasswordConfirmation = !showPasswordConfirmation"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i :class="showPasswordConfirmation ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-primary text-white font-semibold rounded-[8px] hover:opacity-90 transition shadow-sm">
                    Save Password
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
