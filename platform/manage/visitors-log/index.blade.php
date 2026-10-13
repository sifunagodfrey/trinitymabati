{{-- ---------------
-- Manage System: Visitors Log
-- --------------- --}}

@extends('manage.layouts.app')

@section('title', 'Visitors Log - Trinity Mabati Factory Admin')

@section('content')
<div>

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Visitors Log</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Visitors Log</h1>
                <p class="text-sm text-muted">Analytics and logs of all website visitors.</p>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Summary + Top Pages + Top Referrers (3-column grid)
    -- --------------- --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        {{-- Total Unique Visitors --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm flex flex-col justify-between">
            <p class="text-xs font-semibold text-muted uppercase tracking-wide mb-2">Total Unique Sessions</p>
            <div class="flex items-end gap-3">
                <span class="text-4xl font-bold text-black">{{ number_format($totalUniqueVisitors) }}</span>
            </div>
            <p class="text-xs text-muted mt-2">Based on distinct session IDs across all recorded visits.</p>
        </div>

        {{-- Top Pages --}}
        <div class="bg-background border border-border rounded-[12px] p-5 shadow-sm flex flex-col">
            <p class="text-xs font-semibold text-muted uppercase tracking-wide mb-3">Top Pages</p>
            <ul class="flex-1 divide-y divide-border" id="top-pages-list">
                @forelse($pagesRows as $page)
                    <li class="flex items-center justify-between px-3 py-2 hover:bg-slate-50">
                        <span class="font-mono text-xs text-text truncate">{{ $page->visited_url }}</span>
                        <span class="ml-3 shrink-0 inline-flex items-center rounded-[12px] bg-primary/10 text-primary text-xs px-2 py-0.5 font-semibold">{{ $page->visits }}</span>
                    </li>
                @empty
                    <li class="px-3 py-4 text-xs text-muted text-center">No data yet.</li>
                @endforelse
            </ul>
            @if($pagesHasMore)
                <div class="mt-3" id="pages-load-more-wrap">
                    <button id="load-more-pages"
                            type="button"
                            class="w-full rounded-[8px] border border-border bg-white py-2 text-xs font-medium text-primary hover:bg-slate-50 transition"
                            data-type="top_pages"
                            data-next-offset="{{ $pagesNext }}"
                            data-search="{{ e($search) }}">
                        Load more
                    </button>
                </div>
            @endif
        </div>

        {{-- Top Referrers --}}
        <div class="bg-background border border-border rounded-[12px] p-5 shadow-sm flex flex-col">
            <p class="text-xs font-semibold text-muted uppercase tracking-wide mb-3">Top Referrers</p>
            <ul class="flex-1 divide-y divide-border" id="top-ref-list">
                @forelse($refsRows as $ref)
                    <li class="flex items-center justify-between px-3 py-2 hover:bg-slate-50">
                        <span class="font-mono text-xs text-text truncate">{{ $ref->referrer_url }}</span>
                        <span class="ml-3 shrink-0 inline-flex items-center rounded-[12px] bg-emerald-100 text-emerald-800 text-xs px-2 py-0.5 font-semibold">{{ $ref->referrals }}</span>
                    </li>
                @empty
                    <li class="px-3 py-4 text-xs text-muted text-center">No referrers recorded.</li>
                @endforelse
            </ul>
            @if($refsHasMore)
                <div class="mt-3" id="refs-load-more-wrap">
                    <button id="load-more-refs"
                            type="button"
                            class="w-full rounded-[8px] border border-border bg-white py-2 text-xs font-medium text-primary hover:bg-slate-50 transition"
                            data-type="top_referrers"
                            data-next-offset="{{ $refsNext }}"
                            data-search="{{ e($search) }}">
                        Load more
                    </button>
                </div>
            @endif
        </div>

    </div>

    {{-- ---------------
    -- Main Card: Search + Visitor Log List
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        {{-- ---------------
        -- Search Bar
        -- --------------- --}}
        <form method="GET"
              action="{{ route('manage.visitors-log.index') }}"
              id="search-form"
              class="mb-6 flex flex-wrap items-center gap-3">

            <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                <input type="search"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Search by page URL, referrer, or user name..."
                       class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                @if($search)
                    <a href="{{ route('manage.visitors-log.index') }}"
                       class="pr-3 text-muted hover:text-red-400 transition text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-magnifying-glass"></i>
                Search
            </button>

            @if($search)
                <a href="{{ route('manage.visitors-log.index') }}"
                   class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-muted transition hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i>
                    Clear
                </a>
            @endif

            <a href="{{ route('manage.visitors-log.index', array_filter(['search' => $search, 'export' => 'csv'])) }}"
               class="inline-flex items-center gap-2 rounded-[12px] bg-emerald-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-emerald-700">
                <i class="fa-solid fa-file-csv text-xs"></i>
                Export CSV
            </a>

            <a href="{{ route('manage.visitors-log.index', array_filter(['search' => $search, 'export' => 'pdf'])) }}"
               class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-3 text-sm font-medium text-black transition hover:bg-slate-100">
                <i class="fa-solid fa-file-pdf text-xs text-red-600"></i>
                Export PDF
            </a>

        </form>

        {{-- ---------------
        -- Visitor Count
        -- --------------- --}}
        <p class="text-sm text-muted mb-3">
            Showing first results of
            <span class="font-semibold text-black" id="visitors-total">{{ number_format($visitorsTotal) }}</span>
            total log entries
            @if($search)
                matching <span class="text-primary">"{{ $search }}"</span>
            @endif
        </p>

        {{-- ---------------
        -- Visitor Log List
        -- --------------- --}}
        @if($visitorsTotal === 0)
            <div class="flex flex-col items-center gap-3 py-12 text-center text-muted">
                <i class="fa-solid fa-eye-slash text-3xl text-slate-300"></i>
                <span class="text-sm">No visitor logs found{{ $search ? ' for "'.e($search).'"' : '' }}.</span>
                @if($search)
                    <a href="{{ route('manage.visitors-log.index') }}" class="text-xs text-primary hover:underline">
                        Clear search
                    </a>
                @endif
            </div>
        @else
            <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
                <ul class="divide-y divide-border" id="visitor-log-list">
                    @foreach($visitorsRows as $log)
                        @php
                            $visitorName = ($log->first_name || $log->last_name)
                                ? trim(($log->first_name ?? '') . ' ' . ($log->last_name ?? ''))
                                : 'Guest';
                        @endphp
                        <li class="px-4 py-3 hover:bg-slate-50">
                            <div class="font-medium text-sm text-black">{{ $visitorName }}</div>
                            <div class="text-xs mt-0.5">
                                <span class="font-mono text-primary">{{ $log->visited_url }}</span>
                            </div>
                            <div class="text-xs text-muted mt-0.5">
                                Referrer: {{ $log->referrer_url ?: 'Direct' }}
                                &nbsp;&middot;&nbsp;
                                {{ $log->visit_time ?? '-' }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if($visitorsHasMore)
                <div class="mt-4" id="visitors-load-more-wrap">
                    <button id="load-more-visitors"
                            type="button"
                            class="w-full rounded-[12px] border border-border bg-white py-3 text-sm font-medium text-primary hover:bg-slate-50 transition"
                            data-type="visitors"
                            data-next-offset="{{ $visitorsNext }}"
                            data-search="{{ e($search) }}">
                        Load more ({{ number_format($visitorsTotal - $visitorsNext) }} remaining)
                    </button>
                </div>
            @endif
        @endif

    </div>

</div>
@endsection

@push('scripts')
{{-- ---------------
-- Load-more + search-refresh JS
-- --------------- --}}
<script>
(function () {
    // ---------------
    // Base AJAX URL (always this page, params appended per call)
    // ---------------
    const ajaxUrl = '{{ route('manage.visitors-log.index') }}';

    const lists = {
        visitors:      document.getElementById('visitor-log-list'),
        top_pages:     document.getElementById('top-pages-list'),
        top_referrers: document.getElementById('top-ref-list'),
    };

    const loadMoreIds = {
        visitors:      'load-more-visitors',
        top_pages:     'load-more-pages',
        top_referrers: 'load-more-refs',
    };

    const wrapIds = {
        visitors:      'visitors-load-more-wrap',
        top_pages:     'pages-load-more-wrap',
        top_referrers: 'refs-load-more-wrap',
    };

    // ---------------
    // Search: refresh all three sections via AJAX, keep URL in sync
    // ---------------
    const searchForm = document.getElementById('search-form');
    searchForm?.addEventListener('submit', async function (e) {
        e.preventDefault();
        const search = new FormData(searchForm).get('search') || '';

        await Promise.all([
            refreshSection('visitors', search),
            refreshSection('top_pages', search),
            refreshSection('top_referrers', search),
        ]);

        const url = new URL(window.location.href);
        search ? url.searchParams.set('search', search) : url.searchParams.delete('search');
        url.searchParams.delete('page');
        history.replaceState({}, '', url.toString());

        const totalEl = document.getElementById('visitors-total');
        // totalEl is updated inside refreshSection via returned total
    });

    // ---------------
    // Load more: delegate clicks on all three buttons
    // ---------------
    document.addEventListener('click', async function (e) {
        const btn = e.target.closest('#load-more-visitors, #load-more-pages, #load-more-refs');
        if (!btn) return;

        const type       = btn.dataset.type;
        const nextOffset = parseInt(btn.dataset.nextOffset || '0', 10);
        const search     = btn.dataset.search || '';

        btn.disabled    = true;
        btn.textContent = 'Loading…';

        try {
            const data = await fetchChunk(type, nextOffset, search);
            appendChunk(type, data, btn);
        } catch (err) {
            console.error(err);
            btn.textContent = 'Retry';
            btn.disabled    = false;
        }
    });

    // ---------------
    // Replace a section's list with fresh data from offset 0
    // ---------------
    async function refreshSection(type, search) {
        const data = await fetchChunk(type, 0, search);
        if (lists[type]) lists[type].innerHTML = data.html || '';
        syncLoadMoreButton(type, data, search);

        if (type === 'visitors') {
            const totalEl = document.getElementById('visitors-total');
            if (totalEl) totalEl.textContent = data.total?.toLocaleString() ?? '0';
        }
    }

    // ---------------
    // Append items from a load-more response
    // ---------------
    function appendChunk(type, data, btn) {
        if (data.html && lists[type]) {
            const temp = document.createElement('ul');
            temp.innerHTML = data.html;
            temp.querySelectorAll('li').forEach(li => lists[type].appendChild(li));
        }
        syncLoadMoreButton(type, data, btn.dataset.search || '');
    }

    // ---------------
    // Show, update, or remove the load-more button for a section
    // ---------------
    function syncLoadMoreButton(type, data, search) {
        let btn  = document.getElementById(loadMoreIds[type]);
        let wrap = document.getElementById(wrapIds[type]);

        if (!data.hasMore) {
            wrap?.remove();
            return;
        }

        if (!btn) {
            wrap = document.createElement('div');
            wrap.id = wrapIds[type];
            btn = document.createElement('button');
            btn.id = loadMoreIds[type];
            btn.type = 'button';
            btn.className = type === 'visitors'
                ? 'w-full rounded-[12px] border border-border bg-white py-3 text-sm font-medium text-primary hover:bg-slate-50 transition'
                : 'w-full rounded-[8px] border border-border bg-white py-2 text-xs font-medium text-primary hover:bg-slate-50 transition';
            wrap.className = 'mt-3';
            wrap.appendChild(btn);
            lists[type]?.closest('.flex-col, .bg-background')?.appendChild(wrap);
        }

        btn.dataset.type       = type;
        btn.dataset.nextOffset = String(data.nextOffset || 0);
        btn.dataset.search     = search || '';
        btn.disabled           = false;
        btn.textContent        = type === 'visitors'
            ? `Load more (${((data.total || 0) - (data.nextOffset || 0)).toLocaleString()} remaining)`
            : 'Load more';
    }

    // ---------------
    // Fetch one section chunk via AJAX
    // ---------------
    async function fetchChunk(type, offset, search) {
        const url = new URL(ajaxUrl);
        url.searchParams.set('ajax', '1');
        url.searchParams.set('type', type);
        url.searchParams.set('offset', String(offset));
        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');

        const res = await fetch(url.toString(), {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    }
})();
</script>
@endpush
