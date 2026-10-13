@extends('manage.layouts.app')

@section('title', 'Create Label')

@section('content')
    {{-- manage/products/labels/create.blade.php --}}

    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.products.labels.index') }}" class="hover:text-primary">Products</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Create Label</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Create Label</h1>
                <p class="text-sm text-muted">Add a new product label with a colour code.</p>
            </div>
            <a href="{{ route('manage.products.labels.index') }}"
                class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2 text-sm font-medium text-text transition hover:bg-slate-100">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Labels
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
        <form action="{{ route('manage.products.labels.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-text" for="name">Label Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    @error('name')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-4">
                    <label class="block text-sm font-medium text-text" for="color_code">Colour Code</label>
                    <div class="flex items-center gap-3">
                        <input id="color_code" name="color_code" type="color" value="{{ old('color_code', '#000000') }}"
                            class="h-12 w-24 cursor-pointer rounded-[8px] border border-border" />
                        <input type="text" name="color_code_text" value="{{ old('color_code', '#000000') }}"
                            class="flex-1 rounded-[8px] border border-border bg-background px-4 py-3 text-sm font-mono text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                            placeholder="#000000" x-data x-init="$watch('color_code', (val) => { $el.value = val; })" />
                    </div>
                    @error('color_code')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-medium text-text" for="description">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                    placeholder="Brief description of this label">{{ old('description') }}</textarea>
                @error('description')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col gap-3 border-t border-border pt-6 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('manage.products.labels.index') }}"
                    class="inline-flex items-center justify-center rounded-[8px] border border-border bg-background px-6 py-3 text-sm font-medium text-text transition hover:bg-slate-100">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-[8px] bg-primary px-6 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                    Create Label
                </button>
            </div>
        </form>
    </div>
@endsection