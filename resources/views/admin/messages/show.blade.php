@extends('admin.layouts.app')

@section('title', 'Detail Pesan Masuk')
@section('header', 'Detail Pesan: ' . $message->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-4">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-1.5 text-xs font-mono text-slate-400 hover:text-white transition-colors">
            <iconify-icon icon="solar:arrow-left-linear" width="14"></iconify-icon>
            <span>Kembali ke Kotak Masuk</span>
        </a>

        <div class="flex items-center gap-1.5">
            @if($message->status !== 'replied')
                <form action="{{ route('admin.messages.markAsReplied', $message) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-sky-500/15 hover:bg-sky-500/25 border border-sky-500/30 text-[#38bdf8] text-xs font-mono font-semibold transition-colors flex items-center gap-1 cursor-pointer">
                        <iconify-icon icon="solar:check-read-bold" width="14"></iconify-icon>
                        <span>Tandai Dibalas</span>
                    </button>
                </form>
            @endif

            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Hapus pesan ini secara permanen?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-400 text-xs font-mono font-semibold transition-colors flex items-center gap-1 cursor-pointer">
                    <iconify-icon icon="solar:trash-bin-trash-bold" width="14"></iconify-icon>
                    <span>Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Message Content Card -->
    <div class="p-4 sm:p-5 rounded-2xl bg-white/[0.03] border border-white/10 shadow-lg space-y-4">
        
        <!-- Header Info -->
        <div class="pb-3.5 border-b border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="font-heading font-bold text-base text-white">{{ $message->name }}</h2>
                    @if($message->status === 'unread')
                        <span class="px-1.5 py-0.2 rounded text-[8px] font-mono font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">BARU</span>
                    @elseif($message->status === 'replied')
                        <span class="px-1.5 py-0.2 rounded text-[8px] font-mono font-bold bg-sky-500/20 text-sky-400 border border-sky-500/30">SUDAH DIBALAS</span>
                    @endif
                </div>
                <div class="text-[11px] font-mono text-slate-400 mt-0.5">
                    Diterima: {{ $message->created_at->translatedFormat('d M Y - H:i') }}
                </div>
            </div>

            <!-- Quick Action: Reply Email or WhatsApp -->
            <div class="flex items-center gap-1.5">
                <a href="mailto:{{ $message->email }}?subject={{ urlencode('Re: ' . ($message->subject ?? 'Konsultasi Layanan PT Media Solusi Network')) }}" class="px-3 py-1.5 rounded-lg bg-[#38bdf8] text-[#050d1a] hover:bg-white hover:text-[#0284c7] text-xs font-heading font-bold transition-all flex items-center gap-1 shadow-md shadow-sky-500/20">
                    <iconify-icon icon="solar:letter-opened-bold" width="14"></iconify-icon>
                    <span>Balas Email</span>
                </a>
                @if($message->phone)
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $message->phone);
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        }
                    @endphp
                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Halo ' . $message->name . ', terima kasih telah menghubungi PT Media Solusi Network.') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-500 text-slate-950 hover:bg-white hover:text-emerald-600 text-xs font-heading font-bold transition-all flex items-center gap-1">
                        <iconify-icon icon="solar:chat-round-dots-bold" width="14"></iconify-icon>
                        <span>WhatsApp</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Sender Detail Matrix -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-3 rounded-xl bg-white/[0.02] border border-white/5 text-xs font-mono">
            <div>
                <span class="text-slate-500 block text-[10px] mb-0.5">Email:</span>
                <a href="mailto:{{ $message->email }}" class="text-[#38bdf8] hover:underline font-bold">{{ $message->email }}</a>
            </div>
            <div>
                <span class="text-slate-500 block text-[10px] mb-0.5">Nomor Telepon/WhatsApp:</span>
                <span class="text-white font-bold">{{ $message->phone ?? '-' }}</span>
            </div>
            @if($message->subject)
                <div class="sm:col-span-2 pt-2 border-t border-white/5">
                    <span class="text-slate-500 block text-[10px] mb-0.5">Subjek:</span>
                    <span class="text-white font-bold font-sans text-xs">{{ $message->subject }}</span>
                </div>
            @endif
        </div>

        <!-- Message Body -->
        <div class="space-y-1.5">
            <h3 class="text-[11px] font-mono font-bold uppercase tracking-wider text-slate-400">Isi Pesan:</h3>
            <div class="p-3.5 rounded-xl bg-white/[0.04] border border-white/10 text-white font-sans text-xs sm:text-sm leading-relaxed whitespace-pre-line">
                {{ $message->message }}
            </div>
        </div>

    </div>

</div>
@endsection
