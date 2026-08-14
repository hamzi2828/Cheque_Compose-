<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Cheque;
use App\Models\Client;
use App\Models\Payee;
use Illuminate\Database\Seeder;

class ChequeSeeder extends Seeder
{
    public function run(): void
    {
        // The payee each demo company usually pays to.
        $payeeByCompany = [
            'Acme Logistics LLC'            => 'Acme Logistics LLC',
            'Brightside Media Group'        => 'Brightside Media Group',
            'Cedar Valley Farms'            => 'Cedar Valley Farms Inc.',
            'Delta Office Supplies'         => 'Delta Office Supplies',
            'Evergreen Property Management' => 'Evergreen Property Management',
            'Fairview Consulting'           => 'Fairview Consulting Ltd.',
        ];

        // [routing_number, company_name, cheque_number, date, memo, amount]
        $cheques = [
            ['071000505', 'Acme Logistics LLC',            1001, '2026-07-01', 'Freight services - June',        1250.00],
            ['071000505', 'Acme Logistics LLC',            1002, '2026-07-08', 'Fuel surcharge reimbursement',    342.75],
            ['071000505', 'Brightside Media Group',        1003, '2026-07-10', 'Ad campaign deposit',            5000.00],
            ['071000505', 'Brightside Media Group',        1004, '2026-07-15', null,                              780.40],
            ['071000505', 'Acme Logistics LLC',            1005, '2026-07-21', 'Warehouse rent share',           2150.00],
            ['071000505', 'Brightside Media Group',        1006, '2026-07-28', 'Video production',               1499.99],
            ['071000505', 'Acme Logistics LLC',            1007, '2026-08-03', 'Freight services - July',        1310.25],
            ['071000505', 'Brightside Media Group',        1008, '2026-08-10', 'Social media retainer',           950.00],
            ['122000661', 'Cedar Valley Farms',            5001, '2026-07-05', 'Produce delivery',                640.00],
            ['122000661', 'Delta Office Supplies',         5002, '2026-07-12', 'Office chairs (x6)',             1188.60],
            ['122000661', 'Cedar Valley Farms',            5003, '2026-07-26', 'Irrigation supplies',             415.35],
            ['122000661', 'Delta Office Supplies',         5004, '2026-08-09', 'Paper & toner restock',           289.99],
            ['271070801', 'Evergreen Property Management', 2001, '2026-07-18', 'August rent - Unit 4B',          1850.00],
            ['271070801', 'Evergreen Property Management', 2002, '2026-08-01', 'Maintenance fee',                 220.00],
            ['271070801', 'Fairview Consulting',           2003, '2026-08-12', 'Consulting - Q3 kickoff',        3600.00],
        ];

        foreach ($cheques as [$routing, $company, $number, $date, $memo, $amount]) {
            $bank   = Bank::where('routing_number', $routing)->first();
            $client = Client::where('company_name', $company)->first();
            $payee  = Payee::where('name', $payeeByCompany[$company] ?? null)->first();

            if (! $bank || ! $client) {
                continue;
            }

            $sequence = $bank->sequences()
                ->where('start_number', '<=', $number)
                ->where('end_number', '>=', $number)
                ->first();

            Cheque::firstOrCreate(
                ['bank_id' => $bank->id, 'cheque_number' => $number],
                [
                    'client_id'               => $client->id,
                    'payee_id'                => $payee?->id,
                    'bank_cheque_sequence_id' => $sequence?->id,
                    'cheque_date'             => $date,
                    'memo'                    => $memo,
                    'amount'                  => $amount,
                ]
            );
        }
    }
}
