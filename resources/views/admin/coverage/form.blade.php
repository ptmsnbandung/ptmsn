@extends('admin.layouts.app')

@section('title', $isEdit ? 'Edit Area Coverage' : 'Tambah Area Coverage')
@section('header', $isEdit ? 'Edit Area: ' . $area->district : 'Tambah Area Coverage Baru')

@section('content')
<div class="max-w-xl mx-auto space-y-4">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.coverage.index') }}" class="inline-flex items-center gap-1.5 text-xs font-mono text-slate-400 hover:text-white transition-colors">
            <iconify-icon icon="solar:arrow-left-linear" width="14"></iconify-icon>
            <span>Kembali ke Database Coverage</span>
        </a>
    </div>

    <div class="p-4 sm:p-5 rounded-2xl bg-white/[0.03] border border-white/10 shadow-lg">
        <form action="{{ $isEdit ? route('admin.coverage.update', $area) : route('admin.coverage.store') }}" method="POST" class="space-y-4">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <!-- City -->
                <div>
                    <label for="city" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Kota / Kabupaten</label>
                    <input 
                        type="text" 
                        id="city" 
                        name="city" 
                        value="{{ old('city', $area->city) }}" 
                        placeholder="Contoh: Bandung, Cimahi, Bekasi" 
                        required 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-heading font-bold"
                    >
                </div>

                <!-- District -->
                <div>
                    <label for="district" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Kecamatan</label>
                    <input 
                        type="text" 
                        id="district" 
                        name="district" 
                        value="{{ old('district', $area->district) }}" 
                        placeholder="Contoh: Coblong, Buahbatu" 
                        required 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <!-- Village -->
                <div>
                    <label for="village" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Kelurahan / Desa</label>
                    <input 
                        type="text" 
                        id="village" 
                        name="village" 
                        value="{{ old('village', $area->village) }}" 
                        placeholder="Contoh: Dago, Turangga" 
                        required 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all"
                    >
                </div>

                <!-- Postal Code -->
                <div>
                    <label for="postal_code" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Kode Pos (Opsional)</label>
                    <input 
                        type="text" 
                        id="postal_code" 
                        name="postal_code" 
                        value="{{ old('postal_code', $area->postal_code) }}" 
                        placeholder="40135" 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-mono"
                    >
                </div>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Status Ketersediaan Jaringan</label>
                <select 
                    id="status" 
                    name="status" 
                    required 
                    class="w-full px-3 py-2 rounded-xl bg-[#081528] border border-white/15 text-white text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all"
                >
                    <option value="covered" {{ old('status', $area->status) === 'covered' ? 'selected' : '' }}>TERCOVER (Fiber Optic Ready / Aktif)</option>
                    <option value="in_progress" {{ old('status', $area->status) === 'in_progress' ? 'selected' : '' }}>PROSES PENGGELARAN (Dalam Pengerjaan)</option>
                    <option value="pending" {{ old('status', $area->status) === 'pending' ? 'selected' : '' }}>PERENCANAAN (Tahap Survey)</option>
                </select>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Catatan Tambahan (Opsional)</label>
                <input 
                    type="text" 
                    id="notes" 
                    name="notes" 
                    value="{{ old('notes', $area->notes) }}" 
                    placeholder="Contoh: Tersedia Dedicated & Broadband" 
                    class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all"
                >
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-2.5">
                <a href="{{ route('admin.coverage.index') }}" class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-slate-300 text-xs font-heading font-medium transition-colors">
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-4 py-2 rounded-xl bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs transition-all shadow-md shadow-sky-500/20 flex items-center gap-1.5 cursor-pointer"
                >
                    <iconify-icon icon="solar:diskette-bold" width="16"></iconify-icon>
                    <span>{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Area' }}</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
