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
        if ($customer) {
            $customer->load(['pelanggan', 'bandwith']);
        }

        // Ambil tiket terbaru dari IMS
        $recentTickets = $customer ? $customer->tickets()->take(5)->get() : collect([]);
        $activeTicketsCount = $customer ? $customer->tickets()->whereIn('status', ['11', '12', '13', 'open', 'in_progress', 'proses'])->count() : 0;
        $resolvedTicketsCount = $customer ? $customer->tickets()->whereIn('status', ['14', 'resolved', 'done', 'close', 'closed'])->count() : 0;

        return view('portal.dashboard', compact(
            'customer',
            'recentTickets',
            'activeTicketsCount',
            'resolvedTicketsCount'
        ));
    }
}
