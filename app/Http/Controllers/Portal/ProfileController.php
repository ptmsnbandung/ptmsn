<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil & informasi langganan
     */
    public function index()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        $customer->load('package');

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
            'current_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required_with' => 'Masukkan PIN / Kata sandi lama untuk mengubah PIN baru.',
            'new_password.min' => 'PIN / Kata sandi baru minimal 6 karakter/angka.',
            'new_password.confirmed' => 'Konfirmasi PIN / Kata sandi baru tidak cocok.',
        ]);

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $customer->password)) {
                return back()->withErrors(['current_password' => 'PIN / Kata sandi saat ini salah.']);
            }
            $customer->password = Hash::make($request->new_password);
        }

        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->save();

        return back()->with('success', 'Data profil Anda berhasil diperbarui.');
    }
}
