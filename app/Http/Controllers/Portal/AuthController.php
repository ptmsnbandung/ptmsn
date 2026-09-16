<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // Ambil data sampel nomor telepon untuk tombol login cepat (demo mode)
        $demoCustomers = Customer::with('package')->take(3)->get();

        return view('portal.auth.login', compact('demoCustomers'));
    }

    /**
     * Proses login nomor telepon + PIN
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'phone.required' => 'Nomor telepon wajib diisi.',
            'password.required' => 'PIN / Kata sandi wajib diisi.',
        ]);

        // Bersihkan format nomor telepon (misal jika diawali +62 atau spasi/strip)
        $phone = preg_replace('/[^0-9]/', '', $request->phone);
        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }

        $credentials = [
            'phone' => $phone,
            'password' => $request->password,
        ];

        // Jika nomor telepon exact match
        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('portal.dashboard'))->with('success', 'Selamat datang kembali di Portal Pelanggan PT MSN!');
        }

        // Coba juga dengan format raw input nomor telepon
        if ($request->phone !== $phone) {
            if (Auth::guard('customer')->attempt(['phone' => $request->phone, 'password' => $request->password], $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended(route('portal.dashboard'))->with('success', 'Selamat datang kembali di Portal Pelanggan PT MSN!');
            }
        }

        return back()->withInput($request->only('phone'))->withErrors([
            'phone' => 'Nomor telepon atau PIN / Kata sandi yang Anda masukkan tidak sesuai.',
        ]);
    }

    /**
     * Proses logout pelanggan
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.login')->with('info', 'Anda telah berhasil keluar dari Portal Pelanggan.');
    }
}
