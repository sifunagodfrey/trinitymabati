@extends('manage.layouts.app')

@section('title', 'Create User')

@section('content')
<div class="mb-6">
    <nav class="text-sm text-muted mb-4">
        <ol class="inline-flex items-center gap-2">
            <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
            <li>/</li>
            <li><a href="{{ route('manage.system-users.index') }}" class="hover:text-primary">System Users</a></li>
            <li>/</li>
            <li class="text-black font-semibold">Create User</li>
        </ol>
    </nav>
    <h1 class="text-2xl font-semibold text-black">Create New User</h1>
</div>

@if ($errors->any())
    <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
    <form method="POST" action="{{ route('manage.system-users.store') }}">
        @csrf

        <div class="grid gap-6 lg:grid-cols-2 mb-6">
            <div><label class="block text-sm font-medium mb-2">First Name *</label><input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full rounded-[8px] border border-border bg-white px-4 py-3" required></div>
            <div><label class="block text-sm font-medium mb-2">Last Name</label><input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full rounded-[8px] border border-border bg-white px-4 py-3"></div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2 mb-6">
            <div><label class="block text-sm font-medium mb-2">Email *</label><input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-[8px] border border-border bg-white px-4 py-3" required></div>
            <div><label class="block text-sm font-medium mb-2">Phone</label><input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-[8px] border border-border bg-white px-4 py-3"></div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2 mb-6">
            <div>
                <label class="block text-sm font-medium mb-2">Role *</label>
                <select name="role_id" class="w-full rounded-[8px] border border-border bg-white px-4 py-3" required>
                    <option value="">-- Select Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-text mb-2">Status</label>
                <select name="status" class="w-full rounded-[8px] border border-border bg-white px-4 py-3 text-sm text-black outline-none focus:border-primary">
                    @foreach (['active', 'pending', 'suspended'] as $statusOption)
                        <option value="{{ $statusOption }}" {{ old('status', 'pending') == $statusOption ? 'selected' : '' }}>
                            {{ ucfirst($statusOption) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-6" x-data="{ show: false }">
            <label class="block text-sm font-medium mb-2" for="password">Password</label>
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" minlength="8" maxlength="255"
                    autocomplete="new-password" placeholder="Leave blank to auto-generate"
                    class="w-full rounded-[8px] border border-border bg-white px-4 py-3 pr-12">
                <button type="button" @click="show = !show" tabindex="-1" aria-label="Show or hide password"
                    class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-muted hover:text-black">
                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            <p class="mt-2 text-xs text-muted">At least 8 characters. Leave blank and a random password is generated and emailed to the user.</p>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('manage.system-users.index') }}" class="rounded-[8px] border px-5 py-3 text-sm">Cancel</a>
            <button type="submit" class="rounded-[8px] bg-primary px-5 py-3 text-sm font-semibold text-white">Create User</button>
        </div>
    </form>
</div>
@endsection
