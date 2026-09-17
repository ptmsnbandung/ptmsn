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

        // Ambil tiket & ubah layanan terbaru dari IMS
        $tickets = $customer ? $customer->tickets()->get() : collect([]);
        $ubah = $customer ? $customer->ubahLayanan()->get() : collect([]);

        $recentTickets = $tickets->concat($ubah)->sortByDesc(function ($item) {
            return $item->created_at ? $item->created_at->timestamp : 0;
        })->take(5)->values();

        $activeTicketsCount = $tickets->whereIn('status', ['11', '12', 'open', 'in_progress', 'proses', 'antrian', 'konfirmasi'])->count()
            + $ubah->whereIn('status_ubah_layanan', ['11', '12', 'open', 'in_progress', 'proses'])->count();

        $resolvedTicketsCount = $tickets->whereIn('status', ['13', '14', 'resolved', 'done', 'close', 'closed'])->count()
            + $ubah->whereIn('status_ubah_layanan', ['13', '14', 'resolved', 'done'])->count();

        return view('portal.dashboard', compact(
            'customer',
            'recentTickets',
            'activeTicketsCount',
            'resolvedTicketsCount'
        ));
    }
}
