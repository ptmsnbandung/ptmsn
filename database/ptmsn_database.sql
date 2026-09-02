-- ========================================================
-- Database Export: PT Media Solusi Network (MySQL/MariaDB)
-- Created for Direct Import via phpMyAdmin / cPanel
-- ========================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Table: users
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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

-- Table: packages
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `speed` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `period` varchar(255) NOT NULL DEFAULT 'bln',
  `description` text DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: services
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'solar:bolt-circle-bold',
  `description` text NOT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: portfolios
DROP TABLE IF EXISTS `portfolios`;
CREATE TABLE `portfolios` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: clients
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: coverage_areas
DROP TABLE IF EXISTS `coverage_areas`;
CREATE TABLE `coverage_areas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `city` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `village` varchar(255) NOT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `status` enum('covered','in_progress','pending') NOT NULL DEFAULT 'covered',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: contact_messages
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','replied') NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: site_settings
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `label` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES ('0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2026_09_01_060648_create_packages_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2026_09_01_060649_create_portfolios_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2026_09_01_060649_create_services_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2026_09_01_060650_create_clients_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2026_09_01_060651_create_contact_messages_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2026_09_01_060652_create_coverage_areas_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2026_09_02_000001_create_site_settings_table', 2);

-- Data: users
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (1, 'Administrator PT MSN', 'admin@ptmsn.co.id', NULL, '$2y$12$NYv1SlE9AhTXzdpS4ojKbe5WjBBL45C5NJruHDmhFmXxHHJcaRPQq', NULL, '2026-09-01 14:02:52', '2026-09-02 03:37:04');

-- Data: packages
INSERT INTO `packages` (`id`, `name`, `speed`, `price`, `period`, `description`, `features`, `is_popular`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (1, 'BRONZE', '15 Mbps', 200000, 'bln', 'Solusi ideal untuk kebutuhan internet harian rumah tangga, browsing, dan media sosial.', '["Unlimited Akses (Tanpa FUP)","IP Private Dedicated","Fast Network Fiber Optic","Termasuk Modem ONT \\/ WiFi"]', 0, 1, 1, '2026-09-01 06:09:48', '2026-09-01 14:02:52');
INSERT INTO `packages` (`id`, `name`, `speed`, `price`, `period`, `description`, `features`, `is_popular`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (2, 'SILVER', '20 Mbps', 225000, 'bln', 'Paket terfavorit untuk keluarga aktif dengan streaming HD tanpa buffering dan video conference lancar.', '["Unlimited Akses (Tanpa FUP)","IP Private Dedicated","Fast Network Fiber Optic","Termasuk Modem ONT \\/ WiFi"]', 0, 1, 2, '2026-09-01 06:09:48', '2026-09-01 14:02:52');
INSERT INTO `packages` (`id`, `name`, `speed`, `price`, `period`, `description`, `features`, `is_popular`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (3, 'GOLD', '25 Mbps', 250000, 'bln', 'Koneksi prima untuk smart home, low-latency online gaming, serta kebutuhan download file besar.', '["Unlimited Akses (Tanpa FUP)","IP Private Dedicated","Fast Network Fiber Optic","Termasuk Modem ONT \\/ WiFi"]', 1, 1, 3, '2026-09-01 06:09:48', '2026-09-01 14:02:52');
INSERT INTO `packages` (`id`, `name`, `speed`, `price`, `period`, `description`, `features`, `is_popular`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (4, 'PLATINUM', '30 Mbps', 300000, 'bln', 'Performa tertinggi untuk kebutuhan bisnis SOHO, multi-user berkecepatan tinggi tanpa kompromi.', '["Unlimited Akses (Tanpa FUP)","IP Private Dedicated","Fast Network Fiber Optic","Termasuk Modem ONT \\/ WiFi"]', 0, 1, 4, '2026-09-01 06:09:48', '2026-09-01 14:02:52');

-- Data: services
INSERT INTO `services` (`id`, `title`, `slug`, `description`, `icon`, `features`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (1, 'Internet', 'internet', 'Layanan koneksi internet berkecepatan tinggi dengan kestabilan optimal untuk kebutuhan bisnis, perkantoran, dan perumahan.', 'solar:bolt-circle-bold', '["Internet Dedicated Service","Internet Broadband dan SOHO Access","Last Mile Solution","Collocation Service"]', 1, 1, '2026-09-01 06:09:48', '2026-09-01 14:04:20');
INSERT INTO `services` (`id`, `title`, `slug`, `description`, `icon`, `features`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (2, 'Software Development', 'software-development', 'Rekayasa piranti lunak enterprise, pengembangan backend sistem terintegrasi, dan pemeliharaan aplikasi berbasis web.', 'solar:code-square-bold', '["Backend Web Development","Maintance Web Base Software"]', 1, 2, '2026-09-01 06:09:48', '2026-09-01 14:04:20');
INSERT INTO `services` (`id`, `title`, `slug`, `description`, `icon`, `features`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (3, 'IT Solution', 'it-solution', 'Solusi infrastruktur teknologi komprehensif mulai dari telekonferensi berkualitas, optimalisasi jaringan QoS, hingga managed services.', 'solar:server-square-bold', '["Video Teleconference","QOS Networking","Network Managed Service"]', 1, 3, '2026-09-01 06:09:48', '2026-09-01 14:04:20');

-- Data: portfolios
INSERT INTO `portfolios` (`id`, `title`, `category`, `description`, `image`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (1, 'SINOPEL', 'Sistem Informasi Pemerintahan', 'Sistem Informasi Operasional dan Pelayanan Terpadu untuk percepatan birokrasi dan transparansi publik.', 'images/portfolio/sinopel.png', '#', 1, 1, '2026-09-01 06:09:48', '2026-09-01 06:09:48');
INSERT INTO `portfolios` (`id`, `title`, `category`, `description`, `image`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (2, 'Portal Komunikasi & Enterprise Mail', 'Infrastruktur Komunikasi', 'Arsitektur komunikasi internal dan server surat elektronik aman dengan enkripsi tingkat korporasi.', 'images/portfolio/mail-portal.png', '#', 1, 2, '2026-09-01 06:09:48', '2026-09-01 06:09:48');
INSERT INTO `portfolios` (`id`, `title`, `category`, `description`, `image`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (3, 'SENARAI (Arsip Laporan Kegiatan)', 'Manajemen Dokumen & Arsip', 'Platform digital pengelolaan arsip kegiatan terstruktur dengan pencarian cerdas dan audit trail.', 'images/portfolio/senarai.png', '#', 1, 3, '2026-09-01 06:09:48', '2026-09-01 06:09:48');
INSERT INTO `portfolios` (`id`, `title`, `category`, `description`, `image`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (4, 'Walanja', 'Digital Commerce & Marketplace', 'Solusi platform marketplace digital modern untuk mendorong pertumbuhan perdagangan lokal.', 'images/portfolio/walanja.png', '#', 1, 4, '2026-09-01 06:09:48', '2026-09-01 06:09:48');

-- Data: clients
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (1, 'Komisi Pemilihan Umum (KPU)', 'images/clients/kpu.png', NULL, 1, 1, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (2, 'PLN (Persero)', 'images/clients/pln.png', NULL, 1, 2, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (3, 'Pemerintah Kota Bandung', 'images/clients/bandung-2.png', NULL, 1, 3, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (4, 'Diskominfo Kota Bandung', 'images/clients/bandung.png', NULL, 1, 4, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (5, 'Telkom Indonesia', 'images/clients/telkom.png', NULL, 1, 5, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (6, 'Indosat Ooredoo Hutchison', 'images/clients/indosat.png', NULL, 1, 6, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (7, 'K-NET', 'images/clients/k-net.png', NULL, 1, 7, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (8, 'Pupuk Kujang Cikampek', 'images/clients/pupuk-kujang.png', NULL, 1, 8, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (9, 'Citra Maharlika Lintas Jawa (CMLJ)', 'images/clients/cmlj.png', NULL, 1, 9, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (10, 'PZ Cussons', 'images/clients/pz-cussons.png', NULL, 1, 10, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (11, 'HYD-ant', 'images/clients/hydant.png', NULL, 1, 11, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (12, 'Jasa Boga Global (JBG)', 'images/clients/jbg.png', NULL, 1, 12, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (13, 'Centrin Online', 'images/clients/centrin.png', NULL, 1, 13, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (14, 'CGG (CGS Ideas Connected)', 'images/clients/cgg.png', NULL, 1, 14, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (15, 'Lejel Shopping', 'images/clients/lejel.png', NULL, 1, 15, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (16, 'Jabartel', 'images/clients/jabartel.png', NULL, 1, 16, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (17, 'Skyline Network', 'images/clients/skyline.png', NULL, 1, 17, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (18, 'Moratelindo', 'images/clients/moratelindo.png', NULL, 1, 18, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (19, 'FiberStar', 'images/clients/fiberstar.png', NULL, 1, 19, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (20, 'Tristek Media Kreasindo', 'images/clients/tristek.png', NULL, 1, 20, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (21, 'Matrix NAP Info', 'images/clients/matrix.png', NULL, 1, 21, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (22, 'Balai Bahasa Provinsi Jawa Barat', 'images/clients/bbjb.png', NULL, 1, 22, '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `clients` (`id`, `name`, `logo`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES (23, 'LAPAN / BRIN', 'images/clients/lapan.png', NULL, 1, 23, '2026-09-02 03:37:04', '2026-09-02 03:37:04');

-- Data: coverage_areas
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (1, 'Bekasi', 'Bekasi Barat', 'Kranji', '17135', 'covered', 'Jaringan Fiber Optic 100% Aktif', '2026-09-01 06:09:48', '2026-09-01 06:09:48');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (2, 'Bekasi', 'Bekasi Timur', 'Aren Jaya', '17111', 'covered', 'Jaringan Fiber Optic 100% Aktif', '2026-09-01 06:09:48', '2026-09-01 06:09:48');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (3, 'Bekasi', 'Bekasi Selatan', 'Pekayon Jaya', '17148', 'covered', 'Jaringan Fiber Optic 100% Aktif', '2026-09-01 06:09:49', '2026-09-01 06:09:49');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (4, 'Bekasi', 'Cikarang Utara', 'Karangasih', '17530', 'covered', 'Kawasan Industri & Pemukiman Aktif', '2026-09-01 06:09:49', '2026-09-01 06:09:49');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (5, 'Cianjur', 'Cianjur', 'Pamoyanan', '43211', 'covered', 'Pusat Kota & Instansi', '2026-09-01 06:09:49', '2026-09-01 06:09:49');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (6, 'Cianjur', 'Karangtengah', 'Bojong', '43281', 'covered', 'Fiber Optic Ready', '2026-09-01 06:09:49', '2026-09-01 06:09:49');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (7, 'Bandung', 'Coblong', 'Dago', '40135', 'covered', 'Zona Broadband Cepat', '2026-09-01 06:09:49', '2026-09-01 06:09:49');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (8, 'Bandung', 'Sumur Bandung', 'Braga', '40111', 'covered', 'Pusat Bisnis & Perkantoran', '2026-09-01 06:09:49', '2026-09-01 06:09:49');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (9, 'Jakarta Timur', 'Cakung', 'Pulogebang', '13950', 'covered', 'Tersedia Dedicated & Broadband', '2026-09-01 06:09:49', '2026-09-01 06:09:49');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (10, 'Jakarta Selatan', 'Tebet', 'Tebet Barat', '12810', 'covered', 'Tersedia High Speed Connection', '2026-09-01 06:09:49', '2026-09-01 06:09:49');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (11, 'Depok', 'Pancoran Mas', 'Depok', '16431', 'covered', 'Fiber Optic Aktif', '2026-09-01 06:09:49', '2026-09-01 06:09:49');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (12, 'Bogor', 'Bogor Tengah', 'Pabaton', '16121', 'covered', 'Area Komersial & Pemukiman', '2026-09-01 06:09:49', '2026-09-01 06:09:49');
INSERT INTO `coverage_areas` (`id`, `city`, `district`, `village`, `postal_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES (13, 'Karawang', 'Karawang Barat', 'Nagasari', '41312', 'covered', 'Jaringan Fiber Optic Siap Pasang', '2026-09-01 06:09:49', '2026-09-01 06:09:49');

