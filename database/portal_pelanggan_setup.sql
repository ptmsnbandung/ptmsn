-- ==========================================================
-- SQL MIGRATION: PORTAL PELANGGAN & LAPORAN GANGGUAN (PT MSN)
-- Silakan jalankan script SQL ini di phpMyAdmin database server hosting Anda
-- ==========================================================

-- 1. Buat Tabel `customers`
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `package_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `billing_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due_date` int(11) NOT NULL DEFAULT 20,
  `billing_status` varchar(255) NOT NULL DEFAULT 'paid',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_customer_id_unique` (`customer_id`),
  UNIQUE KEY `customers_phone_unique` (`phone`),
  KEY `customers_package_id_foreign` (`package_id`),
  CONSTRAINT `customers_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Buat Tabel `tickets`
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `category` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `priority` varchar(255) NOT NULL DEFAULT 'medium',
  `technician_name` varchar(255) DEFAULT NULL,
  `resolution_notes` text DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tickets_ticket_number_unique` (`ticket_number`),
  KEY `tickets_customer_id_foreign` (`customer_id`),
  CONSTRAINT `tickets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Data Akun Demo Pelanggan (Password / PIN default: 123456)
INSERT INTO `customers` (`id`, `customer_id`, `name`, `phone`, `email`, `password`, `address`, `city`, `district`, `package_id`, `ip_address`, `status`, `billing_amount`, `due_date`, `billing_status`, `created_at`, `updated_at`) VALUES
(1, 'MSN-2024-001', 'Budi Santoso', '081234567890', 'budi.santoso@gmail.com', '$2y$12$4mUsqc6Dkh23wYy55zQ3OuxH.kH4Wp7j1eZ6H8vHw7l7R7iJ.v7eq', 'Jl. Kemang Pratama Raya No. 45, Blok B2', 'Bekasi', 'Bekasi Selatan', 3, '10.20.104.22', 'active', 250000.00, 20, 'paid', NOW(), NOW()),
(2, 'MSN-2024-002', 'Siti Rahmawati', '085712345678', 'siti.rahma@yahoo.com', '$2y$12$4mUsqc6Dkh23wYy55zQ3OuxH.kH4Wp7j1eZ6H8vHw7l7R7iJ.v7eq', 'Perum Grand Wisata Cluster Festive Garden Blok AA 12', 'Bekasi', 'Tambun Selatan', 4, '10.20.108.77', 'active', 300000.00, 15, 'paid', NOW(), NOW()),
(3, 'MSN-2024-003', 'Ahmad Fauzi', '087812345678', 'ahmad.fauzi@outlook.com', '$2y$12$4mUsqc6Dkh23wYy55zQ3OuxH.kH4Wp7j1eZ6H8vHw7l7R7iJ.v7eq', 'Jl. Ir. H. Juanda No. 88, Pamoyanan', 'Cianjur', 'Cianjur', 2, '10.30.50.12', 'active', 225000.00, 25, 'unpaid', NOW(), NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- 4. Data Tiket Sampel
INSERT INTO `tickets` (`id`, `ticket_number`, `customer_id`, `category`, `subject`, `description`, `photo_path`, `status`, `priority`, `technician_name`, `resolution_notes`, `resolved_at`, `created_at`, `updated_at`) VALUES
(1, 'TKT-20260915-001', 1, 'los_merah', 'Lampu Indikator LOS Berkedip Merah', 'Tiba-tiba koneksi internet terputus sekitar pukul 08:30 WIB. Lampu PON padam dan indikator LOS menyala merah berkedip. Sudah coba restart adaptor ONT tetap sama.', NULL, 'in_progress', 'high', 'Rian Pratama (Teknisi Field FO)', 'Tim teknisi telah melakukan pengecekan ODP terdekat. Ditemukan redaman tinggi pada konektor dropcore. Tim saat ini sedang melakukan re-splicing di lokasi.', NULL, DATE_SUB(NOW(), INTERVAL 3 HOUR), NOW()),
(2, 'TKT-20260820-002', 1, 'koneksi_lambat', 'Penurunan Kecepatan Internet di Malam Hari', 'Kecepatan internet terasa menurun saat malam hari sekitar jam 20:00 - 22:00 saat streaming Netflix.', NULL, 'resolved', 'medium', 'Fajar Sidik (NOC PT MSN)', 'Telah dilakukan optimalisasi routing BGP dan reset channel frekuensi WiFi 5GHz pada modem ONT. Pengujian speedtest kembali normal 25.4 Mbps simetris.', DATE_SUB(NOW(), INTERVAL 25 DAY), DATE_SUB(NOW(), INTERVAL 26 DAY), NOW()),
(3, 'TKT-20260916-003', 3, 'internet_mati', 'Internet Mati Total Pasca Hujan Lebat', 'Setelah hujan deras semalam, koneksi wifi tidak bisa browsing. Mohon bantuan pengecekan jaringan di area Pamoyanan.', NULL, 'open', 'urgent', NULL, NULL, NULL, DATE_SUB(NOW(), INTERVAL 45 MINUTE), NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();
