<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard ringkasan pelanggan
     */
    public function index()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        $customer->load('package');

        // Ambil tiket terbaru
        $recentTickets = $customer->tickets()->take(5)->get();
        $activeTicketsCount = $customer->tickets()->whereIn('status', ['open', 'in_progress'])->count();
        $resolvedTicketsCount = $customer->tickets()->where('status', 'resolved')->count();

        return view('portal.dashboard', compact(
            'customer',
            'recentTickets',
            'activeTicketsCount',
            'resolvedTicketsCount'
        ));
    }
}
