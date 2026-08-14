<?php
/**
 * Builds a ready-to-use SQLite database for Cheque Compose, with demo data.
 *
 * Usage:  php database/sql/build_sqlite.php [output-path]
 * Default output: cheque_compose.sqlite in the project root.
 *
 * The produced file can be dropped in as database/database.sqlite
 * (with DB_CONNECTION=sqlite in .env) or shared as a standalone demo DB.
 */

$output = $argv[1] ?? dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'cheque_compose.sqlite';

if (file_exists($output)) {
    unlink($output);
}

$pdo = new PDO('sqlite:' . $output);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = ON');

$now  = '2026-08-14 08:00:00';
// Password for both demo users is: password
$hash = '$2y$12$HHt8NmRGXdmiJQBLGRVoMul9D.lBs6x29pPueGOMLe2UDQpxsraDC';

$pdo->exec(<<<'SQL'
CREATE TABLE migrations (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    migration VARCHAR NOT NULL,
    batch INTEGER NOT NULL
);

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    email_verified_at DATETIME,
    password VARCHAR NOT NULL,
    remember_token VARCHAR,
    created_at DATETIME,
    updated_at DATETIME
);
CREATE UNIQUE INDEX users_email_unique ON users (email);

CREATE TABLE password_reset_tokens (
    email VARCHAR NOT NULL PRIMARY KEY,
    token VARCHAR NOT NULL,
    created_at DATETIME
);

CREATE TABLE sessions (
    id VARCHAR NOT NULL PRIMARY KEY,
    user_id INTEGER,
    ip_address VARCHAR,
    user_agent TEXT,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);
CREATE INDEX sessions_user_id_index ON sessions (user_id);
CREATE INDEX sessions_last_activity_index ON sessions (last_activity);

CREATE TABLE cache (
    "key" VARCHAR NOT NULL PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

CREATE TABLE cache_locks (
    "key" VARCHAR NOT NULL PRIMARY KEY,
    owner VARCHAR NOT NULL,
    expiration INTEGER NOT NULL
);

CREATE TABLE jobs (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    queue VARCHAR NOT NULL,
    payload TEXT NOT NULL,
    attempts INTEGER NOT NULL,
    reserved_at INTEGER,
    available_at INTEGER NOT NULL,
    created_at INTEGER NOT NULL
);
CREATE INDEX jobs_queue_index ON jobs (queue);

CREATE TABLE job_batches (
    id VARCHAR NOT NULL PRIMARY KEY,
    name VARCHAR NOT NULL,
    total_jobs INTEGER NOT NULL,
    pending_jobs INTEGER NOT NULL,
    failed_jobs INTEGER NOT NULL,
    failed_job_ids TEXT NOT NULL,
    options TEXT,
    cancelled_at INTEGER,
    created_at INTEGER NOT NULL,
    finished_at INTEGER
);

CREATE TABLE failed_jobs (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    uuid VARCHAR NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX failed_jobs_uuid_unique ON failed_jobs (uuid);

CREATE TABLE banks (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    bank_name VARCHAR NOT NULL,
    address_1 VARCHAR,
    address_2 VARCHAR,
    city VARCHAR,
    state VARCHAR,
    zip_code VARCHAR,
    phone VARCHAR,
    routing_number VARCHAR NOT NULL,
    fraction VARCHAR,
    created_at DATETIME,
    updated_at DATETIME
);

CREATE TABLE bank_cheque_sequences (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    bank_id INTEGER NOT NULL REFERENCES banks(id) ON DELETE CASCADE,
    start_number INTEGER NOT NULL,
    end_number INTEGER NOT NULL,
    next_number INTEGER NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
);

CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    company_name VARCHAR NOT NULL,
    contact_no VARCHAR,
    address_1 VARCHAR,
    address_2 VARCHAR,
    city VARCHAR,
    state VARCHAR,
    zip_code VARCHAR,
    phone VARCHAR,
    email VARCHAR,
    notes TEXT,
    payee_name VARCHAR NOT NULL,
    bank_id INTEGER REFERENCES banks(id) ON DELETE SET NULL,
    bank_account_number VARCHAR,
    created_at DATETIME,
    updated_at DATETIME
);

CREATE TABLE cheques (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    client_id INTEGER NOT NULL REFERENCES clients(id) ON DELETE CASCADE,
    bank_id INTEGER NOT NULL REFERENCES banks(id) ON DELETE CASCADE,
    bank_cheque_sequence_id INTEGER REFERENCES bank_cheque_sequences(id) ON DELETE SET NULL,
    cheque_number INTEGER NOT NULL,
    cheque_date DATE NOT NULL,
    memo VARCHAR,
    amount NUMERIC(12,2) NOT NULL,
    created_at DATETIME,
    updated_at DATETIME
);
CREATE UNIQUE INDEX cheques_bank_id_cheque_number_unique ON cheques (bank_id, cheque_number);
SQL);

