<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('su_products', function (Blueprint $table) {
            if (!Schema::hasColumn('su_products', 'default_gauge')) $table->string('default_gauge', 100)->nullable();
            if (!Schema::hasColumn('su_products', 'default_finish')) $table->string('default_finish', 100)->nullable();
        });
        DB::table('su_products')->where('allow_custom_length', 1)
            ->where('default_length_m', 3)->update(['default_length_m' => 1]);
        DB::table('su_products')->where('allow_custom_length', 1)
            ->whereNull('default_gauge')->update(['default_gauge' => '30G']);
        DB::table('su_products')->where('allow_custom_length', 1)
            ->whereNull('default_finish')->update(['default_finish' => 'Matte']);
    }

    public function down(): void
    {
        Schema::table('su_products', function (Blueprint $table) {
            $table->dropColumn(['default_gauge', 'default_finish']);
        });
    }
};
