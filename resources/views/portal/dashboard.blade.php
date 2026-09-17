@extends('portal.layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="space-y-3.5 sm:space-y-6">

    <!-- Welcome Hero Banner (Compact on Mobile) -->
    <div class="portal-card rounded-2xl sm:rounded-3xl p-4 sm:p-7 relative overflow-hidden">
        <!-- Ambient Glow -->
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-sky-200/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-indigo-100/50 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-6">
            <div class="space-y-1.5 sm:space-y-2">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="px-2.5 py-0.5 rounded-lg bg-white/90 border border-slate-200/80 text-slate-700 font-mono text-[11px] sm:text-xs font-bold shadow-xs">
                        ID: {{ $customer->customer_id }}
                    </span>
                    @if($customer->status === 'active')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] sm:text-xs font-semibold shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Koneksi Aktif</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-[11px] sm:text-xs font-semibold shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            <span>Status: {{ ucfirst($customer->status) }}</span>
                        </span>
                    @endif
                </div>

                <h1 class="text-xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight leading-tight">
                    Halo, {{ $customer->name }}! 👋
                </h1>
                <p class="hidden sm:block text-xs sm:text-sm text-slate-600 max-w-2xl leading-relaxed">
                    Selamat datang di Portal Pelanggan PT Media Solusi Network. Pantau performa internet Anda atau laporkan kendala jaringan langsung ke tim NOC kami.
                </p>
                <p class="sm:hidden text-xs text-slate-500">
                    Pantau internet dan rincian layanan Anda secara real-time.
                </p>
            </div>

            <!-- Quick Action Buttons on Hero (2-Columns on Mobile for Compactness) -->
            <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center sm:gap-3 shrink-0 pt-1 sm:pt-0">
                <a href="{{ route('portal.tickets.create') }}" class="inline-flex items-center justify-center gap-1.5 px-3 sm:px-5 py-2.5 sm:py-3.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-bold text-xs sm:text-sm shadow-md shadow-sky-500/25 hover:scale-105 active:scale-95 transition-all text-center">
                    <iconify-icon icon="solar:danger-triangle-bold" width="16" class="shrink-0"></iconify-icon>
                    <span>Lapor Gangguan</span>
                </a>
                <a href="https://wa.me/6281214878436?text=Halo%20NOC%20PT%20MSN,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20ingin%20konsultasi" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-3 sm:px-4 py-2.5 sm:py-3.5 rounded-xl sm:rounded-2xl bg-white/90 hover:bg-white border border-slate-200 text-slate-800 font-heading font-semibold text-xs sm:text-sm shadow-xs hover:shadow transition-all text-center">
                    <iconify-icon icon="solar:chat-round-dots-bold" class="text-emerald-500 shrink-0" width="16"></iconify-icon>
                    <span>Hubungi NOC</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Status Cards Grid (Dense 2-Columns on Mobile) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-4">
        
        <!-- Card 1: Paket Internet -->
        <div class="portal-card rounded-2xl p-3 sm:p-5 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-400">Paket</span>
                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl sm:rounded-2xl bg-sky-100/80 border border-sky-200 text-sky-600 flex items-center justify-center shadow-xs shrink-0">
                    <iconify-icon icon="solar:bolt-circle-bold" width="16" class="sm:text-xl"></iconify-icon>
                </div>
            </div>
            <div>
                <div class="text-sm sm:text-lg font-heading font-extrabold text-slate-900 truncate" title="{{ $customer->package->name ?? 'Broadband FTTH' }}">
                    {{ $customer->package->name ?? 'Broadband FTTH' }}
                </div>
                <div class="text-xs sm:text-sm font-mono text-sky-600 font-bold mt-0.5">
                    {{ $customer->package->speed ?? '25 Mbps' }}
                </div>
                <div class="text-[10px] sm:text-[11px] text-slate-500 mt-1.5 flex items-center gap-1">
                    <iconify-icon icon="solar:check-circle-bold" class="text-emerald-500 shrink-0"></iconify-icon>
                    <span>Tanpa FUP</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Status Tagihan -->
        <div class="portal-card rounded-2xl p-3 sm:p-5 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-400">Tagihan</span>
                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl sm:rounded-2xl bg-emerald-100/80 border border-emerald-200 text-emerald-600 flex items-center justify-center shadow-xs shrink-0">
                    <iconify-icon icon="solar:wallet-money-bold" width="16" class="sm:text-xl"></iconify-icon>
                </div>
            </div>
            <div>
                <div class="text-sm sm:text-lg font-heading font-extrabold text-slate-900 truncate">
                    Rp {{ number_format($customer->billing_amount, 0, ',', '.') }}
                </div>
                <div class="text-[10px] sm:text-xs text-slate-500 mt-0.5">
                    Tempo: Tgl {{ $customer->due_date }} / bln
                </div>
                <div class="text-[10px] sm:text-[11px] mt-1.5 flex items-center justify-between gap-1">
                    @if($customer->billing_status === 'paid')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-semibold font-mono text-[10px]">
                            <iconify-icon icon="solar:check-read-linear"></iconify-icon>
                            <span>Lunas</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-1.5 sm:px-2 py-0.5 rounded-full bg-rose-50 border border-rose-200 text-rose-700 font-semibold font-mono text-[9px] sm:text-[10px] truncate">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                            <span>Menunggu</span>
                        </span>
                    @endif
                    <a href="{{ route('portal.billing.index') }}" class="text-sky-600 hover:text-sky-700 font-heading font-bold text-[11px] hover:underline flex items-center shrink-0">
                        <span>Bayar</span>
                        <iconify-icon icon="solar:alt-arrow-right-linear"></iconify-icon>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: Tiket Gangguan Aktif -->
        <div class="portal-card rounded-2xl p-3 sm:p-5 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-400">Tiket Kendala</span>
                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl sm:rounded-2xl bg-amber-100/80 border border-amber-200 text-amber-600 flex items-center justify-center shadow-xs shrink-0">
                    <iconify-icon icon="solar:shield-warning-bold" width="16" class="sm:text-xl"></iconify-icon>
                </div>
            </div>
            <div>
                <div class="text-xl sm:text-2xl font-heading font-extrabold text-slate-900">
                    {{ $activeTicketsCount }}
                </div>
                <div class="text-[10px] sm:text-xs text-slate-500 mt-0.5 truncate">
                    {{ $activeTicketsCount > 0 ? 'Sedang diproses' : 'Normal / Nihil' }}
                </div>
                <div class="text-[10px] sm:text-[11px] text-slate-500 mt-1.5">
                    Selesai: <span class="text-emerald-600 font-bold font-mono">{{ $resolvedTicketsCount }} tiket</span>
                </div>
            </div>
        </div>

        <!-- Card 4: IP & Alamat Pemasangan -->
        <div class="portal-card rounded-2xl p-3 sm:p-5 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-400">Jaringan</span>
                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl sm:rounded-2xl bg-purple-100/80 border border-purple-200 text-purple-600 flex items-center justify-center shadow-xs shrink-0">
                    <iconify-icon icon="solar:map-point-wave-bold" width="16" class="sm:text-xl"></iconify-icon>
                </div>
            </div>
            <div>
                <div class="text-[11px] sm:text-xs font-mono font-bold text-sky-600 truncate">
                    {{ $customer->ip_address ?? '10.20.104.22' }}
                </div>
                <div class="text-[10px] sm:text-xs text-slate-600 mt-0.5 truncate">
                    {{ $customer->city ?? 'Bekasi' }} — GPON
                </div>
                <div class="text-[10px] sm:text-[11px] text-slate-500 mt-1.5 flex items-center gap-1">
                    <iconify-icon icon="solar:server-path-bold" class="text-sky-500 shrink-0"></iconify-icon>
                    <span>Fiber Optic</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Main Content Section: Recent Tickets & Troubleshooting Guide -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3.5 sm:gap-6">
        
        <!-- Left 2 Cols: Recent Trouble Tickets -->
        <div class="lg:col-span-2 space-y-3 sm:space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <iconify-icon icon="solar:ticket-sale-bold" class="text-sky-600 text-base sm:text-lg"></iconify-icon>
                    <h2 class="text-sm sm:text-lg font-heading font-bold text-slate-900">Riwayat Laporan Kendala</h2>
                </div>
                <a href="{{ route('portal.tickets.index') }}" class="text-[11px] sm:text-xs font-heading font-semibold text-sky-600 hover:text-sky-700 hover:underline flex items-center gap-0.5 sm:gap-1">
                    <span>Lihat Semua</span>
                    <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
                </a>
            </div>

            @if($recentTickets->count() > 0)
                <div class="space-y-2.5 sm:space-y-3">
                    @foreach($recentTickets as $ticket)
                        <a href="{{ route('portal.tickets.show', $ticket->id) }}" class="portal-card portal-card-hover rounded-xl sm:rounded-2xl p-3 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-4 block group">
                            <div class="space-y-1 sm:space-y-1.5 flex-1">
                                <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                    <span class="text-[10px] sm:text-xs font-mono font-bold text-sky-700 bg-sky-50 border border-sky-200 px-1.5 py-0.5 rounded-md sm:rounded-lg">
                                        #{{ $ticket->ticket_number }}
                                    </span>
                                    <span class="text-[10px] sm:text-[11px] font-sans px-2 py-0.5 rounded-full {{ $ticket->status_badge_class }} font-semibold">
                                        {{ $ticket->status_label }}
                                    </span>
                                    <span class="text-[10px] sm:text-[11px] font-sans px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $ticket->category_label }}
                                    </span>
                                    <span class="text-[10px] sm:text-[11px] text-slate-400 font-mono">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h3 class="text-xs sm:text-base font-heading font-bold text-slate-900 group-hover:text-sky-600 transition-colors line-clamp-1">
                                    {{ $ticket->subject }}
                                </h3>
                                <p class="text-[11px] sm:text-xs text-slate-500 line-clamp-1">
                                    {{ $ticket->description }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-2 shrink-0 pt-1.5 sm:pt-0 border-t sm:border-t-0 border-slate-100 text-[11px]">
                                @if($ticket->technician_name)
                                    <div class="text-left sm:text-right">
                                        <span class="text-slate-400 text-[10px] block sm:inline">Teknisi:</span>
                                        <span class="text-slate-700 font-semibold">{{ $ticket->technician_name }}</span>
                                    </div>
                                @endif
                                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-slate-100 group-hover:bg-sky-600 group-hover:text-white flex items-center justify-center text-slate-400 transition-all shadow-2xs ml-auto sm:ml-0">
                                    <iconify-icon icon="solar:arrow-right-linear" width="14"></iconify-icon>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="portal-card rounded-2xl p-5 sm:p-8 text-center space-y-2 sm:space-y-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 mx-auto flex items-center justify-center shadow-xs">
                        <iconify-icon icon="solar:check-circle-bold" width="22" class="sm:text-2xl"></iconify-icon>
                    </div>
                    <div class="text-xs sm:text-sm font-heading font-bold text-slate-900">Tidak Ada Laporan Gangguan Aktif</div>
                    <p class="text-[11px] sm:text-xs text-slate-500 max-w-md mx-auto">
                        Koneksi internet Anda beroperasi normal. Jika mengalami kendala seperti lampu LOS merah atau lambat, silakan buat laporan.
                    </p>
                    <div class="pt-1">
                        <a href="{{ route('portal.tickets.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-xs font-heading font-bold text-slate-700 shadow-xs transition-all">
                            <iconify-icon icon="solar:add-circle-bold" class="text-sky-600"></iconify-icon>
                            <span>Buat Laporan Baru</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right 1 Col: Quick Tools & Self-Troubleshooting -->
        <div class="space-y-3 sm:space-y-4">
            <div class="flex items-center gap-1.5 sm:gap-2">
                <iconify-icon icon="solar:settings-bold" class="text-sky-600 text-base sm:text-lg"></iconify-icon>
                <h2 class="text-sm sm:text-lg font-heading font-bold text-slate-900">Panduan Mandiri</h2>
            </div>

            <!-- Speedtest Box -->
            <div class="portal-card rounded-2xl p-3.5 sm:p-5 space-y-2.5">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-sky-100 border border-sky-200 text-sky-600 flex items-center justify-center shrink-0 shadow-xs">
                        <iconify-icon icon="solar:bolt-circle-bold" width="18" class="sm:text-xl"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-bold text-slate-900">Uji Kecepatan Internet</div>
                        <div class="text-[10px] sm:text-[11px] text-slate-500">Cek speed download & upload real-time</div>
                    </div>
                </div>
                <a href="https://fast.com" target="_blank" class="w-full py-2 px-3 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-xs font-heading font-bold text-slate-700 hover:text-sky-600 transition-all flex items-center justify-center gap-1.5 shadow-xs">
                    <span>Buka Fast.com Speedtest</span>
                    <iconify-icon icon="solar:arrow-right-up-linear" width="13"></iconify-icon>
                </a>
            </div>

            <!-- Troubleshooting Tips -->
            <div class="portal-card rounded-2xl p-3.5 sm:p-5 space-y-2.5">
                <div class="text-xs font-heading font-bold text-slate-900 flex items-center gap-1.5">
                    <iconify-icon icon="solar:lightbulb-bolt-bold" class="text-amber-500 text-sm"></iconify-icon>
                    <span>Langkah Cepat Penanganan:</span>
                </div>
                
                <div class="space-y-2 text-xs text-slate-600">
                    <div class="p-2.5 rounded-xl bg-white/70 border border-slate-200/80 space-y-0.5">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5 text-[11px]">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            <span>1. Lampu LOS Modem Merah</span>
                        </div>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 pl-3">
                            Kabel optik terlipat / putus tiang. Jangan ditekuk, segera laporkan ke tim teknisi.
                        </p>
                    </div>

                    <div class="p-2.5 rounded-xl bg-white/70 border border-slate-200/80 space-y-0.5">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5 text-[11px]">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span>2. WiFi Tersambung Tapi No Internet</span>
                        </div>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 pl-3">
                            Matikan tombol power modem 30 detik lalu nyalakan kembali (Power Cycle).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Help Contact Box -->
            <div class="portal-card rounded-2xl p-3.5 sm:p-5 bg-gradient-to-br from-sky-50 to-blue-50/60 border-sky-200 space-y-2">
                <div class="text-xs font-heading font-bold text-slate-900 flex items-center gap-1.5">
                    <iconify-icon icon="solar:headphones-round-sound-bold" class="text-emerald-600 text-sm"></iconify-icon>
                    <span>Bantuan Cepat NOC PT MSN</span>
                </div>
                <p class="text-[10px] sm:text-[11px] text-slate-600 leading-relaxed">
                    Siap siaga melayani Anda 24 jam setiap hari.
                </p>
                <a href="https://wa.me/6281214878436" target="_blank" class="w-full py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:chat-round-dots-bold" width="15"></iconify-icon>
                    <span>WhatsApp NOC (0812-1487-8436)</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
