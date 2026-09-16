<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Tampilkan daftar pelanggan
     */
    public function index(Request $request)
    {
        $query = Customer::with('package')->withCount([
            'tickets',
            'tickets as active_tickets_count' => function ($q) {
                $q->whereIn('status', ['open', 'in_progress']);
            }
        ])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('customer_id', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(15)->withQueryString();
        $packages = Package::where('is_active', true)->get();

        return view('admin.customers.index', compact('customers', 'packages'));
    }

    /**
     * Simpan data pelanggan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => ['required', 'string', 'unique:customers,customer_id'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'unique:customers,phone'],
            'email' => ['nullable', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:4'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'district' => ['nullable', 'string'],
            'ip_address' => ['nullable', 'string'],
            'status' => ['required', 'in:active,isolated,suspended'],
            'billing_amount' => ['nullable', 'numeric'],
            'due_date' => ['nullable', 'integer', 'between:1,31'],
            'billing_status' => ['required', 'in:paid,unpaid,overdue'],
        ]);

        $phone = preg_replace('/[^0-9]/', '', $request->phone);
        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }

        Customer::create([
            'customer_id' => $request->customer_id,
            'name' => $request->name,
            'phone' => $phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'package_id' => $request->package_id,
            'address' => $request->address,
            'city' => $request->city,
            'district' => $request->district,
            'ip_address' => $request->ip_address,
            'status' => $request->status,
            'billing_amount' => $request->billing_amount ?? 0,
            'due_date' => $request->due_date ?? 20,
            'billing_status' => $request->billing_status,
        ]);

        return back()->with('success', 'Pelanggan baru berhasil ditambahkan.');
    }

    /**
     * Hapus data pelanggan
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()->with('success', 'Pelanggan berhasil dihapus.');
    }
}
