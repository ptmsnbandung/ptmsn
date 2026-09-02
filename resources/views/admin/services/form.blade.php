@extends('admin.layouts.app')

@section('title', $isEdit ? 'Edit Layanan Solusi' : 'Tambah Layanan Solusi')
@section('header', $isEdit ? 'Edit Layanan: ' . $service->title : 'Tambah Layanan Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-4">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-1.5 text-xs font-mono text-slate-400 hover:text-white transition-colors">
            <iconify-icon icon="solar:arrow-left-linear" width="14"></iconify-icon>
            <span>Kembali ke Daftar Layanan</span>
        </a>
    </div>

    <div class="p-4 sm:p-5 rounded-2xl bg-white/[0.03] border border-white/10 shadow-lg">
        <form action="{{ $isEdit ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST" class="space-y-4">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Nama Layanan</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title', $service->title) }}" 
                        placeholder="Contoh: Internet, Software Development" 
                        required 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-heading font-bold"
                    >
                </div>

                <!-- Iconify Icon Identifier -->
                <div>
                    <label for="icon" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Ikon Iconify</label>
                    <input 
                        type="text" 
                        id="icon" 
                        name="icon" 
                        value="{{ old('icon', $service->icon ?? 'solar:server-square-bold') }}" 
                        placeholder="solar:bolt-circle-bold" 
                        required 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-mono"
                    >
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Deskripsi Layanan</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="2" 
                    placeholder="Uraian komprehensif mengenai cakupan layanan ini..." 
                    required 
                    class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all"
                >{{ old('description', $service->description) }}</textarea>
            </div>

            <!-- Features -->
            <div>
                <label for="features" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">
                    Daftar Sub-Fitur (1 baris per item)
                </label>
                <textarea 
                    id="features" 
                    name="features" 
                    rows="4" 
                    placeholder="Internet Dedicated Service&#10;Internet Broadband dan SOHO Access&#10;Last Mile Solution" 
                    class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-mono"
                >{{ old('features', is_array($service->features) ? implode("\n", $service->features) : '') }}</textarea>
            </div>

            <!-- Sort Order & Active -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-3 border-t border-white/10 items-center">
                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Urutan</label>
                    <input 
                        type="number" 
                        id="sort_order" 
                        name="sort_order" 
                        value="{{ old('sort_order', $service->sort_order ?? 1) }}" 
                        required 
                        class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-mono"
                    >
                </div>

                <!-- Active Checkbox -->
                <div class="sm:pt-4">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-300">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1" 
                            {{ old('is_active', $isEdit ? $service->is_active : true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded bg-white/10 border-white/20 text-emerald-400 focus:ring-emerald-400"
                        >
                        <span class="font-heading font-medium">Status Aktif</span>
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-2.5">
                <a href="{{ route('admin.services.index') }}" class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-slate-300 text-xs font-heading font-medium transition-colors">
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-4 py-2 rounded-xl bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs transition-all shadow-md shadow-sky-500/20 flex items-center gap-1.5 cursor-pointer"
                >
                    <iconify-icon icon="solar:diskette-bold" width="16"></iconify-icon>
                    <span>{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Layanan' }}</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
