-- =============================================================
-- Cheque Compose — Full database dump (MySQL / MariaDB)
-- Generated from the Laravel migrations on 2026-08-14.
--
-- Usage:
--   CREATE DATABASE cheque_compose CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
--   mysql -u root -p cheque_compose < cheque_compose_mysql.sql
--
-- Demo logins (password for both is: password)
--   admin@example.com / password
--   test@example.com  / password
-- =============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- -------------------------------------------------------------
-- Laravel framework tables
-- -------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Application tables
-- -------------------------------------------------------------

DROP TABLE IF EXISTS `banks`;
CREATE TABLE `banks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) NOT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `routing_number` varchar(255) NOT NULL,
  `fraction` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `bank_cheque_sequences`;
CREATE TABLE `bank_cheque_sequences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` bigint unsigned NOT NULL,
  `start_number` bigint unsigned NOT NULL,
  `end_number` bigint unsigned NOT NULL,
  `next_number` bigint unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_cheque_sequences_bank_id_foreign` (`bank_id`),
  CONSTRAINT `bank_cheque_sequences_bank_id_foreign`
    FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `notes` text,
  `payee_name` varchar(255) NOT NULL,
  `bank_id` bigint unsigned DEFAULT NULL,
  `bank_account_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clients_bank_id_foreign` (`bank_id`),
  CONSTRAINT `clients_bank_id_foreign`
    FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cheques`;
CREATE TABLE `cheques` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `bank_id` bigint unsigned NOT NULL,
  `bank_cheque_sequence_id` bigint unsigned DEFAULT NULL,
  `cheque_number` bigint unsigned NOT NULL,
  `cheque_date` date NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cheques_bank_id_cheque_number_unique` (`bank_id`,`cheque_number`),
  KEY `cheques_client_id_foreign` (`client_id`),
  KEY `cheques_bank_cheque_sequence_id_foreign` (`bank_cheque_sequence_id`),
  CONSTRAINT `cheques_client_id_foreign`
    FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cheques_bank_id_foreign`
    FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cheques_bank_cheque_sequence_id_foreign`
    FOREIGN KEY (`bank_cheque_sequence_id`) REFERENCES `bank_cheque_sequences` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Seed data
-- -------------------------------------------------------------

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2026_08_14_063530_create_banks_table', 1),
('2026_08_14_063531_create_bank_cheque_sequences_table', 1),
('2026_08_14_063531_create_clients_table', 1),
('2026_08_14_063532_create_cheques_table', 1);

-- Password for both users: "password"
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', '2026-08-14 08:00:00', '$2y$12$HHt8NmRGXdmiJQBLGRVoMul9D.lBs6x29pPueGOMLe2UDQpxsraDC', NULL, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(2, 'Test User', 'test@example.com', '2026-08-14 08:00:00', '$2y$12$HHt8NmRGXdmiJQBLGRVoMul9D.lBs6x29pPueGOMLe2UDQpxsraDC', NULL, '2026-08-14 08:00:00', '2026-08-14 08:00:00');

