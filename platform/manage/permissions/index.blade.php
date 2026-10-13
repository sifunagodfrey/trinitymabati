@extends('manage.layouts.app')

@section('title', 'Permission Management - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Permission Management</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('manage.dashboard.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back
                </a>
                <div>
                    <h1 class="text-2xl font-semibold text-black">Permission Management</h1>
                    <p class="text-sm text-muted">Assign permissions to roles. Changes are applied immediately.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Role Selector
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
        <h2 class="text-base font-semibold text-black mb-4">Select Role</h2>
        <form method="GET" action="{{ route('manage.permissions.index') }}">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label class="block text-xs font-semibold uppercase tracking-wide text-muted mb-1">
                        Role
                    </label>
                    <select name="role_id"
                        onchange="this.form.submit()"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                        <option value="">- Select a role to manage -</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $selectedRoleId == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    {{-- ---------------
    -- Permissions Form (shown only when a role is selected)
    -- --------------- --}}
    @if ($selectedRole)

        @php
            // ---------------
            // Super Admin (id=1) is fully locked - cannot be edited
            // ---------------
            $isSuperAdmin = ($selectedRole->id === 1);
        @endphp

        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h2 class="text-base font-semibold text-black">
                        Permissions for: <span class="text-primary">{{ $selectedRole->name }}</span>
                    </h2>
                    <p class="text-xs text-muted mt-0.5">{{ $permissions->count() }} permissions available</p>
                </div>
                @if (!$isSuperAdmin)
                    <div class="flex gap-2">
                        <button type="button" id="btnCheckAll"
                            class="inline-flex items-center gap-1.5 rounded-[12px] border border-border bg-white px-4 py-2 text-xs font-medium text-text hover:bg-slate-50 transition">
                            <i class="fa-solid fa-check-double text-xs"></i> Check All
                        </button>
                        <button type="button" id="btnUncheckAll"
                            class="inline-flex items-center gap-1.5 rounded-[12px] border border-border bg-white px-4 py-2 text-xs font-medium text-text hover:bg-slate-50 transition">
                            <i class="fa-solid fa-xmark text-xs"></i> Uncheck All
                        </button>
                    </div>
                @endif
            </div>

            {{-- ---------------
            -- Super Admin notice
            -- --------------- --}}
            @if ($isSuperAdmin)
                <div class="mb-6 rounded-[12px] border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                    <i class="fa-solid fa-shield-halved mr-1.5"></i>
                    <strong>Super Admin</strong> has all permissions by default and cannot be edited.
                </div>
            @endif

            {{-- ---------------
            -- AJAX response area
            -- --------------- --}}
            <div id="formResponse" class="mb-4 hidden"></div>

            <form id="permissionsForm"
                action="{{ route('manage.permissions.update') }}"
                method="POST">
                @csrf
                <input type="hidden" name="role_id" value="{{ $selectedRole->id }}">

                {{-- ---------------
                -- Permissions grid
                -- --------------- --}}
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($permissions as $perm)
                        <label for="perm{{ $perm->id }}"
                            class="flex items-start gap-3 rounded-[12px] border border-border bg-white px-4 py-3 cursor-pointer transition hover:border-primary/40
                                {{ $isSuperAdmin ? 'opacity-70 cursor-default' : '' }}">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $perm->id }}"
                                id="perm{{ $perm->id }}"
                                class="perm-checkbox mt-0.5 h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                {{ $selectedPermissions->contains($perm->id) ? 'checked' : '' }}
                                {{ $isSuperAdmin ? 'disabled' : '' }}>
                            <div class="min-w-0">
                                <div class="text-sm font-medium text-black leading-snug">{{ $perm->name }}</div>
                                @if ($perm->description)
                                    <div class="text-xs text-muted mt-0.5 leading-snug">{{ $perm->description }}</div>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>

                {{-- ---------------
                -- Form actions (right-aligned per project convention)
                -- --------------- --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('manage.permissions.index') }}"
                        class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-5 py-2.5 text-sm font-medium text-text transition hover:bg-slate-100">
                        Cancel
                    </a>
                    <button type="submit"
                        id="btnSave"
                        {{ $isSuperAdmin ? 'disabled' : '' }}
                        class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save Permissions
                    </button>
                </div>
            </form>
        </div>

    @elseif (request()->has('role_id'))

        {{-- ---------------
        -- Selected role not found
        -- --------------- --}}
        <div class="rounded-[12px] border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            <i class="fa-solid fa-triangle-exclamation mr-1.5"></i>
            The selected role does not exist.
        </div>

    @endif

@endsection

@push('scripts')
    <script>
        (function () {
            const form = document.getElementById('permissionsForm');
            const responseBox = document.getElementById('formResponse');
            const btnSave = document.getElementById('btnSave');

            // ---------------
            // AJAX form submit
            // ---------------
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    if (btnSave) {
                        btnSave.disabled = true;
                        btnSave.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving…';
                    }

                    responseBox.classList.add('hidden');
                    responseBox.innerHTML = '';

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: new FormData(form),
                    })
                        .then(res => res.json())
                        .then(data => {
                            const isSuccess = data.status === 'success';
                            responseBox.innerHTML =
                                `<div class="rounded-[12px] border px-4 py-3 text-sm ${
                                    isSuccess
                                        ? 'border-emerald-200 bg-emerald-50 text-emerald-800'
                                        : 'border-red-200 bg-red-50 text-red-800'
                                }">
                                    <i class="fa-solid ${isSuccess ? 'fa-circle-check' : 'fa-circle-xmark'} mr-1.5"></i>
                                    ${data.message}
                                </div>`;
                            responseBox.classList.remove('hidden');
                        })
                        .catch(() => {
                            responseBox.innerHTML =
                                '<div class="rounded-[12px] border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">' +
                                '<i class="fa-solid fa-circle-xmark mr-1.5"></i>Failed to save permissions. Please try again.</div>';
                            responseBox.classList.remove('hidden');
                        })
                        .finally(() => {
                            if (btnSave) {
                                btnSave.disabled = false;
                                btnSave.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Save Permissions';
                            }
                        });
                });
            }

            // ---------------
            // Check all / Uncheck all
            // ---------------
            const checkboxes = document.querySelectorAll('.perm-checkbox');

            const btnCheck = document.getElementById('btnCheckAll');
            const btnUncheck = document.getElementById('btnUncheckAll');

            if (btnCheck) {
                btnCheck.addEventListener('click', () => {
                    checkboxes.forEach(cb => { cb.checked = true; });
                });
            }

            if (btnUncheck) {
                btnUncheck.addEventListener('click', () => {
                    checkboxes.forEach(cb => { cb.checked = false; });
                });
            }
        })();
    </script>
@endpush
