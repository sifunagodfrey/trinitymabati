<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('su_payments', function (Blueprint $table) {
            $table->boolean('is_manual')->default(false)->index();
        });
        DB::table('su_payments')->whereNotNull('manual_reference')->update(['is_manual' => true]);
        DB::table('su_payment_methods')->where('is_manual', true)
            ->where('description', 'Pay using the details shown and submit your transaction reference for manual verification.')
            ->update(['description' => 'Pay using the details shown. Your payment will be verified manually.']);
    }

    public function down(): void
    {
        if (DB::table('su_payments')->where('is_manual', true)->whereNull('manual_reference')->exists()) {
            throw new \RuntimeException('Reference-free manual payments exist. Keep the manual flag to preserve their approval workflow.');
        }
        Schema::table('su_payments', function (Blueprint $table) {
            $table->dropIndex(['is_manual']);
            $table->dropColumn('is_manual');
        });
    }
};
