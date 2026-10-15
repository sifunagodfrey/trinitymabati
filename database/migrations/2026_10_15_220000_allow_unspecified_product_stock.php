<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['su_products', 'su_product_variants'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->integer('stock_quantity')->nullable()->default(null)->change();
            });
            // One-time conversion. Explicit zero quantities entered later remain sold out.
            DB::table($tableName)->where('stock_quantity', 0)->update(['stock_quantity' => null]);
        }
    }

    public function down(): void
    {
        foreach (['su_products', 'su_product_variants'] as $tableName) {
            DB::table($tableName)->whereNull('stock_quantity')->update(['stock_quantity' => 0]);
            Schema::table($tableName, function (Blueprint $table) {
                $table->integer('stock_quantity')->nullable(false)->default(0)->change();
            });
        }
    }
};
