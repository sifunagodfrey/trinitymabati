<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ---------------
    // Flag a partner as an association (shown under "Our Associations")
    // ---------------
    public function up(): void
    {
        Schema::table('su_partners', function (Blueprint $table) {
            $table->boolean('is_association')->default(false)->index()->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('su_partners', function (Blueprint $table) {
            $table->dropIndex(['is_association']);
            $table->dropColumn('is_association');
        });
    }
};