@extends('portal.layouts.app')

@section('title', 'Daftar Laporan Gangguan')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 text-xs font-mono font-bold text-[#38bdf8] uppercase tracking-wider mb-1">
                <iconify-icon icon="solar:shield-warning-bold"></iconify-icon>
                <span>LAYANAN PENGADUAN</span>
            </div>
            <h1 class="text-2xl font-heading font-extrabold text-white tracking-tight">Daftar Laporan Gangguan</h1>
            <p class="text-xs sm:text-sm text-slate-400">Pantau tiket pengaduan teknis dan riwayat perbaikan koneksi internet Anda</p>
        </div>

        <a href="{{ route('portal.tickets.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-rose-500 to-amber-500 hover:from-rose-600 hover:to-amber-600 text-white font-heading font-bold text-xs sm:text-sm shadow-lg shadow-rose-500/25 hover:scale-105 active:scale-95 transition-all self-start sm:self-auto">
            <iconify-icon icon="solar:danger-triangle-bold" width="18"></iconify-icon>
            <span>Buat Laporan Baru</span>
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="portal-card rounded-2xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-1 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
            <a href="{{ route('portal.tickets.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold whitespace-nowrap transition-all {{ !request('status') ? 'bg-[#38bdf8] text-[#050d1a] font-bold shadow-sm' : 'text-slate-300 hover:bg-white/[0.06]' }}">
                Semua
            </a>
            <a href="{{ route('portal.tickets.index', ['status' => 'open']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold whitespace-nowrap transition-all {{ request('status') === 'open' ? 'bg-[#38bdf8] text-[#050d1a] font-bold shadow-sm' : 'text-slate-300 hover:bg-white/[0.06]' }}">
                Menunggu Verifikasi
            </a>
            <a href="{{ route('portal.tickets.index', ['status' => 'in_progress']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold whitespace-nowrap transition-all {{ request('status') === 'in_progress' ? 'bg-[#38bdf8] text-[#050d1a] font-bold shadow-sm' : 'text-slate-300 hover:bg-white/[0.06]' }}">
                Sedang Ditangani
            </a>
            <a href="{{ route('portal.tickets.index', ['status' => 'resolved']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold whitespace-nowrap transition-all {{ request('status') === 'resolved' ? 'bg-[#38bdf8] text-[#050d1a] font-bold shadow-sm' : 'text-slate-300 hover:bg-white/[0.06]' }}">
                Selesai
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('portal.tickets.index') }}" method="GET" class="flex items-center gap-2">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full sm:w-64">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nomor tiket / kendala..." 
                    class="w-full pl-9 pr-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-[#38bdf8]"
                >
                <iconify-icon icon="solar:magnifer-linear" class="absolute left-3 top-2.5 text-slate-400 text-sm pointer-events-none"></iconify-icon>
            </div>
            @if(request('search'))
                <a href="{{ route('portal.tickets.index', request()->only('status')) }}" class="p-2 rounded-xl bg-white/[0.06] text-slate-400 hover:text-white" title="Reset pencarian">
                    <iconify-icon icon="solar:close-circle-bold" width="16"></iconify-icon>
                </a>
            @endif
        </form>

    </div>

    <!-- Tickets List -->
    @if($tickets->count() > 0)
        <div class="space-y-3">
            @foreach($tickets as $ticket)
                <a href="{{ route('portal.tickets.show', $ticket->id) }}" class="portal-card portal-card-hover rounded-2xl p-5 block group">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-2 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-xs font-mono font-bold text-[#38bdf8] bg-sky-500/10 border border-sky-500/20 px-2.5 py-0.5 rounded-lg">
                                    {{ $ticket->ticket_number }}
                                </span>
                                <span class="text-xs px-2.5 py-0.5 rounded-full {{ $ticket->status_badge_class }} font-semibold">
                                    {{ $ticket->status_label }}
                                </span>
                                <span class="text-xs px-2.5 py-0.5 rounded-full bg-white/[0.05] text-slate-300 border border-white/10">
                                    {{ $ticket->category_label }}
                                </span>
                                <span class="text-xs text-slate-400 font-mono">
                                    {{ $ticket->created_at->translatedFormat('d M Y, H:i') }} WIB
                                </span>
                            </div>

                            <h3 class="text-base font-heading font-bold text-white group-hover:text-[#38bdf8] transition-colors">
                                {{ $ticket->subject }}
                            </h3>

                            <p class="text-xs text-slate-400 line-clamp-2">
                                {{ $ticket->description }}
                            </p>
                        </div>

                        <!-- Right Info & Action -->
                        <div class="flex items-center justify-between md:justify-end gap-4 pt-3 md:pt-0 border-t md:border-t-0 border-white/10">
                            @if($ticket->technician_name)
                                <div class="text-left md:text-right">
                                    <div class="text-[10px] font-mono text-slate-400">Teknisi Penanggung Jawab:</div>
                                    <div class="text-xs text-slate-200 font-semibold flex items-center md:justify-end gap-1">
                                        <iconify-icon icon="solar:user-hand-up-bold" class="text-sky-400"></iconify-icon>
                                        <span>{{ $ticket->technician_name }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center gap-2 text-xs font-heading font-bold text-[#38bdf8] group-hover:translate-x-1 transition-transform">
                                <span>Lihat Progres</span>
                                <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $tickets->links() }}
        </div>
    @else
        <div class="portal-card rounded-2xl p-12 text-center space-y-4">
            <div class="w-16 h-16 rounded-3xl bg-white/[0.04] border border-white/10 text-slate-400 mx-auto flex items-center justify-center">
                <iconify-icon icon="solar:ticket-sale-linear" width="32"></iconify-icon>
            </div>
            <div>
                <h3 class="text-base font-heading font-bold text-white">Tidak Ada Laporan Ditemukan</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                    {{ request('status') ? 'Tidak ada tiket dengan filter status yang dipilih.' : 'Belum ada tiket pengaduan gangguan yang dibuat.' }}
                </p>
            </div>
            <div class="pt-2">
                <a href="{{ route('portal.tickets.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#38bdf8] text-[#050d1a] font-heading font-bold text-xs hover:bg-white transition-all shadow-md">
                    <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
                    <span>Buat Laporan Baru Sekarang</span>
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
