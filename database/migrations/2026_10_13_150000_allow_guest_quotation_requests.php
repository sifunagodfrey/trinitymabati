<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('su_quotations', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->change();
            $table->string('customer_first_name', 100)->nullable();
            $table->string('customer_last_name', 100)->nullable();
            $table->string('customer_phone', 30)->nullable();
            $table->string('customer_email', 190)->nullable();
        });
    }
    public function down(): void {
        Schema::table('su_quotations', function (Blueprint $table) {
            $table->dropColumn(['customer_first_name','customer_last_name','customer_phone','customer_email']);
        });
    }
};
