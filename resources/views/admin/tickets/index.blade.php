@extends('admin.layouts.app')

@section('title', 'Tiket Gangguan Pelanggan')
@section('header', 'Manajemen Tiket Gangguan')

@section('content')
<div class="space-y-5">

    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
        <div class="p-4 rounded-xl bg-white/[0.04] border border-white/10 flex items-center justify-between">
            <div>
                <div class="text-[10px] font-mono font-bold uppercase text-slate-400">Total Tiket Masuk</div>
                <div class="text-xl font-heading font-extrabold text-white mt-1">{{ $stats['total'] }}</div>
            </div>
            <div class="w-9 h-9 rounded-lg bg-sky-500/10 border border-sky-500/20 text-[#38bdf8] flex items-center justify-center">
                <iconify-icon icon="solar:ticket-sale-bold" width="18"></iconify-icon>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-white/[0.04] border border-white/10 flex items-center justify-between">
            <div>
                <div class="text-[10px] font-mono font-bold uppercase text-amber-400">Menunggu Verifikasi</div>
                <div class="text-xl font-heading font-extrabold text-amber-400 mt-1">{{ $stats['open'] }}</div>
            </div>
            <div class="w-9 h-9 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center">
                <iconify-icon icon="solar:inbox-in-bold" width="18"></iconify-icon>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-white/[0.04] border border-white/10 flex items-center justify-between">
            <div>
                <div class="text-[10px] font-mono font-bold uppercase text-[#38bdf8]">Sedang Ditangani</div>
                <div class="text-xl font-heading font-extrabold text-[#38bdf8] mt-1">{{ $stats['in_progress'] }}</div>
            </div>
            <div class="w-9 h-9 rounded-lg bg-sky-500/10 border border-sky-500/20 text-[#38bdf8] flex items-center justify-center">
                <iconify-icon icon="solar:wrench-bold" width="18"></iconify-icon>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-white/[0.04] border border-white/10 flex items-center justify-between">
            <div>
                <div class="text-[10px] font-mono font-bold uppercase text-emerald-400">Telah Selesai</div>
                <div class="text-xl font-heading font-extrabold text-emerald-400 mt-1">{{ $stats['resolved'] }}</div>
            </div>
            <div class="w-9 h-9 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center">
                <iconify-icon icon="solar:check-circle-bold" width="18"></iconify-icon>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
            <a href="{{ route('admin.tickets.index') }}" class="px-3 py-1 rounded-lg text-xs font-semibold {{ !request('status') ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 hover:bg-white/[0.05]' }}">
                Semua
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" class="px-3 py-1 rounded-lg text-xs font-semibold {{ request('status') === 'open' ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 hover:bg-white/[0.05]' }}">
                Open ({{ $stats['open'] }})
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'in_progress']) }}" class="px-3 py-1 rounded-lg text-xs font-semibold {{ request('status') === 'in_progress' ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 hover:bg-white/[0.05]' }}">
                In Progress ({{ $stats['in_progress'] }})
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'resolved']) }}" class="px-3 py-1 rounded-lg text-xs font-semibold {{ request('status') === 'resolved' ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 hover:bg-white/[0.05]' }}">
                Resolved ({{ $stats['resolved'] }})
            </a>
        </div>

        <form action="{{ route('admin.tickets.index') }}" method="GET" class="flex items-center gap-2">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full sm:w-64">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari ID tiket, pelanggan, no HP..." 
                    class="w-full pl-8 pr-3 py-1.5 rounded-lg bg-white/[0.06] border border-white/10 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-[#38bdf8]"
                >
                <iconify-icon icon="solar:magnifer-linear" class="absolute left-2.5 top-2 text-slate-400 text-xs"></iconify-icon>
            </div>
            <button type="submit" class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs text-white font-semibold">
                Filter
            </button>
        </form>
    </div>

    <!-- Tickets Table -->
    <div class="rounded-xl border border-white/10 bg-[#081528]/80 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-white/[0.04] text-slate-400 font-mono uppercase text-[10px] tracking-wider border-b border-white/10">
                    <tr>
                        <th class="py-3 px-4">No. Tiket</th>
                        <th class="py-3 px-4">Pelanggan</th>
                        <th class="py-3 px-4">Kategori & Kendala</th>
                        <th class="py-3 px-4">Prioritas</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Teknisi Bertugas</th>
                        <th class="py-3 px-4">Waktu Lapor</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-slate-300">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-[#38bdf8]">
                                {{ $ticket->ticket_number }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-white">{{ $ticket->customer->name ?? '-' }}</div>
                                <div class="text-[10px] font-mono text-slate-400">{{ $ticket->customer->phone ?? '-' }} ({{ $ticket->customer->customer_id ?? '-' }})</div>
                            </td>
                            <td class="py-3 px-4 max-w-xs">
                                <div class="font-semibold text-white truncate">{{ $ticket->subject }}</div>
                                <div class="text-[10px] text-slate-400">{{ $ticket->category_label }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono uppercase font-bold {{ $ticket->priority === 'urgent' ? 'bg-rose-500/20 text-rose-300' : ($ticket->priority === 'high' ? 'bg-amber-500/20 text-amber-300' : 'bg-slate-500/20 text-slate-300') }}">
                                    {{ $ticket->priority }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $ticket->status_badge_class }}">
                                    {{ $ticket->status_label }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-xs">
                                {{ $ticket->technician_name ?? '—' }}
                            </td>
                            <td class="py-3 px-4 text-[11px] font-mono text-slate-400">
                                {{ $ticket->created_at->diffForHumans() }}
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="p-1.5 rounded-lg bg-sky-500/10 hover:bg-sky-500/20 text-[#38bdf8] transition-colors" title="Lihat & Tangani">
                                        <iconify-icon icon="solar:pen-bold" width="14"></iconify-icon>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-500">
                                Tidak ada data tiket gangguan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 border-t border-white/10">
            {{ $tickets->links() }}
        </div>
    </div>

</div>
@endsection
