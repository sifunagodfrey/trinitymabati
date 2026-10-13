<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Adds a default "Uncategorized" product category and guarantees that
 * every product — existing or future — always has a category_id.
 *
 * Layers of protection:
 *   1. Backfill: any product currently NULL gets the default category.
 *   2. Pivot backfill: any product with zero rows in su_product_category
 *      (the many-to-many table) gets a row pointing at the default category.
 *   3. Column DEFAULT on su_products.category_id, so plain inserts that
 *      omit the column still get the default.
 *   4. BEFORE INSERT / BEFORE UPDATE triggers, so even code that explicitly
 *      passes category_id = NULL is coerced to the default.
 *   5. A BEFORE DELETE trigger on su_product_categories that blocks
 *      deletion of the 'uncategorized' row, since fk_products_category is
 *      ON DELETE SET NULL and would otherwise silently re-orphan products.
 */
return new class extends Migration
{
    private const DEFAULT_SLUG = 'uncategorized';

    public function up(): void
    {
        // 1. Create the default category if it doesn't already exist.
        $exists = DB::table('su_product_categories')
            ->where('slug', self::DEFAULT_SLUG)
            ->exists();

        if (! $exists) {
            DB::table('su_product_categories')->insert([
                'name'            => 'Uncategorized',
                'slug'            => self::DEFAULT_SLUG,
                'parent_id'       => null,
                'icon'            => null,
                'featured_image'  => null,
                'banner_image'    => null,
                'description'     => 'Default category automatically assigned to products that have not been placed in a specific category.',
                'created_at'      => now(),
            ]);
        }

        $defaultCategoryId = DB::table('su_product_categories')
            ->where('slug', self::DEFAULT_SLUG)
            ->value('id');

        // 2. Backfill existing products that have no category_id.
        DB::table('su_products')
            ->whereNull('category_id')
            ->update(['category_id' => $defaultCategoryId]);

        // 3. Backfill the many-to-many pivot table for any product that has
        //    zero rows there at all (covers apps that rely on the pivot
        //    table rather than / in addition to category_id).
        DB::statement("
            INSERT INTO su_product_category (product_id, category_id)
            SELECT p.id, {$defaultCategoryId}
            FROM su_products p
            LEFT JOIN su_product_category pc ON pc.product_id = p.id
            WHERE pc.product_id IS NULL
        ");

        // 4. Column default, so a plain INSERT that omits category_id
        //    entirely still gets the default value.
        DB::statement("ALTER TABLE su_products ALTER COLUMN category_id SET DEFAULT {$defaultCategoryId}");

        // 5. Triggers, so the default also applies when category_id is
        //    explicitly passed as NULL (the column default alone would not
        //    catch that case).
        DB::unprepared('DROP TRIGGER IF EXISTS trg_su_products_default_category_insert');
        DB::unprepared("
            CREATE TRIGGER trg_su_products_default_category_insert
            BEFORE INSERT ON su_products
            FOR EACH ROW
            BEGIN
                IF NEW.category_id IS NULL THEN
                    SET NEW.category_id = (
                        SELECT id FROM su_product_categories WHERE slug = 'uncategorized' LIMIT 1
                    );
                END IF;
            END
        ");

        DB::unprepared('DROP TRIGGER IF EXISTS trg_su_products_default_category_update');
        DB::unprepared("
            CREATE TRIGGER trg_su_products_default_category_update
            BEFORE UPDATE ON su_products
            FOR EACH ROW
            BEGIN
                IF NEW.category_id IS NULL THEN
                    SET NEW.category_id = (
                        SELECT id FROM su_product_categories WHERE slug = 'uncategorized' LIMIT 1
                    );
                END IF;
            END
        ");

        // 6. Protect the default category from deletion. fk_products_category
        //    is ON DELETE SET NULL, so deleting this row would silently
        //    re-orphan every product that relies on it.
        DB::unprepared('DROP TRIGGER IF EXISTS trg_su_product_categories_protect_default');
        DB::unprepared("
            CREATE TRIGGER trg_su_product_categories_protect_default
            BEFORE DELETE ON su_product_categories
            FOR EACH ROW
            BEGIN
                IF OLD.slug = 'uncategorized' THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'The Uncategorized category cannot be deleted: it is the default fallback category for products.';
                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_su_product_categories_protect_default');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_su_products_default_category_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_su_products_default_category_insert');

        DB::statement('ALTER TABLE su_products ALTER COLUMN category_id DROP DEFAULT');

        // Deliberately not reverted: deleting the "Uncategorized" category or
        // resetting products back to category_id = NULL would recreate the
        // exact problem this migration exists to solve. Remove manually if
        // you really need to roll that part back.
    }
};