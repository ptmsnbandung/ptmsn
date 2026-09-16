@extends('admin.layouts.app')

@section('title', 'Penanganan Tiket #' . $ticket->ticket_number)
@section('header', 'Detail & Penanganan Tiket Gangguan')

@section('content')
<div class="max-w-5xl space-y-5">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center gap-1 text-xs text-slate-400 hover:text-white transition-colors font-mono">
            <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
            <span>Kembali ke Daftar Tiket</span>
        </a>
        <div class="flex items-center gap-2">
            <span class="text-xs px-2.5 py-0.5 rounded-full {{ $ticket->status_badge_class }} font-semibold">
                {{ $ticket->status_label }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <!-- Left 2 Cols: Ticket Detail & Admin Action Form -->
        <div class="lg:col-span-2 space-y-5">
            
            <!-- Issue Info Card -->
            <div class="p-5 rounded-2xl bg-[#081528] border border-white/10 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-mono font-bold text-[#38bdf8] bg-sky-500/10 px-2.5 py-0.5 rounded-md">
                        {{ $ticket->ticket_number }}
                    </span>
                    <span class="text-xs text-slate-400 font-mono">
                        {{ $ticket->created_at->translatedFormat('d M Y, H:i') }} WIB
                    </span>
                </div>

                <div>
                    <h2 class="text-base font-heading font-bold text-white mb-2">{{ $ticket->subject }}</h2>
                    <div class="text-xs text-slate-300 whitespace-pre-line bg-white/[0.03] p-4 rounded-xl border border-white/5 leading-relaxed">
                        {{ $ticket->description }}
                    </div>
                </div>

                @if($ticket->photo_path)
                    <div class="pt-2">
                        <div class="text-[11px] font-mono text-slate-400 mb-1.5">Lampiran Foto Bukti Kendala:</div>
                        <div class="rounded-xl overflow-hidden border border-white/10 max-w-sm">
                            <img src="{{ asset('storage/' . $ticket->photo_path) }}" alt="Bukti Kendala" class="w-full h-auto">
                        </div>
                    </div>
                @endif
            </div>

            <!-- Admin Response / Update Form -->
            <div class="p-5 rounded-2xl bg-[#081528] border border-sky-500/20 space-y-4">
                <div class="text-xs font-mono font-bold uppercase tracking-wider text-[#38bdf8] flex items-center gap-1.5">
                    <iconify-icon icon="solar:pen-new-square-bold"></iconify-icon>
                    <span>Update Penanganan & Status NOC</span>
                </div>

                <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="status" class="block text-xs font-mono font-bold uppercase text-slate-300 mb-1">
                                Status Tiket <span class="text-rose-400">*</span>
                            </label>
                            <select name="status" id="status" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-xs text-white focus:outline-none focus:ring-1 focus:ring-[#38bdf8]">
                                <option value="open" {{ old('status', $ticket->status) === 'open' ? 'selected' : '' }}>Open (Menunggu Verifikasi)</option>
                                <option value="in_progress" {{ old('status', $ticket->status) === 'in_progress' ? 'selected' : '' }}>In Progress (Sedang Ditangani / Teknisi Meluncur)</option>
                                <option value="resolved" {{ old('status', $ticket->status) === 'resolved' ? 'selected' : '' }}>Resolved (Gangguan Telah Selesai)</option>
                                <option value="closed" {{ old('status', $ticket->status) === 'closed' ? 'selected' : '' }}>Closed (Ditutup)</option>
                            </select>
                        </div>

                        <div>
                            <label for="priority" class="block text-xs font-mono font-bold uppercase text-slate-300 mb-1">
                                Prioritas
                            </label>
                            <select name="priority" id="priority" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-xs text-white focus:outline-none focus:ring-1 focus:ring-[#38bdf8]">
                                <option value="low" {{ old('priority', $ticket->priority) === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', $ticket->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority', $ticket->priority) === 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ old('priority', $ticket->priority) === 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="technician_name" class="block text-xs font-mono font-bold uppercase text-slate-300 mb-1">
                            Nama Teknisi / PIC NOC yang Bertugas
                        </label>
                        <input 
                            type="text" 
                            name="technician_name" 
                            id="technician_name" 
                            value="{{ old('technician_name', $ticket->technician_name) }}"
                            placeholder="Contoh: Rian Pratama (Teknisi FO Bekasi)"
                            class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-xs text-white focus:outline-none focus:ring-1 focus:ring-[#38bdf8]"
                        >
                    </div>

                    <div>
                        <label for="resolution_notes" class="block text-xs font-mono font-bold uppercase text-slate-300 mb-1">
                            Catatan Tindakan / Solusi Penyelesaian (Dilihat oleh Pelanggan)
                        </label>
                        <textarea 
                            name="resolution_notes" 
                            id="resolution_notes" 
                            rows="4" 
                            placeholder="Jelaskan tindakan yang telah/sedang dilakukan (misal: Splicing ulang konektor tiang ODP #4, reset konfigurasi VLAN di OLT)..."
                            class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-xs text-white focus:outline-none focus:ring-1 focus:ring-[#38bdf8] resize-none leading-relaxed"
                        >{{ old('resolution_notes', $ticket->resolution_notes) }}</textarea>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <span class="text-[11px] text-slate-400">Status akan langsung diperbarui di portal pelanggan</span>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#38bdf8] hover:bg-white text-[#050d1a] text-xs font-heading font-bold transition-all shadow-md">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Right 1 Col: Customer Info Card -->
        <div class="space-y-4">
            <div class="p-5 rounded-2xl bg-[#081528] border border-white/10 space-y-3 text-xs">
                <div class="font-mono font-bold uppercase tracking-wider text-[#38bdf8]">Data Pelanggan</div>
                
                <div class="space-y-2">
                    <div>
                        <span class="text-slate-400 block text-[10px]">Nama:</span>
                        <span class="font-bold text-white">{{ $ticket->customer->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px]">ID Pelanggan:</span>
                        <span class="font-mono text-sky-400 font-bold">{{ $ticket->customer->customer_id ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px]">No. Telepon / WA:</span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ticket->customer->phone ?? '') }}" target="_blank" class="font-mono text-emerald-400 hover:underline flex items-center gap-1 font-semibold">
                            <iconify-icon icon="solar:chat-round-dots-bold"></iconify-icon>
                            <span>{{ $ticket->customer->phone ?? '-' }}</span>
                        </a>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px]">Paket Langganan:</span>
                        <span class="text-white">{{ $ticket->customer->package->name ?? '-' }} ({{ $ticket->customer->package->speed ?? '-' }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px]">IP Address:</span>
                        <span class="font-mono text-slate-300">{{ $ticket->customer->ip_address ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px]">Alamat Pemasangan:</span>
                        <span class="text-slate-300 leading-relaxed block">{{ $ticket->customer->address ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Delete Ticket -->
            <div class="p-4 rounded-xl bg-rose-500/5 border border-rose-500/20 text-center">
                <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tiket ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 font-semibold flex items-center justify-center gap-1 w-full">
                        <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                        <span>Hapus Tiket Ini</span>
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
