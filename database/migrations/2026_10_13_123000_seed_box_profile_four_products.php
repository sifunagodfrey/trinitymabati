<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $categoryId = DB::table('su_product_categories')->where('slug', 'box-profile')->value('id');
        if (!$categoryId) {
            throw new RuntimeException('Box Profile category missing. Create the category first.');
        }

        $description = '<h3>Box Profile Roofing Sheets</h3>'
            . '<p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p>'
            . '<p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>';

        $benefits = "Order your Mabati from Trinity Mabati Factory\n\n"
            . "Invest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\n"
            . "Worry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\n"
            . "Achieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\n"
            . "Smarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\n"
            . "A Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.";

        $items = [
            ['Charcoal Grey', 'charcoal-grey', 'BP-CHARCOAL-GREY'],
            ['Tile Red', 'tile-red', 'BP-TILE-RED'],
            ['Maroon', 'maroon', 'BP-MAROON'],
            ['Forest Green', 'forest-green', 'BP-FOREST-GREEN'],
        ];

        foreach ($items as [$color, $colorSlug, $sku]) {
            $slug = 'box-profile-' . $colorSlug;
            $id = DB::table('su_products')->where('slug', $slug)->value('id');

            if (!$id) {
                $data = [
                    'name' => 'Box Profile - ' . $color,
                    'slug' => $slug,
                    'category_id' => $categoryId,
                    'sku' => $sku,
                    'price' => 550,
                    'currency' => 'KES',
                    'stock_quantity' => 200,
                    'is_variant' => 1,
                    'is_active' => 1,
                    'short_description' => 'Box Profile roofing sheet in ' . $color . '.',
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
                $id = DB::table('su_products')->insertGetId($data);
            }

            if (!DB::table('su_product_category')->where('product_id', $id)->where('category_id', $categoryId)->exists()) {
                DB::table('su_product_category')->insert(['product_id' => $id, 'category_id' => $categoryId]);
            }

            $ids = [];
            foreach ([['Gauge', 'gauge', ['30G' => '30g', '28G' => '28g']],
                      ['Finish', 'finish', ['Matte' => 'matte']]] as [$title, $key, $values]) {
                $attrId = DB::table('su_product_attributes')->where('product_id', $id)->where('slug', $key)->value('id');
                if (!$attrId) {
                    $attrId = DB::table('su_product_attributes')->insertGetId([
                        'product_id' => $id, 'name' => $title, 'slug' => $key, 'created_at' => now(),
                    ]);
                }
                foreach ($values as $label => $valueSlug) {
                    $valueId = DB::table('su_product_attribute_values')->where('attribute_id', $attrId)->where('slug', $valueSlug)->value('id');
                    if (!$valueId) {
                        $valueId = DB::table('su_product_attribute_values')->insertGetId([
                            'attribute_id' => $attrId, 'value' => $label, 'slug' => $valueSlug, 'created_at' => now(),
                        ]);
                    }
                    $ids[$key][$label] = ['attribute' => $attrId, 'value' => $valueId];
                }
            }

            foreach (['30G' => 550, '28G' => 720] as $gauge => $price) {
                $code = $sku . '-' . $gauge . '-MATTE';
                $variantId = DB::table('su_product_variants')->where('product_id', $id)->where('variant_code', $code)->value('id');
                if (!$variantId) {
                    $signature = hash('sha256', implode(':', [
                        $ids['gauge'][$gauge]['value'],
                        $ids['finish']['Matte']['value'],
                    ]));
                    $variantId = DB::table('su_product_variants')->insertGetId([
                        'product_id' => $id,
                        'variant_code' => $code,
                        'sku' => $code,
                        'price' => $price,
                        'stock_quantity' => 200,
                        'variant_signature' => $signature,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                foreach ([$ids['gauge'][$gauge], $ids['finish']['Matte']] as $entry) {
                    if (!DB::table('su_product_variant_attributes')
                        ->where('variant_id', $variantId)
                        ->where('attribute_id', $entry['attribute'])
                        ->exists()) {
                        DB::table('su_product_variant_attributes')->insert([
                            'variant_id' => $variantId,
                            'attribute_id' => $entry['attribute'],
                            'attribute_value_id' => $entry['value'],
                        ]);
                    }
                }
            }
        }
    }

    public function down(): void
    {
        // Preserve product records and any customer order references.
    }
};
