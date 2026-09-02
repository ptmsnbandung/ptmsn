@extends('admin.layouts.app')

@section('title', 'Pesan Kontak Masuk')
@section('header', 'Kotak Masuk Pesan Pengunjung (Inbox)')

@section('content')
<div class="space-y-4">

    <!-- Header & Filter Tabs -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h2 class="font-heading font-bold text-base text-white">Kotak Masuk Pesan</h2>
            <p class="text-[11px] text-slate-400 font-mono">Pesan dan formulir konsultasi dari calon pelanggan</p>
        </div>
        
        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-1 p-1 rounded-xl bg-white/[0.04] border border-white/10 text-xs font-mono">
            <a href="{{ route('admin.messages.index') }}" class="px-2.5 py-1 rounded-lg transition-colors {{ empty($status) ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 hover:text-white' }}">
                Semua
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="px-2.5 py-1 rounded-lg transition-colors flex items-center gap-1 {{ $status === 'unread' ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 hover:text-white' }}">
                <span>Belum Dibaca</span>
                @if($unreadCount > 0)
                    <span class="px-1.5 py-0.2 rounded-full text-[9px] bg-emerald-500 text-slate-950 font-bold">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'read']) }}" class="px-2.5 py-1 rounded-lg transition-colors {{ $status === 'read' ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 hover:text-white' }}">
                Dibaca
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'replied']) }}" class="px-2.5 py-1 rounded-lg transition-colors {{ $status === 'replied' ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 hover:text-white' }}">
                Dibalas
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="rounded-2xl bg-white/[0.03] border border-white/10 overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-white/[0.04] text-[11px] font-mono font-bold uppercase text-slate-400 border-b border-white/10">
                    <tr>
                        <th class="py-2.5 px-4">Pengirim</th>
                        <th class="py-2.5 px-4">Kontak</th>
                        <th class="py-2.5 px-4">Subjek / Ringkasan</th>
                        <th class="py-2.5 px-4">Status</th>
                        <th class="py-2.5 px-4">Waktu</th>
                        <th class="py-2.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-white/[0.02] transition-colors {{ $msg->status === 'unread' ? 'bg-sky-500/[0.04]' : '' }}">
                            <td class="py-2.5 px-4">
                                <div class="font-heading font-semibold text-white text-xs sm:text-sm">{{ $msg->name }}</div>
                            </td>
                            <td class="py-2.5 px-4 font-mono text-[11px]">
                                <div><a href="mailto:{{ $msg->email }}" class="text-[#38bdf8] hover:underline">{{ $msg->email }}</a></div>
                                @if($msg->phone)
                                    <div class="text-slate-400 mt-0.5">{{ $msg->phone }}</div>
                                @endif
                            </td>
                            <td class="py-2.5 px-4 max-w-sm">
                                <div class="font-medium text-slate-200 text-xs truncate">{{ $msg->subject ?? 'Permintaan Informasi' }}</div>
                                <div class="text-[11px] text-slate-400 truncate mt-0.5">{{ $msg->message }}</div>
                            </td>
                            <td class="py-2.5 px-4">
                                @if($msg->status === 'unread')
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-[9px] font-mono font-bold">
                                        BELUM DIBACA
                                    </span>
                                @elseif($msg->status === 'replied')
                                    <span class="px-2 py-0.5 rounded-full bg-sky-500/15 border border-sky-500/30 text-sky-300 text-[9px] font-mono font-bold">
                                        SUDAH DIBALAS
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-slate-500/15 border border-slate-500/30 text-slate-300 text-[9px] font-mono font-bold">
                                        DIBACA
                                    </span>
                                @endif
                            </td>
                            <td class="py-2.5 px-4 font-mono text-[11px] text-slate-400">
                                {{ $msg->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="py-2.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.messages.show', $msg) }}" class="p-1.5 rounded-lg bg-[#38bdf8]/10 hover:bg-[#38bdf8]/20 text-[#38bdf8] transition-colors" title="Buka Pesan">
                                        <iconify-icon icon="solar:eye-bold" width="14"></iconify-icon>
                                    </a>
                                    <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Hapus pesan dari {{ $msg->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition-colors cursor-pointer" title="Hapus Pesan">
                                            <iconify-icon icon="solar:trash-bin-trash-bold" width="14"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500 font-mono">Belum ada pesan yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-3 border-t border-white/10 text-xs">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
