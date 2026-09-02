@extends('admin.layouts.app')

@section('title', 'Cakupan Area (Coverage)')
@section('header', 'Kelola Area Cakupan Jaringan')

@section('content')
<div class="space-y-4">

    <!-- Header Actions & Search -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h2 class="font-heading font-bold text-base text-white">Database Area Tercover</h2>
            <p class="text-[11px] text-slate-400 font-mono">Kelola data kecamatan/kelurahan untuk widget pengecekan jaringan</p>
        </div>
        <div class="flex items-center gap-2.5 w-full sm:w-auto">
            <form action="{{ route('admin.coverage.index') }}" method="GET" class="relative flex-1 sm:w-56">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Cari kota/kecamatan..." 
                    class="w-full pl-8 pr-3 py-1.5 rounded-xl bg-white/[0.04] border border-white/10 text-white placeholder-slate-500 text-xs focus:outline-none focus:ring-1 focus:ring-[#38bdf8]"
                >
                <iconify-icon icon="solar:magnifer-linear" class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></iconify-icon>
            </form>
            <a href="{{ route('admin.coverage.create') }}" class="px-3.5 py-1.5 rounded-xl bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs transition-all shadow-md shadow-sky-500/20 flex items-center gap-1.5 shrink-0">
                <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
                <span>Tambah Area</span>
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="rounded-2xl bg-white/[0.03] border border-white/10 overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-white/[0.04] text-[11px] font-mono font-bold uppercase text-slate-400 border-b border-white/10">
                    <tr>
                        <th class="py-2.5 px-4">Kota / Kabupaten</th>
                        <th class="py-2.5 px-4">Kecamatan</th>
                        <th class="py-2.5 px-4">Kelurahan / Desa</th>
                        <th class="py-2.5 px-4">Kode Pos</th>
                        <th class="py-2.5 px-4">Status Jaringan</th>
                        <th class="py-2.5 px-4">Catatan</th>
                        <th class="py-2.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($areas as $area)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-2.5 px-4 font-heading font-semibold text-white text-xs sm:text-sm">{{ $area->city }}</td>
                            <td class="py-2.5 px-4 text-slate-200">{{ $area->district }}</td>
                            <td class="py-2.5 px-4 text-slate-300">{{ $area->village }}</td>
                            <td class="py-2.5 px-4 font-mono text-[11px] text-slate-400">{{ $area->postal_code ?? '-' }}</td>
                            <td class="py-2.5 px-4">
                                @if($area->status === 'covered')
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-[10px] font-mono font-bold">
                                        TERCOVER (READY)
                                    </span>
                                @elseif($area->status === 'in_progress')
                                    <span class="px-2 py-0.5 rounded-full bg-amber-500/15 border border-amber-500/30 text-amber-300 text-[10px] font-mono font-bold">
                                        PENGGELARAN
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-slate-500/15 border border-slate-500/30 text-slate-300 text-[10px] font-mono font-bold">
                                        PERENCANAAN
                                    </span>
                                @endif
                            </td>
                            <td class="py-2.5 px-4 text-[11px] text-slate-400 truncate max-w-xs">{{ $area->notes ?? '-' }}</td>
                            <td class="py-2.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.coverage.edit', $area) }}" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white transition-colors" title="Edit Area">
                                        <iconify-icon icon="solar:pen-bold" width="14"></iconify-icon>
                                    </a>
                                    <form action="{{ route('admin.coverage.destroy', $area) }}" method="POST" onsubmit="return confirm('Hapus area {{ $area->district }}, {{ $area->city }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition-colors cursor-pointer" title="Hapus Area">
                                            <iconify-icon icon="solar:trash-bin-trash-bold" width="14"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500 font-mono">Tidak ada data area coverage.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($areas->hasPages())
            <div class="p-3 border-t border-white/10 text-xs">
                {{ $areas->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
