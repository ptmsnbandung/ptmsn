@extends('portal.layouts.app')

@section('title', 'Daftar Laporan Gangguan & Layanan')

@section('content')
<!-- Full-Width Dark Oceanic Blue Hero Backdrop -->
<div class="-mx-3 sm:-mx-6 lg:-mx-8 -mt-3 sm:-mt-6 px-4 sm:px-6 lg:px-8 pt-5 sm:pt-7 pb-20 sm:pb-24 hero-network-card !rounded-none !border-x-0 !border-t-0 shadow-md relative overflow-hidden">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-3 relative z-10">
        <div class="space-y-1">
            <div class="flex items-center gap-1.5 text-[11px] font-mono text-cyan-300 font-medium">
                <a href="{{ route('portal.dashboard') }}" class="hover:text-white transition-colors">Portal</a>
                <span class="text-cyan-400/60">/</span>
                <span class="text-cyan-300 font-bold">Laporan & Tiket</span>
            </div>
            <h1 class="text-lg sm:text-2xl font-heading font-extrabold text-white tracking-tight">
                Daftar Tiket & Layanan
            </h1>
            <p class="text-xs text-slate-300">Pantau progres pengaduan teknis, ubah paket, suspend, dan riwayat perbaikan koneksi Anda.</p>
        </div>

        <a id="tour-step-create-ticket" href="{{ route('portal.tickets.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 sm:px-5 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 hover:from-sky-600 hover:to-indigo-700 text-white font-heading font-extrabold text-xs sm:text-sm shadow-lg shadow-sky-500/25 border border-white/20 active:scale-95 transition-all shrink-0 self-start sm:self-center cursor-pointer">
            <iconify-icon icon="solar:add-circle-bold" width="18" class="shrink-0 text-amber-300"></iconify-icon>
            <span class="text-white">Buat Laporan Baru</span>
        </a>
    </div>
</div>

