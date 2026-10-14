<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Step 1: delete every product and everything that points at products.
 * Quotations and orders are wiped too (decision confirmed by the client).
 *
 * Wallet and loyalty transaction rows are KEPT so balances and history stay
 * intact; only their order_id link is cleared.
 *
 * IRREVERSIBLE. Take a database backup before running.
 */
return new class extends Migration
{
    // Child tables first, parents last
    private array $tables = [
        // Quotations
        'su_quotation_items',
        'su_quotations',

        // Orders and everything hanging off them
        'su_order_loyalty',
        'su_order_status_history',
        'su_order_returns',
        'su_order_items',
        'su_invoices',
        'su_payments',
        'su_pending_mpesa',
        'su_orders',

        // Carts, wishlists, reviews, alerts, flash sales, media
        'su_cart_items',
        'su_abandoned_cart_logs',
        'su_abandoned_carts',
        'su_wishlists',
        'su_product_reviews',
        'su_flash_sales',
        'su_low_stock_alerts',

        // Product structure
        'su_product_variant_attributes',
        'su_product_variants',
        'su_product_attribute_values',
        'su_product_attributes',
        'su_product_category',
        'su_product_label',
        'su_products',
    ];

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        try {
            // Keep wallet and loyalty history, just drop the link to deleted orders
            foreach (['su_wallet_transactions', 'su_loyalty_transactions'] as $table) {
                if (Schema::hasTable($table) && Schema::hasColumn($table, 'order_id')) {
                    DB::table($table)->update(['order_id' => null]);
                }
            }

            // su_media may hold non-product files, so only remove product/variant media
            if (Schema::hasTable('su_media')) {
                DB::table('su_media')
                    ->whereNotNull('product_id')
                    ->orWhereNotNull('variant_id')
                    ->delete();
            }

            foreach ($this->tables as $table) {
                if (Schema::hasTable($table)) {
                    DB::table($table)->delete();
                }
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }
    }

    public function down(): void
    {
        // Deleted data cannot be restored. Use your database backup.
    }
};
