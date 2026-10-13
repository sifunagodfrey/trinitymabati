{{-- -------------------
     Admin Content - Site Pages List
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'Site Pages - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Site Pages</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Site Pages</h1>
                <p class="text-sm text-muted">Edit the refund policy, terms, privacy policy and other site pages.</p>
            </div>
            <a href="{{ route('manage.content.pages.create') }}"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-plus"></i>
                Add Page
            </a>
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

    {{-- ---------------
    -- Pages Table
    -- --------------- --}}
    <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[600px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Updated</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($pages as $page)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-medium text-black">{{ $page->title }}</td>
                            <td class="px-4 py-4">
                                <span class="font-mono text-xs text-muted">/pages/{{ $page->slug }}</span>
                            </td>
                            <td class="px-4 py-4 text-xs text-muted">
                                {{ optional($page->updated_at ?? $page->created_at)->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                                    {{ $page->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $page->is_active ? 'Published' : 'Hidden' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    {{-- Edit --}}
                                    <a href="{{ route('manage.content.pages.edit', $page->id) }}" title="Edit"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-muted transition hover:bg-slate-100 hover:text-black">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    {{-- Toggle --}}
                                    <form method="POST" action="{{ route('manage.content.pages.toggle', $page->id) }}">
                                        @csrf
                                        <button type="submit"
                                            title="{{ $page->is_active ? 'Hide' : 'Publish' }}"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border transition
                                                {{ $page->is_active
                                                    ? 'border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100'
                                                    : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                            <i class="fa-solid {{ $page->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-xs"></i>
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('manage.content.pages.destroy', $page->id) }}"
                                          onsubmit="return confirm('Delete this page permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-rose-200 bg-rose-50 text-rose-600 transition hover:bg-rose-100">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-sm text-muted">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fa-solid fa-file-lines text-3xl text-slate-300"></i>
                                    <span>No pages yet. Add your first page.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ---------------
    -- Pagination
    -- --------------- --}}
    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-muted">
            Showing {{ $pages->firstItem() ?? 0 }} - {{ $pages->lastItem() ?? 0 }}
            of {{ $pages->total() }} pages
        </p>
        <div>{{ $pages->links() }}</div>
    </div>

@endsection
