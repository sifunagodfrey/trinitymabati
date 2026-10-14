{{-- -------------------
     Admin Contact & Social Settings
     Manage the public contact details and social links shown on the site
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'Contact & Social Settings')
@section('meta-description', 'Manage the public contact details and social media links shown across the Trinity Mabati Factory storefront.')

@section('content')
    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.settings.contact.index') }}" class="hover:text-primary">Settings</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Contact &amp; Social</li>
            </ol>
        </nav>

        <div>
            <h1 class="text-2xl font-semibold text-black">Contact &amp; Social Settings</h1>
            <p class="text-sm text-muted">These details appear in the site header, footer, contact page and WhatsApp links. Changes apply within a few minutes.</p>
        </div>
    </div>

    {{-- ---------------
    -- Alerts
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('manage.settings.contact.update') }}">
        @csrf

        {{-- ---------------
        -- Contact Details
        -- --------------- --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
            <h2 class="text-lg font-semibold text-black mb-4">Contact Details</h2>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                @foreach (['contact_email', 'contact_phone', 'contact_whatsapp', 'contact_address'] as $key)
                    <div>
                        <label for="{{ $key }}" class="block text-sm font-medium text-black mb-1">{{ $fields[$key]['label'] }}</label>
                        <input type="text" id="{{ $key }}" name="{{ $key }}"
                               value="{{ old($key, $fields[$key]['value']) }}"
                               class="w-full rounded-[8px] border border-border bg-background px-4 py-2.5 text-sm focus:border-primary focus:ring-primary">
                        <p class="mt-1 text-xs text-muted">{{ $fields[$key]['help'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
            <h2 class="text-lg font-semibold text-black mb-1">Branch Contacts</h2>
            <p class="mb-5 text-sm text-muted">Manage the two branch names and phone numbers displayed on the Contact Us page.</p>
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                @foreach (['nairobi' => 'Nairobi Branch', 'migori' => 'Migori Branch'] as $branchKey => $branchTitle)
                    <fieldset class="min-w-0 rounded-lg border border-border p-4">
                        <legend class="px-2 text-sm font-semibold text-black">{{ $branchTitle }}</legend>
                        @foreach (['name', 'address', 'phone'] as $part)
                            @php $key = 'branch_' . $branchKey . '_' . $part; @endphp
                            <div class="mb-4 last:mb-0">
                                <label for="{{ $key }}" class="mb-1 block text-sm font-medium text-black">{{ $fields[$key]['label'] }}</label>
                                <input type="text" id="{{ $key }}" name="{{ $key }}" required
                                    value="{{ old($key, $fields[$key]['value']) }}"
                                    class="w-full rounded-lg border border-border bg-background px-4 py-2.5 text-sm focus:border-primary focus:ring-primary">
                                <p class="mt-1 text-xs text-muted">{{ $fields[$key]['help'] }}</p>
                            </div>
                        @endforeach
                    </fieldset>
                @endforeach
            </div>
        </div>

        {{-- ---------------
        -- Social Media Links
        -- --------------- --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
            <h2 class="text-lg font-semibold text-black mb-1">Social Media Links</h2>
            <p class="text-sm text-muted mb-4">Icons only appear on the site for links that are filled in.</p>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                @foreach (['social_facebook', 'social_instagram', 'social_twitter', 'social_tiktok', 'social_youtube', 'social_linkedin'] as $key)
                    <div>
                        <label for="{{ $key }}" class="block text-sm font-medium text-black mb-1">{{ $fields[$key]['label'] }}</label>
                        <input type="url" id="{{ $key }}" name="{{ $key }}"
                               value="{{ old($key, $fields[$key]['value']) }}"
                               placeholder="https://"
                               class="w-full rounded-[8px] border border-border bg-background px-4 py-2.5 text-sm focus:border-primary focus:ring-primary">
                        <p class="mt-1 text-xs text-muted">{{ $fields[$key]['help'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="rounded-[8px] bg-primary px-6 py-2.5 text-sm font-semibold text-white hover:opacity-90">
                Save Settings
            </button>
        </div>
    </form>
@endsection
