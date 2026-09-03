@extends('admin.layouts.app')

@section('title', $isEdit ? 'Edit Paket Internet' : 'Tambah Paket Internet')
@section('header', $isEdit ? 'Edit Paket: ' . $package->name : 'Tambah Paket Internet Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-4">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center gap-1.5 text-xs font-mono text-slate-400 hover:text-white transition-colors">
            <iconify-icon icon="solar:arrow-left-linear" width="14"></iconify-icon>
            <span>Kembali ke Daftar Paket</span>
        </a>
    </div>

    <div class="p-4 sm:p-5 rounded-2xl bg-white/[0.03] border border-white/10 shadow-lg">
        <form action="{{ $isEdit ? route('admin.packages.update', $package) : route('admin.packages.store') }}" method="POST" class="space-y-4">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Nama Paket</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $package->name) }}" 
                        placeholder="BRONZE, CRYSTAL, dsb" 
                        required 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-heading font-bold uppercase"
                    >
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Kategori Paket</label>
                    <select 
                        id="category" 
                        name="category" 
                        class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-white/15 text-white text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-mono"
                    >
                        <option value="broadband" class="bg-slate-900 text-white" {{ old('category', $package->category) === 'broadband' ? 'selected' : '' }}>Broadband (Rumah)</option>
                        <option value="soho" class="bg-slate-900 text-white" {{ old('category', $package->category) === 'soho' ? 'selected' : '' }}>SOHO (Bisnis & Kantor)</option>
                    </select>
                </div>

                <!-- Speed -->
                <div>
                    <label for="speed" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Kecepatan</label>
                    <input 
                        type="text" 
                        id="speed" 
                        name="speed" 
                        value="{{ old('speed', $package->speed) }}" 
                        placeholder="Contoh: 15 Mbps, 50 Mbps" 
                        required 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-mono"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                <!-- Price -->
                <div class="sm:col-span-2">
                    <label for="price" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Harga (Rupiah)</label>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        value="{{ old('price', $package->price) }}" 
                        placeholder="200000" 
                        required 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-mono font-bold"
                    >
                </div>

                <!-- Period -->
                <div>
                    <label for="period" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Periode</label>
                    <input 
                        type="text" 
                        id="period" 
                        name="period" 
                        value="{{ old('period', $package->period ?? 'bln') }}" 
                        placeholder="bln" 
                        required 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-mono"
                    >
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Deskripsi Singkat</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="2" 
                    placeholder="Deskripsi target pengguna paket..." 
                    class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all"
                >{{ old('description', $package->description) }}</textarea>
            </div>

            <!-- Features -->
            <div>
                <label for="features" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">
                    Daftar Fitur (1 baris per fitur)
                </label>
                <textarea 
                    id="features" 
                    name="features" 
                    rows="4" 
                    placeholder="Unlimited Akses (Tanpa FUP)&#10;Fast Network Fiber Optic&#10;Termasuk Modem ONT / WiFi" 
                    class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-mono"
                >{{ old('features', is_array($package->features) ? implode("\n", $package->features) : '') }}</textarea>
            </div>

            <!-- Sort Order & Options -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 pt-3 border-t border-white/10 items-center">
                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Urutan</label>
                    <input 
                        type="number" 
                        id="sort_order" 
                        name="sort_order" 
                        value="{{ old('sort_order', $package->sort_order ?? 1) }}" 
                        required 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-mono"
                    >
                </div>

                <!-- Popular Checkbox -->
                <div class="sm:pt-4">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-300">
                        <input 
                            type="checkbox" 
                            name="is_popular" 
                            value="1" 
                            {{ old('is_popular', $package->is_popular) ? 'checked' : '' }}
                            class="w-4 h-4 rounded bg-white/10 border-white/20 text-[#38bdf8] focus:ring-[#38bdf8]"
                        >
                        <span class="font-heading font-medium">Tandai Populer</span>
                    </label>
                </div>

                <!-- Active Checkbox -->
                <div class="sm:pt-4">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-300">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1" 
                            {{ old('is_active', $isEdit ? $package->is_active : true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded bg-white/10 border-white/20 text-emerald-400 focus:ring-emerald-400"
                        >
                        <span class="font-heading font-medium">Status Aktif</span>
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-2.5">
                <a href="{{ route('admin.packages.index') }}" class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-slate-300 text-xs font-heading font-medium transition-colors">
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-4 py-2 rounded-xl bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs transition-all shadow-md shadow-sky-500/20 flex items-center gap-1.5 cursor-pointer"
                >
                    <iconify-icon icon="solar:diskette-bold" width="16"></iconify-icon>
                    <span>{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Paket' }}</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
