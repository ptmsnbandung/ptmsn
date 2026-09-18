<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            // --- PAKET RUMAHAN ---
            [
                'name' => 'PAKET BASIC',
                'category' => 'broadband',
                'speed' => '15 Mbps',
                'price' => 125000,
                'period' => 'bln',
                'description' => 'Solusi ideal untuk kebutuhan internet harian rumah tangga dan browsing lancar.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'Fast Network Fiber Optic',
                    'Termasuk Modem ONT / WiFi',
                    'Bantuan Teknis 24/7',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'PAKET HEMAT',
                'category' => 'broadband',
                'speed' => '25 Mbps',
                'price' => 165000,
                'period' => 'bln',
                'description' => 'Paket hemat untuk keluarga dengan streaming lancar dan stabil.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'Fast Network Fiber Optic',
                    'Termasuk Modem ONT / WiFi',
                    'Bantuan Teknis 24/7',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'PAKET KELUARGA',
                'category' => 'broadband',
                'speed' => '30 Mbps',
                'price' => 199000,
                'period' => 'bln',
                'description' => 'Paket paling populer untuk seluruh anggota keluarga, gaming, dan video streaming HD.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'Fast Network Fiber Optic',
                    'Termasuk Modem ONT / WiFi',
                    'Bantuan Prioritas 24/7',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'PAKET PREMIUM',
                'category' => 'broadband',
                'speed' => '50 Mbps',
                'price' => 249000,
                'period' => 'bln',
                'description' => 'Performa kecepatan tinggi tanpa kompromi untuk smart home dan internet super cepat.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'Fast Network Fiber Optic',
                    'Termasuk Modem ONT / WiFi',
                    'Bantuan Prioritas 24/7',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],

            // --- PAKET BISNIS ---
            [
                'name' => 'UMKM BASIC',
                'category' => 'bisnis',
                'speed' => '50 Mbps',
                'price' => 399000,
                'period' => 'bln',
                'description' => 'Koneksi stabil rasio simetris untuk operasional kasir POS, toko, kafe, dan UMKM.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'Fast Network Fiber Optic',
                    'Router Gigabit Dual-Band ONT',
                    'Bantuan Prioritas 24/7',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'UMKM PLUS',
                'category' => 'bisnis',
                'speed' => '100 Mbps',
                'price' => 699000,
                'period' => 'bln',
                'description' => 'Paling populer untuk kantor berkembang, studio kreatif, dan bisnis dengan transfer data intensif.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'Fast Network Fiber Optic',
                    'IP Static / Dedicated Ready',
                    'SLA Bisnis Terjamin',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'BISNIS PRO',
                'category' => 'bisnis',
                'speed' => '200 Mbps',
                'price' => 999000,
                'period' => 'bln',
                'description' => 'Kecepatan super tinggi dan bandwidth konsisten untuk perusahaan dan multi-workstation.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'Fast Network Fiber Optic',
                    'IP Dedicated Bisnis',
                    'SLA Bisnis 99.5%',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'BISNIS ENTERPRISE',
                'category' => 'bisnis',
                'speed' => '300 Mbps',
                'price' => 1299000,
                'period' => 'bln',
                'description' => 'Kapasitas maksimal enterprise untuk korporat, instansi, dan kebutuhan cloud computing skala besar.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'Fast Network Fiber Optic',
                    'IP Dedicated Bisnis',
                    'Dedicated NOC & SLA 99.8%',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        // Nonaktifkan paket lama jika ada
        Package::whereNotIn('name', array_column($packages, 'name'))->update(['is_active' => false]);

        foreach ($packages as $pkg) {
            Package::updateOrCreate(
                ['name' => $pkg['name']],
                $pkg
            );
        }
    }
}
