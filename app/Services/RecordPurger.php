<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// ---------------
// Permanently deletes orders, quotations and customers together with every
// record that belongs to them, so dummy/test data leaves no orphans behind.
//
// Dependent tables are discovered at runtime from the database itself
// (foreign keys + the user_id / order_id / quotation_id naming convention),
// so it keeps working as new tables are added.
// ---------------
class RecordPurger
{
    // Columns that mean "this row belongs to the parent" - those rows are deleted.
    // Any OTHER nullable reference (converted_order_id, prepared_by, referred_by...)
    // is only set to NULL so unrelated records survive.
    private const OWNER_COLUMNS = ['user_id', 'order_id', 'quotation_id'];

    private const CONVENTION = [
        'su_orders'     => 'order_id',
        'su_quotations' => 'quotation_id',
        'su_users'      => 'user_id',
    ];

    // Extra non-conventional columns that belong to a user.
    private const EXTRA = [
        'su_users' => [
            ['su_system_messages', 'sender_id'],
            ['su_system_messages', 'recipient_id'],
        ],
    ];

    private const MAX_DEPTH = 6;

    private array $referenceCache = [];
    private array $nullableCache  = [];

    // ---------------
    // Public API - each returns the number of parent rows removed
    // ---------------
    public function purgeOrders(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $ids = $this->clean($ids);

            // A converted quotation goes back to "accepted" so it can be converted again.
            if ($ids && Schema::hasColumn('su_quotations', 'converted_order_id')) {
                DB::table('su_quotations')->whereIn('converted_order_id', $ids)
                    ->update(['converted_order_id' => null, 'status' => 'accepted']);
            }

            return $this->purge('su_orders', $ids);
        });
    }

    public function purgeQuotations(array $ids): int
    {
        return DB::transaction(fn () => $this->purge('su_quotations', $this->clean($ids)));
    }

    // A customer takes their orders and quotations with them.
    public function purgeCustomers(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $ids = $this->clean($ids);
            if (! $ids) {
                return 0;
            }

            $this->purgeOrders(DB::table('su_orders')->whereIn('user_id', $ids)->pluck('id')->all());
            $this->purgeQuotations(DB::table('su_quotations')->whereIn('user_id', $ids)->pluck('id')->all());

            return $this->purge('su_users', $ids);
        });
    }

    // ---------------
    // Internals
    // ---------------
    private function clean(array $ids): array
    {
        return array_values(array_unique(array_filter(array_map('intval', $ids))));
    }

    private function purge(string $table, array $ids): int
    {
        if (! $ids) {
            return 0;
        }

        foreach (array_chunk($ids, 500) as $chunk) {
            $this->deleteChildren($table, $chunk, 0);
            DB::table($table)->whereIn('id', $chunk)->delete();
        }

        return count($ids);
    }

    private function deleteChildren(string $table, array $ids, int $depth): void
    {
        if ($depth > self::MAX_DEPTH) {
            return;
        }

        foreach ($this->references($table) as [$childTable, $column]) {
            // Unrelated nullable reference: detach instead of delete.
            if ($this->isNullable($childTable, $column) && ! in_array($column, self::OWNER_COLUMNS, true)) {
                DB::table($childTable)->whereIn($column, $ids)->update([$column => null]);
                continue;
            }

            if (Schema::hasColumn($childTable, 'id')) {
                $childIds = DB::table($childTable)->whereIn($column, $ids)->pluck('id')->all();
                foreach (array_chunk($childIds, 500) as $chunk) {
                    // Guard against a row that references itself.
                    if ($childTable === $table) {
                        $chunk = array_values(array_diff($chunk, $ids));
                    }
                    if (! $chunk) {
                        continue;
                    }
                    $this->deleteChildren($childTable, $chunk, $depth + 1);
                    DB::table($childTable)->whereIn('id', $chunk)->delete();
                }
            } else {
                DB::table($childTable)->whereIn($column, $ids)->delete();
            }
        }
    }

    // ---------------
    // [childTable, column] pairs that point at $table
    // ---------------
    private function references(string $table): array
    {
        if (isset($this->referenceCache[$table])) {
            return $this->referenceCache[$table];
        }

        $found = [];
        $add = function (string $t, string $c) use (&$found, $table) {
            if (Schema::hasTable($t) && Schema::hasColumn($t, $c)) {
                $found[$t . '.' . $c] = [$t, $c];
            }
        };

        // Real foreign keys
        $fks = DB::select(
            "SELECT k.TABLE_NAME AS t, k.COLUMN_NAME AS c
               FROM information_schema.KEY_COLUMN_USAGE k
               JOIN information_schema.TABLES tb
                 ON tb.TABLE_SCHEMA = k.TABLE_SCHEMA AND tb.TABLE_NAME = k.TABLE_NAME AND tb.TABLE_TYPE = 'BASE TABLE'
              WHERE k.TABLE_SCHEMA = DATABASE() AND k.REFERENCED_TABLE_NAME = ? AND k.REFERENCED_COLUMN_NAME = 'id'",
            [$table]
        );
        foreach ($fks as $fk) {
            $add($fk->t, $fk->c);
        }

        // Naming convention (covers tables created without foreign keys)
        if ($conv = self::CONVENTION[$table] ?? null) {
            $cols = DB::select(
                "SELECT c.TABLE_NAME AS t, c.COLUMN_NAME AS c
                   FROM information_schema.COLUMNS c
                   JOIN information_schema.TABLES tb
                     ON tb.TABLE_SCHEMA = c.TABLE_SCHEMA AND tb.TABLE_NAME = c.TABLE_NAME AND tb.TABLE_TYPE = 'BASE TABLE'
                  WHERE c.TABLE_SCHEMA = DATABASE() AND c.COLUMN_NAME = ? AND c.TABLE_NAME <> ?",
                [$conv, $table]
            );
            foreach ($cols as $col) {
                $add($col->t, $col->c);
            }
        }

        foreach (self::EXTRA[$table] ?? [] as [$t, $c]) {
            $add($t, $c);
        }

        return $this->referenceCache[$table] = array_values($found);
    }

    private function isNullable(string $table, string $column): bool
    {
        $key = $table . '.' . $column;

        return $this->nullableCache[$key] ??= (function () use ($table, $column) {
            $row = DB::selectOne(
                'SELECT IS_NULLABLE AS n FROM information_schema.COLUMNS
                  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?',
                [$table, $column]
            );

            return $row && $row->n === 'YES';
        })();
    }
}
