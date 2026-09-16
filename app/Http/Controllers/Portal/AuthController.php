<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Ims\BatchjobRegister;
use App\Models\Ims\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

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

        $demoCustomers = [];

        // Coba ambil data sampel real dari ims_v2.trx_batchjob_register
        try {
            $imsRecords = DB::connection('ims')->table('trx_batchjob_register as r')
                ->join('m_pelanggan as p', 'r.nik_penduduk', '=', 'p.nik_penduduk')
                ->whereNotNull('p.nomor_hp')
                ->where('p.nomor_hp', '!=', '')
                ->select(
                    'r.nomor_internet as customer_id',
                    'r.nama_pelanggan as name',
                    'p.nomor_hp as phone',
                    'r.alamat_pasang as address',
                    'r.kode_bandwith as package_name',
                    'r.ont_ps'
                )
                ->take(3)
                ->get();

            if ($imsRecords->isNotEmpty()) {
                $demoCustomers = $imsRecords;
            }
        } catch (\Exception $e) {
            // Fallback ke tabel lokal jika koneksi ims belum tersedia
            $demoCustomers = Customer::with('package')->take(3)->get();
        }

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
            'phone.required' => 'Nomor telepon / Nomor internet wajib diisi.',
            'password.required' => 'PIN / Kata sandi wajib diisi.',
        ]);

        $rawInput = trim($request->phone);
        $phone = preg_replace('/[^0-9]/', '', $rawInput);
        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }

        // 1. CARI DATA DARI DATABASE IMS_V2 (trx_batchjob_register JOIN m_pelanggan)
        try {
            $imsCustomer = DB::connection('ims')->table('trx_batchjob_register as r')
                ->leftJoin('m_pelanggan as p', 'r.nik_penduduk', '=', 'p.nik_penduduk')
                ->where(function ($q) use ($phone, $rawInput) {
                    $q->where('p.nomor_hp', $phone)
                      ->orWhere('p.nomor_hp_2', $phone)
                      ->orWhere('r.nomor_internet', $rawInput)
                      ->orWhere('p.nomor_hp', $rawInput);
                })
                ->select(
                    'r.nomor_internet',
                    'r.nama_pelanggan',
                    'r.alamat_pasang',
                    'r.kode_bandwith',
                    'r.pppoe_username',
                    'r.pppoe_password',
                    'r.ont_ps',
                    'r.is_suspend',
                    'r.status_reg',
                    'p.nomor_hp',
                    'p.email'
                )
                ->first();

            if ($imsCustomer) {
                // Verifikasi Password: Cek ont_ps, pppoe_password, default 123456, atau 6 digit terakhir nomor hp
                $passwordInput = $request->password;
                $isValidPassword = false;

                if (!empty($imsCustomer->ont_ps) && $passwordInput === $imsCustomer->ont_ps) {
                    $isValidPassword = true;
                } elseif (!empty($imsCustomer->pppoe_password) && $passwordInput === $imsCustomer->pppoe_password) {
                    $isValidPassword = true;
                } elseif ($passwordInput === '123456') {
                    $isValidPassword = true;
                } elseif (!empty($imsCustomer->nomor_hp) && strlen($imsCustomer->nomor_hp) >= 6 && substr($imsCustomer->nomor_hp, -6) === $passwordInput) {
                    $isValidPassword = true;
                }

                if ($isValidPassword) {
                    // Sinkronkan ke model Customer lokal untuk kelola sesi
                    $customerPhone = $imsCustomer->nomor_hp ?: $phone;
                    $localCustomer = Customer::updateOrCreate(
                        ['customer_id' => $imsCustomer->nomor_internet],
                        [
                            'name' => $imsCustomer->nama_pelanggan ?? 'Pelanggan IMS',
                            'phone' => $customerPhone,
                            'email' => $imsCustomer->email,
                            'password' => Hash::make($passwordInput),
                            'address' => $imsCustomer->alamat_pasang,
                            'status' => ($imsCustomer->is_suspend == '1' || $imsCustomer->is_suspend == '0') ? 'active' : 'suspended',
                        ]
                    );

                    Auth::guard('customer')->login($localCustomer, $request->boolean('remember'));
                    $request->session()->regenerate();

                    return redirect()->intended(route('portal.dashboard'))->with('success', "Selamat datang kembali, {$imsCustomer->nama_pelanggan}!");
                }
            }
        } catch (\Exception $e) {
            // Jika koneksi ims belum aktif, lanjut pengecekan lokal
        }

        // 2. FALLBACK PENGECEKAN TABEL CUSTOMERS LOKAL
        $credentials = [
            'phone' => $phone,
            'password' => $request->password,
        ];

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('portal.dashboard'))->with('success', 'Selamat datang kembali di Portal Pelanggan PT MSN!');
        }

        if ($request->phone !== $phone) {
            if (Auth::guard('customer')->attempt(['phone' => $request->phone, 'password' => $request->password], $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended(route('portal.dashboard'))->with('success', 'Selamat datang kembali di Portal Pelanggan PT MSN!');
            }
        }

        return back()->withInput($request->only('phone'))->withErrors([
            'phone' => 'Nomor telepon / ID Pelanggan atau PIN / Kata sandi yang Anda masukkan tidak sesuai.',
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
