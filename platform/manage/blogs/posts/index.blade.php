@extends('manage.layouts.app')

@section('title', 'Blog Posts - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Blog Posts</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Blog Posts</h1>
                <p class="text-sm text-muted">Manage all blog articles published on the platform.</p>
            </div>
            <a href="{{ route('manage.blogs.posts.create') }}"
               class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-plus"></i>
                New Post
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
        -- Search + Filters
        -- --------------- --}}
        <form method="GET" action="{{ route('manage.blogs.posts.index') }}"
              class="mb-6 flex flex-wrap items-center gap-3">

            <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search by title..."
                    class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                @if (request('search'))
                    <a href="{{ route('manage.blogs.posts.index', request()->except(['search', 'page'])) }}"
                       class="pr-3 text-muted hover:text-red-400 transition text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <select name="status" onchange="this.form.submit()"
                class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                <option value="">All Statuses</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
            </select>

            <select name="category_id" onchange="this.form.submit()"
                class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </button>

            @if (request()->hasAny(['search', 'status', 'category_id']))
                <a href="{{ route('manage.blogs.posts.index') }}"
                   class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-3 text-sm text-muted transition hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i> Clear
                </a>
            @endif

        </form>

        {{-- ---------------
        -- Posts Table
        -- --------------- --}}
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[840px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Author</th>
                            <th class="px-4 py-3">Category</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Views</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($posts as $post)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($post->thumbnail)
                                            <img src="{{ asset($post->thumbnail) }}"
                                                 alt="Thumbnail"
                                                 class="w-10 h-10 rounded-[8px] object-cover flex-shrink-0 border border-border">
                                        @else
                                            <div class="w-10 h-10 rounded-[8px] bg-slate-100 border border-border flex items-center justify-center flex-shrink-0">
                                                <i class="fa-solid fa-image text-slate-300 text-xs"></i>
                                            </div>
                                        @endif
                                        <span class="font-medium text-black line-clamp-2 max-w-xs">
                                            {{ $post->title }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-black">
                                    {{ optional($post->author)->first_name }} {{ optional($post->author)->last_name }}
                                </td>
                                <td class="px-4 py-4 text-sm text-muted">
                                    {{ optional($post->category)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if ($post->is_published)
                                        <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-amber-100 text-amber-800">
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-muted">
                                    {{ number_format($post->views ?? 0) }}
                                </td>
                                <td class="px-4 py-4 text-xs text-muted whitespace-nowrap">
                                    {{ $post->created_at?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">

                                        {{-- ---------------
                                        -- Toggle publish
                                        -- --------------- --}}
                                        <form action="{{ route('manage.blogs.posts.toggle-publish', $post->id) }}"
                                              method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                title="{{ $post->is_published ? 'Unpublish' : 'Publish' }}"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                                <i class="fa-solid {{ $post->is_published ? 'fa-eye-slash' : 'fa-eye' }} text-xs"></i>
                                            </button>
                                        </form>

                                        {{-- ---------------
                                        -- Edit
                                        -- --------------- --}}
                                        <a href="{{ route('manage.blogs.posts.edit', $post->id) }}"
                                           title="Edit Post"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        {{-- ---------------
                                        -- Delete
                                        -- --------------- --}}
                                        <form action="{{ route('manage.blogs.posts.destroy', $post->id) }}"
                                              method="POST" class="inline"
                                              onsubmit="return confirm('Delete this post? This cannot be undone.')">
                                            @csrf
                                            <button type="submit"
                                                title="Delete Post"
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
                                        <i class="fa-solid fa-newspaper text-3xl text-slate-300"></i>
                                        <span>No blog posts found. Try adjusting your search or filters.</span>
                                        @if (request()->hasAny(['search', 'status', 'category_id']))
                                            <a href="{{ route('manage.blogs.posts.index') }}"
                                               class="text-xs text-primary hover:underline">Clear filters</a>
                                        @endif
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
                Showing {{ $posts->firstItem() ?? 0 }} – {{ $posts->lastItem() ?? 0 }}
                of {{ $posts->total() }} posts
            </p>
            <div>{{ $posts->links() }}</div>
        </div>

    </div>

@endsection
