<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Tampilkan semua tiket pengaduan masuk
     */
    public function index(Request $request)
    {
        $query = Ticket::with('customer.package')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('customer_id', 'like', "%{$search}%");
                  });
            });
        }

        $tickets = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
        ];

        return view('admin.tickets.index', compact('tickets', 'stats'));
    }

    /**
     * Tampilkan detail tiket untuk update status & penugasan teknisi
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('customer.package');
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Update status tiket & catatan penyelesaian
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:open,in_progress,resolved,closed'],
            'priority' => ['required', 'string', 'in:low,medium,high,urgent'],
            'technician_name' => ['nullable', 'string', 'max:100'],
            'resolution_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $resolvedAt = $ticket->resolved_at;
        if ($request->status === 'resolved' && !$ticket->resolved_at) {
            $resolvedAt = now();
        }

        $ticket->update([
            'status' => $request->status,
            'priority' => $request->priority,
            'technician_name' => $request->technician_name,
            'resolution_notes' => $request->resolution_notes,
            'resolved_at' => $resolvedAt,
        ]);

        return back()->with('success', "Tiket {$ticket->ticket_number} berhasil diperbarui.");
    }

    /**
     * Hapus tiket
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Tiket gangguan berhasil dihapus.');
    }
}