INSERT INTO `banks` (`id`, `bank_name`, `address_1`, `address_2`, `city`, `state`, `zip_code`, `phone`, `routing_number`, `fraction`, `created_at`, `updated_at`) VALUES
(1, 'First National Bank', '100 Main Street', 'Suite 400', 'Springfield', 'IL', '62701', '(217) 555-0134', '071000505', '70-505/711', '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(2, 'Pacific Union Bank', '2200 Harbor Blvd', NULL, 'Long Beach', 'CA', '90802', '(562) 555-0188', '122000661', '16-66/1220', '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(3, 'Great Lakes Trust', '45 Lakeshore Drive', 'Floor 2', 'Chicago', 'IL', '60611', '(312) 555-0102', '271070801', '2-78/2710', '2026-08-14 08:00:00', '2026-08-14 08:00:00');

INSERT INTO `bank_cheque_sequences` (`id`, `bank_id`, `start_number`, `end_number`, `next_number`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1000, 1001, 0, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(2, 1, 1001, 2000, 1009, 1, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(3, 2, 5001, 5500, 5005, 1, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(4, 3, 2001, 3000, 2004, 1, '2026-08-14 08:00:00', '2026-08-14 08:00:00');

INSERT INTO `clients` (`id`, `company_name`, `contact_no`, `address_1`, `address_2`, `city`, `state`, `zip_code`, `phone`, `email`, `notes`, `payee_name`, `bank_id`, `bank_account_number`, `created_at`, `updated_at`) VALUES
(1, 'Acme Logistics LLC', 'John Carter', '780 Industrial Pkwy', 'Unit 12', 'Springfield', 'IL', '62703', '(217) 555-0177', 'accounts@acmelogistics.example.com', 'Net 30 payment terms. Prefers cheques mailed on Fridays.', 'Acme Logistics LLC', 1, '001122334455', '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(2, 'Brightside Media Group', 'Sara Nguyen', '55 Sunset Ave', NULL, 'Peoria', 'IL', '61602', '(309) 555-0142', 'billing@brightsidemedia.example.com', NULL, 'Brightside Media Group', 1, '001199887766', '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(3, 'Cedar Valley Farms', 'Miguel Alvarez', '18 County Road 9', NULL, 'Bakersfield', 'CA', '93301', '(661) 555-0165', 'office@cedarvalleyfarms.example.com', 'Seasonal supplier — most invoices arrive June through September.', 'Cedar Valley Farms Inc.', 2, '445566778899', '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(4, 'Delta Office Supplies', 'Priya Shah', '900 Commerce St', 'Suite 210', 'Long Beach', 'CA', '90810', '(562) 555-0119', 'ar@deltaoffice.example.com', NULL, 'Delta Office Supplies', 2, '990011223344', '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(5, 'Evergreen Property Management', 'Dana Kowalski', '310 Michigan Ave', NULL, 'Chicago', 'IL', '60604', '(312) 555-0158', 'rent@evergreenpm.example.com', 'Monthly rent cheques due by the 1st.', 'Evergreen Property Management', 3, '556677889900', '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(6, 'Fairview Consulting', 'Alex Osei', '12 Beacon Court', NULL, 'Naperville', 'IL', '60540', '(630) 555-0126', 'invoices@fairviewconsulting.example.com', 'New client — no bank details on file yet.', 'Fairview Consulting Ltd.', NULL, NULL, '2026-08-14 08:00:00', '2026-08-14 08:00:00');

INSERT INTO `cheques` (`id`, `client_id`, `bank_id`, `bank_cheque_sequence_id`, `cheque_number`, `cheque_date`, `memo`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 1001, '2026-07-01', 'Freight services - June', 1250.00, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(2, 1, 1, 2, 1002, '2026-07-08', 'Fuel surcharge reimbursement', 342.75, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(3, 2, 1, 2, 1003, '2026-07-10', 'Ad campaign deposit', 5000.00, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(4, 2, 1, 2, 1004, '2026-07-15', NULL, 780.40, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(5, 1, 1, 2, 1005, '2026-07-21', 'Warehouse rent share', 2150.00, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(6, 2, 1, 2, 1006, '2026-07-28', 'Video production', 1499.99, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(7, 1, 1, 2, 1007, '2026-08-03', 'Freight services - July', 1310.25, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(8, 2, 1, 2, 1008, '2026-08-10', 'Social media retainer', 950.00, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(9, 3, 2, 3, 5001, '2026-07-05', 'Produce delivery', 640.00, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(10, 4, 2, 3, 5002, '2026-07-12', 'Office chairs (x6)', 1188.60, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(11, 3, 2, 3, 5003, '2026-07-26', 'Irrigation supplies', 415.35, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(12, 4, 2, 3, 5004, '2026-08-09', 'Paper & toner restock', 289.99, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(13, 5, 3, 4, 2001, '2026-07-18', 'August rent - Unit 4B', 1850.00, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(14, 5, 3, 4, 2002, '2026-08-01', 'Maintenance fee', 220.00, '2026-08-14 08:00:00', '2026-08-14 08:00:00'),
(15, 6, 3, 4, 2003, '2026-08-12', 'Consulting - Q3 kickoff', 3600.00, '2026-08-14 08:00:00', '2026-08-14 08:00:00');

SET FOREIGN_KEY_CHECKS = 1;