<!-- Main Content Container Overlapping the Blue Backdrop -->
<div class="-mt-14 sm:-mt-16 relative z-10 space-y-3.5 sm:space-y-5 max-w-7xl mx-auto">

    <!-- Tour Target: Filter Header & 1 Ticket Data (or Empty State) -->
    <div id="tour-step-tickets-list" class="space-y-3.5 sm:space-y-5">
        
        <!-- Filter & Search Bar -->
        <div class="portal-card rounded-2xl sm:rounded-3xl p-2.5 sm:p-4 flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-4 shadow-sm border border-slate-200/80 bg-white/95 backdrop-blur-md">
            
            <!-- Status Filter Tabs (Scrollable on Mobile without scrollbars) -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-0.5 md:pb-0 scrollbar-none no-scrollbar bg-slate-100/90 p-1.5 rounded-xl sm:rounded-2xl border border-slate-200/80 shadow-inner" style="-webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none;">
                <a href="{{ route('portal.tickets.index') }}" class="px-3 sm:px-4 py-1.5 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-heading font-bold whitespace-nowrap transition-all flex items-center gap-1.5 {{ !request('status') ? 'bg-white text-sky-800 shadow-sm border border-slate-200/70' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }}">
                    <iconify-icon icon="solar:layers-bold-duotone" class="text-xs sm:text-sm {{ !request('status') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                    <span>Semua</span>
                </a>
                <a href="{{ route('portal.tickets.index', ['status' => 'open']) }}" class="px-3 sm:px-4 py-1.5 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-heading font-bold whitespace-nowrap transition-all flex items-center gap-1.5 {{ request('status') === 'open' ? 'bg-white text-amber-800 shadow-sm border border-amber-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }}">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                    </span>
                    <span>Menunggu Verifikasi</span>
                </a>
                <a href="{{ route('portal.tickets.index', ['status' => 'in_progress']) }}" class="px-3 sm:px-4 py-1.5 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-heading font-bold whitespace-nowrap transition-all flex items-center gap-1.5 {{ request('status') === 'in_progress' ? 'bg-white text-sky-800 shadow-sm border border-sky-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }}">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-500"></span>
                    </span>
                    <span>Sedang Ditangani</span>
                </a>
                <a href="{{ route('portal.tickets.index', ['status' => 'resolved']) }}" class="px-3 sm:px-4 py-1.5 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-heading font-bold whitespace-nowrap transition-all flex items-center gap-1.5 {{ request('status') === 'resolved' ? 'bg-white text-emerald-800 shadow-sm border border-emerald-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }}">
                    <span class="inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    <span>Selesai</span>
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('portal.tickets.index') }}" method="GET" class="flex items-center gap-1.5">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="relative w-full sm:w-72">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari tiket / topik kendala..." 
                        class="w-full pl-8 sm:pl-9 pr-8 py-2 rounded-xl sm:rounded-2xl bg-slate-50/90 hover:bg-white focus:bg-white border border-slate-200 focus:border-sky-400 text-xs text-slate-800 placeholder-slate-400 focus:outline-none transition-all shadow-2xs"
                    >
                    <iconify-icon icon="solar:magnifer-linear" class="absolute left-2.5 top-2.5 text-slate-400 text-xs sm:text-sm pointer-events-none"></iconify-icon>
                    @if(request('search'))
                        <a href="{{ route('portal.tickets.index', request()->only('status')) }}" class="absolute right-2.5 top-2 text-slate-400 hover:text-slate-700" title="Reset pencarian">
                            <iconify-icon icon="solar:close-circle-bold" width="16"></iconify-icon>
                        </a>
                    @endif
                </div>
            </form>

        </div>

        <!-- First Ticket Item (1 Data Saja Diperlihatkan di Tour Highlight) -->
        @if($tickets->count() > 0)
            @php $firstTicket = $tickets->first(); @endphp
            <a href="{{ route('portal.tickets.show', $firstTicket->id) }}" class="portal-card portal-card-hover rounded-2xl sm:rounded-3xl p-4 sm:p-5.5 block group overflow-hidden border border-slate-200/85 bg-white/95 transition-all shadow-sm hover:shadow-md hover:border-sky-300">
                <div class="space-y-3">
                    
                    <!-- Row 1: Nomor Tiket & Kategori (Kiri) vs Status Pill (Kanan) -->
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                        <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap min-w-0">
                            <!-- Nomor Tiket Pill -->
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-sky-50 border border-sky-200/80 text-sky-700 font-mono text-[11px] sm:text-xs font-extrabold shrink-0 shadow-2xs">
                                <iconify-icon icon="solar:hashtag-bold" class="text-xs text-sky-500"></iconify-icon>
                                <span>#{{ $firstTicket->ticket_number }}</span>
                            </span>

                            <!-- Kategori Pill -->
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100/90 border border-slate-200 text-slate-700 text-[11px] sm:text-xs font-heading font-semibold shrink-0">
                                <span>{{ $firstTicket->category_label }}</span>
                            </span>
                        </div>

                        <!-- Status Badge Pill (Kanan) -->
                        <div class="shrink-0">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] sm:text-xs font-heading font-bold {{ $firstTicket->status_badge_class }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-80"></span>
                                <span>{{ $firstTicket->status_label }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Row 2: Waktu Pembuatan Tiket -->
                    <div class="flex items-center gap-1.5 text-[11px] font-mono text-slate-400">
                        <iconify-icon icon="solar:clock-circle-bold" class="text-xs text-slate-400 shrink-0"></iconify-icon>
                        <span>{{ $firstTicket->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                    </div>

                    <!-- Row 3: Judul & Deskripsi Singkat -->
                    <div class="space-y-1">
                        <h3 class="text-xs sm:text-base font-heading font-extrabold text-slate-900 group-hover:text-sky-600 transition-colors leading-snug">
                            {{ $firstTicket->subject }}
                        </h3>
                        <p class="text-[11px] sm:text-xs text-slate-600 line-clamp-2 leading-relaxed font-sans">
                            {{ $firstTicket->description }}
                        </p>
                    </div>

                    <!-- Row 4: Footer Info Teknisi & Aksi -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2 flex-wrap">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            @if($firstTicket->technician_name)
                                <div class="w-5 h-5 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 text-[10px]">
                                    <iconify-icon icon="solar:user-hand-up-bold"></iconify-icon>
                                </div>
                                <span class="text-[11px] text-slate-600 font-medium">
                                    Teknisi: <strong class="text-slate-800 font-semibold">{{ $firstTicket->technician_name }}</strong>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[11px] text-slate-400">
                                    <iconify-icon icon="solar:info-circle-bold" class="text-xs"></iconify-icon>
                                    <span>Menunggu penugasan tim teknisi</span>
                                </span>
                            @endif
                        </div>

                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 group-hover:bg-sky-600 text-sky-600 group-hover:text-white text-xs font-heading font-bold transition-all shadow-2xs">
                            <span>Lihat Progres</span>
                            <iconify-icon icon="solar:alt-arrow-right-bold" class="text-xs group-hover:translate-x-0.5 transition-transform"></iconify-icon>
                        </div>
                    </div>

                </div>
            </a>
        @else
            <!-- Compact Empty State on Mobile -->
            <div class="portal-card rounded-2xl sm:rounded-3xl p-6 sm:p-12 text-center space-y-3 sm:space-y-4 border border-slate-200/80 bg-white/95">
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
                    <a href="{{ route('portal.tickets.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 hover:from-sky-600 hover:to-indigo-700 text-white font-heading font-extrabold text-xs shadow-md shadow-sky-500/20 active:scale-95 transition-all">
                        <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
                        <span>Buat Laporan Baru</span>
                    </a>
                </div>
            </div>
        @endif

    </div>

    <!-- Remaining Tickets List (Outside Tour Highlight) -->
    @if($tickets->count() > 1)
        <div class="space-y-2.5 sm:space-y-3">
            @foreach($tickets->slice(1) as $ticket)
                <a href="{{ route('portal.tickets.show', $ticket->id) }}" class="portal-card portal-card-hover rounded-2xl sm:rounded-3xl p-4 sm:p-5.5 block group overflow-hidden border border-slate-200/85 bg-white/95 transition-all shadow-sm hover:shadow-md hover:border-sky-300">
                    <div class="space-y-3">
                        
                        <!-- Row 1: Nomor Tiket & Kategori (Kiri) vs Status Pill (Kanan) -->
                        <div class="flex items-center justify-between gap-2 flex-wrap">
                            <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap min-w-0">
                                <!-- Nomor Tiket Pill -->
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-sky-50 border border-sky-200/80 text-sky-700 font-mono text-[11px] sm:text-xs font-extrabold shrink-0 shadow-2xs">
                                    <iconify-icon icon="solar:hashtag-bold" class="text-xs text-sky-500"></iconify-icon>
                                    <span>#{{ $ticket->ticket_number }}</span>
                                </span>

                                <!-- Kategori Pill -->
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100/90 border border-slate-200 text-slate-700 text-[11px] sm:text-xs font-heading font-semibold shrink-0">
                                    <span>{{ $ticket->category_label }}</span>
                                </span>
                            </div>

                            <!-- Status Badge Pill (Kanan) -->
                            <div class="shrink-0">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] sm:text-xs font-heading font-bold {{ $ticket->status_badge_class }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-80"></span>
                                    <span>{{ $ticket->status_label }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Row 2: Waktu Pembuatan Tiket -->
                        <div class="flex items-center gap-1.5 text-[11px] font-mono text-slate-400">
                            <iconify-icon icon="solar:clock-circle-bold" class="text-xs text-slate-400 shrink-0"></iconify-icon>
                            <span>{{ $ticket->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                        </div>

                        <!-- Row 3: Judul & Deskripsi Singkat -->
                        <div class="space-y-1">
                            <h3 class="text-xs sm:text-base font-heading font-extrabold text-slate-900 group-hover:text-sky-600 transition-colors leading-snug">
                                {{ $ticket->subject }}
                            </h3>
                            <p class="text-[11px] sm:text-xs text-slate-600 line-clamp-2 leading-relaxed font-sans">
                                {{ $ticket->description }}
                            </p>
                        </div>

                        <!-- Row 4: Footer Info Teknisi & Aksi -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2 flex-wrap">
                            <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                @if($ticket->technician_name)
                                    <div class="w-5 h-5 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 text-[10px]">
                                        <iconify-icon icon="solar:user-hand-up-bold"></iconify-icon>
                                    </div>
                                    <span class="text-[11px] text-slate-600 font-medium">
                                        Teknisi: <strong class="text-slate-800 font-semibold">{{ $ticket->technician_name }}</strong>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] text-slate-400">
                                        <iconify-icon icon="solar:info-circle-bold" class="text-xs"></iconify-icon>
                                        <span>Menunggu penugasan tim teknisi</span>
                                    </span>
                                @endif
                            </div>

                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 group-hover:bg-sky-600 text-sky-600 group-hover:text-white text-xs font-heading font-bold transition-all shadow-2xs">
                                <span>Lihat Progres</span>
                                <iconify-icon icon="solar:alt-arrow-right-bold" class="text-xs group-hover:translate-x-0.5 transition-transform"></iconify-icon>
                            </div>
                        </div>

                    </div>
                </a>
            @endforeach
        </div>
    @endif

    @if($tickets->count() > 0)
        <div class="pt-3">
            {{ $tickets->links() }}
        </div>
    @endif

</div>
@endsection


