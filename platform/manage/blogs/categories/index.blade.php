@extends('manage.layouts.app')

@section('title', 'Blog Categories - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.blogs.posts.index') }}" class="hover:text-primary">Blog Posts</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Categories</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Blog Categories</h1>
                <p class="text-sm text-muted">Organise your blog content with categories.</p>
            </div>
            <a href="{{ route('manage.blogs.categories.create') }}"
               class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-plus"></i>
                New Category
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
    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        {{-- ---------------
        -- Categories Table
        -- --------------- --}}
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[840px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">Banner</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Slug</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3 text-center">Posts</th>
                            <th class="px-4 py-3">Created</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-4">
                                    @if ($category->banner)
                                        <img src="{{ asset($category->banner) }}"
                                             alt="{{ $category->name }}"
                                             class="w-14 h-10 rounded-[8px] object-cover border border-border">
                                    @else
                                        <div class="w-14 h-10 rounded-[8px] bg-slate-100 border border-border flex items-center justify-center">
                                            <i class="fa-solid fa-image text-slate-300 text-xs"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 font-medium text-black">{{ $category->name }}</td>
                                <td class="px-4 py-4 text-xs font-mono text-muted">{{ $category->slug }}</td>
                                <td class="px-4 py-4 text-sm text-muted max-w-xs">
                                    <span class="line-clamp-2">{{ $category->description ?: '-' }}</span>
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-black">
                                    {{ $category->posts_count }}
                                </td>
                                <td class="px-4 py-4 text-xs text-muted whitespace-nowrap">
                                    {{ $category->created_at ? \Carbon\Carbon::parse($category->created_at)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">

                                        {{-- Edit --}}
                                        <a href="{{ route('manage.blogs.categories.edit', $category->id) }}"
                                           title="Edit Category"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('manage.blogs.categories.destroy', $category->id) }}"
                                              method="POST" class="inline"
                                              onsubmit="return confirm('Delete this category? Posts in it will become uncategorised.')">
                                            @csrf
                                            <button type="submit"
                                                title="Delete Category"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-red-200 bg-red-50 text-red-500 transition hover:bg-red-100">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-sm text-muted">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="fa-solid fa-folder-open text-3xl text-slate-300"></i>
                                        <span>No categories yet.</span>
                                        <a href="{{ route('manage.blogs.categories.create') }}"
                                           class="text-xs text-primary hover:underline">Create the first category</a>
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
        @if ($categories->hasPages())
            <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-muted">
                    Showing {{ $categories->firstItem() }} – {{ $categories->lastItem() }}
                    of {{ $categories->total() }} categories
                </p>
                <div>{{ $categories->links() }}</div>
            </div>
        @endif

    </div>

@endsection
