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

            // Pastikan is_login terupdate menjadi 1 di database
            if ((int)($customer->is_login ?? 0) === 0) {
                $customer->markAsLoggedIn();
            }
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

    /**
     * Tandai tutorial onboarding telah diselesaikan oleh pelanggan (update is_login = 1)
     */
    public function completeOnboarding(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $customer->markAsLoggedIn();
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
