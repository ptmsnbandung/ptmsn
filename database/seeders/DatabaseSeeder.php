<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\CoverageArea;
use App\Models\Package;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@ptmsn.co.id'],
            [
                'name' => 'Administrator PT MSN',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Packages (Broadband FTTH & SOHO Small Office Home Office)
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
            Package::updateOrCreate(['name' => $pkg['name']], $pkg);
        }

        // 3. Services (01 Internet, 02 Software Development, 03 IT Solution)
        $services = [
            [
                'title' => 'Internet',
                'slug' => 'internet',
                'icon' => 'solar:bolt-circle-bold',
                'description' => 'Layanan koneksi internet berkecepatan tinggi dengan kestabilan optimal untuk kebutuhan bisnis, perkantoran, dan perumahan.',
                'features' => [
                    'Internet Dedicated Service',
                    'Internet Broadband dan SOHO Access',
                    'Last Mile Solution',
                    'Collocation Service',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Software Development',
                'slug' => 'software-development',
                'icon' => 'solar:code-square-bold',
                'description' => 'Rekayasa piranti lunak enterprise, pengembangan backend sistem terintegrasi, dan pemeliharaan aplikasi berbasis web.',
                'features' => [
                    'Backend Web Development',
                    'Maintance Web Base Software',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'IT Solution',
                'slug' => 'it-solution',
                'icon' => 'solar:server-square-bold',
                'description' => 'Solusi infrastruktur teknologi komprehensif mulai dari telekonferensi berkualitas, optimalisasi jaringan QoS, hingga managed services.',
                'features' => [
                    'Video Teleconference',
                    'QOS Networking',
                    'Network Managed Service',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($services as $srv) {
            Service::updateOrCreate(['slug' => $srv['slug']], $srv);
        }

        // 4. Portfolios
        $portfolios = [
            [
                'title' => 'SINOPEL',
                'category' => 'Sistem Informasi Pemerintahan',
                'description' => 'Sistem Informasi Operasional dan Pelayanan Terpadu untuk percepatan birokrasi dan transparansi publik.',
                'image' => 'images/portfolio/sinopel.png',
                'url' => '#',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Portal Komunikasi & Enterprise Mail',
                'category' => 'Infrastruktur Komunikasi',
                'description' => 'Arsitektur komunikasi internal dan server surat elektronik aman dengan enkripsi tingkat korporasi.',
                'image' => 'images/portfolio/mail-portal.png',
                'url' => '#',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'SENARAI (Arsip Laporan Kegiatan)',
                'category' => 'Manajemen Dokumen & Arsip',
                'description' => 'Platform digital pengelolaan arsip kegiatan terstruktur dengan pencarian cerdas dan audit trail.',
                'image' => 'images/portfolio/senarai.png',
                'url' => '#',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Walanja',
                'category' => 'Digital Commerce & Marketplace',
                'description' => 'Solusi platform marketplace digital modern untuk mendorong pertumbuhan perdagangan lokal.',
                'image' => 'images/portfolio/walanja.png',
                'url' => '#',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($portfolios as $port) {
            Portfolio::updateOrCreate(['title' => $port['title']], $port);
        }

        // 5. Clients (23 Official Client Logos Verified in public/images/clients/)
        Client::truncate();
        $clients = [
            ['name' => 'Komisi Pemilihan Umum (KPU)', 'logo' => 'images/clients/kpu.png', 'sort_order' => 1],
            ['name' => 'PLN (Persero)', 'logo' => 'images/clients/pln.png', 'sort_order' => 2],
            ['name' => 'Pemerintah Kota Bandung', 'logo' => 'images/clients/bandung-2.png', 'sort_order' => 3],
            ['name' => 'Diskominfo Kota Bandung', 'logo' => 'images/clients/bandung.png', 'sort_order' => 4],
            ['name' => 'Telkom Indonesia', 'logo' => 'images/clients/telkom.png', 'sort_order' => 5],
            ['name' => 'Indosat Ooredoo Hutchison', 'logo' => 'images/clients/indosat.png', 'sort_order' => 6],
            ['name' => 'K-NET', 'logo' => 'images/clients/k-net.png', 'sort_order' => 7],
            ['name' => 'Pupuk Kujang Cikampek', 'logo' => 'images/clients/pupuk-kujang.png', 'sort_order' => 8],
            ['name' => 'Citra Maharlika Lintas Jawa (CMLJ)', 'logo' => 'images/clients/cmlj.png', 'sort_order' => 9],
            ['name' => 'PZ Cussons', 'logo' => 'images/clients/pz-cussons.png', 'sort_order' => 10],
            ['name' => 'HYD-ant', 'logo' => 'images/clients/hydant.png', 'sort_order' => 11],
            ['name' => 'Jasa Boga Global (JBG)', 'logo' => 'images/clients/jbg.png', 'sort_order' => 12],
            ['name' => 'Centrin Online', 'logo' => 'images/clients/centrin.png', 'sort_order' => 13],
            ['name' => 'CGG (CGS Ideas Connected)', 'logo' => 'images/clients/cgg.png', 'sort_order' => 14],
            ['name' => 'Lejel Shopping', 'logo' => 'images/clients/lejel.png', 'sort_order' => 15],
            ['name' => 'Jabartel', 'logo' => 'images/clients/jabartel.png', 'sort_order' => 16],
            ['name' => 'Skyline Network', 'logo' => 'images/clients/skyline.png', 'sort_order' => 17],
            ['name' => 'Moratelindo', 'logo' => 'images/clients/moratelindo.png', 'sort_order' => 18],
            ['name' => 'FiberStar', 'logo' => 'images/clients/fiberstar.png', 'sort_order' => 19],
            ['name' => 'Tristek Media Kreasindo', 'logo' => 'images/clients/tristek.png', 'sort_order' => 20],
            ['name' => 'Matrix NAP Info', 'logo' => 'images/clients/matrix.png', 'sort_order' => 21],
            ['name' => 'Balai Bahasa Provinsi Jawa Barat', 'logo' => 'images/clients/bbjb.png', 'sort_order' => 22],
            ['name' => 'LAPAN / BRIN', 'logo' => 'images/clients/lapan.png', 'sort_order' => 23],
        ];

        foreach ($clients as $client) {
            Client::create(array_merge($client, ['is_active' => true]));
        }

        // 6. Coverage Areas
        $coverageAreas = [
            ['city' => 'Bekasi', 'district' => 'Bekasi Barat', 'village' => 'Kranji', 'postal_code' => '17135', 'status' => 'covered', 'notes' => 'Jaringan Fiber Optic 100% Aktif'],
            ['city' => 'Bekasi', 'district' => 'Bekasi Timur', 'village' => 'Aren Jaya', 'postal_code' => '17111', 'status' => 'covered', 'notes' => 'Jaringan Fiber Optic 100% Aktif'],
            ['city' => 'Bekasi', 'district' => 'Bekasi Selatan', 'village' => 'Pekayon Jaya', 'postal_code' => '17148', 'status' => 'covered', 'notes' => 'Jaringan Fiber Optic 100% Aktif'],
            ['city' => 'Bekasi', 'district' => 'Cikarang Utara', 'village' => 'Karangasih', 'postal_code' => '17530', 'status' => 'covered', 'notes' => 'Kawasan Industri & Pemukiman Aktif'],
            ['city' => 'Cianjur', 'district' => 'Cianjur', 'village' => 'Pamoyanan', 'postal_code' => '43211', 'status' => 'covered', 'notes' => 'Pusat Kota & Instansi'],
            ['city' => 'Cianjur', 'district' => 'Karangtengah', 'village' => 'Bojong', 'postal_code' => '43281', 'status' => 'covered', 'notes' => 'Fiber Optic Ready'],
            ['city' => 'Bandung', 'district' => 'Coblong', 'village' => 'Dago', 'postal_code' => '40135', 'status' => 'covered', 'notes' => 'Zona Broadband Cepat'],
            ['city' => 'Bandung', 'district' => 'Sumur Bandung', 'village' => 'Braga', 'postal_code' => '40111', 'status' => 'covered', 'notes' => 'Pusat Bisnis & Perkantoran'],
            ['city' => 'Jakarta Timur', 'district' => 'Cakung', 'village' => 'Pulogebang', 'postal_code' => '13950', 'status' => 'covered', 'notes' => 'Tersedia Dedicated & Broadband'],
            ['city' => 'Jakarta Selatan', 'district' => 'Tebet', 'village' => 'Tebet Barat', 'postal_code' => '12810', 'status' => 'covered', 'notes' => 'Tersedia High Speed Connection'],
            ['city' => 'Depok', 'district' => 'Pancoran Mas', 'village' => 'Depok', 'postal_code' => '16431', 'status' => 'covered', 'notes' => 'Fiber Optic Aktif'],
            ['city' => 'Bogor', 'district' => 'Bogor Tengah', 'village' => 'Pabaton', 'postal_code' => '16121', 'status' => 'covered', 'notes' => 'Area Komersial & Pemukiman'],
            ['city' => 'Karawang', 'district' => 'Karawang Barat', 'village' => 'Nagasari', 'postal_code' => '41312', 'status' => 'covered', 'notes' => 'Jaringan Fiber Optic Siap Pasang'],
        ];

        foreach ($coverageAreas as $cov) {
            CoverageArea::updateOrCreate(
                ['city' => $cov['city'], 'district' => $cov['district'], 'village' => $cov['village']],
                $cov
            );
        }

        // 7. Site Settings
        $this->call(SiteSettingSeeder::class);
    }
}
