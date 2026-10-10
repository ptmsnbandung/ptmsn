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
            $customer->load(['pelanggan', 'bandwith', 'statusRegistrasi']);
        }

        // Ambil tiket, ubah layanan, suspend, & terminasi terbaru dari IMS
        $tickets = $customer ? $customer->tickets()->get() : collect([]);
        $ubah = $customer ? $customer->ubahLayanan()->get() : collect([]);
        $suspend = $customer ? $customer->suspendLayanan()->get() : collect([]);
        $terminasi = $customer ? $customer->terminasiLayanan()->get() : collect([]);

        $recentTickets = $tickets
            ->concat($ubah)
            ->concat($suspend)
            ->concat($terminasi)
            ->sortByDesc(function ($item) {
                return $item->created_at ? $item->created_at->timestamp : 0;
            })->take(5)->values();

        $activeTicketsCount = $tickets->whereIn('status', ['11', '12', 'open', 'in_progress', 'proses', 'antrian', 'konfirmasi'])->count()
            + $ubah->whereIn('status_ubah_layanan', ['11', '12', 'open', 'in_progress', 'proses'])->count()
            + $suspend->whereIn('status_suspend', ['11', '12', '18', 'open', 'in_progress'])->count()
            + $terminasi->whereIn('status_terminasi', ['11', '12', '12.1', '13', '15', 'open', 'in_progress'])->count();

        $resolvedTicketsCount = $tickets->whereIn('status', ['13', '14', 'resolved', 'done', 'close', 'closed'])->count()
            + $ubah->whereIn('status_ubah_layanan', ['13', '14', 'resolved', 'done'])->count()
            + $suspend->whereIn('status_suspend', ['13', '14', '16', 'resolved', 'done'])->count()
            + $terminasi->whereIn('status_terminasi', ['14', '16', 'resolved', 'done'])->count();

        return view('portal.dashboard', compact(
            'customer',
            'recentTickets',
            'activeTicketsCount',
            'resolvedTicketsCount'
        ));
    }

    /**
     * Tandai tutorial onboarding telah diselesaikan oleh pelanggan (update is_login = 1)
     */
    public function completeOnboarding(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $customer->markAsLoggedIn();
            \Illuminate\Support\Facades\Cache::put("portal_cust_is_login_{$customer->nomor_internet}", 1, 86400);
        }

        session(['is_first_login' => false]);
        session()->forget('is_first_login');

        return response()->json([
            'success' => true,
            'message' => 'Tutorial onboarding berhasil diselesaikan.',
            'is_login' => 1,
        ]);
    }
}
