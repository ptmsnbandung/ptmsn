@extends('portal.layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="space-y-3 sm:space-y-5">

    <!-- Executive Dark Glassmorphism Hero Card -->
    <div class="hero-network-card p-3.5 sm:p-6 lg:p-7 relative">
        
        <div class="relative z-10 space-y-3 sm:space-y-4">
            
            <!-- Top Row: ID, Status Badge & Action Buttons -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4">
                
                <!-- Left: Greeting & Badges -->
                <div class="space-y-1.5 sm:space-y-2">
                    <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                        <button 
                            type="button"
                            onclick="copyToClipboard('{{ $customer->customer_id }}', 'ID Pelanggan {{ $customer->customer_id }}')" 
                            class="copy-btn inline-flex items-center gap-1 px-2.5 py-0.5 sm:py-1 rounded-lg bg-slate-800/90 border border-slate-700/90 hover:border-sky-400 text-sky-300 font-mono text-[11px] sm:text-xs font-bold transition-all shadow-2xs"
                            title="Klik untuk menyalin ID Pelanggan"
                        >
                            <iconify-icon icon="solar:hashtag-bold" class="text-sky-400 text-xs"></iconify-icon>
                            <span>ID: {{ $customer->customer_id }}</span>
                            <iconify-icon icon="solar:copy-linear" class="text-slate-400 text-xs ml-0.5"></iconify-icon>
                        </button>

                        @if($customer->status === 'active')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 sm:py-1 rounded-full bg-emerald-950/80 border border-emerald-500/50 text-emerald-300 text-[11px] sm:text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>Koneksi FTTH Aktif</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 sm:py-1 rounded-full bg-rose-950/80 border border-rose-500/50 text-rose-300 text-[11px] sm:text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                <span>Status: {{ ucfirst($customer->status) }}</span>
                            </span>
                        @endif

                        <span class="inline-flex items-center gap-1 px-2 py-0.5 sm:py-1 rounded-lg bg-slate-800/80 border border-slate-700/80 text-slate-300 font-mono text-[10px] sm:text-[11px]">
                            <iconify-icon icon="solar:server-path-bold" class="text-sky-400"></iconify-icon>
                            <span>GPON OLT Online</span>
                        </span>
                    </div>

                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-heading font-extrabold text-white tracking-tight">
                        Halo, {{ $customer->name }}! 👋
                    </h1>
                    
                    <p class="text-xs sm:text-sm text-slate-200/90 max-w-2xl leading-relaxed">
                        Pantau performa koneksi internet broadband dan rincian layanan Anda secara real-time.
                    </p>
                </div>

                <!-- Right: Action Buttons -->
                <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center sm:gap-2.5 shrink-0">
                    <a href="{{ route('portal.tickets.create') }}" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-bold text-xs sm:text-sm shadow-md transition-all active:scale-95 text-center">
                        <iconify-icon icon="solar:danger-triangle-bold" class="text-amber-300 text-sm sm:text-base shrink-0"></iconify-icon>
                        <span>Lapor Gangguan</span>
                    </a>
                    <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20NOC%20PT%20MSN,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20({{ urlencode($customer->name) }})%20ingin%20konsultasi%20layanan" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs sm:text-sm shadow-md transition-all active:scale-95 text-center">
                        <iconify-icon icon="solar:chat-round-dots-bold" class="text-white text-sm sm:text-base shrink-0"></iconify-icon>
                        <span>Hubungi NOC</span>
                    </a>
                </div>

            </div>

        </div>

    </div>

    <!-- Status 4 KPI Cards Grid (Compact 2x2 on Mobile, 4 Cols on Desktop) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3.5">
        
        <!-- Card 1: Paket Internet -->
        <div class="kpi-stat-card kpi-sky flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Paket</span>
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100 shrink-0">
                        <iconify-icon icon="solar:bolt-circle-bold" class="text-base sm:text-lg"></iconify-icon>
                    </div>
                </div>
                <div class="text-sm sm:text-base lg:text-lg font-heading font-extrabold text-slate-900 truncate" title="{{ $customer->package->name ?? 'Broadband FTTH' }}">
                    {{ $customer->package->name ?? 'Broadband FTTH' }}
                </div>
                <div class="text-xs sm:text-sm font-mono text-sky-600 font-bold mt-0.5">
                    {{ $customer->package->speed ?? '25 Mbps' }}
                </div>
            </div>
            <div class="pt-2 mt-2 sm:pt-2.5 sm:mt-2.5 border-t border-slate-200/60 text-[10px] sm:text-xs text-slate-600 flex items-center gap-1">
                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-500 text-xs shrink-0"></iconify-icon>
                <span class="font-medium truncate">Tanpa FUP (Unlimited)</span>
            </div>
        </div>

        <!-- Card 2: Status Tagihan -->
        <div class="kpi-stat-card kpi-emerald flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Tagihan</span>
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shrink-0">
                        <iconify-icon icon="solar:wallet-money-bold" class="text-base sm:text-lg"></iconify-icon>
                    </div>
                </div>
                <div class="text-sm sm:text-base lg:text-lg font-heading font-extrabold text-slate-900 truncate">
                    Rp {{ number_format($customer->billing_amount, 0, ',', '.') }}
                </div>
                <div class="text-[10px] sm:text-xs text-slate-500 mt-0.5 truncate">
                    Tempo: Tgl {{ $customer->due_date }} / bln
                </div>
            </div>
            <div class="pt-2 mt-2 sm:pt-2.5 sm:mt-2.5 border-t border-slate-200/60 flex items-center justify-between gap-1">
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
                <a href="{{ route('portal.billing.index') }}" class="text-sky-600 hover:text-sky-700 font-heading font-bold text-[11px] sm:text-xs hover:underline flex items-center gap-0.5">
                    <span>Bayar</span>
                    <iconify-icon icon="solar:alt-arrow-right-linear"></iconify-icon>
                </a>
            </div>
        </div>

        <!-- Card 3: Tiket Kendala Aktif -->
        <div class="kpi-stat-card kpi-amber flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Tiket</span>
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shrink-0">
                        <iconify-icon icon="solar:shield-warning-bold" class="text-base sm:text-lg"></iconify-icon>
                    </div>
                </div>
                <div class="text-base sm:text-lg lg:text-xl font-heading font-extrabold text-slate-900">
                    {{ $activeTicketsCount }}
                </div>
                <div class="text-[10px] sm:text-xs text-slate-500 mt-0.5 truncate">
                    {{ $activeTicketsCount > 0 ? 'Sedang ditangani' : 'Jaringan Normal' }}
                </div>
            </div>
            <div class="pt-2 mt-2 sm:pt-2.5 sm:mt-2.5 border-t border-slate-200/60 text-[10px] sm:text-xs text-slate-500 flex items-center justify-between">
                <span>Selesai: <strong class="text-emerald-600 font-mono">{{ $resolvedTicketsCount }}</strong></span>
                <a href="{{ route('portal.tickets.index') }}" class="text-sky-600 hover:text-sky-700 font-heading font-semibold text-[11px] sm:text-xs hover:underline">
                    Lihat
                </a>
            </div>
        </div>

        <!-- Card 4: Parameter Jaringan -->
        <div class="kpi-stat-card kpi-purple flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Jaringan</span>
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 shrink-0">
                        <iconify-icon icon="solar:map-point-wave-bold" class="text-base sm:text-lg"></iconify-icon>
                    </div>
                </div>
                <button 
                    type="button"
                    onclick="copyToClipboard('{{ $customer->ip_address ?? '10.20.104.22' }}', 'IP Address')" 
                    class="copy-btn text-left group w-full"
                    title="Klik untuk menyalin IP"
                >
                    <div class="text-xs sm:text-sm font-mono font-bold text-sky-600 truncate flex items-center gap-1 group-hover:text-sky-700">
                        <span>{{ $customer->ip_address ?? '10.20.104.22' }}</span>
                        <iconify-icon icon="solar:copy-linear" class="text-slate-400 group-hover:text-sky-600 text-xs shrink-0"></iconify-icon>
                    </div>
                </button>
                <div class="text-[10px] sm:text-xs text-slate-500 mt-0.5 truncate">
                    {{ $customer->city ?? 'Area Layanan' }} — GPON
                </div>
            </div>
            <div class="pt-2 mt-2 sm:pt-2.5 sm:mt-2.5 border-t border-slate-200/60 flex items-center justify-between text-[10px] sm:text-xs text-slate-500">
                <span class="flex items-center gap-1">
                    <iconify-icon icon="solar:server-path-bold" class="text-sky-500"></iconify-icon>
                    <span>Fiber</span>
                </span>
                <span class="signal-bars signal-full" title="Kekuatan Sinyal Sangat Baik">
                    <span></span><span></span><span></span><span></span>
                </span>
            </div>
        </div>

    </div>

    <!-- Main Content Section: Recent Tickets & Diagnostics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-5">
        
        <!-- Left 2 Cols: Recent Trouble Tickets -->
        <div class="lg:col-span-2 space-y-2.5 sm:space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                        <iconify-icon icon="solar:ticket-sale-bold" class="text-sm sm:text-base"></iconify-icon>
                    </div>
                    <h2 class="text-sm sm:text-base lg:text-lg font-heading font-bold text-slate-900">Riwayat Laporan Kendala</h2>
                </div>
                <a href="{{ route('portal.tickets.index') }}" class="text-[11px] sm:text-xs font-heading font-semibold text-sky-600 hover:text-sky-700 hover:underline flex items-center gap-0.5">
                    <span>Lihat Semua</span>
                    <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
                </a>
            </div>

            @if($recentTickets->count() > 0)
                <div class="space-y-2.5 sm:space-y-3">
                    @foreach($recentTickets as $ticket)
                        <a href="{{ route('portal.tickets.show', $ticket->id) }}" class="portal-card portal-card-hover rounded-xl sm:rounded-2xl p-3 sm:p-4 lg:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3 block group">
                            <div class="space-y-1 sm:space-y-1.5 flex-1">
                                <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                    <span class="text-[11px] sm:text-xs font-mono font-bold text-sky-700 bg-sky-50 border border-sky-200 px-2 py-0.5 rounded-md sm:rounded-lg">
                                        #{{ $ticket->ticket_number }}
                                    </span>
                                    <span class="text-[10px] sm:text-[11px] font-sans px-2 sm:px-2.5 py-0.5 rounded-full {{ $ticket->status_badge_class }} font-semibold">
                                        {{ $ticket->status_label }}
                                    </span>
                                    <span class="text-[10px] sm:text-[11px] font-sans px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $ticket->category_label }}
                                    </span>
                                    <span class="text-[10px] sm:text-[11px] text-slate-400 font-mono">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h3 class="text-xs sm:text-sm lg:text-base font-heading font-bold text-slate-900 group-hover:text-sky-600 transition-colors line-clamp-1">
                                    {{ $ticket->subject }}
                                </h3>
                                <p class="text-[11px] sm:text-xs text-slate-500 line-clamp-1">
                                    {{ $ticket->description }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-2.5 sm:gap-3 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 text-xs">
                                @if($ticket->technician_name)
                                    <div class="text-left sm:text-right">
                                        <span class="text-slate-400 text-[10px] block sm:inline">Teknisi:</span>
                                        <span class="text-slate-700 font-semibold text-xs">{{ $ticket->technician_name }}</span>
                                    </div>
                                @endif
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-slate-100 group-hover:bg-sky-600 group-hover:text-white flex items-center justify-center text-slate-400 transition-all ml-auto sm:ml-0">
                                    <iconify-icon icon="solar:arrow-right-linear" width="14 sm:16"></iconify-icon>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="portal-card rounded-xl sm:rounded-2xl p-5 sm:p-8 text-center space-y-2.5">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 mx-auto flex items-center justify-center shadow-xs">
                        <iconify-icon icon="solar:check-circle-bold" class="text-2xl sm:text-3xl"></iconify-icon>
                    </div>
                    <div class="text-sm sm:text-base font-heading font-bold text-slate-900">Tidak Ada Laporan Gangguan Aktif</div>
                    <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                        Koneksi internet Anda beroperasi normal. Jika Anda mengalami kendala teknis, silakan buat laporan ke tim NOC.
                    </p>
                    <div class="pt-1.5">
                        <a href="{{ route('portal.tickets.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl bg-sky-500 hover:bg-sky-600 text-white text-xs font-heading font-bold shadow-xs transition-all">
                            <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
                            <span>Buat Laporan Baru</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right 1 Col: Speedtest & Quick Diagnostics -->
        <div class="space-y-2.5 sm:space-y-4">
            
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                    <iconify-icon icon="solar:settings-bold" class="text-sm sm:text-base"></iconify-icon>
                </div>
                <h2 class="text-sm sm:text-base lg:text-lg font-heading font-bold text-slate-900">Diagnostik & Panduan</h2>
            </div>

            <!-- Speedtest Box -->
            <div class="portal-card rounded-xl sm:rounded-2xl p-3.5 sm:p-5 space-y-2.5 sm:space-y-3">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                        <iconify-icon icon="solar:bolt-circle-bold" class="text-lg sm:text-xl"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-xs sm:text-sm font-heading font-bold text-slate-900">Uji Kecepatan Internet</div>
                        <div class="text-[11px] sm:text-xs text-slate-500">Cek speed download & upload</div>
                    </div>
                </div>
                <a href="https://fast.com" target="_blank" class="w-full py-2 px-3 sm:py-2.5 sm:px-4 rounded-xl bg-slate-50/80 hover:bg-sky-50 border border-slate-200 text-xs font-heading font-bold text-slate-700 hover:text-sky-700 transition-all flex items-center justify-center gap-1.5 shadow-2xs">
                    <iconify-icon icon="solar:play-circle-bold" class="text-sky-500" width="16"></iconify-icon>
                    <span>Buka Fast.com Speedtest</span>
                    <iconify-icon icon="solar:arrow-right-up-linear" width="14"></iconify-icon>
                </a>
            </div>

            <!-- Troubleshooting Tips -->
            <div class="portal-card rounded-xl sm:rounded-2xl p-3.5 sm:p-5 space-y-2.5 sm:space-y-3">
                <div class="text-xs font-heading font-bold text-slate-900 flex items-center gap-1.5">
                    <iconify-icon icon="solar:lightbulb-bolt-bold" class="text-amber-500 text-sm sm:text-base"></iconify-icon>
                    <span>Langkah Cepat Penanganan:</span>
                </div>
                
                <div class="space-y-2 text-xs">
                    <div class="p-2.5 sm:p-3 rounded-xl bg-slate-50/70 border border-slate-200/80 space-y-0.5">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5 text-[11px] sm:text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            <span>1. Lampu LOS Modem Merah</span>
                        </div>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 pl-3 leading-relaxed">
                            Kabel patchcord fiber optic terlipat atau putus. Jangan ditarik paksa, segera laporkan ke tim teknisi NOC.
                        </p>
                    </div>

                    <div class="p-2.5 sm:p-3 rounded-xl bg-slate-50/70 border border-slate-200/80 space-y-0.5">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5 text-[11px] sm:text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span>2. WiFi "No Internet"</span>
                        </div>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 pl-3 leading-relaxed">
                            Matikan tombol power modem ONT selama 30 detik lalu hidupkan kembali (Power Cycle) agar IP router tersegarkan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Help Contact Box -->
            <div class="portal-card rounded-xl sm:rounded-2xl p-3.5 sm:p-5 bg-gradient-to-br from-emerald-50/80 to-teal-50/50 border-emerald-200/80 space-y-2">
                <div class="text-xs font-heading font-bold text-emerald-900 flex items-center gap-1.5">
                    <iconify-icon icon="solar:headphones-round-sound-bold" class="text-emerald-600 text-sm sm:text-base"></iconify-icon>
                    <span>Bantuan Cepat NOC 24 Jam</span>
                </div>
                <p class="text-[11px] sm:text-xs text-emerald-800 leading-relaxed">
                    Tim NOC siap siaga melayani konsultasi dan penanganan teknis Anda.
                </p>
                <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20NOC%20PT%20MSN,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20membutuhkan%20bantuan%20teknis" target="_blank" class="w-full py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-xs">
                    <iconify-icon icon="solar:chat-round-dots-bold" width="16"></iconify-icon>
                    <span>WhatsApp NOC ({{ config('company.phone', '+62 896-9662-9955') }})</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
