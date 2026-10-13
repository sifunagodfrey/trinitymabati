<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ---------------
    // Apply: is_default flag replaces the hardcoded "uncategorized" slug / id 17
    // ---------------
    public function up(): void
    {
        // ---------------
        // 1. Add the column (skipped if the SQL script was already run manually)
        // ---------------
        if (! Schema::hasColumn('su_product_categories', 'is_default')) {
            Schema::table('su_product_categories', function (Blueprint $table) {
                $table->boolean('is_default')->default(false)->after('description');
            });
        }

        // ---------------
        // 2. Fill values: "Uncategorized" stays the default, every other category gets 0
        // ---------------
        DB::table('su_product_categories')->update([
            'is_default' => DB::raw("CASE WHEN slug = 'uncategorized' THEN 1 ELSE 0 END"),
        ]);

        // ---------------
        // 3. Drop the hardcoded DEFAULT 17 so products saved without a category
        //    become NULL and the triggers assign the current default
        // ---------------
        DB::statement('ALTER TABLE su_products ALTER COLUMN category_id DROP DEFAULT');

        // ---------------
        // 4. Replace the slug-based triggers with is_default-based ones
        // ---------------
        $this->dropTriggers();

        DB::unprepared("
            CREATE TRIGGER trg_su_products_default_category_insert BEFORE INSERT ON su_products FOR EACH ROW
            BEGIN
                IF NEW.category_id IS NULL THEN
                    SET NEW.category_id = (SELECT id FROM su_product_categories WHERE is_default = 1 LIMIT 1);
                END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_su_products_default_category_update BEFORE UPDATE ON su_products FOR EACH ROW
            BEGIN
                IF NEW.category_id IS NULL THEN
                    SET NEW.category_id = (SELECT id FROM su_product_categories WHERE is_default = 1 LIMIT 1);
                END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_su_product_categories_protect_default BEFORE DELETE ON su_product_categories FOR EACH ROW
            BEGIN
                IF OLD.is_default = 1 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'The default category cannot be deleted. Set another category as default first.';
                END IF;
            END
        ");
    }

    // ---------------
    // Revert: restore the slug-based triggers and the DEFAULT 17
    // ---------------
    public function down(): void
    {
        $this->dropTriggers();

        DB::unprepared("
            CREATE TRIGGER trg_su_products_default_category_insert BEFORE INSERT ON su_products FOR EACH ROW
            BEGIN
                IF NEW.category_id IS NULL THEN
                    SET NEW.category_id = (SELECT id FROM su_product_categories WHERE slug = 'uncategorized' LIMIT 1);
                END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_su_products_default_category_update BEFORE UPDATE ON su_products FOR EACH ROW
            BEGIN
                IF NEW.category_id IS NULL THEN
                    SET NEW.category_id = (SELECT id FROM su_product_categories WHERE slug = 'uncategorized' LIMIT 1);
                END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_su_product_categories_protect_default BEFORE DELETE ON su_product_categories FOR EACH ROW
            BEGIN
                IF OLD.slug = 'uncategorized' THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'The Uncategorized category cannot be deleted: it is the default fallback category for products.';
                END IF;
            END
        ");

        DB::statement('ALTER TABLE su_products ALTER COLUMN category_id SET DEFAULT 17');

        Schema::table('su_product_categories', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
    }

    // ---------------
    // Helper: Drop The Three Default-Category Triggers
    // ---------------
    private function dropTriggers(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_su_products_default_category_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_su_products_default_category_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_su_product_categories_protect_default');
    }
};