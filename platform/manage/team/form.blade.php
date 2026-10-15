@extends('manage.layouts.app')
@section('title', ($member->exists ? 'Edit' : 'Add').' Team Member')
@section('content')
<div class="mx-auto max-w-3xl space-y-5">
    <div class="flex items-center justify-between gap-3"><h1 class="text-2xl font-bold">{{ $member->exists ? 'Edit' : 'Add' }} Team Member</h1><a href="{{ route('manage.content.team.index') }}" class="text-sm text-primary">Back to team</a></div>
    @if($errors->any())<div role="alert" class="rounded-lg border border-red-200 bg-red-50 p-4 text-red-700"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ $member->exists ? route('manage.content.team.update', $member->id) : route('manage.content.team.store') }}" class="space-y-5 rounded-xl border border-gray-200 bg-white p-5 sm:p-7">
        @csrf
        @if($member->exists) @method('PUT') @endif
        <div class="grid gap-4 sm:grid-cols-2">
            <div><label for="team-first-name" class="mb-2 block text-sm font-semibold">First name *</label><input id="team-first-name" name="first_name" maxlength="80" required value="{{ old('first_name', $member->first_name) }}" class="w-full rounded-lg border px-3 py-2.5"></div>
            <div><label for="team-last-name" class="mb-2 block text-sm font-semibold">Last name *</label><input id="team-last-name" name="last_name" maxlength="80" required value="{{ old('last_name', $member->last_name) }}" class="w-full rounded-lg border px-3 py-2.5"></div>
        </div>
        <div><label for="team-title" class="mb-2 block text-sm font-semibold">Title / position</label><input id="team-title" name="title" maxlength="160" value="{{ old('title', $member->title) }}" placeholder="e.g. Sales Manager" class="w-full rounded-lg border px-3 py-2.5"></div>
        <div><label for="team-bio" class="mb-2 block text-sm font-semibold">Bio (optional)</label><textarea id="team-bio" name="bio" rows="5" maxlength="5000" class="w-full rounded-lg border px-3 py-2.5">{{ old('bio', $member->bio) }}</textarea></div>
        <div><label for="team-photo" class="mb-2 block text-sm font-semibold">Photo {{ $member->photo ? '(leave empty to keep current photo)' : '*' }}</label><input id="team-photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" @required(!$member->photo) class="block w-full text-sm"><p class="mt-2 text-xs text-gray-500">JPG, PNG or WebP, up to 4 MB. Portrait photos work best.</p>@if($member->photo)<img src="{{ asset($member->photo) }}" alt="Current team photo" class="mt-3 h-40 w-32 rounded-lg object-cover">@endif</div>
        <div><label for="team-order" class="mb-2 block text-sm font-semibold">Display order</label><input id="team-order" type="number" name="sort_order" min="0" max="1000000" value="{{ old('sort_order', $member->sort_order ?? 0) }}" class="w-full rounded-lg border px-3 py-2.5"><p class="mt-1 text-xs text-gray-500">Lower numbers appear first.</p></div>
        <label class="flex items-center gap-2"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $member->is_published ?? false))> Publish on website</label>
        <button type="submit" class="rounded-lg bg-primary px-7 py-3 font-semibold text-white transition hover:opacity-90">Save team member</button>
    </form>
</div>
@endsection
