@extends('portal.layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="space-y-4 sm:space-y-6">

    <!-- Executive Network Hero Card (Solid & High-Contrast) -->
    <div class="hero-network-card p-5 sm:p-7 relative">
        
        <div class="relative z-10 space-y-5">
            
            <!-- Top Row: ID, Status Badge & Action Buttons -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <!-- Left: Greeting & Badges -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2 flex-wrap">
                        <button 
                            type="button"
                            onclick="copyToClipboard('{{ $customer->customer_id }}', 'ID Pelanggan {{ $customer->customer_id }}')" 
                            class="copy-btn inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-800 border border-slate-700 hover:border-sky-500 text-sky-400 font-mono text-xs font-bold transition-all"
                            title="Klik untuk menyalin ID Pelanggan"
                        >
                            <iconify-icon icon="solar:hashtag-bold" class="text-sky-400 text-xs"></iconify-icon>
                            <span>ID: {{ $customer->customer_id }}</span>
                            <iconify-icon icon="solar:copy-linear" class="text-slate-400 text-xs ml-0.5"></iconify-icon>
                        </button>

                        @if($customer->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-950/80 border border-emerald-500/50 text-emerald-400 text-xs font-semibold">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>Koneksi FTTH Aktif</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-950/80 border border-rose-500/50 text-rose-400 text-xs font-semibold">
                                <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                <span>Status: {{ ucfirst($customer->status) }}</span>
                            </span>
                        @endif

                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-800/80 border border-slate-700 text-slate-300 font-mono text-[11px]">
                            <iconify-icon icon="solar:server-path-bold" class="text-sky-400"></iconify-icon>
                            <span>GPON OLT Online</span>
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-white tracking-tight">
                        Halo, {{ $customer->name }}! 👋
                    </h1>
                    
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        Pantau performa koneksi internet broadband dan rincian layanan Anda secara real-time.
                    </p>
                </div>

                <!-- Right: Action Buttons -->
                <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center sm:gap-3 shrink-0">
                    <a href="{{ route('portal.tickets.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 sm:py-3 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-bold text-xs sm:text-sm shadow-md transition-all active:scale-95 text-center">
                        <iconify-icon icon="solar:danger-triangle-bold" class="text-amber-300 text-base shrink-0"></iconify-icon>
                        <span>Lapor Gangguan</span>
                    </a>
                    <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20NOC%20PT%20MSN,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20({{ urlencode($customer->name) }})%20ingin%20konsultasi%20layanan" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 sm:py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs sm:text-sm shadow-md transition-all active:scale-95 text-center">
                        <iconify-icon icon="solar:chat-round-dots-bold" class="text-white text-base shrink-0"></iconify-icon>
                        <span>Hubungi NOC</span>
                    </a>
                </div>

            </div>

            <!-- Bottom: Telemetry Bar -->
            <div class="telemetry-grid pt-3 border-t border-slate-800">
                
                <div class="telemetry-box">
                    <div class="flex items-center gap-1.5 text-slate-400">
                        <iconify-icon icon="solar:graph-up-linear" class="text-sky-400 text-sm"></iconify-icon>
                        <span>Latensi:</span>
                    </div>
                    <span class="text-emerald-400 font-bold">~8 ms</span>
                </div>

                <div class="telemetry-box">
                    <div class="flex items-center gap-1.5 text-slate-400">
                        <iconify-icon icon="solar:server-square-bold" class="text-cyan-400 text-sm"></iconify-icon>
                        <span>Sinyal Rx:</span>
                    </div>
                    <span class="text-cyan-400 font-bold">-18.5 dBm</span>
                </div>

                <div class="telemetry-box">
                    <div class="flex items-center gap-1.5 text-slate-400">
                        <iconify-icon icon="solar:shield-check-bold" class="text-emerald-400 text-sm"></iconify-icon>
                        <span>Packet Loss:</span>
                    </div>
                    <span class="text-emerald-400 font-bold">0.0%</span>
                </div>

                <div class="telemetry-box">
                    <div class="flex items-center gap-1.5 text-slate-400">
                        <iconify-icon icon="solar:routing-2-bold" class="text-purple-400 text-sm"></iconify-icon>
                        <span>DNS Server:</span>
                    </div>
                    <span class="text-sky-300 font-bold truncate">MSN Primary</span>
                </div>

            </div>

        </div>

    </div>

    <!-- Status 4 KPI Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
        
        <!-- Card 1: Paket Internet -->
        <div class="kpi-stat-card kpi-sky flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Paket Internet</span>
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100">
                        <iconify-icon icon="solar:bolt-circle-bold" width="20"></iconify-icon>
                    </div>
                </div>
                <div class="text-lg font-heading font-extrabold text-slate-900 truncate" title="{{ $customer->package->name ?? 'Broadband FTTH' }}">
                    {{ $customer->package->name ?? 'Broadband FTTH' }}
                </div>
                <div class="text-sm font-mono text-sky-600 font-bold mt-0.5">
                    {{ $customer->package->speed ?? '25 Mbps' }}
                </div>
            </div>
            <div class="pt-3 mt-3 border-t border-slate-100 text-xs text-slate-500 flex items-center gap-1.5">
                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-500 text-sm shrink-0"></iconify-icon>
                <span class="font-medium text-slate-700">Tanpa FUP (Unlimited)</span>
            </div>
        </div>

        <!-- Card 2: Status Tagihan -->
        <div class="kpi-stat-card kpi-emerald flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Status Tagihan</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                        <iconify-icon icon="solar:wallet-money-bold" width="20"></iconify-icon>
                    </div>
                </div>
                <div class="text-lg font-heading font-extrabold text-slate-900 truncate">
                    Rp {{ number_format($customer->billing_amount, 0, ',', '.') }}
                </div>
                <div class="text-xs text-slate-500 mt-0.5">
                    Tempo: Tgl {{ $customer->due_date }} / bln
                </div>
            </div>
            <div class="pt-3 mt-3 border-t border-slate-100 flex items-center justify-between gap-1">
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
                <a href="{{ route('portal.billing.index') }}" class="text-sky-600 hover:text-sky-700 font-heading font-bold text-xs hover:underline flex items-center gap-0.5">
                    <span>Bayar</span>
                    <iconify-icon icon="solar:alt-arrow-right-linear"></iconify-icon>
                </a>
            </div>
        </div>

        <!-- Card 3: Tiket Kendala Aktif -->
        <div class="kpi-stat-card kpi-amber flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Tiket Kendala</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100">
                        <iconify-icon icon="solar:shield-warning-bold" width="20"></iconify-icon>
                    </div>
                </div>
                <div class="text-2xl font-heading font-extrabold text-slate-900">
                    {{ $activeTicketsCount }}
                </div>
                <div class="text-xs text-slate-500 mt-0.5 truncate">
                    {{ $activeTicketsCount > 0 ? 'Sedang ditangani teknisi' : 'Jaringan Normal / Nihil' }}
                </div>
            </div>
            <div class="pt-3 mt-3 border-t border-slate-100 text-xs text-slate-500 flex items-center justify-between">
                <span>Selesai: <strong class="text-emerald-600 font-mono">{{ $resolvedTicketsCount }}</strong></span>
                <a href="{{ route('portal.tickets.index') }}" class="text-sky-600 hover:text-sky-700 font-heading font-semibold text-xs hover:underline">
                    Lihat
                </a>
            </div>
        </div>

        <!-- Card 4: Parameter Jaringan -->
        <div class="kpi-stat-card kpi-purple flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Jaringan & IP</span>
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100">
                        <iconify-icon icon="solar:map-point-wave-bold" width="20"></iconify-icon>
                    </div>
                </div>
                <button 
                    type="button"
                    onclick="copyToClipboard('{{ $customer->ip_address ?? '10.20.104.22' }}', 'IP Address')" 
                    class="copy-btn text-left group w-full"
                    title="Klik untuk menyalin IP"
                >
                    <div class="text-sm font-mono font-bold text-sky-600 truncate flex items-center gap-1 group-hover:text-sky-700">
                        <span>{{ $customer->ip_address ?? '10.20.104.22' }}</span>
                        <iconify-icon icon="solar:copy-linear" class="text-slate-400 group-hover:text-sky-600 text-xs shrink-0"></iconify-icon>
                    </div>
                </button>
                <div class="text-xs text-slate-500 mt-0.5 truncate">
                    {{ $customer->city ?? 'Area Layanan' }} — GPON
                </div>
            </div>
            <div class="pt-3 mt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span class="flex items-center gap-1">
                    <iconify-icon icon="solar:server-path-bold" class="text-sky-500"></iconify-icon>
                    <span>Fiber Optic</span>
                </span>
                <span class="signal-bars signal-full" title="Kekuatan Sinyal Sangat Baik">
                    <span></span><span></span><span></span><span></span>
                </span>
            </div>
        </div>

    </div>

    <!-- Main Content Section: Recent Tickets & Diagnostics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        
        <!-- Left 2 Cols: Recent Trouble Tickets -->
        <div class="lg:col-span-2 space-y-3 sm:space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                        <iconify-icon icon="solar:ticket-sale-bold" class="text-base"></iconify-icon>
                    </div>
                    <h2 class="text-base sm:text-lg font-heading font-bold text-slate-900">Riwayat Laporan Kendala</h2>
                </div>
                <a href="{{ route('portal.tickets.index') }}" class="text-xs font-heading font-semibold text-sky-600 hover:text-sky-700 hover:underline flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
                </a>
            </div>

            @if($recentTickets->count() > 0)
                <div class="space-y-3">
                    @foreach($recentTickets as $ticket)
                        <a href="{{ route('portal.tickets.show', $ticket->id) }}" class="portal-card portal-card-hover rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 block group">
                            <div class="space-y-1.5 flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-mono font-bold text-sky-700 bg-sky-50 border border-sky-200 px-2 py-0.5 rounded-lg">
                                        #{{ $ticket->ticket_number }}
                                    </span>
                                    <span class="text-[11px] font-sans px-2.5 py-0.5 rounded-full {{ $ticket->status_badge_class }} font-semibold">
                                        {{ $ticket->status_label }}
                                    </span>
                                    <span class="text-[11px] font-sans px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $ticket->category_label }}
                                    </span>
                                    <span class="text-[11px] text-slate-400 font-mono">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h3 class="text-sm sm:text-base font-heading font-bold text-slate-900 group-hover:text-sky-600 transition-colors line-clamp-1">
                                    {{ $ticket->subject }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-1">
                                    {{ $ticket->description }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 text-xs">
                                @if($ticket->technician_name)
                                    <div class="text-left sm:text-right">
                                        <span class="text-slate-400 text-[10px] block sm:inline">Teknisi:</span>
                                        <span class="text-slate-700 font-semibold">{{ $ticket->technician_name }}</span>
                                    </div>
                                @endif
                                <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-sky-600 group-hover:text-white flex items-center justify-center text-slate-400 transition-all ml-auto sm:ml-0">
                                    <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="portal-card rounded-2xl p-7 sm:p-9 text-center space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 mx-auto flex items-center justify-center shadow-xs">
                        <iconify-icon icon="solar:check-circle-bold" width="28"></iconify-icon>
                    </div>
                    <div class="text-base font-heading font-bold text-slate-900">Tidak Ada Laporan Gangguan Aktif</div>
                    <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                        Koneksi internet Anda beroperasi normal. Jika Anda mengalami kendala teknis (lampu LOS merah, lambat, atau gangguan perangkat), silakan buat laporan ke tim NOC.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('portal.tickets.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-600 text-white text-xs font-heading font-bold shadow-xs transition-all">
                            <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
                            <span>Buat Laporan Baru</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right 1 Col: Speedtest & Quick Diagnostics -->
        <div class="space-y-3 sm:space-y-4">
            
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                    <iconify-icon icon="solar:settings-bold" class="text-base"></iconify-icon>
                </div>
                <h2 class="text-base sm:text-lg font-heading font-bold text-slate-900">Diagnostik & Panduan</h2>
            </div>

            <!-- Speedtest Box -->
            <div class="portal-card rounded-2xl p-5 space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                        <iconify-icon icon="solar:bolt-circle-bold" width="22"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-sm font-heading font-bold text-slate-900">Uji Kecepatan Internet</div>
                        <div class="text-xs text-slate-500">Cek speed download & upload real-time</div>
                    </div>
                </div>
                <a href="https://fast.com" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-slate-50 hover:bg-sky-50 border border-slate-200 text-xs font-heading font-bold text-slate-700 hover:text-sky-700 transition-all flex items-center justify-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:play-circle-bold" class="text-sky-500" width="16"></iconify-icon>
                    <span>Buka Fast.com Speedtest</span>
                    <iconify-icon icon="solar:arrow-right-up-linear" width="14"></iconify-icon>
                </a>
            </div>

            <!-- Troubleshooting Tips -->
            <div class="portal-card rounded-2xl p-5 space-y-3">
                <div class="text-xs font-heading font-bold text-slate-900 flex items-center gap-1.5">
                    <iconify-icon icon="solar:lightbulb-bolt-bold" class="text-amber-500 text-base"></iconify-icon>
                    <span>Langkah Cepat Penanganan Kendala:</span>
                </div>
                
                <div class="space-y-2 text-xs">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>1. Lampu LOS Modem Berkedip Merah</span>
                        </div>
                        <p class="text-[11px] text-slate-500 pl-3.5 leading-relaxed">
                            Kabel patchcord fiber optic terlipat atau putus jalur tiang. Jangan ditarik paksa, segera laporkan ke tim teknisi NOC.
                        </p>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span>2. WiFi Terhubung Tapi "No Internet"</span>
                        </div>
                        <p class="text-[11px] text-slate-500 pl-3.5 leading-relaxed">
                            Matikan tombol power modem ONT selama 30 detik lalu hidupkan kembali (Power Cycle) agar IP router tersegarkan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Help Contact Box -->
            <div class="portal-card rounded-2xl p-5 bg-gradient-to-br from-emerald-50 to-teal-50/60 border-emerald-200 space-y-2.5">
                <div class="text-xs font-heading font-bold text-emerald-900 flex items-center gap-1.5">
                    <iconify-icon icon="solar:headphones-round-sound-bold" class="text-emerald-600 text-base"></iconify-icon>
                    <span>Bantuan Cepat NOC 24 Jam</span>
                </div>
                <p class="text-xs text-emerald-800 leading-relaxed">
                    Tim Network Operation Center siap siaga melayani konsultasi dan penanganan teknis Anda.
                </p>
                <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20NOC%20PT%20MSN,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20membutuhkan%20bantuan%20teknis" target="_blank" class="w-full py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:chat-round-dots-bold" width="16"></iconify-icon>
                    <span>WhatsApp NOC ({{ config('company.phone', '+62 896-9662-9955') }})</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
