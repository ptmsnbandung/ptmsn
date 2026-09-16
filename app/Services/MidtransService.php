<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Ims\BillingLayanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    /**
     * Dapatkan Server Key dari konfigurasi
     */
    public function getServerKey(): string
    {
        return (string) config('services.midtrans.server_key', '');
    }

    /**
     * Dapatkan Client Key dari konfigurasi
     */
    public function getClientKey(): string
    {
        return (string) config('services.midtrans.client_key', '');
    }

    /**
     * Cek apakah mode Production
     */
    public function isProduction(): bool
    {
        $serverKey = $this->getServerKey();
        if (str_starts_with($serverKey, 'SB-Mid-')) {
            return false;
        }
        if (str_starts_with($serverKey, 'Mid-server-')) {
            return true;
        }
        return (bool) config('services.midtrans.is_production', false);
    }

    /**
     * URL API Snap Transaksi
     */
    public function getSnapApiUrl(): string
    {
        return $this->isProduction()
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    /**
     * URL Javascript Snap Resmi Midtrans
     */
    public function getSnapJsUrl(): string
    {
        return $this->isProduction()
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }

    /**
     * Buat Transaksi Snap Token ke Midtrans API (Selalu buat sesi baru agar token tidak kadaluarsa)
     */
    public function createSnapTransaction(BillingLayanan $billing, Customer $customer, bool $forceNew = true): array
    {
        if ($billing->is_paid) {
            return [
                'success' => false,
                'message' => 'Tagihan ini sudah berstatus LUNAS.',
            ];
        }

        // Cek jika server key belum diisi
        if (empty($this->getServerKey())) {
            return [
                'success' => false,
                'message' => 'MIDTRANS_SERVER_KEY belum dikonfigurasikan di sistem.',
            ];
        }

        // Generate ID Order Unik: ubah karakter slash '/' menjadi '-' agar valid sesuai spesifikasi Midtrans
        // Spesifikasi Midtrans: hanya boleh alfanumerik, dash (-), underscore (_), tilde (~), titik (.)
        $cleanKodeBilling = str_replace(['/', '\\', ' '], '-', $billing->kode_billing_layanan);
        $uniqueOrderId = $cleanKodeBilling . '-' . rand(10000, 99999);

        $amount = (int) round((float) $billing->total_layanan);

        $cleanPhone = preg_replace('/[^0-9]/', '', $customer->phone ?? '08123456789');
        if (strlen($cleanPhone) < 10) {
            $cleanPhone = '08123456789';
        }

        $cleanEmail = filter_var($customer->email, FILTER_VALIDATE_EMAIL)
            ? $customer->email
            : ($customer->customer_id . '@ptmsn.net.id');

        $packageName = $billing->package_name ?: 'Layanan Internet PT MSN';

        $payload = [
            'transaction_details' => [
                'order_id' => $uniqueOrderId,
                'gross_amount' => $amount,
            ],
            'item_details' => [
                [
                    'id' => substr($billing->kode_bandwith ?: 'PKG-1', 0, 50),
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => substr($packageName, 0, 50),
                ],
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'last_name' => '',
                'email' => $cleanEmail,
                'phone' => $cleanPhone,
            ],
            'expiry' => [
                'start_time' => Carbon::now()->format('Y-m-d H:i:s O'),
                'unit' => 'day',
                'duration' => 3,
            ],
        ];

        try {
            $response = Http::withBasicAuth($this->getServerKey(), '')
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->timeout(15)
                ->post($this->getSnapApiUrl(), $payload);

            if ($response->successful()) {
                $resData = $response->json();
                $token = $resData['token'] ?? null;
                $redirectUrl = $resData['redirect_url'] ?? null;

                if ($token) {
                    // Simpan sesuai format tabel IMS trx_billing_layanan
                    $billing->payment_post = json_encode($payload);
                    $billing->payment_respond_post = $resData;
                    if ($billing->status_bill_lay == 11) {
                        $billing->status_bill_lay = 13; // Status: Menunggu Pembayaran
                    }
                    $billing->save();

                    return [
                        'success' => true,
                        'token' => $token,
                        'redirect_url' => $redirectUrl,
                        'order_id' => $uniqueOrderId,
                    ];
                }
            }

            Log::error('Midtrans Snap Error: ' . $response->body(), [
                'status' => $response->status(),
                'billing' => $billing->kode_billing_layanan,
            ]);

            $errorMsg = $response->json('error_messages.0') ?? $response->body();
            return [
                'success' => false,
                'message' => 'Midtrans: ' . $errorMsg,
            ];
        } catch (\Throwable $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage(), [
                'billing' => $billing->kode_billing_layanan,
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menghubungi server Midtrans: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Verifikasi & Tangani Notifikasi Webhook Resmi dari Midtrans
     */
    public function handleNotification(array $payload): array
    {
        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $signature = $payload['signature_key'] ?? '';
        $serverKey = $this->getServerKey();

        // Validasi Signature Key SHA-512 sesuai dokumentasi resmi Midtrans
        $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        if ($signature !== $calculatedSignature) {
            Log::warning('Midtrans Webhook: Invalid signature', [
                'order_id' => $orderId,
                'received_signature' => $signature,
            ]);

            return [
                'success' => false,
                'code' => 403,
                'message' => 'Invalid signature key',
            ];
        }

        // Cari billing berdasarkan kode billing (prefix sebelum -rand)
        $kodeBilling = preg_replace('/-[0-9]+$/', '', $orderId);
        $billing = BillingLayanan::where('kode_billing_layanan', $kodeBilling)->first();

        if (!$billing) {
            // Coba dengan mengembalikan dash '-' menjadi slash '/' (format asli INV/xxx/xx/xxxx)
            $withSlashes = str_replace('-', '/', $kodeBilling);
            $billing = BillingLayanan::where('kode_billing_layanan', $withSlashes)->first();
        }

        if (!$billing) {
            // Fallback: cari dari payload payment_post yang mengandung order_id
            $billing = BillingLayanan::where('payment_post', 'like', '%' . $orderId . '%')->first();
        }

        if (!$billing) {
            Log::warning('Midtrans Webhook: Billing record not found', ['order_id' => $orderId]);
            return [
                'success' => false,
                'code' => 404,
                'message' => 'Billing record not found for order: ' . $orderId,
            ];
        }

        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus = $payload['fraud_status'] ?? '';
        $paymentType = $payload['payment_type'] ?? 'midtrans';

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'challenge') {
                $billing->status_bill_lay = 13; // Challenge / menunggu
            } elseif ($fraudStatus === 'accept') {
                $billing->status_bill_lay = 15; // Lunas
                $billing->merchant_type = $paymentType;
                $billing->amount_paid = (float) $grossAmount;
                $billing->payment_paid = $payload['settlement_time'] ?? Carbon::now();
            }
        } elseif ($transactionStatus === 'settlement') {
            $billing->status_bill_lay = 15; // Lunas (QRIS, VA Bank, Minimarket, dll)
            $billing->merchant_type = $paymentType;
            $billing->amount_paid = (float) $grossAmount;
            $billing->payment_paid = $payload['settlement_time'] ?? Carbon::now();
        } elseif ($transactionStatus === 'pending') {
            $billing->status_bill_lay = 13; // Menunggu Pembayaran
        } elseif (in_array($transactionStatus, ['deny', 'cancel'])) {
            $billing->status_bill_lay = 17; // Dibatalkan
        } elseif ($transactionStatus === 'expire') {
            $billing->status_bill_lay = 18; // Kadaluarsa
        }

        $billing->payment_respond_paid = $payload;
        $billing->save();

        Log::info('Midtrans Webhook: Billing status updated', [
            'order_id' => $orderId,
            'billing' => $billing->kode_billing_layanan,
            'status' => $billing->status_bill_lay,
            'transaction_status' => $transactionStatus,
        ]);

        return [
            'success' => true,
            'code' => 200,
            'message' => 'Notification processed successfully',
        ];
    }
}
