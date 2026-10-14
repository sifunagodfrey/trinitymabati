<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $categoryId = DB::table('su_product_categories')->where('slug', 'corrugated-sheets')->value('id');
        if (!$categoryId) {
            throw new RuntimeException('Corrugated Sheets category is missing.');
        }

        $description = '<h3>Corrugated Roofing Sheets</h3>'
            . '<p>Corrugated roofing sheets, widely known across Kenya as mabati, represent the most economical roofing solution, making them highly favored for projects ranging from modern housing to functional commercial structures. These sheets are specifically valued for their superior ability to handle the diverse Kenyan climate, offering proven durability against heavy seasonal rains and intense equatorial sun.</p>'
            . '<p>Available in various gauges (thicknesses) and attractive colored finishes, they are lightweight, easy to transport and install, providing a practical, high-value, and long-lasting choice perfectly suited for any budget-conscious construction.</p>';

        $benefits = "Order your Mabati from Trinity Mabati Factory\n\n"
            . "Invest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\n"
            . "Worry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\n"
            . "Achieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\n"
            . "Smarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\n"
            . "A Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.";

        $products = [
            ['Forest Green', 'forest-green', 'CR-FOREST-GREEN'],
            ['Charcoal Grey', 'charcoal-grey', 'CR-CHARCOAL-GREY'],
            ['Tile Red', 'tile-red', 'CR-TILE-RED'],
            ['Maroon', 'maroon', 'CR-MAROON'],
            ['Maasai Red', 'maasai-red', 'CR-MAASAI-RED'],
        ];

        foreach ($products as [$color, $colorSlug, $sku]) {
            $slug = 'corrugated-roofing-sheet-' . $colorSlug;
            $productId = DB::table('su_products')->where('slug', $slug)->value('id');

            if (!$productId) {
                $data = [
                    'name' => 'Corrugated Roofing Sheet - ' . $color,
                    'slug' => $slug,
                    'category_id' => $categoryId,
                    'sku' => $sku,
                    'price' => 550.00,
                    'currency' => 'KES',
                    'stock_quantity' => 200,
                    'is_variant' => 1,
                    'is_active' => 1,
                    'short_description' => 'Corrugated roofing sheet in ' . $color . '.',
                    'detailed_description' => $description,
                    'condition_notes' => $benefits,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                if (Schema::hasColumn('su_products', 'allow_custom_length')) $data['allow_custom_length'] = 1;
                if (Schema::hasColumn('su_products', 'default_length_m')) $data['default_length_m'] = 1.00;
                if (Schema::hasColumn('su_products', 'min_length_m')) $data['min_length_m'] = 0.10;
                if (Schema::hasColumn('su_products', 'max_length_m')) $data['max_length_m'] = 30.00;
                if (Schema::hasColumn('su_products', 'default_gauge')) $data['default_gauge'] = '30G';
                if (Schema::hasColumn('su_products', 'default_finish')) $data['default_finish'] = 'Matte';
                $productId = DB::table('su_products')->insertGetId($data);
            }

            if (!DB::table('su_product_category')->where('product_id', $productId)->where('category_id', $categoryId)->exists()) {
                DB::table('su_product_category')->insert(['product_id' => $productId, 'category_id' => $categoryId]);
            }

            $values = [];
            foreach ([
                ['Gauge', 'gauge', ['30G' => '30g', '28G' => '28g']],
                ['Finish', 'finish', ['Matte' => 'matte', 'Glossy' => 'glossy']],
            ] as [$label, $attributeSlug, $options]) {
                $attributeId = DB::table('su_product_attributes')->where('product_id', $productId)->where('slug', $attributeSlug)->value('id');
                if (!$attributeId) {
                    $attributeId = DB::table('su_product_attributes')->insertGetId([
                        'product_id' => $productId, 'name' => $label, 'slug' => $attributeSlug, 'created_at' => now(),
                    ]);
                }
                foreach ($options as $option => $optionSlug) {
                    $valueId = DB::table('su_product_attribute_values')->where('attribute_id', $attributeId)->where('slug', $optionSlug)->value('id');
                    if (!$valueId) {
                        $valueId = DB::table('su_product_attribute_values')->insertGetId([
                            'attribute_id' => $attributeId, 'value' => $option, 'slug' => $optionSlug, 'created_at' => now(),
                        ]);
                    }
                    $values[$attributeSlug][$option] = ['attribute_id' => $attributeId, 'value_id' => $valueId];
                }
            }

            foreach ([['30G', 'Matte', 550.00], ['28G', 'Matte', 720.00], ['28G', 'Glossy', 700.00]] as [$gauge, $finish, $price]) {
                $code = $sku . '-' . $gauge . '-' . strtoupper($finish);
                $variantId = DB::table('su_product_variants')->where('product_id', $productId)->where('variant_code', $code)->value('id');
                if (!$variantId) {
                    $signature = hash('sha256', $values['gauge'][$gauge]['value_id'] . ':' . $values['finish'][$finish]['value_id']);
                    $variantId = DB::table('su_product_variants')->insertGetId([
                        'product_id' => $productId,
                        'variant_code' => $code,
                        'sku' => $code,
                        'price' => $price,
                        'stock_quantity' => 200,
                        'variant_signature' => $signature,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                foreach ([$values['gauge'][$gauge], $values['finish'][$finish]] as $pair) {
                    if (!DB::table('su_product_variant_attributes')->where('variant_id', $variantId)->where('attribute_id', $pair['attribute_id'])->exists()) {
                        DB::table('su_product_variant_attributes')->insert([
                            'variant_id' => $variantId,
                            'attribute_id' => $pair['attribute_id'],
                            'attribute_value_id' => $pair['value_id'],
                        ]);
                    }
                }
            }
        }

        $plainSlug = 'corrugated-alluzinc-roofing-sheet-non-colored';
        if (!DB::table('su_products')->where('slug', $plainSlug)->exists()) {
            $data = [
                'name' => 'Corrugated Alluzinc Roofing Sheet - Non Colored',
                'slug' => $plainSlug,
                'category_id' => $categoryId,
                'sku' => 'CR-ALLUZINC-NON-COLORED',
                'price' => 550.00,
                'currency' => 'KES',
                'stock_quantity' => 200,
                'is_variant' => 0,
                'is_active' => 1,
                'short_description' => 'Non colored corrugated Alluzinc roofing sheet.',
                'detailed_description' => $description,
                'condition_notes' => $benefits,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (Schema::hasColumn('su_products', 'allow_custom_length')) $data['allow_custom_length'] = 1;
            if (Schema::hasColumn('su_products', 'default_length_m')) $data['default_length_m'] = 1.00;
            if (Schema::hasColumn('su_products', 'min_length_m')) $data['min_length_m'] = 0.10;
            if (Schema::hasColumn('su_products', 'max_length_m')) $data['max_length_m'] = 30.00;
            $id = DB::table('su_products')->insertGetId($data);
        } else {
            $id = DB::table('su_products')->where('slug', $plainSlug)->value('id');
        }
        if (!DB::table('su_product_category')->where('product_id', $id)->where('category_id', $categoryId)->exists()) {
            DB::table('su_product_category')->insert(['product_id' => $id, 'category_id' => $categoryId]);
        }
    }

    public function down(): void
    {
        // Existing products and quotation references are intentionally preserved.
    }
};
