<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('su_seo_metadata', function (Blueprint $table) {
            $table->id();
            $table->string('route_name', 100);
            $table->string('resource_slug', 255)->default('');
            $table->string('meta_title', 180)->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->unique(['route_name', 'resource_slug']);
        });
        Schema::create('su_seo_slug_redirects', function (Blueprint $table) {
            $table->id();
            $table->string('kind', 20);
            $table->string('old_slug', 255);
            $table->unsignedBigInteger('entity_id');
            $table->timestamp('created_at')->nullable();
            $table->unique(['kind', 'old_slug']);
        });
        foreach (['seo_indexing_enabled' => '1', 'seo_canonical_redirect' => '0', 'ga4_enabled' => '0',
            'ga4_measurement_id' => '', 'google_site_verification' => ''] as $key => $value) {
            DB::table('su_settings')->insertOrIgnore(['setting_key' => $key, 'setting_value' => $value]);
        }
        Cache::forget('site_settings_all');
    }

    public function down(): void
    {
        Schema::dropIfExists('su_seo_slug_redirects');
        Schema::dropIfExists('su_seo_metadata');
        // Keep site settings to avoid discarding configured account IDs.
    }
};
