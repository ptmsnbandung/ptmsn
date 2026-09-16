-- ==========================================================
-- SCRIPT UPDATE PAKET INTERNET TERBARU (RUMAHAN & BISNIS)
-- PT MEDIA SOLUSI NETWORK
-- Tanggal: 16 September 2026
-- ==========================================================

-- 1. Nonaktifkan paket lama (Bronze, Silver, Gold, Platinum, Crystal, dll)
UPDATE `packages` 
SET `is_active` = 0 
WHERE `name` NOT IN (
    'PAKET BASIC', 
    'PAKET HEMAT', 
    'PAKET KELUARGA', 
    'PAKET PREMIUM', 
    'UMKM BASIC', 
    'UMKM PLUS', 
    'BISNIS PRO', 
    'BISNIS ENTERPRISE'
);

-- 2. Tambah atau Perbarui Paket Rumahan & Paket Bisnis
INSERT INTO `packages` (`name`, `category`, `speed`, `price`, `period`, `description`, `features`, `is_popular`, `is_active`, `sort_order`, `created_at`, `updated_at`)
VALUES
-- PAKET RUMAHAN
('PAKET BASIC', 'broadband', '15 Mbps', 125000, 'bln', 'Solusi ideal untuk kebutuhan internet harian rumah tangga, browsing, dan 1 - 4 perangkat.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "Termasuk Modem ONT / WiFi", "Ideal untuk 1 - 4 Perangkat"]', 0, 1, 1, NOW(), NOW()),
('PAKET HEMAT', 'broadband', '25 Mbps', 165000, 'bln', 'Paket hemat untuk keluarga dengan streaming lancar untuk 3 - 6 perangkat.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "Termasuk Modem ONT / WiFi", "Ideal untuk 3 - 6 Perangkat"]', 0, 1, 2, NOW(), NOW()),
('PAKET KELUARGA', 'broadband', '30 Mbps', 199000, 'bln', 'Paket paling populer untuk seluruh anggota keluarga, gaming, dan video streaming HD.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "Termasuk Modem ONT / WiFi", "Ideal untuk 5 - 8 Perangkat"]', 1, 1, 3, NOW(), NOW()),
('PAKET PREMIUM', 'broadband', '50 Mbps', 249000, 'bln', 'Performa kecepatan tinggi tanpa kompromi untuk smart home dan multi-device 8 - 10 perangkat.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "Termasuk Modem ONT / WiFi", "Ideal untuk 8 - 10 Perangkat"]', 0, 1, 4, NOW(), NOW()),

-- PAKET BISNIS
('UMKM BASIC', 'soho', '50 Mbps', 399000, 'bln', 'Koneksi stabil rasio simetris untuk operasional kasir POS, toko, kafe, dan UMKM.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "Router Gigabit Dual-Band ONT", "Bantuan Prioritas 24/7"]', 0, 1, 5, NOW(), NOW()),
('UMKM PLUS', 'soho', '100 Mbps', 699000, 'bln', 'Paling populer untuk kantor berkembang, studio kreatif, dan bisnis dengan transfer data intensif.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "IP Static / Dedicated Ready", "SLA Bisnis Terjamin"]', 1, 1, 6, NOW(), NOW()),
('BISNIS PRO', 'soho', '200 Mbps', 999000, 'bln', 'Kecepatan super tinggi dan bandwidth konsisten untuk perusahaan dan multi-workstation.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "IP Dedicated Bisnis", "SLA Bisnis 99.5%"]', 0, 1, 7, NOW(), NOW()),
('BISNIS ENTERPRISE', 'soho', '300 Mbps', 1299000, 'bln', 'Kapasitas maksimal enterprise untuk korporat, instansi, dan kebutuhan cloud computing skala besar.', '["Unlimited Akses (Tanpa FUP)", "Fiber Optic 1:1 Simetris", "IP Dedicated Bisnis", "Dedicated NOC & SLA 99.8%"]', 0, 1, 8, NOW(), NOW())

ON DUPLICATE KEY UPDATE
    `category` = VALUES(`category`),
    `speed` = VALUES(`speed`),
    `price` = VALUES(`price`),
    `period` = VALUES(`period`),
    `description` = VALUES(`description`),
    `features` = VALUES(`features`),
    `is_popular` = VALUES(`is_popular`),
    `is_active` = VALUES(`is_active`),
    `sort_order` = VALUES(`sort_order`),
    `updated_at` = NOW();
