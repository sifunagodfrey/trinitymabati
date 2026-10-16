@extends('manage.layouts.app')
@section('title', 'Partners | Trinity Mabati Admin')
@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div><h1 class="text-2xl font-bold text-gray-900">Partners</h1><p class="mt-1 text-sm text-gray-500">Published partner images appear on the homepage and Partners page.</p></div>
        <a href="{{ route('manage.content.partners.create') }}" class="rounded-lg bg-primary px-5 py-3 font-semibold text-white">Add partner</a>
    </div>
    @if(session('success'))<p role="status" class="rounded-lg bg-green-50 p-4 text-green-800">{{ session('success') }}</p>@endif
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($partners as $partner)
            <article class="overflow-hidden rounded-xl border border-gray-200 bg-white">
                @if($partner->image)<img src="{{ asset($partner->image) }}" alt="{{ $partner->name }}" style="aspect-ratio:2/1;width:100%;object-fit:cover;">@endif
                <div class="space-y-3 p-5"><h2 class="font-semibold text-gray-900">{{ $partner->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $partner->is_published ? 'Published' : 'Draft' }} · Order {{ $partner->sort_order }}</p>
                    @if($partner->is_association) &middot; Association @endif
                    <div class="flex items-center gap-3 border-t pt-3">
                        <a href="{{ route('manage.content.partners.edit', $partner->id) }}" class="rounded-lg border px-4 py-2 text-sm font-semibold">Edit</a>
                        <form method="POST" action="{{ route('manage.content.partners.destroy', $partner->id) }}" onsubmit="return confirm('Delete this partner?')">@csrf @method('DELETE')<button type="submit" class="rounded-lg border border-red-200 px-4 py-2 text-sm text-red-700">Delete</button></form>
                    </div>
                </div>
            </article>
        @empty
            <p class="rounded-xl border bg-white p-8 text-gray-500 sm:col-span-2 lg:col-span-3">No partners yet. Add and publish your first partner image to show the homepage section.</p>
        @endforelse
    </div>
    {{ $partners->links() }}
</div>
@endsection
