@extends('portal.layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="space-y-6">

    <!-- Welcome Hero Banner -->
    <div class="portal-card rounded-3xl p-6 sm:p-8 relative overflow-hidden">
        <!-- Ambient Glow -->
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-sky-200/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-indigo-100/50 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2.5 flex-wrap">
                    <span class="px-3 py-1 rounded-xl bg-white/80 border border-slate-200/80 text-slate-700 font-mono text-xs font-bold shadow-sm">
                        ID: {{ $customer->customer_id }}
                    </span>
                    @if($customer->status === 'active')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Koneksi Aktif & Normal</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>Status: {{ ucfirst($customer->status) }}</span>
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">
                    Halo, {{ $customer->name }}! 👋
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 max-w-2xl leading-relaxed">
                    Selamat datang di Portal Pelanggan PT Media Solusi Network. Pantau performa internet Anda atau laporkan kendala jaringan langsung ke tim NOC kami.
                </p>
            </div>

            <!-- Quick Action Buttons on Hero -->
            <div class="flex items-center gap-3 shrink-0 flex-wrap sm:flex-nowrap">
                <a href="{{ route('portal.tickets.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-bold text-xs sm:text-sm shadow-lg shadow-sky-500/25 hover:scale-105 active:scale-95 transition-all">
                    <iconify-icon icon="solar:danger-triangle-bold" width="18"></iconify-icon>
                    <span>Lapor Gangguan Baru</span>
                </a>
                <a href="https://wa.me/6281214878436?text=Halo%20NOC%20PT%20MSN,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20ingin%20konsultasi" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-3.5 rounded-2xl bg-white/80 hover:bg-white border border-slate-200 text-slate-800 font-heading font-semibold text-xs sm:text-sm shadow-sm hover:shadow transition-all">
                    <iconify-icon icon="solar:chat-round-dots-bold" class="text-emerald-500" width="18"></iconify-icon>
                    <span>Hubungi NOC</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Status Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- Card 1: Paket Internet -->
        <div class="portal-card rounded-2xl p-5 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-mono font-semibold uppercase tracking-wider text-slate-500">Paket Langganan</span>
                <div class="w-9 h-9 rounded-2xl bg-sky-100/80 border border-sky-200 text-sky-600 flex items-center justify-center shadow-sm">
                    <iconify-icon icon="solar:bolt-circle-bold" width="20"></iconify-icon>
                </div>
            </div>
            <div>
                <div class="text-lg font-heading font-extrabold text-slate-900">
                    {{ $customer->package->name ?? 'Broadband FTTH' }}
                </div>
                <div class="text-xs font-mono text-sky-600 font-bold mt-0.5">
                    {{ $customer->package->speed ?? 'Up to 25 Mbps' }}
                </div>
                <div class="text-[11px] text-slate-500 mt-2 flex items-center gap-1">
                    <iconify-icon icon="solar:check-circle-bold" class="text-emerald-500"></iconify-icon>
                    <span>Unlimited Tanpa FUP</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Status Tagihan -->
        <div class="portal-card rounded-2xl p-5 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-mono font-semibold uppercase tracking-wider text-slate-500">Status Tagihan</span>
                <div class="w-9 h-9 rounded-2xl bg-emerald-100/80 border border-emerald-200 text-emerald-600 flex items-center justify-center shadow-sm">
                    <iconify-icon icon="solar:wallet-money-bold" width="20"></iconify-icon>
                </div>
            </div>
            <div>
                <div class="text-lg font-heading font-extrabold text-slate-900">
                    Rp {{ number_format($customer->billing_amount, 0, ',', '.') }}
                </div>
                <div class="text-xs text-slate-600 mt-0.5">
                    Jatuh Tempo: Tgl {{ $customer->due_date }} / bulan
                </div>
                <div class="text-[11px] mt-2">
                    @if($customer->billing_status === 'paid')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-semibold font-mono">
                            <iconify-icon icon="solar:check-read-linear"></iconify-icon> Lunas Bulan Ini
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 border border-rose-200 text-rose-700 font-semibold font-mono">
                            <iconify-icon icon="solar:danger-circle-bold"></iconify-icon> Menunggu Pembayaran
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card 3: Tiket Gangguan Aktif -->
        <div class="portal-card rounded-2xl p-5 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-mono font-semibold uppercase tracking-wider text-slate-500">Laporan Gangguan</span>
                <div class="w-9 h-9 rounded-2xl bg-amber-100/80 border border-amber-200 text-amber-600 flex items-center justify-center shadow-sm">
                    <iconify-icon icon="solar:shield-warning-bold" width="20"></iconify-icon>
                </div>
            </div>
            <div>
                <div class="text-2xl font-heading font-extrabold text-slate-900">
                    {{ $activeTicketsCount }}
                </div>
                <div class="text-xs text-slate-600 mt-0.5">
                    {{ $activeTicketsCount > 0 ? 'Tiket sedang diproses teknisi' : 'Tidak ada kendala aktif' }}
                </div>
                <div class="text-[11px] text-slate-500 mt-2">
                    Total terselesaikan: <span class="text-emerald-600 font-bold font-mono">{{ $resolvedTicketsCount }} tiket</span>
                </div>
            </div>
        </div>

        <!-- Card 4: IP & Alamat Pemasangan -->
        <div class="portal-card rounded-2xl p-5 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-mono font-semibold uppercase tracking-wider text-slate-500">Titik Jaringan</span>
                <div class="w-9 h-9 rounded-2xl bg-purple-100/80 border border-purple-200 text-purple-600 flex items-center justify-center shadow-sm">
                    <iconify-icon icon="solar:map-point-wave-bold" width="20"></iconify-icon>
                </div>
            </div>
            <div>
                <div class="text-xs font-mono font-bold text-sky-600 truncate">
                    IP: {{ $customer->ip_address ?? '10.20.104.22' }}
                </div>
                <div class="text-xs text-slate-600 mt-1 line-clamp-1">
                    {{ $customer->city ?? 'Bekasi' }} — {{ $customer->district ?? 'Jawa Barat' }}
                </div>
                <div class="text-[11px] text-slate-500 mt-2 flex items-center gap-1">
                    <iconify-icon icon="solar:server-path-bold" class="text-sky-500"></iconify-icon>
                    <span>Fiber Optic Direct GPON</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Main Content Section: Recent Tickets & Troubleshooting Guide -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Cols: Recent Trouble Tickets -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <iconify-icon icon="solar:ticket-sale-bold" class="text-sky-600 text-lg"></iconify-icon>
                    <h2 class="text-base sm:text-lg font-heading font-bold text-slate-900">Riwayat Laporan Gangguan</h2>
                </div>
                <a href="{{ route('portal.tickets.index') }}" class="text-xs font-heading font-semibold text-sky-600 hover:text-sky-700 hover:underline flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
                </a>
            </div>

            @if($recentTickets->count() > 0)
                <div class="space-y-3">
                    @foreach($recentTickets as $ticket)
                        <a href="{{ route('portal.tickets.show', $ticket->id) }}" class="portal-card portal-card-hover rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 block group">
                            <div class="space-y-1.5 flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-mono font-bold text-sky-700 bg-sky-50 border border-sky-200 px-2 py-0.5 rounded-lg">
                                        {{ $ticket->ticket_number }}
                                    </span>
                                    <span class="text-[11px] font-sans px-2.5 py-0.5 rounded-full {{ $ticket->status_badge_class }} font-semibold">
                                        {{ $ticket->status_label }}
                                    </span>
                                    <span class="text-[11px] font-sans px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $ticket->category_label }}
                                    </span>
                                    <span class="text-[11px] text-slate-500 font-mono">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h3 class="text-sm sm:text-base font-heading font-bold text-slate-900 group-hover:text-sky-600 transition-colors">
                                    {{ $ticket->subject }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-1">
                                    {{ $ticket->description }}
                                </p>
                            </div>

                            <div class="flex items-center gap-3 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                                @if($ticket->technician_name)
                                    <div class="text-right hidden sm:block">
                                        <div class="text-[10px] font-mono text-slate-400">Teknisi:</div>
                                        <div class="text-xs text-slate-700 font-semibold">{{ $ticket->technician_name }}</div>
                                    </div>
                                @endif
                                <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-sky-600 group-hover:text-white flex items-center justify-center text-slate-400 transition-all shadow-sm">
                                    <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="portal-card rounded-2xl p-8 text-center space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 mx-auto flex items-center justify-center shadow-sm">
                        <iconify-icon icon="solar:check-circle-bold" width="26"></iconify-icon>
                    </div>
                    <div class="text-sm font-heading font-bold text-slate-900">Tidak Ada Laporan Gangguan Aktif</div>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">
                        Koneksi internet Anda beroperasi normal. Jika mengalami kendala seperti lampu LOS merah atau internet lambat, silakan buat laporan.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('portal.tickets.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-xs font-heading font-bold text-slate-700 shadow-sm transition-all">
                            <iconify-icon icon="solar:add-circle-bold" class="text-sky-600"></iconify-icon>
                            <span>Buat Laporan Baru</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right 1 Col: Quick Tools & Self-Troubleshooting -->
        <div class="space-y-4">
            <div class="flex items-center gap-2">
                <iconify-icon icon="solar:wrench-bold" class="text-sky-600 text-lg"></iconify-icon>
                <h2 class="text-base sm:text-lg font-heading font-bold text-slate-900">Panduan Kendala Mandiri</h2>
            </div>

            <!-- Speedtest Box -->
            <div class="portal-card rounded-2xl p-5 space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-100 border border-sky-200 text-sky-600 flex items-center justify-center shrink-0 shadow-sm">
                        <iconify-icon icon="solar:speedometer-bold" width="22"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-bold text-slate-900">Cek Kecepatan Internet</div>
                        <div class="text-[11px] text-slate-500">Uji bandwidth download & upload real-time</div>
                    </div>
                </div>
                <a href="https://fast.com" target="_blank" class="w-full py-2.5 px-3 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-xs font-heading font-bold text-slate-700 hover:text-sky-600 transition-all flex items-center justify-center gap-2 shadow-sm">
                    <span>Buka Fast.com Speedtest</span>
                    <iconify-icon icon="solar:arrow-right-up-linear" width="14"></iconify-icon>
                </a>
            </div>

            <!-- Troubleshooting Tips -->
            <div class="portal-card rounded-2xl p-5 space-y-3.5">
                <div class="text-xs font-heading font-bold text-slate-900 flex items-center gap-2">
                    <iconify-icon icon="solar:lightbulb-bolt-bold" class="text-amber-500 text-base"></iconify-icon>
                    <span>Langkah Penanganan Mandiri:</span>
                </div>
                
                <div class="space-y-2.5 text-xs text-slate-600">
                    <div class="p-3 rounded-2xl bg-white/60 border border-slate-200/80 space-y-1">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            <span>1. Lampu LOS Modem Merah</span>
                        </div>
                        <p class="text-[11px] text-slate-500 pl-3">
                            Kabel patchcord fiber optic terlipat atau putus dari tiang. Jangan ditekuk, segera buat tiket pengaduan.
                        </p>
                    </div>

                    <div class="p-3 rounded-2xl bg-white/60 border border-slate-200/80 space-y-1">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span>2. WiFi Terhubung Tanpa Internet</span>
                        </div>
                        <p class="text-[11px] text-slate-500 pl-3">
                            Matikan tombol power modem ONT selama 30 detik lalu nyalakan kembali (Power Cycle).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Help Contact Box -->
            <div class="portal-card rounded-2xl p-5 bg-gradient-to-br from-sky-50 to-blue-50/60 border-sky-200 space-y-2.5">
                <div class="text-xs font-heading font-bold text-slate-900 flex items-center gap-2">
                    <iconify-icon icon="solar:headphones-round-sound-bold" class="text-emerald-600 text-base"></iconify-icon>
                    <span>Butuh Bantuan Mendesak?</span>
                </div>
                <p class="text-[11px] text-slate-600 leading-relaxed">
                    Tim teknisi PT Media Solusi Network siap siaga melayani Anda 24 jam setiap hari.
                </p>
                <a href="https://wa.me/6281214878436" target="_blank" class="w-full py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-emerald-600/20">
                    <iconify-icon icon="solar:chat-round-dots-bold" width="16"></iconify-icon>
                    <span>WhatsApp NOC (0812-1487-8436)</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection

