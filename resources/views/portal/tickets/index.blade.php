@extends('portal.layouts.app')

@section('title', 'Daftar Laporan Gangguan')

@section('content')
<div class="space-y-3.5 sm:space-y-6">

    <!-- Header Section -->
    <div class="flex items-center justify-between gap-2.5 sm:gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 text-[10px] sm:text-xs font-mono font-bold text-sky-700 uppercase tracking-wider mb-0.5">
                <iconify-icon icon="solar:shield-warning-bold"></iconify-icon>
                <span>LAYANAN PENGADUAN & TIKET NOC</span>
            </div>
            <h1 class="text-lg sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">Daftar Laporan Gangguan</h1>
            <p class="hidden sm:block text-xs sm:text-sm text-slate-600 mt-0.5">Pantau tiket pengaduan teknis dan riwayat perbaikan koneksi internet Anda</p>
        </div>

        <a href="{{ route('portal.tickets.create') }}" class="btn-network-action inline-flex items-center justify-center gap-1.5 px-3 py-1.5 sm:px-5 sm:py-3 rounded-xl sm:rounded-2xl font-heading font-bold text-xs sm:text-sm shadow-md shrink-0">
            <iconify-icon icon="solar:danger-triangle-bold" width="15" class="sm:w-[18px] shrink-0 text-amber-300"></iconify-icon>
            <span class="hidden sm:inline">Buat Laporan Baru</span>
            <span class="sm:hidden">+ Lapor Baru</span>
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="portal-card rounded-2xl sm:rounded-3xl p-2.5 sm:p-4 flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-4">
        
        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-1 overflow-x-auto pb-0.5 md:pb-0 scrollbar-none bg-slate-100/80 p-1 rounded-xl sm:rounded-2xl border border-slate-200/60">
            <a href="{{ route('portal.tickets.index') }}" class="px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-heading font-semibold whitespace-nowrap transition-all {{ !request('status') ? 'bg-white text-sky-700 font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Semua
            </a>
            <a href="{{ route('portal.tickets.index', ['status' => 'open']) }}" class="px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-heading font-semibold whitespace-nowrap transition-all {{ request('status') === 'open' ? 'bg-white text-sky-700 font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Menunggu Verifikasi
            </a>
            <a href="{{ route('portal.tickets.index', ['status' => 'in_progress']) }}" class="px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-heading font-semibold whitespace-nowrap transition-all {{ request('status') === 'in_progress' ? 'bg-white text-sky-700 font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Sedang Ditangani
            </a>
            <a href="{{ route('portal.tickets.index', ['status' => 'resolved']) }}" class="px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-heading font-semibold whitespace-nowrap transition-all {{ request('status') === 'resolved' ? 'bg-white text-sky-700 font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Selesai
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('portal.tickets.index') }}" method="GET" class="flex items-center gap-1.5">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full sm:w-64">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari tiket / kendala..." 
                    class="w-full pl-8 sm:pl-9 pr-3 py-1.5 sm:py-2 rounded-xl sm:rounded-2xl bg-white/80 border border-slate-300 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-2xs"
                >
                <iconify-icon icon="solar:magnifer-linear" class="absolute left-2.5 top-2 sm:left-3 sm:top-2.5 text-slate-400 text-xs sm:text-sm pointer-events-none"></iconify-icon>
            </div>
            @if(request('search'))
                <a href="{{ route('portal.tickets.index', request()->only('status')) }}" class="p-1.5 sm:p-2 rounded-xl sm:rounded-2xl bg-white border border-slate-200 text-slate-400 hover:text-slate-700 shadow-2xs" title="Reset pencarian">
                    <iconify-icon icon="solar:close-circle-bold" width="15"></iconify-icon>
                </a>
            @endif
        </form>

    </div>

    <!-- Tickets List -->
    @if($tickets->count() > 0)
        <div class="space-y-2 sm:space-y-3">
            @foreach($tickets as $ticket)
                <a href="{{ route('portal.tickets.show', $ticket->id) }}" class="portal-card portal-card-hover rounded-xl sm:rounded-3xl p-3 sm:p-5 block group">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-4">
                        <div class="space-y-1 sm:space-y-2 flex-1">
                            <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                <span class="text-[10px] sm:text-xs font-mono font-bold text-sky-700 bg-sky-50 border border-sky-200 px-2 py-0.5 rounded-lg">
                                    #{{ $ticket->ticket_number }}
                                </span>
                                <span class="text-[10px] sm:text-xs px-2.5 py-0.5 rounded-full {{ $ticket->status_badge_class }} font-semibold">
                                    {{ $ticket->status_label }}
                                </span>
                                <span class="text-[10px] sm:text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $ticket->category_label }}
                                </span>
                                <span class="text-[10px] sm:text-xs text-slate-400 font-mono">
                                    {{ $ticket->created_at->translatedFormat('d M Y, H:i') }} WIB
                                </span>
                            </div>

                            <h3 class="text-xs sm:text-base font-heading font-bold text-slate-900 group-hover:text-sky-600 transition-colors">
                                {{ $ticket->subject }}
                            </h3>

                            <p class="text-[11px] sm:text-xs text-slate-600 line-clamp-1 sm:line-clamp-2 leading-relaxed">
                                {{ $ticket->description }}
                            </p>
                        </div>

                        <!-- Right Info & Action -->
                        <div class="flex items-center justify-between md:justify-end gap-3 pt-2 md:pt-0 border-t md:border-t-0 border-slate-100">
                            @if($ticket->technician_name)
                                <div class="text-left md:text-right">
                                    <div class="text-[9px] sm:text-[10px] font-mono text-slate-400">Teknisi:</div>
                                    <div class="text-xs text-slate-700 font-semibold flex items-center md:justify-end gap-1">
                                        <iconify-icon icon="solar:user-hand-up-bold" class="text-sky-500"></iconify-icon>
                                        <span>{{ $ticket->technician_name }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center gap-1 text-xs font-heading font-bold text-sky-600 group-hover:translate-x-1 transition-transform ml-auto md:ml-0">
                                <span>Lihat Progres</span>
                                <iconify-icon icon="solar:arrow-right-linear" width="14"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pt-3">
            {{ $tickets->links() }}
        </div>
    @else
        <!-- Compact Empty State on Mobile -->
        <div class="portal-card rounded-2xl sm:rounded-3xl p-6 sm:p-12 text-center space-y-3 sm:space-y-4">
            <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl sm:rounded-3xl bg-sky-50 border border-sky-200 text-sky-600 mx-auto flex items-center justify-center shadow-xs">
                <iconify-icon icon="solar:ticket-sale-linear" width="24" class="sm:w-[32px] sm:h-[32px]"></iconify-icon>
            </div>
            <div>
                <h3 class="text-sm sm:text-base font-heading font-bold text-slate-900">Tidak Ada Laporan Ditemukan</h3>
                <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5 max-w-sm mx-auto">
                    {{ request('status') ? 'Tidak ada tiket dengan filter status yang dipilih.' : 'Belum ada tiket pengaduan gangguan yang dibuat.' }}
                </p>
            </div>
            <div class="pt-1">
                <a href="{{ route('portal.tickets.create') }}" class="btn-network-action inline-flex items-center gap-1.5 px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl sm:rounded-2xl font-heading font-bold text-xs shadow-md">
                    <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
                    <span>Buat Laporan Baru</span>
                </a>
            </div>
        </div>
    @endif

</div>
@endsection

