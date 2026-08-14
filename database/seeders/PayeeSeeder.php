<?php

namespace Database\Seeders;

use App\Models\Payee;
use Illuminate\Database\Seeder;

class PayeeSeeder extends Seeder
{
    public function run(): void
    {
        $payees = [
            'Acme Logistics LLC',
            'Brightside Media Group',
            'Cedar Valley Farms Inc.',
            'Delta Office Supplies',
            'Evergreen Property Management',
            'Fairview Consulting Ltd.',
        ];

        foreach ($payees as $name) {
            Payee::firstOrCreate(['name' => $name]);
        }
    }
}
