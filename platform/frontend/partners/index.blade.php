@extends('frontend.layouts.app')
@section('title', ($isAssociation ?? false) ? 'Our Associations | Trinity Mabati Factory' : 'Our Partners | Trinity Mabati Factory')
@section('meta_description', ($isAssociation ?? false) ? 'Explore the industry associations connected with Trinity Mabati Factory.' : 'Meet the partners working with Trinity Mabati Factory.')
@section('content')
    @php
        $isAssociation = $isAssociation ?? false;
        $heading = $isAssociation ? 'Our Associations' : 'Our Partners';
    @endphp
    <section class="trinity-network trinity-network--directory {{ $isAssociation ? 'trinity-network--associations' : '' }}" aria-labelledby="directory-heading">
        <div class="trinity-network__inner">
            <header class="trinity-network__header">
                <div class="trinity-network__intro">
                    <h1 id="directory-heading" class="trinity-network__title">{{ $heading }}</h1>
                    <p class="trinity-network__description">{{ $isAssociation ? 'Building stronger connections across our industry.' : 'Working together to bring quality to every project.' }}</p>
                </div>
            </header>
            @if ($partners->isNotEmpty())
                <div class="trinity-network__grid">
                    @foreach ($partners as $partner)
                        @include('frontend.partials.partner-card', ['partner' => $partner])
                    @endforeach
                </div>
                @if ($partners->hasPages())
                    <div class="trinity-network__pagination">{{ $partners->links() }}</div>
                @endif
            @else
                <p class="trinity-network__empty">Our {{ $isAssociation ? 'associations' : 'partners' }} will be featured here soon.</p>
            @endif
        </div>
    </section>
    @include('frontend.partials.page-cta')
@endsection
