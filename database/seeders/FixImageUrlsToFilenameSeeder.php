<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * One-off fix for data already inserted by ProductCsvSeeder before it was
 * changed to store filenames instead of full URLs.
 *
 * Converts:
 *   https://finamax.co.ke/wp-content/uploads/2024/08/some-image.jpg
 * into:
 *   some-image.jpg
 *
 * Safe to run more than once — rows that are already just a filename
 * (no "/" in the value) are left untouched.
 */
class FixImageUrlsToFilenameSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $thumbFixed = $this->fixColumn('su_products', 'thumbnail');
            $variantImageFixed = $this->fixColumn('su_product_variants', 'image');
            $mediaFixed = $this->fixColumn('su_media', 'file_path');

            $this->command->info("Fixed su_products.thumbnail: {$thumbFixed}");
            $this->command->info("Fixed su_product_variants.image: {$variantImageFixed}");
            $this->command->info("Fixed su_media.file_path: {$mediaFixed}");
        });
    }

    /**
     * Rewrite every non-null value in $table.$column that still looks like
     * a URL/path to just its filename (the part after the last "/").
     */
    private function fixColumn(string $table, string $column): int
    {
        $fixed = 0;

        DB::table($table)
            ->whereNotNull($column)
            ->where($column, 'like', '%/%') // skip rows already just a filename
            ->orderBy('id')
            ->chunkById(200, function ($rows) use ($table, $column, &$fixed) {
                foreach ($rows as $row) {
                    $original = $row->{$column};
                    $filename = $this->filenameFromValue($original);

                    if ($filename !== $original && $filename !== null) {
                        DB::table($table)
                            ->where('id', $row->id)
                            ->update([$column => $filename]);
                        $fixed++;
                    }
                }
            }, 'id');

        return $fixed;
    }

    /**
     * Extract the filename from a full URL or path, ignoring any query
     * string (?ver=123) or fragment (#foo) if present.
     */
    private function filenameFromValue(string $value): ?string
    {
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        $path = parse_url($value, PHP_URL_PATH) ?: $value;

        return basename($path);
    }
}
