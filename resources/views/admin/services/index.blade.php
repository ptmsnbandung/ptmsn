@extends('admin.layouts.app')

@section('title', 'Kelola Layanan')
@section('header', 'Kelola Layanan & Solusi')

@section('content')
<div class="space-y-4">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h2 class="font-heading font-bold text-base text-white">Daftar Layanan Solusi</h2>
            <p class="text-[11px] text-slate-400 font-mono">Kelola pilar layanan utama (Internet, Software, IT Solution)</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="px-3.5 py-2 rounded-lg bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs transition-all shadow-md shadow-sky-500/20 flex items-center gap-1.5">
            <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
            <span>Tambah Layanan Baru</span>
        </a>
    </div>

    <!-- Table Card -->
    <div class="rounded-2xl bg-white/[0.03] border border-white/10 overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-white/[0.04] text-[11px] font-mono font-bold uppercase text-slate-400 border-b border-white/10">
                    <tr>
                        <th class="py-2.5 px-4">Urutan</th>
                        <th class="py-2.5 px-4">Layanan</th>
                        <th class="py-2.5 px-4">Ikon</th>
                        <th class="py-2.5 px-4">Deskripsi</th>
                        <th class="py-2.5 px-4">Fitur</th>
                        <th class="py-2.5 px-4">Status</th>
                        <th class="py-2.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($services as $srv)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-2.5 px-4 font-mono text-[11px] text-slate-400 font-bold">#{{ $srv->sort_order }}</td>
                            <td class="py-2.5 px-4 font-heading font-semibold text-white text-xs sm:text-sm">{{ $srv->title }}</td>
                            <td class="py-2.5 px-4">
                                <div class="w-7 h-7 rounded-lg bg-sky-500/10 border border-sky-500/20 text-[#38bdf8] flex items-center justify-center">
                                    <iconify-icon icon="{{ $srv->icon }}" width="14"></iconify-icon>
                                </div>
                            </td>
                            <td class="py-2.5 px-4 max-w-xs truncate text-[11px] text-slate-400">
                                {{ $srv->description }}
                            </td>
                            <td class="py-2.5 px-4 font-mono text-[11px]">
                                {{ is_array($srv->features) ? count($srv->features) : 0 }} Fitur
                            </td>
                            <td class="py-2.5 px-4">
                                @if($srv->is_active)
                                    <span class="inline-flex items-center gap-1 text-[11px] text-emerald-400 font-mono">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] text-slate-500 font-mono">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                        <span>Non-Aktif</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-2.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.services.edit', $srv) }}" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white transition-colors" title="Edit Layanan">
                                        <iconify-icon icon="solar:pen-bold" width="14"></iconify-icon>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $srv) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan {{ $srv->title }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition-colors cursor-pointer" title="Hapus Layanan">
                                            <iconify-icon icon="solar:trash-bin-trash-bold" width="14"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500 font-mono">Belum ada layanan yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
