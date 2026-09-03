@extends('admin.layouts.app')

@section('title', 'Kelola Paket Internet')
@section('header', 'Kelola Paket Internet Broadband')

@section('content')
<div class="space-y-4">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h2 class="font-heading font-bold text-base text-white">Daftar Paket Internet</h2>
            <p class="text-[11px] text-slate-400 font-mono">Kelola harga, kecepatan bandwidth, dan fitur paket</p>
        </div>
        <a href="{{ route('admin.packages.create') }}" class="px-3.5 py-2 rounded-lg bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs transition-all shadow-md shadow-sky-500/20 flex items-center gap-1.5">
            <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
            <span>Tambah Paket Baru</span>
        </a>
    </div>

    <!-- Table Card -->
    <div class="rounded-2xl bg-white/[0.03] border border-white/10 overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-white/[0.04] text-[11px] font-mono font-bold uppercase text-slate-400 border-b border-white/10">
                    <tr>
                        <th class="py-2.5 px-4">Urutan</th>
                        <th class="py-2.5 px-4">Paket</th>
                        <th class="py-2.5 px-4">Kecepatan</th>
                        <th class="py-2.5 px-4">Harga / Bulan</th>
                        <th class="py-2.5 px-4">Populer</th>
                        <th class="py-2.5 px-4">Status</th>
                        <th class="py-2.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($packages as $pkg)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-2.5 px-4 font-mono text-[11px] text-slate-400 font-bold">#{{ $pkg->sort_order }}</td>
                            <td class="py-2.5 px-4">
                                <div class="font-heading font-semibold text-white text-xs sm:text-sm">{{ $pkg->name }}</div>
                                <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-mono uppercase {{ $pkg->category === 'soho' ? 'bg-cyan-500/15 text-cyan-300 border border-cyan-400/30' : 'bg-slate-700/50 text-slate-300' }}">
                                    {{ $pkg->category === 'soho' ? 'SOHO' : 'BROADBAND' }}
                                </span>
                            </td>
                            <td class="py-2.5 px-4">
                                <span class="px-2 py-0.5 rounded bg-sky-500/10 border border-sky-500/20 text-[#38bdf8] font-mono text-[11px] font-bold">
                                    {{ $pkg->speed }}
                                </span>
                            </td>
                            <td class="py-2.5 px-4 font-mono font-bold text-slate-100">
                                Rp {{ number_format($pkg->price, 0, ',', '.') }}
                            </td>
                            <td class="py-2.5 px-4">
                                @if($pkg->is_popular)
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-[9px] font-mono font-bold">
                                        POPULER
                                    </span>
                                @else
                                    <span class="text-slate-500 font-mono">-</span>
                                @endif
                            </td>
                            <td class="py-2.5 px-4">
                                @if($pkg->is_active)
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
                                    <a href="{{ route('admin.packages.edit', $pkg) }}" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white transition-colors" title="Edit Paket">
                                        <iconify-icon icon="solar:pen-bold" width="14"></iconify-icon>
                                    </a>
                                    <form action="{{ route('admin.packages.destroy', $pkg) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket {{ $pkg->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition-colors cursor-pointer" title="Hapus Paket">
                                            <iconify-icon icon="solar:trash-bin-trash-bold" width="14"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500 font-mono">Belum ada paket internet yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
