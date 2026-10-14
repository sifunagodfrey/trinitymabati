@extends('frontend.layouts.app')
@section('title', 'Client Testimonials | Trinity Mabati Factory')
@section('meta_description', 'Read customer testimonials about Trinity Mabati Factory roofing sheets and service.')
@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
 <div class="text-center mb-10"><p class="uppercase tracking-widest text-red-600 text-sm font-semibold">Customer experiences</p><h1 class="text-3xl sm:text-4xl font-bold mt-2">Client Testimonials</h1><p class="text-gray-600 mt-3">What our customers say about Trinity Mabati Factory.</p></div>
 <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
 @forelse($testimonials as $t)
  <article class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 flex flex-col gap-4">
   <div class="flex items-center gap-3">@if($t->photo)<img src="{{ asset($t->photo) }}" alt="" class="w-14 h-14 rounded-full object-cover">@else<div class="w-14 h-14 rounded-full flex items-center justify-center bg-red-50 text-red-600 text-xl"><i class="fas fa-user"></i></div>@endif <div><h2 class="font-bold">{{ $t->client_name }}</h2><p class="text-sm text-gray-500">{{ collect([$t->role, $t->location])->filter()->implode(' · ') }}</p></div></div>
   <div class="text-amber-500" aria-label="{{ $t->rating }} out of 5 stars">@for($i=1;$i<=5;$i++)<i class="{{ $i <= $t->rating ? 'fas' : 'far' }} fa-star"></i>@endfor</div>
   <blockquote class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $t->testimonial }}</blockquote>
  </article>
 @empty <div class="col-span-full text-center bg-white border rounded-xl p-12 text-gray-500">Testimonials will be published here soon.</div>
 @endforelse
 </div><div class="mt-8">{{ $testimonials->links() }}</div>
</section>
@endsection
