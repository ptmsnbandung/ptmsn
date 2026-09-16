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
