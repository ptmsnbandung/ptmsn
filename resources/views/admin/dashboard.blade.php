@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Ringkasan Dashboard')

@section('content')
<div class="space-y-5">

    <!-- Welcome Banner (Compact) -->
    <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-[#0c2445] via-[#07172e] to-[#040e1f] border border-sky-500/20 shadow-md relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="relative z-10">
            <span class="text-[10px] font-mono font-bold text-[#38bdf8] uppercase tracking-wider px-2 py-0.5 rounded-full bg-sky-500/10 border border-sky-500/20 inline-block mb-1.5">PANEL ADMINISTRATOR</span>
            <h2 class="font-heading font-bold text-lg sm:text-xl text-white tracking-tight">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="text-slate-300 text-xs mt-0.5 max-w-xl">Kelola paket internet, rekayasa layanan, portofolio proyek, mitra, area coverage, dan pesan masuk dari satu dashboard.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0 relative z-10">
            <a href="{{ route('admin.settings.index') }}" class="px-3.5 py-2 rounded-lg bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs transition-all shadow-md shadow-sky-500/20 flex items-center gap-1.5">
                <iconify-icon icon="solar:pen-new-square-bold" width="14"></iconify-icon>
                <span>Edit Konten</span>
            </a>
            <a href="{{ route('home') }}" target="_blank" class="px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-white font-heading font-semibold text-xs transition-all border border-white/15 flex items-center gap-1">
                <iconify-icon icon="solar:link-bold" width="14"></iconify-icon>
                <span>Lihat Web</span>
            </a>
        </div>
    </div>

    <!-- Analytics Stat Cards (6 Grid Compact) -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
        
        <!-- Packages -->
        <a href="{{ route('admin.packages.index') }}" class="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 hover:border-sky-400/40 hover:bg-white/[0.06] transition-all group">
            <div class="flex items-center justify-between text-slate-400 group-hover:text-[#38bdf8] transition-colors mb-2">
                <iconify-icon icon="solar:box-minimalistic-bold" class="text-lg"></iconify-icon>
                <iconify-icon icon="solar:arrow-right-linear" class="text-xs opacity-0 group-hover:opacity-100 transition-opacity"></iconify-icon>
            </div>
            <div class="text-xl font-heading font-bold text-white">{{ $stats['packages_count'] }}</div>
            <div class="text-[11px] text-slate-400 font-mono mt-0.5">Paket Internet</div>
        </a>

        <!-- Services -->
        <a href="{{ route('admin.services.index') }}" class="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 hover:border-sky-400/40 hover:bg-white/[0.06] transition-all group">
            <div class="flex items-center justify-between text-slate-400 group-hover:text-[#38bdf8] transition-colors mb-2">
                <iconify-icon icon="solar:server-square-bold" class="text-lg"></iconify-icon>
                <iconify-icon icon="solar:arrow-right-linear" class="text-xs opacity-0 group-hover:opacity-100 transition-opacity"></iconify-icon>
            </div>
            <div class="text-xl font-heading font-bold text-white">{{ $stats['services_count'] }}</div>
            <div class="text-[11px] text-slate-400 font-mono mt-0.5">Layanan Solusi</div>
        </a>

        <!-- Portfolios -->
        <a href="{{ route('admin.portfolios.index') }}" class="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 hover:border-sky-400/40 hover:bg-white/[0.06] transition-all group">
            <div class="flex items-center justify-between text-slate-400 group-hover:text-[#38bdf8] transition-colors mb-2">
                <iconify-icon icon="solar:folder-with-files-bold" class="text-lg"></iconify-icon>
                <iconify-icon icon="solar:arrow-right-linear" class="text-xs opacity-0 group-hover:opacity-100 transition-opacity"></iconify-icon>
            </div>
            <div class="text-xl font-heading font-bold text-white">{{ $stats['portfolios_count'] }}</div>
            <div class="text-[11px] text-slate-400 font-mono mt-0.5">Portofolio Proyek</div>
        </a>

        <!-- Clients -->
        <a href="{{ route('admin.clients.index') }}" class="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 hover:border-sky-400/40 hover:bg-white/[0.06] transition-all group">
            <div class="flex items-center justify-between text-slate-400 group-hover:text-[#38bdf8] transition-colors mb-2">
                <iconify-icon icon="solar:users-group-two-rounded-bold" class="text-lg"></iconify-icon>
                <iconify-icon icon="solar:arrow-right-linear" class="text-xs opacity-0 group-hover:opacity-100 transition-opacity"></iconify-icon>
            </div>
            <div class="text-xl font-heading font-bold text-white">{{ $stats['clients_count'] }}</div>
            <div class="text-[11px] text-slate-400 font-mono mt-0.5">Mitra & Klien</div>
        </a>

        <!-- Coverage -->
        <a href="{{ route('admin.coverage.index') }}" class="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 hover:border-sky-400/40 hover:bg-white/[0.06] transition-all group">
            <div class="flex items-center justify-between text-slate-400 group-hover:text-[#38bdf8] transition-colors mb-2">
                <iconify-icon icon="solar:map-point-wave-bold" class="text-lg"></iconify-icon>
                <iconify-icon icon="solar:arrow-right-linear" class="text-xs opacity-0 group-hover:opacity-100 transition-opacity"></iconify-icon>
            </div>
            <div class="text-xl font-heading font-bold text-white">{{ $stats['coverage_count'] }}</div>
            <div class="text-[11px] text-slate-400 font-mono mt-0.5">Area Coverage</div>
        </a>

        <!-- Unread Messages -->
        <a href="{{ route('admin.messages.index') }}" class="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 hover:border-sky-400/40 hover:bg-white/[0.06] transition-all group {{ $stats['messages_unread'] > 0 ? 'border-emerald-500/40 bg-emerald-500/[0.05]' : '' }}">
            <div class="flex items-center justify-between text-slate-400 group-hover:text-[#38bdf8] transition-colors mb-2">
                <iconify-icon icon="solar:letter-bold" class="text-lg {{ $stats['messages_unread'] > 0 ? 'text-emerald-400' : '' }}"></iconify-icon>
                @if($stats['messages_unread'] > 0)
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                @endif
            </div>
            <div class="text-xl font-heading font-bold text-white">{{ $stats['messages_unread'] }}</div>
            <div class="text-[11px] text-slate-400 font-mono mt-0.5">Pesan Masuk</div>
        </a>

    </div>

    <!-- Two-Column Recent Data Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        
        <!-- Left: Recent Contact Messages (7 cols) -->
        <div class="lg:col-span-7 rounded-2xl bg-white/[0.03] border border-white/10 p-4 sm:p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-heading font-bold text-sm text-white">Pesan Kontak Masuk</h3>
                    <p class="text-[11px] text-slate-400 font-mono">Pesan terbaru dari calon pelanggan</p>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-mono text-[#38bdf8] hover:underline flex items-center gap-1">
                    <span>Semua</span>
                    <iconify-icon icon="solar:arrow-right-linear" width="12"></iconify-icon>
                </a>
            </div>

            @if($recentMessages->isEmpty())
                <div class="text-center py-8 text-slate-500 text-xs font-mono">Belum ada pesan masuk dari pengunjung.</div>
            @else
                <div class="space-y-2">
                    @foreach($recentMessages as $msg)
                        <a href="{{ route('admin.messages.show', $msg) }}" class="p-2.5 rounded-xl bg-white/[0.02] hover:bg-white/[0.05] border border-white/5 hover:border-white/15 transition-all flex items-center justify-between gap-3 group">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <span class="font-heading font-semibold text-xs text-white truncate">{{ $msg->name }}</span>
                                    <span class="text-[9px] font-mono text-slate-400">• {{ $msg->created_at->diffForHumans() }}</span>
                                    @if($msg->status === 'unread')
                                        <span class="px-1.5 py-0.2 rounded text-[8px] font-mono font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">BARU</span>
                                    @endif
                                </div>
                                <p class="text-[11px] text-slate-400 truncate">{{ $msg->subject ?? $msg->message }}</p>
                            </div>
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="text-slate-500 group-hover:text-white transition-colors text-xs"></iconify-icon>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Active Packages Summary (5 cols) -->
        <div class="lg:col-span-5 rounded-2xl bg-white/[0.03] border border-white/10 p-4 sm:p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-heading font-bold text-sm text-white">Daftar Paket Internet</h3>
                        <p class="text-[11px] text-slate-400 font-mono">Kecepatan & harga aktif</p>
                    </div>
                    <a href="{{ route('admin.packages.index') }}" class="text-xs font-mono text-[#38bdf8] hover:underline flex items-center gap-1">
                        <span>Kelola</span>
                        <iconify-icon icon="solar:arrow-right-linear" width="12"></iconify-icon>
                    </a>
                </div>

                <div class="space-y-2">
                    @foreach($packages as $pkg)
                        <div class="p-2.5 rounded-xl bg-white/[0.02] border border-white/5 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-sky-500/10 border border-sky-500/20 text-[#38bdf8] flex items-center justify-center font-mono font-bold text-[11px]">
                                    {{ $pkg->speed }}
                                </div>
                                <div>
                                    <div class="font-heading font-semibold text-xs text-white flex items-center gap-1.5">
                                        <span>{{ $pkg->name }}</span>
                                        @if($pkg->is_popular)
                                            <span class="px-1 py-0.2 text-[8px] font-mono bg-sky-500/20 text-[#38bdf8] rounded border border-sky-500/30">POPULER</span>
                                        @endif
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-mono">Rp {{ number_format($pkg->price, 0, ',', '.') }}/{{ $pkg->period }}</div>
                                </div>
                            </div>
                            <a href="{{ route('admin.packages.edit', $pkg) }}" class="p-1.5 text-slate-400 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                                <iconify-icon icon="solar:pen-bold" width="14"></iconify-icon>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-white/10">
                <a href="{{ route('admin.packages.create') }}" class="w-full py-2 rounded-lg bg-white/[0.05] hover:bg-white/10 text-xs font-heading font-semibold text-slate-200 transition-colors border border-white/10 flex items-center justify-center gap-1.5">
                    <iconify-icon icon="solar:add-circle-bold" width="14"></iconify-icon>
                    <span>Tambah Paket Baru</span>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
