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

            // Pastikan is_login terupdate menjadi 1 di database IMS trx_batchjob_register
            if ((int)($customer->is_login ?? 0) === 0) {
                try {
                    \Illuminate\Support\Facades\DB::connection('ims')
                        ->statement("UPDATE trx_batchjob_register SET is_login = 1 WHERE nomor_internet = ?", [$customer->nomor_internet]);
                    $customer->is_login = 1;
                } catch (\Throwable $e) {
                    try {
                        \Illuminate\Support\Facades\DB::connection('ims')
                            ->table('trx_batchjob_register')
                            ->where('nomor_internet', $customer->nomor_internet)
                            ->update(['is_login' => 1]);
                        $customer->is_login = 1;
                    } catch (\Throwable $err) {
                        //
                    }
                }
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
            try {
                $customer->is_login = 1;
                $customer->save();
            } catch (\Throwable $e) {
                try {
                    \Illuminate\Support\Facades\DB::connection($customer->getConnectionName() ?: 'ims')
                        ->table($customer->getTable())
                        ->where($customer->getKeyName(), $customer->getKey())
                        ->update(['is_login' => 1]);
                } catch (\Throwable $inner) {
                    //
                }
            }

            // Sync ke tabel customers di default connection jika ada
            try {
                if (\Illuminate\Support\Facades\Schema::connection('mysql')->hasTable('customers')) {
                    \Illuminate\Support\Facades\DB::connection('mysql')->table('customers')
                        ->where('customer_id', $customer->customer_id)
                        ->orWhere('phone', $customer->phone)
                        ->update(['is_login' => 1]);
                }
            } catch (\Throwable $e) {
                //
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Tutorial onboarding berhasil diselesaikan.',
            'is_login' => 1,
        ]);
    }
}
