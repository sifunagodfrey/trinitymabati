<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('su_team_members', function (Blueprint $table) {
            $table->string('title', 160)->nullable();
        });
        Schema::create('su_partners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 160);
            $table->string('image');
            $table->boolean('is_published')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('su_partners');
        Schema::table('su_team_members', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
};
