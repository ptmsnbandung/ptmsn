<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil & informasi langganan
     */
    public function index()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $customer->load(['pelanggan', 'bandwith']);
        }

        return view('portal.profile', compact('customer'));
    }

    /**
     * Update kontak atau PIN pelanggan
     */
    public function update(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        if ($customer) {
            if ($customer->pelanggan && $request->filled('email')) {
                $customer->pelanggan->email = $request->email;
                $customer->pelanggan->save();
            }

            if ($request->filled('address')) {
                $customer->alamat_pasang = $request->address;
                $customer->save();
            }
        }

        return back()->with('success', 'Data kontak profil Anda berhasil diperbarui.');
    }

    /**
     * Update email aktif pelanggan via AJAX (dari modal tutorial / verifikasi email)
     */
    public function updateEmailAjax(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Sesi login telah berakhir.'], 401);
        }

        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'Alamat email aktif wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $newEmail = trim((string)$request->input('email'));

        try {
            if ($customer->pelanggan) {
                $customer->pelanggan->email = $newEmail;
                $customer->pelanggan->save();
            } elseif (!empty($customer->nik_penduduk)) {
                \Illuminate\Support\Facades\DB::connection('ims')
                    ->table('m_pelanggan')
                    ->where('nik_penduduk', $customer->nik_penduduk)
                    ->update(['email' => $newEmail]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Alamat email notifikasi berhasil diperbarui!',
                'email' => $newEmail,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan email: ' . $e->getMessage(),
            ], 500);
        }
    }
}
