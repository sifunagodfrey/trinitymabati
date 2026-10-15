@extends('manage.layouts.app')
@section('title', 'SEO & Analytics Settings')
@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <header><h1 class="text-2xl font-semibold text-primary">SEO & Analytics</h1><p class="mt-2 text-sm text-gray-600">Manage search visibility, page metadata and Google Analytics. Homepage title and description are preserved.</p></header>
    @if (session('success'))
        <p class="rounded-lg bg-green-50 p-4 text-green-800">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <div class="rounded-lg bg-red-50 p-4 text-red-800">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('manage.settings.seo.update') }}" class="space-y-5 rounded-lg border bg-white p-6">
        @csrf
        <h2 class="text-lg font-semibold">Website settings</h2>
        <label class="flex items-center gap-3"><input type="checkbox" name="seo_indexing_enabled" value="1" @checked(($settings['seo_indexing_enabled'] ?? '1') === '1')> Allow search engine indexing on the production website</label>
        <p class="text-sm text-gray-500">Local and staging environments remain excluded automatically. Set APP_ENV=production only on the live website.</p>
        <label class="block"><span class="mb-2 block text-sm font-medium">Google Search Console verification token</span><input name="google_site_verification" value="{{ old('google_site_verification', $settings['google_site_verification'] ?? '') }}" maxlength="200" class="w-full rounded-lg border-gray-300" placeholder="Token only, without the meta tag"></label>
        <label class="block"><span class="mb-2 block text-sm font-medium">GA4 measurement ID</span><input name="ga4_measurement_id" value="{{ old('ga4_measurement_id', $settings['ga4_measurement_id'] ?? '') }}" maxlength="40" class="w-full rounded-lg border-gray-300" placeholder="G-XXXXXXXXXX"></label>
        <label class="flex items-center gap-3"><input type="checkbox" name="ga4_enabled" value="1" @checked(($settings['ga4_enabled'] ?? '0') === '1')> Enable Google Analytics on the production website</label>
        <label class="flex items-center gap-3"><input type="checkbox" name="seo_canonical_redirect" value="1" @checked(($settings['seo_canonical_redirect'] ?? '0') === '1')> Redirect public requests to the preferred website address</label>
        <p class="text-sm text-gray-500">Preferred address: {{ config('app.url') }}. Enable redirects after APP_URL and HTTPS have been verified.</p>
        <button class="rounded-lg bg-primary px-5 py-2.5 font-medium text-white">Save settings</button>
    </form>
    <section class="space-y-5 rounded-lg border bg-white p-6">
        <h2 class="text-lg font-semibold">Page metadata</h2>
        <form method="GET" action="{{ route('manage.settings.seo.index') }}" class="flex flex-wrap gap-3">
            <select name="target" aria-label="Select page" class="min-w-0 flex-1 rounded-lg border-gray-300">
                @foreach ($targets as $key => $label)
                    <option value="{{ $key }}" @selected($selected === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="rounded-lg border border-primary px-4 py-2 text-primary">Edit page</button>
        </form>
        <form method="POST" action="{{ route('manage.settings.seo.metadata') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="target" value="{{ $selected }}">
            <label class="block"><span class="mb-2 block text-sm font-medium">Meta title</span><input name="meta_title" maxlength="180" value="{{ old('meta_title', $metadata?->meta_title) }}" class="w-full rounded-lg border-gray-300"></label>
            <label class="block"><span class="mb-2 block text-sm font-medium">Meta description</span><textarea name="meta_description" maxlength="500" rows="3" class="w-full rounded-lg border-gray-300">{{ old('meta_description', $metadata?->meta_description) }}</textarea></label>
            <p class="text-sm text-gray-500">Leave either field empty to use its automatic default. A useful starting point is about 50–60 characters for titles and 140–160 for descriptions; Google may display different text.</p>
            <button class="rounded-lg bg-primary px-5 py-2.5 font-medium text-white">Save page metadata</button>
        </form>
    </section>
    <p class="text-sm text-gray-600">Sitemap: <a class="text-primary underline" href="{{ route('seo.sitemap') }}" target="_blank" rel="noopener">{{ route('seo.sitemap') }}</a>. Submit this address in Google Search Console. Updates appear within five minutes.</p>
</div>
@endsection
