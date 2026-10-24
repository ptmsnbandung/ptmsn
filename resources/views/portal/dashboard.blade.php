@extends('portal.layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="space-y-3 sm:space-y-5">

    <!-- Executive Dark Glassmorphism Hero Card -->
    <div id="tour-step-hero" class="hero-network-card p-3.5 sm:p-6 lg:p-7 relative">
        
        <div class="relative z-10 space-y-3 sm:space-y-4">
            
            <!-- Top Row: ID, Status Badge & Action Buttons -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4">
                
                <!-- Left: Greeting & Badges -->
                <div class="space-y-1.5 sm:space-y-2">
                    <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                        <button 
                            type="button"
                            onclick="copyToClipboard('{{ $customer->customer_id }}', 'ID Pelanggan {{ $customer->customer_id }}')" 
                            class="copy-btn inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-800/90 border border-slate-700/90 hover:border-sky-400 text-sky-300 font-mono text-[11px] sm:text-xs font-bold transition-all shadow-2xs whitespace-nowrap"
                            title="Klik untuk menyalin ID Pelanggan"
                        >
                            <iconify-icon icon="solar:hashtag-bold" class="text-sky-400 text-xs shrink-0"></iconify-icon>
                            <span>ID: {{ $customer->customer_id }}</span>
                            <iconify-icon icon="solar:copy-linear" class="text-slate-400 text-xs ml-0.5 shrink-0"></iconify-icon>
                        </button>

                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-[11px] sm:text-xs font-semibold {{ $customer->status_reg_badge_class }} whitespace-nowrap">
                            <span class="w-1.5 h-1.5 rounded-full {{ $customer->status_reg_dot_class }} shrink-0"></span>
                            <span>{{ $customer->status_reg_label }}</span>
                        </span>

                        @if($customer->berlangganan_sejak !== '-')
                            <span class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1 rounded-full border text-[10.5px] sm:text-xs font-semibold bg-slate-800/90 border-slate-700/90 text-cyan-300 shadow-2xs whitespace-nowrap" title="Total durasi aktif: {{ $customer->subscription_duration_text }}">
                                <iconify-icon icon="solar:calendar-date-bold" class="text-cyan-400 text-xs shrink-0"></iconify-icon>
                                <span class="hidden sm:inline">Bergabung </span>
                                <span>Sejak {{ $customer->berlangganan_sejak }}</span>
                                <span class="text-cyan-400/50">•</span>
                                <span class="text-emerald-400 font-mono">{{ $customer->subscription_duration_text }}</span>
                            </span>
                        @endif

                        <!-- Email Verification Status Badge / Trigger -->
                        @if(!empty($customer->email))
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-[10.5px] sm:text-xs font-semibold bg-emerald-500/15 border-emerald-400/40 text-emerald-300 shadow-2xs whitespace-nowrap" title="{{ $customer->email }}">
                                <iconify-icon icon="solar:verified-check-bold" class="text-emerald-400 text-xs shrink-0"></iconify-icon>
                                <span>Email Terverifikasi</span>
                            </span>
                        @else
                            <a 
                                href="{{ route('portal.profile') }}"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-[10.5px] sm:text-xs font-semibold bg-amber-500/15 border-amber-400/40 text-amber-300 hover:bg-amber-500/25 transition-all shadow-2xs whitespace-nowrap cursor-pointer"
                                title="Klik untuk melengkapi email di profil"
                            >
                                <iconify-icon icon="solar:letter-bold" class="text-amber-400 text-xs shrink-0"></iconify-icon>
                                <span>Verifikasi Email</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping"></span>
                            </a>
                        @endif
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
                    <div class="inline-flex items-center justify-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-slate-800/80 text-slate-300 font-heading font-bold text-xs sm:text-sm border border-slate-700/80 shadow-xs cursor-not-allowed select-none text-center opacity-80" title="Fitur Upgrade Paket segera hadir (Soon Launching)">
                        <iconify-icon icon="solar:round-transfer-vertical-bold" class="text-slate-400 text-sm sm:text-base shrink-0"></iconify-icon>
                        <span>Upgrade Paket</span>
                        <span class="px-1.5 py-0.5 rounded-md bg-amber-500/20 text-amber-300 border border-amber-400/30 text-[9px] font-mono font-bold uppercase tracking-wider">Soon Launching</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Status 4 KPI Cards Grid (Compact 2x2 on Mobile, 4 Cols on Desktop) -->
    <!-- Status 4 KPI Cards Grid (Compact 2x2 on Mobile, 4 Cols on Desktop) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3.5">
        
        <!-- Card 1: Paket Internet -->
        <div id="tour-step-package" class="kpi-stat-card kpi-sky flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                    <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Paket</span>
                    <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100 shrink-0">
                        <iconify-icon icon="solar:bolt-circle-bold" class="text-sm sm:text-base"></iconify-icon>
                    </div>
                </div>
                <div class="text-xs sm:text-sm lg:text-base font-heading font-extrabold text-slate-900 truncate" title="{{ $customer->package->name ?? 'Broadband FTTH' }}">
                    {{ $customer->package->name ?? 'Broadband FTTH' }}
                </div>
                <div class="text-[11px] sm:text-xs lg:text-sm font-mono text-sky-600 font-bold mt-0.5 truncate">
                    {{ $customer->package->speed ?? '25 Mbps' }}
                </div>
            </div>
            <div class="pt-2 mt-2 sm:pt-2.5 sm:mt-2.5 border-t border-slate-200/60 flex items-center justify-between text-[10px] sm:text-xs text-slate-600">
                <span class="flex items-center gap-1 truncate" title="Berlangganan sejak {{ $customer->berlangganan_sejak }}">
                    <iconify-icon icon="solar:calendar-date-bold" class="text-sky-500 text-xs shrink-0"></iconify-icon>
                    <span class="truncate font-medium">{{ $customer->subscription_duration_text }}</span>
                </span>
                <span class="text-emerald-600 font-semibold font-mono text-[9px] sm:text-[11px] shrink-0">Aktif</span>
            </div>
        </div>

        <!-- Card 2: Status Tagihan -->
        <div id="tour-step-billing" class="kpi-stat-card kpi-emerald flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                    <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Tagihan</span>
                    <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shrink-0">
                        <iconify-icon icon="solar:wallet-money-bold" class="text-sm sm:text-base"></iconify-icon>
                    </div>
                </div>
                <div class="text-xs sm:text-sm lg:text-base font-heading font-extrabold text-slate-900 truncate">
                    Rp {{ number_format($customer->billing_amount, 0, ',', '.') }}
                </div>
                <div class="text-[10px] sm:text-xs text-slate-500 mt-0.5 truncate">
                    Tempo Tgl {{ $customer->due_date }}/bln
                </div>
            </div>
            <div class="pt-2 mt-2 sm:pt-2.5 sm:mt-2.5 border-t border-slate-200/60 flex items-center justify-between gap-1">
                @if($customer->billing_status === 'paid')
                    <span class="badge-paid text-[9px] sm:text-[10px] px-1.5 py-0.5">
                        <iconify-icon icon="solar:check-read-linear"></iconify-icon>
                        <span>Lunas</span>
                    </span>
                @else
                    <span class="badge-unpaid text-[9px] sm:text-[10px] px-1.5 py-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                        <span>Menunggu</span>
                    </span>
                @endif
                <a href="{{ route('portal.billing.index') }}" class="text-sky-600 hover:text-sky-700 font-heading font-bold text-[10px] sm:text-xs hover:underline flex items-center gap-0.5 shrink-0">
                    <span>Bayar</span>
                    <iconify-icon icon="solar:alt-arrow-right-linear" class="text-[9px]"></iconify-icon>
                </a>
            </div>
        </div>

        <!-- Card 3: Tiket Kendala Aktif -->
        <div id="tour-step-tickets" class="kpi-stat-card kpi-amber flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                    <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Tiket</span>
                    <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shrink-0">
                        <iconify-icon icon="solar:shield-warning-bold" class="text-sm sm:text-base"></iconify-icon>
                    </div>
                </div>
                <div class="text-sm sm:text-base lg:text-xl font-heading font-extrabold text-slate-900 leading-tight">
                    {{ $activeTicketsCount }}
                </div>
                <div class="text-[10px] sm:text-xs text-slate-500 mt-0.5 truncate">
                    {{ $activeTicketsCount > 0 ? 'Sedang ditangani' : 'Jaringan Normal' }}
                </div>
            </div>
            <div class="pt-2 mt-2 sm:pt-2.5 sm:mt-2.5 border-t border-slate-200/60 text-[10px] sm:text-xs text-slate-500 flex items-center justify-between">
                <span class="truncate">Selesai: <strong class="text-emerald-600 font-mono">{{ $resolvedTicketsCount }}</strong></span>
                <a href="{{ route('portal.tickets.index') }}" class="text-sky-600 hover:text-sky-700 font-heading font-semibold text-[10px] sm:text-xs hover:underline shrink-0 flex items-center gap-0.5">
                    <span>Lihat</span>
                    <iconify-icon icon="solar:alt-arrow-right-linear" class="text-[9px]"></iconify-icon>
                </a>
            </div>
        </div>

        <!-- Card 4: Alamat Pemasangan -->
        <div class="kpi-stat-card kpi-purple flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                    <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Alamat Pasang</span>
                    <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 shrink-0">
                        <iconify-icon icon="solar:map-point-wave-bold" class="text-sm sm:text-base"></iconify-icon>
                    </div>
                </div>
                <div class="text-xs sm:text-sm font-heading font-bold text-slate-900 line-clamp-2 leading-tight min-h-[28px] sm:min-h-[32px]" title="{{ $customer->address ?: 'Alamat belum tercatat di sistem' }}">
                    {{ $customer->address ?: 'Alamat belum tercatat di sistem' }}
                </div>
            </div>
            <div class="pt-2 mt-2 sm:pt-2.5 sm:mt-2.5 border-t border-slate-200/60 flex items-center justify-between text-[10px] sm:text-xs text-slate-500">
                <span class="flex items-center gap-1 truncate text-slate-500" title="{{ $customer->city ?? 'Area Layanan' }}">
                    <iconify-icon icon="solar:city-bold" class="text-purple-500 text-xs shrink-0"></iconify-icon>
                    <span class="truncate">{{ $customer->city ?? 'Area Layanan' }}</span>
                </span>
                <a href="{{ route('portal.profile') }}" class="text-sky-600 hover:text-sky-700 font-heading font-semibold text-[10px] sm:text-xs hover:underline shrink-0 flex items-center gap-0.5">
                    <span>Lihat</span>
                    <iconify-icon icon="solar:alt-arrow-right-linear" class="text-[9px]"></iconify-icon>
                </a>
            </div>
        </div>

    </div>

    <!-- PWA Mobile App Card (Di Bawah Statistik Sesuai Panduan) -->
    <div id="pwa-dashboard-banner"
         x-data="pwaDashboardCard()"
         class="rounded-2xl p-4 sm:p-5 bg-gradient-to-br from-[#061122] via-[#0b1b33] to-[#081529] border border-sky-500/25 shadow-xl relative overflow-hidden text-white transition-all duration-300">
        
        <!-- Ambient Background Glow -->
        <div class="absolute -right-8 -top-8 w-44 h-44 bg-sky-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col gap-3.5 sm:gap-4">
            <div class="flex items-center gap-3.5 sm:gap-4">
                <!-- Clean & Sleek Smartphone Mockup (MyMSN) -->
                <div class="w-[50px] sm:w-[58px] h-[96px] sm:h-[110px] bg-slate-950 border-[2px] border-slate-700/90 rounded-[20px] sm:rounded-[22px] p-[2.5px] shadow-xl shrink-0 relative flex flex-col justify-between ring-1 ring-white/10">
                    <!-- Edge-to-Edge Clean White Screen Display -->
                    <div class="w-full h-full bg-white rounded-[16px] sm:rounded-[18px] flex flex-col items-center justify-between relative overflow-hidden p-1 shadow-sm">
                        <!-- Top Sleek Dynamic Island / Notch -->
                        <div class="w-5 sm:w-6 h-1.5 bg-slate-950 rounded-full mt-0.5 shrink-0"></div>

                        <!-- App Branding in Center: Logo Icon + MyMSN -->
                        <div class="flex flex-col items-center justify-center my-auto">
                            <img src="{{ asset('images/logo/logo-icon.png') }}" alt="MyMSN Logo" class="w-7 sm:w-8 h-7 sm:h-8 object-contain">
                            <span class="text-[9px] sm:text-[10px] font-heading font-black text-slate-900 tracking-tight block mt-1 leading-none">MyMSN</span>
                        </div>

                        <!-- Bottom Home Indicator -->
                        <div class="w-6 sm:w-7 h-0.5 bg-slate-300 rounded-full mb-0.5 shrink-0"></div>

                        <!-- Subtle Screen Glass Glare Reflection -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/5 to-white/35 pointer-events-none rounded-[16px]"></div>
                    </div>
                </div>

                <!-- Text Info -->
                <div class="flex-1 min-w-0 space-y-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-sm sm:text-base font-heading font-extrabold text-white tracking-tight">
                            Aplikasi Mobile PT MSN
                        </h3>
                        <template x-if="isInstalled">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                Terpasang
                            </span>
                        </template>
                        <template x-if="!isInstalled">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-500/20 text-sky-300 border border-sky-500/30">
                                PWA
                            </span>
                        </template>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed"
                       x-text="isInstalled ? 'Aplikasi resmi MyMSN telah terpasang di perangkat Anda. Akses cepat dan praktis tanpa buka browser.' : 'Pasang aplikasi untuk akses cepat, praktis, dan notifikasi langsung di HP.'">
                        Pasang aplikasi untuk akses cepat, praktis, dan notifikasi langsung di HP.
                    </p>
                </div>
            </div>

            <!-- Installation Visual Progress Indicator (Muncul saat proses download & pasang) -->
            <div x-show="isInstalling" x-cloak class="space-y-2 pt-1 pb-1">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-sky-300 font-semibold flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 animate-spin text-sky-400 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span x-text="installStepText">Mengunduh aset & konfigurasi...</span>
                    </span>
                    <span class="font-mono font-bold text-sky-400" x-text="installProgress + '%'">0%</span>
                </div>
                
                <!-- Animated Progress Track & Bar -->
                <div class="w-full h-2 rounded-full bg-slate-900/90 overflow-hidden border border-slate-700/80 p-0.5 shadow-inner">
                    <div class="h-full rounded-full bg-gradient-to-r from-sky-500 via-blue-500 to-emerald-400 transition-all duration-300 ease-out"
                         :style="'width: ' + installProgress + '%'"></div>
                </div>

                <div class="flex items-center justify-between text-[10px] text-slate-400">
                    <span>*Aplikasi PWA dipasang langsung ke sistem HP</span>
                    <span class="font-mono text-emerald-400" x-show="installProgress >= 100">Siap Digunakan</span>
                </div>
            </div>

            <!-- Full Width Action Button (Pasang Aplikasi / Buka Aplikasi) -->
            <button type="button"
                    @click="handleAction()"
                    :disabled="isInstalling"
                    :class="isInstalled ? 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-emerald-600/25' : (isInstalling ? 'bg-slate-800 text-slate-400 cursor-wait opacity-80' : 'bg-gradient-to-r from-blue-600 via-sky-600 to-blue-700 hover:from-blue-500 hover:to-sky-500 shadow-sky-600/30')"
                    class="w-full py-2.5 sm:py-3 px-4 rounded-xl text-white font-heading font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-lg transition-all active:scale-[0.98] cursor-pointer">
                
                <!-- State 1: Sedang Memasang -->
                <template x-if="isInstalling">
                    <div class="flex items-center gap-2 text-sky-300">
                        <svg class="w-4 h-4 animate-spin text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Memasang Aplikasi (<span x-text="installProgress + '%'"></span>)...</span>
                    </div>
                </template>

                <!-- State 2: Belum Pasang -->
                <template x-if="!isInstalled && !isInstalling">
                    <div class="flex items-center gap-2">
                        <iconify-icon icon="solar:download-minimalistic-bold" class="text-base sm:text-lg shrink-0"></iconify-icon>
                        <span>Pasang Aplikasi</span>
                    </div>
                </template>

                <!-- State 3: Sudah Terpasang -> Buka Aplikasi -->
                <template x-if="isInstalled && !isInstalling">
                    <div class="flex items-center gap-2">
                        <iconify-icon icon="solar:play-circle-bold" class="text-base sm:text-lg text-emerald-200 shrink-0"></iconify-icon>
                        <span>Buka Aplikasi</span>
                    </div>
                </template>
            </button>
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
                        <div class="portal-card rounded-xl sm:rounded-2xl p-3 sm:p-4 lg:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3 overflow-hidden">
                            <div class="space-y-1 sm:space-y-1.5 flex-1 min-w-0">
                                <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                    <span class="text-[11px] sm:text-xs font-mono font-bold text-sky-700 bg-sky-50 border border-sky-200 px-2 py-0.5 rounded-md sm:rounded-lg shrink-0">
                                        #{{ $ticket->ticket_number }}
                                    </span>
                                    <span class="text-[10px] sm:text-[11px] font-sans px-2 sm:px-2.5 py-0.5 rounded-full {{ $ticket->status_badge_class }} font-semibold shrink-0">
                                        {{ $ticket->status_label }}
                                    </span>
                                    <span class="text-[10px] sm:text-[11px] font-sans px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200 shrink-0">
                                        {{ $ticket->category_label }}
                                    </span>
                                    <span class="text-[10px] sm:text-[11px] text-slate-400 font-mono shrink-0">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h3 class="text-xs sm:text-sm lg:text-base font-heading font-bold text-slate-900 truncate">
                                    {{ $ticket->subject }}
                                </h3>
                                <p class="text-[11px] sm:text-xs text-slate-500 truncate">
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
                                <a href="{{ route('portal.tickets.show', $ticket->id) }}" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-slate-100 hover:bg-sky-600 text-slate-400 hover:text-white flex items-center justify-center transition-all ml-auto sm:ml-0 shadow-2xs active:scale-95" title="Lihat detail laporan kendala" aria-label="Lihat detail laporan kendala">
                                    <iconify-icon icon="solar:arrow-right-linear" class="text-sm sm:text-base"></iconify-icon>
                                </a>
                            </div>
                        </div>
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
        <div id="tour-step-help" class="space-y-2.5 sm:space-y-4">
            
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
                <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20NOC%20PT%20MSN,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20membutuhkan%20bantuan%20teknis" target="_blank" class="w-full py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs transition-all flex items-center justify-center gap-2 shadow-xs">
                    <iconify-icon icon="logos:whatsapp-icon" width="16"></iconify-icon>
                    <span>WhatsApp NOC</span>
                </a>
            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function pwaDashboardCard() {
    return {
        isInstalled: false,
        isInstalling: false,
        installProgress: 0,
        installStepText: 'Menyiapkan paket aplikasi...',
        progressTimer: null,

        init() {
            this.checkInstallation();

            // Dengarkan event ketika prompt install siap
            window.addEventListener('pwa-prompt-available', () => {
                this.checkInstallation();
            });

            // Dengarkan event ketika app berhasil diinstall oleh OS
            window.addEventListener('pwa-installed-success', () => {
                this.onInstallCompleted();
            });

            window.addEventListener('appinstalled', () => {
                this.onInstallCompleted();
            });
        },

        checkInstallation() {
            const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
            const isMarkedInstalled = localStorage.getItem('pwa_installed') === 'true';
            this.isInstalled = isStandalone || isMarkedInstalled;
        },

        startProgressIndicator(callback) {
            this.isInstalling = true;
            this.installProgress = 15;
            this.installStepText = 'Mengunduh aset & konfigurasi MyMSN...';

            if (this.progressTimer) clearInterval(this.progressTimer);

            this.progressTimer = setInterval(() => {
                if (this.installProgress < 45) {
                    this.installProgress += 10;
                    this.installStepText = 'Mengunduh icon & modul antarmuka...';
                } else if (this.installProgress < 80) {
                    this.installProgress += 7;
                    this.installStepText = 'Menyiapkan pemasangan ke sistem HP...';
                } else if (this.installProgress < 95) {
                    this.installProgress += 3;
                    this.installStepText = 'Memasang icon ke Layar Utama...';
                }
            }, 300);

            if (callback) {
                setTimeout(callback, 600);
            }
        },

        onInstallCompleted() {
            if (this.progressTimer) clearInterval(this.progressTimer);
            this.installProgress = 100;
            this.installStepText = 'Pemasangan Berhasil 100%!';
            this.isInstalled = true;
            localStorage.setItem('pwa_installed', 'true');

            setTimeout(() => {
                this.isInstalling = false;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Aplikasi MyMSN Terpasang! 🎉',
                        html: '<div class="text-left text-xs text-slate-600 dark:text-slate-300 space-y-2 mt-2">' +
                              '<p>Aplikasi resmi <b>MyMSN</b> telah berhasil ditambahkan ke HP Anda.</p>' +
                              '<p class="text-slate-500 text-[11px]">Silakan buka <b>Layar Utama (Homescreen)</b> atau cari di <b>Daftar Semua Aplikasi</b> di HP Anda untuk menjalankannya langsung tanpa browser.</p>' +
                              '</div>',
                        icon: 'success',
                        confirmButtonText: 'Siap',
                        confirmButtonColor: '#0284c7'
                    });
                }
            }, 800);
        },

        async handleAction() {
            const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;

            if (isStandalone) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Aplikasi Sedang Aktif',
                        text: 'Anda saat ini sudah menjalankan aplikasi resmi MyMSN di HP.',
                        icon: 'success',
                        confirmButtonColor: '#0284c7'
                    });
                } else {
                    alert('Aplikasi MyMSN sudah aktif dan berjalan!');
                }
                return;
            }

            if (this.isInstalled) {
                // User mengklik Buka Aplikasi dari dalam browser Chrome biasa
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Status Pemasangan MyMSN',
                        html: '<div class="text-left text-xs text-slate-600 dark:text-slate-300 space-y-2.5 mt-2">' +
                              '<p>Aplikasi telah didaftarkan ke sistem HP Anda.</p>' +
                              '<div class="p-2.5 rounded-lg bg-sky-50 dark:bg-sky-950/40 border border-sky-200 dark:border-sky-800/50 space-y-1.5">' +
                              '<p class="font-bold text-sky-700 dark:text-sky-300">1. Notifikasi "Menginstal MyMSN...":</p>' +
                              '<p class="text-[11px] text-slate-600 dark:text-slate-400">Jika notifikasi masih muncul di bar atas HP, tunggu sekitar 15–30 detik hingga sistem Android selesai memproses.</p>' +
                              '</div>' +
                              '<div class="p-2.5 rounded-lg bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-1.5">' +
                              '<p class="font-bold text-slate-700 dark:text-slate-200">2. Cari di Menu HP:</p>' +
                              '<p class="text-[11px] text-slate-600 dark:text-slate-400">Geser layar HP ke atas (Daftar Semua Aplikasi / App Drawer) lalu cari <b>MyMSN</b>.</p>' +
                              '</div>' +
                              '<p class="text-[11px] text-slate-400">Ikon belum muncul? Anda juga bisa ketuk menu titik tiga (⋮) di pojok kanan atas Chrome lalu pilih <b>"Tambahkan ke Layar Utama"</b>.</p>' +
                              '</div>',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Pasang Ulang via Menu',
                        cancelButtonText: 'Tutup',
                        confirmButtonColor: '#0284c7'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            localStorage.removeItem('pwa_installed');
                            this.isInstalled = false;
                            this.handleAction();
                        }
                    });
                } else {
                    alert('Silakan cek Layar Utama atau Daftar Aplikasi di HP Anda untuk membuka MyMSN.');
                }
                return;
            }

            // Jika belum diinstall: Jalankan progress dan prompt install
            if (window.pwaDeferredPrompt) {
                this.startProgressIndicator(async () => {
                    try {
                        window.pwaDeferredPrompt.prompt();
                        const { outcome } = await window.pwaDeferredPrompt.userChoice;
                        console.log('[PWA] Pilihan user:', outcome);
                        if (outcome === 'accepted') {
                            this.installProgress = 90;
                            this.installStepText = 'Memproses instalasi ke sistem Android...';
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Sedang Memasang ke HP...',
                                    html: '<div class="text-left text-xs text-slate-600 dark:text-slate-300 space-y-2 mt-2">' +
                                          '<p>Permintaan pemasangan diterima! Sistem Android saat ini sedang memasang aplikasi <b>MyMSN</b> di latar belakang.</p>' +
                                          '<p class="text-sky-600 dark:text-sky-400 font-semibold">Perhatikan bar notifikasi HP Anda ("Menginstal MyMSN...").</p>' +
                                          '<p class="text-slate-500 text-[11px]">Setelah notifikasi selesai (sekitar 10–30 detik), ikon MyMSN otomatis muncul di Layar Utama / Daftar Aplikasi HP Anda.</p>' +
                                          '</div>',
                                    icon: 'info',
                                    confirmButtonText: 'Baik, Saya Mengerti',
                                    confirmButtonColor: '#0284c7'
                                });
                            }
                        } else {
                            if (this.progressTimer) clearInterval(this.progressTimer);
                            this.isInstalling = false;
                            this.installProgress = 0;
                        }
                        window.pwaDeferredPrompt = null;
                    } catch (e) {
                        if (this.progressTimer) clearInterval(this.progressTimer);
                        this.isInstalling = false;
                    }
                });
            } else {
                const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                if (isIos) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Pasang di iPhone / iPad',
                            html: '<div class="text-left text-xs text-slate-600 space-y-2 mt-2">' +
                                  '<p>1. Ketuk ikon <b>Bagikan (Share)</b> di Safari (tanda kotak berpanah ke atas di bilah bawah).</p>' +
                                  '<p>2. Geser ke bawah lalu pilih menu <b>"Tambah ke Layar Utama" (Add to Home Screen)</b>.</p>' +
                                  '<p>3. Ketuk <b>Tambah</b> di pojok kanan atas.</p>' +
                                  '</div>',
                            icon: 'info',
                            confirmButtonText: 'Saya Mengerti',
                            confirmButtonColor: '#0284c7'
                        });
                    } else {
                        alert('Untuk memasang di iPhone/iPad:\n1. Ketuk ikon Bagikan (Share) di Safari.\n2. Pilih "Tambah ke Layar Utama" (Add to Home Screen).');
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Pasang Aplikasi MyMSN',
                            html: '<div class="text-left text-xs text-slate-600 space-y-2 mt-2">' +
                                  '<p>Jika pop-up otomatis tidak muncul:</p>' +
                                  '<p>1. Ketuk ikon menu titik tiga (⋮) di pojok kanan atas browser Chrome.</p>' +
                                  '<p>2. Pilih menu <b>"Install app"</b> atau <b>"Tambahkan ke Layar Utama"</b>.</p>' +
                                  '</div>',
                            icon: 'info',
                            confirmButtonText: 'Tutup',
                            confirmButtonColor: '#0284c7'
                        });
                    } else {
                        alert('Ketuk menu titik tiga (⋮) di browser Anda, lalu pilih "Install app" atau "Tambahkan ke Layar Utama".');
                    }
                }
            }
        }
    };
}
</script>
@endpush
