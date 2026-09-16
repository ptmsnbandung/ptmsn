@extends('portal.layouts.app')

@section('title', 'Buat Laporan Gangguan Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Header -->
    <div>
        <a href="{{ route('portal.tickets.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-sky-600 transition-colors mb-2 font-mono font-semibold">
            <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
            <span>Kembali ke Daftar Laporan</span>
        </a>
        <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">Formulir Pengaduan / Tiket Layanan</h1>
        <p class="text-xs sm:text-sm text-slate-600">Silakan pilih kategori dan sampaikan kendala Anda agar tim teknisi & NOC PT MSN dapat segera menindaklanjuti.</p>
    </div>

    <!-- Main Form Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Cols: The Form -->
        <div class="lg:col-span-2">
            <div class="portal-card rounded-3xl p-6 sm:p-8">
                
                <form action="{{ route('portal.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- 1. Kategori Tiket IMS (Visual Radio Cards) -->
                    <div class="space-y-2.5">
                        <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700">
                            1. Kategori Pengaduan / Permintaan <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            
                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/70 border border-slate-200 hover:border-sky-300 cursor-pointer transition-all has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50/90 has-[:checked]:shadow-sm">
                                <input type="radio" name="kat_tiket" value="11" class="sr-only" {{ old('kat_tiket', '11') === '11' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:shield-warning-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-slate-900">Gangguan Layanan</div>
                                    <div class="text-[10px] text-slate-500">LOS merah, mati total, lambat</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/70 border border-slate-200 hover:border-sky-300 cursor-pointer transition-all has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50/90 has-[:checked]:shadow-sm">
                                <input type="radio" name="kat_tiket" value="12" class="sr-only" {{ old('kat_tiket') === '12' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:key-minimalistic-square-3-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-slate-900">Ubah Password</div>
                                    <div class="text-[10px] text-slate-500">Ganti SSID / password WiFi</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/70 border border-slate-200 hover:border-sky-300 cursor-pointer transition-all has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50/90 has-[:checked]:shadow-sm">
                                <input type="radio" name="kat_tiket" value="17" class="sr-only" {{ old('kat_tiket') === '17' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:round-transfer-vertical-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-slate-900">Ubah Layanan</div>
                                    <div class="text-[10px] text-slate-500">Upgrade / downgrade kecepatan</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/70 border border-slate-200 hover:border-sky-300 cursor-pointer transition-all has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50/90 has-[:checked]:shadow-sm">
                                <input type="radio" name="kat_tiket" value="13" class="sr-only" {{ old('kat_tiket') === '13' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:map-point-wave-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-slate-900">Cek Coverage Area</div>
                                    <div class="text-[10px] text-slate-500">Pindah alamat / cek jangkauan</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/70 border border-slate-200 hover:border-sky-300 cursor-pointer transition-all has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50/90 has-[:checked]:shadow-sm">
                                <input type="radio" name="kat_tiket" value="15" class="sr-only" {{ old('kat_tiket') === '15' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:pause-circle-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-slate-900">Suspend Layanan</div>
                                    <div class="text-[10px] text-slate-500">Jeda sementara koneksi</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/70 border border-slate-200 hover:border-sky-300 cursor-pointer transition-all has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50/90 has-[:checked]:shadow-sm">
                                <input type="radio" name="kat_tiket" value="14" class="sr-only" {{ old('kat_tiket') === '14' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:user-cross-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-slate-900">Terminasi</div>
                                    <div class="text-[10px] text-slate-500">Penghentian berlangganan</div>
                                </div>
                            </label>

                        </div>
                    </div>

                    <!-- 2. Judul / Ringkasan Kendala -->
                    <div class="space-y-1.5">
                        <label for="subject" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700">
                            2. Judul Ringkas Kendala <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="subject" 
                            name="subject" 
                            value="{{ old('subject') }}" 
                            required 
                            placeholder="Contoh: Lampu LOS Modem Merah Berkedip Sejak Pagi"
                            class="w-full px-4 py-3.5 rounded-2xl bg-white/80 border border-slate-300 text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all shadow-sm"
                        >
                    </div>

                    <!-- 3. Deskripsi Detail -->
                    <div class="space-y-1.5">
                        <label for="description" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700">
                            3. Penjelasan Detail Keluhan <span class="text-rose-500">*</span>
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4" 
                            required 
                            placeholder="Jelaskan kronologi kendala (sejak kapan, perangkat apa saja yang terpengaruh, apakah sudah coba restart modem, dll)..."
                            class="w-full px-4 py-3 rounded-2xl bg-white/80 border border-slate-300 text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all resize-none shadow-sm"
                        >{{ old('description') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-slate-200 flex items-center justify-between gap-4">
                        <a href="{{ route('portal.tickets.index') }}" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-xs font-heading font-bold text-slate-700 transition-colors">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-xs sm:text-sm shadow-lg shadow-sky-500/25 hover:scale-105 active:scale-95 transition-all flex items-center gap-2 cursor-pointer"
                        >
                            <iconify-icon icon="solar:plain-bold" width="18"></iconify-icon>
                            <span>Kirim Laporan Tiket</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

        <!-- Right 1 Col: Customer Info & SLA Notes -->
        <div class="space-y-4">
            
            <!-- Customer Data Snapshot -->
            <div class="portal-card rounded-3xl p-5 space-y-3">
                <div class="text-xs font-mono font-bold uppercase tracking-wider text-sky-700 flex items-center gap-1.5">
                    <iconify-icon icon="solar:user-id-bold"></iconify-icon>
                    <span>Data Pelapor:</span>
                </div>
                <div class="space-y-1.5 text-xs text-slate-600">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Nama:</span>
                        <span class="text-slate-900 font-bold block">{{ $customer->name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[11px]">ID Pelanggan:</span>
                        <span class="text-sky-600 font-mono font-bold block">{{ $customer->customer_id }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[11px]">No. WhatsApp:</span>
                        <span class="text-slate-700 font-mono block">{{ $customer->phone }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[11px]">Paket Aktif:</span>
                        <span class="text-slate-800 font-semibold block">{{ $customer->package->name ?? 'Broadband' }} ({{ $customer->package->speed ?? '25 Mbps' }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[11px]">Alamat Pemasangan:</span>
                        <span class="text-slate-700 block text-[11px] leading-relaxed">{{ $customer->address ?? 'Bekasi, Jawa Barat' }}</span>
                    </div>
                </div>
            </div>

            <!-- Service Level Agreement (SLA) Guarantee -->
            <div class="portal-card rounded-3xl p-5 bg-sky-50/80 border-sky-200 space-y-2.5 text-xs">
                <div class="font-heading font-bold text-sky-800 flex items-center gap-1.5">
                    <iconify-icon icon="solar:clock-circle-bold" class="text-base"></iconify-icon>
                    <span>Komitmen Respon Cepat (SLA)</span>
                </div>
                <p class="text-[11px] text-slate-600 leading-relaxed">
                    Setelah laporan dikirim:
                </p>
                <ul class="space-y-1.5 text-[11px] text-slate-600 list-disc list-inside">
                    <li><strong class="text-slate-800">&lt; 15 Menit:</strong> Respon awal NOC & analisa jarak jauh (remote check).</li>
                    <li><strong class="text-white bg-sky-600 px-1 py-0.5 rounded text-[10px]">&lt; 2 Jam:</strong> Penugasan teknisi ke lokasi jika kendala fisik kabel/modem.</li>
                </ul>
            </div>

        </div>

    </div>

</div>
@endsection

