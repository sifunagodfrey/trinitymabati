<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('su_product_label', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('label_id');
            $table->primary(['product_id', 'label_id']);
            $table->index(['label_id'], 'label_id');
        });

        Schema::table('su_product_label', function (Blueprint $table) {
            $table->foreign('label_id', 'fk_product_label_label')->references('id')->on('su_product_labels')->cascadeOnDelete();
            $table->foreign('product_id', 'fk_product_label_product')->references('id')->on('su_products')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('su_product_label', function (Blueprint $table) {
            $table->dropForeign('fk_product_label_label');
            $table->dropForeign('fk_product_label_product');
        });
        Schema::dropIfExists('su_product_label');
    }
};