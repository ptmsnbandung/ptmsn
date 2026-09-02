<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Company Info
            ['key' => 'company_name', 'value' => 'PT Media Solusi Network', 'group' => 'company', 'label' => 'Nama Perusahaan', 'type' => 'text'],
            ['key' => 'company_tagline', 'value' => 'Get Your IT Solution', 'group' => 'company', 'label' => 'Tagline Perusahaan', 'type' => 'text'],
            ['key' => 'company_whatsapp', 'value' => '6289696629955', 'group' => 'company', 'label' => 'Nomor WhatsApp Sales', 'type' => 'text'],
            ['key' => 'company_phone', 'value' => '(022) 7351 2289', 'group' => 'company', 'label' => 'Nomor Telepon Kantor', 'type' => 'text'],
            ['key' => 'company_email', 'value' => 'info@ptmsn.co.id', 'group' => 'company', 'label' => 'Email Resmi', 'type' => 'text'],
            ['key' => 'company_address', 'value' => 'Jl. Reog No. 18, Turangga, Kec. Lengkong, Kota Bandung, Jawa Barat 40264', 'group' => 'company', 'label' => 'Alamat Kantor Lengkap', 'type' => 'textarea'],
            ['key' => 'company_hours', 'value' => 'Senin - Jumat: 08.30 - 21.00 WIB', 'group' => 'company', 'label' => 'Jam Operasional Kantor', 'type' => 'text'],

            // Hero Section
            ['key' => 'hero_badge', 'value' => 'Infrastruktur Digital & Jaringan Fiber Optic • ISP Resmi', 'group' => 'hero', 'label' => 'Badge / Lencana Hero', 'type' => 'text'],
            ['key' => 'hero_title_line1', 'value' => 'GET YOUR IT', 'group' => 'hero', 'label' => 'Judul Hero Baris 1', 'type' => 'text'],
            ['key' => 'hero_title_highlight', 'value' => 'SOLUTION', 'group' => 'hero', 'label' => 'Judul Hero Highlight Biru', 'type' => 'text'],
            ['key' => 'hero_description', 'value' => 'Holding telekomunikasi resmi penyedia internet fiber optic enterprise, infrastruktur jaringan terpadu, dan rekayasa piranti lunak untuk sektor pemerintahan, BUMN, dan korporasi swasta.', 'group' => 'hero', 'label' => 'Deskripsi Hero', 'type' => 'textarea'],

            // Tentang Kami Section
            ['key' => 'about_badge', 'value' => 'Tentang PT Media Solusi Network', 'group' => 'about', 'label' => 'Badge Tentang Kami', 'type' => 'text'],
            ['key' => 'about_title_regular', 'value' => 'Mitra Terpercaya', 'group' => 'about', 'label' => 'Judul Tentang Kami', 'type' => 'text'],
            ['key' => 'about_title_highlight', 'value' => 'Solusi IT & Infrastruktur Digital', 'group' => 'about', 'label' => 'Judul Highlight Tentang Kami', 'type' => 'text'],
            ['key' => 'about_description', 'value' => 'PT Media Solusi Network adalah perusahaan holding penyedia solusi IT terpadu, developer aplikasi, dan infrastruktur internet yang telah dipercaya oleh pemerintah daerah, BUMN, serta berbagai sektor korporasi swasta.', 'group' => 'about', 'label' => 'Paragraf Profil Tentang Kami', 'type' => 'textarea'],

            // Why Us Section
            ['key' => 'why_badge', 'value' => 'WHY MSN', 'group' => 'why_us', 'label' => 'Badge Why Us', 'type' => 'text'],
            ['key' => 'why_title_line1', 'value' => 'Membangun koneksi yang', 'group' => 'why_us', 'label' => 'Judul Why Us Baris 1', 'type' => 'text'],
            ['key' => 'why_title_highlight', 'value' => 'dapat diandalkan.', 'group' => 'why_us', 'label' => 'Judul Highlight Why Us', 'type' => 'text'],
            ['key' => 'why_description', 'value' => 'PT Media Solusi Network hadir dengan pengalaman di bidang konektivitas, infrastruktur jaringan, dan teknologi digital.', 'group' => 'why_us', 'label' => 'Deskripsi Why Us', 'type' => 'textarea'],

            // CTA Section
            ['key' => 'cta_badge', 'value' => 'Infrastruktur & Layanan Dedicated', 'group' => 'cta', 'label' => 'Badge CTA', 'type' => 'text'],
            ['key' => 'cta_title', 'value' => 'Mari Bangun Koneksi yang Lebih Baik.', 'group' => 'cta', 'label' => 'Judul Banner CTA', 'type' => 'text'],
            ['key' => 'cta_description', 'value' => 'Konsultasikan kebutuhan internet dan infrastruktur jaringan Anda bersama tim spesialis kami untuk solusi konektivitas yang andal dan terukur.', 'group' => 'cta', 'label' => 'Deskripsi Banner CTA', 'type' => 'textarea'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
