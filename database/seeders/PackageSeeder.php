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
            // --- BROADBAND PACKAGES ---
            [
                'name' => 'BRONZE',
                'category' => 'broadband',
                'speed' => '15 Mbps',
                'price' => 200000,
                'period' => 'bln',
                'description' => 'Solusi ideal untuk kebutuhan internet harian rumah tangga, browsing, dan media sosial.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'IP Private Dedicated',
                    'Fast Network Fiber Optic',
                    'Termasuk Modem ONT / WiFi',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'SILVER',
                'category' => 'broadband',
                'speed' => '20 Mbps',
                'price' => 225000,
                'period' => 'bln',
                'description' => 'Paket terfavorit untuk keluarga aktif dengan streaming HD tanpa buffering dan video conference lancar.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'IP Private Dedicated',
                    'Fast Network Fiber Optic',
                    'Termasuk Modem ONT / WiFi',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'GOLD',
                'category' => 'broadband',
                'speed' => '25 Mbps',
                'price' => 250000,
                'period' => 'bln',
                'description' => 'Koneksi prima untuk smart home, low-latency online gaming, serta kebutuhan download file besar.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'IP Private Dedicated',
                    'Fast Network Fiber Optic',
                    'Termasuk Modem ONT / WiFi',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'PLATINUM',
                'category' => 'broadband',
                'speed' => '30 Mbps',
                'price' => 300000,
                'period' => 'bln',
                'description' => 'Performa tertinggi untuk kebutuhan multi-user berkecepatan tinggi tanpa kompromi.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'IP Private Dedicated',
                    'Fast Network Fiber Optic',
                    'Termasuk Modem ONT / WiFi',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],

            // --- SOHO (SMALL OFFICE HOME OFFICE) PACKAGES ---
            [
                'name' => 'CRYSTAL',
                'category' => 'soho',
                'speed' => '10 Mbps',
                'price' => 499000,
                'period' => 'bln',
                'description' => 'Koneksi stabil rasio simetris untuk operasional bisnis small office dan home office dasar.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'IP Static / Dedicated SOHO',
                    'Rasio 1:1 Simetris Fiber Optic',
                    'Router Dual-Band Gigabit ONT',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'SAPHIRE',
                'category' => 'soho',
                'speed' => '20 Mbps',
                'price' => 599000,
                'period' => 'bln',
                'description' => 'Optimalisasi jaringan bisnis untuk cloud computing, VoIP, dan multi-workstation lancar.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'IP Static / Dedicated SOHO',
                    'Rasio 1:1 Simetris Fiber Optic',
                    'Router Dual-Band Gigabit ONT',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'EMERALD',
                'category' => 'soho',
                'speed' => '30 Mbps',
                'price' => 699000,
                'period' => 'bln',
                'description' => 'Paket rekomendasi SOHO terbaik untuk kolaborasi tim bisnis dengan transfer data besar.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'IP Static / Dedicated SOHO',
                    'Rasio 1:1 Simetris Fiber Optic',
                    'Router Dual-Band Gigabit ONT',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'RUBY',
                'category' => 'soho',
                'speed' => '40 Mbps',
                'price' => 799000,
                'period' => 'bln',
                'description' => 'Kecepatan prima untuk studio kreatif, agensi digital, dan operasional bisnis intensif data.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'IP Static / Dedicated SOHO',
                    'Rasio 1:1 Simetris Fiber Optic',
                    'Router Dual-Band Gigabit ONT',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'DIAMOND',
                'category' => 'soho',
                'speed' => '50 Mbps',
                'price' => 899000,
                'period' => 'bln',
                'description' => 'Kapasitas maksimal SOHO dengan throughput tinggi, latensi ultra-rendah, dan prioritas support.',
                'features' => [
                    'Unlimited Akses (Tanpa FUP)',
                    'IP Static / Dedicated SOHO',
                    'Rasio 1:1 Simetris Fiber Optic',
                    'Router Dual-Band Gigabit ONT',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(
                ['name' => $pkg['name']],
                $pkg
            );
        }
    }
}
