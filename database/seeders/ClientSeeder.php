<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'company_name'        => 'Acme Logistics LLC',
                'contact_no'          => 'John Carter',
                'address_1'           => '780 Industrial Pkwy',
                'address_2'           => 'Unit 12',
                'city'                => 'Springfield',
                'state'               => 'IL',
                'zip_code'            => '62703',
                'phone'               => '(217) 555-0177',
                'email'               => 'accounts@acmelogistics.example.com',
                'notes'               => 'Net 30 payment terms. Prefers cheques mailed on Fridays.',
                'payee_name'          => 'Acme Logistics LLC',
                'bank_routing'        => '071000505',
                'bank_account_number' => '001122334455',
            ],
            [
                'company_name'        => 'Brightside Media Group',
                'contact_no'          => 'Sara Nguyen',
                'address_1'           => '55 Sunset Ave',
                'address_2'           => null,
                'city'                => 'Peoria',
                'state'               => 'IL',
                'zip_code'            => '61602',
                'phone'               => '(309) 555-0142',
                'email'               => 'billing@brightsidemedia.example.com',
                'notes'               => null,
                'payee_name'          => 'Brightside Media Group',
                'bank_routing'        => '071000505',
                'bank_account_number' => '001199887766',
            ],
            [
                'company_name'        => 'Cedar Valley Farms',
                'contact_no'          => 'Miguel Alvarez',
                'address_1'           => '18 County Road 9',
                'address_2'           => null,
                'city'                => 'Bakersfield',
                'state'               => 'CA',
                'zip_code'            => '93301',
                'phone'               => '(661) 555-0165',
                'email'               => 'office@cedarvalleyfarms.example.com',
                'notes'               => 'Seasonal supplier - most invoices arrive June through September.',
                'payee_name'          => 'Cedar Valley Farms Inc.',
                'bank_routing'        => '122000661',
                'bank_account_number' => '445566778899',
            ],
            [
                'company_name'        => 'Delta Office Supplies',
                'contact_no'          => 'Priya Shah',
                'address_1'           => '900 Commerce St',
                'address_2'           => 'Suite 210',
                'city'                => 'Long Beach',
                'state'               => 'CA',
                'zip_code'            => '90810',
                'phone'               => '(562) 555-0119',
                'email'               => 'ar@deltaoffice.example.com',
                'notes'               => null,
                'payee_name'          => 'Delta Office Supplies',
                'bank_routing'        => '122000661',
                'bank_account_number' => '990011223344',
            ],
            [
                'company_name'        => 'Evergreen Property Management',
                'contact_no'          => 'Dana Kowalski',
                'address_1'           => '310 Michigan Ave',
                'address_2'           => null,
                'city'                => 'Chicago',
                'state'               => 'IL',
                'zip_code'            => '60604',
                'phone'               => '(312) 555-0158',
                'email'               => 'rent@evergreenpm.example.com',
                'notes'               => 'Monthly rent cheques due by the 1st.',
                'payee_name'          => 'Evergreen Property Management',
                'bank_routing'        => '271070801',
                'bank_account_number' => '556677889900',
            ],
            [
                'company_name'        => 'Fairview Consulting',
                'contact_no'          => 'Alex Osei',
                'address_1'           => '12 Beacon Court',
                'address_2'           => null,
                'city'                => 'Naperville',
                'state'               => 'IL',
                'zip_code'            => '60540',
                'phone'               => '(630) 555-0126',
                'email'               => 'invoices@fairviewconsulting.example.com',
                'notes'               => 'New client - no bank details on file yet.',
                'payee_name'          => 'Fairview Consulting Ltd.',
                'bank_routing'        => null,
                'bank_account_number' => null,
            ],
        ];

        foreach ($clients as $data) {
            $routing = $data['bank_routing'];
            unset($data['bank_routing']);

            $data['bank_id'] = $routing
                ? Bank::where('routing_number', $routing)->value('id')
                : null;

            Client::firstOrCreate(['company_name' => $data['company_name']], $data);
        }
    }
}
