@extends('portal.layouts.app')

@section('title', 'Profil & Layanan Pelanggan')

@section('content')
<!-- Full-Width Dark Oceanic Blue Hero Backdrop -->
<div class="-mx-3 sm:-mx-6 lg:-mx-8 -mt-3 sm:-mt-6 px-4 sm:px-6 lg:px-8 pt-5 sm:pt-7 pb-20 sm:pb-24 hero-network-card !rounded-none !border-x-0 !border-t-0 shadow-md relative overflow-hidden">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-3 relative z-10">
        <div class="space-y-1">
            <div class="flex items-center gap-1.5 text-[11px] font-mono text-cyan-300 font-medium">
                <a href="{{ route('portal.dashboard') }}" class="hover:text-white transition-colors">Portal</a>
                <span class="text-cyan-400/60">/</span>
                <span class="text-cyan-300 font-bold">Profil</span>
            </div>
            <h1 class="text-lg sm:text-2xl font-heading font-extrabold text-white tracking-tight">
                Profil & Paket Langganan
            </h1>
            <p class="text-xs text-slate-300">Rincian parameter koneksi fiber optic dan kontak akun pelanggan PT MSN.</p>
        </div>

        <!-- ID Pelanggan Pill -->
        <button 
            type="button" 
            onclick="copyToClipboard('{{ $customer->customer_id }}', 'ID Pelanggan {{ $customer->customer_id }}')"
            class="copy-btn px-3 py-1.5 rounded-xl bg-slate-800/90 hover:bg-slate-700/90 border border-slate-700/90 hover:border-cyan-400 text-cyan-300 flex items-center gap-1.5 shrink-0 transition-all cursor-pointer shadow-2xs self-start sm:self-center"
            title="Klik untuk menyalin ID"
        >
            <iconify-icon icon="solar:hashtag-bold" class="text-cyan-400 text-xs"></iconify-icon>
            <span class="text-xs font-mono font-bold">{{ $customer->customer_id }}</span>
            <iconify-icon icon="solar:copy-linear" class="text-slate-400 text-[11px]"></iconify-icon>
        </button>
    </div>
</div>

