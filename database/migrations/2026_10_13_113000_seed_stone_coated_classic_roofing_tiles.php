<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $categoryId = DB::table('su_product_categories')
            ->where('slug', 'classic-roofing-tiles')
            ->value('id');

        if (! $categoryId) {
            throw new \RuntimeException('Classic Roofing Tiles category not found. Create the category before running this migration.');
        }

        $description = '<h3>Stone Coated Roofing Tiles</h3>'
            . '<p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p>'
            . '<p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>'
            . '<p>Although they require a higher initial investment, Stone Coated Tiles provide unmatched longevity, exceptional curb appeal, and significant added value to any property, offering a truly premium, maintenance-free solution.</p>';

        $items = [
            ['Charcoal Grey', 'charcoal-grey', 'SCC-CHARCOAL-GREY'],
            ['Forest Green', 'forest-green', 'SCC-FOREST-GREEN'],
            ['Tile Red', 'tile-red', 'SCC-TILE-RED'],
            ['Chocolate Brown', 'chocolate-brown', 'SCC-CHOCOLATE-BROWN'],
        ];

        foreach ($items as [$color, $suffix, $sku]) {
            $slug = 'stone-coated-classic-roofing-tiles-' . $suffix;
            $productId = DB::table('su_products')->where('slug', $slug)->value('id');

            if (! $productId) {
                $productId = DB::table('su_products')->insertGetId([
                    'name' => 'Stone Coated Classic Roofing Tiles - ' . $color,
                    'slug' => $slug,
                    'category_id' => $categoryId,
                    'sku' => $sku,
                    'price' => 750.00,
                    'currency' => 'KES',
                    'stock_quantity' => 200,
                    'is_variant' => 0,
                    'is_active' => 1,
                    'short_description' => 'Stone coated classic roofing tiles in ' . $color . '.',
                    'detailed_description' => $description,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $exists = DB::table('su_product_category')
                ->where('product_id', $productId)
                ->where('category_id', $categoryId)
                ->exists();

            if (! $exists) {
                DB::table('su_product_category')->insert([
                    'product_id' => $productId,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Intentionally preserve products and customer references on rollback.
    }
};
