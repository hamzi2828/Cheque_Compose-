-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: cheque_compose
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `cheque_compose`
--

/*!40000 DROP DATABASE IF EXISTS `cheque_compose`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `cheque_compose` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `cheque_compose`;

--
-- Table structure for table `bank_cheque_sequences`
--

DROP TABLE IF EXISTS `bank_cheque_sequences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_cheque_sequences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` bigint(20) unsigned NOT NULL,
  `start_number` bigint(20) unsigned NOT NULL,
  `end_number` bigint(20) unsigned NOT NULL,
  `next_number` bigint(20) unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_cheque_sequences_bank_id_foreign` (`bank_id`),
  CONSTRAINT `bank_cheque_sequences_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_cheque_sequences`
--

LOCK TABLES `bank_cheque_sequences` WRITE;
/*!40000 ALTER TABLE `bank_cheque_sequences` DISABLE KEYS */;
INSERT INTO `bank_cheque_sequences` VALUES (1,1,1,1000,1001,0,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(2,1,1001,2000,1009,1,'2026-08-14 03:00:00','2026-08-14 13:19:50'),(3,2,5001,5500,5005,1,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(4,3,2001,3000,2004,1,'2026-08-14 03:00:00','2026-08-14 03:00:00');
/*!40000 ALTER TABLE `bank_cheque_sequences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_client`
--

DROP TABLE IF EXISTS `bank_client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_client` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bank_client_bank_id_client_id_unique` (`bank_id`,`client_id`),
  KEY `bank_client_client_id_foreign` (`client_id`),
  CONSTRAINT `bank_client_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bank_client_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_client`
--

LOCK TABLES `bank_client` WRITE;
/*!40000 ALTER TABLE `bank_client` DISABLE KEYS */;
INSERT INTO `bank_client` VALUES (1,1,1,'2026-08-14 13:15:52','2026-08-14 13:15:52'),(2,1,2,'2026-08-14 13:15:52','2026-08-14 13:15:52'),(3,2,3,'2026-08-14 13:15:52','2026-08-14 13:15:52'),(4,2,4,'2026-08-14 13:15:52','2026-08-14 13:15:52'),(5,3,5,'2026-08-14 13:15:52','2026-08-14 13:15:52'),(6,3,6,NULL,NULL);
/*!40000 ALTER TABLE `bank_client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) NOT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `routing_number` varchar(255) NOT NULL,
  `bank_account_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banks`
--

LOCK TABLES `banks` WRITE;
/*!40000 ALTER TABLE `banks` DISABLE KEYS */;
INSERT INTO `banks` VALUES (1,'First National Bank','100 Main Street','Suite 400','Springfield','IL','62701','(217) 555-0134','071000505','001122334455','2026-08-14 03:00:00','2026-08-14 03:00:00'),(2,'Pacific Union Bank','2200 Harbor Blvd',NULL,'Long Beach','CA','90802','(562) 555-0188','122000661','445566778899','2026-08-14 03:00:00','2026-08-14 03:00:00'),(3,'Great Lakes Trust','45 Lakeshore Drive','Floor 2','Chicago','IL','60611','(312) 555-0102','271070801','556677889900','2026-08-14 03:00:00','2026-08-14 03:00:00');
/*!40000 ALTER TABLE `banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cheques`
--

DROP TABLE IF EXISTS `cheques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cheques` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `payee_id` bigint(20) unsigned DEFAULT NULL,
  `bank_id` bigint(20) unsigned NOT NULL,
  `bank_cheque_sequence_id` bigint(20) unsigned DEFAULT NULL,
  `cheque_number` bigint(20) unsigned NOT NULL,
  `cheque_date` date NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cheques_bank_id_cheque_number_unique` (`bank_id`,`cheque_number`),
  KEY `cheques_client_id_foreign` (`client_id`),
  KEY `cheques_bank_cheque_sequence_id_foreign` (`bank_cheque_sequence_id`),
  KEY `cheques_payee_id_foreign` (`payee_id`),
  CONSTRAINT `cheques_bank_cheque_sequence_id_foreign` FOREIGN KEY (`bank_cheque_sequence_id`) REFERENCES `bank_cheque_sequences` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cheques_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cheques_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cheques_payee_id_foreign` FOREIGN KEY (`payee_id`) REFERENCES `payees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cheques`
--

LOCK TABLES `cheques` WRITE;
/*!40000 ALTER TABLE `cheques` DISABLE KEYS */;
INSERT INTO `cheques` VALUES (1,1,1,1,2,1001,'2026-07-01','Freight services - June',1250.00,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(2,1,1,1,2,1002,'2026-07-08','Fuel surcharge reimbursement',342.75,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(3,2,2,1,2,1003,'2026-07-10','Ad campaign deposit',5000.00,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(4,2,2,1,2,1004,'2026-07-15',NULL,780.40,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(5,1,1,1,2,1005,'2026-07-21','Warehouse rent share',2150.00,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(6,2,2,1,2,1006,'2026-07-28','Video production',1499.99,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(7,1,1,1,2,1007,'2026-08-03','Freight services - July',1310.25,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(8,2,2,1,2,1008,'2026-08-10','Social media retainer',950.00,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(9,3,3,2,3,5001,'2026-07-05','Produce delivery',640.00,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(10,4,4,2,3,5002,'2026-07-12','Office chairs (x6)',1188.60,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(11,3,3,2,3,5003,'2026-07-26','Irrigation supplies',415.35,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(12,4,4,2,3,5004,'2026-08-09','Paper & toner restock',289.99,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(13,5,5,3,4,2001,'2026-07-18','August rent - Unit 4B',1850.00,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(14,5,5,3,4,2002,'2026-08-01','Maintenance fee',220.00,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(15,6,6,3,4,2003,'2026-08-12','Consulting - Q3 kickoff',3600.00,'2026-08-14 03:00:00','2026-08-14 03:00:00');
/*!40000 ALTER TABLE `cheques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Acme Logistics LLC','John Carter','780 Industrial Pkwy','Unit 12','Springfield','IL','62703','(217) 555-0177','accounts@acmelogistics.example.com','Net 30 payment terms. Prefers cheques mailed on Fridays.','2026-08-14 03:00:00','2026-08-14 03:00:00'),(2,'Brightside Media Group','Sara Nguyen','55 Sunset Ave',NULL,'Peoria','IL','61602','(309) 555-0142','billing@brightsidemedia.example.com',NULL,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(3,'Cedar Valley Farms','Miguel Alvarez','18 County Road 9',NULL,'Bakersfield','CA','93301','(661) 555-0165','office@cedarvalleyfarms.example.com','Seasonal supplier â€” most invoices arrive June through September.','2026-08-14 03:00:00','2026-08-14 03:00:00'),(4,'Delta Office Supplies','Priya Shah','900 Commerce St','Suite 210','Long Beach','CA','90810','(562) 555-0119','ar@deltaoffice.example.com',NULL,'2026-08-14 03:00:00','2026-08-14 03:00:00'),(5,'Evergreen Property Management','Dana Kowalski','310 Michigan Ave',NULL,'Chicago','IL','60604','(312) 555-0158','rent@evergreenpm.example.com','Monthly rent cheques due by the 1st.','2026-08-14 03:00:00','2026-08-14 03:00:00'),(6,'Fairview Consulting','Alex Osei','12 Beacon Court',NULL,'Naperville','IL','60540','(630) 555-0126','invoices@fairviewconsulting.example.com','New client â€” no bank details on file yet.','2026-08-14 03:00:00','2026-08-14 03:00:00');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_08_14_063530_create_banks_table',1),(5,'2026_08_14_063531_create_bank_cheque_sequences_table',1),(6,'2026_08_14_063531_create_clients_table',1),(7,'2026_08_14_063532_create_cheques_table',1),(8,'2026_08_14_100000_rename_fraction_to_bank_account_number_on_banks_table',2),(9,'2026_08_14_100001_create_payees_and_company_bank_relations',2),(10,'2026_08_14_110000_create_site_settings_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payees`
--

DROP TABLE IF EXISTS `payees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payees_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payees`
--

LOCK TABLES `payees` WRITE;
/*!40000 ALTER TABLE `payees` DISABLE KEYS */;
INSERT INTO `payees` VALUES (1,'Acme Logistics LLC','2026-08-14 13:15:52','2026-08-14 13:15:52'),(2,'Brightside Media Group','2026-08-14 13:15:52','2026-08-14 13:15:52'),(3,'Cedar Valley Farms Inc.','2026-08-14 13:15:52','2026-08-14 13:15:52'),(4,'Delta Office Supplies','2026-08-14 13:15:52','2026-08-14 13:15:52'),(5,'Evergreen Property Management','2026-08-14 13:15:52','2026-08-14 13:15:52'),(6,'Fairview Consulting Ltd.','2026-08-14 13:15:52','2026-08-14 13:15:52');
/*!40000 ALTER TABLE `payees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('6zm1uehIXwfe04q0E05kKtaFD3unGhAL6CniYPc4',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaHpRa0V2YndrVWk4UFhOUEQyNHUzM2dlbXZCNVJQdHYxS0plWThlSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zZXR0aW5ncyI7czo1OiJyb3V0ZSI7czoxNToic2V0dGluZ3MuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1786733255),('9jEErsRUYUMhr32uGZiUjrQjpIBJ6z3K1YqoEnK0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoia21Yb1dTeHQ4dWRXRnZkdmFaZ3VyTEdDQkNFaW5oY1FsaWZjd05SUyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9jbGllbnRzIjtzOjU6InJvdXRlIjtzOjEzOiJjbGllbnRzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786731460),('EV8x3DKj9Gh3CpqM2AbfUe6QTZYHL8wL0A8XneTi',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQU5XQnBFcVRYT1hUMzVRQXVqVnNScmhna2syS2htMG9ETllLRDVXdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9jaGVxdWVzL2NyZWF0ZSI7czo1OiJyb3V0ZSI7czoxNDoiY2hlcXVlcy5jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786731521),('EYUMTAm6ciUAUO1KK0miDzF5riNboqppztDrbHiH',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMzZjblYwR3dmdFIzNTJ0eVZ6N2h1NHNVaW1vTVFHNUNwUUw0QlpyTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9jbGllbnRzLzEvZWRpdCI7czo1OiJyb3V0ZSI7czoxMjoiY2xpZW50cy5lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786731461),('hhpIud6b43Y2635Rd3yvm19Yf344nKtEuovdy3SL',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYmM2YTRvdkFRTm9NcmtVRFBpazBxOTh6c0ZxT0taZlp0MjNoRVg2RSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9iYW5rcy9jcmVhdGUiO3M6NToicm91dGUiO3M6MTI6ImJhbmtzLmNyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786731463),('JX6qjSiW7m1q6Nxk4UbTylnkhoFQn34I0tON72VD',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMnU5dTdQTjFEM3dmUWs3TTVjRm43dUxOUmtRSzdnZkJCYzZRcmRudSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9jbGllbnRzL2NyZWF0ZSI7czo1OiJyb3V0ZSI7czoxNDoiY2xpZW50cy5jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786731461),('n5WGFsGRC3s6zZX0z0cwNTwzOa2ke1aOCRLrFOkI',1,'127.0.0.1','curl/8.18.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiekhyWHpNS2FYUUpybjAxbFJFeTl2Z3VSN0hqeDdvcUUyYUtFQTRzSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9zZXR0aW5ncyI7czo1OiJyb3V0ZSI7czoxNToic2V0dGluZ3MuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1786733113),('np8YDVCLIBm9ctTy9MQV0Wjhcpu7lVr9iXzyAFa2',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOXg4Ymk3Z1VnWFNQb0dScXBMQmhmMW1IeEtlYlNXVWV3OEdSVlJGNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9iYW5rcy8xL25leHQtY2hlcXVlLW51bWJlciI7czo1OiJyb3V0ZSI7czoyNDoiYmFua3MubmV4dC1jaGVxdWUtbnVtYmVyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786731463),('O5L74iPRM0oDX0OQC0g0MLjzTrLsOiMbPYssjmrL',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiME5uYlFWSGV4M0w3c0VaNmhTM0ZHSkRBUldyTG5RTHlqeTF6djl5QyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9wYXllZXMvMS9lZGl0IjtzOjU6InJvdXRlIjtzOjExOiJwYXllZXMuZWRpdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786731462),('OwlCayrMIIIzyP0z13XXbqUsHeaa8PG8jb21geys',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRWdaNndLaHhkNTU1UXc3Q25UZjBjVXlNZFdJTG96dmppRWVXeEtzdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9wYXllZXMvY3JlYXRlIjtzOjU6InJvdXRlIjtzOjEzOiJwYXllZXMuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786731462),('Qg4GK1LEyEpHOt1NLkmv594B6nrgr061xKncOIH0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTm1OUUdHNGZwWFNFV0JuVW1Qb3hGelZHVHR1V05sNkJRRkp2QzBOeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9jaGVxdWVzLzEvcGRmIjtzOjU6InJvdXRlIjtzOjExOiJjaGVxdWVzLnBkZiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786731464),('sZjZmpjsk6R7FNp8FC42120uXKFgWT0zfQTe56q5',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoid3RuYzRONHdaWVY3RjJyanNqZFRnZ2g2cktpQkR1dXhQbnoxS20xUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9iYW5rcyI7czo1OiJyb3V0ZSI7czoxMToiYmFua3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786731462),('ubngqamPhf2TaVNqhdIsTtWnclKmJrdvRQzq2bsV',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTnhYRFZBbVhoSXpCYTByQndpSmNSclY1VFdqZ2piUUZZNzdqWWpJUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9jbGllbnRzIjt9fQ==',1786732883),('upeYxw5sS6wfzQiqgMEOvHGxVoIn5mqxsyxOx4za',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSlRqbXpTbElTUFJ3RU5uSGdQbGVuRDdIVmNha2pQZGNxRU12dHJpOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9wYXllZXMiO3M6NToicm91dGUiO3M6MTI6InBheWVlcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786731461),('XNCrgIVSJeU4XdybeuNKN3qNBQIdcNjOxKJrvd2E',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTk14dDRVZVl6cm9Zc3o5V3VtcjVIcHBza1pmVFQ1bTVpOE4yS2Y4TiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9iYW5rcy8xL2VkaXQiO3M6NToicm91dGUiO3M6MTA6ImJhbmtzLmVkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786731463),('xtH0UTKReXpWAKwlk2H2mFjoUzbtmNb1CtWSwI0Y',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmhoUVpzNzlLdmdTUU16ZzZOODBRTmE2b3E0cHRoUVlUZFM1S21DcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9jaGVxdWVzIjtzOjU6InJvdXRlIjtzOjEzOiJjaGVxdWVzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786731452),('xWVC3LoNJAzmhJWaSTTyj47TjwCBzuRGtAwapL3U',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWh6UTFIc0k2cVpXREU1NEJiTzdzYUx5N3ZjRktDTGtydGNrZnZGSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9jaGVxdWVzL2NyZWF0ZSI7czo1OiJyb3V0ZSI7czoxNDoiY2hlcXVlcy5jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786731460),('YSNf4REjDlXU6QbllyPEWyLuC8XAoO2zuJrDO9Qb',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920','YTozOntzOjY6Il90b2tlbiI7czo0MDoibUxRQ0lBaW9vSkk3U2NaWEFXbUF0OFZraE83UlZCTUFaMWRjd3lDdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9jaGVxdWVzIjtzOjU6InJvdXRlIjtzOjEzOiJjaGVxdWVzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786731541),('yUBomXE2SlHahDV9nazL7uuDlpwwxFY91BSRE8Nl',NULL,'127.0.0.1','curl/8.18.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaHlId0xBdGZuNWthdjRRSERUWUIyS3FPWTZ0N3NzS0owblNoT0hVdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODE5OS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786733113);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin@example.com','2026-08-14 03:00:00','$2y$12$HHt8NmRGXdmiJQBLGRVoMul9D.lBs6x29pPueGOMLe2UDQpxsraDC','sVhSH04Rp98d0tFTx4IL5LJI9uGuffKXHTJ6dBtXCBhDd3BmosXqUvy10l9t','2026-08-14 03:00:00','2026-08-14 03:00:00'),(2,'Test User','test@example.com','2026-08-14 03:00:00','$2y$12$HHt8NmRGXdmiJQBLGRVoMul9D.lBs6x29pPueGOMLe2UDQpxsraDC',NULL,'2026-08-14 03:00:00','2026-08-14 03:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'cheque_compose'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-14 23:48:36
