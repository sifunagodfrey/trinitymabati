@extends('frontend.layouts.app')
@section('title', 'Our Partners | Trinity Mabati Factory')
@section('meta_description', 'Meet the partners working with Trinity Mabati Factory.')
@section('content')
<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-16 lg:px-8"><header class="mb-10 text-center"><h1 class="text-3xl font-semibold text-primary sm:text-4xl">Our Partners</h1></header>
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 sm:gap-6 lg:grid-cols-4">@forelse($partners as $partner)@include('frontend.partials.partner-card', ['partner' => $partner])@empty<p class="col-span-full rounded-xl border bg-white p-10 text-center text-gray-500">Our partners will be featured here soon.</p>@endforelse</div><div class="mt-8">{{ $partners->links() }}</div>
</section>
@include('frontend.partials.page-cta')
@endsection
