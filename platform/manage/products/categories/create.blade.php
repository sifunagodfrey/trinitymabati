@extends('manage.layouts.app')

@section('title', 'Create Category')

@section('content')
    {{-- manage/products/categories/create.blade.php --}}

    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.products.categories.index') }}" class="hover:text-primary">Products</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Create Category</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Create Category</h1>
                <p class="text-sm text-muted">Add a new product category and assign commission settings.</p>
            </div>
            <a href="{{ route('manage.products.categories.index') }}"
                class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2 text-sm font-medium text-text transition hover:bg-slate-100">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Categories
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            <p class="font-semibold">Please correct the highlighted fields.</p>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
        <form action="{{ route('manage.products.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-text" for="name">Category Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    @error('name')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-4">
                    <label class="block text-sm font-medium text-text" for="parent_id">Parent Category</label>
                    <select id="parent_id" name="parent_id"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        <option value="">Root category</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-text" for="featured_image">Featured Image</label>
                    <input id="featured_image" name="featured_image" type="file" accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition file:rounded-[8px] file:border-none file:bg-primary file:px-3 file:py-2 file:text-white file:font-semibold file:cursor-pointer focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    @error('featured_image')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-text" for="icon">Category Icon</label>
                    <input id="icon" name="icon" type="file" accept="image/jpeg,image/png,image/webp,svg+xml"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition file:rounded-[8px] file:border-none file:bg-primary file:px-3 file:py-2 file:text-white file:font-semibold file:cursor-pointer focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    @error('icon')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-text" for="banner_image">Banner Image</label>
                    <input id="banner_image" name="banner_image" type="file" accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition file:rounded-[8px] file:border-none file:bg-primary file:px-3 file:py-2 file:text-white file:font-semibold file:cursor-pointer focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    @error('banner_image')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-medium text-text" for="description">Description</label>
                <textarea id="description" name="description" rows="5"
                    class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">{{ old('description') }}</textarea>
                @error('description')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- --------------- --}}
            {{-- Default Category --}}
            {{-- --------------- --}}
            <div class="rounded-[8px] border border-border bg-background p-4">
                <label class="flex cursor-pointer items-start gap-3">
                    <input type="radio" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}
                        class="mt-1 h-4 w-4 border-border text-primary focus:ring-primary/30" />
                    <span>
                        <span class="block text-sm font-medium text-text">Set as default category</span>
                        <span class="block text-xs text-muted">Products saved without a category are placed here. Only one category can be the default, so choosing this replaces the current one.</span>
                    </span>
                </label>
            </div>

            <div class="flex flex-col gap-3 border-t border-border pt-6 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('manage.products.categories.index') }}"
                    class="inline-flex items-center justify-center rounded-[8px] border border-border bg-background px-6 py-3 text-sm font-medium text-text transition hover:bg-slate-100">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-[8px] bg-primary px-6 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                    Create Category
                </button>
            </div>
        </form>
    </div>
@endsection