@extends('manage.layouts.app')
@section('title', ($item ? 'Edit' : 'New').' '.ucfirst($kind))
@section('content')
@php $isProject = $kind === 'projects'; @endphp
<div class="max-w-4xl mx-auto space-y-5">
 <div class="flex flex-wrap items-center justify-between gap-3"><h1 class="text-2xl font-bold">{{ $item ? 'Edit' : 'Add' }} {{ $isProject ? 'Client Project' : 'Client Testimonial' }}</h1><a href="{{ route('manage.content.client-stories.index', $kind) }}" class="text-sm text-red-600">Back to list</a></div>
 @if($errors->any())<div class="rounded-lg bg-red-50 border border-red-200 p-4 text-red-700"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
 <form method="POST" enctype="multipart/form-data" action="{{ $item ? route('manage.content.client-stories.update', [$kind, $item->id]) : route('manage.content.client-stories.store', $kind) }}" class="bg-white border border-gray-200 rounded-xl p-5 sm:p-7 space-y-5">
 @csrf @if($item) @method('PUT') @endif
 <div class="grid sm:grid-cols-2 gap-4">
 @if($isProject)
  <div class="sm:col-span-2"><label class="block text-sm font-semibold mb-2">Project title *</label><input required name="title" value="{{ old('title', $item->title ?? '') }}" class="w-full border rounded-lg px-3 py-2.5"></div>
  <div><label class="block text-sm font-semibold mb-2">Project URL slug (optional)</label><input name="slug" value="{{ old('slug', $item->slug ?? '') }}" placeholder="auto-generated from title" class="w-full border rounded-lg px-3 py-2.5"></div>
  <div><label class="block text-sm font-semibold mb-2">Roofing profile used</label><input name="roofing_profile" value="{{ old('roofing_profile', $item->roofing_profile ?? '') }}" placeholder="e.g. Trinity Versatile" class="w-full border rounded-lg px-3 py-2.5"></div>
  <div><label class="block text-sm font-semibold mb-2">Completion date</label><input type="date" name="completion_date" value="{{ old('completion_date', $item->completion_date ?? '') }}" class="w-full border rounded-lg px-3 py-2.5"></div>
 @else
  <div><label class="block text-sm font-semibold mb-2">Client name *</label><input required name="client_name" value="{{ old('client_name', $item->client_name ?? '') }}" class="w-full border rounded-lg px-3 py-2.5"></div>
  <div><label class="block text-sm font-semibold mb-2">Client role or project type (optional)</label><input name="role" value="{{ old('role', $item->role ?? '') }}" class="w-full border rounded-lg px-3 py-2.5"></div>
  <div><label class="block text-sm font-semibold mb-2">Rating</label><select name="rating" class="w-full border rounded-lg px-3 py-2.5">@for($r=5;$r>=1;$r--)<option value="{{ $r }}" @selected(old('rating', $item->rating ?? 5) == $r)>{{ $r }} star{{ $r > 1 ? 's' : '' }}</option>@endfor</select></div>
 @endif
  <div><label class="block text-sm font-semibold mb-2">Location</label><input name="location" value="{{ old('location', $item->location ?? '') }}" placeholder="e.g. Nairobi" class="w-full border rounded-lg px-3 py-2.5"></div>
 </div>
 <div><label class="block text-sm font-semibold mb-2">{{ $isProject ? 'Project description' : 'Customer testimonial *' }}</label><textarea name="{{ $isProject ? 'description' : 'testimonial' }}" rows="6" {{ $isProject ? '' : 'required' }} class="w-full border rounded-lg px-3 py-2.5">{{ old($isProject ? 'description' : 'testimonial', $isProject ? ($item->description ?? '') : ($item->testimonial ?? '')) }}</textarea></div>
 <div><label class="block text-sm font-semibold mb-2">{{ $isProject ? 'Cover image' : 'Client photo' }} (JPG, PNG, WebP, max 4 MB)</label><input type="file" name="{{ $isProject ? 'cover_image' : 'photo' }}" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm">@php $img = $isProject ? ($item->cover_image ?? null) : ($item->photo ?? null); @endphp @if($img)<img src="{{ asset($img) }}" class="mt-3 w-32 h-24 object-cover rounded-lg" alt="Existing photo">@endif</div>
 @if($isProject)
 <div><label class="block text-sm font-semibold mb-2">Add gallery photos (up to 12 per upload)</label><input type="file" name="gallery[]" multiple accept="image/jpeg,image/png,image/webp" class="block w-full text-sm"></div>
 @if($item)
 <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">@foreach(json_decode($item->gallery ?: '[]', true) ?: [] as $img)<label class="relative block"><img src="{{ asset($img) }}" class="w-full aspect-square object-cover rounded-lg" alt="Project photo"><span class="text-xs"><input type="checkbox" name="remove_gallery[]" value="{{ $img }}"> Remove</span></label>@endforeach</div>
 @endif
 @endif
 <div class="grid sm:grid-cols-2 gap-4"><div><label class="block text-sm font-semibold mb-2">Display order</label><input type="number" min="0" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="w-full border rounded-lg px-3 py-2.5"></div><div class="space-y-3 pt-3"><label class="flex items-center gap-2"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $item->is_published ?? false))> Publish on website</label><label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $item->is_featured ?? false))> Featured item</label></div></div>
 <button type="submit" class="w-full sm:w-auto rounded-lg bg-red-600 text-white px-8 py-3 font-semibold hover:bg-red-700">Save {{ $isProject ? 'project' : 'testimonial' }}</button>
 </form>
</div>
@endsection
