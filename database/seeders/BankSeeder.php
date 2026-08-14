<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\BankChequeSequence;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            [
                'bank_name'           => 'First National Bank',
                'address_1'           => '100 Main Street',
                'address_2'           => 'Suite 400',
                'city'                => 'Springfield',
                'state'               => 'IL',
                'zip_code'            => '62701',
                'phone'               => '(217) 555-0134',
                'routing_number'      => '071000505',
                'bank_account_number' => '001122334455',
                'sequences'           => [
                    ['start_number' => 1,    'end_number' => 1000, 'next_number' => 1001, 'is_active' => false],
                    ['start_number' => 1001, 'end_number' => 2000, 'next_number' => 1009, 'is_active' => true],
                ],
            ],
            [
                'bank_name'           => 'Pacific Union Bank',
                'address_1'           => '2200 Harbor Blvd',
                'address_2'           => null,
                'city'                => 'Long Beach',
                'state'               => 'CA',
                'zip_code'            => '90802',
                'phone'               => '(562) 555-0188',
                'routing_number'      => '122000661',
                'bank_account_number' => '445566778899',
                'sequences'           => [
                    ['start_number' => 5001, 'end_number' => 5500, 'next_number' => 5005, 'is_active' => true],
                ],
            ],
            [
                'bank_name'           => 'Great Lakes Trust',
                'address_1'           => '45 Lakeshore Drive',
                'address_2'           => 'Floor 2',
                'city'                => 'Chicago',
                'state'               => 'IL',
                'zip_code'            => '60611',
                'phone'               => '(312) 555-0102',
                'routing_number'      => '271070801',
                'bank_account_number' => '556677889900',
                'sequences'           => [
                    ['start_number' => 2001, 'end_number' => 3000, 'next_number' => 2004, 'is_active' => true],
                ],
            ],
        ];

        foreach ($banks as $data) {
            $sequences = $data['sequences'];
            unset($data['sequences']);

            $bank = Bank::firstOrCreate(['routing_number' => $data['routing_number']], $data);

            foreach ($sequences as $sequence) {
                BankChequeSequence::firstOrCreate(
                    ['bank_id' => $bank->id, 'start_number' => $sequence['start_number']],
                    $sequence
                );
            }
        }
    }
}
