@extends('portal.layouts.app')

@section('title', 'Buat Laporan Gangguan Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Header -->
    <div>
        <a href="{{ route('portal.tickets.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-[#38bdf8] transition-colors mb-2 font-mono">
            <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
            <span>Kembali ke Daftar Laporan</span>
        </a>
        <h1 class="text-2xl font-heading font-extrabold text-white tracking-tight">Formulir Laporan Gangguan Jaringan</h1>
        <p class="text-xs sm:text-sm text-slate-400">Silakan lengkapi informasi kendala di bawah ini agar tim NOC & teknisi kami dapat segera menangani.</p>
    </div>

    <!-- Main Form Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Cols: The Form -->
        <div class="lg:col-span-2">
            <div class="portal-card rounded-3xl p-6 sm:p-8">
                
                <form action="{{ route('portal.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- 1. Kategori Gangguan (Visual Radio Cards) -->
                    <div class="space-y-2.5">
                        <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-300">
                            1. Jenis Kendala / Gangguan <span class="text-rose-400">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            
                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/[0.04] border border-white/10 hover:border-[#38bdf8]/50 cursor-pointer transition-all has-[:checked]:border-[#38bdf8] has-[:checked]:bg-[#38bdf8]/10">
                                <input type="radio" name="category" value="los_merah" class="sr-only" {{ old('category', 'los_merah') === 'los_merah' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:shield-warning-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-white">Lampu LOS Merah</div>
                                    <div class="text-[10px] text-slate-400">Modem berkedip merah</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/[0.04] border border-white/10 hover:border-[#38bdf8]/50 cursor-pointer transition-all has-[:checked]:border-[#38bdf8] has-[:checked]:bg-[#38bdf8]/10">
                                <input type="radio" name="category" value="internet_mati" class="sr-only" {{ old('category') === 'internet_mati' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:forbidden-circle-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-white">Internet Mati Total</div>
                                    <div class="text-[10px] text-slate-400">Tidak ada koneksi sama sekali</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/[0.04] border border-white/10 hover:border-[#38bdf8]/50 cursor-pointer transition-all has-[:checked]:border-[#38bdf8] has-[:checked]:bg-[#38bdf8]/10">
                                <input type="radio" name="category" value="koneksi_lambat" class="sr-only" {{ old('category') === 'koneksi_lambat' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:speedometer-low-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-white">Koneksi Lambat / RTO</div>
                                    <div class="text-[10px] text-slate-400">Kecepatan turun drastis</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/[0.04] border border-white/10 hover:border-[#38bdf8]/50 cursor-pointer transition-all has-[:checked]:border-[#38bdf8] has-[:checked]:bg-[#38bdf8]/10">
                                <input type="radio" name="category" value="perangkat_rusak" class="sr-only" {{ old('category') === 'perangkat_rusak' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:server-square-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-white">Kerusakan ONT/Modem</div>
                                    <div class="text-[10px] text-slate-400">Adaptor mati / perangkat panas</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/[0.04] border border-white/10 hover:border-[#38bdf8]/50 cursor-pointer transition-all has-[:checked]:border-[#38bdf8] has-[:checked]:bg-[#38bdf8]/10">
                                <input type="radio" name="category" value="billing" class="sr-only" {{ old('category') === 'billing' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:bill-check-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-white">Tagihan / Pembayaran</div>
                                    <div class="text-[10px] text-slate-400">Konfirmasi status bayar</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl bg-white/[0.04] border border-white/10 hover:border-[#38bdf8]/50 cursor-pointer transition-all has-[:checked]:border-[#38bdf8] has-[:checked]:bg-[#38bdf8]/10">
                                <input type="radio" name="category" value="lainnya" class="sr-only" {{ old('category') === 'lainnya' ? 'checked' : '' }}>
                                <div class="w-8 h-8 rounded-xl bg-slate-500/20 text-slate-400 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:question-circle-bold" width="18"></iconify-icon>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-bold text-white">Lainnya / Pertanyaan</div>
                                    <div class="text-[10px] text-slate-400">Pertanyaan teknis lain</div>
                                </div>
                            </label>

                        </div>
                    </div>

                    <!-- 2. Judul / Ringkasan Kendala -->
                    <div class="space-y-1.5">
                        <label for="subject" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-300">
                            2. Judul Ringkas Kendala <span class="text-rose-400">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="subject" 
                            name="subject" 
                            value="{{ old('subject') }}" 
                            required 
                            placeholder="Contoh: Lampu LOS Modem Merah Berkedip Sejak Pukul 09:00"
                            class="w-full px-4 py-3 rounded-2xl bg-white/[0.06] border border-white/15 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-[#38bdf8] transition-all"
                        >
                    </div>

                    <!-- 3. Tingkat Prioritas Kendala -->
                    <div class="space-y-1.5">
                        <label for="priority" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-300">
                            3. Tingkat Urgensi
                        </label>
                        <select 
                            id="priority" 
                            name="priority" 
                            class="w-full px-4 py-3 rounded-2xl bg-[#08162b] border border-white/15 text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#38bdf8] transition-all"
                        >
                            <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Normal (Kebutuhan Harian Rumah Tangga)</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>Tinggi (Work From Home / Belajar Online)</option>
                            <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Sangat Mendesak (Kantor / Usaha / Bisnis)</option>
                        </select>
                    </div>

                    <!-- 4. Deskripsi Detail -->
                    <div class="space-y-1.5">
                        <label for="description" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-300">
                            4. Penjelasan Detail Kendala <span class="text-rose-400">*</span>
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4" 
                            required 
                            placeholder="Jelaskan kronologi kendala (sejak kapan, apa saja perangkat yang terpengaruh, apakah sudah coba restart modem, dll)..."
                            class="w-full px-4 py-3 rounded-2xl bg-white/[0.06] border border-white/15 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-[#38bdf8] transition-all resize-none"
                        >{{ old('description') }}</textarea>
                    </div>

                    <!-- 5. Foto / Bukti Kendala (Opsional) -->
                    <div class="space-y-1.5">
                        <label for="photo" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-300">
                            5. Foto Lampu Indikator Modem / Screenshot (Opsional)
                        </label>
                        <div class="relative">
                            <input 
                                type="file" 
                                id="photo" 
                                name="photo" 
                                accept="image/*"
                                class="w-full px-4 py-2.5 rounded-2xl bg-white/[0.04] border border-white/15 text-xs text-slate-300 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#38bdf8] file:text-[#050d1a] hover:file:bg-white cursor-pointer"
                            >
                        </div>
                        <div class="text-[11px] text-slate-400">Format JPG, PNG, WEBP. Maksimal 5 MB.</div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-white/10 flex items-center justify-between gap-4">
                        <a href="{{ route('portal.tickets.index') }}" class="px-5 py-3 rounded-2xl bg-white/[0.06] hover:bg-white/[0.12] text-xs font-heading font-bold text-slate-300 transition-colors">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-rose-500 to-amber-500 hover:from-rose-600 hover:to-amber-600 text-white font-heading font-extrabold text-xs sm:text-sm shadow-lg shadow-rose-500/25 hover:scale-105 active:scale-95 transition-all flex items-center gap-2 cursor-pointer"
                        >
                            <iconify-icon icon="solar:plain-bold" width="18"></iconify-icon>
                            <span>Kirim Laporan Gangguan</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

        <!-- Right 1 Col: Customer Info & SLA Notes -->
        <div class="space-y-4">
            
            <!-- Customer Data Snapshot -->
            <div class="portal-card rounded-2xl p-5 space-y-3">
                <div class="text-xs font-mono font-bold uppercase tracking-wider text-[#38bdf8] flex items-center gap-1.5">
                    <iconify-icon icon="solar:user-id-bold"></iconify-icon>
                    <span>Data Pelapor:</span>
                </div>
                <div class="space-y-1.5 text-xs">
                    <div>
                        <span class="text-slate-400">Nama:</span>
                        <span class="text-white font-bold block">{{ $customer->name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400">ID Pelanggan:</span>
                        <span class="text-[#38bdf8] font-mono font-bold block">{{ $customer->customer_id }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400">No. WhatsApp:</span>
                        <span class="text-slate-200 font-mono block">{{ $customer->phone }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400">Paket:</span>
                        <span class="text-slate-200 font-semibold block">{{ $customer->package->name ?? 'Broadband' }} ({{ $customer->package->speed ?? '25 Mbps' }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400">Alamat Pemasangan:</span>
                        <span class="text-slate-200 block text-[11px] leading-relaxed">{{ $customer->address ?? 'Bekasi, Jawa Barat' }}</span>
                    </div>
                </div>
            </div>

            <!-- Service Level Agreement (SLA) Guarantee -->
            <div class="portal-card rounded-2xl p-5 bg-sky-950/20 border-sky-500/20 space-y-2.5 text-xs">
                <div class="font-heading font-bold text-white flex items-center gap-1.5 text-[#38bdf8]">
                    <iconify-icon icon="solar:clock-circle-bold" class="text-base"></iconify-icon>
                    <span>Komitmen Respon Cepat (SLA)</span>
                </div>
                <p class="text-[11px] text-slate-300 leading-relaxed">
                    Setelah laporan dikirim:
                </p>
                <ul class="space-y-1.5 text-[11px] text-slate-300 list-disc list-inside">
                    <li><strong class="text-white">&lt; 15 Menit:</strong> Respon awal NOC & analisa jarak jauh (remote check).</li>
                    <li><strong class="text-white">&lt; 2 Jam:</strong> Penugasan tim teknisi lapangan jika kendala fisik kabel/dropcore.</li>
                </ul>
            </div>

        </div>

    </div>

</div>
@endsection
