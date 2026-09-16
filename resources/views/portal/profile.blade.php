@extends('portal.layouts.app')

@section('title', 'Profil & Layanan Pelanggan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <div class="inline-flex items-center gap-1.5 text-xs font-mono font-bold text-[#38bdf8] uppercase tracking-wider mb-1">
            <iconify-icon icon="solar:user-circle-bold"></iconify-icon>
            <span>INFORMASI AKUN</span>
        </div>
        <h1 class="text-2xl font-heading font-extrabold text-white tracking-tight">Profil & Paket Langganan</h1>
        <p class="text-xs sm:text-sm text-slate-400">Kelola data kontak dan informasi langganan internet Anda di PT MSN</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 1 Col: Subscription Info Card -->
        <div class="space-y-4">
            <div class="portal-card rounded-3xl p-6 space-y-4">
                <div class="flex items-center gap-3 pb-4 border-b border-white/10">
                    <div class="w-12 h-12 rounded-2xl bg-[#38bdf8]/20 border border-[#38bdf8]/40 text-[#38bdf8] flex items-center justify-center font-heading font-extrabold text-lg">
                        {{ substr($customer->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-sm font-heading font-bold text-white">{{ $customer->name }}</div>
                        <div class="text-xs font-mono text-[#38bdf8]">{{ $customer->customer_id }}</div>
                    </div>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Paket Internet:</span>
                        <span class="text-white font-bold text-sm">{{ $customer->package->name ?? 'Broadband' }}</span>
                        <span class="text-sky-400 font-mono text-xs block">Speed: {{ $customer->package->speed ?? '25 Mbps' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Tarif Bulanan:</span>
                        <span class="text-white font-bold">Rp {{ number_format($customer->billing_amount, 0, ',', '.') }} / bln</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Tanggal Jatuh Tempo:</span>
                        <span class="text-slate-200">Setiap tanggal {{ $customer->due_date }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Alamat IP Pelanggan:</span>
                        <span class="text-[#38bdf8] font-mono">{{ $customer->ip_address ?? '10.20.104.22' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Status Akun:</span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-400 font-semibold text-[11px] mt-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Aktif & Terhubung
                        </span>
                    </div>
                </div>
            </div>

            <!-- Upgrade Package Notice -->
            <div class="portal-card rounded-2xl p-5 bg-gradient-to-br from-sky-950/30 to-blue-950/20 border-sky-500/20 space-y-2 text-xs">
                <div class="font-heading font-bold text-white flex items-center gap-1.5 text-[#38bdf8]">
                    <iconify-icon icon="solar:bolt-bold"></iconify-icon>
                    <span>Ingin Upgrade Kecepatan?</span>
                </div>
                <p class="text-[11px] text-slate-300">
                    Tingkatkan kecepatan internet hingga 100 Mbps tanpa biaya penarikan ulang kabel fiber.
                </p>
                <a href="https://wa.me/6281214878436?text=Halo%20Admin,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20ingin%20upgrade%20paket" target="_blank" class="w-full py-2 px-3 rounded-xl bg-sky-500 hover:bg-sky-400 text-[#050d1a] font-heading font-bold text-xs transition-all flex items-center justify-center gap-1 mt-2">
                    <span>Chat Admin Upgrade</span>
                    <iconify-icon icon="solar:arrow-right-up-linear" width="14"></iconify-icon>
                </a>
            </div>
        </div>

        <!-- Right 2 Cols: Profile Edit Form & Password Form -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Update Profile Form -->
            <div class="portal-card rounded-3xl p-6 sm:p-7 space-y-5">
                <div class="text-xs font-mono font-bold uppercase tracking-wider text-slate-300 flex items-center gap-1.5">
                    <iconify-icon icon="solar:pen-bold" class="text-[#38bdf8]"></iconify-icon>
                    <span>Ubah Kontak & Alamat</span>
                </div>

                <form action="{{ route('portal.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-400 mb-1.5">
                            Nomor Telepon / WhatsApp (ID Login)
                        </label>
                        <input 
                            type="text" 
                            disabled 
                            value="{{ $customer->phone }}" 
                            class="w-full px-4 py-3 rounded-2xl bg-white/[0.03] border border-white/10 text-slate-400 text-sm font-mono cursor-not-allowed"
                        >
                        <div class="text-[10px] text-slate-500 mt-1">Untuk pergantian nomor WhatsApp utama, hubungi Customer Service PT MSN.</div>
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                            Alamat Email (E-Billing)
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $customer->email) }}" 
                            placeholder="nama@email.com"
                            class="w-full px-4 py-3 rounded-2xl bg-white/[0.06] border border-white/15 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-[#38bdf8] transition-all"
                        >
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                            Alamat Pemasangan
                        </label>
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="2"
                            class="w-full px-4 py-3 rounded-2xl bg-white/[0.06] border border-white/15 text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#38bdf8] transition-all resize-none"
                        >{{ old('address', $customer->address) }}</textarea>
                    </div>

                    <!-- Change PIN Section -->
                    <div class="pt-4 border-t border-white/10 space-y-4">
                        <div class="text-xs font-mono font-bold uppercase tracking-wider text-slate-300 flex items-center gap-1.5">
                            <iconify-icon icon="solar:lock-password-bold" class="text-amber-400"></iconify-icon>
                            <span>Ganti PIN / Kata Sandi (Opsional)</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="current_password" class="block text-xs font-mono text-slate-400 mb-1">
                                    PIN Saat Ini
                                </label>
                                <input 
                                    type="password" 
                                    id="current_password" 
                                    name="current_password" 
                                    placeholder="••••••"
                                    class="w-full px-4 py-2.5 rounded-xl bg-white/[0.06] border border-white/15 text-white text-xs focus:outline-none focus:ring-1 focus:ring-[#38bdf8]"
                                >
                            </div>

                            <div>
                                <label for="new_password" class="block text-xs font-mono text-slate-400 mb-1">
                                    PIN Baru (Min 6 digit)
                                </label>
                                <input 
                                    type="password" 
                                    id="new_password" 
                                    name="new_password" 
                                    placeholder="••••••"
                                    class="w-full px-4 py-2.5 rounded-xl bg-white/[0.06] border border-white/15 text-white text-xs focus:outline-none focus:ring-1 focus:ring-[#38bdf8]"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="new_password_confirmation" class="block text-xs font-mono text-slate-400 mb-1">
                                Konfirmasi PIN Baru
                            </label>
                            <input 
                                type="password" 
                                id="new_password_confirmation" 
                                name="new_password_confirmation" 
                                placeholder="••••••"
                                class="w-full px-4 py-2.5 rounded-xl bg-white/[0.06] border border-white/15 text-white text-xs focus:outline-none focus:ring-1 focus:ring-[#38bdf8]"
                            >
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button 
                            type="submit" 
                            class="px-6 py-3 rounded-2xl bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-extrabold text-xs sm:text-sm transition-all duration-200 shadow-md flex items-center gap-2 cursor-pointer"
                        >
                            <iconify-icon icon="solar:check-circle-bold" width="16"></iconify-icon>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>

</div>
@endsection
