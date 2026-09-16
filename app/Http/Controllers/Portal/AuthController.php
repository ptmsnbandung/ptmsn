<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Proses login langsung dengan Nomor Internet atau Nomor Telepon / WhatsApp
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

        $phone = preg_replace('/[^0-9]/', '', $rawInput);
        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }

        try {
            // 1. Cari pelanggan berdasarkan Nomor Internet (ID Pelanggan) persis
            $customer = Customer::with(['pelanggan', 'bandwith'])
                ->where('nomor_internet', $rawInput)
                ->first();

            // 2. Jika tidak ditemukan, cari dengan angka bersih atau relasi ke biodata pelanggan (nomor HP / WA)
            if (!$customer) {
                $customer = Customer::with(['pelanggan', 'bandwith'])
                    ->where('nomor_internet', $phone)
                    ->orWhereHas('pelanggan', function ($q) use ($phone, $rawInput) {
                        $q->where('nomor_hp', $phone)
                          ->orWhere('nomor_hp_2', $phone)
                          ->orWhere('nomor_hp', $rawInput)
                          ->orWhere('nomor_hp_2', $rawInput);
                    })
                    ->first();
            }

            if ($customer) {
                // Langsung login tanpa perlu memasukkan PIN/kata sandi (tanpa remember token agar patuh batas sesi 1 jam)
                Auth::guard('customer')->login($customer, false);
                $request->session()->regenerate();

                // Catat waktu aktivitas awal (untuk timeout 1 jam)
                session(['customer_last_activity' => time()]);

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