$insert = function (string $table, array $rows) use ($pdo) {
    if (! $rows) {
        return;
    }
    $cols = array_keys($rows[0]);
    $sql  = sprintf(
        'INSERT INTO %s (%s) VALUES (%s)',
        $table,
        implode(', ', array_map(fn ($c) => '"' . $c . '"', $cols)),
        implode(', ', array_fill(0, count($cols), '?'))
    );
    $stmt = $pdo->prepare($sql);
    foreach ($rows as $row) {
        $stmt->execute(array_values($row));
    }
};

$insert('migrations', [
    ['migration' => '0001_01_01_000000_create_users_table', 'batch' => 1],
    ['migration' => '0001_01_01_000001_create_cache_table', 'batch' => 1],
    ['migration' => '0001_01_01_000002_create_jobs_table', 'batch' => 1],
    ['migration' => '2026_08_14_063530_create_banks_table', 'batch' => 1],
    ['migration' => '2026_08_14_063531_create_bank_cheque_sequences_table', 'batch' => 1],
    ['migration' => '2026_08_14_063531_create_clients_table', 'batch' => 1],
    ['migration' => '2026_08_14_063532_create_cheques_table', 'batch' => 1],
]);

$insert('users', [
    ['id' => 1, 'name' => 'Admin User', 'email' => 'admin@example.com', 'email_verified_at' => $now, 'password' => $hash, 'created_at' => $now, 'updated_at' => $now],
    ['id' => 2, 'name' => 'Test User', 'email' => 'test@example.com', 'email_verified_at' => $now, 'password' => $hash, 'created_at' => $now, 'updated_at' => $now],
]);

$insert('banks', [
    ['id' => 1, 'bank_name' => 'First National Bank', 'address_1' => '100 Main Street', 'address_2' => 'Suite 400', 'city' => 'Springfield', 'state' => 'IL', 'zip_code' => '62701', 'phone' => '(217) 555-0134', 'routing_number' => '071000505', 'fraction' => '70-505/711', 'created_at' => $now, 'updated_at' => $now],
    ['id' => 2, 'bank_name' => 'Pacific Union Bank', 'address_1' => '2200 Harbor Blvd', 'address_2' => null, 'city' => 'Long Beach', 'state' => 'CA', 'zip_code' => '90802', 'phone' => '(562) 555-0188', 'routing_number' => '122000661', 'fraction' => '16-66/1220', 'created_at' => $now, 'updated_at' => $now],
    ['id' => 3, 'bank_name' => 'Great Lakes Trust', 'address_1' => '45 Lakeshore Drive', 'address_2' => 'Floor 2', 'city' => 'Chicago', 'state' => 'IL', 'zip_code' => '60611', 'phone' => '(312) 555-0102', 'routing_number' => '271070801', 'fraction' => '2-78/2710', 'created_at' => $now, 'updated_at' => $now],
]);

