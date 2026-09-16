<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
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
        $customer->load('package');

        return view('portal.tickets.create', compact('customer'));
    }

    /**
     * Simpan laporan gangguan baru
     */
    public function store(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'category' => ['required', 'string', 'in:internet_mati,los_merah,koneksi_lambat,perangkat_rusak,billing,lainnya'],
            'subject' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'priority' => ['nullable', 'string', 'in:low,medium,high,urgent'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'], // Max 5MB
        ], [
            'category.required' => 'Pilih jenis kendala / kategori gangguan.',
            'subject.required' => 'Judul laporan gangguan wajib diisi.',
            'description.required' => 'Deskripsi kendala wajib dijelaskan.',
            'description.min' => 'Deskripsi minimal 10 karakter agar teknisi dapat memahami kendala dengan baik.',
            'photo.image' => 'File bukti harus berupa gambar (JPG, PNG, WEBP).',
            'photo.max' => 'Ukuran foto maksimal 5 MB.',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('tickets', 'public');
        }

        // Generate nomor tiket unik: TKT-YYYYMMDD-XXXX
        $datePrefix = date('Ymd');
        $randomSuffix = strtoupper(substr(bin2hex(random_bytes(3)), 0, 4));
        $ticketNumber = 'TKT-' . $datePrefix . '-' . $randomSuffix;

        $ticket = Ticket::create([
            'ticket_number' => $ticketNumber,
            'customer_id' => $customer->id,
            'category' => $request->category,
            'subject' => $request->subject,
            'description' => $request->description,
            'photo_path' => $photoPath,
            'status' => 'open',
            'priority' => $request->priority ?? 'medium',
        ]);

        return redirect()->route('portal.tickets.show', $ticket->id)
            ->with('success', "Laporan gangguan #{$ticket->ticket_number} berhasil dikirim! Tim teknisi NOC kami sedang meninjaunya.");
    }

    /**
     * Tampilkan detail laporan gangguan & pelacakan status
     */
    public function show($id)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $ticket = $customer->tickets()->where('id', $id)->firstOrFail();

        return view('portal.tickets.show', compact('ticket', 'customer'));
    }
}
