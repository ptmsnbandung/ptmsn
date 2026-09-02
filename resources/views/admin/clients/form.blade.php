@extends('admin.layouts.app')

@section('title', $isEdit ? 'Edit Klien' : 'Upload Logo Klien Baru')
@section('header', $isEdit ? 'Edit Klien: ' . $client->name : 'Tambah Mitra/Klien Baru')

@section('content')
<div class="max-w-xl mx-auto space-y-4">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.clients.index') }}" class="inline-flex items-center gap-1.5 text-xs font-mono text-slate-400 hover:text-white transition-colors">
            <iconify-icon icon="solar:arrow-left-linear" width="14"></iconify-icon>
            <span>Kembali ke Daftar Klien</span>
        </a>
    </div>

    <div class="p-4 sm:p-5 rounded-2xl bg-white/[0.03] border border-white/10 shadow-lg">
        <form action="{{ $isEdit ? route('admin.clients.update', $client) : route('admin.clients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- Client Name -->
            <div>
                <label for="name" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">Nama Instansi / Perusahaan</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $client->name) }}" 
                    placeholder="Contoh: Telkom Indonesia, PLN, KPU" 
                    required 
                    class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 text-white placeholder-slate-500 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all font-heading font-bold"
                >
            </div>

            <!-- Logo Upload -->
            <div>
                <label for="logo" class="block text-[11px] font-mono font-bold uppercase text-slate-300 mb-1">File Logo Perusahaan</label>
                
                @if($isEdit && $client->logo)
                    <div class="mb-2 flex items-center gap-3 p-2 rounded-xl bg-white/[0.02] border border-white/10 w-fit">
                        <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" class="h-8 max-w-[100px] object-contain">
                        <span class="text-[10px] text-slate-400 font-mono">Logo saat ini</span>
                    </div>
                @endif

                <input 
                    type="file" 
                    id="logo" 
                    name="logo" 
                    accept="image/*"
                    {{ $isEdit ? '' : 'required' }}
                    class="w-full px-3 py-1.5 rounded-xl bg-white/[0.04] border border-white/15 text-white text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-[#38bdf8] file:text-[#050d1a] hover:file:bg-white transition-all cursor-pointer"
                >
                <p class="text-[10px] text-slate-400 font-mono mt-1">Format: PNG, SVG, JPG, WEBP. Maksimal: 2MB.</p>
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
                        value="{{ old('sort_order', $client->sort_order ?? 1) }}" 
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
                            {{ old('is_active', $isEdit ? $client->is_active : true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded bg-white/10 border-white/20 text-emerald-400 focus:ring-emerald-400"
                        >
                        <span class="font-heading font-medium">Status Aktif</span>
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-2.5">
                <a href="{{ route('admin.clients.index') }}" class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-slate-300 text-xs font-heading font-medium transition-colors">
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-4 py-2 rounded-xl bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs transition-all shadow-md shadow-sky-500/20 flex items-center gap-1.5 cursor-pointer"
                >
                    <iconify-icon icon="solar:diskette-bold" width="16"></iconify-icon>
                    <span>{{ $isEdit ? 'Simpan Perubahan' : 'Upload Logo' }}</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
