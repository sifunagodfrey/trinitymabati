<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $options = [
                'manual_ncba' => [
                    'bank_name' => 'NCBA Bank',
                    'paybill' => '880100',
                    'account_number' => '801204',
                    'account_name' => 'TRINITY MABATI',
                ],
                'manual_trinity' => [
                    'bank_name' => '',
                    'paybill' => '522533',
                    'account_number' => '7988779',
                    'account_name' => 'TRINITY MABATI',
                ],
                'manual_im_bank' => [
                    'bank_name' => 'I&M Bank',
                    'paybill' => '542542',
                    'account_number' => '03106687906151',
                    'account_name' => 'TRINITY MABATI',
                ],
            ];

            foreach ($options as $slug => $details) {
                $method = DB::table('su_payment_methods')
                    ->where('slug', $slug)->where('is_manual', true)
                    ->lockForUpdate()->first();
                if (!$method) {
                    throw new \RuntimeException('Manual payment option missing: ' . $slug . '. Run the manual-payment setup migration first.');
                }
                $existing = json_decode($method->config ?: '{}', true);
                $config = array_merge(is_array($existing) ? $existing : [], $details);
                DB::table('su_payment_methods')->where('id', $method->id)->update([
                    'config' => json_encode($config, JSON_THROW_ON_ERROR),
                    'is_active' => true,
                ]);
            }
        });
    }

    public function down(): void
    {
        // Disable these options on rollback without erasing payment details or transaction history.
        DB::table('su_payment_methods')
            ->where('is_manual', true)
            ->whereIn('slug', ['manual_ncba', 'manual_trinity', 'manual_im_bank'])
            ->update(['is_active' => false, 'is_default' => false]);
    }
};
