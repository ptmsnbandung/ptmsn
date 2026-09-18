<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Package;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index(): View
    {
        $allPackages = Package::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Categorize safely without requiring SQL column in WHERE clause
        $broadbandPackages = $allPackages->filter(function ($pkg) {
            $cat = strtolower($pkg->category ?? '');
            if (!empty($cat)) {
                return in_array($cat, ['broadband', 'rumahan']);
            }
            return in_array(strtoupper(trim($pkg->name)), ['PAKET BASIC', 'PAKET HEMAT', 'PAKET KELUARGA', 'PAKET PREMIUM', 'BRONZE', 'SILVER', 'GOLD', 'PLATINUM']);
        })->values();

        $sohoPackages = $allPackages->filter(function ($pkg) {
            $cat = strtolower($pkg->category ?? '');
            if (!empty($cat)) {
                return in_array($cat, ['soho', 'bisnis']);
            }
            return in_array(strtoupper(trim($pkg->name)), ['UMKM BASIC', 'UMKM PLUS', 'BISNIS PRO', 'BISNIS ENTERPRISE', 'CRYSTAL', 'SAPHIRE', 'EMERALD', 'RUBY', 'DIAMOND']);
        })->values();

        // Fallback: If broadband packages are empty, generate default list
        if ($broadbandPackages->isEmpty()) {
            $broadbandList = [
                ['name' => 'PAKET BASIC', 'category' => 'broadband', 'speed' => '15 Mbps', 'price' => 125000, 'period' => 'bln', 'is_popular' => false, 'features' => ['Unlimited Akses (Tanpa FUP)', 'Fast Fiber Optic', 'Termasuk Modem WiFi ONT', 'Bantuan CS 24/7']],
                ['name' => 'PAKET HEMAT', 'category' => 'broadband', 'speed' => '25 Mbps', 'price' => 165000, 'period' => 'bln', 'is_popular' => false, 'features' => ['Unlimited Akses (Tanpa FUP)', 'Fast Fiber Optic', 'Termasuk Modem WiFi ONT', 'Bantuan CS 24/7']],
                ['name' => 'PAKET KELUARGA', 'category' => 'broadband', 'speed' => '30 Mbps', 'price' => 199000, 'period' => 'bln', 'is_popular' => true, 'features' => ['Unlimited Akses (Tanpa FUP)', 'Fast Fiber Optic', 'Termasuk Modem WiFi ONT', 'Bantuan Prioritas 24/7']],
                ['name' => 'PAKET PREMIUM', 'category' => 'broadband', 'speed' => '50 Mbps', 'price' => 249000, 'period' => 'bln', 'is_popular' => false, 'features' => ['Unlimited Akses (Tanpa FUP)', 'Fast Fiber Optic', 'Termasuk Modem WiFi ONT', 'Bantuan Prioritas 24/7']],
            ];
            $broadbandPackages = collect($broadbandList)->map(fn($item) => new Package($item));
        }

        // Fallback: If SOHO/Bisnis packages are empty, generate default list
        if ($sohoPackages->isEmpty()) {
            $sohoList = [
                ['name' => 'UMKM BASIC', 'category' => 'soho', 'speed' => '50 Mbps', 'price' => 399000, 'period' => 'bln', 'is_popular' => false, 'features' => ['Unlimited Akses (Tanpa FUP)', 'IP Private / Static Ready', 'Koneksi Fiber Cepat', 'Router Gigabit ONT']],
                ['name' => 'UMKM PLUS', 'category' => 'soho', 'speed' => '100 Mbps', 'price' => 699000, 'period' => 'bln', 'is_popular' => true, 'features' => ['Unlimited Akses (Tanpa FUP)', 'IP Private / Static Ready', 'Koneksi Fiber Cepat', 'Router Gigabit Dual-Band']],
                ['name' => 'BISNIS PRO', 'category' => 'soho', 'speed' => '200 Mbps', 'price' => 999000, 'period' => 'bln', 'is_popular' => false, 'features' => ['Unlimited Akses (Tanpa FUP)', 'IP Dedicated Bisnis', 'SLA 99.5% Perusahaan', 'Router Gigabit Dual-Band']],
                ['name' => 'BISNIS ENTERPRISE', 'category' => 'soho', 'speed' => '300 Mbps', 'price' => 1299000, 'period' => 'bln', 'is_popular' => false, 'features' => ['Unlimited Akses (Tanpa FUP)', 'IP Dedicated Bisnis', 'SLA 99.8% Korporat', 'Dukungan Dedicated NOC 24/7']],
            ];
            $sohoPackages = collect($sohoList)->map(fn($item) => new Package($item));
        }

        $packages = $broadbandPackages;

        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $portfolios = Portfolio::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $clients = Client::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('home', compact(
            'packages',
            'broadbandPackages',
            'sohoPackages',
            'services',
            'portfolios',
            'clients'
        ));
    }
}
