<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Ims\BillingLayanan;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Tampilkan Halaman Menu Tagihan & Pembayaran Pelanggan (Terhubung ke IMS v2)
     */
    public function index()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $customer->load(['pelanggan', 'bandwith']);
        }

        // Ambil riwayat seluruh invoice pelanggan dari tabel IMS trx_billing_layanan
        $invoices = $customer->billingLayanan;

        // Cari tagihan aktif: prioritaskan yang belum lunas (status != 15), atau ambil tagihan terbaru
        $currentInvoice = $invoices->firstWhere('is_paid', false) ?? $invoices->first();

        // Jika belum ada data tagihan di IMS untuk pelanggan ini, siapkan tagihan bulan berjalan
        if (!$currentInvoice) {
            $currentMonth = Carbon::now()->format('m');
            $currentYear = Carbon::now()->format('Y');
            $kodeBilling = 'INV/' . $customer->customer_id . '/' . $currentMonth . '/' . $currentYear;

            $currentInvoice = BillingLayanan::firstOrCreate(
                [
                    'kode_billing_layanan' => $kodeBilling,
                ],
                [
                    'nomor_internet' => $customer->customer_id,
                    'kode_bandwith' => $customer->kode_bandwith ?? 'AG26007',
                    'nominal_bandwith' => (string) ($customer->bandwith?->nominal_bandwith ?? '25'),
                    'bulan_tagihan' => $currentMonth,
                    'tahun_tagihan' => $currentYear,
                    'periode_tagihan' => Carbon::now()->translatedFormat('M Y'),
                    'total_layanan' => (string) $customer->billing_amount,
                    'potongan' => '0',
                    'ppn' => '0.11',
                    'status_bill_lay' => ($customer->billing_status === 'paid' ? '15' : '13'),
                    'expiry' => Carbon::now()->setDay(min(28, (int)($customer->due_date ?: 20)))->setTime(23, 59, 0),
                    'date_create' => Carbon::now(),
                ]
            );

            // Muat ulang riwayat
            $invoices = $customer->billingLayanan()->get();
        }

        // Cek sinkronisasi status otomatis dengan Midtrans jika tagihan belum lunas tapi pernah dibuat sesi bayar
        if ($currentInvoice && !$currentInvoice->is_paid && !empty($currentInvoice->payment_post)) {
            $this->midtransService->syncTransactionStatus($currentInvoice);
            $currentInvoice->refresh();
        }

        $snapJsUrl = $this->midtransService->getSnapJsUrl();
        $clientKey = $this->midtransService->getClientKey();

        return view('portal.billing.index', compact(
            'customer',
            'currentInvoice',
            'invoices',
            'snapJsUrl',
            'clientKey'
        ));
    }

    /**
     * Cetak / Tampilkan Rincian Tagihan Resmi (Print Friendly) dari IMS v2
     */
    public function show(string $invoiceCode)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        // Decode jika terdapat URL encoding
        $decodedCode = urldecode($invoiceCode);

        // Cari di tabel trx_billing_layanan
        $invoice = BillingLayanan::where('kode_billing_layanan', $decodedCode)
            ->orWhere('kode_billing_layanan', $invoiceCode)
            ->firstOrFail();

        // Pastikan hanya pemilik invoice yang bisa melihat
        if ($invoice->nomor_internet !== $customer->customer_id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        // Sinkronisasi status dengan Midtrans jika belum lunas
        if (!$invoice->is_paid && !empty($invoice->payment_post)) {
            $this->midtransService->syncTransactionStatus($invoice);
            $invoice->refresh();
        }

        $snapJsUrl = $this->midtransService->getSnapJsUrl();
        $clientKey = $this->midtransService->getClientKey();

        return view('portal.billing.show', compact('customer', 'invoice', 'snapJsUrl', 'clientKey'));
    }

    /**
     * Endpoint Cek & Sinkronkan Status Pembayaran dari Frontend / Popup
     */
    public function sync(string $invoiceCode): JsonResponse
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        $decodedCode = urldecode($invoiceCode);

        $invoice = BillingLayanan::where('kode_billing_layanan', $decodedCode)
            ->orWhere('kode_billing_layanan', $invoiceCode)
            ->first();

        if (!$invoice || $invoice->nomor_internet !== $customer->customer_id) {
            return response()->json(['success' => false, 'message' => 'Tagihan tidak ditemukan'], 404);
        }

        $this->midtransService->syncTransactionStatus($invoice);
        $invoice->refresh();

        return response()->json([
            'success' => true,
            'is_paid' => $invoice->is_paid,
            'status' => $invoice->status_bill_lay,
            'message' => $invoice->is_paid ? 'Tagihan berhasil dikonfirmasi LUNAS.' : 'Status tagihan diperbarui.',
        ]);
    }

    /**
     * Endpoint Buat / Dapatkan Token Midtrans Snap untuk Tagihan Tertentu
     */
    public function pay(Request $request, string $invoiceCode): JsonResponse
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $decodedCode = urldecode($invoiceCode);

        $invoice = BillingLayanan::where('kode_billing_layanan', $decodedCode)
            ->orWhere('kode_billing_layanan', $invoiceCode)
            ->firstOrFail();

        if ($invoice->nomor_internet !== $customer->customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak: Tagihan bukan milik akun Anda.',
            ], 403);
        }

        if ($invoice->is_paid) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan ini sudah LUNAS.',
            ], 400);
        }

        $force = $request->boolean('force', false);
        $result = $this->midtransService->createSnapTransaction($invoice, $customer, $force);

        if (!$result['success']) {
            return response()->json($result, 500);
        }

        return response()->json($result);
    }

    /**
     * Webhook / HTTP Notification Handler dari Midtrans
     */
     public function handleNotification(Request $request): JsonResponse
     {
         // Handle test ping (GET request atau payload kosong dari tombol Test Midtrans Dashboard)
         if ($request->isMethod('get') || empty($request->all())) {
             return response()->json([
                 'status' => 'ok',
                 'message' => 'PT MSN Midtrans Notification Endpoint is active and ready.',
             ], 200);
         }

         $payload = $request->all();

         // Handle dummy test payload dari tombol "Test notification URL"
         if (isset($payload['order_id']) && (str_starts_with($payload['order_id'], 'test-') || str_contains($payload['order_id'], 'dummy') || str_contains($payload['order_id'], 'sample'))) {
             return response()->json([
                 'status' => 'ok',
                 'message' => 'Test notification received successfully.',
             ], 200);
         }

         $result = $this->midtransService->handleNotification($payload);

         return response()->json([
             'status' => $result['success'] ? 'ok' : 'processed',
             'message' => $result['message'],
         ], 200);
     }
}
