@extends('manage.layouts.app')
@section('title', ucfirst($kind).' - Trinity Mabati Admin')
@section('content')
<div class="max-w-6xl mx-auto space-y-6">
 <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
  <div><h1 class="text-2xl font-bold text-gray-900">{{ $kind === 'projects' ? 'Project Gallery' : 'Client Testimonials' }}</h1><p class="text-sm text-gray-500">Only published content appears on the website.</p></div>
  <a href="{{ route('manage.content.client-stories.create', $kind) }}" class="inline-flex justify-center rounded-lg bg-primary px-5 py-3 text-white font-semibold">+ Add {{ $kind === 'projects' ? 'project' : 'testimonial' }}</a>
 </div>
 @if(session('success')) <div class="rounded-lg bg-green-50 p-4 text-green-800">{{ session('success') }}</div> @endif
 <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
 @forelse($items as $item)
  <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col gap-3">
   <div class="flex gap-4 items-start">
    @php $image = $kind === 'projects' ? $item->cover_image : $item->photo; @endphp
    @if($image)<img src="{{ asset($image) }}" alt="" class="w-20 h-20 object-cover rounded-lg">@else<div class="w-20 h-20 flex items-center justify-center bg-gray-100 rounded-lg text-gray-400"><i class="fas fa-image"></i></div>@endif
    <div class="min-w-0 flex-1"><h2 class="font-bold text-gray-900">{{ $kind === 'projects' ? $item->title : $item->client_name }}</h2><p class="text-sm text-gray-500">{{ $item->location }}</p><span class="inline-block mt-2 px-2 py-1 rounded text-xs {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ $item->is_published ? 'Published' : 'Draft' }}</span></div>
   </div>
   <p class="text-sm text-gray-600 line-clamp-2">{{ $kind === 'projects' ? $item->description : $item->testimonial }}</p>
   <div class="flex gap-3 border-t pt-3">
    <a class="rounded-lg border px-4 py-2 text-sm font-semibold" href="{{ route('manage.content.client-stories.edit', [$kind, $item->id]) }}">Edit</a>
    <form method="POST" action="{{ route('manage.content.client-stories.destroy', [$kind, $item->id]) }}" onsubmit="return confirm('Delete this item permanently?')">@csrf @method('DELETE')<button class="rounded-lg border border-red-200 text-red-600 px-4 py-2 text-sm">Delete</button></form>
   </div>
  </div>
 @empty <div class="rounded-xl bg-white border p-8 text-gray-500">No content yet. Select Add to create the first entry.</div>
 @endforelse
 </div>
 {{ $items->links() }}
</div>
@endsection
