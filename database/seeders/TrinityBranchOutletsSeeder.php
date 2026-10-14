<?php

namespace Database\Seeders;

use App\Models\Core\Setting;
use Illuminate\Database\Seeder;

class TrinityBranchOutletsSeeder extends Seeder
{
    public function run(): void
    {
        $outlets = [
            'branch_nairobi_name' => 'Nairobi Outlet',
            'branch_nairobi_address' => 'Enterprise Road, B. Binico Enterprises, Nairobi, Kenya.',
            'branch_nairobi_phone' => '+254 740 550 105',
            'branch_migori_name' => 'Migori Outlet',
            'branch_migori_address' => 'Kimaiga, next to Dolion Hotel',
            'branch_migori_phone' => '+254 796 593 842',
        ];

        foreach ($outlets as $key => $value) {
            Setting::put($key, $value, 'Trinity Mabati Factory outlet contact details');
        }
    }
}
