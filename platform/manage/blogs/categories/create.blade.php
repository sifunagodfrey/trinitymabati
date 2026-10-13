@extends('manage.layouts.app')

@section('title', 'New Blog Category - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.blogs.categories.index') }}" class="hover:text-primary">Categories</a></li>
                <li>/</li>
                <li class="text-black font-semibold">New Category</li>
            </ol>
        </nav>

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">New Blog Category</h1>
                <p class="text-sm text-muted">Create a new category to organise blog posts.</p>
            </div>
            <a href="{{ route('manage.blogs.categories.index') }}"
               class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm text-muted transition hover:bg-slate-100">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back
            </a>
        </div>
    </div>

    {{-- ---------------
    -- Validation Errors
    -- --------------- --}}
    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('manage.blogs.categories.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="max-w-2xl space-y-6">

            {{-- Name --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <label for="name" class="block text-sm font-medium text-black mb-1">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    placeholder="e.g. Business Tips"
                    oninput="autoSlug(this.value)"
                    class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <label for="slug" class="block text-sm font-medium text-black mb-1">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                    placeholder="auto-generated from name"
                    class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary @error('slug') border-red-400 @enderror">
                <p class="mt-1 text-xs text-muted">Leave blank to auto-generate from the name.</p>
                @error('slug')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <label for="description" class="block text-sm font-medium text-black mb-1">Description</label>
                <textarea name="description" id="description" rows="4"
                    placeholder="Optional description for this category..."
                    class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary resize-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Banner Image --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <label for="banner" class="block text-sm font-medium text-black mb-3">Banner Image</label>
                <input type="file" name="banner" id="banner" accept="image/*"
                    onchange="previewImage(this, 'banner-preview')"
                    class="w-full text-sm text-muted file:mr-3 file:rounded-[12px] file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-xs file:text-white file:cursor-pointer">
                <div id="banner-preview" class="mt-3 hidden">
                    <img src="" alt="Preview" class="w-full rounded-[12px] object-cover max-h-48 border border-border">
                </div>
                @error('banner')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- ---------------
            -- Form Actions
            -- --------------- --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('manage.blogs.categories.index') }}"
                   class="rounded-[12px] border border-border px-5 py-2.5 text-sm text-muted transition hover:bg-slate-100">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                    Save Category
                </button>
            </div>

        </div>

    </form>

@endsection

@push('scripts')
    <script>
        // ---------------
        // Auto-generate slug from category name
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

        // ---------------
        // Image preview helper
        // ---------------
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
