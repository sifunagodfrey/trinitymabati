{{-- ---------------
-- Manage Newsletters Index
-- Campaigns list + compose form + subscribers table
-- --------------- --}}
@extends('manage.layouts.app')

@section('title', 'Newsletters - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Newsletters</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Newsletters</h1>
                <p class="text-sm text-muted">Compose and send email campaigns to your subscribers.</p>
            </div>
            <button
                x-data
                @click="$dispatch('open-compose')"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-semibold rounded-[12px] hover:opacity-90 transition">
                <i class="fas fa-paper-plane text-xs"></i>
                Compose Campaign
            </button>
        </div>
    </div>

    {{-- ---------------
    -- Session Alerts
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    {{-- ---------------
    -- Compose Campaign Modal
    -- --------------- --}}
    <div
        x-data="{ open: false }"
        x-on:open-compose.window="open = true"
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">

        <div
            @click.outside="open = false"
            class="w-full max-w-2xl max-h-[90vh] overflow-y-auto bg-white rounded-[12px] shadow-xl">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-border">
                <h2 class="text-base font-semibold text-black">Compose Newsletter Campaign</h2>
                <button @click="open = false" class="text-muted hover:text-black transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Compose Form --}}
            <form method="POST" action="{{ route('manage.newsletters.store') }}" class="p-6 space-y-5">
                @csrf

                {{-- Subject --}}
                <div>
                    <label class="block text-sm font-semibold text-black mb-1">Subject <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="subject"
                        value="{{ old('subject') }}"
                        placeholder="e.g. New arrivals this week!"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none focus:border-primary transition"
                        required>
                </div>

                {{-- Audience --}}
                <div>
                    <label class="block text-sm font-semibold text-black mb-1">Audience <span class="text-red-500">*</span></label>
                    <select
                        name="audience"
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none focus:border-primary transition"
                        required>
                        <option value="all" {{ old('audience') === 'all' ? 'selected' : '' }}>All Verified Subscribers</option>
                        <option value="promotions" {{ old('audience') === 'promotions' ? 'selected' : '' }}>Promotions subscribers</option>
                        <option value="suggestions" {{ old('audience') === 'suggestions' ? 'selected' : '' }}>Suggestions &amp; Recommendations subscribers</option>
                        <option value="order_updates" {{ old('audience') === 'order_updates' ? 'selected' : '' }}>Order Updates subscribers</option>
                        <option value="news_updates" {{ old('audience') === 'news_updates' ? 'selected' : '' }}>News Updates subscribers</option>
                    </select>
                </div>

                {{-- Message --}}
                <div>
                    <label class="block text-sm font-semibold text-black mb-1">Message <span class="text-red-500">*</span></label>
                    <textarea
                        name="message"
                        rows="8"
                        placeholder="Write your newsletter message here..."
                        class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none focus:border-primary transition resize-none"
                        required>{{ old('message') }}</textarea>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" @click="open = false"
                        class="px-5 py-2.5 text-sm font-semibold text-muted border border-border rounded-[12px] hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-[12px] hover:opacity-90 transition">
                        <i class="fas fa-paper-plane mr-1.5 text-xs"></i>
                        Send Campaign
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ---------------
    -- Campaigns Table
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-8">

        <h2 class="text-base font-semibold text-black mb-5">Sent Campaigns</h2>

        @if ($campaigns->isNotEmpty())

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[600px]">
                    <thead>
                        <tr class="border-b border-border text-left">
                            <th class="pb-3 pr-4 font-semibold text-muted">Subject</th>
                            <th class="pb-3 pr-4 font-semibold text-muted">Audience</th>
                            <th class="pb-3 pr-4 font-semibold text-muted">Status</th>
                            <th class="pb-3 pr-4 font-semibold text-muted">Sent At</th>
                            <th class="pb-3 font-semibold text-muted">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach ($campaigns as $campaign)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 pr-4 font-medium text-black">
                                    {{ Str::limit($campaign->subject, 50) }}
                                </td>
                                <td class="py-4 pr-4">
                                    @php
                                        $audienceLabels = [
                                            'all'           => 'All Subscribers',
                                            'promotions'    => 'Promotions',
                                            'suggestions'   => 'Suggestions',
                                            'order_updates' => 'Order Updates',
                                            'news_updates'  => 'News Updates',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-[12px] text-xs font-semibold bg-blue-100 text-blue-700">
                                        {{ $audienceLabels[$campaign->audience] ?? ucfirst($campaign->audience) }}
                                    </span>
                                </td>
                                <td class="py-4 pr-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-[12px] text-xs font-semibold
                                        {{ $campaign->status === 'Sent' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $campaign->status }}
                                    </span>
                                </td>
                                <td class="py-4 pr-4 text-muted text-xs">
                                    {{ $campaign->created_at?->format('d M Y, h:i A') }}
                                </td>
                                <td class="py-4">
                                    <form method="POST" action="{{ route('manage.newsletters.destroy', $campaign->id) }}"
                                          onsubmit="return confirm('Delete this campaign?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[8px] hover:bg-red-200 transition">
                                            <i class="fas fa-trash text-xs"></i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($campaigns->hasPages())
                <div class="mt-6">
                    {{ $campaigns->links() }}
                </div>
            @endif

        @else
            <div class="text-center py-16">
                <div class="w-16 h-16 rounded-[12px] bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-2xl text-gray-300"></i>
                </div>
                <p class="text-muted text-sm">No campaigns sent yet.</p>
            </div>
        @endif

    </div>

    {{-- ---------------
    -- Subscribers Table
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-5">
            <h2 class="text-base font-semibold text-black">Subscribers</h2>

            {{-- Filter by consent type --}}
            <form method="GET" action="{{ route('manage.newsletters.index') }}" class="flex items-center gap-2">
                <select name="consent" onchange="this.form.submit()"
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none transition focus:border-primary">
                    <option value="">All Verified</option>
                    <option value="promotions" {{ $filterConsent === 'promotions' ? 'selected' : '' }}>Promotions</option>
                    <option value="suggestions" {{ $filterConsent === 'suggestions' ? 'selected' : '' }}>Suggestions</option>
                    <option value="order_updates" {{ $filterConsent === 'order_updates' ? 'selected' : '' }}>Order Updates</option>
                    <option value="news_updates" {{ $filterConsent === 'news_updates' ? 'selected' : '' }}>News Updates</option>
                </select>
                @if ($filterConsent)
                    <a href="{{ route('manage.newsletters.index') }}"
                        class="text-xs text-muted hover:text-red-500 transition">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
            </form>
        </div>

        @if ($subscribers->isNotEmpty())

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[720px]">
                    <thead>
                        <tr class="border-b border-border text-left">
                            <th class="pb-3 pr-4 font-semibold text-muted">Email</th>
                            <th class="pb-3 pr-4 font-semibold text-muted">Promotions</th>
                            <th class="pb-3 pr-4 font-semibold text-muted">Suggestions</th>
                            <th class="pb-3 pr-4 font-semibold text-muted">Order Updates</th>
                            <th class="pb-3 pr-4 font-semibold text-muted">News</th>
                            <th class="pb-3 font-semibold text-muted">Subscribed</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach ($subscribers as $subscriber)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 pr-4 text-black font-medium">{{ $subscriber->email }}</td>

                                @php
                                    $yesClass = 'inline-flex items-center px-2 py-0.5 rounded-[12px] text-xs font-semibold bg-emerald-100 text-emerald-700';
                                    $noClass  = 'inline-flex items-center px-2 py-0.5 rounded-[12px] text-xs font-semibold bg-gray-100 text-gray-500';
                                @endphp

                                <td class="py-3 pr-4">
                                    <span class="{{ $subscriber->receive_promotions ? $yesClass : $noClass }}">
                                        {{ $subscriber->receive_promotions ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="py-3 pr-4">
                                    <span class="{{ $subscriber->receive_suggestions ? $yesClass : $noClass }}">
                                        {{ $subscriber->receive_suggestions ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="py-3 pr-4">
                                    <span class="{{ $subscriber->receive_order_updates ? $yesClass : $noClass }}">
                                        {{ $subscriber->receive_order_updates ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="py-3 pr-4">
                                    <span class="{{ $subscriber->receive_news_updates ? $yesClass : $noClass }}">
                                        {{ $subscriber->receive_news_updates ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="py-3 text-muted text-xs">
                                    {{ $subscriber->subscribed_at?->format('d M Y') ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination (preserve consent filter) --}}
            @if ($subscribers->hasPages())
                <div class="mt-6">
                    {{ $subscribers->appends(request()->only('consent'))->links() }}
                </div>
            @endif

        @else
            <div class="text-center py-16">
                <div class="w-16 h-16 rounded-[12px] bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-2xl text-gray-300"></i>
                </div>
                <p class="text-muted text-sm">No subscribers found for this filter.</p>
            </div>
        @endif

    </div>

@endsection
