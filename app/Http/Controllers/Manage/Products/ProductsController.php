<?php

namespace App\Http\Controllers\Manage\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Products\StoreProductRequest;
use App\Http\Requests\Manage\Products\UpdateProductRequest;
use App\Models\Manage\Products\Brand;
use App\Models\Manage\Products\Category;
use App\Models\Manage\Products\Label;
use App\Models\Manage\Products\Media;
use App\Models\Manage\Products\Product;
use App\Models\Manage\Products\ProductAttribute;
use App\Models\Manage\Products\ProductAttributeValue;
use App\Models\Manage\Products\ProductVariant;
use App\Models\Manage\Products\ProductVariantAttribute;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Client\ProductReview;

class ProductsController extends Controller
{
    // ---------------
    // List All Products
    // ---------------
    public function index()
    {
        $query = Product::with(['category', 'brand', 'label', 'categories', 'labels', 'variants:id,product_id,stock_quantity,price']);
        // ---------------
        // Handle Search
        // ---------------
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // ---------------
        // Handle Sidebar Filters
        // ---------------
        if (request('category_id')) {
            $query->where('category_id', request('category_id'));
        }
        if (request('brand_id')) {
            $query->where('brand_id', request('brand_id'));
        }
        if (request('label_id')) {
            $query->where('label_id', request('label_id'));
        }
        if (request('stock_status') === 'low') {
            $query->where('is_active', true)
                  ->whereColumn('stock_quantity', '<=', 'low_stock_threshold');
        }
        if (request('stock_status') === 'low') {
            $query->where('is_active', true)
                  ->whereColumn('stock_quantity', '<=', 'low_stock_threshold');
        }

        // ---------------
        // Handle Sort
        // ---------------
        match (request('sort', 'latest')) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name_asc'   => $query->orderBy('name'),
            'stock_asc'  => $query->orderBy('stock_quantity'),
            default      => $query->latest(),
        };

        // ---------------
        // Paginate
        // ---------------
        $perPage  = request('per_page', 20);
        $products = $query->paginate($perPage)->withQueryString();

        $categories = Category::withCount('products')->orderBy('name')->get();
        $brands     = Brand::withCount('products')->orderBy('name')->get();
        $labels     = Label::withCount('products')->orderBy('name')->get();

