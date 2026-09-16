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
}
