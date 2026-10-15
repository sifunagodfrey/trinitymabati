@php
    $seoTitle = $seo['title'] ?? trim($__env->yieldContent('title', 'Trinity Mabati Factory'));
    $seoDescription = $seo['description'] ?? trim($__env->yieldContent('meta_description', \App\Services\Seo\SeoService::DESCRIPTION));
    if ($seoDescription === '') $seoDescription = \App\Services\Seo\SeoService::DESCRIPTION;
    $seoImage = $seo['image'];
    $seoPage = filter_var(request()->query('page'), FILTER_VALIDATE_INT);
    if ($seoPage && $seoPage > 1 && str_contains($seo['canonical'], '?page=')) $seoTitle .= ' | Page ' . $seoPage;
    $verification = \App\Models\Core\Setting::get('google_site_verification', '');
@endphp
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
<meta name="robots" content="{{ $seo['robots'] }}">
<link rel="canonical" href="{{ $seo['canonical'] }}">
<meta name="author" content="Trinity Mabati Factory">
@if ($verification !== '')
    <meta name="google-site-verification" content="{{ $verification }}">
@endif
<meta property="og:title" content="{{ request()->routeIs('frontend.home', 'home') ? trim($__env->yieldContent('og_title', $seoTitle)) : $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:type" content="{{ request()->routeIs('frontend.products.show') ? 'product' : 'website' }}">
<meta property="og:url" content="{{ $seo['canonical'] }}">
<meta property="og:site_name" content="Trinity Mabati Factory">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ request()->routeIs('frontend.home', 'home') ? trim($__env->yieldContent('og_title', $seoTitle)) : $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">
@foreach ($seo['schemas'] as $schema)
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endforeach
@include('frontend.partials.analytics')
