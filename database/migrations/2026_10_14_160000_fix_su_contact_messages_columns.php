<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $table = 'su_contact_messages';

    // ---------------
    // Make su_contact_messages match what ContactController::store() inserts:
    // name, email, subject, message, is_read, received_at
    // Safe to run on any database: only touches columns that are missing.
    // ---------------
    public function up(): void
    {
        if (! Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('email', 150);
                $table->string('subject', 255)->nullable();
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamp('received_at')->nullable()->useCurrent();
            });
            return;
        }

        // ---------------
        // "name": rename a legacy column if one exists, otherwise add it
        // ---------------
        if (! Schema::hasColumn($this->table, 'name')) {
            $legacy = collect(['full_name', 'sender_name', 'fullname', 'contact_name'])
                ->first(fn ($c) => Schema::hasColumn($this->table, $c));

            if ($legacy) {
                Schema::table($this->table, fn (Blueprint $t) => $t->renameColumn($legacy, 'name'));
            } else {
                Schema::table($this->table, function (Blueprint $t) {
                    $t->string('name', 100)->default('')->after('id');
                });
            }
        }

        // ---------------
        // Remaining columns the code reads or writes
        // ---------------
        Schema::table($this->table, function (Blueprint $t) {
            if (! Schema::hasColumn($this->table, 'email')) {
                $t->string('email', 150)->default('');
            }
            if (! Schema::hasColumn($this->table, 'subject')) {
                $t->string('subject', 255)->nullable();
            }
            if (! Schema::hasColumn($this->table, 'message')) {
                $t->text('message')->nullable();
            }
            if (! Schema::hasColumn($this->table, 'is_read')) {
                $t->boolean('is_read')->default(false);
            }
            if (! Schema::hasColumn($this->table, 'received_at')) {
                $t->timestamp('received_at')->nullable()->useCurrent();
            }
        });
    }

    // ---------------
    // Intentionally empty: never drop columns that may hold real messages
    // ---------------
    public function down(): void
    {
    }
};
