@extends('manage.layouts.app')

@section('title', 'View User')

@section('content')
<div class="mb-6">
    <nav class="text-sm text-muted mb-4">
        <ol class="inline-flex items-center gap-2">
            <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
            <li>/</li>
            <li><a href="{{ route('manage.system-users.index') }}" class="hover:text-primary">System Users</a></li>
            <li>/</li>
            <li class="text-black font-semibold">View User</li>
        </ol>
    </nav>
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-black">User Profile</h1>
        <div class="flex gap-2">
            <a href="{{ route('manage.system-users.edit', $user->id) }}" class="rounded-[12px] border border-border bg-background px-4 py-2 text-sm">Edit</a>
            <a href="{{ route('manage.system-users.index') }}" class="rounded-[12px] bg-primary px-4 py-2 text-sm text-white">All Users</a>
        </div>
    </div>
</div>

<div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
    <div class="grid gap-6 xl:grid-cols-2">
        <div class="space-y-3 rounded-[12px] bg-slate-50 p-5">
            <h3 class="text-lg font-semibold">Personal Info</h3>
            <hr>
            <div class="flex justify-between"><span class="text-muted">Full Name:</span><span>{{ $user->name }}</span></div>
            <div class="flex justify-between"><span class="text-muted">Email:</span><span>{{ $user->email }}</span></div>
            <div class="flex justify-between"><span class="text-muted">Phone:</span><span>{{ $user->phone ?? '-' }}</span></div>
            <div class="flex justify-between"><span class="text-muted">Role:</span><span>{{ $user->role->name ?? '-' }}</span></div>
            <div class="flex justify-between"><span class="text-muted">Status:</span>
                <span class="rounded-[12px] px-3 py-1 text-xs font-semibold {{ $user->status ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                    {{ $user->status ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
        <div class="space-y-3 rounded-[12px] bg-slate-50 p-5">
            <h3 class="text-lg font-semibold">Metadata</h3>
            <hr>
            <div class="flex justify-between"><span class="text-muted">User ID:</span><span>#{{ $user->id }}</span></div>
            <div class="flex justify-between"><span class="text-muted">Created:</span><span>{{ $user->created_at?->format('d M Y, H:i') ?? '-' }}</span></div>
            <div class="flex justify-between"><span class="text-muted">Updated:</span><span>{{ $user->updated_at?->format('d M Y, H:i') ?? '-' }}</span></div>
            @if($user->deleted_at)<div class="flex justify-between text-red-600"><span>Deleted:</span><span>{{ $user->deleted_at->format('d M Y, H:i') }}</span></div>@endif
        </div>
    </div>
</div>
@endsection