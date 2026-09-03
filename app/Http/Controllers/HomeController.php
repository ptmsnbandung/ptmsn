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
                return $cat === 'broadband';
            }
            return !in_array(strtoupper($pkg->name), ['CRYSTAL', 'SAPHIRE', 'EMERALD', 'RUBY', 'DIAMOND']);
        })->values();

        $sohoPackages = $allPackages->filter(function ($pkg) {
            $cat = strtolower($pkg->category ?? '');
            if (!empty($cat)) {
                return $cat === 'soho';
            }
            return in_array(strtoupper($pkg->name), ['CRYSTAL', 'SAPHIRE', 'EMERALD', 'RUBY', 'DIAMOND']);
        })->values();

        // Fallback: If SOHO packages are not yet in database table, generate them in-memory
        if ($sohoPackages->isEmpty()) {
            $sohoList = [
                ['name' => 'CRYSTAL', 'category' => 'soho', 'speed' => '10 Mbps', 'price' => 499000, 'period' => 'bln', 'is_popular' => false, 'features' => ['Unlimited Akses (Tanpa FUP)', 'IP Static / Dedicated SOHO', 'Rasio 1:1 Simetris Fiber Optic', 'Router Dual-Band Gigabit ONT']],
                ['name' => 'SAPHIRE', 'category' => 'soho', 'speed' => '20 Mbps', 'price' => 599000, 'period' => 'bln', 'is_popular' => false, 'features' => ['Unlimited Akses (Tanpa FUP)', 'IP Static / Dedicated SOHO', 'Rasio 1:1 Simetris Fiber Optic', 'Router Dual-Band Gigabit ONT']],
                ['name' => 'EMERALD', 'category' => 'soho', 'speed' => '30 Mbps', 'price' => 699000, 'period' => 'bln', 'is_popular' => true, 'features' => ['Unlimited Akses (Tanpa FUP)', 'IP Static / Dedicated SOHO', 'Rasio 1:1 Simetris Fiber Optic', 'Router Dual-Band Gigabit ONT']],
                ['name' => 'RUBY', 'category' => 'soho', 'speed' => '40 Mbps', 'price' => 799000, 'period' => 'bln', 'is_popular' => false, 'features' => ['Unlimited Akses (Tanpa FUP)', 'IP Static / Dedicated SOHO', 'Rasio 1:1 Simetris Fiber Optic', 'Router Dual-Band Gigabit ONT']],
                ['name' => 'DIAMOND', 'category' => 'soho', 'speed' => '50 Mbps', 'price' => 899000, 'period' => 'bln', 'is_popular' => false, 'features' => ['Unlimited Akses (Tanpa FUP)', 'IP Static / Dedicated SOHO', 'Rasio 1:1 Simetris Fiber Optic', 'Router Dual-Band Gigabit ONT']],
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
