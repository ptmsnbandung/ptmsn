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
        $broadbandPackages = Package::where('is_active', true)
            ->where(function ($query) {
                $query->where('category', 'broadband')->orWhereNull('category');
            })
            ->orderBy('sort_order')
            ->get();

        $sohoPackages = Package::where('is_active', true)
            ->where('category', 'soho')
            ->orderBy('sort_order')
            ->get();

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
