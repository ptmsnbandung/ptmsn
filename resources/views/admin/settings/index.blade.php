@extends('admin.layouts.app')

@section('title', 'Kelola Teks & Copywriting')
@section('header', 'Kelola Teks & Copywriting Website')

@section('content')
<div class="space-y-4">
    
    <!-- Top Nav Tabs by Group (Compact) -->
    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 border-b border-white/10">
        @foreach($groups as $key => $title)
            <a 
                href="{{ route('admin.settings.index', ['group' => $key]) }}" 
                class="px-3.5 py-1.5 rounded-lg text-xs font-heading font-semibold whitespace-nowrap transition-all flex items-center gap-1.5 {{ $group === $key ? 'bg-[#38bdf8] text-[#050d1a] shadow-md shadow-sky-500/20 font-bold' : 'bg-white/[0.04] text-slate-300 hover:bg-white/10 hover:text-white border border-white/10' }}"
            >
                <span>{{ $title }}</span>
            </a>
        @endforeach
    </div>

    <!-- Edit Form Card (Compact) -->
    <div class="p-4 sm:p-5 rounded-2xl bg-white/[0.03] border border-white/10 shadow-lg">
        <div class="mb-4 pb-3 border-b border-white/10 flex items-center justify-between">
            <div>
                <h2 class="font-heading font-bold text-base text-white">{{ $groups[$group] ?? 'Pengaturan' }}</h2>
                <p class="text-[11px] text-slate-400 font-mono mt-0.5">Ubah teks di bawah ini dan klik Simpan Perubahan.</p>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white/10 hover:bg-white/20 text-[11px] font-mono text-[#38bdf8] transition-colors">
                <span>Cek Live</span>
                <iconify-icon icon="solar:arrow-right-up-linear" width="12"></iconify-icon>
            </a>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="group" value="{{ $group }}">

            <div class="space-y-3.5">
                @foreach($settings as $setting)
                    <div class="space-y-1">
                        <label for="{{ $setting->key }}" class="block text-[11px] font-mono font-bold uppercase text-slate-300">
                            {{ $setting->label ?? $setting->key }}
                            <span class="text-slate-500 font-normal lowercase">({{ $setting->key }})</span>
                        </label>

                        @if($setting->type === 'textarea')
                            <textarea 
                                id="{{ $setting->key }}" 
                                name="{{ $setting->key }}" 
                                rows="2" 
                                class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 focus:border-[#38bdf8] focus:ring-1 focus:ring-[#38bdf8] text-white text-xs sm:text-sm font-sans transition-all placeholder:text-slate-500 resize-y"
                            >{{ old($setting->key, $setting->value) }}</textarea>
                        @else
                            <input 
                                type="text" 
                                id="{{ $setting->key }}" 
                                name="{{ $setting->key }}" 
                                value="{{ old($setting->key, $setting->value) }}"
                                class="w-full px-3 py-2 rounded-xl bg-white/[0.04] border border-white/15 focus:border-[#38bdf8] focus:ring-1 focus:ring-[#38bdf8] text-white text-xs sm:text-sm font-sans transition-all placeholder:text-slate-500"
                            >
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-3">
                <button 
                    type="submit" 
                    class="px-5 py-2 rounded-xl bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs transition-all shadow-md shadow-sky-500/20 flex items-center gap-1.5 cursor-pointer"
                >
                    <iconify-icon icon="solar:diskette-bold" width="14"></iconify-icon>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
