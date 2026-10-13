@extends('manage.layouts.app')

@section('title', 'System Users - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">System Users</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">System Users</h1>
                <p class="text-sm text-muted">View and manage all registered users in the platform.</p>
            </div>
            <a href="{{ route('manage.system-users.create') }}"
               class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-user-plus"></i>
                Create New User
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

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        {{-- ---------------
        -- Search + Role Filter
        -- --------------- --}}
        <form method="GET" action="{{ route('manage.system-users.index') }}"
              class="mb-6 flex flex-wrap items-center gap-3">

            <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                <input type="search" name="search" value="{{ $search }}"
                       placeholder="Search by name or email..."
                       class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                @if ($search)
                    <a href="{{ route('manage.system-users.index') }}"
                       class="pr-3 text-muted hover:text-red-400 transition text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-magnifying-glass"></i>
                Search
            </button>

            @if ($search)
                <a href="{{ route('manage.system-users.index') }}"
                   class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-3 text-sm text-muted transition hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i>
                    Reset
                </a>
            @endif

        </form>

        {{-- ---------------
        -- Users Table
        -- --------------- --}}
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[960px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Full Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Phone</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Joined On</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($users as $user)
                            @php
                                // ---------------
                                // Status badge colour map
                                // ---------------
                                $statusColors = [
                                    'active'    => 'bg-emerald-100 text-emerald-800',
                                    'pending'   => 'bg-amber-100 text-amber-800',
                                    'suspended' => 'bg-rose-100 text-rose-800',
                                    'inactive'  => 'bg-gray-100 text-gray-600', 
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('manage.system-users.show', $user->id) }}'"  >
                                <td class="px-4 py-4 text-xs text-muted font-mono">{{ $user->id }}</td>
                                <td class="px-4 py-4">
                                    <div class="font-medium text-black">
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-muted">{{ $user->email }}</td>
                                <td class="px-4 py-4 text-sm text-muted">{{ $user->phone ?? '-' }}</td>
                                <td class="px-4 py-4 text-sm text-muted">
                                    {{ $user->role?->name ?? '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                                        {{ $statusColors[$user->status] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($user->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-xs text-muted whitespace-nowrap">
                                    {{ $user->created_at?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="px-4 py-4 text-right" onclick="event.stopPropagation()">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('manage.system-users.show', $user->id) }}"
                                           title="View User"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('manage.system-users.edit', $user->id) }}"
                                           title="Edit User"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-primary/30 bg-primary/5 text-primary transition hover:bg-primary/10">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>
                                        @if (!in_array($user->role_id, [1, 2]))
                                            <form action="{{ route('manage.system-users.destroy', $user->id) }}" method="POST" class="inline-block"
                                                  onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Delete User"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-rose-200 bg-rose-50 text-rose-700 transition hover:bg-rose-100">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center text-sm text-muted">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="fa-solid fa-users text-3xl text-slate-300"></i>
                                        <span>No users found. Try adjusting your search or filters.</span>
                                        @if ($search || $roleFilter)
                                            <a href="{{ route('manage.system-users.index') }}"
                                               class="text-xs text-primary hover:underline">Clear filters</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ---------------
        -- Pagination
        -- --------------- --}}
        <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-muted">
                Showing {{ $users->firstItem() ?? 0 }} – {{ $users->lastItem() ?? 0 }}
                of {{ $users->total() }} users
            </p>
            <div>{{ $users->links() }}</div>
        </div>

    </div>

@endsection
