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

        // Ambil data sampel real langsung dari ims_v2.trx_batchjob_register
        try {
            $demoCustomers = Customer::with(['pelanggan', 'bandwith'])
                ->whereHas('pelanggan', function ($q) {
                    $q->whereNotNull('nomor_hp')->where('nomor_hp', '!=', '');
                })
                ->take(3)
                ->get();
        } catch (\Exception $e) {
            $demoCustomers = collect([]);
        }

        return view('portal.auth.login', compact('demoCustomers'));
    }

    /**
     * Proses login langsung dengan nomor telepon / nomor internet
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string'],
        ], [
            'phone.required' => 'Nomor Telepon / WhatsApp atau Nomor Internet wajib diisi.',
        ]);

        $rawInput = trim($request->phone);
        $phone = preg_replace('/[^0-9]/', '', $rawInput);
        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }

        try {
            // Cari data pelanggan langsung di database ims_v2 (trx_batchjob_register & m_pelanggan)
            $customer = Customer::with(['pelanggan', 'bandwith'])
                ->where(function ($query) use ($phone, $rawInput) {
                    $query->whereHas('pelanggan', function ($q) use ($phone, $rawInput) {
                        $q->where('nomor_hp', $phone)
                          ->orWhere('nomor_hp_2', $phone)
                          ->orWhere('nomor_hp', $rawInput);
                    })
                    ->orWhere('nomor_internet', $rawInput);
                })
                ->first();

            if ($customer) {
                // Langsung login tanpa perlu memasukkan PIN/kata sandi
                Auth::guard('customer')->login($customer, $request->boolean('remember', true));
                $request->session()->regenerate();

                return redirect()->intended(route('portal.dashboard'))
                    ->with('success', "Selamat datang di Portal Layanan PT MSN, {$customer->name}!");
            }
        } catch (\Exception $e) {
            return back()->withInput($request->only('phone'))->withErrors([
                'phone' => 'Gagal terhubung ke database IMS: ' . $e->getMessage(),
            ]);
        }

        return back()->withInput($request->only('phone'))->withErrors([
            'phone' => 'Nomor telepon (' . $rawInput . ') tidak terdaftar di sistem pelanggan PT MSN. Pastikan nomor sesuai dengan yang didaftarkan saat pemasangan internet.',
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
