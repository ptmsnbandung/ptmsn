-- ==========================================================
-- SQL MIGRATION: PORTAL PELANGGAN & LAPORAN GANGGUAN (PT MSN)
-- Jalankan query ini di database `ptmsn` pada phpMyAdmin server hosting
-- Note: Data pelanggan diambil langsung secara real-time dari database `ims_v2`
-- ==========================================================

-- Buat Tabel `tickets` (Penyimpanan Laporan Gangguan Jaringan dari Website)
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(255) NOT NULL,
  `customer_id` varchar(100) NOT NULL COMMENT 'Nomor Internet / ID Pelanggan di database ims_v2',
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
  KEY `tickets_customer_id_index` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================
-- 2. UPDATE PAKET INTERNET TERBARU (RUMAHAN & BISNIS)
-- ==========================================================

-- 2.1 Tambahkan kolom category jika belum ada di tabel packages
-- (Jika muncul peringatan Duplicate column name 'category', abaikan dan lanjut ke langkah berikutnya)
ALTER TABLE `packages` ADD COLUMN `category` VARCHAR(255) NOT NULL DEFAULT 'broadband' AFTER `name`;

-- 2.2 Nonaktifkan paket lama
UPDATE `packages` 
SET `is_active` = 0 
WHERE `name` NOT IN (
    'PAKET BASIC', 'PAKET HEMAT', 'PAKET KELUARGA', 'PAKET PREMIUM', 
    'UMKM BASIC', 'UMKM PLUS', 'BISNIS PRO', 'BISNIS ENTERPRISE'
);

-- Hapus duplikasi jika nama paket sudah ada
DELETE FROM `packages` 
WHERE `name` IN (
    'PAKET BASIC', 'PAKET HEMAT', 'PAKET KELUARGA', 'PAKET PREMIUM', 
    'UMKM BASIC', 'UMKM PLUS', 'BISNIS PRO', 'BISNIS ENTERPRISE'
);

-- Masukkan Paket Rumahan & Paket Bisnis
INSERT INTO `packages` (`name`, `category`, `speed`, `price`, `period`, `description`, `features`, `is_popular`, `is_active`, `sort_order`, `created_at`, `updated_at`)
VALUES
-- PAKET RUMAHAN
('PAKET BASIC', 'broadband', '15 Mbps', 125000, 'bln', 'Solusi ideal untuk kebutuhan internet harian rumah tangga, browsing, dan 1 - 4 perangkat.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "Termasuk Modem ONT / WiFi", "Ideal untuk 1 - 4 Perangkat"]', 0, 1, 1, NOW(), NOW()),
('PAKET HEMAT', 'broadband', '25 Mbps', 165000, 'bln', 'Paket hemat untuk keluarga dengan streaming lancar untuk 3 - 6 perangkat.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "Termasuk Modem ONT / WiFi", "Ideal untuk 3 - 6 Perangkat"]', 0, 1, 2, NOW(), NOW()),
('PAKET KELUARGA', 'broadband', '30 Mbps', 199000, 'bln', 'Paket paling populer untuk seluruh anggota keluarga, gaming, dan video streaming HD.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "Termasuk Modem ONT / WiFi", "Ideal untuk 5 - 8 Perangkat"]', 1, 1, 3, NOW(), NOW()),
('PAKET PREMIUM', 'broadband', '50 Mbps', 249000, 'bln', 'Performa kecepatan tinggi tanpa kompromi untuk smart home dan multi-device 8 - 10 perangkat.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "Termasuk Modem ONT / WiFi", "Ideal untuk 8 - 10 Perangkat"]', 0, 1, 4, NOW(), NOW()),

-- PAKET BISNIS
('UMKM BASIC', 'bisnis', '50 Mbps', 399000, 'bln', 'Koneksi stabil rasio simetris untuk operasional kasir POS, toko, kafe, dan UMKM.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "Router Gigabit Dual-Band ONT", "Bantuan Prioritas 24/7"]', 0, 1, 5, NOW(), NOW()),
('UMKM PLUS', 'bisnis', '100 Mbps', 699000, 'bln', 'Paling populer untuk kantor berkembang, studio kreatif, dan bisnis dengan transfer data intensif.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "IP Static / Dedicated Ready", "SLA Bisnis Terjamin"]', 1, 1, 6, NOW(), NOW()),
('BISNIS PRO', 'bisnis', '200 Mbps', 999000, 'bln', 'Kecepatan super tinggi dan bandwidth konsisten untuk perusahaan dan multi-workstation.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "IP Dedicated Bisnis", "SLA Bisnis 99.5%"]', 0, 1, 7, NOW(), NOW()),
('BISNIS ENTERPRISE', 'bisnis', '300 Mbps', 1299000, 'bln', 'Kapasitas maksimal enterprise untuk korporat, instansi, dan kebutuhan cloud computing skala besar.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "IP Dedicated Bisnis", "Dedicated NOC & SLA 99.8%"]', 0, 1, 8, NOW(), NOW());

-- ==========================================================
-- 3. TABEL INVOICES (TAGIHAN & PEMBAYARAN MIDTRANS)
-- ==========================================================
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(255) NOT NULL,
  `customer_id` varchar(100) NOT NULL COMMENT 'Nomor Internet Pelanggan',
  `period` varchar(100) NOT NULL COMMENT 'Periode tagihan (contoh: September 2026)',
  `package_name` varchar(255) NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `tax_amount` int(10) unsigned NOT NULL DEFAULT 0,
  `total_amount` int(10) unsigned NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'unpaid' COMMENT 'unpaid, paid, pending, expired',
  `due_date` date NOT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `midtrans_order_id` varchar(255) DEFAULT NULL,
  `midtrans_snap_token` varchar(255) DEFAULT NULL,
  `midtrans_payload` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  KEY `invoices_customer_id_index` (`customer_id`),
  KEY `invoices_midtrans_order_id_index` (`midtrans_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


