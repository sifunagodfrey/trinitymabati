@extends('manage.layouts.app')
@section('title', 'Our Team | Trinity Mabati Admin')
@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div><h1 class="text-2xl font-bold text-gray-900">Our Team</h1><p class="mt-1 text-sm text-gray-500">Published members appear on the homepage and Our Team page.</p></div>
        <a href="{{ route('manage.content.team.create') }}" class="rounded-lg bg-primary px-5 py-3 font-semibold text-white">Add team member</a>
    </div>
    @if(session('success'))<p role="status" class="rounded-lg bg-green-50 p-4 text-green-800">{{ session('success') }}</p>@endif
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($members as $member)
            <article class="overflow-hidden rounded-xl border border-gray-200 bg-white">
                @if($member->photo)<img src="{{ asset($member->photo) }}" alt="{{ $member->full_name }}" class="h-48 w-full object-cover">@endif
                <div class="space-y-3 p-5"><h2 class="font-semibold text-gray-900">{{ $member->full_name }}</h2>@if($member->title)<p class="text-sm text-primary">{{ $member->title }}</p>@endif
                    <p class="text-sm text-gray-500">{{ $member->is_published ? 'Published' : 'Draft' }} · Order {{ $member->sort_order }}</p>
                    <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($member->bio ?? '', 140) }}</p>
                    <div class="flex items-center gap-3 border-t pt-3">
                        <a href="{{ route('manage.content.team.edit', $member->id) }}" class="rounded-lg border px-4 py-2 text-sm font-semibold">Edit</a>
                        <form method="POST" action="{{ route('manage.content.team.destroy', $member->id) }}" onsubmit="return confirm('Delete this team member?')">@csrf @method('DELETE')<button type="submit" class="rounded-lg border border-red-200 px-4 py-2 text-sm text-red-700">Delete</button></form>
                    </div>
                </div>
            </article>
        @empty
            <p class="rounded-xl border bg-white p-8 text-gray-500 sm:col-span-2 lg:col-span-3">No team members yet. Add and publish your first member to show the homepage section.</p>
        @endforelse
    </div>
    {{ $members->links() }}
</div>
@endsection
