<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $product = DB::table('su_products')
            ->where('slug', 'box-profile-tile-red')
            ->first();

        if (!$product) {
            throw new RuntimeException('Box Profile - Tile Red is missing. Run the Box Profile product migration first.');
        }

        $attributeIds = [];
        foreach (['gauge' => 'Gauge', 'finish' => 'Finish'] as $slug => $label) {
            $id = DB::table('su_product_attributes')
                ->where('product_id', $product->id)
                ->where('slug', $slug)
                ->value('id');

            if (!$id) {
                $id = DB::table('su_product_attributes')->insertGetId([
                    'product_id' => $product->id,
                    'name' => $label,
                    'slug' => $slug,
                    'created_at' => now(),
                ]);
            }
            $attributeIds[$slug] = $id;
        }

        $valueIds = [];
        foreach (['gauge' => ['28g', '28G'], 'finish' => ['glossy', 'Glossy']] as $slug => [$valueSlug, $valueLabel]) {
            $id = DB::table('su_product_attribute_values')
                ->where('attribute_id', $attributeIds[$slug])
                ->where('slug', $valueSlug)
                ->value('id');

            if (!$id) {
                $id = DB::table('su_product_attribute_values')->insertGetId([
                    'attribute_id' => $attributeIds[$slug],
                    'value' => $valueLabel,
                    'slug' => $valueSlug,
                    'created_at' => now(),
                ]);
            }
            $valueIds[$slug] = $id;
        }

        $existing = DB::table('su_product_variants as v')
            ->join('su_product_variant_attributes as ga', function ($join) use ($attributeIds, $valueIds) {
                $join->on('ga.variant_id', '=', 'v.id')
                    ->where('ga.attribute_id', '=', $attributeIds['gauge'])
                    ->where('ga.attribute_value_id', '=', $valueIds['gauge']);
            })
            ->join('su_product_variant_attributes as fa', function ($join) use ($attributeIds, $valueIds) {
                $join->on('fa.variant_id', '=', 'v.id')
                    ->where('fa.attribute_id', '=', $attributeIds['finish'])
                    ->where('fa.attribute_value_id', '=', $valueIds['finish']);
            })
            ->where('v.product_id', $product->id)
            ->value('v.id');

        if ($existing) {
            return;
        }

        $signatureValueIds = array_values($valueIds);
        sort($signatureValueIds, SORT_NUMERIC);
        $signature = hash('sha256', implode(',', $signatureValueIds));

        $variantId = DB::table('su_product_variants')
            ->where('product_id', $product->id)
            ->where('variant_signature', $signature)
            ->value('id');

        if (!$variantId) {
            $variantId = DB::table('su_product_variants')->insertGetId([
                'product_id' => $product->id,
                'variant_code' => 'BP-TILE-RED-28G-GLOSSY',
                'sku' => 'BP-TILE-RED-28G-GLOSSY',
                'price' => 700.00,
                'stock_quantity' => 200,
                'variant_signature' => $signature,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($valueIds as $slug => $valueId) {
            DB::table('su_product_variant_attributes')->updateOrInsert(
                ['variant_id' => $variantId, 'attribute_id' => $attributeIds[$slug]],
                ['attribute_value_id' => $valueId]
            );
        }
    }

    public function down(): void
    {
        // Keep any products/variants referenced by existing orders.
    }
};
