@extends('portal.layouts.app')

@section('title', 'Buat Laporan / Tiket Layanan')

@section('content')
<div x-data="{
    katTiket: '{{ old('kat_tiket', request('category', request('kat_tiket', '11'))) }}',
    showPassword: false,
    selectedPackageId: '{{ old('target_package_id', '') }}',
    packageCategoryTab: 'all',
    changeType: '{{ old('change_type', 'Upgrade Kecepatan (Tambah Bandwidth)') }}',
    currentPackagePrice: {{ (int) ($customer->package->price ?? 0) }},
    currentPackageId: {{ (int) ($customer->package->id ?? 0) }},
    selectPackage(id, price, name) {
        this.selectedPackageId = String(id);
        if (this.currentPackagePrice > 0 && price > 0) {
            if (price > this.currentPackagePrice) {
                this.changeType = 'Upgrade Kecepatan (Tambah Bandwidth)';
            } else if (price < this.currentPackagePrice) {
                this.changeType = 'Downgrade Paket';
            }
        }
    }
}">

    <!-- Full-Width Dark Oceanic Blue Hero Backdrop -->
    <div class="-mx-3 sm:-mx-6 lg:-mx-8 -mt-3 sm:-mt-6 px-4 sm:px-6 lg:px-8 pt-5 sm:pt-7 pb-20 sm:pb-24 hero-network-card !rounded-none !border-x-0 !border-t-0 shadow-md relative overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-3 relative z-10">
            <div class="space-y-1">
                <div class="flex items-center gap-1.5 text-[11px] font-mono text-cyan-300 font-medium">
                    <a href="{{ route('portal.dashboard') }}" class="hover:text-white transition-colors">Portal</a>
                    <span class="text-cyan-400/60">/</span>
                    <a href="{{ route('portal.tickets.index') }}" class="hover:text-white transition-colors">Tiket</a>
                    <span class="text-cyan-400/60">/</span>
                    <span class="text-cyan-300 font-bold">Buat Laporan</span>
                </div>
                <h1 class="text-lg sm:text-2xl font-heading font-extrabold text-white tracking-tight">
                    Formulir Tiket Layanan
                </h1>
                <p class="text-xs text-slate-300">Pilih kategori layanan. Formulir otomatis menyesuaikan informasi untuk tim NOC & teknisi PT MSN.</p>
            </div>

            <a href="{{ route('portal.tickets.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800/90 hover:bg-slate-700/90 border border-slate-700/90 text-slate-200 text-xs font-heading font-semibold transition-all shadow-2xs self-start sm:self-center">
                <iconify-icon icon="solar:arrow-left-linear" class="text-sm text-cyan-400"></iconify-icon>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>

    <!-- Main Content Container Overlapping the Blue Backdrop -->
    <div class="-mt-14 sm:-mt-16 relative z-10 max-w-4xl mx-auto space-y-3.5 sm:space-y-6">

    <!-- Error Summary if Any -->
    @if (isset($errors) && $errors->any())
        <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-start gap-2.5 sm:gap-3 shadow-xs">
            <iconify-icon icon="solar:danger-triangle-bold" class="text-rose-500 text-lg sm:text-xl shrink-0 mt-0.5"></iconify-icon>
            <div class="space-y-1">
                <p class="font-bold">Mohon lengkapi data formulir berikut:</p>
                <ul class="list-disc list-inside text-rose-700 text-xs space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Main Form Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3.5 sm:gap-6">
        
        <!-- Left 2 Cols: The Form -->
        <div class="lg:col-span-2">
            <div class="portal-card rounded-2xl sm:rounded-3xl p-3.5 sm:p-8">
                
                <form action="{{ route('portal.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5 sm:space-y-6">
                    @csrf

                    <!-- 1. Kategori Tiket IMS (Visual Radio Cards) -->
                    <div class="space-y-2 sm:space-y-2.5">
                        <label class="block text-[11px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-700">
                            1. Pilih Kategori Pengaduan / Permintaan <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-1.5 sm:gap-2.5">
                            
                            <!-- Kat 11: Gangguan Layanan -->
                            <label 
                                @click="katTiket = '11'"
                                :class="katTiket === '11' ? 'border-sky-500 bg-sky-50/90 ring-2 ring-sky-500/20 shadow-xs' : 'border-slate-200 bg-white/70 hover:border-sky-300'"
                                class="relative flex items-center gap-2 sm:gap-3 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border cursor-pointer transition-all"
                            >
                                <input type="radio" name="kat_tiket" value="11" x-model="katTiket" class="sr-only">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:shield-warning-bold" width="16" class="sm:w-[18px]"></iconify-icon>
                                </div>
                                <div class="text-left min-w-0">
                                    <div class="text-[11px] sm:text-xs font-bold text-slate-900 leading-tight truncate">Gangguan Layanan</div>
                                    <div class="text-[9px] sm:text-[10px] text-slate-500 leading-tight truncate">LOS merah / lemot</div>
                                </div>
                            </label>

                            <!-- Kat 12: Ubah Password -->
                            <label 
                                @click="katTiket = '12'"
                                :class="katTiket === '12' ? 'border-pink-500 bg-pink-50/90 ring-2 ring-pink-500/20 shadow-xs' : 'border-slate-200 bg-white/70 hover:border-pink-300'"
                                class="relative flex items-center gap-2 sm:gap-3 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border cursor-pointer transition-all"
                            >
                                <input type="radio" name="kat_tiket" value="12" x-model="katTiket" class="sr-only">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:key-minimalistic-square-3-bold" width="16" class="sm:w-[18px]"></iconify-icon>
                                </div>
                                <div class="text-left min-w-0">
                                    <div class="text-[11px] sm:text-xs font-bold text-slate-900 leading-tight truncate">Ubah WiFi</div>
                                    <div class="text-[9px] sm:text-[10px] text-slate-500 leading-tight truncate">Ganti password</div>
                                </div>
                            </label>

                            <!-- Kat 17: Ubah Layanan -->
                            <label 
                                @click="katTiket = '17'"
                                :class="katTiket === '17' ? 'border-emerald-500 bg-emerald-50/90 ring-2 ring-emerald-500/20 shadow-xs' : 'border-slate-200 bg-white/70 hover:border-emerald-300'"
                                class="relative flex items-center gap-2 sm:gap-3 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border cursor-pointer transition-all"
                            >
                                <input type="radio" name="kat_tiket" value="17" x-model="katTiket" class="sr-only">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:round-transfer-vertical-bold" width="16" class="sm:w-[18px]"></iconify-icon>
                                </div>
                                <div class="text-left min-w-0">
                                    <div class="text-[11px] sm:text-xs font-bold text-slate-900 leading-tight truncate">Ubah Paket</div>
                                    <div class="text-[9px] sm:text-[10px] text-slate-500 leading-tight truncate">Upgrade speed</div>
                                </div>
                            </label>

                            <!-- Kat 13: Cek Coverage / Relokasi -->
                            <label 
                                @click="katTiket = '13'"
                                :class="katTiket === '13' ? 'border-amber-500 bg-amber-50/90 ring-2 ring-amber-500/20 shadow-xs' : 'border-slate-200 bg-white/70 hover:border-amber-300'"
                                class="relative flex items-center gap-2 sm:gap-3 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border cursor-pointer transition-all"
                            >
                                <input type="radio" name="kat_tiket" value="13" x-model="katTiket" class="sr-only">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:map-point-wave-bold" width="16" class="sm:w-[18px]"></iconify-icon>
                                </div>
                                <div class="text-left min-w-0">
                                    <div class="text-[11px] sm:text-xs font-bold text-slate-900 leading-tight truncate">Relokasi</div>
                                    <div class="text-[9px] sm:text-[10px] text-slate-500 leading-tight truncate">Pindah alamat FO</div>
                                </div>
                            </label>

                            <!-- Kat 15: Suspend Layanan -->
                            <label 
                                @click="katTiket = '15'"
                                :class="katTiket === '15' ? 'border-purple-500 bg-purple-50/90 ring-2 ring-purple-500/20 shadow-xs' : 'border-slate-200 bg-white/70 hover:border-purple-300'"
                                class="relative flex items-center gap-2 sm:gap-3 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border cursor-pointer transition-all"
                            >
                                <input type="radio" name="kat_tiket" value="15" x-model="katTiket" class="sr-only">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:pause-circle-bold" width="16" class="sm:w-[18px]"></iconify-icon>
                                </div>
                                <div class="text-left min-w-0">
                                    <div class="text-[11px] sm:text-xs font-bold text-slate-900 leading-tight truncate">Suspend</div>
                                    <div class="text-[9px] sm:text-[10px] text-slate-500 leading-tight truncate">Min. 6 bln aktif</div>
                                </div>
                            </label>

                            <!-- Kat 14: Terminasi -->
                            <label 
                                @click="katTiket = '14'"
                                :class="katTiket === '14' ? 'border-rose-500 bg-rose-50/90 ring-2 ring-rose-500/20 shadow-xs' : 'border-slate-200 bg-white/70 hover:border-rose-300'"
                                class="relative flex items-center gap-2 sm:gap-3 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border cursor-pointer transition-all"
                            >
                                <input type="radio" name="kat_tiket" value="14" x-model="katTiket" class="sr-only">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:user-cross-bold" width="16" class="sm:w-[18px]"></iconify-icon>
                                </div>
                                <div class="text-left min-w-0">
                                    <div class="text-[11px] sm:text-xs font-bold text-slate-900 leading-tight truncate">Terminasi</div>
                                    <div class="text-[9px] sm:text-[10px] text-slate-500 leading-tight truncate">Min. 6 bln aktif</div>
                                </div>
                            </label>

                        </div>
                    </div>

                    <!-- ================================================================= -->
                    <!-- FORM KONDISIONAL 1: GANGGUAN LAYANAN (11)                        -->
                    <!-- ================================================================= -->
                    <div x-show="katTiket === '11'" class="space-y-3 sm:space-y-4 pt-2.5 sm:pt-3 border-t border-slate-200/80">
                        <div class="text-[11px] sm:text-xs font-mono font-bold uppercase tracking-wider text-sky-700 flex items-center gap-1.5">
                            <iconify-icon icon="solar:shield-warning-bold"></iconify-icon>
                            <span>Rincian Kendala Gangguan Internet</span>
                        </div>

                        <!-- Pilihan Jenis Gangguan Populer -->
                        <div class="space-y-1">
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-800">
                                Indikasi Utama Gangguan: <span class="text-rose-500">*</span>
                            </label>
                            <select 
                                name="gangguan_type" 
                                class="w-full px-3 py-2 sm:px-4 sm:py-3 rounded-xl sm:rounded-2xl bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all shadow-2xs"
                            >
                                <option value="Lampu LOS Modem Merah / Berkedip" {{ old('gangguan_type') === 'Lampu LOS Modem Merah / Berkedip' ? 'selected' : '' }}>Lampu LOS Modem Merah / Berkedip (Kabel FO Putus)</option>
                                <option value="Mati Total (No Internet Access)" {{ old('gangguan_type') === 'Mati Total (No Internet Access)' ? 'selected' : '' }}>Mati Total / Tidak Ada Internet</option>
                                <option value="Koneksi Sangat Lambat / Lemot" {{ old('gangguan_type') === 'Koneksi Sangat Lambat / Lemot' ? 'selected' : '' }}>Koneksi Sangat Lambat / Lemot (Speed Drop)</option>
                                <option value="Sering Putus-Putus (RTO / Intermittent)" {{ old('gangguan_type') === 'Sering Putus-Putus (RTO / Intermittent)' ? 'selected' : '' }}>Sering Putus-Putus (RTO / Intermittent)</option>
                                <option value="Tidak Bisa Akses Situs / Aplikasi Tertentu" {{ old('gangguan_type') === 'Tidak Bisa Akses Situs / Aplikasi Tertentu' ? 'selected' : '' }}>Tidak Bisa Akses Situs / Aplikasi Tertentu</option>
                                <option value="Kendala Fisik Kabel / Tiang Roboh" {{ old('gangguan_type') === 'Kendala Fisik Kabel / Tiang Roboh' ? 'selected' : '' }}>Kendala Fisik Kabel Terjepit / Tiang Roboh</option>
                            </select>
                        </div>

                        <!-- Status Lampu Modem ONT -->
                        <div class="space-y-1">
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-800">
                                Lampu Indikator Modem yang Menyala Saat Ini:
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-1.5 sm:gap-2 text-[11px] sm:text-xs">
                                <label class="flex items-center gap-1.5 sm:gap-2 p-2 sm:p-2.5 rounded-lg sm:rounded-xl border border-slate-200 bg-white/70 hover:bg-white cursor-pointer transition-all">
                                    <input type="checkbox" name="indikator_lampu[]" value="Power Hijau" checked class="rounded text-sky-600 focus:ring-sky-500">
                                    <span class="font-medium text-slate-800">Power</span>
                                </label>
                                <label class="flex items-center gap-1.5 sm:gap-2 p-2 sm:p-2.5 rounded-lg sm:rounded-xl border border-slate-200 bg-white/70 hover:bg-white cursor-pointer transition-all">
                                    <input type="checkbox" name="indikator_lampu[]" value="PON Hijau" class="rounded text-sky-600 focus:ring-sky-500">
                                    <span class="font-medium text-slate-800">PON (Hijau)</span>
                                </label>
                                <label class="flex items-center gap-1.5 sm:gap-2 p-2 sm:p-2.5 rounded-lg sm:rounded-xl border border-rose-200 bg-rose-50/50 hover:bg-rose-50 cursor-pointer transition-all">
                                    <input type="checkbox" name="indikator_lampu[]" value="LOS Merah Berkedip" class="rounded text-rose-600 focus:ring-rose-500">
                                    <span class="font-medium text-rose-700">LOS (Merah)</span>
                                </label>
                                <label class="flex items-center gap-1.5 sm:gap-2 p-2 sm:p-2.5 rounded-lg sm:rounded-xl border border-slate-200 bg-white/70 hover:bg-white cursor-pointer transition-all">
                                    <input type="checkbox" name="indikator_lampu[]" value="WLAN / WiFi Menyala" checked class="rounded text-sky-600 focus:ring-sky-500">
                                    <span class="font-medium text-slate-800">WLAN / WiFi</span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-4">
                            <!-- Sudah restart modem -->
                            <div class="space-y-1">
                                <label class="block text-[11px] sm:text-xs font-bold text-slate-800">
                                    Sudah Coba Restart Modem?
                                </label>
                                <select name="restart_modem" class="w-full px-3 py-2 sm:px-3.5 sm:py-2.5 rounded-lg sm:rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-sky-500 shadow-2xs">
                                    <option value="Sudah direstart, kendala tetap sama">Sudah direstart, kendala tetap sama</option>
                                    <option value="Belum dicoba restart">Belum dicoba restart</option>
                                </select>
                            </div>

                            <!-- Waktu Mulai Kendala -->
                            <div class="space-y-1">
                                <label class="block text-[11px] sm:text-xs font-bold text-slate-800">
                                    Sejak Kapan Kendala Terjadi?
                                </label>
                                <input 
                                    type="text" 
                                    name="waktu_mulai" 
                                    placeholder="Contoh: Pagi ini jam 07:30" 
                                    value="{{ old('waktu_mulai', 'Hari ini') }}"
                                    class="w-full px-3 py-2 sm:px-3.5 sm:py-2.5 rounded-lg sm:rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-sky-500 shadow-2xs"
                                >
                            </div>
                        </div>

                        <!-- Kronologi / Deskripsi Tambahan -->
                        <div class="space-y-1">
                            <label for="description_gangguan" class="block text-[11px] sm:text-xs font-bold text-slate-800">
                                Penjelasan / Kronologi Lengkap:
                            </label>
                            <textarea 
                                id="description_gangguan" 
                                name="description" 
                                rows="2" 
                                placeholder="Keterangan detail tambahan untuk membantu teknisi..."
                                class="w-full px-3 py-2 sm:px-4 sm:py-3 rounded-xl sm:rounded-2xl bg-white border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all resize-none shadow-2xs"
                            >{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <!-- ================================================================= -->
                    <!-- FORM KONDISIONAL 2: UBAH PASSWORD WIFI (12)                       -->
                    <!-- ================================================================= -->
                    <div x-show="katTiket === '12'" class="space-y-4 pt-3 border-t border-slate-200/80">
                        <div class="p-3.5 rounded-2xl bg-pink-50/80 border border-pink-200 text-pink-900 text-xs flex items-start gap-2.5">
                            <iconify-icon icon="solar:info-circle-bold" class="text-pink-600 text-lg shrink-0 mt-0.5"></iconify-icon>
                            <span>Tim teknisi NOC kami akan mengirimkan konfigurasi SSID & password baru langsung ke modem ONT Anda secara remote.</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- SSID Baru -->
                            <div class="space-y-1.5">
                                <label for="wifi_ssid" class="block text-xs font-bold text-slate-800">
                                    Nama WiFi Baru (SSID) <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="wifi_ssid" 
                                    name="wifi_ssid" 
                                    value="{{ old('wifi_ssid') }}" 
                                    placeholder="Contoh: MSN-Keluarga"
                                    class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 shadow-sm"
                                >
                            </div>

                            <!-- Password Baru -->
                            <div class="space-y-1.5">
                                <label for="wifi_password" class="block text-xs font-bold text-slate-800">
                                    Password Baru WiFi <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        :type="showPassword ? 'text' : 'password'" 
                                        id="wifi_password" 
                                        name="wifi_password" 
                                        value="{{ old('wifi_password') }}" 
                                        placeholder="Minimal 8 karakter"
                                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 pr-10 shadow-sm"
                                    >
                                    <button 
                                        type="button" 
                                        @click="showPassword = !showPassword"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer"
                                    >
                                        <iconify-icon :icon="showPassword ? 'solar:eye-closed-bold' : 'solar:eye-bold'" width="18"></iconify-icon>
                                    </button>
                                </div>
                                <p class="text-[10px] text-slate-500">Gunakan kombinasi huruf dan angka agar aman.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Frekuensi WiFi -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-800">Frekuensi WiFi:</label>
                                <select name="wifi_band" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-pink-500 shadow-sm">
                                    <option value="Dual Band (2.4 GHz & 5 GHz)">Dual Band (2.4 GHz & 5 GHz) [Disarankan]</option>
                                    <option value="Hanya 2.4 GHz">Hanya 2.4 GHz (Jangkauan Luas)</option>
                                    <option value="Hanya 5 GHz">Hanya 5 GHz (Kecepatan Maksimal)</option>
                                </select>
                            </div>

                            <!-- Waktu Penerapan -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-800">Waktu Penerapan:</label>
                                <select name="wifi_schedule" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-pink-500 shadow-sm">
                                    <option value="Segera mungkin">Segera mungkin</option>
                                    <option value="Malam hari (setelah jam 22:00 WIB)">Malam hari (setelah jam 22:00 WIB)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Catatan Opsional -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">Catatan Tambahan (Opsional):</label>
                            <textarea 
                                name="wifi_notes" 
                                rows="2" 
                                placeholder="Contoh: Tolong disamakan password untuk frekuensi 2.4G dan 5G..."
                                class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-pink-500 resize-none shadow-sm"
                            >{{ old('wifi_notes') }}</textarea>
                        </div>
                    </div>

                    <!-- ================================================================= -->
                    <!-- FORM KONDISIONAL 3: UBAH LAYANAN / UPGRADE (17)                   -->
                    <!-- ================================================================= -->
                    <div x-show="katTiket === '17'" class="space-y-4 pt-3 border-t border-slate-200/80">
                        <!-- Info Banner Paket Aktif -->
                        <div class="p-3.5 sm:p-4 rounded-2xl bg-gradient-to-r from-emerald-500/10 via-teal-500/5 to-transparent border border-emerald-200/80 text-emerald-950 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 shadow-2xs">
                                    <iconify-icon icon="solar:round-transfer-vertical-bold" class="text-xl"></iconify-icon>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="text-[11px] font-mono uppercase tracking-wider text-emerald-700 font-bold block">Paket Aktif Anda Saat Ini:</span>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-xs sm:text-sm font-heading font-extrabold text-slate-900">
                                            {{ $customer->package->name ?? ($customer->bandwith->nama_bandwith ?? 'Broadband Internet') }}
                                        </span>
                                        @if(isset($customer->package->speed) || isset($customer->bandwith->nama_bandwith))
                                            <span class="px-2 py-0.5 rounded-lg bg-emerald-100/80 text-emerald-800 font-mono font-bold text-[10px] border border-emerald-200/60">
                                                {{ $customer->package->speed ?? $customer->bandwith->nama_bandwith }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(isset($customer->package->price) && $customer->package->price > 0)
                                <div class="sm:text-right pl-12 sm:pl-0">
                                    <span class="text-[10px] text-slate-500 block">Tarif Berjalan</span>
                                    <span class="text-xs font-mono font-bold text-emerald-700">{{ $customer->package->formatted_price ?? ('Rp ' . number_format($customer->package->price, 0, ',', '.')) }}/bln</span>
                                </div>
                            @endif
                        </div>

                        <!-- Card Pilihan Paket Baru -->
                        <div class="space-y-2.5">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div>
                                    <label class="block text-xs font-heading font-bold text-slate-900">
                                        Pilih Paket Internet Baru: <span class="text-rose-500">*</span>
                                    </label>
                                    <p class="text-[11px] text-slate-500">Pilih salah satu kartu paket di bawah ini yang sesuai dengan kebutuhan Anda.</p>
                                </div>

                                <!-- Filter Segment Tab (Rumahan vs Bisnis) -->
                                <div class="inline-flex p-1 rounded-xl bg-slate-100 border border-slate-200 text-xs self-start sm:self-auto">
                                    <button 
                                        type="button" 
                                        @click="packageCategoryTab = 'all'"
                                        :class="packageCategoryTab === 'all' ? 'bg-white text-emerald-700 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                                        class="px-2.5 py-1 rounded-lg transition-all cursor-pointer text-[11px]"
                                    >
                                        Semua
                                    </button>
                                    <button 
                                        type="button" 
                                        @click="packageCategoryTab = 'broadband'"
                                        :class="packageCategoryTab === 'broadband' ? 'bg-white text-emerald-700 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                                        class="px-2.5 py-1 rounded-lg transition-all cursor-pointer text-[11px]"
                                    >
                                        Rumahan
                                    </button>
                                    <button 
                                        type="button" 
                                        @click="packageCategoryTab = 'bisnis'"
                                        :class="packageCategoryTab === 'bisnis' ? 'bg-white text-emerald-700 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                                        class="px-2.5 py-1 rounded-lg transition-all cursor-pointer text-[11px]"
                                    >
                                        Bisnis
                                    </button>
                                </div>
                            </div>

                            <!-- Interactive Grid of Cards -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                @foreach($packages as $pkg)
                                    @php
                                        $isCurrent = ($customer->package_id && $customer->package_id == $pkg->id) || 
                                                     (strtolower($customer->package->name ?? '') === strtolower($pkg->name));
                                        $currentPrice = (int) ($customer->package->price ?? 0);
                                        $isUpgrade = $currentPrice > 0 && $pkg->price > $currentPrice;
                                        $isDowngrade = $currentPrice > 0 && $pkg->price < $currentPrice;
                                    @endphp
                                    <div 
                                        x-show="packageCategoryTab === 'all' || packageCategoryTab === '{{ $pkg->category ?? 'broadband' }}'"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-98"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        @click="selectPackage('{{ $pkg->id }}', {{ $pkg->price }}, '{{ addslashes($pkg->name) }}')"
                                        :class="selectedPackageId === '{{ $pkg->id }}' 
                                            ? 'border-emerald-500 bg-emerald-50/70 ring-2 ring-emerald-500/25 shadow-md scale-[1.01]' 
                                            : 'border-slate-200/90 bg-white/90 hover:border-emerald-300 hover:bg-white hover:shadow-sm'"
                                        class="relative rounded-2xl border p-3.5 sm:p-4 transition-all duration-200 cursor-pointer flex flex-col justify-between group overflow-hidden"
                                    >
                                        <!-- Hidden Radio Input -->
                                        <input 
                                            type="radio" 
                                            name="target_package_id" 
                                            value="{{ $pkg->id }}" 
                                            x-model="selectedPackageId"
                                            class="sr-only"
                                            @if(old('target_package_id') == $pkg->id) checked @endif
                                        >

                                        <!-- Card Header: Title & Badges -->
                                        <div>
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div class="space-y-0.5">
                                                    <div class="flex items-center gap-1.5 flex-wrap">
                                                        <h4 class="font-heading font-extrabold text-xs sm:text-sm text-slate-900 group-hover:text-emerald-700 transition-colors">
                                                            {{ $pkg->name }}
                                                        </h4>
                                                        @if($pkg->is_popular)
                                                            <span class="px-1.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[9px] font-bold border border-amber-200 flex items-center gap-0.5">
                                                                <iconify-icon icon="solar:star-bold" class="text-[10px] text-amber-500"></iconify-icon>
                                                                Populer
                                                            </span>
                                                        @endif
                                                        @if($isCurrent)
                                                            <span class="px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[9px] font-semibold border border-slate-200">
                                                                Paket Anda
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <span class="text-[10px] text-slate-500 block capitalize">
                                                        {{ $pkg->category === 'bisnis' ? 'Kategori Bisnis' : 'Kategori Broadband Rumah' }}
                                                    </span>
                                                </div>

                                                <!-- Select Checkmark Badge -->
                                                <div 
                                                    :class="selectedPackageId === '{{ $pkg->id }}' 
                                                        ? 'bg-emerald-600 text-white border-emerald-600 scale-110 shadow-xs' 
                                                        : 'bg-slate-100 text-transparent border-slate-200 group-hover:border-emerald-300 group-hover:text-slate-300'"
                                                    class="w-5 h-5 sm:w-6 sm:h-6 rounded-full border flex items-center justify-center transition-all shrink-0"
                                                >
                                                    <iconify-icon icon="solar:check-read-bold" class="text-xs sm:text-sm"></iconify-icon>
                                                </div>
                                            </div>

                                            <!-- Speed & Price Highlight -->
                                            <div class="my-2.5 p-2.5 rounded-xl bg-slate-50/80 border border-slate-100/80 flex items-center justify-between gap-2 group-hover:bg-emerald-50/40 transition-colors">
                                                <div class="flex items-center gap-1.5">
                                                    <div class="w-7 h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                                                        <iconify-icon icon="solar:round-transfer-vertical-bold" class="text-sm"></iconify-icon>
                                                    </div>
                                                    <div>
                                                        <div class="text-[10px] text-slate-400 font-mono leading-none">Kecepatan</div>
                                                        <div class="font-mono font-extrabold text-xs sm:text-sm text-slate-900 leading-tight">
                                                            {{ $pkg->speed }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-right">
                                                    <div class="font-mono font-extrabold text-xs sm:text-sm text-emerald-600">
                                                        {{ $pkg->formatted_price }}
                                                    </div>
                                                    <div class="text-[9px] text-slate-400 font-sans leading-none">/bulan</div>
                                                </div>
                                            </div>

                                            <!-- Short Description / Ideal Devices -->
                                            @if($pkg->ideal_devices)
                                                <div class="flex items-center gap-1.5 text-[11px] text-slate-600 mb-2">
                                                    <iconify-icon icon="solar:devices-bold" class="text-slate-400 text-xs shrink-0"></iconify-icon>
                                                    <span class="truncate">Ideal untuk: <strong class="text-slate-700">{{ $pkg->ideal_devices }}</strong></span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Card Footer: Upgrade / Downgrade Tag & Selection Button -->
                                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                                            @if($isUpgrade)
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-100/70 px-2 py-0.5 rounded-md">
                                                    <iconify-icon icon="solar:arrow-up-bold" class="text-xs"></iconify-icon>
                                                    Upgrade Speed
                                                </span>
                                            @elseif($isDowngrade)
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-700 bg-amber-100/70 px-2 py-0.5 rounded-md">
                                                    <iconify-icon icon="solar:arrow-down-bold" class="text-xs"></iconify-icon>
                                                    Downgrade Paket
                                                </span>
                                            @else
                                                <span class="text-[10px] text-slate-400">Unlimited Kuota (FUP Free)</span>
                                            @endif

                                            <span 
                                                :class="selectedPackageId === '{{ $pkg->id }}' ? 'text-emerald-700 font-bold' : 'text-slate-400 group-hover:text-emerald-600'"
                                                class="text-[10px] font-heading flex items-center gap-0.5"
                                            >
                                                <span x-text="selectedPackageId === '{{ $pkg->id }}' ? 'Terpilih' : 'Pilih Paket'"></span>
                                                <iconify-icon icon="solar:alt-arrow-right-bold" class="text-xs"></iconify-icon>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Grid Form Options: Jenis Perubahan & Tanggal Mulai -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 pt-2">
                            <!-- Jenis Permintaan -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-800">
                                    Jenis Perubahan: <span class="text-rose-500">*</span>
                                </label>
                                <select 
                                    name="change_type" 
                                    x-model="changeType"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 shadow-sm font-medium"
                                >
                                    <option value="Upgrade Kecepatan (Tambah Bandwidth)">Upgrade Kecepatan (Tambah Bandwidth)</option>
                                    <option value="Downgrade Paket">Downgrade Paket</option>
                                </select>
                            </div>

                            <!-- Tanggal Mulai Berlaku -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-800">Tanggal Mulai Berlaku:</label>
                                <select name="effective_date" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 shadow-sm font-medium">
                                    <option value="Mulai Awal Bulan Depan (Periode Tagihan Baru)">Mulai Awal Bulan Depan (Periode Tagihan Baru) [Disarankan]</option>
                                    <option value="Segera (Perhitungan biaya berjalan dihitung prorata)">Segera (Perhitungan biaya berjalan dihitung prorata)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Alasan Perubahan Paket -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">Alasan Perubahan Paket (Opsional):</label>
                            <textarea 
                                name="change_reason" 
                                rows="2" 
                                placeholder="Contoh: Kebutuhan streaming dan upload bertambah untuk kebutuhan kerja WFH..."
                                class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 resize-none shadow-sm"
                            >{{ old('change_reason') }}</textarea>
                        </div>
                    </div>

                    <!-- ================================================================= -->
                    <!-- FORM KONDISIONAL 4: CEK COVERAGE / RELOKASI PINDAH (13)          -->
                    <!-- ================================================================= -->
                    <div x-show="katTiket === '13'" class="space-y-4 pt-3 border-t border-slate-200/80">
                        <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200 text-amber-900 text-xs flex items-start gap-2.5">
                            <iconify-icon icon="solar:map-point-wave-bold" class="text-amber-600 text-lg shrink-0 mt-0.5"></iconify-icon>
                            <span>Tim jaringan kami akan memverifikasi ketersediaan tiang ODP fiber optic di lokasi baru sebelum jadwal instalasi relokasi ditentukan.</span>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">
                                Alamat Pemasangan Saat Ini (Terdaftar):
                            </label>
                            <div class="px-4 py-2.5 rounded-xl bg-slate-100 border border-slate-200 text-xs text-slate-600">
                                {{ $customer->address ?: 'Bekasi, Jawa Barat' }}
                            </div>
                        </div>

                        <!-- Alamat Baru Tujuan -->
                        <div class="space-y-1.5">
                            <label for="new_address" class="block text-xs font-bold text-slate-800">
                                Alamat Lengkap Lokasi Baru: <span class="text-rose-500">*</span>
                            </label>
                            <textarea 
                                id="new_address" 
                                name="new_address" 
                                rows="3" 
                                placeholder="Cantumkan Nama Jalan, Nomor Rumah, RT/RW, Blok, Kelurahan, Kecamatan, Kota..."
                                class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-amber-500 resize-none shadow-sm"
                            >{{ old('new_address') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Link Google Maps / Patokan -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-800">Link Google Maps / Patokan:</label>
                                <input 
                                    type="text" 
                                    name="location_maps" 
                                    value="{{ old('location_maps') }}" 
                                    placeholder="Contoh: https://maps.app.goo.gl/... atau dekat Masjid Al-Ikhlas"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-amber-500 shadow-sm"
                                >
                            </div>

                            <!-- Rencana Tanggal Pindah -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-800">
                                    Rencana Tanggal Pindah: <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    name="move_date" 
                                    value="{{ old('move_date', date('Y-m-d', strtotime('+7 days'))) }}" 
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-amber-500 shadow-sm"
                                >
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">Kontak Pendamping di Lokasi Baru:</label>
                            <input 
                                type="text" 
                                name="contact_person" 
                                value="{{ old('contact_person', $customer->phone) }}" 
                                placeholder="Nama & No WhatsApp yang bisa dihubungi saat survei lokasi"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-amber-500 shadow-sm"
                            >
                        </div>
                    </div>

                    <!-- ================================================================= -->
                    <!-- FORM KONDISIONAL 5: SUSPEND LAYANAN (15)                          -->
                    <!-- ================================================================= -->
                    <div x-show="katTiket === '15'" class="space-y-4 pt-3 border-t border-slate-200/80">
                        @if(!$customer->can_request_suspend)
                            <!-- Alert: Ineligible for Suspend (Under 6 months) -->
                            <div class="p-4 sm:p-5 rounded-2xl bg-amber-50 border border-amber-300 text-amber-950 space-y-3 shadow-xs">
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                                        <iconify-icon icon="solar:shield-warning-bold" class="text-xl"></iconify-icon>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="font-heading font-bold text-sm text-amber-900">
                                            Belum Memenuhi Syarat Suspend Layanan
                                        </h4>
                                        <p class="text-xs text-amber-800 leading-relaxed">
                                            Sesuai kebijakan PT MSN, pengajuan suspend layanan sementara hanya dapat dilakukan oleh pelanggan yang telah aktif berlangganan <strong>minimal 6 bulan berturut-turut</strong>.
                                        </p>
                                    </div>
                                </div>

                                <div class="p-3 rounded-xl bg-white/80 border border-amber-200 grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-mono uppercase">Berlangganan Sejak:</span>
                                        <span class="font-bold text-slate-900">{{ $customer->berlangganan_sejak }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-mono uppercase">Masa Aktif Saat Ini:</span>
                                        <span class="font-bold text-amber-700">{{ $customer->subscription_duration_text }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-mono uppercase">Syarat Minimal:</span>
                                        <span class="font-bold text-slate-800">6 Bulan (Kurang {{ max(1, 6 - $customer->subscription_months) }} Bulan)</span>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row items-center justify-between gap-2 pt-1 text-xs">
                                    <span class="text-amber-800 text-[11px]">Butuh bantuan terkait kendala atau perubahan paket?</span>
                                    <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20Admin,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20ingin%20konsultasi%20mengenai%20layanan%20saya" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-heading font-bold text-xs transition-all shadow-xs shrink-0">
                                        <iconify-icon icon="solar:chat-round-dots-bold"></iconify-icon>
                                        <span>Hubungi Customer Care</span>
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Eligibility Notice -->
                            <div class="p-3.5 rounded-2xl bg-purple-50/80 border border-purple-200 text-purple-900 text-xs flex items-start gap-2.5">
                                <iconify-icon icon="solar:pause-circle-bold" class="text-purple-600 text-lg shrink-0 mt-0.5"></iconify-icon>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-bold">Pengajuan Suspend Sementara</span>
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-semibold text-[10px]">
                                            ✓ Memenuhi Syarat (Aktif {{ $customer->subscription_duration_text }})
                                        </span>
                                    </div>
                                    <span>Layanan internet Anda akan dinonaktifkan sementara (misal: saat bepergian ke luar kota atau renovasi rumah). Jalur fiber optic Anda tetap tersimpan.</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Tanggal Mulai -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-slate-800">
                                        Tanggal Mulai Suspend: <span class="text-rose-500">*</span>
                                    </label>
                                    <input 
                                        type="date" 
                                        name="suspend_start" 
                                        value="{{ old('suspend_start', date('Y-m-d', strtotime('+3 days'))) }}" 
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-purple-500 shadow-sm"
                                    >
                                </div>

                                <!-- Estimasi Selesai -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-slate-800">Estimasi Tanggal Aktif Kembali:</label>
                                    <input 
                                        type="date" 
                                        name="suspend_end" 
                                        value="{{ old('suspend_end', date('Y-m-d', strtotime('+1 month'))) }}" 
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-purple-500 shadow-sm"
                                    >
                                </div>
                            </div>

                            <!-- Alasan Suspend -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-800">
                                    Alasan Penonaktifan Sementara: <span class="text-rose-500">*</span>
                                </label>
                                <select name="suspend_reason" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-purple-500 shadow-sm">
                                    <option value="Renovasi Rumah / Bangunan">Renovasi Rumah / Bangunan</option>
                                    <option value="Dinas / Bepergian Keluar Kota / Luar Negeri">Dinas / Bepergian Keluar Kota / Luar Negeri</option>
                                    <option value="Libur Panjang / Mudik">Libur Panjang / Mudik</option>
                                    <option value="Alasan Pribadi / Lainnya">Alasan Pribadi / Lainnya</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-800">Catatan Tambahan:</label>
                                <textarea 
                                    name="suspend_notes" 
                                    rows="2" 
                                    placeholder="Keterangan tambahan jika ada..."
                                    class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-purple-500 resize-none shadow-sm"
                                >{{ old('suspend_notes') }}</textarea>
                            </div>
                        @endif
                    </div>

                    <!-- ================================================================= -->
                    <!-- FORM KONDISIONAL 6: TERMINASI (14)                                -->
                    <!-- ================================================================= -->
                    <div x-show="katTiket === '14'" class="space-y-4 pt-3 border-t border-slate-200/80">
                        @if(!$customer->can_request_termination)
                            <!-- Alert: Ineligible for Termination (Under 6 months) -->
                            <div class="p-4 sm:p-5 rounded-2xl bg-rose-50 border border-rose-300 text-rose-950 space-y-3 shadow-xs">
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                                        <iconify-icon icon="solar:shield-warning-bold" class="text-xl"></iconify-icon>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="font-heading font-bold text-sm text-rose-900">
                                            Belum Memenuhi Syarat Terminasi Layanan
                                        </h4>
                                        <p class="text-xs text-rose-800 leading-relaxed">
                                            Sesuai ketentuan kontrak berlangganan PT MSN, pengajuan permohonan terminasi/penutupan layanan hanya dapat dilakukan setelah masa berlangganan <strong>minimal 6 bulan berturut-turut</strong>.
                                        </p>
                                    </div>
                                </div>

                                <div class="p-3 rounded-xl bg-white/80 border border-rose-200 grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-mono uppercase">Berlangganan Sejak:</span>
                                        <span class="font-bold text-slate-900">{{ $customer->berlangganan_sejak }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-mono uppercase">Masa Aktif Saat Ini:</span>
                                        <span class="font-bold text-rose-700">{{ $customer->subscription_duration_text }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-mono uppercase">Syarat Minimal:</span>
                                        <span class="font-bold text-slate-800">6 Bulan (Kurang {{ max(1, 6 - $customer->subscription_months) }} Bulan)</span>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row items-center justify-between gap-2 pt-1 text-xs">
                                    <span class="text-rose-800 text-[11px]">Memiliki kendala kualitas, kecepatan, atau biaya langganan?</span>
                                    <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20Admin,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20ingin%20konsultasi%20mengenai%20layanan%20saya" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-heading font-bold text-xs transition-all shadow-xs shrink-0">
                                        <iconify-icon icon="solar:chat-round-dots-bold"></iconify-icon>
                                        <span>Konsultasi Solusi Terbaik</span>
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Eligibility Notice -->
                            <div class="p-3.5 rounded-2xl bg-rose-50/90 border border-rose-200 text-rose-900 text-xs flex items-start gap-2.5">
                                <iconify-icon icon="solar:danger-circle-bold" class="text-rose-600 text-lg shrink-0 mt-0.5"></iconify-icon>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-bold">Pemberitahuan Penghentian Langganan</span>
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-semibold text-[10px]">
                                            ✓ Memenuhi Syarat Kontrak (Aktif {{ $customer->subscription_duration_text }})
                                        </span>
                                    </div>
                                    <span>Kami menyayangkan keputusan Anda. Jika terdapat kendala kecepatan atau harga paket, tim customer support kami selalu siap memberikan alternatif solusi terbaik.</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Tanggal Efektif -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-slate-800">
                                        Tanggal Efektif Berhenti: <span class="text-rose-500">*</span>
                                    </label>
                                    <input 
                                        type="date" 
                                        name="termination_date" 
                                        value="{{ old('termination_date', date('Y-m-d', strtotime('+7 days'))) }}" 
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-rose-500 shadow-sm"
                                    >
                                </div>

                                <!-- Alasan Penghentian -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-slate-800">
                                        Alasan Utama Berhenti: <span class="text-rose-500">*</span>
                                    </label>
                                    <select name="termination_reason" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-rose-500 shadow-sm">
                                        <option value="Pindah Tempat Tinggal ke Luar Jangkauan PT MSN">Pindah Tempat Tinggal ke Luar Jangkauan PT MSN</option>
                                        <option value="Rumah / Bangunan Sudah Tidak Ditempati">Rumah / Bangunan Sudah Tidak Ditempati</option>
                                        <option value="Efisiensi Anggaran / Kendala Biaya">Efisiensi Anggaran / Kendala Biaya</option>
                                        <option value="Beralih ke Internet Kantor / Hotspot Seluler">Beralih ke Internet Kantor / Hotspot Seluler</option>
                                        <option value="Menggunakan Layanan Provider Lain">Menggunakan Layanan Provider Lain</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Checkbox Kesiapan Pengembalian Modem -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                                <label class="flex items-start gap-2.5 text-xs text-slate-700 cursor-pointer">
                                    <input type="checkbox" name="agree_return_device" value="1" class="mt-0.5 rounded text-rose-600 focus:ring-rose-500">
                                    <span>Saya memahami bahwa perangkat Modem ONT & Adaptor adalah aset milik PT MSN dan bersedia diserahterimakan kembali kepada teknisi resmi saat proses penarikan. <span class="text-rose-500 font-bold">*</span></span>
                                </label>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-800">Saran & Evaluasi untuk Layanan PT MSN:</label>
                                <textarea 
                                    name="termination_notes" 
                                    rows="2" 
                                    placeholder="Beri kami masukan agar kami dapat terus berbenah dan meningkatkan kualitas..."
                                    class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-rose-500 resize-none shadow-sm"
                                >{{ old('termination_notes') }}</textarea>
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3 sm:pt-4 border-t border-slate-200 flex items-center justify-between gap-3 sm:gap-4">
                        <a href="{{ route('portal.tickets.index') }}" class="px-3.5 py-2 sm:px-5 sm:py-3 rounded-xl sm:rounded-2xl bg-slate-100 hover:bg-slate-200 text-xs font-heading font-bold text-slate-700 transition-colors">
                            Batal
                        </a>
                        
                        @if(!$customer->can_request_suspend)
                            <template x-if="katTiket === '15'">
                                <button 
                                    type="button" 
                                    disabled
                                    class="px-4 sm:px-6 py-2.5 sm:py-3.5 rounded-xl sm:rounded-2xl bg-slate-300 text-slate-500 font-heading font-bold text-xs sm:text-sm cursor-not-allowed flex items-center gap-1.5 sm:gap-2 shadow-none"
                                >
                                    <iconify-icon icon="solar:lock-keyhole-bold" width="16"></iconify-icon>
                                    <span>Suspend Belum Memenuhi Syarat</span>
                                </button>
                            </template>
                        @endif

                        @if(!$customer->can_request_termination)
                            <template x-if="katTiket === '14'">
                                <button 
                                    type="button" 
                                    disabled
                                    class="px-4 sm:px-6 py-2.5 sm:py-3.5 rounded-xl sm:rounded-2xl bg-slate-300 text-slate-500 font-heading font-bold text-xs sm:text-sm cursor-not-allowed flex items-center gap-1.5 sm:gap-2 shadow-none"
                                >
                                    <iconify-icon icon="solar:lock-keyhole-bold" width="16"></iconify-icon>
                                    <span>Terminasi Belum Memenuhi Syarat</span>
                                </button>
                            </template>
                        @endif

                        <template x-if="(katTiket !== '15' || {{ $customer->can_request_suspend ? 'true' : 'false' }}) && (katTiket !== '14' || {{ $customer->can_request_termination ? 'true' : 'false' }})">
                            <button 
                                type="submit" 
                                class="px-4 sm:px-6 py-2.5 sm:py-3.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-xs sm:text-sm shadow-md sm:shadow-lg shadow-sky-500/25 hover:scale-105 active:scale-95 transition-all flex items-center gap-1.5 sm:gap-2 cursor-pointer"
                            >
                                <iconify-icon icon="solar:plain-bold" width="16" class="sm:w-[18px]"></iconify-icon>
                                <span>Kirim Laporan Tiket</span>
                            </button>
                        </template>
                    </div>

                </form>

            </div>
        </div>

        <!-- Right 1 Col: Customer Info & SLA Notes -->
        <div class="space-y-3 sm:space-y-4">
            
            <!-- Customer Data Snapshot -->
            <div class="portal-card rounded-2xl sm:rounded-3xl p-3.5 sm:p-5 space-y-2.5 sm:space-y-3">
                <div class="text-[11px] sm:text-xs font-mono font-bold uppercase tracking-wider text-sky-700 flex items-center gap-1.5">
                    <iconify-icon icon="solar:user-id-bold"></iconify-icon>
                    <span>Data Pelapor:</span>
                </div>
                <div class="space-y-1.5 text-xs text-slate-600">
                    <div>
                        <span class="text-slate-400 block text-[10px] sm:text-[11px]">Nama:</span>
                        <span class="text-slate-900 font-bold block text-xs">{{ $customer->name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] sm:text-[11px]">ID Pelanggan:</span>
                        <span class="text-sky-600 font-mono font-bold block text-xs">{{ $customer->customer_id }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] sm:text-[11px]">Berlangganan Sejak:</span>
                        <span class="text-slate-900 font-bold block text-xs">{{ $customer->berlangganan_sejak }}</span>
                        <span class="text-emerald-600 font-semibold text-[10px] block">Aktif selama {{ $customer->subscription_duration_text }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] sm:text-[11px]">No. WhatsApp:</span>
                        <span class="text-slate-700 font-mono block text-xs">{{ $customer->phone }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] sm:text-[11px]">Paket Aktif:</span>
                        <span class="text-slate-800 font-semibold block text-xs">{{ $customer->package->name ?? 'Broadband' }} ({{ $customer->package->speed ?? '25 Mbps' }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] sm:text-[11px]">Alamat Pemasangan:</span>
                        <span class="text-slate-700 block text-[11px] leading-relaxed">{{ $customer->address ?? 'Bekasi, Jawa Barat' }}</span>
                    </div>
                </div>
            </div>

            <!-- Service Level Agreement (SLA) Guarantee -->
            <div class="portal-card rounded-2xl sm:rounded-3xl p-3.5 sm:p-5 bg-sky-50/80 border-sky-200 space-y-2 text-xs">
                <div class="font-heading font-bold text-sky-800 flex items-center gap-1.5">
                    <iconify-icon icon="solar:clock-circle-bold" class="text-sm sm:text-base"></iconify-icon>
                    <span>Komitmen Respon Cepat (SLA)</span>
                </div>
                <p class="text-[10px] sm:text-[11px] text-slate-600 leading-relaxed">
                    Setelah laporan dikirim:
                </p>
                <ul class="space-y-1 text-[10px] sm:text-[11px] text-slate-600 list-disc list-inside">
                    <li><strong class="text-slate-800">&lt; 15 Menit:</strong> Respon awal & remote check NOC.</li>
                    <li><strong class="text-white bg-sky-600 px-1 py-0.5 rounded text-[9px] sm:text-[10px]">&lt; 2 Jam:</strong> Penugasan teknisi ke lokasi.</li>
                </ul>
            </div>

        </div>

    </div>

</div>
@endsection
