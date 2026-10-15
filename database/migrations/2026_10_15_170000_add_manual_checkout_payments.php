<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('su_payment_methods', function (Blueprint $table) {
            $table->boolean('is_manual')->default(false)->index();
        });
        Schema::table('su_payments', function (Blueprint $table) {
            $table->string('manual_reference', 100)->nullable()->unique();
            $table->string('proof_path')->nullable();
            $table->json('payment_details')->nullable();
            $table->text('review_notes')->nullable();
            $table->unsignedInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
        });
        foreach ([
            ['manual_ncba', 'NCBA Bank Paybill', 'NCBA Bank'],
            ['manual_trinity', 'Trinity Mabati Paybill', ''],
            ['manual_im_bank', 'I&M Bank Paybill', 'I&M Bank'],
        ] as [$slug, $name, $bank]) {
            DB::table('su_payment_methods')->insert([
                'name' => $name, 'slug' => $slug, 'is_manual' => true,
                'description' => 'Pay using the details shown and submit your transaction reference for manual verification.',
                'is_active' => false, 'is_default' => false,
                'config' => json_encode(['bank_name' => $bank, 'paybill' => '', 'account_number' => '', 'account_name' => '', 'instructions' => '']),
                'user_input_label' => 'Payment transaction reference',
                'user_input_description' => 'Enter the reference from your payment confirmation.',
                'created_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        if (DB::table('su_payments')->whereNotNull('manual_reference')->exists()) {
            throw new \RuntimeException('Manual payment records exist. Keep the migration to preserve their payment and review history.');
        }
        DB::table('su_payment_methods')->whereIn('slug', ['manual_ncba', 'manual_trinity', 'manual_im_bank'])->where('is_manual', true)->delete();
        Schema::table('su_payments', function (Blueprint $table) {
            $table->dropUnique(['manual_reference']);
            $table->dropColumn(['manual_reference', 'proof_path', 'payment_details', 'review_notes', 'reviewed_by', 'reviewed_at']);
        });
        Schema::table('su_payment_methods', function (Blueprint $table) {
            $table->dropIndex(['is_manual']);
            $table->dropColumn('is_manual');
        });
    }
};