-- Data: site_settings
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (1, 'company_name', 'PT Media Solusi Network', 'company', 'Nama Perusahaan', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (2, 'company_tagline', 'Get Your IT Solution', 'company', 'Tagline Perusahaan', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (3, 'company_whatsapp', '6289696629955', 'company', 'Nomor WhatsApp Sales', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (4, 'company_phone', '(022) 7351 2289', 'company', 'Nomor Telepon Kantor', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (5, 'company_email', 'info@ptmsn.co.id', 'company', 'Email Resmi', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (6, 'company_address', 'Jl. Reog No. 18, Turangga, Kec. Lengkong, Kota Bandung, Jawa Barat 40264', 'company', 'Alamat Kantor Lengkap', 'textarea', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (7, 'company_hours', 'Senin - Jumat: 08.30 - 21.00 WIB', 'company', 'Jam Operasional Kantor', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (8, 'hero_badge', 'Infrastruktur Digital & Jaringan Fiber Optic • ISP Resmi', 'hero', 'Badge / Lencana Hero', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (9, 'hero_title_line1', 'GET YOUR IT', 'hero', 'Judul Hero Baris 1', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (10, 'hero_title_highlight', 'SOLUTION', 'hero', 'Judul Hero Highlight Biru', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (11, 'hero_description', 'Holding telekomunikasi resmi penyedia internet fiber optic enterprise, infrastruktur jaringan terpadu, dan rekayasa piranti lunak untuk sektor pemerintahan, BUMN, dan korporasi swasta.', 'hero', 'Deskripsi Hero', 'textarea', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (12, 'about_badge', 'Tentang PT Media Solusi Network', 'about', 'Badge Tentang Kami', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (13, 'about_title_regular', 'Mitra Terpercaya', 'about', 'Judul Tentang Kami', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (14, 'about_title_highlight', 'Solusi IT & Infrastruktur Digital', 'about', 'Judul Highlight Tentang Kami', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (15, 'about_description', 'PT Media Solusi Network adalah perusahaan holding penyedia solusi IT terpadu, developer aplikasi, dan infrastruktur internet yang telah dipercaya oleh pemerintah daerah, BUMN, serta berbagai sektor korporasi swasta.', 'about', 'Paragraf Profil Tentang Kami', 'textarea', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (16, 'why_badge', 'WHY MSN', 'why_us', 'Badge Why Us', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (17, 'why_title_line1', 'Membangun koneksi yang', 'why_us', 'Judul Why Us Baris 1', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (18, 'why_title_highlight', 'dapat diandalkan.', 'why_us', 'Judul Highlight Why Us', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (19, 'why_description', 'PT Media Solusi Network hadir dengan pengalaman di bidang konektivitas, infrastruktur jaringan, dan teknologi digital.', 'why_us', 'Deskripsi Why Us', 'textarea', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (20, 'cta_badge', 'Infrastruktur & Layanan Dedicated', 'cta', 'Badge CTA', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (21, 'cta_title', 'Mari Bangun Koneksi yang Lebih Baik.', 'cta', 'Judul Banner CTA', 'text', '2026-09-02 03:37:04', '2026-09-02 03:37:04');
INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `label`, `type`, `created_at`, `updated_at`) VALUES (22, 'cta_description', 'Konsultasikan kebutuhan internet dan infrastruktur jaringan Anda bersama tim spesialis kami untuk solusi konektivitas yang andal dan terukur.', 'cta', 'Deskripsi Banner CTA', 'textarea', '2026-09-02 03:37:04', '2026-09-02 03:37:04');

COMMIT;
SET FOREIGN_KEY_CHECKS=1;
