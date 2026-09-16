@extends('portal.layouts.app')

@section('title', 'Detail Tiket #' . $ticket->ticket_number)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Back Link & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('portal.tickets.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-[#38bdf8] transition-colors mb-2 font-mono">
                <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                <span>Kembali ke Daftar Laporan</span>
            </a>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl font-heading font-extrabold text-white tracking-tight">
                    Tiket #{{ $ticket->ticket_number }}
                </h1>
                <span class="text-xs px-3 py-1 rounded-full {{ $ticket->status_badge_class }} font-semibold">
                    {{ $ticket->status_label }}
                </span>
            </div>
            <div class="text-xs text-slate-400 mt-1 font-mono">
                Dibuat pada: {{ $ticket->created_at->translatedFormat('d F Y, H:i') }} WIB
            </div>
        </div>

        <a href="https://wa.me/6281214878436?text=Halo%20NOC%20PT%20MSN,%20saya%20ingin%20menanyakan%20progres%20Tiket%20Gangguan%20%23{{ $ticket->ticket_number }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-500/15 hover:bg-emerald-500/25 border border-emerald-500/30 text-emerald-400 font-heading font-bold text-xs transition-all self-start sm:self-auto">
            <iconify-icon icon="solar:chat-round-dots-bold" width="16"></iconify-icon>
            <span>Tanya via WhatsApp</span>
        </a>
    </div>

    <!-- Live Status Tracker (Visual Stepper) -->
    <div class="portal-card rounded-3xl p-6 sm:p-8">
        <div class="text-xs font-mono font-bold uppercase tracking-wider text-[#38bdf8] mb-6 flex items-center gap-2">
            <iconify-icon icon="solar:history-bold"></iconify-icon>
            <span>Status Progres Penanganan:</span>
        </div>

        @php
            $currentStep = match((string) $ticket->status) {
                '11', 'open' => 1,
                '12', '13', 'in_progress', 'proses' => 2,
                '14', 'resolved', 'closed', 'done', 'close' => 3,
                default => 1,
            };
        @endphp

        <div class="relative">
            <!-- Connecting Line -->
            <div class="hidden sm:block absolute top-5 left-10 right-10 h-0.5 bg-white/10 z-0">
                <div class="h-full bg-gradient-to-r from-sky-400 to-emerald-400 transition-all duration-500" style="width: {{ $currentStep === 1 ? '15%' : ($currentStep === 2 ? '60%' : '100%') }}"></div>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-2 relative z-10">
                
                <!-- Step 1: Laporan Diterima -->
                <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 {{ $currentStep >= 1 ? 'bg-sky-500 text-[#050d1a] shadow-[0_0_15px_rgba(56,189,248,0.5)] font-bold' : 'bg-white/10 text-slate-400' }}">
                        <iconify-icon icon="solar:inbox-in-bold" width="20"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-bold {{ $currentStep >= 1 ? 'text-white' : 'text-slate-400' }}">1. Laporan Diterima</div>
                        <div class="text-[11px] text-slate-400">Verifikasi & Antrian NOC</div>
                    </div>
                </div>

                <!-- Step 2: Sedang Ditangani / Investigasi -->
                <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 {{ $currentStep >= 2 ? 'bg-sky-500 text-[#050d1a] shadow-[0_0_15px_rgba(56,189,248,0.5)] font-bold animate-pulse' : 'bg-white/10 text-slate-400' }}">
                        <iconify-icon icon="solar:wrench-bold" width="20"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-bold {{ $currentStep >= 2 ? 'text-white' : 'text-slate-400' }}">2. Sedang Ditangani</div>
                        <div class="text-[11px] text-slate-400">Pemeriksaan NOC & Teknisi</div>
                    </div>
                </div>

                <!-- Step 3: Selesai / Pulih -->
                <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 {{ $currentStep >= 3 ? 'bg-emerald-500 text-[#050d1a] shadow-[0_0_15px_rgba(16,185,129,0.5)] font-bold' : 'bg-white/10 text-slate-400' }}">
                        <iconify-icon icon="solar:check-circle-bold" width="20"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-bold {{ $currentStep >= 3 ? 'text-white' : 'text-slate-400' }}">3. Gangguan Selesai</div>
                        <div class="text-[11px] text-slate-400">Koneksi Kembali Normal</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Ticket Detail Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Cols: Issue Content & Technician Notes -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Issue Details -->
            <div class="portal-card rounded-3xl p-6 sm:p-7 space-y-4">
                <div class="text-xs font-mono font-bold uppercase tracking-wider text-slate-400">Informasi Kendala</div>
                
                <div>
                    <h2 class="text-lg font-heading font-bold text-white mb-2">{{ $ticket->subject }}</h2>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed whitespace-pre-line bg-white/[0.03] p-4 rounded-2xl border border-white/5">
                        {{ $ticket->description }}
                    </p>
                </div>

                @if($ticket->photo_path)
                    <div class="pt-2">
                        <div class="text-xs font-mono text-slate-400 mb-2">Lampiran Foto Bukti:</div>
                        <div class="rounded-2xl overflow-hidden border border-white/10 max-w-sm">
                            <img src="{{ asset('storage/' . $ticket->photo_path) }}" alt="Bukti Kendala" class="w-full h-auto object-cover">
                        </div>
                    </div>
                @endif
            </div>

            <!-- Technician Action / Resolution Box -->
            @if($ticket->resolution_notes || $ticket->technician_name)
                <div class="portal-card rounded-3xl p-6 sm:p-7 border-sky-500/30 bg-gradient-to-br from-sky-950/30 to-[#08172c] space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="text-xs font-mono font-bold uppercase tracking-wider text-[#38bdf8] flex items-center gap-1.5">
                            <iconify-icon icon="solar:user-hand-up-bold"></iconify-icon>
                            <span>Tindakan Tim Teknis PT MSN</span>
                        </div>
                        @if($ticket->resolved_at)
                            <span class="text-[11px] font-mono text-emerald-400">
                                Selesai: {{ $ticket->resolved_at->translatedFormat('d M Y, H:i') }} WIB
                            </span>
                        @endif
                    </div>

                    @if($ticket->technician_name)
                        <div class="text-xs text-slate-300">
                            <span class="text-slate-400">Teknisi Bertugas:</span>
                            <span class="font-bold text-white ml-1">{{ $ticket->technician_name }}</span>
                        </div>
                    @endif

                    @if($ticket->resolution_notes)
                        <div class="text-xs text-slate-200 bg-white/[0.05] p-4 rounded-2xl border border-white/10 whitespace-pre-line leading-relaxed">
                            {{ $ticket->resolution_notes }}
                        </div>
                    @endif
                </div>
            @endif

        </div>

        <!-- Right 1 Col: Metadata & Customer Reference -->
        <div class="space-y-4">
            
            <div class="portal-card rounded-2xl p-5 space-y-3.5 text-xs">
                <div class="font-mono font-bold uppercase tracking-wider text-[#38bdf8]">Detail Pengaduan</div>
                
                <div class="space-y-2 divide-y divide-white/5">
                    <div class="pt-1">
                        <span class="text-slate-400 block text-[11px]">Kategori Gangguan:</span>
                        <span class="text-white font-semibold">{{ $ticket->category_label }}</span>
                    </div>

                    <div class="pt-2">
                        <span class="text-slate-400 block text-[11px]">Tingkat Urgensi:</span>
                        <span class="capitalize text-white font-semibold">{{ $ticket->priority }}</span>
                    </div>

                    <div class="pt-2">
                        <span class="text-slate-400 block text-[11px]">ID Pelanggan:</span>
                        <span class="font-mono text-[#38bdf8] font-bold">{{ $customer->customer_id }}</span>
                    </div>

                    <div class="pt-2">
                        <span class="text-slate-400 block text-[11px]">Paket Aktif:</span>
                        <span class="text-white font-semibold">{{ $customer->package->name ?? 'Broadband' }} ({{ $customer->package->speed ?? '25 Mbps' }})</span>
                    </div>

                    <div class="pt-2">
                        <span class="text-slate-400 block text-[11px]">Nomor WhatsApp:</span>
                        <span class="text-slate-200 font-mono">{{ $customer->phone }}</span>
                    </div>

                    <div class="pt-2">
                        <span class="text-slate-400 block text-[11px]">Alamat Terdaftar:</span>
                        <span class="text-slate-300 text-[11px] leading-relaxed block">{{ $customer->address }}</span>
                    </div>
                </div>
            </div>

            <!-- Emergency Direct Call -->
            <div class="portal-card rounded-2xl p-5 text-center space-y-2">
                <div class="text-xs font-heading font-bold text-white">Butuh Penanganan Cepat?</div>
                <p class="text-[11px] text-slate-400">
                    Sebutkan nomor tiket <strong class="text-[#38bdf8] font-mono">#{{ $ticket->ticket_number }}</strong> ke petugas kami.
                </p>
                <a href="https://wa.me/6281214878436?text=Halo%20NOC%20PT%20MSN,%20saya%20ingin%20update%20Tiket%20%23{{ $ticket->ticket_number }}" target="_blank" class="w-full py-2.5 px-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-heading font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-md mt-2">
                    <iconify-icon icon="solar:chat-round-dots-bold" width="16"></iconify-icon>
                    <span>Hubungi Hotline WhatsApp</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
