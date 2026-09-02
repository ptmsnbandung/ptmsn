@extends('admin.layouts.app')

@section('title', 'Kelola Klien & Mitra')
@section('header', 'Kelola Logo Klien & Mitra')

@section('content')
<div class="space-y-4">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h2 class="font-heading font-bold text-base text-white">Daftar Logo Klien & Mitra</h2>
            <p class="text-[11px] text-slate-400 font-mono">Kelola logo instansi & korporasi mitra</p>
        </div>
        <a href="{{ route('admin.clients.create') }}" class="px-3.5 py-2 rounded-lg bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs transition-all shadow-md shadow-sky-500/20 flex items-center gap-1.5">
            <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
            <span>Upload Logo Baru</span>
        </a>
    </div>

    <!-- Client Logo Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
        @forelse($clients as $client)
            <div class="p-3 rounded-xl bg-white/[0.03] border border-white/10 hover:border-sky-400/40 transition-all flex flex-col justify-between group">
                <div class="h-14 flex items-center justify-center p-1.5 bg-white/5 rounded-lg mb-2 border border-white/5 group-hover:bg-white/10 transition-colors">
                    <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" class="max-h-10 max-w-full object-contain filter drop-shadow">
                </div>
                <div>
                    <div class="font-heading font-semibold text-xs text-white truncate" title="{{ $client->name }}">
                        {{ $client->name }}
                    </div>
                    <div class="flex items-center justify-between mt-1.5 pt-1.5 border-t border-white/5 text-[10px] font-mono text-slate-400">
                        <span>#{{ $client->sort_order }}</span>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.clients.edit', $client) }}" class="p-1 text-slate-400 hover:text-white" title="Edit">
                                <iconify-icon icon="solar:pen-bold" width="12"></iconify-icon>
                            </a>
                            <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Hapus logo {{ $client->name }}?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-rose-400 hover:text-rose-300 cursor-pointer" title="Hapus">
                                    <iconify-icon icon="solar:trash-bin-trash-bold" width="12"></iconify-icon>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-8 text-center text-slate-500 font-mono text-xs">Belum ada logo klien yang terdaftar.</div>
        @endforelse
    </div>

</div>
@endsection
