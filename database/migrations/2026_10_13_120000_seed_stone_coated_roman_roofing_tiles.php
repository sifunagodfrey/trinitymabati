<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $categoryId = DB::table('su_product_categories')
            ->where('slug', 'roman-roofing-tiles')
            ->value('id');

        if (!$categoryId) {
            throw new RuntimeException('Roman Roofing Tiles category not found.');
        }

        $description = '<h3>Stone Coated Roofing Tiles</h3>'
            . '<p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p>'
            . '<p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>'
            . '<p>Although they require a higher initial investment, Stone Coated Tiles provide unmatched longevity, exceptional curb appeal, and significant added value to any property, offering a truly premium, maintenance-free solution.</p>';

        $benefits = "Order your Mabati from Trinity Mabati Factory\n\n"
            . "Invest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\n"
            . "Worry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\n"
            . "Achieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\n"
            . "Smarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\n"
            . "A Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.";

        $items = [
            ['Charcoal Grey', 'charcoal-grey', 'SCR-CHARCOAL-GREY'],
            ['Tile Red', 'tile-red', 'SCR-TILE-RED'],
        ];

        foreach ($items as [$color, $suffix, $sku]) {
            $slug = 'stone-coated-roman-roofing-tiles-' . $suffix;
            $id = DB::table('su_products')->where('slug', $slug)->value('id');

            if (!$id) {
                $id = DB::table('su_products')->insertGetId([
                    'name' => 'Stone Coated Roman Roofing Tiles - ' . $color,
                    'slug' => $slug,
                    'category_id' => $categoryId,
                    'sku' => $sku,
                    'price' => 750.00,
                    'currency' => 'KES',
                    'stock_quantity' => 200,
                    'is_variant' => 0,
                    'is_active' => 1,
                    'short_description' => 'Stone coated Roman roofing tiles in ' . $color . '.',
                    'detailed_description' => $description,
                    'condition_notes' => $benefits,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $linked = DB::table('su_product_category')
                ->where('product_id', $id)
                ->where('category_id', $categoryId)
                ->exists();

            if (!$linked) {
                DB::table('su_product_category')->insert([
                    'product_id' => $id,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Keep existing products and order references intact.
    }
};