<!-- Main Content Container Overlapping the Blue Backdrop -->
<div class="-mt-14 sm:-mt-16 relative z-10 space-y-3.5 sm:space-y-5">
    <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        
        <!-- Left 1 Col: Subscription Info Card -->
        <div class="space-y-4">
            <div class="portal-card rounded-2xl sm:rounded-3xl p-5 sm:p-6 space-y-4">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 text-white flex items-center justify-center font-heading font-extrabold text-lg shadow-md shadow-sky-500/20 shrink-0">
                        {{ $customer->initial }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="text-sm font-heading font-bold text-slate-900 truncate">{{ $customer->name }}</div>
                        <div class="flex items-center gap-2 flex-wrap mt-0.5">
                            <button 
                                type="button" 
                                onclick="copyToClipboard('{{ $customer->customer_id }}', 'ID Pelanggan')"
                                class="text-xs font-mono text-sky-600 font-semibold flex items-center gap-1 hover:text-sky-700"
                                title="Salin ID"
                            >
                                <span>ID: {{ $customer->customer_id }}</span>
                                <iconify-icon icon="solar:copy-linear" class="text-xs opacity-60"></iconify-icon>
                            </button>
                            @if($customer->berlangganan_sejak !== '-')
                                <span class="text-[10px] sm:text-[11px] text-slate-400 font-medium truncate">
                                    • Sejak {{ $customer->berlangganan_sejak }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-3 text-xs text-slate-600">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Paket Internet FTTH:</span>
                        <span class="text-slate-900 font-bold text-sm">{{ $customer->package->name ?? 'Broadband FTTH' }}</span>
                        <span class="text-sky-600 font-mono text-xs block font-bold">Speed: {{ $customer->package->speed ?? '25 Mbps' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Tarif Bulanan:</span>
                        <span class="text-slate-900 font-bold">Rp {{ number_format($customer->billing_amount, 0, ',', '.') }} / bln</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Tanggal Jatuh Tempo:</span>
                        <span class="text-slate-700">Setiap tanggal {{ $customer->due_date }} / bln</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Alamat IP Pelanggan:</span>
                        <button 
                            type="button"
                            onclick="copyToClipboard('{{ $customer->ip_address ?? '10.20.104.22' }}', 'IP Address')"
                            class="text-sky-600 font-mono font-bold flex items-center gap-1 hover:text-sky-700"
                            title="Salin IP"
                        >
                            <span>{{ $customer->ip_address ?? '10.20.104.22' }}</span>
                            <iconify-icon icon="solar:copy-linear" class="text-xs opacity-60"></iconify-icon>
                        </button>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 text-[11px] font-medium flex items-center gap-1">
                                <iconify-icon icon="solar:calendar-date-bold" class="text-sky-500 text-xs"></iconify-icon>
                                <span>Bergabung Sejak:</span>
                            </span>
                            <span class="text-emerald-700 bg-emerald-100 font-semibold px-2 py-0.5 rounded text-[10px]">
                                Aktif {{ $customer->subscription_duration_text }}
                            </span>
                        </div>
                        <span class="text-slate-900 font-bold text-xs block">{{ $customer->berlangganan_sejak }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Status Registrasi:</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border font-semibold text-[11px] mt-1 shadow-2xs {{ $customer->status_reg_badge_class }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $customer->status_reg_dot_class }}"></span>
                            <span>{{ $customer->status_reg_label }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Upgrade Package Notice -->
            <div class="portal-card rounded-2xl sm:rounded-3xl p-4 sm:p-5 bg-gradient-to-br from-sky-50 to-blue-50/70 border-sky-200 space-y-2 text-xs">
                <div class="font-heading font-bold text-slate-900 flex items-center gap-1.5 text-sky-800">
                    <iconify-icon icon="solar:bolt-bold" class="text-amber-500 text-base"></iconify-icon>
                    <span>Ingin Upgrade Kecepatan?</span>
                </div>
                <p class="text-[11px] text-slate-600 leading-relaxed">
                    Tingkatkan kecepatan bandwidth internet hingga 100 Mbps dengan promo khusus pelanggan setia MSN.
                </p>
                <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20Admin,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20ingin%20upgrade%20paket" target="_blank" class="w-full py-2.5 px-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-heading font-bold text-xs transition-all flex items-center justify-center gap-1 mt-2 shadow-xs">
                    <span>Chat Admin Upgrade</span>
                    <iconify-icon icon="solar:arrow-right-up-linear" width="14"></iconify-icon>
                </a>
            </div>

            <!-- Tour Replay Card -->
            <div class="portal-card rounded-2xl sm:rounded-3xl p-4 sm:p-5 bg-slate-50/90 border-slate-200 space-y-2 text-xs">
                <div class="font-heading font-bold text-slate-800 flex items-center gap-1.5">
                    <iconify-icon icon="solar:star-fall-minimalistic-2-bold" class="text-sky-600 text-base"></iconify-icon>
                    <span>Panduan Fitur Aplikasi</span>
                </div>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Ingin melihat kembali panduan interaktif cara menggunakan fitur-fitur portal pelanggan?
                </p>
                <a href="{{ route('portal.dashboard') }}?tour_step=1" class="w-full py-2 px-3 rounded-xl bg-white hover:bg-sky-50 border border-slate-200 hover:border-sky-300 text-slate-700 hover:text-sky-700 font-heading font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-2xs">
                    <iconify-icon icon="solar:play-circle-bold" class="text-sky-600"></iconify-icon>
                    <span>Mulai Ulang Panduan</span>
                </a>
            </div>
        </div>

        <!-- Right 2 Cols: Installation Data & Profile Edit Form -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            
            <!-- Data Pemasangan & Parameter Teknis Card -->
            <div class="portal-card rounded-2xl sm:rounded-3xl p-5 sm:p-7 space-y-4 sm:space-y-5 border border-slate-200/80 bg-white/95 shadow-xs">
                
                <!-- Card Header -->
                <div class="pb-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 shadow-2xs">
                            <iconify-icon icon="solar:home-wifi-bold" class="text-lg sm:text-xl"></iconify-icon>
                        </div>
                        <div>
                            <h2 class="text-sm sm:text-base font-heading font-extrabold text-slate-900 leading-tight">
                                Data Pemasangan & Lokasi Jaringan
                            </h2>
                            <p class="text-[11px] text-slate-500">Rincian parameter lokasi instalasi fisik dan media transmisi internet aktif.</p>
                        </div>
                    </div>

                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-heading font-bold self-start sm:self-auto {{ $customer->status_reg_badge_class }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $customer->status_reg_dot_class }}"></span>
                        <span>{{ $customer->status_reg_label }}</span>
                    </span>
                </div>

                <!-- Primary Installation Address Box -->
                <div class="p-3.5 sm:p-4 rounded-2xl bg-slate-50/90 border border-slate-200/90 space-y-2">
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                        <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1">
                            <iconify-icon icon="solar:map-point-wave-bold" class="text-sky-500 text-xs"></iconify-icon>
                            <span>Alamat Lengkap Pemasangan</span>
                        </span>
                        @if(!empty($customer->loc_maps) || !empty($customer->lon_lat))
                            @php
                                $mapsRaw = $customer->loc_maps ?: $customer->lon_lat;
                                $mapsLink = str_starts_with($mapsRaw, 'http') ? $mapsRaw : 'https://www.google.com' . $mapsRaw;
                            @endphp
                            <a 
                                href="{{ $mapsLink }}" 
                                target="_blank" 
                                class="inline-flex items-center gap-1 text-[11px] font-heading font-bold text-sky-600 hover:text-sky-700 transition-colors"
                                title="Lihat di Google Maps"
                            >
                                <iconify-icon icon="solar:map-arrow-square-bold" class="text-xs"></iconify-icon>
                                <span>Lihat Peta Titik Pasang</span>
                            </a>
                        @endif
                    </div>
                    <p class="text-xs sm:text-sm font-heading font-semibold text-slate-900 leading-relaxed">
                        {{ $customer->address ?: 'Alamat belum tercatat di sistem' }}
                    </p>
                    <div class="flex items-center gap-2 sm:gap-3 flex-wrap text-[11px] text-slate-600 pt-1 border-t border-slate-200/60 font-mono">
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-700">
                            RT: <strong>{{ $customer->rt_pasang ?: '00' }}</strong> / RW: <strong>{{ $customer->rw_pasang ?: '00' }}</strong>
                        </span>
                        @if(!empty($customer->nomor_bangunan) && $customer->nomor_bangunan !== '00')
                            <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-700">
                                No. Bangunan: <strong>{{ $customer->nomor_bangunan }}</strong>
                            </span>
                        @endif
                        @if(!empty($customer->jenis_bangunan))
                            <span class="px-2 py-0.5 rounded-md bg-sky-50 border border-sky-200 text-sky-700 font-sans font-medium">
                                {{ str_replace('-', ' ', ucwords(strtolower($customer->jenis_bangunan))) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- 4 Grid Technical Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3 text-xs">
                    
                    <!-- Media Akses -->
                    <div class="p-3 rounded-xl bg-white border border-slate-200/80 shadow-2xs space-y-1">
                        <span class="text-slate-400 text-[10px] font-mono uppercase block flex items-center gap-1">
                            <iconify-icon icon="solar:transmission-bold" class="text-sky-500 text-xs"></iconify-icon>
                            <span>Media Akses Transmisi</span>
                        </span>
                        <div class="font-heading font-bold text-slate-800 text-xs sm:text-sm">
                            {{ $customer->media_akses ?: 'Fiber Optic (FTTH)' }}
                        </div>
                        <span class="text-[10px] text-emerald-600 font-medium block">Koneksi Dedicated Simetris</span>
                    </div>

                    <!-- Tanggal Aktivasi Pasang -->
                    <div class="p-3 rounded-xl bg-white border border-slate-200/80 shadow-2xs space-y-1">
                        <span class="text-slate-400 text-[10px] font-mono uppercase block flex items-center gap-1">
                            <iconify-icon icon="solar:calendar-date-bold" class="text-sky-500 text-xs"></iconify-icon>
                            <span>Tanggal Mulai Berlangganan</span>
                        </span>
                        <div class="font-heading font-bold text-slate-800 text-xs sm:text-sm">
                            {{ $customer->berlangganan_sejak }}
                        </div>
                        <span class="text-[10px] text-slate-500 font-medium block">Aktif selama {{ $customer->subscription_duration_text }}</span>
                    </div>

                    <!-- Titik POP Jaringan -->
                    <div class="p-3 rounded-xl bg-white border border-slate-200/80 shadow-2xs space-y-1">
                        <span class="text-slate-400 text-[10px] font-mono uppercase block flex items-center gap-1">
                            <iconify-icon icon="solar:server-bold" class="text-sky-500 text-xs"></iconify-icon>
                            <span>Node / Server Distribusi (POP)</span>
                        </span>
                        <div class="font-mono font-bold text-slate-800 text-xs">
                            {{ $customer->kode_pop ? strtoupper($customer->kode_pop) : 'POP Distribusi Regional' }}
                        </div>
                        <span class="text-[10px] text-slate-500 font-medium block">Jaringan Inti PT MSN</span>
                    </div>

                    <!-- Sales / Petugas Lapangan -->
                    <div class="p-3 rounded-xl bg-white border border-slate-200/80 shadow-2xs space-y-1">
                        <span class="text-slate-400 text-[10px] font-mono uppercase block flex items-center gap-1">
                            <iconify-icon icon="solar:user-hand-up-bold" class="text-sky-500 text-xs"></iconify-icon>
                            <span>Petugas Registrasi / Sales</span>
                        </span>
                        <div class="font-heading font-bold text-slate-800 text-xs truncate">
                            {{ $customer->nama_sales ?: ($customer->user_create ?: 'Tim Layanan PT MSN') }}
                        </div>
                        <span class="text-[10px] text-slate-500 font-medium block">{{ $customer->group_layanan ?: 'MEDIANET Broadband' }}</span>
                    </div>

                </div>

            </div>

            <!-- Update Profile Form -->
            <div class="portal-card rounded-2xl sm:rounded-3xl p-5 sm:p-7 space-y-4 sm:space-y-5">
                <div class="text-xs font-mono font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                    <iconify-icon icon="solar:pen-bold" class="text-sky-600"></iconify-icon>
                    <span>Ubah Data Kontak & Alamat</span>
                </div>

                <form action="{{ route('portal.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Nomor WhatsApp / Telepon Utama (ID Login)
                        </label>
                        <input 
                            type="text" 
                            disabled 
                            value="{{ $customer->phone }}" 
                            class="w-full px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl bg-slate-100 border border-slate-200 text-slate-500 text-xs sm:text-sm font-mono cursor-not-allowed"
                        >
                        <div class="text-[10px] text-slate-400 mt-1">Untuk pergantian nomor WhatsApp utama, hubungi Customer Service PT MSN.</div>
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alamat Email (E-Billing)
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $customer->email) }}" 
                            placeholder="nama@email.com"
                            class="w-full px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl bg-white/80 border border-slate-300 text-slate-900 placeholder-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all shadow-xs"
                        >
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alamat Pemasangan
                        </label>
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="2"
                            class="w-full px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl bg-white/80 border border-slate-300 text-slate-900 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all resize-none shadow-xs"
                        >{{ old('address', $customer->address) }}</textarea>
                    </div>

                    <div class="pt-3 flex justify-end">
                        <button 
                            type="submit" 
                            class="px-5 py-2.5 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-xs sm:text-sm transition-all duration-200 shadow-md flex items-center gap-2 cursor-pointer"
                        >
                            <iconify-icon icon="solar:check-circle-bold" width="16"></iconify-icon>
                            <span>Simpan Perubahan Kontak</span>
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>

</div>
@endsection


