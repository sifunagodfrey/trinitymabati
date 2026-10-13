@extends('manage.layouts.app')

@section('title', 'Create Brand')

@section('content')
    {{-- manage/products/brands/create.blade.php --}}

    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.products.brands.index') }}" class="hover:text-primary">Products</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Create Brand</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Create Brand</h1>
                <p class="text-sm text-muted">Add a new product brand with logo and banner.</p>
            </div>
            <a href="{{ route('manage.products.brands.index') }}"
                class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2 text-sm font-medium text-text transition hover:bg-slate-100">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Brands
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
        <form id="brand-create-form" action="{{ route('manage.products.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="space-y-4">
                <label class="block text-sm font-medium text-text" for="name">Brand Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}"
                    class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                @error('name')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-text" for="logo">Brand Logo</label>
                    <input id="logo" name="logo" type="file" accept="image/jpeg,image/png,image/webp,svg+xml"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition file:rounded-[8px] file:border-none file:bg-primary file:px-3 file:py-2 file:text-white file:font-semibold file:cursor-pointer focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    <p class="text-xs text-muted">Recommended: 2:1 aspect ratio (e.g. 400&times;200px, 800&times;400px).</p>
                    <p id="logo-ratio-error" class="text-sm text-red-500 hidden"></p>
                    @error('logo')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
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

            <div class="flex flex-col gap-3 border-t border-border pt-6 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('manage.products.brands.index') }}"
                    class="inline-flex items-center justify-center rounded-[8px] border border-border bg-background px-6 py-3 text-sm font-medium text-text transition hover:bg-slate-100">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-[8px] bg-primary px-6 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                    Create Brand
                </button>
            </div>
        </form>
    </div>

    <script>
        (function () {
            const logoInput = document.getElementById('logo');
            const errorEl = document.getElementById('logo-ratio-error');
            const form = document.getElementById('brand-create-form');

            if (!logoInput || !errorEl || !form) return;

            const TARGET_RATIO = 2 / 1;
            const TOLERANCE = 0.05; // allow ~5% wiggle room, e.g. 396x200 still passes
            let logoIsValid = true;

            function resetError() {
                errorEl.textContent = '';
                errorEl.classList.add('hidden');
            }

            function showError(message) {
                errorEl.textContent = message;
                errorEl.classList.remove('hidden');
            }

            logoInput.addEventListener('change', function () {
                resetError();
                logoIsValid = true;

                const file = logoInput.files[0];
                if (!file) return;

                // SVGs are vector-based; there's no reliable pixel ratio to check client-side.
                if (file.type === 'image/svg+xml') return;

                const objectUrl = URL.createObjectURL(file);
                const img = new Image();

                img.onload = function () {
                    URL.revokeObjectURL(objectUrl);

                    const ratio = img.naturalWidth / img.naturalHeight;

                    if (Math.abs(ratio - TARGET_RATIO) > TOLERANCE) {
                        logoIsValid = false;
                        showError(
                            `This image is ${img.naturalWidth}×${img.naturalHeight}px (about ${ratio.toFixed(2)}:1). ` +
                            `Please upload a logo close to a 2:1 ratio, e.g. 400×200px.`
                        );
                        logoInput.value = '';
                    }
                };

                img.onerror = function () {
                    URL.revokeObjectURL(objectUrl);
                };

                img.src = objectUrl;
            });

            form.addEventListener('submit', function (e) {
                if (!logoIsValid) {
                    e.preventDefault();
                }
            });
        })();
    </script>
@endsection