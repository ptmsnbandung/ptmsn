<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\CoverageArea;
use App\Models\Package;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display dashboard summary and analytics.
     */
    public function index(): View
    {
        $stats = [
            'packages_count' => Package::count(),
            'packages_active' => Package::where('is_active', true)->count(),
            'services_count' => Service::count(),
            'portfolios_count' => Portfolio::count(),
            'clients_count' => Client::count(),
            'coverage_count' => CoverageArea::count(),
            'messages_unread' => ContactMessage::where('status', 'unread')->count(),
            'messages_total' => ContactMessage::count(),
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentPortfolios = Portfolio::latest()->take(4)->get();
        $packages = Package::orderBy('sort_order')->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentMessages',
            'recentPortfolios',
            'packages'
        ));
    }
}