$insert('bank_cheque_sequences', [
    ['id' => 1, 'bank_id' => 1, 'start_number' => 1, 'end_number' => 1000, 'next_number' => 1001, 'is_active' => 0, 'created_at' => $now, 'updated_at' => $now],
    ['id' => 2, 'bank_id' => 1, 'start_number' => 1001, 'end_number' => 2000, 'next_number' => 1009, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
    ['id' => 3, 'bank_id' => 2, 'start_number' => 5001, 'end_number' => 5500, 'next_number' => 5005, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
    ['id' => 4, 'bank_id' => 3, 'start_number' => 2001, 'end_number' => 3000, 'next_number' => 2004, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
]);

$insert('clients', [
    ['id' => 1, 'company_name' => 'Acme Logistics LLC', 'contact_no' => 'John Carter', 'address_1' => '780 Industrial Pkwy', 'address_2' => 'Unit 12', 'city' => 'Springfield', 'state' => 'IL', 'zip_code' => '62703', 'phone' => '(217) 555-0177', 'email' => 'accounts@acmelogistics.example.com', 'notes' => 'Net 30 payment terms. Prefers cheques mailed on Fridays.', 'payee_name' => 'Acme Logistics LLC', 'bank_id' => 1, 'bank_account_number' => '001122334455', 'created_at' => $now, 'updated_at' => $now],
    ['id' => 2, 'company_name' => 'Brightside Media Group', 'contact_no' => 'Sara Nguyen', 'address_1' => '55 Sunset Ave', 'address_2' => null, 'city' => 'Peoria', 'state' => 'IL', 'zip_code' => '61602', 'phone' => '(309) 555-0142', 'email' => 'billing@brightsidemedia.example.com', 'notes' => null, 'payee_name' => 'Brightside Media Group', 'bank_id' => 1, 'bank_account_number' => '001199887766', 'created_at' => $now, 'updated_at' => $now],
    ['id' => 3, 'company_name' => 'Cedar Valley Farms', 'contact_no' => 'Miguel Alvarez', 'address_1' => '18 County Road 9', 'address_2' => null, 'city' => 'Bakersfield', 'state' => 'CA', 'zip_code' => '93301', 'phone' => '(661) 555-0165', 'email' => 'office@cedarvalleyfarms.example.com', 'notes' => 'Seasonal supplier - most invoices arrive June through September.', 'payee_name' => 'Cedar Valley Farms Inc.', 'bank_id' => 2, 'bank_account_number' => '445566778899', 'created_at' => $now, 'updated_at' => $now],
    ['id' => 4, 'company_name' => 'Delta Office Supplies', 'contact_no' => 'Priya Shah', 'address_1' => '900 Commerce St', 'address_2' => 'Suite 210', 'city' => 'Long Beach', 'state' => 'CA', 'zip_code' => '90810', 'phone' => '(562) 555-0119', 'email' => 'ar@deltaoffice.example.com', 'notes' => null, 'payee_name' => 'Delta Office Supplies', 'bank_id' => 2, 'bank_account_number' => '990011223344', 'created_at' => $now, 'updated_at' => $now],
    ['id' => 5, 'company_name' => 'Evergreen Property Management', 'contact_no' => 'Dana Kowalski', 'address_1' => '310 Michigan Ave', 'address_2' => null, 'city' => 'Chicago', 'state' => 'IL', 'zip_code' => '60604', 'phone' => '(312) 555-0158', 'email' => 'rent@evergreenpm.example.com', 'notes' => 'Monthly rent cheques due by the 1st.', 'payee_name' => 'Evergreen Property Management', 'bank_id' => 3, 'bank_account_number' => '556677889900', 'created_at' => $now, 'updated_at' => $now],
    ['id' => 6, 'company_name' => 'Fairview Consulting', 'contact_no' => 'Alex Osei', 'address_1' => '12 Beacon Court', 'address_2' => null, 'city' => 'Naperville', 'state' => 'IL', 'zip_code' => '60540', 'phone' => '(630) 555-0126', 'email' => 'invoices@fairviewconsulting.example.com', 'notes' => 'New client - no bank details on file yet.', 'payee_name' => 'Fairview Consulting Ltd.', 'bank_id' => null, 'bank_account_number' => null, 'created_at' => $now, 'updated_at' => $now],
]);

$chequeRows = [
    [1,  1, 1, 2, 1001, '2026-07-01', 'Freight services - June',      1250.00],
    [2,  1, 1, 2, 1002, '2026-07-08', 'Fuel surcharge reimbursement',  342.75],
    [3,  2, 1, 2, 1003, '2026-07-10', 'Ad campaign deposit',          5000.00],
    [4,  2, 1, 2, 1004, '2026-07-15', null,                            780.40],
    [5,  1, 1, 2, 1005, '2026-07-21', 'Warehouse rent share',         2150.00],
    [6,  2, 1, 2, 1006, '2026-07-28', 'Video production',             1499.99],
    [7,  1, 1, 2, 1007, '2026-08-03', 'Freight services - July',      1310.25],
    [8,  2, 1, 2, 1008, '2026-08-10', 'Social media retainer',         950.00],
    [9,  3, 2, 3, 5001, '2026-07-05', 'Produce delivery',              640.00],
    [10, 4, 2, 3, 5002, '2026-07-12', 'Office chairs (x6)',           1188.60],
    [11, 3, 2, 3, 5003, '2026-07-26', 'Irrigation supplies',           415.35],
    [12, 4, 2, 3, 5004, '2026-08-09', 'Paper & toner restock',         289.99],
    [13, 5, 3, 4, 2001, '2026-07-18', 'August rent - Unit 4B',        1850.00],
    [14, 5, 3, 4, 2002, '2026-08-01', 'Maintenance fee',               220.00],
    [15, 6, 3, 4, 2003, '2026-08-12', 'Consulting - Q3 kickoff',      3600.00],
];

$insert('cheques', array_map(fn ($r) => [
    'id'                      => $r[0],
    'client_id'               => $r[1],
    'bank_id'                 => $r[2],
    'bank_cheque_sequence_id' => $r[3],
    'cheque_number'           => $r[4],
    'cheque_date'             => $r[5],
    'memo'                    => $r[6],
    'amount'                  => $r[7],
    'created_at'              => '2026-08-14 08:00:00',
    'updated_at'              => '2026-08-14 08:00:00',
], $chequeRows));

$counts = [];
foreach (['users', 'banks', 'bank_cheque_sequences', 'clients', 'cheques'] as $table) {
    $counts[] = $table . '=' . $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
}

echo "Created: $output\n";
echo 'Row counts: ' . implode(', ', $counts) . "\n";
