@extends('manage.layouts.app')

@section('title', 'Blog Tags - Trinity Mabati Factory Admin')

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
                <li class="text-black font-semibold">Tags</li>
            </ol>
        </nav>

        <div>
            <h1 class="text-2xl font-semibold text-black">Blog Tags</h1>
            <p class="text-sm text-muted">Add, edit, or remove tags used to label blog posts.</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ---------------
        -- Inline Add / Edit Form
        -- --------------- --}}
        <div class="lg:col-span-1">
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm sticky top-6">

                @if ($editTag)
                    <h2 class="text-base font-semibold text-black mb-4">Edit Tag</h2>
                    <form method="POST" action="{{ route('manage.blogs.tags.update', $editTag->id) }}">
                @else
                    <h2 class="text-base font-semibold text-black mb-4">Add New Tag</h2>
                    <form method="POST" action="{{ route('manage.blogs.tags.store') }}">
                @endif
                    @csrf

                    {{-- Tag Name --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-black mb-1">
                            Tag Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', $editTag->name ?? '') }}"
                            placeholder="e.g. Marketing"
                            oninput="autoSlug(this.value)"
                            class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary @error('name') border-red-400 @enderror">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="mb-6">
                        <label for="slug" class="block text-sm font-medium text-black mb-1">Slug</label>
                        <input type="text" name="slug" id="slug"
                            value="{{ old('slug', $editTag->slug ?? '') }}"
                            placeholder="auto-generated"
                            class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary @error('slug') border-red-400 @enderror">
                        <p class="mt-1 text-xs text-muted">Leave blank to auto-generate.</p>
                        @error('slug')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ---------------
                    -- Form Actions
                    -- --------------- --}}
                    <div class="flex justify-end gap-3">
                        @if ($editTag)
                            <a href="{{ route('manage.blogs.tags.index') }}"
                               class="rounded-[12px] border border-border px-4 py-2 text-sm text-muted transition hover:bg-slate-100">
                                Cancel
                            </a>
                            <button type="submit"
                                class="rounded-[12px] bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">
                                Update Tag
                            </button>
                        @else
                            <button type="submit"
                                class="w-full rounded-[12px] bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">
                                Add Tag
                            </button>
                        @endif
                    </div>

                </form>

            </div>
        </div>

        {{-- ---------------
        -- Tags Table
        -- --------------- --}}
        <div class="lg:col-span-2">
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

                <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-[560px] divide-y divide-border text-sm">
                            <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                                <tr>
                                    <th class="px-4 py-3">Tag Name</th>
                                    <th class="px-4 py-3">Slug</th>
                                    <th class="px-4 py-3 text-center">Posts</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border bg-white">
                                @forelse ($tags as $tag)
                                    <tr class="hover:bg-slate-50 {{ $editTag && $editTag->id === $tag->id ? 'bg-amber-50' : '' }}">
                                        <td class="px-4 py-3 font-medium text-black">
                                            {{ $tag->name }}
                                        </td>
                                        <td class="px-4 py-3 text-xs font-mono text-muted">
                                            {{ $tag->slug }}
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-muted">
                                            {{ $tag->posts_count }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-end gap-2">

                                                {{-- Edit (loads tag into form) --}}
                                                <a href="{{ route('manage.blogs.tags.index', ['edit' => $tag->id]) }}"
                                                   title="Edit Tag"
                                                   class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                                    <i class="fa-solid fa-pen text-xs"></i>
                                                </a>

                                                {{-- Delete --}}
                                                <form action="{{ route('manage.blogs.tags.destroy', $tag->id) }}"
                                                      method="POST" class="inline"
                                                      onsubmit="return confirm('Delete tag \'{{ addslashes($tag->name) }}\'? It will be removed from all posts.')">
                                                    @csrf
                                                    <button type="submit"
                                                        title="Delete Tag"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-red-200 bg-red-50 text-red-500 transition hover:bg-red-100">
                                                        <i class="fa-solid fa-trash text-xs"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-12 text-center text-sm text-muted">
                                            <div class="flex flex-col items-center gap-3">
                                                <i class="fa-solid fa-tags text-3xl text-slate-300"></i>
                                                <span>No tags yet. Add the first one using the form.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        // ---------------
        // Auto-generate slug from tag name
        // ---------------
        function autoSlug(value) {
            const slugField = document.getElementById('slug');
            if (slugField.dataset.locked) return;
            slugField.value = value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
        }

        document.getElementById('slug').addEventListener('input', function () {
            this.dataset.locked = this.value ? '1' : '';
        });
    </script>
@endpush
