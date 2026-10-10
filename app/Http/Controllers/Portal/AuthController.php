<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\MetaWhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login portal pelanggan
     */
    public function showLogin()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('portal.dashboard');
        }

        return view('portal.auth.login');
    }

    /**
     * Kirim kode OTP WhatsApp ke nomor telepon pelanggan
     */
    public function sendOtp(Request $request, MetaWhatsAppService $waService)
    {
        $rawPhone = trim((string)$request->input('phone', ''));

        if (empty($rawPhone)) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp wajib diisi.',
            ], 422);
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
        if (empty($cleanPhone)) {
            return response()->json([
                'success' => false,
                'message' => 'Format nomor WhatsApp tidak valid.',
            ], 422);
        }

        // Variasi format: di database IMS nomor diawali '62', sedangkan user mengetik '08...'
        $variants = $this->getPhoneSearchVariants($rawPhone);
        $corePhone = $this->extractCorePhoneNumber($rawPhone);
        $intlPhone = MetaWhatsAppService::formatPhoneNumber($rawPhone);

        try {
            // Cari pelanggan di database IMS berdasarkan nomor HP (mencocokkan awalan 62, 0, +62)
            $customer = Customer::with(['pelanggan', 'bandwith'])
                ->whereHas('pelanggan', function ($q) use ($variants, $corePhone) {
                    $q->whereIn('nomor_hp', $variants)
                      ->orWhereIn('nomor_hp_2', $variants);

                    if (!empty($corePhone) && strlen($corePhone) >= 7) {
                        $q->orWhere('nomor_hp', 'like', "%{$corePhone}")
                          ->orWhere('nomor_hp_2', 'like', "%{$corePhone}");
                    }
                })
                ->orWhere('nomor_internet', $rawPhone)
                ->first();

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => "Nomor WhatsApp ({$rawPhone}) tidak terdaftar di sistem PT MSN. Pastikan nomor sesuai saat pendaftaran.",
                ], 404);
            }

            // Ambil nomor HP aktif dari data pelanggan (utamakan nomor terdaftar di database)
            $destPhone = $customer->pelanggan?->nomor_hp 
                ?: $customer->pelanggan?->nomor_hp_2 
                ?: $intlPhone;

            $destPhoneFormatted = MetaWhatsAppService::formatPhoneNumber($destPhone);

            // Rate limit / Cooldown: Cek apakah OTP baru saja dikirim dalam 60 detik terakhir
            $cacheKey = "portal_wa_otp_{$destPhoneFormatted}";
            $existing = Cache::get($cacheKey);

            if ($existing && isset($existing['created_at'])) {
                $elapsed = time() - $existing['created_at'];
                if ($elapsed < 60) {
                    $remaining = 60 - $elapsed;
                    return response()->json([
                        'success' => false,
                        'message' => "Kode OTP baru saja dikirim. Silakan tunggu {$remaining} detik sebelum meminta kode baru.",
                        'cooldown' => $remaining,
                    ], 429);
                }
            }

            // Generate 6-digit OTP angka
            $otp = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

            // Kirim OTP via template Meta WhatsApp Cloud API (Template: vertifikasi)
            $sendResult = $waService->sendOtp($destPhoneFormatted, $otp);

            if (!$sendResult['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $sendResult['message'],
                ], 500);
            }

            // Simpan data OTP di Cache & Session selama 5 menit
            $otpData = [
                'otp' => $otp,
                'nomor_internet' => $customer->nomor_internet,
                'phone' => $destPhoneFormatted,
                'created_at' => time(),
                'expires_at' => time() + 300,
                'attempts' => 0,
            ];

            Cache::put($cacheKey, $otpData, now()->addMinutes(5));
            session(['portal_pending_otp' => $otpData]);

            $masked = MetaWhatsAppService::maskPhoneNumber($destPhoneFormatted);

            return response()->json([
                'success' => true,
                'message' => "Kode verifikasi 6-digit telah dikirim ke WhatsApp {$masked}.",
                'phone' => $destPhoneFormatted,
                'masked_phone' => $masked,
                'cooldown' => 60,
                'debug_otp' => $sendResult['debug_otp'] ?? null,
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim OTP login: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat mengirim kode OTP: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verifikasi kode OTP dan langsung login pelanggan
     */
    public function verifyOtp(Request $request)
    {
        $rawPhone = trim((string)$request->input('phone', ''));
        $inputOtp = trim((string)$request->input('otp', ''));

        if (empty($inputOtp)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP 6-digit wajib diisi.',
            ], 422);
        }

        $destPhoneFormatted = MetaWhatsAppService::formatPhoneNumber($rawPhone);
        $cacheKey = "portal_wa_otp_{$destPhoneFormatted}";

        $otpData = Cache::get($cacheKey) ?: session('portal_pending_otp');

        if (!$otpData) {
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi telah kadaluarsa atau belum diminta. Silakan minta kode baru.',
            ], 400);
        }

        // Cek kadaluarsa (5 menit)
        if (time() > ($otpData['expires_at'] ?? 0)) {
            Cache::forget($cacheKey);
            session()->forget('portal_pending_otp');
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi telah kadaluarsa. Silakan minta kode baru.',
            ], 400);
        }

        // Cek batas percobaan gagal
        if (($otpData['attempts'] ?? 0) >= 5) {
            Cache::forget($cacheKey);
            session()->forget('portal_pending_otp');
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak percobaan salah. Silakan minta kode verifikasi baru.',
            ], 429);
        }

        // Cek kecocokan OTP
        if ((string)$otpData['otp'] !== $inputOtp) {
            $otpData['attempts'] = ($otpData['attempts'] ?? 0) + 1;
            $remaining = 5 - $otpData['attempts'];
            Cache::put($cacheKey, $otpData, now()->addMinutes(5));
            session(['portal_pending_otp' => $otpData]);

            return response()->json([
                'success' => false,
                'message' => "Kode verifikasi salah. Sisa percobaan: {$remaining} kali.",
                'remaining_attempts' => $remaining,
            ], 422);
        }

        // OTP Valid! Bersihkan cache & session OTP
        Cache::forget($cacheKey);
        session()->forget('portal_pending_otp');

        // Ambil data pelanggan untuk login berdasarkan nomor internet (primary key)
        $customer = Customer::with(['pelanggan', 'bandwith'])
            ->where('nomor_internet', $otpData['nomor_internet'])
            ->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggan tidak ditemukan.',
            ], 404);
        }

        $isLoginZero = (int)($customer->is_login ?? 0) === 0;

        Auth::guard('customer')->login($customer, false);
        $request->session()->regenerate();

        session([
            'customer_last_activity' => time(),
            'is_first_login' => $isLoginZero,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Verifikasi berhasil! Selamat datang, {$customer->name}.",
            'redirect' => route('portal.dashboard'),
        ]);
    }

    /**
     * Proses login langsung dengan Nomor Internet (ID Pelanggan)
     */
    public function login(Request $request)
    {
        $rawInput = trim($request->input('login') ?: $request->input('phone') ?: '');

        if (empty($rawInput)) {
            return back()->withInput()->withErrors([
                'login' => 'Nomor Internet atau Nomor Telepon / WhatsApp wajib diisi.',
                'phone' => 'Nomor Internet atau Nomor Telepon / WhatsApp wajib diisi.',
            ]);
        }

        $cleanInput = preg_replace('/[^0-9]/', '', $rawInput);
        $variants = $this->getPhoneSearchVariants($rawInput);
        $corePhone = $this->extractCorePhoneNumber($rawInput);

        try {
            // 1. Cari pelanggan berdasarkan Nomor Internet (ID Pelanggan) persis
            $customer = Customer::with(['pelanggan', 'bandwith'])
                ->where('nomor_internet', $rawInput)
                ->orWhere('nomor_internet', $cleanInput)
                ->first();

            // 2. Jika tidak ditemukan, cari dengan nomor HP/WhatsApp pelanggan (mencocokkan awalan 62 dan 0)
            if (!$customer) {
                $customer = Customer::with(['pelanggan', 'bandwith'])
                    ->whereHas('pelanggan', function ($q) use ($variants, $corePhone) {
                        $q->whereIn('nomor_hp', $variants)
                          ->orWhereIn('nomor_hp_2', $variants);

                        if (!empty($corePhone) && strlen($corePhone) >= 7) {
                            $q->orWhere('nomor_hp', 'like', "%{$corePhone}")
                              ->orWhere('nomor_hp_2', 'like', "%{$corePhone}");
                        }
                    })
                    ->first();
            }

            if ($customer) {
                $isLoginZero = (int)($customer->is_login ?? 0) === 0;

                // Langsung login tanpa perlu memasukkan PIN/kata sandi
                Auth::guard('customer')->login($customer, false);
                $request->session()->regenerate();

                // Catat waktu aktivitas awal (untuk timeout 1 jam) dan status login perdana
                session([
                    'customer_last_activity' => time(),
                    'is_first_login' => $isLoginZero,
                ]);

                return redirect()->intended(route('portal.dashboard'))
                    ->with('success', "Selamat datang di Portal Layanan PT MSN, {$customer->name}!");
            }
        } catch (\Exception $e) {
            return back()->withInput($request->only('login', 'phone'))->withErrors([
                'login' => 'Gagal terhubung ke database IMS: ' . $e->getMessage(),
            ]);
        }

        return back()->withInput($request->only('login', 'phone'))->withErrors([
            'login' => 'Nomor Internet / Nomor WhatsApp (' . $rawInput . ') tidak terdaftar di sistem pelanggan PT MSN. Pastikan data sesuai dengan yang terdaftar.',
        ]);
    }

    /**
     * Hasilkan variasi nomor telepon (62xxx, 0xxx, +62xxx, 8xxx)
     * agar pelanggan yang mengetikkan 08... tetap cocok dengan database IMS yang tersimpan 62...
     */
    protected function getPhoneSearchVariants(string $rawInput): array
    {
        $clean = preg_replace('/[^0-9]/', '', $rawInput);
        if (empty($clean)) {
            return array_values(array_filter([trim($rawInput)]));
        }

        $core = $clean;
        if (str_starts_with($core, '62')) {
            $core = substr($core, 2);
        } elseif (str_starts_with($core, '0')) {
            $core = substr($core, 1);
        }

        return array_values(array_unique(array_filter([
            '62' . $core,      // Format utama di database IMS (6281234567890)
            '+62' . $core,     // Format tanda plus (+6281234567890)
            '0' . $core,       // Format lokal yang diketik user (081234567890)
            $core,             // Format inti tanpa awalan (81234567890)
            $clean,            // Angka bersih
            trim($rawInput),   // Input mentah
        ])));
    }

    /**
     * Ambil inti nomor telepon tanpa kode negara atau leading zero (misal: 81234567890)
     */
    protected function extractCorePhoneNumber(string $rawInput): string
    {
        $clean = preg_replace('/[^0-9]/', '', $rawInput);
        if (str_starts_with($clean, '62')) {
            return substr($clean, 2);
        } elseif (str_starts_with($clean, '0')) {
            return substr($clean, 1);
        }
        return $clean;
    }

    /**
     * Proses logout pelanggan
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->forget('customer_last_activity');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.login')->with('info', 'Anda telah berhasil keluar dari Portal Pelanggan.');
    }
}
