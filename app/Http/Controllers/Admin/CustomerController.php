<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Package;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Tampilkan daftar pelanggan langsung dari database ims_v2
     */
    public function index(Request $request)
    {
        $query = Customer::with(['pelanggan', 'bandwith']);

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereIn('is_suspend', ['0', '1'])->orWhereNull('is_suspend');
            } elseif ($request->status === 'isolated' || $request->status === 'suspended') {
                $query->where('is_suspend', '2');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('nomor_internet', 'like', "%{$search}%")
                  ->orWhere('alamat_pasang', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function ($pq) use ($search) {
                      $pq->where('nomor_hp', 'like', "%{$search}%")
                         ->orWhere('nomor_hp_2', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $customers = $query->paginate(15)->withQueryString();
        $packages = Package::where('is_active', true)->get();

        return view('admin.customers.index', compact('customers', 'packages'));
    }
}
