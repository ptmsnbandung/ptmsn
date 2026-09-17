@extends('portal.layouts.app')

@section('title', 'Detail Tiket #' . $ticket->ticket_number)

@section('content')
<div class="max-w-4xl mx-auto space-y-3.5 sm:space-y-6">

    <!-- Back Link & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-4">
        @php
            $typeLabel = match((string) $ticket->kat_tiket) {
                '17' => 'Pengajuan Ubah Layanan',
                '12' => 'Permintaan Ubah WiFi',
                '13' => 'Pengajuan Relokasi',
                '14' => 'Permohonan Terminasi',
                '15' => 'Pengajuan Suspend',
                default => 'Tiket Gangguan',
            };
        @endphp
        <div>
            <a href="{{ route('portal.tickets.index') }}" class="inline-flex items-center gap-1.5 text-[11px] sm:text-xs text-slate-500 hover:text-sky-600 transition-colors mb-1 sm:mb-2 font-mono font-semibold">
                <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                <span>Kembali ke Daftar Laporan</span>
            </a>
            <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                <h1 class="text-xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">
                    {{ $typeLabel }} #{{ $ticket->ticket_number }}
                </h1>
                <span class="text-[10px] sm:text-xs px-2.5 py-0.5 sm:py-1 rounded-full {{ $ticket->status_badge_class }} font-semibold">
                    {{ $ticket->status_label }}
                </span>
            </div>
            <div class="text-[10px] sm:text-xs text-slate-500 mt-0.5 sm:mt-1 font-mono">
                Dibuat pada: {{ $ticket->created_at->translatedFormat('d F Y, H:i') }} WIB
            </div>
        </div>

        <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text={{ urlencode('Halo Tim Layanan PT MSN, saya ingin menanyakan status ' . $typeLabel . ' #' . $ticket->ticket_number) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2.5 rounded-xl sm:rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-700 font-heading font-bold text-xs transition-all self-start sm:self-auto shadow-2xs">
            <iconify-icon icon="solar:chat-round-dots-bold" width="15" class="text-emerald-600"></iconify-icon>
            <span>Tanya via WhatsApp</span>
        </a>
    </div>

    <!-- Live Status Tracker (Visual Stepper) -->
    <div class="portal-card rounded-2xl sm:rounded-3xl p-3.5 sm:p-8">
        <div class="text-xs font-mono font-bold uppercase tracking-wider text-sky-700 mb-3 sm:mb-6 flex items-center gap-1.5">
            <iconify-icon icon="solar:history-bold"></iconify-icon>
            <span>Status Progres Penanganan:</span>
        </div>

        @php
            $currentStep = match((string) $ticket->status) {
                '11', 'open', 'antrian' => 1,
                '12', 'in_progress', 'proses', 'konfirmasi' => 2,
                '13', '14', 'resolved', 'closed', 'done', 'close' => 3,
                default => 1,
            };
        @endphp

        <div class="relative">
            <!-- Connecting Line -->
            <div class="hidden sm:block absolute top-5 left-10 right-10 h-1 bg-slate-200 z-0 rounded-full">
                <div class="h-full bg-gradient-to-r from-sky-500 to-emerald-500 transition-all duration-500 rounded-full" style="width: {{ $currentStep === 1 ? '15%' : ($currentStep === 2 ? '60%' : '100%') }}"></div>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-2 relative z-10">
                
                <!-- Step 1: Laporan Diterima -->
                <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 {{ $currentStep >= 1 ? ($currentStep >= 3 ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20 font-bold' : 'bg-sky-600 text-white shadow-md shadow-sky-500/30 font-bold') : 'bg-slate-100 text-slate-400 border border-slate-200' }}">
                        <iconify-icon icon="solar:inbox-in-bold" width="20"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-bold {{ $currentStep >= 1 ? 'text-slate-900' : 'text-slate-400' }}">1. Laporan Diterima</div>
                        <div class="text-[11px] text-slate-500">Verifikasi & Antrian NOC</div>
                    </div>
                </div>

                <!-- Step 2: Sedang Ditangani / Investigasi -->
                <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 {{ $currentStep >= 2 ? ($currentStep >= 3 ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20 font-bold' : 'bg-sky-600 text-white shadow-md shadow-sky-500/30 font-bold animate-pulse') : 'bg-slate-100 text-slate-400 border border-slate-200' }}">
                        <iconify-icon icon="solar:settings-bold" width="20"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-bold {{ $currentStep >= 2 ? 'text-slate-900' : 'text-slate-400' }}">2. Sedang Ditangani</div>
                        <div class="text-[11px] text-slate-500">Pemeriksaan NOC & Teknisi</div>
                    </div>
                </div>

                <!-- Step 3: Selesai / Pulih -->
                <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 {{ $currentStep >= 3 ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/30 font-bold' : 'bg-slate-100 text-slate-400 border border-slate-200' }}">
                        <iconify-icon icon="solar:check-circle-bold" width="20"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-bold {{ $currentStep >= 3 ? 'text-slate-900' : 'text-slate-400' }}">
                            {{ (string) $ticket->kat_tiket === '11' ? '3. Gangguan Selesai' : '3. Permintaan Selesai' }}
                        </div>
                        <div class="text-[11px] text-slate-500">
                            {{ (string) $ticket->kat_tiket === '11' ? 'Koneksi Kembali Normal' : 'Berhasil Ditindaklanjuti' }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Ticket Detail Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-6">
        
        <!-- Left 2 Cols: Issue Content & Technician Notes -->
        <div class="lg:col-span-2 space-y-3 sm:space-y-6">
            
            <!-- Issue Details -->
            <div class="portal-card rounded-2xl sm:rounded-3xl p-3.5 sm:p-7 space-y-2.5 sm:space-y-4">
                <div class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Informasi Kendala</div>
                
                <div>
                    <h2 class="text-sm sm:text-lg font-heading font-bold text-slate-900 mb-1.5 sm:mb-2">{{ $ticket->subject }}</h2>
                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50/80 p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-slate-200/80">
                        {{ $ticket->description }}
                    </p>
                </div>
            </div>

            <!-- Technician Action / Resolution Box (Hanya tampil jika tiket sedang ditangani, sudah selesai, atau ada catatan teknisi) -->
            @if($currentStep >= 2 || !empty($ticket->solusi) || !empty($ticket->penanganan))
                <div class="portal-card rounded-2xl sm:rounded-3xl p-3.5 sm:p-7 {{ $currentStep >= 3 ? 'border-emerald-200 bg-gradient-to-br from-emerald-50/90 to-teal-50/60' : 'border-sky-200 bg-gradient-to-br from-sky-50/90 to-blue-50/60' }} space-y-2.5 sm:space-y-3 shadow-xs">
                    <div class="flex items-center justify-between">
                        <div class="text-xs font-mono font-bold uppercase tracking-wider {{ $currentStep >= 3 ? 'text-emerald-800' : 'text-sky-800' }} flex items-center gap-1.5">
                            <iconify-icon icon="solar:user-hand-up-bold"></iconify-icon>
                            <span>{{ $currentStep >= 3 ? 'Tindakan & Solusi Penyelesaian NOC' : 'Progres Penanganan Tim Teknis' }}</span>
                        </div>
                        @if($ticket->resolved_at)
                            <span class="text-[10px] sm:text-[11px] font-mono text-emerald-700 font-semibold bg-white/90 px-2 py-0.5 rounded-full border border-emerald-200 shadow-2xs">
                                Selesai: {{ $ticket->resolved_at->translatedFormat('d M Y, H:i') }} WIB
                            </span>
                        @elseif($currentStep >= 3)
                            <span class="text-[10px] sm:text-[11px] font-mono text-emerald-700 font-semibold bg-white/90 px-2 py-0.5 rounded-full border border-emerald-200 shadow-2xs">
                                Status: Selesai
                            </span>
                        @endif
                    </div>

                    @if($ticket->technician_name)
                        <div class="text-xs text-slate-700">
                            <span class="text-slate-500">Petugas / Teknisi:</span>
                            <span class="font-bold text-slate-900 ml-1">{{ $ticket->technician_name }}</span>
                        </div>
                    @endif

                    <div class="text-xs text-slate-800 bg-white/90 p-3 sm:p-4 rounded-xl sm:rounded-2xl border {{ $currentStep >= 3 ? 'border-emerald-200/80' : 'border-slate-200' }} whitespace-pre-line leading-relaxed shadow-xs">
                        @if(!empty($ticket->solusi))
                            {{ $ticket->solusi }}
                        @elseif(!empty($ticket->penanganan))
                            {{ $ticket->penanganan }}
                        @elseif(!empty($ticket->resolution_notes))
                            {{ $ticket->resolution_notes }}
                        @elseif($currentStep >= 3)
                            Kendala pada layanan internet telah selesai diperbaiki dan jaringan kembali beroperasi secara normal. Terima kasih atas kesabaran Anda.
                        @else
                            Laporan Anda telah diterima dan saat ini sedang dalam penanganan aktif oleh tim teknisi NOC PT MSN.
                        @endif
                    </div>
                </div>
            @endif

        </div>

        <!-- Right 1 Col: Metadata & Customer Reference -->
        <div class="space-y-3 sm:space-y-4">
            
            <div class="portal-card rounded-2xl sm:rounded-3xl p-3.5 sm:p-5 space-y-2.5 sm:space-y-3.5 text-xs">
                <div class="font-mono font-bold uppercase tracking-wider text-sky-700 text-[11px] sm:text-xs">Detail Pengaduan</div>
                
                <div class="space-y-2.5 divide-y divide-slate-100">
                    <div class="pt-1">
                        <span class="text-slate-400 block text-[11px]">Kategori Tiket:</span>
                        <span class="text-slate-900 font-semibold">{{ $ticket->category_label }}</span>
                    </div>

                    <div class="pt-2">
                        <span class="text-slate-400 block text-[11px]">ID Pelanggan:</span>
                        <span class="font-mono text-sky-600 font-bold">{{ $customer->customer_id }}</span>
                    </div>

                    <div class="pt-2">
                        <span class="text-slate-400 block text-[11px]">Paket Aktif:</span>
                        <span class="text-slate-900 font-semibold">{{ $customer->package->name ?? 'Broadband' }} ({{ $customer->package->speed ?? '25 Mbps' }})</span>
                    </div>

                    <div class="pt-2">
                        <span class="text-slate-400 block text-[11px]">Nomor WhatsApp:</span>
                        <span class="text-slate-700 font-mono">{{ $customer->phone }}</span>
                    </div>

                    <div class="pt-2">
                        <span class="text-slate-400 block text-[11px]">Alamat Terdaftar:</span>
                        <span class="text-slate-700 text-[11px] leading-relaxed block">{{ $customer->address }}</span>
                    </div>
                </div>
            </div>

            <!-- Emergency Direct Call -->
            <div class="portal-card rounded-3xl p-5 text-center space-y-2">
                <div class="text-xs font-heading font-bold text-slate-900">Butuh Penanganan Cepat?</div>
                <p class="text-[11px] text-slate-500">
                    Sebutkan nomor tiket <strong class="text-sky-600 font-mono">#{{ $ticket->ticket_number }}</strong> ke petugas kami.
                </p>
                <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20NOC%20PT%20MSN,%20saya%20ingin%20update%20Tiket%20%23{{ $ticket->ticket_number }}" target="_blank" class="w-full py-2.5 px-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-emerald-600/20 mt-2">
                    <iconify-icon icon="solar:chat-round-dots-bold" width="16"></iconify-icon>
                    <span>Hubungi Hotline WhatsApp</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection

