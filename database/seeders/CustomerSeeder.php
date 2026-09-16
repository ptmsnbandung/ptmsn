<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Package;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goldPackage = Package::where('name', 'GOLD')->first() ?? Package::first();
        $silverPackage = Package::where('name', 'SILVER')->first() ?? Package::first();
        $platinumPackage = Package::where('name', 'PLATINUM')->first() ?? Package::first();

        // 1. Demo Customer 1 (Budi Santoso - Active with Tickets)
        $customer1 = Customer::updateOrCreate(
            ['phone' => '081234567890'],
            [
                'customer_id' => 'MSN-2024-001',
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'password' => Hash::make('123456'), // PIN: 123456
                'address' => 'Jl. Kemang Pratama Raya No. 45, Blok B2',
                'city' => 'Bekasi',
                'district' => 'Bekasi Selatan',
                'package_id' => $goldPackage?->id,
                'ip_address' => '10.20.104.22',
                'status' => 'active',
                'billing_amount' => $goldPackage?->price ?? 250000,
                'due_date' => 20,
                'billing_status' => 'paid',
            ]
        );

        // 2. Demo Customer 2 (Siti Rahmawati)
        $customer2 = Customer::updateOrCreate(
            ['phone' => '085712345678'],
            [
                'customer_id' => 'MSN-2024-002',
                'name' => 'Siti Rahmawati',
                'email' => 'siti.rahma@yahoo.com',
                'password' => Hash::make('123456'), // PIN: 123456
                'address' => 'Perum Grand Wisata Cluster Festive Garden Blok AA 12',
                'city' => 'Bekasi',
                'district' => 'Tambun Selatan',
                'package_id' => $platinumPackage?->id,
                'ip_address' => '10.20.108.77',
                'status' => 'active',
                'billing_amount' => $platinumPackage?->price ?? 300000,
                'due_date' => 15,
                'billing_status' => 'paid',
            ]
        );

        // 3. Demo Customer 3 (Ahmad Fauzi)
        $customer3 = Customer::updateOrCreate(
            ['phone' => '087812345678'],
            [
                'customer_id' => 'MSN-2024-003',
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@outlook.com',
                'password' => Hash::make('123456'),
                'address' => 'Jl. Ir. H. Juanda No. 88, Pamoyanan',
                'city' => 'Cianjur',
                'district' => 'Cianjur',
                'package_id' => $silverPackage?->id,
                'ip_address' => '10.30.50.12',
                'status' => 'active',
                'billing_amount' => $silverPackage?->price ?? 225000,
                'due_date' => 25,
                'billing_status' => 'unpaid',
            ]
        );

        // Sample Tickets for Customer 1
        Ticket::updateOrCreate(
            ['ticket_number' => 'TKT-20260915-001'],
            [
                'customer_id' => $customer1->id,
                'category' => 'los_merah',
                'subject' => 'Lampu Indikator LOS Berkedip Merah',
                'description' => 'Tiba-tiba koneksi internet terputus sekitar pukul 08:30 WIB. Lampu PON padam dan indikator LOS menyala merah berkedip. Sudah coba restart adaptor ONT tetap sama.',
                'status' => 'in_progress',
                'priority' => 'high',
                'technician_name' => 'Rian Pratama (Teknisi Field FO)',
                'resolution_notes' => 'Tim teknisi telah melakukan pengecekan ODP terdekat. Ditemukan redaman tinggi pada konektor dropcore. Tim saat ini sedang melakukan re-splicing di lokasi.',
                'created_at' => now()->subHours(3),
            ]
        );

        Ticket::updateOrCreate(
            ['ticket_number' => 'TKT-20260820-002'],
            [
                'customer_id' => $customer1->id,
                'category' => 'koneksi_lambat',
                'subject' => 'Penurunan Kecepatan Internet di Malam Hari',
                'description' => 'Kecepatan internet terasa menurun saat malam hari sekitar jam 20:00 - 22:00 saat streaming Netflix.',
                'status' => 'resolved',
                'priority' => 'medium',
                'technician_name' => 'Fajar Sidik (NOC PT MSN)',
                'resolution_notes' => 'Telah dilakukan optimalisasi routing BGP dan reset channel frekuensi WiFi 5GHz pada modem ONT. Pengujian speedtest kembali normal 25.4 Mbps simetris.',
                'resolved_at' => now()->subDays(25),
                'created_at' => now()->subDays(26),
            ]
        );

        // Sample Ticket for Customer 3
        Ticket::updateOrCreate(
            ['ticket_number' => 'TKT-20260916-003'],
            [
                'customer_id' => $customer3->id,
                'category' => 'internet_mati',
                'subject' => 'Internet Mati Total Pasca Hujan Lebat',
                'description' => 'Setelah hujan deras semalam, koneksi wifi tidak bisa browsing. Mohon bantuan pengecekan jaringan di area Pamoyanan.',
                'status' => 'open',
                'priority' => 'urgent',
                'technician_name' => null,
                'resolution_notes' => null,
                'created_at' => now()->subMinutes(45),
            ]
        );
    }
}
