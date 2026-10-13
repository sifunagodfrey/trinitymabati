<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCsvSeeder extends Seeder
{
    // ---------------
    // Lookup caches (avoid re-querying for repeated categories/brands/slugs)
    // ---------------
    private array $categoryCache = [];
    private array $brandCache = [];
    private array $usedProductSlugs = [];

    public function run(): void
    {
        $path = database_path('seeders/data/wc-product-export.csv');

        if (! file_exists($path)) {
            $this->command->error("CSV file not found at: {$path}");
            return;
        }

        $rows = $this->readCsv($path);

        // ---------------
        // Split rows by WooCommerce "Type" column
        // ---------------
        $simpleRows = [];
        $variableRows = [];
        $variationRows = [];

        foreach ($rows as $row) {
            match (trim($row['Type'] ?? '')) {
                'simple' => $simpleRows[] = $row,
                'variable' => $variableRows[] = $row,
                'variation' => $variationRows[] = $row,
                default => null,
            };
        }

        // ---------------
        // Group each variation under its parent's Name.
        // WooCommerce's "Parent" column stores the internal WP post id
        // (e.g. "id:856"), which does not correspond to anything in this
        // export, so parents are matched by stripping the
        // " - {attribute value}" suffix from the variation's Name instead.
        // ---------------
        $variationsByParentName = [];
        foreach ($variationRows as $row) {
            $value = trim($row['Attribute 1 value(s)'] ?? '');
            $name = trim($row['Name'] ?? '');
            $suffix = ' - ' . $value;

            if ($value !== '' && Str::endsWith($name, $suffix)) {
                $parentName = Str::substr($name, 0, -Str::length($suffix));
                $variationsByParentName[$parentName][] = $row;
            } else {
                $this->command->warn("Skipping variation, could not resolve parent product: \"{$name}\"");
            }
        }

        DB::beginTransaction();

        try {
            foreach ($simpleRows as $row) {
                $this->createProduct($row, false);
            }

            foreach ($variableRows as $row) {
                $productId = $this->createProduct($row, true);
                $parentName = trim($row['Name'] ?? '');
                $children = $variationsByParentName[$parentName] ?? [];
                $this->createVariants($productId, $row, $children);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        $this->command->info('Product CSV seeding complete: ' . count($simpleRows) . ' simple, ' . count($variableRows) . ' variable products seeded.');
    }

    // ---------------
    // Insert a su_products row (simple or variable) from one CSV row.
    // Only columns that exist on su_products are populated.
    // ---------------
    private function createProduct(array $row, bool $isVariant): int
    {
        $name = trim($row['Name'] ?? '');
        $slug = $this->uniqueProductSlug($name);

        $categoryNames = $this->splitList($row['Categories'] ?? '');
        $categoryIds = array_map(fn ($catName) => $this->findOrCreateCategory($catName), $categoryNames);
        $primaryCategoryId = $categoryIds[0] ?? null;

        $brandNames = $this->splitList($row['Brands'] ?? '');
        $brandId = $brandNames ? $this->findOrCreateBrand($brandNames[0]) : null;

        $images = $this->splitList($row['Images'] ?? '');

        $productId = DB::table('su_products')->insertGetId([
            'name' => $name,
            'slug' => $slug,
            'brand_id' => $brandId,
            'category_id' => $primaryCategoryId,
            'sku' => $this->nullIfBlank($row['SKU'] ?? null),
            'price' => $this->parseDecimal($row['Regular price'] ?? null),
            'sale_price' => $this->parseDecimal($row['Sale price'] ?? null),
            'stock_quantity' => $this->parseInt($row['Stock'] ?? null) ?? 0,
            'low_stock_threshold' => $this->parseInt($row['Low stock amount'] ?? null) ?? 5,
            'is_variant' => $isVariant,
            'weight' => $this->parseDecimal($row['Weight (kg)'] ?? null),
            'length' => $this->parseDecimal($row['Length (cm)'] ?? null),
            'width' => $this->parseDecimal($row['Width (cm)'] ?? null),
            'height' => $this->parseDecimal($row['Height (cm)'] ?? null),
            'is_vat_exempt' => strtolower(trim($row['Tax status'] ?? '')) === 'none',
            'is_active' => strtolower(trim($row['Visibility in catalog'] ?? '')) !== 'hidden',
            'thumbnail' => $this->filenameFromUrl($images[0] ?? null),
            'short_description' => $this->truncate($this->nullIfBlank($row['Short description'] ?? null), 255),
            'detailed_description' => $this->nullIfBlank($row['Description'] ?? null),
        ]);

        // ---------------
        // su_product_category pivot: attach every category, not just the primary one
        // ---------------
        foreach ($categoryIds as $categoryId) {
            DB::table('su_product_category')->insertOrIgnore([
                'product_id' => $productId,
                'category_id' => $categoryId,
            ]);
        }

        // ---------------
        // su_media: one row per image, first image already set as thumbnail above
        // ---------------
        foreach ($images as $position => $imageUrl) {
            DB::table('su_media')->insert([
                'product_id' => $productId,
                'type' => 'image',
                'file_path' => $this->filenameFromUrl($imageUrl),
                'position' => $position,
            ]);
        }

        return $productId;
    }

    // ---------------
    // Create the attribute, its values, and one su_product_variants row
    // per variation, for a "variable" parent product.
    // ---------------
    private function createVariants(int $productId, array $parentRow, array $childRows): void
    {
        $attributeName = trim($parentRow['Attribute 1 name'] ?? '');

        if ($attributeName === '' || empty($childRows)) {
            return;
        }

        $attributeId = DB::table('su_product_attributes')->insertGetId([
            'product_id' => $productId,
            'name' => $attributeName,
            'slug' => Str::slug($attributeName),
        ]);

        // The parent row's declared value list and the values actually used
        // by its variations can disagree in the source export (seen for at
        // least one product); take the union so no variant is left without
        // a matching attribute value.
        $declaredValues = $this->splitList($parentRow['Attribute 1 value(s)'] ?? '');
        $actualValues = array_values(array_unique(array_map(
            fn ($row) => trim($row['Attribute 1 value(s)'] ?? ''),
            $childRows
        )));
        $allValues = array_values(array_unique(array_merge($declaredValues, $actualValues)));

        $valueIds = [];
        foreach ($allValues as $value) {
            $valueIds[$value] = DB::table('su_product_attribute_values')->insertGetId([
                'attribute_id' => $attributeId,
                'value' => $value,
                'slug' => Str::slug($value),
            ]);
        }

        foreach ($childRows as $child) {
            $value = trim($child['Attribute 1 value(s)'] ?? '');
            $attributeValueId = $valueIds[$value] ?? null;

            if ($attributeValueId === null) {
                continue;
            }

            $childImages = $this->splitList($child['Images'] ?? '');

            $variantId = DB::table('su_product_variants')->insertGetId([
                'product_id' => $productId,
                'variant_code' => Str::slug($value),
                'sku' => $this->nullIfBlank($child['SKU'] ?? null),
                'price' => $this->parseDecimal($child['Regular price'] ?? null) ?? 0,
                'sale_price' => $this->parseDecimal($child['Sale price'] ?? null),
                'stock_quantity' => $this->parseInt($child['Stock'] ?? null) ?? 0,
                'image' => $this->filenameFromUrl($childImages[0] ?? null),
                'variant_signature' => hash('sha256', $productId . '|' . $attributeId . '|' . $attributeValueId),
            ]);

            DB::table('su_product_variant_attributes')->insert([
                'variant_id' => $variantId,
                'attribute_id' => $attributeId,
                'attribute_value_id' => $attributeValueId,
            ]);

            foreach ($childImages as $position => $imageUrl) {
                DB::table('su_media')->insert([
                    'variant_id' => $variantId,
                    'type' => 'image',
                    'file_path' => $this->filenameFromUrl($imageUrl),
                    'position' => $position,
                ]);
            }
        }
    }

    // ---------------
    // Category / brand find-or-create helpers
    // ---------------
    private function findOrCreateCategory(string $name): int
    {
        $slug = Str::slug($name);

        if (isset($this->categoryCache[$slug])) {
            return $this->categoryCache[$slug];
        }

        $existing = DB::table('su_product_categories')->where('slug', $slug)->first();

        if ($existing) {
            return $this->categoryCache[$slug] = $existing->id;
        }

        return $this->categoryCache[$slug] = DB::table('su_product_categories')->insertGetId([
            'name' => $name,
            'slug' => $slug,
        ]);
    }

    private function findOrCreateBrand(string $name): int
    {
        $slug = Str::slug($name);

        if (isset($this->brandCache[$slug])) {
            return $this->brandCache[$slug];
        }

        $existing = DB::table('su_brands')->where('slug', $slug)->first();

        if ($existing) {
            return $this->brandCache[$slug] = $existing->id;
        }

        return $this->brandCache[$slug] = DB::table('su_brands')->insertGetId([
            'name' => $name,
            'slug' => $slug,
        ]);
    }

    // ---------------
    // Slug uniqueness for su_products.slug (has a UNIQUE constraint)
    // ---------------
    private function uniqueProductSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'product';
        $slug = $base;
        $suffix = 1;

        while (
            isset($this->usedProductSlugs[$slug])
            || DB::table('su_products')->where('slug', $slug)->exists()
        ) {
            $slug = $base . '-' . (++$suffix);
        }

        $this->usedProductSlugs[$slug] = true;

        return $slug;
    }

    // ---------------
    // Small parsing helpers
    // ---------------
    private function splitList(?string $value): array
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $value)), fn ($v) => $v !== ''));
    }

    private function parseDecimal(?string $value): ?float
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        return (float) $value;
    }

    private function parseInt(?string $value): ?int
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        return (int) $value;
    }

    private function nullIfBlank(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        return trim($value);
    }

    // ---------------
    // The CSV's "Images" column contains full site URLs
    // (e.g. https://finamax.co.ke/wp-content/uploads/2024/08/foo.jpg).
    // We only want the filename itself in the database, so strip
    // everything up to and including the last "/" (ignoring any query
    // string like "?ver=123" if present).
    // ---------------
    private function filenameFromUrl(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        $path = parse_url($value, PHP_URL_PATH) ?: $value;

        return basename($path);
    }

    // ---------------
    // short_description is varchar(255) on su_products; the CSV's "Short
    // description" values can run longer, so trim to fit rather than
    // letting the insert fail under strict SQL mode.
    // ---------------
    private function truncate(?string $value, int $length): ?string
    {
        if ($value === null) {
            return null;
        }

        return Str::limit($value, $length - 3, '...');
    }

    // ---------------
    // Minimal CSV reader (handles the UTF-8 BOM WooCommerce exports with)
    // ---------------
    private function readCsv(string $path): array
    {
        $handle = fopen($path, 'r');

        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle);
        $rows = [];

        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) < count($header)) {
                $data = array_pad($data, count($header), null);
            } elseif (count($data) > count($header)) {
                $data = array_slice($data, 0, count($header));
            }

            $rows[] = array_combine($header, $data);
        }

        fclose($handle);

        return $rows;
    }
}
