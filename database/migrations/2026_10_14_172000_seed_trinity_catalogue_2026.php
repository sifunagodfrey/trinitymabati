<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Step 3: load Trinity-Catalogue-2026.xlsx.
 *
 * Rules applied:
 *  - One product per finish + colour. Gauge is the variant (plus a Finish
 *    attribute holding the single finish, so quotations still show both).
 *  - Sheets sold per metre allow custom length (0.10 to 30 m), like the admin.
 *    Panels, fixed 2 m accessories, nails and washers do not.
 *  - Product names contain no hyphens or other special characters.
 *    (Slugs, SKUs and variant codes keep hyphens because they are internal.)
 */
return new class extends Migration
{
    private array $cats = [];
    private array $hasCol = [];

    // ---------------------------------------------------------------
    // Colour sets (taken from the catalogue tabs)
    // ---------------------------------------------------------------
    private const GLOSSY = ['Charcoal Grey', 'Brick Red', 'Tile Red', 'Maroon', 'Jungle Green', 'Ocean Blue'];
    private const MATTE = ['Charcoal Grey', 'Chocolate Brown', 'Maroon', 'Tile Red', 'Brick Red', 'Ocean Blue', 'Jungle Green', 'Dark Green'];
    private const STONE = ['Charcoal Grey', 'Dark Brown', 'Brick Red', 'Maroon', 'Black', 'Bark Wood Brown', 'Dark Green', 'Terracotta', 'Chocolate Brown'];

    public function up(): void
    {
        foreach (DB::table('su_product_categories')->get(['id', 'slug']) as $c) {
            $this->cats[$c->slug] = (int) $c->id;
        }

        DB::transaction(function () {
            foreach ($this->catalogue() as $product) {
                $this->save($product);
            }
        });
    }

    // ---------------------------------------------------------------
    // The catalogue
    // ---------------------------------------------------------------
    private function catalogue(): array
    {
        $boxDesc = '<h3>Box Profile Roofing Sheets</h3>'
            . '<p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p>'
            . '<p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>';

        $stoneDesc = '<h3>Stone Coated Roofing Tiles</h3>'
            . '<p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p>'
            . '<p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>';

        $benefits = "Order your Mabati from Trinity Mabati Factory\n\n"
            . "Invest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\n"
            . "Worry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\n"
            . "Achieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\n"
            . "Smarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\n"
            . "A Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.";

        $p = [];

        // ---------------- PROFILES tab (per metre, custom length) ----------------
        $sheet = fn (string $name, string $cat, string $finish, array $colours, array $gauges, ?string $desc = null) =>
            $this->matrix($name, $cat, $finish, $colours, $gauges, true, 'per metre', $desc, $desc ? $benefits : null);

        $glossyBox = ['30G' => 500, '28G' => 650];
        $matteBox = ['30G' => 600, '28G' => 700];

        // Box Profiles
        $p = array_merge($p,
            $sheet('Box Profile IT4 IT5', 'box-profiles', 'Glossy', ['Charcoal Grey', 'Brick Red', 'Tile Red', 'Maroon', 'Jungle Green', 'Ocean Blue'], $glossyBox, $boxDesc),
            $sheet('Box Profile IT4 IT5', 'box-profiles', 'Matte', ['Charcoal Grey', 'Chocolate Brown', 'Tile Red', 'Maroon', 'Jungle Green'], $matteBox, $boxDesc)
        );

        // Tile Profiles
        $p = array_merge($p,
            $sheet('Versatile Profile', 'versatile-profiles', 'Matte', ['Charcoal Grey', 'Chocolate Brown', 'Maroon', 'Tile Red', 'Brick Red', 'Ocean Blue'], $matteBox),
            $sheet('Eurotile Profile', 'eurotile-profiles', 'Matte', ['Charcoal Grey', 'Chocolate Brown', 'Maroon', 'Dark Green', 'Tile Red', 'Brick Red'], $matteBox),
            $sheet('Romantile', 'romantile-profiles', 'Matte', ['Charcoal Grey', 'Maroon', 'Brick Red', 'Chocolate Brown'], $matteBox)
        );

        // Corrugated Sheets
        $p = array_merge($p,
            $sheet('Corrugated Wave', 'corrugated-sheets', 'Glossy', ['Charcoal Grey', 'Brick Red', 'Tile Red', 'Ocean Blue', 'Jungle Green'], $glossyBox),
            $sheet('Corrugated Wave', 'corrugated-sheets', 'Matte', ['Charcoal Grey', 'Chocolate Brown', 'Maroon'], ['30G' => 600, '28G' => 650]),
            $sheet('Non Colored Corrugated Sheet', 'corrugated-sheets', 'Uncolored Galvanized', ['Metallic Silver'], ['32G' => 280, '30G' => 380])
        );

        // Industrial Sheets
        foreach (['Clear Transparent', 'Opal White'] as $colour) {
            $p[] = $this->item(
                $this->name('Translucent Clear Sheet', 'Fiberglass', $colour),
                'industrial-sheets',
                ['Standard Thickness' => 950, 'Standard Thickness Custom Length' => 1500],
                null, true, 'Translucent fiberglass sheet in ' . $colour . ', priced per metre. The custom length option is priced at 1500 per metre.',
                'Fiberglass'
            );
        }

        $p[] = $this->item('Polycarbonate Sheet', 'industrial-sheets', null, 17000, false, 'Polycarbonate sheet, priced per sheet.');

        foreach (['Glossy', 'Matte'] as $finish) {
            $p[] = $this->item(
                $this->name('Crimped Roofing Sheet', $finish),
                'industrial-sheets',
                ['30G' => 1000, '28G' => 1000],
                null, true, 'Crimped roofing sheet, ' . strtolower($finish) . ' finish, priced per metre.',
                $finish
            );
        }

        // ---------------- STONE COATED TILES tab (per panel) ----------------
        $tile = fn (string $name, string $cat, array $colours) =>
            $this->matrix($name, $cat, 'Alu Zinc Volcanic Stone', $colours, ['28G' => 650, '26G' => 700], false, 'per panel', $stoneDesc, null);

        $p = array_merge($p,
            $tile('Classic Tile', 'classic-roofing-tiles', ['Charcoal Grey', 'Dark Brown', 'Brick Red', 'Maroon', 'Black']),
            $tile('Shingles Tile', 'shingle-roofing-tiles', ['Charcoal Grey', 'Bark Wood Brown', 'Dark Green', 'Black']),
            $tile('Milano Tile', 'milano-roofing-tiles', ['Charcoal Grey', 'Terracotta', 'Chocolate Brown', 'Maroon'])
        );

        // ---------------- ROOFING ACCESSORIES tab ----------------
        // Fixed 2.0 m pieces, so no custom length. Gauge is the variant.
        $acc = fn (string $name, string $cat, string $finish, array $colours, array $gauges, string $unit = 'per 2.0 metre piece') =>
            $this->matrix($name, $cat, $finish, $colours, $gauges, false, $unit, null, null);

        $accG = ['30G' => 300, '28G' => 350];

        foreach (['Ridge Cap', 'Roll Top Ridge Cap'] as $ridge) {
            $p = array_merge($p,
                $acc($ridge, 'ridge-cap', 'Glossy', self::GLOSSY, $accG),
                $acc($ridge, 'ridge-cap', 'Matte', self::MATTE, $accG)
            );
        }

        $p = array_merge($p,
            $acc('Side Flashing', 'side-flashing', 'Glossy', self::GLOSSY, $accG),
            $acc('Side Flashing', 'side-flashing', 'Matte', self::MATTE, $accG),
            $acc('Valley Tray', 'valley-tray', 'Galvanized', ['Metallic Silver'], $accG),
            $acc('Valley Tray', 'valley-tray', 'Color Coated', array_values(array_unique(array_merge(self::GLOSSY, self::MATTE))), $accG),
            // Plain sheet is priced per metre "same as sheet", so custom length applies
            $this->matrix('Plain Sheet', 'plainsheet', 'Glossy', self::GLOSSY, ['30G' => 600, '28G' => 700], true, 'per metre', null, null)
        );

        $p[] = $this->item('Normal Roofing Nails Non Coloured', 'roofing-nails', null, 250, false, 'Normal roofing nails, non coloured, priced per kg.');
        $p[] = $this->item('Rubber Washers Coloured', 'washers', null, 100, false, 'Coloured rubber washers, priced per packet.');
        $p[] = $this->item(
            'PVC Gutters', 'pvc-gutters', null, 1500, false,
            "PVC gutters.\nGutter 1500 per piece\nClips 150\nConnectors 450 per piece\nDown pipe 1500 per piece\nThe rest 450 per piece"
        );

        // ---------------- STONE COATED ACCESSORIES tab ----------------
        $stoneG = ['28G' => 750, '26G' => 800];
        $stoneAcc = fn (string $name) =>
            $this->matrix($name, 'stoney-coated-accessories', 'Stone Coated', self::STONE, $stoneG, false, 'per 2.0 metre piece', null, null);

        $p = array_merge($p,
            $stoneAcc('Valley Tray'),
            $stoneAcc('Ridge Cap'),
            $stoneAcc('Side Flashing'),
            $this->matrix('Plain Sheet', 'stoney-coated-accessories', 'Stone Coated', self::STONE, $stoneG, false, 'per 2.0M x 0.45M sheet', null, null),
            // Barge Box goes directly under Roofing Accessories
            $this->matrix('Barge Box', 'roofing-accessories', 'Stone Coated', self::STONE, $stoneG, false, 'per 2.0 metre piece', null, null)
        );

        $p[] = $this->item('Touch Up Kit Glue Chips', 'roofing-accessories', null, 800, false, 'Natural chips and adhesive for repairs and cuts. Covers about 100 sq.m of roof.');
        $p[] = $this->item('Serrated Ring Shank Nails Galvanized', 'roofing-accessories', null, 800, false, 'Heavy duty galvanized side fixing nails. 1 kg pack, about 250 pieces.');
        $p[] = $this->item('Roofing Nails and Rubber Washers', 'stoney-coated-accessories', null, 800, false, 'Standard galvanized spiral roofing nails with rubber washers. 1 kg pack.');

        return $p;
    }

    // ---------------------------------------------------------------
    // Builders
    // ---------------------------------------------------------------

    // One product per colour for a finish
    private function matrix(string $base, string $cat, string $finish, array $colours, array $gauges, bool $custom, string $unit, ?string $desc, ?string $notes): array
    {
        $out = [];
        foreach ($colours as $colour) {
            $name = $this->name($base, $finish, $colour);
            $short = $name . ', ' . $unit . '.';
            $out[] = $this->item($name, $cat, $gauges, null, $custom, $short, $finish, $desc, $notes);
        }

        return $out;
    }

    private function item(string $name, string $cat, ?array $gauges, $price, bool $custom, string $short, ?string $finish = null, ?string $desc = null, ?string $notes = null): array
    {
        return compact('name', 'cat', 'gauges', 'price', 'custom', 'short', 'finish', 'desc', 'notes');
    }

    // Join the parts, drop anything that is not a letter, digit or space, and avoid repeating a word group
    private function name(string ...$parts): string
    {
        $name = '';
        foreach ($parts as $part) {
            $part = trim(preg_replace('/\s+/', ' ', preg_replace('/[^A-Za-z0-9 ]+/', ' ', $part)));
            if ($part === '' || stripos($name, $part) !== false) {
                continue;
            }
            $name = trim($name . ' ' . $part);
        }

        return $name;
    }

    // ---------------------------------------------------------------
    // Writer
    // ---------------------------------------------------------------
    private function col(string $column): bool
    {
        return $this->hasCol[$column] ??= Schema::hasColumn('su_products', $column);
    }

    private function save(array $p): void
    {
        $categoryId = $this->cats[$p['cat']] ?? null;
        if (! $categoryId) {
            throw new RuntimeException("Category '{$p['cat']}' not found. Run the category migration first.");
        }

        $slug = Str::slug($p['name']);
        $sku = strtoupper($slug);
        $hasVariants = ! empty($p['gauges']);
        $price = $hasVariants ? min($p['gauges']) : $p['price'];

        $id = DB::table('su_products')->where('slug', $slug)->value('id');

        if (! $id) {
            $data = [
                'name' => $p['name'],
                'slug' => $slug,
                'category_id' => $categoryId,
                'sku' => $sku,
                'price' => $price,
                'currency' => 'KES',
                'stock_quantity' => 200,
                'is_variant' => $hasVariants ? 1 : 0,
                'is_active' => 1,
                'short_description' => $p['short'],
                'detailed_description' => $p['desc'] ?? $p['short'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if ($p['notes']) $data['condition_notes'] = $p['notes'];
            if ($this->col('allow_custom_length')) $data['allow_custom_length'] = $p['custom'] ? 1 : 0;
            if ($p['custom']) {
                if ($this->col('default_length_m')) $data['default_length_m'] = 1.00;
                if ($this->col('min_length_m')) $data['min_length_m'] = 0.10;
                if ($this->col('max_length_m')) $data['max_length_m'] = 30.00;
            }
            if ($hasVariants) {
                if ($this->col('default_gauge')) $data['default_gauge'] = array_key_first($p['gauges']);
                if ($this->col('default_finish') && $p['finish']) $data['default_finish'] = $p['finish'];
            }

            $id = DB::table('su_products')->insertGetId($data);
        }

        if (! DB::table('su_product_category')->where('product_id', $id)->where('category_id', $categoryId)->exists()) {
            DB::table('su_product_category')->insert(['product_id' => $id, 'category_id' => $categoryId]);
        }

        if ($hasVariants) {
            $this->variants($id, $sku, $p['gauges'], $p['finish']);
        }
    }

    private function variants(int $productId, string $sku, array $gauges, ?string $finish): void
    {
        $gaugeAttr = $this->attribute($productId, 'Gauge');
        $gaugeValues = [];
        foreach (array_keys($gauges) as $label) {
            $gaugeValues[$label] = $this->attributeValue($gaugeAttr, $label);
        }

        $finishAttr = $finishValue = null;
        if ($finish) {
            $finishAttr = $this->attribute($productId, 'Finish');
            $finishValue = $this->attributeValue($finishAttr, $finish);
        }

        $index = 0;
        foreach ($gauges as $label => $price) {
            $index++;
            $suffix = preg_match('/^\d+G$/', $label) ? $label : 'V' . $index;
            $code = $sku . '-' . $suffix;

            $valueIds = array_filter([$gaugeValues[$label], $finishValue]);
            sort($valueIds, SORT_NUMERIC);
            $signature = hash('sha256', implode(',', $valueIds));

            $variantId = DB::table('su_product_variants')
                ->where('product_id', $productId)
                ->where('variant_signature', $signature)
                ->value('id');

            if (! $variantId) {
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

            $links = [[$gaugeAttr, $gaugeValues[$label]]];
            if ($finishAttr) {
                $links[] = [$finishAttr, $finishValue];
            }
            foreach ($links as [$attributeId, $valueId]) {
                DB::table('su_product_variant_attributes')->updateOrInsert(
                    ['variant_id' => $variantId, 'attribute_id' => $attributeId],
                    ['attribute_value_id' => $valueId]
                );
            }
        }
    }

    private function attribute(int $productId, string $name): int
    {
        $slug = Str::slug($name);
        $id = DB::table('su_product_attributes')->where('product_id', $productId)->where('slug', $slug)->value('id');

        return (int) ($id ?: DB::table('su_product_attributes')->insertGetId([
            'product_id' => $productId, 'name' => $name, 'slug' => $slug, 'created_at' => now(),
        ]));
    }

    private function attributeValue(int $attributeId, string $value): int
    {
        $slug = Str::slug($value);
        $id = DB::table('su_product_attribute_values')->where('attribute_id', $attributeId)->where('slug', $slug)->value('id');

        return (int) ($id ?: DB::table('su_product_attribute_values')->insertGetId([
            'attribute_id' => $attributeId, 'value' => $value, 'slug' => $slug, 'created_at' => now(),
        ]));
    }

    public function down(): void
    {
        // Preserve products and any customer references on rollback.
    }
};
