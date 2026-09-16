@extends('portal.layouts.app')

@section('title', 'Profil & Layanan Pelanggan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <div class="inline-flex items-center gap-1.5 text-xs font-mono font-bold text-sky-700 uppercase tracking-wider mb-1">
            <iconify-icon icon="solar:user-circle-bold"></iconify-icon>
            <span>INFORMASI AKUN</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">Profil & Paket Langganan</h1>
        <p class="text-xs sm:text-sm text-slate-600">Kelola data kontak dan informasi langganan internet Anda di PT MSN</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 1 Col: Subscription Info Card -->
        <div class="space-y-4">
            <div class="portal-card rounded-3xl p-6 space-y-4">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 text-white flex items-center justify-center font-heading font-extrabold text-lg shadow-md shadow-sky-500/20">
                        {{ substr($customer->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-sm font-heading font-bold text-slate-900">{{ $customer->name }}</div>
                        <div class="text-xs font-mono text-sky-600 font-semibold">ID: {{ $customer->customer_id }}</div>
                    </div>
                </div>

                <div class="space-y-3 text-xs text-slate-600">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Paket Internet:</span>
                        <span class="text-slate-900 font-bold text-sm">{{ $customer->package->name ?? 'Broadband' }}</span>
                        <span class="text-sky-600 font-mono text-xs block font-semibold">Speed: {{ $customer->package->speed ?? '25 Mbps' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Tarif Bulanan:</span>
                        <span class="text-slate-900 font-bold">Rp {{ number_format($customer->billing_amount, 0, ',', '.') }} / bln</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Tanggal Jatuh Tempo:</span>
                        <span class="text-slate-700">Setiap tanggal {{ $customer->due_date }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Alamat IP Pelanggan:</span>
                        <span class="text-sky-600 font-mono font-bold">{{ $customer->ip_address ?? '10.20.104.22' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Status Akun:</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-semibold text-[11px] mt-1 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Aktif & Terhubung
                        </span>
                    </div>
                </div>
            </div>

            <!-- Upgrade Package Notice -->
            <div class="portal-card rounded-3xl p-5 bg-gradient-to-br from-sky-50 to-blue-50/70 border-sky-200 space-y-2 text-xs">
                <div class="font-heading font-bold text-slate-900 flex items-center gap-1.5 text-sky-800">
                    <iconify-icon icon="solar:bolt-bold" class="text-amber-500 text-base"></iconify-icon>
                    <span>Ingin Upgrade Kecepatan?</span>
                </div>
                <p class="text-[11px] text-slate-600 leading-relaxed">
                    Tingkatkan kecepatan internet hingga 100 Mbps tanpa biaya penarikan ulang kabel fiber.
                </p>
                <a href="https://wa.me/6281214878436?text=Halo%20Admin,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20ingin%20upgrade%20paket" target="_blank" class="w-full py-2.5 px-3 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white font-heading font-bold text-xs transition-all flex items-center justify-center gap-1 mt-2 shadow-sm">
                    <span>Chat Admin Upgrade</span>
                    <iconify-icon icon="solar:arrow-right-up-linear" width="14"></iconify-icon>
                </a>
            </div>
        </div>

        <!-- Right 2 Cols: Profile Edit Form & Password Form -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Update Profile Form -->
            <div class="portal-card rounded-3xl p-6 sm:p-7 space-y-5">
                <div class="text-xs font-mono font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                    <iconify-icon icon="solar:pen-bold" class="text-sky-600"></iconify-icon>
                    <span>Ubah Kontak & Alamat</span>
                </div>

                <form action="{{ route('portal.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Nomor Telepon / WhatsApp (ID Login)
                        </label>
                        <input 
                            type="text" 
                            disabled 
                            value="{{ $customer->phone }}" 
                            class="w-full px-4 py-3 rounded-2xl bg-slate-100 border border-slate-200 text-slate-500 text-sm font-mono cursor-not-allowed"
                        >
                        <div class="text-[10px] text-slate-400 mt-1">Untuk pergantian nomor WhatsApp utama, hubungi Customer Service PT MSN.</div>
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alamat Email (E-Billing)
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $customer->email) }}" 
                            placeholder="nama@email.com"
                            class="w-full px-4 py-3 rounded-2xl bg-white/80 border border-slate-300 text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alamat Pemasangan
                        </label>
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="2"
                            class="w-full px-4 py-3 rounded-2xl bg-white/80 border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all resize-none shadow-sm"
                        >{{ old('address', $customer->address) }}</textarea>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button 
                            type="submit" 
                            class="px-6 py-3 rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-xs sm:text-sm transition-all duration-200 shadow-md flex items-center gap-2 cursor-pointer"
                        >
                            <iconify-icon icon="solar:check-circle-bold" width="16"></iconify-icon>
                            <span>Simpan Perubahan Kontak</span>
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>

</div>
@endsection

