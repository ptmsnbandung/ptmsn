<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Ims\TiketGangguan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Tampilkan semua daftar tiket gangguan pelanggan
     */
    public function index(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $query = $customer->tickets();

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'open') {
                $query->whereIn('status', ['11', 'open']);
            } elseif ($status === 'in_progress') {
                $query->whereIn('status', ['12', '13', 'in_progress', 'proses']);
            } elseif ($status === 'resolved') {
                $query->whereIn('status', ['14', 'resolved', 'done', 'close', 'closed']);
            } else {
                $query->where('status', $status);
            }
        }

        if ($request->filled('category')) {
            $query->where('kat_tiket', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tiket', 'like', "%{$search}%")
                  ->orWhere('indikasi', 'like', "%{$search}%")
                  ->orWhere('keluhan', 'like', "%{$search}%");
            });
        }

        $tickets = $query->paginate(10)->withQueryString();

        return view('portal.tickets.index', compact('tickets', 'customer'));
    }

    /**
     * Tampilkan form pembuatan laporan gangguan baru
     */
    public function create()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $customer->load(['pelanggan', 'bandwith']);
        }

        return view('portal.tickets.create', compact('customer'));
    }

    /**
     * Simpan laporan gangguan baru ke database IMS (trx_tiket_gangguan)
     */
    public function store(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'kat_tiket' => ['required', 'string'],
            'subject' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'min:5', 'max:2000'],
        ], [
            'kat_tiket.required' => 'Pilih jenis kendala / kategori tiket.',
            'subject.required' => 'Judul ringkas kendala / indikasi wajib diisi.',
            'description.required' => 'Deskripsi keluhan wajib dijelaskan.',
            'description.min' => 'Deskripsi keluhan minimal 5 karakter.',
        ]);

        $katTiket = $request->kat_tiket ?? '11';
        
        // Generate nomor tiket format IMS: [kat_tiket][YYYYMMDD][RANDOM]
        $datePrefix = date('Ymd');
        $randomSuffix = rand(100, 999);
        $ticketNumber = $katTiket . '1' . $datePrefix . $randomSuffix;

        $ticket = TiketGangguan::create([
            'tiket' => $ticketNumber,
            'nomor_internet' => $customer->nomor_internet,
            'keluhan' => $request->description,
            'indikasi' => $request->subject,
            'status' => '11', // Status 11 = Menunggu Verifikasi / Baru
            'kat_tiket' => $katTiket,
            'nomor_hp' => $customer->phone ?: ($customer->pelanggan?->nomor_hp ?? ''),
            'is_group' => '2',
            'group_wa' => null,
            'note' => 'Dikirim dari Portal Pelanggan Website',
            'date_create' => now(),
            'user_create' => 'Portal Pelanggan',
            'hide' => '0',
        ]);

        return redirect()->route('portal.tickets.show', $ticket->tiket)
            ->with('success', "Laporan tiket #{$ticket->tiket} berhasil dikirim ke sistem IMS! Tim teknisi NOC kami akan segera menindaklanjuti.");
    }

    /**
     * Tampilkan detail laporan gangguan & pelacakan status
     */
    public function show($id)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $ticket = $customer->tickets()->where('tiket', $id)->firstOrFail();

        return view('portal.tickets.show', compact('ticket', 'customer'));
    }
}

