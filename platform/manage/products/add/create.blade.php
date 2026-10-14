@extends('manage.layouts.app')

@section('title', 'Create Product')

@section('content')
    {{-- manage/products/add/create.blade.php --}}

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.products.all.index') }}" class="hover:text-primary">Products</a></li>
                <li>/</li>
                <li class="text-text font-semibold">Add Product</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-text">Add New Product</h1>
                <p class="text-sm text-muted">Create a new product and assign it to a category, brand, and label.</p>
            </div>
            <a href="{{ route('manage.products.all.index') }}"
                class="inline-flex items-center gap-2 rounded-[8px] border border-border bg-background px-4 py-2 text-sm font-medium text-text hover:bg-border transition">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Products
            </a>
        </div>
    </div>

    <div class="product-editor-shell">

        {{-- ---------------
        -- Validation Error Summary
        -- --------------- --}}
        @if ($errors->any())
            <div class="mb-6 rounded-[8px] border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-semibold">Please fix the errors below.</p>
                <ul class="mt-2 space-y-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('manage.products.add.store') }}" method="POST" enctype="multipart/form-data"
            id="productCreateForm" class="product-editor-form">
            @csrf

            {{-- ---------------
            -- Product Identity: Name and SKU
            -- --------------- --}}
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-text" for="name">Product Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    {{-- Slug preview - populated by JS as the user types --}}
                    <p id="slugPreview" class="text-xs text-muted font-mono hidden">
                        Slug: <span id="slugPreviewText"></span>
                    </p>
                    @error('name')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-medium text-text" for="sku">SKU</label>
                        <button type="button" id="regenerateSku"
                            class="inline-flex items-center gap-1 text-xs text-primary hover:underline">
                            <i class="fa-solid fa-rotate-right"></i> Regenerate
                        </button>
                    </div>
                    <input id="sku" name="sku" type="text" value="{{ old('sku') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                        placeholder="Auto-generated from product name" />
                    <p class="text-xs text-muted">Auto-generated when you type the product name. Override manually if needed.</p>
                    @error('sku')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

            </div>

            <div class="rounded-lg border border-gray-200 p-4 my-4 space-y-3">
                <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="allow_custom_length" value="1" { old('allow_custom_length', false) ? 'checked' : '' }> Allow custom sheet length (priced per metre)</label>
                <label class="block text-sm">Default length (metres)
                    <input type="number" name="default_length_m" min="0.1" max="30" step="0.01" value="{{ old('default_length_m', 3) }}" class="block w-36 rounded border px-3 py-2 mt-1">
                </label>
                <p class="text-xs text-gray-500">For enabled products, product and variant prices are rates per metre. The customer can enter 0.10–30.00 metres. Default is 3 m.</p>
            </div>
            {{-- ---------------
            -- Classification: Category, Brand, Label
            -- --------------- --}}
            <div class="">
                @php
                    $categoryOptions = [];
                    foreach ($categories as $category) {
                        $categoryOptions[] = ['id' => $category->id, 'name' => $category->name];
                        foreach ($category->children as $child) {
                            $categoryOptions[] = ['id' => $child->id, 'name' => '— ' . $child->name];
                        }
                    }
                    $labelOptions = $labels->map(fn ($label) => ['id' => $label->id, 'name' => $label->name])->values()->toArray();
                @endphp

                @include('manage.products.partials.search-select', [
                    'name'        => 'category_ids',
                    'label'       => 'Categories',
                    'options'     => $categoryOptions,
                    'selected'    => old('category_ids', []),
                    'placeholder' => 'Search categories…',
                ])

                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-text" for="brand_id">Brand</label>
                        <select id="brand_id" name="brand_id"
                            class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                            <option value="">Select brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                @include('manage.products.partials.search-select', [
                    'name'        => 'label_ids',
                    'label'       => 'Labels',
                    'options'     => $labelOptions,
                    'selected'    => old('label_ids', []),
                    'placeholder' => 'Search labels…',
                ])
            </div>

            {{-- ---------------
            -- Product Type: Variant flag (placed before pricing)
            -- --------------- --}}
            <div class="rounded-[8px] border border-border bg-background p-5 space-y-3">
                <div>
                    <h3 class="text-sm font-semibold text-text">Product Type</h3>
                    <p class="text-xs text-muted mt-1">Enable variants for products sold in multiple options such as size or color.</p>
                </div>
                <div class="flex flex-wrap gap-6">
                    <label class="inline-flex items-center gap-2 text-sm text-text cursor-pointer">
                        <input type="checkbox" id="is_variant_toggle" name="is_variant" value="1" {{ old('is_variant') ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-border text-primary focus:ring-primary" />
                        Has Variants
                    </label>
                </div>
            </div>

            {{-- ---------------
            -- Variants: Define attributes and generate the variant matrix
            -- --------------- --}}
            <div id="variantSection" class="hidden space-y-4 rounded-[8px] border border-border p-5">
                <h3 class="text-sm font-semibold text-text">Product Attributes &amp; Variants</h3>
                <p class="text-xs text-muted">Define attributes (e.g. Color, Size) and their comma-separated values, then click <strong>Generate Variants</strong>. SKUs are auto-generated per variant.</p>

                {{-- Attribute rows - one per attribute type --}}
                <div id="attributesContainer" class="space-y-3">
                    <div class="attribute-group grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                        <div class="sm:col-span-5">
                            <input type="text" name="attributes[0][name]"
                                class="w-full rounded-[8px] border border-border bg-background px-4 py-2 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                placeholder="Attribute name (e.g. Color)" />
                        </div>
                        <div class="sm:col-span-5">
                            <input type="text" name="attributes[0][values]"
                                class="w-full rounded-[8px] border border-border bg-background px-4 py-2 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                placeholder="Values comma-separated (e.g. Red,Blue)" />
                        </div>
                        <div class="sm:col-span-2 flex justify-end">
                            <button type="button"
                                class="remove-attribute hidden rounded-[8px] border border-red-300 bg-red-50 px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-100 transition">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button type="button" id="addAttribute"
                        class="inline-flex items-center gap-2 rounded-[8px] border border-border bg-background px-4 py-2 text-sm font-medium text-text hover:bg-border transition">
                        <i class="fa-solid fa-plus-circle"></i> Add Attribute
                    </button>
                    <button type="button" id="generateVariants"
                        class="inline-flex items-center gap-2 rounded-[8px] bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary/90 transition">
                        <i class="fa-solid fa-cogs"></i> Generate Variants
                    </button>
                </div>

                <div id="variantsTable" class="hidden">
                    <p class="mb-3 text-xs text-muted">Enter a price for each customer option. SKU is a technical inventory reference, not a customer-facing name.</p>
                    <div id="variantRows" class="grid grid-cols-1 gap-4 xl:grid-cols-2"></div>
                </div>
            </div>

            {{-- ---------------
            -- Pricing: Cost, Selling (mandatory) and Strike-through
            -- --------------- --}}
            <div>
                <h3 class="text-sm font-semibold text-text">Pricing</h3>
                <p class="text-xs text-muted mt-1">Selling price is what the customer pays. The strike-through price shows crossed out next to it. Cost price is internal and only used for profit reports. For variant products, set prices per variant above.</p>
            </div>
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-text" for="cost_price">Cost Price</label>
                    <input id="cost_price" name="cost_price" type="number" step="0.01" min="0" value="{{ old('cost_price') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    <p class="text-xs text-muted">What you paid. Never shown to customers.</p>
                    @error('cost_price')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-text" for="selling_price">Selling Price <span class="text-red-500">*</span></label>
                    <input id="selling_price" name="selling_price" type="number" step="0.01" min="0" value="{{ old('selling_price') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    <p class="text-xs text-muted">Required for simple products. Variant products use per-variant prices.</p>
                    @error('selling_price')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-text" for="strikethrough_price">Strike-through Price</label>
                    <input id="strikethrough_price" name="strikethrough_price" type="number" step="0.01" min="0" value="{{ old('strikethrough_price') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    <p class="text-xs text-muted">Optional. Must be higher than the selling price.</p>
                    @error('strikethrough_price')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- ---------------
            -- Inventory: Stock Quantity, Currency (freight cost removed)
            -- --------------- --}}
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-text" for="stock_quantity">Stock Quantity</label>
                    <input id="stock_quantity" name="stock_quantity" type="number" value="{{ old('stock_quantity') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    @error('stock_quantity')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-text" for="currency">Currency</label>
                    <select id="currency" name="currency"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        <option value="KES" {{ old('currency', 'KES') == 'KES' ? 'selected' : '' }}>KES</option>
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                    </select>
                    @error('currency')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- ---------------
            -- Dimensions & Weight (used for shipping cost calculations)
            -- --------------- --}}
            <div class="grid gap-6 lg:grid-cols-4">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-text" for="weight">Weight (kg)</label>
                    <input id="weight" name="weight" type="number" step="0.01" value="{{ old('weight') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    @error('weight')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-text" for="length">Length (cm)</label>
                    <input id="length" name="length" type="number" step="0.01" value="{{ old('length') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    @error('length')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-text" for="width">Width (cm)</label>
                    <input id="width" name="width" type="number" step="0.01" value="{{ old('width') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    @error('width')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-text" for="height">Height (cm)</label>
                    <input id="height" name="height" type="number" step="0.01" value="{{ old('height') }}"
                        class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                    @error('height')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- ---------------
            -- Short Description (max 20 words)
            -- --------------- --}}
            <div class="max-w-2xl space-y-2">
                <label class="block text-sm font-medium text-text" for="short_description">Short Description</label>
                <textarea id="short_description" name="short_description" rows="3"
                    class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">{{ old('short_description') }}</textarea>
                <div class="flex items-center justify-between">
                    <p class="text-xs text-muted">A concise summary shown in product listings.</p>
                    <p id="shortWordCount" class="text-xs text-muted">0 / 20 words</p>
                </div>
                @error('short_description')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- ---------------
            -- Detailed Description (full-width own row, rich text editor)
            -- --------------- --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-text">Detailed Description</label>
                <p class="text-xs text-muted">Recommended 200–300 words for best SEO and buyer experience.</p>
                <div id="detailed_description_editor"></div>
                <input type="hidden" name="detailed_description" id="detailed_description_hidden"
                    value="{{ old('detailed_description') }}" />
                <div class="flex justify-end">
                    <p id="detailedWordCount" class="text-xs text-muted">0 words</p>
                </div>
                @error('detailed_description')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- ---------------
            -- Media: Product Image and Gallery (upload from device or choose from library)
            -- --------------- --}}
            <div class="grid gap-6 lg:grid-cols-2 bg-background">

                {{-- Thumbnail --}}
                <div class="rounded-[8px] border border-border bg-white p-5 space-y-2">
                    <label class="block text-sm font-medium text-text">Product Image</label>
                    <div class="flex flex-wrap gap-2">
                        <label for="thumbnail"
                            class="inline-flex items-center gap-2 cursor-pointer rounded-[8px] border border-border bg-background px-4 py-2 text-sm text-text hover:bg-border transition">
                            <i class="fa-solid fa-upload"></i> Upload from device
                        </label>
                        <button type="button" data-library-target="thumbnail"
                            class="open-media-library inline-flex items-center gap-2 rounded-[8px] border border-border bg-background px-4 py-2 text-sm text-text hover:bg-border transition">
                            <i class="fa-solid fa-photo-film"></i> Choose from library
                        </button>
                    </div>
                    <input id="thumbnail" name="thumbnail" type="file" accept="image/jpeg,image/png,image/webp"
                        class="hidden" />
                    <input type="hidden" name="thumbnail_library" id="thumbnail_library_input" />
                    <div id="thumbnailPreview" class="hidden mt-2">
                        <img id="thumbnailPreviewImg" src="" alt="Thumbnail preview"
                            class="h-24 w-24 rounded-[8px] object-cover border border-border" />
                    </div>
                    <p class="text-xs text-muted">Main product image. Accepted: JPG, PNG, WebP - max 2 MB.</p>
                    @error('thumbnail')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Gallery --}}
                <div class="rounded-[8px] border border-border bg-white p-5 space-y-2">
                    <label class="block text-sm font-medium text-text">Product Gallery</label>
                    <div class="flex flex-wrap gap-2">
                        <label for="gallery"
                            class="inline-flex items-center gap-2 cursor-pointer rounded-[8px] border border-border bg-background px-4 py-2 text-sm text-text hover:bg-border transition">
                            <i class="fa-solid fa-upload"></i> Upload from device
                        </label>
                        <button type="button" data-library-target="gallery"
                            class="open-media-library inline-flex items-center gap-2 rounded-[8px] border border-border bg-background px-4 py-2 text-sm text-text hover:bg-border transition">
                            <i class="fa-solid fa-photo-film"></i> Choose from library
                        </button>
                    </div>
                    <input id="gallery" name="gallery[]" type="file" multiple accept="image/jpeg,image/png,image/webp"
                        class="hidden" />
                    <div id="galleryLibraryInputs"></div>
                    <div id="galleryPreview" class="flex flex-wrap gap-2 mt-2"></div>
                    <p class="text-xs text-muted">Additional product images. Accepted: JPG, PNG, WebP - max 2 MB each.</p>
                    @error('gallery.*')<p class="text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- ---------------
            -- Form Actions
            -- --------------- --}}
            <div class="flex flex-col gap-3 pt-4 border-t border-border sm:flex-row sm:justify-end">
                <a href="{{ route('manage.products.all.index') }}"
                    class="inline-flex items-center justify-center rounded-[8px] border border-border bg-background px-5 py-3 text-sm font-medium text-text hover:bg-border transition">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-[8px] bg-primary px-5 py-3 text-sm font-semibold text-white hover:bg-primary/90 transition">
                    Submit
                </button>
            </div>
        </form>
    </div>

    {{-- ---------------
    -- Media Library Modal
    -- --------------- --}}
    <div id="mediaLibraryModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4">
        <div class="relative bg-background rounded-[12px] border border-border shadow-2xl w-full max-w-4xl flex flex-col"
            style="max-height: 80vh;">
            <div class="flex items-center justify-between px-5 py-4 border-b border-border shrink-0">
                <h2 class="text-sm font-semibold text-text">Media Library</h2>
                <button type="button" id="closeMediaModal" class="text-muted hover:text-text transition text-lg leading-none">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div id="mediaLibraryGrid" class="grid grid-cols-3 sm:grid-cols-6 gap-3 p-5 overflow-y-auto flex-1">
                <p class="col-span-full text-center text-sm text-muted py-8">Loading…</p>
            </div>
        </div>
    </div>

    @include('manage.products.partials.editor-layout', ['formId' => 'productCreateForm'])
