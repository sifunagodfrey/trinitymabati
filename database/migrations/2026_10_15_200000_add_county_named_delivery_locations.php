<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            // Use the existing counties, preserving their spelling and IDs.
            $counties = DB::table('su_counties')->orderBy('id')->lockForUpdate()->get();

            foreach ($counties as $county) {
                $townId = DB::table('su_towns')
                    ->where('county_id', $county->id)
                    ->where('name', $county->name)
                    ->value('id');

                if ($townId === null) {
                    $townId = DB::table('su_towns')->insertGetId([
                        'county_id' => $county->id,
                        'name' => $county->name,
                        'created_at' => now(),
                    ]);
                }

                // Reuse a matching location; do not duplicate or remove other towns.
                DB::table('su_location_pricing')->updateOrInsert(
                    ['town_id' => $townId],
                    ['price' => 0, 'updated_at' => now()]
                );
            }
        });
    }

    public function down(): void
    {
        // Retain delivery locations and prices: orders may already refer to them.
    }
};
