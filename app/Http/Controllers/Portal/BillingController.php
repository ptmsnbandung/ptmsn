<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    /**
     * Tampilkan Halaman Menu Tagihan & Pembayaran Pelanggan
     */
    public function index()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $customer->load(['pelanggan', 'bandwith']);
        }

        $currentPeriod = Carbon::now()->translatedFormat('F Y');
        $cleanCustomerId = preg_replace('/[^A-Za-z0-9]/', '', $customer->customer_id);
        $invoiceNumber = 'INV/' . Carbon::now()->format('Ym') . '/' . $cleanCustomerId;

        $dueDay = min(28, max(1, (int) ($customer->due_date ?: 20)));
        $dueDate = Carbon::now()->setDay($dueDay);

        // Cari atau buatkan invoice bulan berjalan secara otomatis
        $currentInvoice = Invoice::firstOrCreate(
            [
                'customer_id' => $customer->customer_id,
                'period' => $currentPeriod,
            ],
            [
                'invoice_number' => $invoiceNumber,
                'package_name' => ($customer->package->name ?? 'Broadband FTTH') . ' (' . ($customer->package->speed ?? '25 Mbps') . ')',
                'amount' => $customer->billing_amount,
                'tax_amount' => 0,
                'total_amount' => $customer->billing_amount,
                'status' => $customer->billing_status,
                'due_date' => $dueDate->toDateString(),
            ]
        );

        // Jika status di profil berubah (misal sudah lunas), sinkronkan
        if ($customer->billing_status === 'paid' && $currentInvoice->status === 'unpaid') {
            $currentInvoice->update([
                'status' => 'paid',
                'paid_at' => Carbon::now(),
            ]);
        }

        // Ambil riwayat seluruh invoice pelanggan
        $invoices = Invoice::where('customer_id', $customer->customer_id)
            ->orderBy('due_date', 'desc')
            ->get();

        return view('portal.billing.index', compact(
            'customer',
            'currentInvoice',
            'invoices'
        ));
    }

    /**
     * Cetak / Tampilkan Rincian Tagihan Resmi (Print Friendly)
     */
    public function show(Invoice $invoice)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        // Pastikan hanya pemilik invoice yang bisa melihat
        if ($invoice->customer_id !== $customer->customer_id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('portal.billing.show', compact('customer', 'invoice'));
    }
}
