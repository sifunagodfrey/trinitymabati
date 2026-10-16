<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ---------------
    // Add is_user_read to system messages when missing
    // ---------------
    public function up(): void
    {
        if (! Schema::hasColumn('su_system_messages', 'is_user_read')) {
            Schema::table('su_system_messages', function (Blueprint $table) {
                $table->boolean('is_user_read')->default(false)->after('is_read');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('su_system_messages', 'is_user_read')) {
            Schema::table('su_system_messages', function (Blueprint $table) {
                $table->dropColumn('is_user_read');
            });
        }
    }
};