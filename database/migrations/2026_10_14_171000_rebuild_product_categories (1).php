<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Step 2: make su_product_categories match the new category tree.
 *
 * - Existing categories that match a new one (by slug, by name, or by a known
 *   legacy slug) are EDITED in place, so their images and descriptions survive.
 * - Missing ones are created.
 * - Every other category is deleted, except the default "Uncategorized" one.
 */
return new class extends Migration
{
    // name => [slug, children (name => slug)], plus legacy slugs to reuse
    private function tree(): array
    {
        return [
            ['Box Profiles', 'box-profiles', ['box-profile'], []],
            ['Corrugated Sheets', 'corrugated-sheets', ['corrugated-roofing-sheets', 'corrugated-sheet'], []],
            ['Stone Coated Profiles', 'stone-coated-profiles', ['stone-coated-roofing-tiles'], [
                ['Classic roofing tiles', 'classic-roofing-tiles', ['stone-coated-classic-roofing-tiles']],
                ['Shingle roofing tiles', 'shingle-roofing-tiles', ['stone-coated-shingle-roofing-tiles']],
                ['Milano roofing tiles', 'milano-roofing-tiles', ['roman-roofing-tiles', 'stone-coated-roman-roofing-tiles']],
            ]],
            ['Tile Profiles', 'tile-profiles', [], [
                ['Versatile profiles', 'versatile-profiles', []],
                ['Eurotile profiles', 'eurotile-profiles', []],
                ['Romantile profiles', 'romantile-profiles', []],
            ]],
            ['Industrial Sheets', 'industrial-sheets', [], []],
            ['Roofing Accessories', 'roofing-accessories', [], [
                ['Stoney coated accessories', 'stoney-coated-accessories', []],
                ['Ridge cap', 'ridge-cap', []],
                ['Valley tray', 'valley-tray', []],
                ['Side flashing', 'side-flashing', []],
                ['Plainsheet', 'plainsheet', []],
                ['Roofing nails', 'roofing-nails', []],
                ['Washers', 'washers', []],
                ['PVC Gutters', 'pvc-gutters', []],
            ]],
        ];
    }

    public function up(): void
    {
        DB::transaction(function () {
            $keep = [];

            foreach ($this->tree() as [$name, $slug, $legacy, $children]) {
                $parentId = $this->upsert($name, $slug, $legacy, null);
                $keep[] = $parentId;

                foreach ($children as [$childName, $childSlug, $childLegacy]) {
                    $keep[] = $this->upsert($childName, $childSlug, $childLegacy, $parentId);
                }
            }

            // Keep the default fallback category
            $defaultIds = DB::table('su_product_categories')->where('is_default', 1)->pluck('id')->all();
            $keep = array_merge($keep, $defaultIds);

            // Delete the rest, children before parents
            $stale = DB::table('su_product_categories')->whereNotIn('id', $keep);
            $staleIds = (clone $stale)->pluck('id')->all();

            if ($staleIds) {
                DB::table('su_product_categories')->whereIn('id', $staleIds)->whereNotNull('parent_id')->delete();
                DB::table('su_product_categories')->whereIn('id', $staleIds)->delete();
            }
        });
    }

    private function upsert(string $name, string $slug, array $legacySlugs, ?int $parentId): int
    {
        $row = DB::table('su_product_categories')->where('slug', $slug)->first()
            ?? DB::table('su_product_categories')->whereRaw('LOWER(name) = ?', [strtolower($name)])->first();

        if (! $row && $legacySlugs) {
            $row = DB::table('su_product_categories')->whereIn('slug', $legacySlugs)->first();
        }

        if ($row) {
            DB::table('su_product_categories')->where('id', $row->id)->update([
                'name' => $name,
                'slug' => $slug,
                'parent_id' => $parentId,
                'is_default' => 0,
            ]);

            return (int) $row->id;
        }

        return (int) DB::table('su_product_categories')->insertGetId([
            'name' => $name,
            'slug' => $slug,
            'parent_id' => $parentId,
            'is_default' => 0,
            'created_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Category changes are not reverted.
    }
};
