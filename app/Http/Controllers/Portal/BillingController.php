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

        // Ambil seluruh tagihan yang belum lunas, urutkan secara kronologis (Tahun ASC, Bulan ASC, date_create ASC)
        $unpaidInvoices = $invoices->where('is_paid', false)->sortBy(function ($inv) {
            $year = (int) ($inv->tahun_tagihan ?: 2026);
            $month = (int) ($inv->bulan_tagihan ?: 1);
            $date = $inv->date_create ? $inv->date_create->timestamp : 0;
            return sprintf('%04d%02d_%012d', $year, $month, $date);
        })->values();

        // Tagihan aktif yang WAJIB dibayar pertama kali adalah tunggakan tertua
        $oldestUnpaidInvoice = $unpaidInvoices->first();

        // Tagihan aktif utama: gunakan tunggakan tertua jika ada, atau tagihan terbaru jika semua sudah lunas
        $currentInvoice = $oldestUnpaidInvoice ?? $invoices->first();

        // Jika belum ada data tagihan sama sekali di IMS untuk pelanggan ini, siapkan tagihan bulan berjalan
        if (!$currentInvoice && $invoices->isEmpty()) {
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
                    'expiry' => Carbon::now()->setDay(24)->setTime(23, 59, 0),
                    'date_create' => Carbon::now(),
                ]
            );

            // Muat ulang riwayat
            $invoices = $customer->billingLayanan()->get();
            $unpaidInvoices = $invoices->where('is_paid', false);
            $oldestUnpaidInvoice = $currentInvoice->is_paid ? null : $currentInvoice;
        }

        // Cek sinkronisasi status otomatis dengan Midtrans jika tagihan belum lunas tapi pernah dibuat sesi bayar
        if ($currentInvoice && !$currentInvoice->is_paid && !empty($currentInvoice->payment_post)) {
            $this->midtransService->syncTransactionStatus($currentInvoice);
            $currentInvoice->refresh();
        }

        $snapJsUrl = $this->midtransService->getSnapJsUrl();
        $clientKey = $this->midtransService->getClientKey();

        $bankAccounts = config('company.bank_accounts', []);
        $billingWhatsapp = config('company.billing_whatsapp', '6285188358385');
        $billingWhatsappDisplay = config('company.billing_whatsapp_display', '+62 851-8835-8385');

        $confirmations = \App\Models\PaymentConfirmation::where('customer_id', $customer->customer_id)
            ->latest()
            ->get()
            ->keyBy('kode_billing_layanan');

        return view('portal.billing.index', compact(
            'customer',
            'currentInvoice',
            'oldestUnpaidInvoice',
            'unpaidInvoices',
            'invoices',
            'snapJsUrl',
            'clientKey',
            'bankAccounts',
            'billingWhatsapp',
            'billingWhatsappDisplay',
            'confirmations'
        ));
    }

    /**
     * Proses Upload Bukti Pembayaran Transfer Bank Manual
     */
    public function confirmTransfer(Request $request, string $invoiceCode)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        $decodedCode = urldecode($invoiceCode);

        $invoice = BillingLayanan::where('kode_billing_layanan', $decodedCode)
            ->orWhere('kode_billing_layanan', $invoiceCode)
            ->firstOrFail();

        if ($invoice->nomor_internet !== $customer->customer_id) {
            return back()->withErrors(['transfer' => 'Akses ditolak: Tagihan bukan milik akun Anda.']);
        }

        if ($invoice->is_paid) {
            return back()->with('info', 'Tagihan ini sudah tercatat LUNAS.');
        }

        // Validasi urutan pembayaran (FIFO): Pelanggan wajib melunasi tunggakan tertua terlebih dahulu
        $unpaidInvoices = $customer->billingLayanan->where('is_paid', false)->sortBy(function ($inv) {
            $year = (int) ($inv->tahun_tagihan ?: 2026);
            $month = (int) ($inv->bulan_tagihan ?: 1);
            $date = $inv->date_create ? $inv->date_create->timestamp : 0;
            return sprintf('%04d%02d_%012d', $year, $month, $date);
        })->values();

        $oldestUnpaid = $unpaidInvoices->first();
        if ($oldestUnpaid && $oldestUnpaid->kode_billing_layanan !== $invoice->kode_billing_layanan) {
            return back()->withErrors(['transfer' => "Pembayaran harus berurutan. Harap selesaikan tagihan tertua Anda terlebih dahulu (#{$oldestUnpaid->invoice_number} - Periode {$oldestUnpaid->period})."]);
        }

        $request->validate([
            'proof_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'destination_bank' => 'nullable|string|max:200',
            'notes' => 'nullable|string|max:500',
        ], [
            'proof_file.required' => 'Bukti transfer (foto/PDF) wajib diunggah.',
            'proof_file.mimes' => 'Format file bukti harus berupa JPG, JPEG, PNG, atau PDF.',
            'proof_file.max' => 'Ukuran file bukti maksimal 5MB.',
        ]);

        $file = $request->file('proof_file');
        $cleanId = preg_replace('/[^a-zA-Z0-9]/', '', $customer->customer_id);
        $filename = 'tf_' . $cleanId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('uploads/bukti_transfer');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);
        $filePath = 'uploads/bukti_transfer/' . $filename;
        $fullUrl = url($filePath);

        $destBank = trim((string) $request->input('destination_bank', ''));
        $rawNotes = trim((string) $request->input('notes', ''));

        // Update invoice di IMS v3 menjadi metode transfer (payment_type = '2')
        try {
            $invoice->update([
                'payment_type' => '2',
                'date_update' => \Carbon\Carbon::now(),
            ]);

            // Catat log billing di IMS jika tabel ada
            if (\Illuminate\Support\Facades\Schema::connection('ims')->hasTable('trx_billing_layanan_log')) {
                \Illuminate\Support\Facades\DB::connection('ims')->table('trx_billing_layanan_log')->insert([
                    'kode_billing_lay_log' => 'LOG-' . uniqid(),
                    'kode_billing_layanan' => $invoice->kode_billing_layanan,
                    'status_bill_lay' => $invoice->status_bill_lay ?? '13',
                    'note_billing_lay' => "Customer mengunggah bukti transfer via Portal Pelanggan ({$customer->name})" . ($destBank ? " - {$destBank}" : ''),
                    'date_create' => \Carbon\Carbon::now()->toDateTimeString(),
                    'user_create' => 'PORTAL_CUSTOMER',
                    'hide' => '0',
                ]);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal update status payment_type invoice IMS: ' . $e->getMessage());
        }

        // Simpan atau update data konfirmasi di database lokal ptmsn
        \App\Models\PaymentConfirmation::updateOrCreate(
            [
                'customer_id' => $customer->customer_id,
                'kode_billing_layanan' => $invoice->kode_billing_layanan,
            ],
            [
                'customer_name' => $customer->name,
                'destination_bank' => $destBank ?: null,
                'proof_file' => $fullUrl,
                'notes' => $rawNotes ?: null,
                'status' => 'pending',
                'verified_at' => null,
            ]
        );

        // Sinkronisasi data konfirmasi ke database ims_v3 agar ims_v2 dapat membaca langsung
        try {
            if (\Illuminate\Support\Facades\Schema::connection('ims')->hasTable('payment_confirmations')) {
                // Pastikan kolom destination_bank ada di tabel payment_confirmations IMS
                if (!\Illuminate\Support\Facades\Schema::connection('ims')->hasColumn('payment_confirmations', 'destination_bank')) {
                    \Illuminate\Support\Facades\DB::connection('ims')->statement("ALTER TABLE payment_confirmations ADD COLUMN destination_bank VARCHAR(255) NULL AFTER customer_name;");
                }

                \Illuminate\Support\Facades\DB::connection('ims')->table('payment_confirmations')->updateOrInsert(
                    [
                        'customer_id' => $customer->customer_id,
                        'kode_billing_layanan' => $invoice->kode_billing_layanan,
                    ],
                    [
                        'customer_name' => $customer->name,
                        'destination_bank' => $destBank ?: null,
                        'proof_file' => $fullUrl,
                        'notes' => $rawNotes ?: null,
                        'status' => 'pending',
                        'verified_at' => null,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
            } else {
                // Buat tabel payment_confirmations di ims_v3 jika belum ada
                \Illuminate\Support\Facades\DB::connection('ims')->statement("
                    CREATE TABLE IF NOT EXISTS payment_confirmations (
                        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        customer_id VARCHAR(255) NOT NULL,
                        kode_billing_layanan VARCHAR(255) NOT NULL,
                        customer_name VARCHAR(255) NULL,
                        destination_bank VARCHAR(255) NULL,
                        proof_file TEXT NOT NULL,
                        notes TEXT NULL,
                        status VARCHAR(50) DEFAULT 'pending',
                        admin_notes TEXT NULL,
                        verified_at TIMESTAMP NULL,
                        created_at TIMESTAMP NULL,
                        updated_at TIMESTAMP NULL,
                        INDEX (customer_id),
                        INDEX (kode_billing_layanan)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                ");

                \Illuminate\Support\Facades\DB::connection('ims')->table('payment_confirmations')->updateOrInsert(
                    [
                        'customer_id' => $customer->customer_id,
                        'kode_billing_layanan' => $invoice->kode_billing_layanan,
                    ],
                    [
                        'customer_name' => $customer->name,
                        'destination_bank' => $destBank ?: null,
                        'proof_file' => $fullUrl,
                        'notes' => $rawNotes ?: null,
                        'status' => 'pending',
                        'verified_at' => null,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal sinkronisasi payment_confirmations ke IMS: ' . $e->getMessage());
        }

        $billingWa = config('company.billing_whatsapp', '6289696629955');
        $formattedTotal = $invoice->formatted_total ?? ('Rp ' . number_format((float) $invoice->total_layanan, 0, ',', '.'));
        $bankLine = $destBank ? "%0A• *Bank Tujuan:* {$destBank}" : '';
        $waMsg = "Halo Tim Billing PT MSN,%0A%0ASaya sudah melakukan transfer dan mengunggah bukti pembayaran untuk tagihan:%0A• *ID Pelanggan:* {$customer->customer_id}%0A• *Nama:* {$customer->name}%0A• *No. Invoice:* {$invoice->kode_billing_layanan}%0A• *Periode:* {$invoice->period}%0A• *Total Tagihan:* {$formattedTotal}{$bankLine}%0A%0AMohon bantuannya untuk verifikasi pembayaran. Terima kasih!";
        $waUrl = "https://wa.me/{$billingWa}?text={$waMsg}";

        return back()->with('wa_confirm_url', $waUrl);
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
        $billingWhatsapp = config('company.billing_whatsapp', '6289696629955');
        $bankAccounts = config('company.bank_accounts', []);
        $confirmation = \App\Models\PaymentConfirmation::where('customer_id', $customer->customer_id)
            ->where('kode_billing_layanan', $invoice->kode_billing_layanan)
            ->latest()
            ->first();

        return view('portal.billing.show', compact(
            'customer', 
            'invoice', 
            'snapJsUrl', 
            'clientKey',
            'billingWhatsapp',
            'bankAccounts',
            'confirmation'
        ));
    }

    /**
     * Endpoint Cek & Sinkronkan Status Pembayaran dari Frontend / Popup
     */
    public function syncDirect(Request $request): JsonResponse
    {
        $invoiceCode = $request->input('kode_billing') ?? $request->input('invoice') ?? '';
        return $this->processSync($request, $invoiceCode);
    }

    public function sync(Request $request, string $invoiceCode): JsonResponse
    {
        return $this->processSync($request, $invoiceCode);
    }

    protected function processSync(Request $request, string $invoiceCode): JsonResponse
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        $decodedCode = urldecode($invoiceCode);

        $invoice = BillingLayanan::where('kode_billing_layanan', $decodedCode)
            ->orWhere('kode_billing_layanan', $invoiceCode)
            ->orWhere('kode_billing_layanan', str_replace('-', '/', $decodedCode))
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
    public function payDirect(Request $request): JsonResponse
    {
        $invoiceCode = $request->input('kode_billing') ?? $request->input('invoice') ?? '';
        return $this->processPay($request, $invoiceCode);
    }

    public function pay(Request $request, string $invoiceCode): JsonResponse
    {
        return $this->processPay($request, $invoiceCode);
    }

    protected function processPay(Request $request, string $invoiceCode): JsonResponse
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $decodedCode = urldecode($invoiceCode);

        $invoice = BillingLayanan::where('kode_billing_layanan', $decodedCode)
            ->orWhere('kode_billing_layanan', $invoiceCode)
            ->orWhere('kode_billing_layanan', str_replace('-', '/', $decodedCode))
            ->first();

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan tidak ditemukan: ' . $invoiceCode,
            ], 404);
        }

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

        // Validasi urutan pembayaran (FIFO): Pelanggan wajib melunasi tunggakan tertua terlebih dahulu
        $unpaidInvoices = $customer->billingLayanan->where('is_paid', false)->sortBy(function ($inv) {
            $year = (int) ($inv->tahun_tagihan ?: 2026);
            $month = (int) ($inv->bulan_tagihan ?: 1);
            $date = $inv->date_create ? $inv->date_create->timestamp : 0;
            return sprintf('%04d%02d_%012d', $year, $month, $date);
        })->values();

        $oldestUnpaid = $unpaidInvoices->first();
        if ($oldestUnpaid && $oldestUnpaid->kode_billing_layanan !== $invoice->kode_billing_layanan) {
            return response()->json([
                'success' => false,
                'message' => "Pembayaran harus berurutan. Harap selesaikan tagihan tertua Anda terlebih dahulu (#{$oldestUnpaid->invoice_number} - Periode {$oldestUnpaid->period}).",
            ], 422);
        }

        $force = $request->boolean('force', true);
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