@endsection

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet" />
    <style>
        .ql-toolbar.ql-snow { border-radius: 0.75rem 0.75rem 0 0; }
        .ql-container.ql-snow { border-radius: 0 0 0.75rem 0.75rem; min-height: 220px; }
        .ql-editor { min-height: 220px; font-size: 0.875rem; }
    </style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
(function () {
    // ---------------
    // SKU Auto-Generation from Product Name
    // ---------------
    function buildSku(name) {
        const prefix = name.replace(/[^a-zA-Z0-9]/g, '').substring(0, 3).toUpperCase() || 'PRD';
        const chars  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let rand = '';
        for (let i = 0; i < 6; i++) rand += chars.charAt(Math.floor(Math.random() * chars.length));
        return 'NAW-' + prefix + '-' + rand;
    }

    // ---------------
    // Slug Preview from Product Name
    // ---------------
    function buildSlug(name) {
        return name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/[\s-]+/g, '-')
            .replace(/^-|-$/g, '');
    }

    const nameInput       = document.getElementById('name');
    const skuInput        = document.getElementById('sku');
    const slugPreview     = document.getElementById('slugPreview');
    const slugPreviewText = document.getElementById('slugPreviewText');
    let skuUserEdited     = skuInput.value.trim() !== '';

    nameInput.addEventListener('input', function () {
        const val = this.value.trim();
        if (!skuUserEdited && !variantToggle.checked) skuInput.value = buildSku(val);
        const slug = buildSlug(val);
        if (slug) { slugPreviewText.textContent = slug; slugPreview.classList.remove('hidden'); }
        else { slugPreview.classList.add('hidden'); }
    });

    skuInput.addEventListener('input', function () {
        skuUserEdited = this.value.trim() !== '';
    });

    document.getElementById('regenerateSku').addEventListener('click', function () {
        skuInput.value = buildSku(nameInput.value.trim());
        skuUserEdited  = false;
    });

    // ---------------
    // Variant toggle
    // ---------------
    const variantToggle  = document.getElementById('is_variant_toggle');
    const variantSection = document.getElementById('variantSection');

    variantToggle.addEventListener('change', function () {
        variantSection.classList.toggle('hidden', !this.checked);
        if (this.checked) {
            skuInput.value = '';
            skuUserEdited  = false;
        } else if (!skuUserEdited && nameInput.value.trim()) {
            skuInput.value = buildSku(nameInput.value.trim());
        }
    });

    if (variantToggle.checked) { variantSection.classList.remove('hidden'); }

    // ---------------
    // Add Attribute Row
    // ---------------
    let attrIndex = 1;
    document.getElementById('addAttribute').addEventListener('click', function () {
        const container = document.getElementById('attributesContainer');
        const row = document.createElement('div');
        row.className = 'attribute-group grid grid-cols-1 sm:grid-cols-12 gap-3 items-center';
        row.innerHTML = `
            <div class="sm:col-span-5">
                <input type="text" name="attributes[${attrIndex}][name]"
                    class="w-full rounded-[8px] border border-border bg-background px-4 py-2 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                    placeholder="Attribute name (e.g. Size)" />
            </div>
            <div class="sm:col-span-5">
                <input type="text" name="attributes[${attrIndex}][values]"
                    class="w-full rounded-[8px] border border-border bg-background px-4 py-2 text-sm text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                    placeholder="Values comma-separated (e.g. S,M,L,XL)" />
            </div>
            <div class="sm:col-span-2 flex justify-end">
                <button type="button" class="remove-attribute rounded-[8px] border border-red-300 bg-red-50 px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-100 transition">Remove</button>
            </div>`;
        container.appendChild(row);
        row.querySelector('.remove-attribute').addEventListener('click', () => row.remove());
        attrIndex++;
    });

    document.getElementById('attributesContainer').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-attribute')) e.target.closest('.attribute-group').remove();
    });

    // ---------------
    // Generate Variants Table (with auto-SKU per variant and image column)
    // ---------------
    const escapeVariantText = value => String(value ?? '').replace(/[&"'<>]/g, c => ({'&':'&amp;','"':'&quot;',"'":'&#39;','<':'&lt;','>':'&gt;'}[c]));

    document.getElementById('generateVariants').addEventListener('click', function () {
        const groups = document.querySelectorAll('.attribute-group');
        const attributeSets = [];
        groups.forEach(group => {
            const nameIn   = group.querySelector('input[name*="[name]"]');
            const valuesIn = group.querySelector('input[name*="[values]"]');
            const n = nameIn ? nameIn.value.trim() : '';
            const v = valuesIn ? valuesIn.value.split(',').map(s => s.trim()).filter(Boolean) : [];
            if (n && v.length) attributeSets.push(v);
        });

        if (!attributeSets.length) {
            alert('Add at least one attribute with values before generating variants.');
            return;
        }

        const combinations = attributeSets.reduce((acc, set) => {
            const result = [];
            acc.forEach(e => set.forEach(v => result.push([...e, v])));
            return result;
        }, [[]]);

        // Preserve values already entered in existing rows
        const tbody = document.getElementById('variantRows');
        const existingRows = {};
        tbody.querySelectorAll('[data-label]').forEach(tr => {
            const label = tr.dataset.label;
            if (label) {
                existingRows[label] = {
                    sku:     tr.querySelector('input[name*="[sku]"]')?.value || '',
                    cost:    tr.querySelector('input[name*="[cost_price]"]')?.value || '',
                    selling: tr.querySelector('input[name*="[selling_price]"]')?.value || '',
                    strike:  tr.querySelector('input[name*="[strikethrough_price]"]')?.value || '',
                    stock:   tr.querySelector('input[name*="[stock]"]')?.value || '',
                };
            }
        });

        tbody.innerHTML = '';
        combinations.forEach((combo, i) => {
            const label   = combo.join(' / ');
            const prev    = existingRows[label] || {};
            const autoSku = prev.sku || buildSku(label);
            const tr = document.createElement('div');
            tr.dataset.label = label;
            tr.className = 'rounded-xl border border-border bg-white p-4 shadow-sm sm:p-5';
            tr.innerHTML = `
                <div class="mb-4 flex flex-wrap items-start justify-between gap-2">
                    <div><div class="font-semibold text-text">${escapeVariantText(combo.join(' · '))}</div><p class="mt-1 text-xs text-muted">Set price and availability for this option</p></div>
                    <span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">Option ${i + 1}</span>
                </div>
                <input type="hidden" name="variants[${i}][variant_code]" value="${escapeVariantText(label)}" />
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <label class="block min-w-0 space-y-1.5"><span class="block text-xs font-semibold text-text">SKU (internal)</span><input type="text" name="variants[${i}][sku]"  value="${escapeVariantText(autoSku)}" class="w-full min-w-0 rounded-lg border border-border bg-background px-3 py-2.5 text-sm text-text outline-none focus:border-primary focus:ring-2 focus:ring-primary/20" /></label>
                    <label class="block min-w-0 space-y-1.5"><span class="block text-xs font-semibold text-text">Cost price (KSh)</span><input type="number" name="variants[${i}][cost_price]" step="0.01" min="0" value="${escapeVariantText(prev.cost || '')}" class="w-full min-w-0 rounded-lg border border-border bg-background px-3 py-2.5 text-sm text-text outline-none focus:border-primary focus:ring-2 focus:ring-primary/20" /></label>
                    <label class="block min-w-0 space-y-1.5"><span class="block text-xs font-semibold text-text">Selling price (KSh)</span><input type="number" name="variants[${i}][selling_price]" step="0.01" min="0" required value="${escapeVariantText(prev.selling || '')}" class="w-full min-w-0 rounded-lg border border-border bg-background px-3 py-2.5 text-sm text-text outline-none focus:border-primary focus:ring-2 focus:ring-primary/20" /></label>
                    <label class="block min-w-0 space-y-1.5"><span class="block text-xs font-semibold text-text">Was price (optional)</span><input type="number" name="variants[${i}][strikethrough_price]" step="0.01" min="0" value="${escapeVariantText(prev.strike || '')}" class="w-full min-w-0 rounded-lg border border-border bg-background px-3 py-2.5 text-sm text-text outline-none focus:border-primary focus:ring-2 focus:ring-primary/20" /></label>
                    <label class="block min-w-0 space-y-1.5"><span class="block text-xs font-semibold text-text">Available stock</span><input type="number" name="variants[${i}][stock]" min="0" value="${escapeVariantText(prev.stock || '')}" class="w-full min-w-0 rounded-lg border border-border bg-background px-3 py-2.5 text-sm text-text outline-none focus:border-primary focus:ring-2 focus:ring-primary/20" /></label>
                    <div class="min-w-0 space-y-2 sm:col-span-2">
                        <label class="block text-xs font-semibold text-text">Variant image (optional)</label>
                        <input type="file" name="variants[${i}][image]" accept="image/jpeg,image/png,image/webp" class="block w-full min-w-0 text-xs text-muted file:mr-2 file:rounded-lg file:border-0 file:bg-primary/10 file:px-3 file:py-2 file:font-semibold file:text-primary" />
                    </div>
                </div>`;
            tbody.appendChild(tr);
        });

        document.getElementById('variantsTable').classList.remove('hidden');
    });


    // ---------------
    // Short Description Word Count (max 20 words)
    // ---------------
    const shortDesc      = document.getElementById('short_description');
    const shortWordCount = document.getElementById('shortWordCount');

    function countWords(text) {
        return text.trim() === '' ? 0 : text.trim().split(/\s+/).length;
    }

    shortDesc.addEventListener('input', function () {
        const words = countWords(this.value);
        shortWordCount.textContent = words + ' / 20 words';
        shortWordCount.className   = 'text-xs ' + (words > 20 ? 'text-red-500' : 'text-muted');
    });

        const quill = new Quill('#detailed_description_editor', {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        [{ header: [2, 3, false] }],
                        ['link', 'image', 'video'],
                        ['clean'],
                    ],
                    handlers: {
                        image: function () { uploadEditorMedia(quill, 'image/*'); }
                    }
                }
            },
            placeholder: 'Write a detailed product description (200–300 words recommended)…',
        });

        // ---------------
        // Upload an image/video file to the server and insert it at the cursor
        // ---------------
        function uploadEditorMedia(editor, accept) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = accept;
            input.onchange = function () {
                const file = input.files[0];
                if (!file) return;

                const range = editor.getSelection(true);
                editor.insertText(range.index, 'Uploading...', 'italic', true);

                const formData = new FormData();
                formData.append('file', file);

                axios.post('{{ route('manage.products.uploadMedia') }}', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(function (response) {
                    editor.deleteText(range.index, 'Uploading...'.length);
                    editor.insertEmbed(range.index, 'image', response.data.url);
                    editor.setSelection(range.index + 1);
                }).catch(function () {
                    editor.deleteText(range.index, 'Uploading...'.length);
                    alert('Upload failed. Please try again.');
                });
            };
            input.click();
        }
    // Pre-fill on validation failure reload
    const savedDetailed = document.getElementById('detailed_description_hidden').value;
    if (savedDetailed) quill.root.innerHTML = savedDetailed;

    const detailedWordCount = document.getElementById('detailedWordCount');
    quill.on('text-change', function () {
        const words = countWords(quill.getText());
        detailedWordCount.textContent = words + ' words';
        detailedWordCount.className   = 'text-xs ' + (words < 200 ? 'text-muted' : (words <= 300 ? 'text-green-600' : 'text-amber-500'));
    });

    // Sync Quill content to hidden input before form submit; disable hidden section inputs so they are not submitted
    document.getElementById('productCreateForm').addEventListener('submit', function () {
        document.getElementById('detailed_description_hidden').value = quill.root.innerHTML;
        if (variantSection.classList.contains('hidden')) {
            variantSection.querySelectorAll('input, select, textarea').forEach(el => el.disabled = true);
        }
    });

    // ---------------
    // Thumbnail Device Upload Preview
    // ---------------
    document.getElementById('thumbnail').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('thumbnailPreviewImg').src = e.target.result;
            document.getElementById('thumbnailPreview').classList.remove('hidden');
            document.getElementById('thumbnail_library_input').value = '';
        };
        reader.readAsDataURL(file);
    });

    // ---------------
    // Gallery Device Upload Preview
    // ---------------
    document.getElementById('gallery').addEventListener('change', function () {
        const preview = document.getElementById('galleryPreview');
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'h-14 w-14 rounded-[8px] object-cover border border-border';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    // ---------------
    // Media Library Modal
    // ---------------
    let libraryTarget = 'thumbnail';
    let libraryLoaded = false;
    const modal         = document.getElementById('mediaLibraryModal');
    const modalGrid     = document.getElementById('mediaLibraryGrid');
    const closeModalBtn = document.getElementById('closeMediaModal');

    document.querySelectorAll('.open-media-library').forEach(btn => {
        btn.addEventListener('click', function () {
            libraryTarget = this.dataset.libraryTarget;
            modal.classList.remove('hidden');
            if (!libraryLoaded) loadMediaLibrary();
        });
    });

    closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
    modal.addEventListener('click', function (e) {
        if (e.target === modal) modal.classList.add('hidden');
    });

    function loadMediaLibrary() {
        modalGrid.innerHTML = '<p class="col-span-full text-center text-sm text-muted py-8">Loading…</p>';
        axios.get('{{ route("manage.products.mediaLibrary") }}')
            .then(function (response) {
                libraryLoaded = true;
                const items   = response.data;
                if (!items.length) {
                    modalGrid.innerHTML = '<p class="col-span-full text-center text-sm text-muted py-8">No images in the library yet.</p>';
                    return;
                }
                modalGrid.innerHTML = '';
                items.forEach(function (item) {
                    const btn = document.createElement('button');
                    btn.type  = 'button';
                    btn.className = 'relative group rounded-[8px] overflow-hidden border-2 border-transparent hover:border-primary transition focus:outline-none';
                    btn.innerHTML = `<img src="${item.url}" alt="" class="w-full aspect-square object-cover" />
                        <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                            <i class="fa-solid fa-check text-white text-lg"></i>
                        </div>`;
                    btn.addEventListener('click', function () {
                        selectLibraryItem(item.path, item.url);
                    });
                    modalGrid.appendChild(btn);
                });
            })
            .catch(function () {
                modalGrid.innerHTML = '<p class="col-span-full text-center text-sm text-red-500 py-8">Failed to load media library.</p>';
            });
    }

    function selectLibraryItem(path, url) {
        if (libraryTarget === 'thumbnail') {
            document.getElementById('thumbnail_library_input').value = path;
            document.getElementById('thumbnailPreviewImg').src = url;
            document.getElementById('thumbnailPreview').classList.remove('hidden');
        } else {
            const input = document.createElement('input');
            input.type  = 'hidden';
            input.name  = 'gallery_library[]';
            input.value = path;
            document.getElementById('galleryLibraryInputs').appendChild(input);

            const img   = document.createElement('img');
            img.src     = url;
            img.className = 'h-14 w-14 rounded-[8px] object-cover border border-border';
            document.getElementById('galleryPreview').appendChild(img);
        }
        modal.classList.add('hidden');
    }

}());
</script>
@endpush
