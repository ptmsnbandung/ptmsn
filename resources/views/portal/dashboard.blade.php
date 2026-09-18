@extends('portal.layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="space-y-4 sm:space-y-6">

    <!-- Network Hero Pass Banner -->
    <div class="network-hero-pass p-4 sm:p-7 relative overflow-hidden">
        
        <!-- Ambient Circuit Grid & Glow Background -->
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-4 sm:space-y-6">
            
            <!-- Top Hero Row: Customer ID, Status & Actions -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-6">
                
                <div class="space-y-2">
                    <!-- Status & ID Badges -->
                    <div class="flex items-center gap-2 flex-wrap">
                        <button 
                            type="button"
                            onclick="copyToClipboard('{{ $customer->customer_id }}', 'ID Pelanggan {{ $customer->customer_id }}')" 
                            class="copy-badge inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-white/10 hover:bg-white/20 border border-sky-400/30 text-sky-200 font-mono text-xs font-bold shadow-xs backdrop-blur-md transition-all group"
                            title="Klik untuk menyalin ID Pelanggan"
                        >
                            <iconify-icon icon="solar:hashtag-bold" class="text-sky-400 text-xs"></iconify-icon>
                            <span>ID: {{ $customer->customer_id }}</span>
                            <iconify-icon icon="solar:copy-linear" class="text-sky-300 opacity-60 group-hover:opacity-100 transition-opacity text-xs"></iconify-icon>
                        </button>

                        @if($customer->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/15 border border-emerald-400/40 text-emerald-300 text-xs font-semibold backdrop-blur-md">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>Koneksi FTTH Aktif</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-500/15 border border-rose-400/40 text-rose-300 text-xs font-semibold backdrop-blur-md">
                                <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                <span>Status: {{ ucfirst($customer->status) }}</span>
                            </span>
                        @endif

                        <span class="hidden sm:inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-sky-950/60 border border-sky-800/60 text-sky-300 font-mono text-[11px]">
                            <iconify-icon icon="solar:round-transfer-vertical-bold" class="text-sky-400"></iconify-icon>
                            <span>GPON OLT: Online</span>
                        </span>
                    </div>

                    <!-- Welcome Title -->
                    <h1 class="text-xl sm:text-3xl font-heading font-extrabold text-white tracking-tight leading-tight">
                        Halo, {{ $customer->name }}! 👋
                    </h1>
                    
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        Selamat datang di portal <strong class="text-sky-300 font-semibold">MyMSN Self-Care</strong>. Layanan internet broadband Anda beroperasi normal via jaringan Fiber Optic PT Media Solusi Network.
                    </p>
                </div>

                <!-- Quick Action Buttons on Hero -->
                <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center sm:gap-3 shrink-0 pt-1 sm:pt-0">
                    <a href="{{ route('portal.tickets.create') }}" class="btn-network-action inline-flex items-center justify-center gap-1.5 px-4 sm:px-5 py-2.5 sm:py-3.5 rounded-xl sm:rounded-2xl font-heading font-bold text-xs sm:text-sm text-center shadow-lg">
                        <iconify-icon icon="solar:danger-triangle-bold" width="16" class="shrink-0 text-amber-300"></iconify-icon>
                        <span>Lapor Gangguan</span>
                    </a>
                    <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20NOC%20PT%20MSN,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20({{ urlencode($customer->name) }})%20ingin%20konsultasi%20layanan" target="_blank" class="btn-noc-action inline-flex items-center justify-center gap-1.5 px-4 sm:px-5 py-2.5 sm:py-3.5 rounded-xl sm:rounded-2xl font-heading font-bold text-xs sm:text-sm text-center shadow-lg">
                        <iconify-icon icon="solar:chat-round-dots-bold" class="shrink-0" width="16"></iconify-icon>
                        <span>Hubungi NOC</span>
                    </a>
                </div>

            </div>

            <!-- Bottom Hero Telemetry Live Bar (Network Metrics) -->
            <div class="telemetry-bar p-2.5 sm:p-3 grid grid-cols-2 sm:grid-cols-4 gap-2 border-t border-sky-400/15 text-xs">
                
                <div class="telemetry-item justify-between sm:justify-start">
                    <div class="flex items-center gap-1.5 text-slate-300">
                        <iconify-icon icon="solar:graph-up-linear" class="text-sky-400"></iconify-icon>
                        <span class="text-[11px]">Latensi Ping:</span>
                    </div>
                    <span class="text-emerald-400 font-bold ml-1">~8 ms</span>
                </div>

                <div class="telemetry-item justify-between sm:justify-start">
                    <div class="flex items-center gap-1.5 text-slate-300">
                        <iconify-icon icon="solar:server-square-bold" class="text-cyan-400"></iconify-icon>
                        <span class="text-[11px]">Sinyal Rx:</span>
                    </div>
                    <span class="text-emerald-400 font-bold ml-1">-18.5 dBm</span>
                </div>

                <div class="telemetry-item justify-between sm:justify-start">
                    <div class="flex items-center gap-1.5 text-slate-300">
                        <iconify-icon icon="solar:shield-check-bold" class="text-emerald-400"></iconify-icon>
                        <span class="text-[11px]">Packet Loss:</span>
                    </div>
                    <span class="text-emerald-400 font-bold ml-1">0.0%</span>
                </div>

                <div class="telemetry-item justify-between sm:justify-start">
                    <div class="flex items-center gap-1.5 text-slate-300">
                        <iconify-icon icon="solar:routing-2-bold" class="text-purple-400"></iconify-icon>
                        <span class="text-[11px]">DNS Primary:</span>
                    </div>
                    <span class="text-sky-300 font-bold ml-1 truncate">MSN Resolver</span>
                </div>

            </div>

        </div>

    </div>

    <!-- Status KPI Cards Grid (4 Column Grid with Network Theme) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-4">
        
        <!-- Card 1: Paket Internet & Bandwidth -->
        <div class="stat-kpi-card kpi-blue p-3.5 sm:p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-400">PAKET INTERNET</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center shadow-xs shrink-0">
                    <iconify-icon icon="solar:bolt-circle-bold" width="18" class="sm:text-xl"></iconify-icon>
                </div>
            </div>
            <div>
                <div class="text-sm sm:text-lg font-heading font-extrabold text-slate-900 truncate" title="{{ $customer->package->name ?? 'Broadband FTTH' }}">
                    {{ $customer->package->name ?? 'Broadband FTTH' }}
                </div>
                <div class="text-xs sm:text-sm font-mono text-sky-600 font-extrabold mt-0.5 flex items-center gap-1.5">
                    <span>{{ $customer->package->speed ?? '25 Mbps' }}</span>
                    <span class="text-[10px] font-sans px-1.5 py-0.2 rounded bg-sky-50 text-sky-700 border border-sky-200">FTTH</span>
                </div>
                <div class="text-[10px] sm:text-[11px] text-slate-500 mt-2 flex items-center justify-between">
                    <span class="flex items-center gap-1 text-emerald-600 font-semibold">
                        <iconify-icon icon="solar:check-circle-bold" class="text-emerald-500 shrink-0"></iconify-icon>
                        <span>Tanpa FUP (Unlimited)</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 2: Status Tagihan & Billing -->
        <div class="stat-kpi-card kpi-emerald p-3.5 sm:p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-400">STATUS TAGIHAN</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shadow-xs shrink-0">
                    <iconify-icon icon="solar:wallet-money-bold" width="18" class="sm:text-xl"></iconify-icon>
                </div>
            </div>
            <div>
                <div class="text-sm sm:text-lg font-heading font-extrabold text-slate-900 truncate">
                    Rp {{ number_format($customer->billing_amount, 0, ',', '.') }}
                </div>
                <div class="text-[10px] sm:text-xs text-slate-500 mt-0.5">
                    Jatuh Tempo: Tgl {{ $customer->due_date }} / bln
                </div>
                <div class="text-[10px] sm:text-[11px] mt-2 flex items-center justify-between gap-1">
                    @if($customer->billing_status === 'paid')
                        <span class="badge-paid">
                            <iconify-icon icon="solar:check-read-linear"></iconify-icon>
                            <span>Lunas</span>
                        </span>
                    @else
                        <span class="badge-unpaid">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                            <span>Menunggu</span>
                        </span>
                    @endif
                    <a href="{{ route('portal.billing.index') }}" class="text-sky-600 hover:text-sky-700 font-heading font-bold text-[11px] hover:underline flex items-center gap-0.5 shrink-0">
                        <span>Rincian</span>
                        <iconify-icon icon="solar:alt-arrow-right-linear"></iconify-icon>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: Tiket Kendala Aktif -->
        <div class="stat-kpi-card kpi-amber p-3.5 sm:p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-400">TIKET KENDALA</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shadow-xs shrink-0">
                    <iconify-icon icon="solar:shield-warning-bold" width="18" class="sm:text-xl"></iconify-icon>
                </div>
            </div>
            <div>
                <div class="text-xl sm:text-2xl font-heading font-extrabold text-slate-900">
                    {{ $activeTicketsCount }}
                </div>
                <div class="text-[10px] sm:text-xs text-slate-500 mt-0.5 truncate">
                    {{ $activeTicketsCount > 0 ? 'Sedang ditangani teknisi' : 'Jaringan Normal / Nihil' }}
                </div>
                <div class="text-[10px] sm:text-[11px] text-slate-500 mt-2 flex items-center justify-between">
                    <span>Selesai: <strong class="text-emerald-600 font-mono">{{ $resolvedTicketsCount }}</strong></span>
                    <a href="{{ route('portal.tickets.index') }}" class="text-sky-600 hover:text-sky-700 font-heading font-semibold text-[11px] hover:underline">
                        Lihat
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 4: Detail Jaringan & IP Address -->
        <div class="stat-kpi-card kpi-purple p-3.5 sm:p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-400">JARINGAN & IP</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center shadow-xs shrink-0">
                    <iconify-icon icon="solar:map-point-wave-bold" width="18" class="sm:text-xl"></iconify-icon>
                </div>
            </div>
            <div>
                <button 
                    type="button"
                    onclick="copyToClipboard('{{ $customer->ip_address ?? '10.20.104.22' }}', 'IP Address {{ $customer->ip_address ?? '10.20.104.22' }}')" 
                    class="copy-badge text-left group w-full"
                    title="Klik untuk salin IP Address"
                >
                    <div class="text-[11px] sm:text-xs font-mono font-bold text-sky-600 truncate flex items-center gap-1 group-hover:text-sky-700">
                        <span>{{ $customer->ip_address ?? '10.20.104.22' }}</span>
                        <iconify-icon icon="solar:copy-linear" class="opacity-60 group-hover:opacity-100 text-slate-400 group-hover:text-sky-600 text-xs shrink-0"></iconify-icon>
                    </div>
                </button>
                <div class="text-[10px] sm:text-xs text-slate-600 mt-0.5 truncate">
                    {{ $customer->city ?? 'Area Layanan' }} — GPON
                </div>
                <div class="text-[10px] sm:text-[11px] text-slate-500 mt-2 flex items-center justify-between">
                    <span class="flex items-center gap-1">
                        <iconify-icon icon="solar:server-path-bold" class="text-sky-500 shrink-0"></iconify-icon>
                        <span>Fiber Optic</span>
                    </span>
                    <span class="signal-bars signal-full" title="Kekuatan Sinyal Optik Sempurna">
                        <span></span><span></span><span></span><span></span>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Main Content Section: Recent Tickets & Troubleshooting Guide -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3.5 sm:gap-6">
        
        <!-- Left 2 Cols: Recent Trouble Tickets -->
        <div class="lg:col-span-2 space-y-3 sm:space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                        <iconify-icon icon="solar:ticket-sale-bold" class="text-sm"></iconify-icon>
                    </div>
                    <h2 class="text-sm sm:text-lg font-heading font-bold text-slate-900">Riwayat Laporan Kendala</h2>
                </div>
                <a href="{{ route('portal.tickets.index') }}" class="text-[11px] sm:text-xs font-heading font-semibold text-sky-600 hover:text-sky-700 hover:underline flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
                </a>
            </div>

            @if($recentTickets->count() > 0)
                <div class="space-y-2.5 sm:space-y-3">
                    @foreach($recentTickets as $ticket)
                        <a href="{{ route('portal.tickets.show', $ticket->id) }}" class="portal-card portal-card-hover rounded-xl sm:rounded-2xl p-3.5 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 block group">
                            <div class="space-y-1.5 flex-1">
                                <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                    <span class="text-[10px] sm:text-xs font-mono font-bold text-sky-700 bg-sky-50 border border-sky-200 px-2 py-0.5 rounded-md sm:rounded-lg">
                                        #{{ $ticket->ticket_number }}
                                    </span>
                                    <span class="text-[10px] sm:text-[11px] font-sans px-2.5 py-0.5 rounded-full {{ $ticket->status_badge_class }} font-semibold">
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

                            <div class="flex items-center justify-between sm:justify-end gap-2 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 text-[11px]">
                                @if($ticket->technician_name)
                                    <div class="text-left sm:text-right">
                                        <span class="text-slate-400 text-[10px] block sm:inline">Teknisi:</span>
                                        <span class="text-slate-700 font-semibold">{{ $ticket->technician_name }}</span>
                                    </div>
                                @endif
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-slate-100 group-hover:bg-sky-600 group-hover:text-white flex items-center justify-center text-slate-400 transition-all shadow-2xs ml-auto sm:ml-0">
                                    <iconify-icon icon="solar:arrow-right-linear" width="14"></iconify-icon>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="portal-card rounded-2xl p-6 sm:p-8 text-center space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 mx-auto flex items-center justify-center shadow-xs">
                        <iconify-icon icon="solar:check-circle-bold" width="26"></iconify-icon>
                    </div>
                    <div class="text-sm font-heading font-bold text-slate-900">Tidak Ada Laporan Gangguan Aktif</div>
                    <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                        Koneksi internet FTTH Anda beroperasi normal. Jika Anda mengalami kendala teknis (lampu LOS merah, lambat, atau kendala perangkat), silakan buat laporan ke tim NOC kami.
                    </p>
                    <div class="pt-1">
                        <a href="{{ route('portal.tickets.create') }}" class="btn-network-action inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-heading font-bold shadow-xs">
                            <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
                            <span>Buat Laporan Gangguan Baru</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right 1 Col: Speedtest & Quick Troubleshooting -->
        <div class="space-y-3 sm:space-y-4">
            
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                    <iconify-icon icon="solar:settings-bold" class="text-sm"></iconify-icon>
                </div>
                <h2 class="text-sm sm:text-lg font-heading font-bold text-slate-900">Diagnostik & Panduan</h2>
            </div>

            <!-- Speedtest Box -->
            <div class="portal-card rounded-2xl p-4 sm:p-5 space-y-3 bg-gradient-to-br from-white/90 to-sky-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm shadow-sky-500/25">
                        <iconify-icon icon="solar:bolt-circle-bold" width="22"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-xs sm:text-sm font-heading font-bold text-slate-900">Uji Kecepatan Internet</div>
                        <div class="text-[10px] sm:text-[11px] text-slate-500">Cek speed download & upload real-time</div>
                    </div>
                </div>
                <a href="https://fast.com" target="_blank" class="w-full py-2.5 px-3.5 rounded-xl bg-white hover:bg-sky-50 border border-slate-200 text-xs font-heading font-bold text-slate-700 hover:text-sky-600 transition-all flex items-center justify-center gap-1.5 shadow-2xs hover:shadow-xs">
                    <iconify-icon icon="solar:play-circle-bold" class="text-sky-500" width="16"></iconify-icon>
                    <span>Jalankan Fast.com Speedtest</span>
                    <iconify-icon icon="solar:arrow-right-up-linear" width="13"></iconify-icon>
                </a>
            </div>

            <!-- Troubleshooting Tips -->
            <div class="portal-card rounded-2xl p-4 sm:p-5 space-y-3">
                <div class="text-xs font-heading font-bold text-slate-900 flex items-center gap-1.5">
                    <iconify-icon icon="solar:lightbulb-bolt-bold" class="text-amber-500 text-base"></iconify-icon>
                    <span>Langkah Cepat Penanganan Kendala:</span>
                </div>
                
                <div class="space-y-2 text-xs">
                    <div class="p-2.5 rounded-xl bg-slate-50/80 border border-slate-200/80 space-y-1">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5 text-[11px]">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>1. Lampu LOS Modem Berkedip Merah</span>
                        </div>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 pl-3.5 leading-relaxed">
                            Kabel patchcord fiber optic terlipat atau putus jalur tiang. Jangan ditarik paksa, segera laporkan ke tim teknisi NOC.
                        </p>
                    </div>

                    <div class="p-2.5 rounded-xl bg-slate-50/80 border border-slate-200/80 space-y-1">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5 text-[11px]">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span>2. WiFi Terhubung Tapi "No Internet"</span>
                        </div>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 pl-3.5 leading-relaxed">
                            Matikan tombol power modem ONT selama 30 detik lalu hidupkan kembali (Power Cycle) agar IP router tersegarkan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Help Contact Box -->
            <div class="portal-card rounded-2xl p-4 sm:p-5 bg-gradient-to-br from-emerald-50/90 to-teal-50/70 border-emerald-200/90 space-y-2.5">
                <div class="text-xs font-heading font-bold text-emerald-900 flex items-center gap-1.5">
                    <iconify-icon icon="solar:headphones-round-sound-bold" class="text-emerald-600 text-base"></iconify-icon>
                    <span>Bantuan Cepat NOC 24 Jam</span>
                </div>
                <p class="text-[10px] sm:text-[11px] text-emerald-800 leading-relaxed">
                    Tim Network Operation Center siap melayani konsultasi dan eskalasi teknis Anda kapan saja.
                </p>
                <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20NOC%20PT%20MSN,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20membutuhkan%20bantuan%20teknis" target="_blank" class="w-full py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-sm shadow-emerald-600/25">
                    <iconify-icon icon="solar:chat-round-dots-bold" width="16"></iconify-icon>
                    <span>Chat WhatsApp NOC ({{ config('company.phone', '+62 896-9662-9955') }})</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