        return view('manage.products.all.index', compact('products', 'categories', 'brands', 'labels'));
    }

    // ---------------
    // Show Single Product
    // ---------------
    public function show(string $id)
    {
        $product = Product::with([
            'category',
            'brand',
            'label',
            'categories',
            'labels',
            'variants.variantAttributes.attributeValue',
            'reviews.user',
            'media',
            'flashSale',
        ])->findOrFail($id);

        return view('manage.products.all.show', compact('product'));
    }

    // ---------------
    // Show Create Form
    // ---------------
    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->orderBy('name')->get();
        $brands     = Brand::orderBy('name')->get();
        $labels     = Label::orderBy('name')->get();

        return view('manage.products.add.create', compact('categories', 'brands', 'labels'));
    }

    // ---------------
    // Helpers
    // ---------------

    // ---------------
    // Generate incrementing product SKU - NAW- + 8-digit sequence starting at 111000.
    // Ignores old name-prefix format (NAW-XXX-RANDOM) so the sequence starts clean.
    // ---------------
    private function generateSku(string $name): string
    {
        $last   = DB::table('su_products')
            ->where('sku', 'like', 'NAW-%')
            ->orderByDesc('id')
            ->value('sku');
        $suffix = $last ? substr($last, 4) : null;
        $next   = ($suffix && ctype_digit($suffix)) ? ((int) $suffix + 1) : 111000;

        return 'NAW-' . str_pad($next, 8, '0', STR_PAD_LEFT);
    }

    // ---------------
    // Generate incrementing variant SKU - NAWV- + 8-digit sequence starting at 111000.
    // Separate prefix from products so variants are distinguishable at a glance.
    // ---------------
    private function generateVariantSku(string $label): string
    {
        $last   = DB::table('su_product_variants')
            ->where('sku', 'like', 'NAWV-%')
            ->orderByDesc('id')
            ->value('sku');
        $suffix = $last ? substr($last, 5) : null;
        $next   = ($suffix && ctype_digit($suffix)) ? ((int) $suffix + 1) : 111000;

        return 'NAWV-' . str_pad($next, 8, '0', STR_PAD_LEFT);
    }

    // ---------------
    // Media Library - JSON list of all uploaded product images for the picker modal
    // ---------------
    public function mediaLibrary(): \Illuminate\Http\JsonResponse
    {
        $items = Media::where('type', 'image')
            ->orderByDesc('created_at')
            ->limit(200)
            ->get(['id', 'file_path']);

        return response()->json($items->map(fn ($m) => [
            'id'   => $m->id,
            'path' => $m->file_path,
            'url'  => asset($m->file_path),
        ]));
    }

    // ---------------
    // Get the category flagged as default (is_default = 1), used whenever
    // a product is saved with no category selected. Null if none is set.
    // ---------------
    private function defaultCategoryId(): ?int
    {
        return Category::where('is_default', true)->value('id');
    }

    // ---------------
    // Save a Single Variant Image - returns the stored relative path
    // ---------------
    private function saveVariantImage(UploadedFile $file): string
    {
        $destination = public_path('uploads/products/images');
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $name     = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = sprintf('%s-%s.%s', time(), $name ?: 'variant', $file->getClientOriginalExtension());

        if (! @copy($file->getRealPath(), $destination . DIRECTORY_SEPARATOR . $filename)) {
            throw new \RuntimeException('Unable to save variant image: ' . $filename);
        }

        return 'uploads/products/images/' . $filename;
    }

    // ---------------
    // Save a Single Gallery Image - returns the stored relative path
    // ---------------
    private function saveGalleryImage(UploadedFile $file): string
    {
        if (! $file->isValid()) {
            throw new \RuntimeException('Uploaded gallery image is not valid. Error: ' . $file->getError());
        }

        $destination = public_path('uploads/products/images');
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $name     = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = sprintf('%s-%s.%s', time(), $name ?: 'image', $file->getClientOriginalExtension());

        if (! @copy($file->getRealPath(), $destination . DIRECTORY_SEPARATOR . $filename)) {
            throw new \RuntimeException('Unable to save gallery image: ' . $filename);
        }

        return 'uploads/products/images/' . $filename;
    }

    private function saveThumbnail(UploadedFile $file): string
    {
        if (! $file->isValid()) {
            throw new \RuntimeException('Uploaded thumbnail is not valid. Error: ' . $file->getError());
        }

        $tmpPath = $file->getRealPath() ?: $file->getPathname();
        if (! $tmpPath || ! file_exists($tmpPath)) {
            throw new \RuntimeException('Uploaded temporary file is missing: ' . $tmpPath);
        }

        $destination = public_path('uploads/products/images');
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = sprintf('%s-%s.%s', time(), $name ?: 'thumbnail', $file->getClientOriginalExtension());
        $destinationPath = $destination . DIRECTORY_SEPARATOR . $filename;

        if (! @copy($tmpPath, $destinationPath)) {
            throw new \RuntimeException(sprintf('Unable to save uploaded thumbnail from [%s] to [%s].', $tmpPath, $destinationPath));
        }

        return 'uploads/products/images/' . $filename;
    }

    // ---------------
    // Store New Product
    // ---------------
    public function store(StoreProductRequest $request)
    {
        $request->validate(['default_length_m' => ['nullable','numeric','min:0.1','max:30','regex:/^\d+(\.\d{1,2})?$/'], 'default_gauge' => 'nullable|string|max:100', 'default_finish' => 'nullable|string|max:100']);
        // ---------------
        // Generate Unique Slug
        // ---------------
        $slug         = Str::slug($request->name);
        $originalSlug = $slug;
        $i            = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        // ---------------
        // Handle Thumbnail - file upload takes priority over library selection
        // ---------------
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $thumbnailPath = $this->saveThumbnail($request->file('thumbnail'));
        } elseif ($request->filled('thumbnail_library')) {
            $thumbnailPath = $request->thumbnail_library;
        }

        // ---------------
        // Resolve base pricing from selling and strike-through inputs
        // ---------------
        $pricing = $this->resolvePricing($request->selling_price, $request->strikethrough_price);

        $categoryIds = $request->input('category_ids', []);
        if (empty($categoryIds)) {
            $categoryIds = array_filter([$this->defaultCategoryId()]);
        }

        $product = Product::create([
            'name'                 => $request->name,
            'slug'                 => $slug,
            'category_id'          => $categoryIds[0] ?? null,
            'brand_id'             => $request->brand_id,
            'label_id'             => $request->input('label_ids.0'),
            'sku'                  => $request->filled('sku') ? $request->sku : $this->generateSku($request->name),
            'price'                => $pricing['price'],
            'sale_price'           => $pricing['sale_price'],
            'cost_price'           => $request->cost_price,
            'stock_quantity'       => $request->stock_quantity,
            'currency'             => $request->currency,
            'condition'            => 'new',
            'condition_notes'      => null,
            'is_variant'           => $request->boolean('is_variant'),
            'is_vat_exempt'        => $request->boolean('is_vat_exempt'),
            'is_active'            => $request->boolean('is_active', true),
            'allow_custom_length'  => $request->boolean('allow_custom_length'),
            'default_length_m'     => $request->input('default_length_m', 1),
            'default_gauge'        => $request->filled('default_gauge') ? trim($request->input('default_gauge')) : null,
            'default_finish'       => $request->filled('default_finish') ? trim($request->input('default_finish')) : null,
            'weight'               => $request->weight,
            'length'               => $request->length,
            'width'                => $request->width,
            'height'               => $request->height,
            'short_description'    => $request->short_description,
            'detailed_description' => $request->detailed_description,
            'thumbnail'            => $thumbnailPath,
        ]);

        $product->categories()->sync($categoryIds);
        $product->labels()->sync($request->input('label_ids', []));
        // ---------------
        // Save Gallery Images to su_media (uploaded files)
        // ---------------
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $galleryFile) {
                if ($galleryFile && $galleryFile->isValid()) {
                    $path = $this->saveGalleryImage($galleryFile);
                    Media::create([
                        'product_id' => $product->id,
                        'type'       => 'image',
                        'file_path'  => $path,
                        'caption'    => null,
                        'position'   => 0,
                    ]);
                }
            }
        }

        // ---------------
        // Save Gallery Images to su_media (selected from media library)
        // ---------------
        foreach ($request->input('gallery_library', []) as $libraryPath) {
            if ($libraryPath) {
                Media::create([
                    'product_id' => $product->id,
                    'type'       => 'image',
                    'file_path'  => $libraryPath,
                    'caption'    => null,
                    'position'   => 0,
                ]);
            }
        }

        // ---------------
        // Save Attributes and Generated Variants
        // ---------------
        if ($request->boolean('is_variant') && $request->filled('attributes')) {
            $this->saveVariants($product, $request->input('attributes', []), $request->input('variants', []), $request->file('variants', []));
        }

        // ---------------
        // Calculate and Update Total Stock from Variants (if variant product)
        // ---------------
        if ($request->boolean('is_variant')) {
            $totalVariantStock = $product->variants()->sum('stock_quantity');
            $product->update(['stock_quantity' => $totalVariantStock]);
        }

        return redirect()->route('manage.products.all.index')
            ->with('success', 'Product "' . $product->name . '" created successfully.');
    }

    // ---------------
    // Show Edit Form
    // ---------------
    public function edit(string $id)
    {
        $product = Product::with([
            'attributes.values',
            'variants.variantAttributes.attributeValue',
            'media',
            'categories',
            'labels',
        ])->findOrFail($id);

        $categories = Category::whereNull('parent_id')->with('children')->orderBy('name')->get();
        $brands     = Brand::orderBy('name')->get();
        $labels     = Label::orderBy('name')->get();

        return view('manage.products.all.edit', compact('product', 'categories', 'brands', 'labels'));
    }

    // ---------------
    // Update Product
    // ---------------
    public function update(UpdateProductRequest $request, string $id)
    {
        $request->validate(['default_length_m' => ['nullable','numeric','min:0.1','max:30','regex:/^\d+(\.\d{1,2})?$/'], 'default_gauge' => 'nullable|string|max:100', 'default_finish' => 'nullable|string|max:100']);
        $product = Product::findOrFail($id);

        // ---------------
        // Regenerate Slug Only If Name Changed
        // ---------------
        $slug = $product->slug;
        if ($request->name !== $product->name) {
            $slug         = Str::slug($request->name);
            $originalSlug = $slug;
            $i            = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $i++;
            }
        }

        // ---------------
        // Handle Thumbnail - file upload takes priority over library selection
        // ---------------
        $thumbnailPath = $product->thumbnail;
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $thumbnailPath = $this->saveThumbnail($request->file('thumbnail'));
        } elseif ($request->filled('thumbnail_library')) {
            $thumbnailPath = $request->thumbnail_library;
        }

        // ---------------
        // Resolve base pricing from selling and strike-through inputs
        // ---------------
        $pricing = $this->resolvePricing($request->selling_price, $request->strikethrough_price);

        // ---------------
        // Update Product Record
        // ---------------
        $categoryIds = $request->input('category_ids', []);
        if (empty($categoryIds)) {
            $categoryIds = array_filter([$this->defaultCategoryId()]);
        }

        $product->update([
            'name'                 => $request->name,
            'slug'                 => $slug,
            'category_id'          => $categoryIds[0] ?? null,
            'brand_id'             => $request->brand_id,
            'label_id'             => $request->input('label_ids.0'),
            'sku'                  => $request->filled('sku') ? $request->sku : $product->sku,
            'price'                => $pricing['price'],
            'sale_price'           => $pricing['sale_price'],
            'cost_price'           => $request->cost_price,
            'stock_quantity'       => $request->stock_quantity,
            'currency'             => $request->currency,
            'is_variant'           => $request->boolean('is_variant'),
            'is_vat_exempt'        => $request->boolean('is_vat_exempt'),
            'is_active'            => $request->boolean('is_active', $product->is_active),
            'allow_custom_length'  => $request->boolean('allow_custom_length'),
            'default_length_m'     => $request->input('default_length_m', 1),
            'default_gauge'        => $request->filled('default_gauge') ? trim($request->input('default_gauge')) : null,
            'default_finish'       => $request->filled('default_finish') ? trim($request->input('default_finish')) : null,
            'weight'               => $request->weight,
            'length'               => $request->length,
            'width'                => $request->width,
            'height'               => $request->height,
            'short_description'    => $request->short_description,
            'detailed_description' => $request->detailed_description,
            'thumbnail'            => $thumbnailPath,
        ]);

        $product->categories()->sync($categoryIds);
        $product->labels()->sync($request->input('label_ids', []));

        // ---------------
        // Append New Gallery Images to su_media (uploaded files; existing are kept)
        // ---------------
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $galleryFile) {
                if ($galleryFile && $galleryFile->isValid()) {
                    $path = $this->saveGalleryImage($galleryFile);
                    Media::create([
                        'product_id' => $product->id,
                        'type'       => 'image',
                        'file_path'  => $path,
                        'caption'    => null,
                        'position'   => 0,
                    ]);
                }
            }
        }

        // ---------------
        // Append Gallery from Media Library Selections
        // ---------------
        foreach ($request->input('gallery_library', []) as $libraryPath) {
            if ($libraryPath) {
                Media::create([
                    'product_id' => $product->id,
                    'type'       => 'image',
                    'file_path'  => $libraryPath,
                    'caption'    => null,
                    'position'   => 0,
                ]);
            }
        }

        // ---------------
        // Sync Attributes and Variants - clear old, re-save from form
        // ---------------
        if ($request->boolean('is_variant') && $request->filled('attributes')) {
            $this->clearVariants($product);
            $this->saveVariants($product, $request->input('attributes', []), $request->input('variants', []), $request->file('variants', []));
        } else {
            $this->clearVariants($product);
        }

        // ---------------
        // Calculate and Update Total Stock from Variants (if variant product)
        // ---------------
        if ($request->boolean('is_variant')) {
            $totalVariantStock = $product->variants()->sum('stock_quantity');
            $product->update(['stock_quantity' => $totalVariantStock]);
        }

        return redirect()->route('manage.products.all.index')
            ->with('success', 'Product "' . $product->name . '" updated successfully.');
    }

    // ---------------
    // Remove All Variant/Attribute Data for a Product
    // ---------------
    private function clearVariants(Product $product): void
    {
        $variantIds = ProductVariant::where('product_id', $product->id)->pluck('id');
        ProductVariantAttribute::whereIn('variant_id', $variantIds)->delete();
        ProductVariant::where('product_id', $product->id)->delete();

        $attributeIds = ProductAttribute::where('product_id', $product->id)->pluck('id');
        ProductAttributeValue::whereIn('attribute_id', $attributeIds)->delete();
        ProductAttribute::where('product_id', $product->id)->delete();
    }

    // ---------------
    // Save Attributes, Attribute Values, and Variants
    // ---------------
    // ---------------
    // Map the admin-facing price inputs onto the storage columns.
    // The customer pays COALESCE(sale_price, price); when a strike-through
    // price is provided it is stored in `price` and the selling price in
    // `sale_price` so the storefront shows it crossed out.
    // ---------------
    private function resolvePricing($sellingPrice, $strikethroughPrice): array
    {
        $selling = ($sellingPrice !== null && $sellingPrice !== '') ? (float) $sellingPrice : null;
        $strike  = ($strikethroughPrice !== null && $strikethroughPrice !== '') ? (float) $strikethroughPrice : null;

        if ($selling === null) {
            return ['price' => null, 'sale_price' => null];
        }

        if ($strike !== null && $strike > $selling) {
            return ['price' => $strike, 'sale_price' => $selling];
        }

        return ['price' => $selling, 'sale_price' => null];
    }

    private function saveVariants(Product $product, array $attributes, array $variantData, array $variantFiles = []): void
    {
        // ---------------
        // Build file map: variant_code → uploaded image file
        // ---------------
        $variantFilesByCode = [];
        foreach ($variantData as $i => $row) {
            $code = $row['variant_code'] ?? '';
            if ($code !== '' && isset($variantFiles[$i]['image'])) {
                $file = $variantFiles[$i]['image'];
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $variantFilesByCode[$code] = $file;
                }
            }
        }

        // Build attribute → value map and persist records
        $attributeValueSets = [];
        foreach ($attributes as $attrInput) {
            $attrName = trim($attrInput['name'] ?? '');
            if ($attrName === '') {
                continue;
            }

            $attribute = ProductAttribute::create([
                'product_id' => $product->id,
                'name'       => $attrName,
                'slug'       => \Illuminate\Support\Str::slug($attrName),
            ]);

            $valuesRaw = array_filter(array_map('trim', explode(',', $attrInput['values'] ?? '')));
            $valueRecords = [];
            foreach ($valuesRaw as $val) {
                $valueRecord = ProductAttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value'        => $val,
                    'slug'         => \Illuminate\Support\Str::slug($val),
                ]);
                $valueRecords[] = $valueRecord;
            }
            $attributeValueSets[] = $valueRecords;
        }

        if (empty($attributeValueSets)) {
            return;
        }

        // Compute cartesian product of all attribute value combinations
        $combinations = [[]];
        foreach ($attributeValueSets as $valueSet) {
            $newCombinations = [];
            foreach ($combinations as $existing) {
                foreach ($valueSet as $value) {
                    $newCombinations[] = array_merge($existing, [$value]);
                }
            }
            $combinations = $newCombinations;
        }

        // Match submitted variant rows by variant_code label
        $variantDataByCode = [];
        foreach ($variantData as $row) {
            $code = $row['variant_code'] ?? '';
            if ($code !== '') {
                $variantDataByCode[$code] = $row;
            }
        }

        foreach ($combinations as $combo) {
            $label = implode(' / ', array_map(fn($v) => $v->value, $combo));
            $submitted = $variantDataByCode[$label] ?? [];

            $valueIds = array_map(fn($v) => $v->id, $combo);
            sort($valueIds);
            $signature = hash('sha256', implode(',', $valueIds));

            $variantImagePath = null;
            if (isset($variantFilesByCode[$label])) {
                $variantImagePath = $this->saveVariantImage($variantFilesByCode[$label]);
            }

            // ---------------
            // Resolve variant SKU - use the submitted value if it is non-empty and not already
            // taken; otherwise generate a guaranteed-unique one to avoid uq_variant_sku violations
            // ---------------
            $rawSku     = trim($submitted['sku'] ?? '');
            $variantSku = ($rawSku !== '' && ! ProductVariant::where('sku', $rawSku)->exists())
                ? $rawSku
                : $this->generateVariantSku($label);

            $variantPricing = $this->resolvePricing(
                $submitted['selling_price'] ?? ($product->sale_price ?? $product->price),
                $submitted['strikethrough_price'] ?? null
            );

            $variant = ProductVariant::create([
                'product_id'        => $product->id,
                'variant_code'      => $label,
                'sku'               => $variantSku,
                'price'             => $variantPricing['price'],
                'sale_price'        => $variantPricing['sale_price'],
                'cost_price'        => ($submitted['cost_price'] ?? '') !== '' ? $submitted['cost_price'] : null,
                'stock_quantity'    => $submitted['stock'] ?? 0,
                'image'             => $variantImagePath,
                'variant_signature' => $signature,
            ]);

            foreach ($combo as $attrValue) {
                ProductVariantAttribute::create([
                    'variant_id'         => $variant->id,
                    'attribute_id'       => $attrValue->attribute_id,
                    'attribute_value_id' => $attrValue->id,
                ]);
            }
        }
    }

    // ---------------
    // Delete Product
    // ---------------
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $name    = $product->name;

        // Delete the product (foreign key handles order_items)
        $product->delete();

        return redirect()->route('manage.products.all.index')
            ->with('success', 'Product "' . $name . '" deleted successfully.');
    }

    /**
     * Toggle product active status (activate/deactivate).
     */
    public function toggleActive(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $product->update(['is_active' => !$product->is_active]);
        $status = $product->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Product \"{$product->name}\" has been {$status}.");
    }

    // ---------------
    // Update Product Review Status (approve/reject/pending)
    // ---------------
    public function updateReviewStatus(Request $request, int $reviewId)
    {
        $review = ProductReview::findOrFail($reviewId);
        $request->validate(['status' => 'required|in:pending,approved,rejected']);
        $review->update(['status' => $request->status]);

        return back()->with('success', 'Review status updated.');
    }

    // ---------------
    // Inline Editor Media Upload - used by Quill's image/video toolbar buttons
    // on the Detailed Description editor
    // ---------------
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif,mp4,webm,ogg|max:20480',
        ]);

        $file = $request->file('file');

        $destination = public_path('uploads/products/images');
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $name     = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = sprintf('%s-%s.%s', time(), $name ?: 'media', $file->getClientOriginalExtension());

        if (! @copy($file->getRealPath(), $destination . DIRECTORY_SEPARATOR . $filename)) {
            return response()->json(['error' => 'Upload failed.'], 500);
        }

        return response()->json(['url' => asset('uploads/products/images/' . $filename)]);
    }
}
