@extends('portal.layouts.app')

@section('title', 'Tagihan & Pembayaran')

@section('content')
<div class="relative" x-data="{ 
    paymentTab: 'midtrans', 
    showTransferModal: false, 
    modalInvoiceCode: '', 
    modalInvoiceAmount: '', 
    modalInvoiceNumber: '',
    modalPeriod: '',
    filePreview: null,
    modalFilePreview: null
}">

    <!-- Full-Width Dark Oceanic Blue Hero Backdrop (Extends down behind the top of invoice card) -->
    <div class="-mx-3 sm:-mx-6 lg:-mx-8 -mt-3 sm:-mt-6 px-4 sm:px-6 lg:px-8 pt-5 sm:pt-7 pb-20 sm:pb-24 hero-network-card !rounded-none !border-x-0 !border-t-0 shadow-md relative overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-3 relative z-10">
            <div class="space-y-1">
                <div class="flex items-center gap-1.5 text-[11px] font-mono text-cyan-300 font-medium">
                    <a href="{{ route('portal.dashboard') }}" class="hover:text-white transition-colors">Portal</a>
                    <span class="text-cyan-400/60">/</span>
                    <span class="text-cyan-300 font-bold">Tagihan</span>
                </div>
                <h1 class="text-lg sm:text-2xl font-heading font-extrabold text-white tracking-tight">
                    Tagihan & Pembayaran
                </h1>
                <p class="text-xs text-slate-300">Rincian invoice, riwayat transaksi, dan pilihan pembayaran online atau transfer bank.</p>
            </div>

            <!-- ID Pelanggan Pill -->
            <button 
                type="button" 
                onclick="copyToClipboard('{{ $customer->customer_id }}', 'ID Pelanggan {{ $customer->customer_id }}')"
                class="copy-btn px-3 py-1.5 rounded-xl bg-slate-800/90 hover:bg-slate-700/90 border border-slate-700/90 hover:border-cyan-400 text-cyan-300 flex items-center gap-1.5 shrink-0 transition-all cursor-pointer shadow-2xs self-start sm:self-center"
                title="Klik untuk menyalin ID"
            >
                <iconify-icon icon="solar:hashtag-bold" class="text-cyan-400 text-xs"></iconify-icon>
                <span class="text-xs font-mono font-bold">{{ $customer->customer_id }}</span>
                <iconify-icon icon="solar:copy-linear" class="text-slate-400 text-[11px]"></iconify-icon>
            </button>
        </div>
    </div>

    <!-- Main Content Container Overlapping the Blue Backdrop -->
    <div class="-mt-14 sm:-mt-16 relative z-10 space-y-3.5 sm:space-y-5">

    <!-- Quick Action Banner for WA Confirmation -->
    @if(session('wa_confirm_url'))
        <div class="p-3 sm:p-3.5 rounded-2xl bg-emerald-50 border border-emerald-300/80 text-emerald-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-sm">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <iconify-icon icon="solar:check-circle-bold" class="text-lg"></iconify-icon>
                </div>
                <div class="text-xs">
                    <span class="font-bold text-xs sm:text-sm block text-emerald-950">Bukti Transfer Berhasil Dikirim!</span>
                    <span class="text-emerald-800 text-[11px]">Ingin konfirmasi instan? Hubungi Tim Billing PT MSN via WhatsApp.</span>
                </div>
            </div>
            <a href="{{ session('wa_confirm_url') }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs shadow-md shadow-emerald-600/20 transition-all active:scale-95 shrink-0 text-center">
                <iconify-icon icon="solar:chat-round-dots-bold" class="text-sm"></iconify-icon>
                <span>Buka WhatsApp Billing</span>
            </a>
        </div>
    @endif

    @if(isset($unpaidInvoices) && $unpaidInvoices->count() > 1)
        <!-- Warning Banner: Multi-Month Unpaid Invoices (FIFO Sequential Order Notice) -->
        <div class="p-3.5 sm:p-4 rounded-2xl bg-amber-50/95 border border-amber-300 text-amber-950 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <iconify-icon icon="solar:danger-triangle-bold" class="text-xl"></iconify-icon>
                </div>
                <div class="text-xs">
                    <span class="font-bold text-xs sm:text-sm block text-amber-950">
                        Anda memiliki {{ $unpaidInvoices->count() }} tagihan yang belum lunas
                    </span>
                    <span class="text-amber-800 text-[11px]">
                        Pembayaran harus diselesaikan secara berurutan mulai dari tagihan tertua (<strong>Periode: {{ $oldestUnpaidInvoice->period }}</strong>).
                    </span>
                </div>
            </div>
            <span class="px-3 py-1.5 rounded-xl bg-amber-100 text-amber-900 border border-amber-300/80 font-mono font-bold text-xs shrink-0 text-center">
                Tunggakan: {{ $unpaidInvoices->count() }} Bulan
            </span>
        </div>
    @endif

    <!-- Active Invoice Card -->
    <div id="tour-step-invoice-card" class="portal-card rounded-2xl sm:rounded-3xl p-4 sm:p-5 lg:p-6 relative overflow-hidden space-y-3.5 sm:space-y-4">
        
        <!-- Header Strip: No Invoice, Periode & Status -->
        <div id="tour-step-invoice-header" class="flex items-center justify-between gap-2 pb-3 border-b border-slate-200/80 flex-wrap">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="px-2.5 py-0.5 rounded-lg bg-sky-50 border border-sky-200/80 font-mono text-xs font-bold text-sky-700">
                    #{{ $currentInvoice->invoice_number }}
                </span>
                <span class="px-2.5 py-0.5 rounded-lg bg-slate-100 border border-slate-200 text-xs font-heading font-semibold text-slate-700">
                    Periode: <strong class="text-slate-900 font-bold">{{ $currentInvoice->period }}</strong>
                </span>
            </div>

            <div class="shrink-0 flex items-center gap-2">
                @if($currentInvoice->is_paid)
                    <span class="badge-paid">
                        <iconify-icon icon="solar:check-circle-bold" class="text-sm"></iconify-icon>
                        <span>LUNAS</span>
                    </span>
                @else
                    @php
                        $activeConf = $confirmations->get($currentInvoice->kode_billing_layanan);
                    @endphp
                    @if($activeConf && $activeConf->status === 'pending')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-heading font-bold bg-amber-50 text-amber-800 border border-amber-300">
                            <iconify-icon icon="solar:clock-circle-bold" class="text-amber-600 text-xs"></iconify-icon>
                            <span>MENUNGGU VERIFIKASI</span>
                        </span>
                    @else
                        <span class="badge-unpaid">
                            <iconify-icon icon="solar:danger-triangle-bold" class="text-sm"></iconify-icon>
                            <span>BELUM DIBAYAR</span>
                        </span>
                    @endif
                @endif
            </div>
        </div>

        <!-- Body Grid: Package & Service Details (Left 5 Cols) vs Payment Section (Right 7 Cols) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3.5 sm:gap-5 items-start">
            
            <!-- Left Info: Package & Subscriber Details (5 Cols) -->
            <div id="tour-step-billing-detail" class="lg:col-span-5 space-y-3">
                <div>
                    <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-slate-400">Layanan Berlangganan</span>
                    <h2 class="text-base sm:text-lg font-heading font-extrabold text-slate-900 leading-snug mt-0.5">
                        {{ $currentInvoice->package_name }}
                    </h2>
                    <div class="flex items-center gap-1.5 text-xs text-sky-600 font-medium mt-0.5">
                        <iconify-icon icon="solar:bolt-circle-bold" class="text-sm shrink-0"></iconify-icon>
                        <span>Kecepatan Simetris Fiber Optic Unlimited</span>
                    </div>
                </div>

                <!-- Detail Meta Box -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-3 rounded-xl bg-slate-50/80 border border-slate-200/80 text-xs">
                    <div class="space-y-0.5">
                        <span class="text-slate-400 text-[10px] block">Jatuh Tempo:</span>
                        <span class="font-mono font-bold text-xs {{ $currentInvoice->is_paid ? 'text-slate-700' : 'text-rose-600' }}">
                            {{ $currentInvoice->due_date?->translatedFormat('d F Y') ?? 'Tgl ' . $customer->due_date . ' / bln' }}
                        </span>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-slate-400 text-[10px] block">Nama Pelanggan:</span>
                        <span class="font-heading font-semibold text-slate-800 text-xs truncate block">{{ $customer->name }}</span>
                    </div>
                    <div class="sm:col-span-2 space-y-0.5 pt-1.5 border-t border-slate-200/60">
                        <span class="text-slate-400 text-[10px] block">Alamat Pemasangan:</span>
                        <span class="text-slate-700 text-[11px] leading-relaxed block">{{ $customer->address ?: '-' }}</span>
                    </div>
                </div>

                <!-- Price Breakdown Box -->
                @php
                    $prorate = $currentInvoice->prorate_info ?? ['is_prorate' => false];
                @endphp
                <div class="p-3 sm:p-3.5 rounded-xl bg-white border border-slate-200/90 shadow-2xs space-y-2">
                    <div class="text-[10px] font-mono uppercase text-slate-400 font-bold tracking-wider pb-1 border-b border-slate-100 flex items-center justify-between">
                        <span>Rincian Tagihan</span>
                        @if(!empty($prorate['is_prorate']))
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-amber-700 font-sans text-[10px] font-bold">
                                <iconify-icon icon="solar:bolt-circle-bold" class="text-amber-500 text-xs"></iconify-icon>
                                <span>Prorate {{ $prorate['days_active'] }} Hari</span>
                            </span>
                        @else
                            <span class="text-sky-600 font-mono text-[10px] font-bold">1 Bulan</span>
                        @endif
                    </div>

                    <div class="space-y-1 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Paket Normal</span>
                            <span class="font-mono font-semibold text-slate-800">{{ $prorate['formatted_base'] ?? $currentInvoice->formatted_amount }}</span>
                        </div>

                        @if(!empty($prorate['is_prorate']))
                            <div class="flex justify-between text-rose-600 font-medium">
                                <span>Potongan Masa Suspend ({{ $prorate['days_suspended'] }} Hari)</span>
                                <span class="font-mono font-semibold">- {{ $prorate['formatted_discount'] }}</span>
                            </div>

                            <div class="p-2 rounded-lg bg-amber-50/80 border border-amber-200/70 text-[11px] text-amber-900 space-y-0.5">
                                <div class="font-bold flex items-center gap-1 text-[11px]">
                                    <iconify-icon icon="solar:info-circle-bold" class="text-amber-600 text-xs shrink-0"></iconify-icon>
                                    <span>Penyesuaian Hari Aktif Suspend</span>
                                </div>
                                <p class="text-[10.5px] text-amber-800/90 leading-tight">
                                    Tagihan dihitung proporsional untuk <strong>{{ $prorate['days_active'] }} hari sisa</strong> di bulan ini.
                                </p>
                            </div>
                        @endif

                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Admin & Pajak</span>
                            <span class="font-mono font-semibold text-emerald-600">Termasuk (Rp 0)</span>
                        </div>
                        <div class="pt-1.5 border-t border-slate-100 flex justify-between items-baseline">
                            <span class="font-heading font-bold text-slate-800 text-xs">Total yang Harus Dibayar:</span>
                            <span class="font-heading font-black text-lg sm:text-xl text-sky-600 tracking-tight">
                                {{ $currentInvoice->formatted_total }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Info: Payment Methods & Actions (7 Cols) -->
            <div class="lg:col-span-7 space-y-3">
                
                <!-- Payment Methods Card -->
                <div class="p-3.5 sm:p-4 lg:p-4.5 rounded-xl sm:rounded-2xl bg-white border border-slate-200/90 shadow-2xs space-y-3">
                    
                    @php
                        $activeConf = $confirmations->get($currentInvoice->kode_billing_layanan);
                        $isPendingVerification = ($activeConf && $activeConf->status === 'pending');
                    @endphp

                    @if($currentInvoice->is_paid)
                        <!-- Lunas Box -->
                        <div id="tour-step-billing-status" class="p-4 sm:p-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-center space-y-1.5">
                            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center mx-auto shadow-sm shadow-emerald-500/20">
                                <iconify-icon icon="solar:check-circle-bold" class="text-xl"></iconify-icon>
                            </div>
                            <h3 class="text-sm font-heading font-extrabold text-emerald-900">Tagihan Telah Lunas</h3>
                            <p class="text-xs text-emerald-700 leading-relaxed max-w-sm mx-auto">
                                Terima kasih! Pembayaran tagihan periode ini telah terkonfirmasi. Layanan internet aktif lancar tanpa kendala.
                            </p>
                        </div>
                    @elseif($isPendingVerification)
                        <!-- Menunggu Verifikasi Box -->
                        <div id="tour-step-billing-status" class="p-4 sm:p-5 rounded-2xl bg-amber-50/90 border border-amber-300 text-center space-y-2">
                            <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center mx-auto shadow-sm shadow-amber-500/20">
                                <iconify-icon icon="solar:clock-circle-bold" class="text-2xl"></iconify-icon>
                            </div>
                            <h3 class="text-sm font-heading font-extrabold text-amber-950">Sedang Menunggu Verifikasi</h3>
                            <p class="text-xs text-amber-800 leading-relaxed max-w-sm mx-auto">
                                Bukti pembayaran transfer Anda telah berhasil dikirim pada <strong>{{ $activeConf->created_at?->translatedFormat('d F Y, H:i') }} WIB</strong> dan sedang dalam proses verifikasi oleh Tim Finance/HRD PT MSN.
                            </p>
                            <div class="pt-1 flex items-center justify-center gap-2">
                                <a href="{{ $activeConf->proof_url }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-100 hover:bg-amber-200 border border-amber-300/80 text-amber-900 font-heading font-bold text-xs transition-colors">
                                    <iconify-icon icon="solar:eye-bold" class="text-xs"></iconify-icon>
                                    <span>Lihat Bukti yang Dikirim</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Card Header & Tab Selector -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between flex-wrap gap-1">
                                <span class="text-[10px] sm:text-[11px] font-mono uppercase font-bold text-slate-500 tracking-wider flex items-center gap-1.5">
                                    <iconify-icon icon="solar:card-2-bold" class="text-sky-600 text-sm"></iconify-icon>
                                    <span>PILIH CARA PEMBAYARAN</span>
                                </span>
                                <span class="text-[10px] font-heading text-slate-400">Pilih salah satu metode</span>
                            </div>

                            <!-- Tabs Switcher -->
                            <div class="grid grid-cols-2 gap-1.5 p-1 rounded-xl bg-slate-100/90 border border-slate-200/80">
                                <button 
                                    type="button" 
                                    @click="paymentTab = 'midtrans'"
                                    :class="paymentTab === 'midtrans' ? 'bg-sky-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60 font-semibold'"
                                    class="py-2 px-3 rounded-lg text-xs font-heading transition-all flex items-center justify-center gap-1.5 cursor-pointer whitespace-nowrap"
                                >
                                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L4 6.6V17.4L12 22L20 17.4V6.6L12 2Z" :fill="paymentTab === 'midtrans' ? 'white' : '#00AEFF'" :fill-opacity="paymentTab === 'midtrans' ? '0.25' : '0.15'"/>
                                        <path d="M12 3.8L18.8 7.7L12 11.6L5.2 7.7L12 3.8Z" :fill="paymentTab === 'midtrans' ? 'white' : '#00AEFF'"/>
                                        <path d="M5.2 9.2L11.2 12.6V19.8L5.2 16.4V9.2Z" :fill="paymentTab === 'midtrans' ? 'white' : '#0284C7'" :fill-opacity="paymentTab === 'midtrans' ? '0.8' : '1'"/>
                                        <path d="M12.8 12.6L18.8 9.2V16.4L12.8 19.8V12.6Z" :fill="paymentTab === 'midtrans' ? 'white' : '#0369A1'" :fill-opacity="paymentTab === 'midtrans' ? '0.95' : '1'"/>
                                    </svg>
                                    <span class="sm:hidden">Midtrans</span>
                                    <span class="hidden sm:inline">Otomatis (Midtrans)</span>
                                </button>
                                <button 
                                    type="button" 
                                    id="tour-step-transfer-tab"
                                    @click="paymentTab = 'transfer'"
                                    :class="paymentTab === 'transfer' ? 'bg-sky-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60 font-semibold'"
                                    class="py-2 px-3 rounded-lg text-xs font-heading transition-all flex items-center justify-center gap-1.5 cursor-pointer whitespace-nowrap"
                                >
                                    <svg class="w-3.5 h-3.5 shrink-0" :class="paymentTab === 'transfer' ? 'text-white' : 'text-slate-600'" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L2 7V9H22V7L12 2Z"/>
                                        <path d="M4 11H7V18H4V11Z"/>
                                        <path d="M10.5 11H13.5V18H10.5V11Z"/>
                                        <path d="M17 11H20V18H17V11Z"/>
                                        <path d="M2 20H22V22H2V20Z"/>
                                    </svg>
                                    <span>Transfer Bank</span>
                                </button>
                            </div>
                        </div>

                        <!-- Tab 1: Midtrans Payment -->
                        <div id="tour-step-midtrans-pay" x-show="paymentTab === 'midtrans'" x-transition:enter="transition ease-out duration-150" class="space-y-3">
                            <div class="p-3 rounded-xl bg-sky-50/70 border border-sky-100 text-xs space-y-1">
                                <div class="flex items-center gap-1.5 font-heading font-bold text-sky-950 text-xs">
                                    <iconify-icon icon="solar:shield-check-bold" class="text-sky-600 text-sm"></iconify-icon>
                                    <span>Verifikasi Otomatis 24 Jam</span>
                                </div>
                                <p class="text-slate-600 leading-relaxed text-[11px]">
                                    Pembayaran terverifikasi seketika via QRIS (Gopay, OVO, Dana, ShopeePay), Virtual Account Bank (BCA, Mandiri, BRI, BNI), atau Gerai Retail.
                                </p>
                            </div>

                            <button 
                                type="button" 
                                id="btnPayMain"
                                onclick="payWithMidtrans('{{ $currentInvoice->kode_billing_layanan }}', 'btnPayMain')"
                                class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white font-heading font-extrabold text-xs sm:text-sm shadow-md shadow-sky-500/20 active:scale-98 transition-all flex items-center justify-center gap-2 text-center disabled:opacity-60 cursor-pointer"
                            >
                                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L4 6.6V17.4L12 22L20 17.4V6.6L12 2Z" fill="white" fill-opacity="0.2"/>
                                    <path d="M12 3.8L18.8 7.7L12 11.6L5.2 7.7L12 3.8Z" fill="white"/>
                                    <path d="M5.2 9.2L11.2 12.6V19.8L5.2 16.4V9.2Z" fill="white" fill-opacity="0.8"/>
                                    <path d="M12.8 12.6L18.8 9.2V16.4L12.8 19.8V12.6Z" fill="white" fill-opacity="0.95"/>
                                </svg>
                                <span>Bayar Sekarang (Midtrans)</span>
                            </button>

                            <!-- Channel Logos (Balanced, uniform height and aligned) -->
                            <div class="pt-3.5 border-t border-slate-100 flex items-center justify-center gap-3 sm:gap-4.5 flex-wrap">
                                <div class="h-6 sm:h-7 w-12 sm:w-14 flex items-center justify-center">
                                    <img src="{{ asset('images/logo/qris.png') }}" alt="QRIS" class="max-h-5 sm:max-h-5.5 max-w-full object-contain transition-transform hover:scale-105" title="QRIS (Gopay, OVO, Dana, ShopeePay)" onerror="this.onerror=null; this.src='{{ asset('images/logo/qris.jpg') }}';">
                                </div>
                                <div class="h-6 sm:h-7 w-14 sm:w-16 flex items-center justify-center">
                                    <img src="{{ asset('images/logo/bca.png') }}" alt="BCA" class="max-h-5.5 sm:max-h-6 max-w-full object-contain transition-transform hover:scale-105" title="BCA Virtual Account" onerror="this.onerror=null; this.outerHTML='<span class=\'text-xs font-black text-blue-800 tracking-tight\'>BCA</span>';">
                                </div>
                                <div class="h-6 sm:h-7 w-14 sm:w-16 flex items-center justify-center">
                                    <img src="{{ asset('images/logo/mandiri.png') }}" alt="Mandiri" class="max-h-5.5 sm:max-h-6 max-w-full object-contain transition-transform hover:scale-105" title="Bank Mandiri Virtual Account" onerror="this.onerror=null; this.outerHTML='<span class=\'text-xs font-black text-sky-900 tracking-tight\'>MANDIRI</span>';">
                                </div>
                                <div class="h-6 sm:h-7 w-11 sm:w-13 flex items-center justify-center">
                                    <img src="{{ asset('images/logo/bri.png') }}" alt="BRI" class="max-h-5 sm:max-h-5.5 max-w-full object-contain transition-transform hover:scale-105" title="Bank BRI Virtual Account" onerror="this.onerror=null; this.outerHTML='<span class=\'text-xs font-black text-blue-900 tracking-tight\'>BRI</span>';">
                                </div>
                                <div class="h-6 sm:h-7 w-11 sm:w-13 flex items-center justify-center">
                                    <img src="{{ asset('images/logo/bni.png') }}" alt="BNI" class="max-h-5 sm:max-h-5.5 max-w-full object-contain transition-transform hover:scale-105" title="Bank BNI Virtual Account" onerror="this.onerror=null; this.outerHTML='<span class=\'text-xs font-black text-teal-800 tracking-tight\'>BNI</span>';">
                                </div>
                                <div class="h-6 sm:h-7 w-14 sm:w-16 flex items-center justify-center">
                                    <img src="{{ asset('images/logo/alfamart.png') }}" alt="Alfamart" class="max-h-4.5 sm:max-h-5 max-w-full object-contain transition-transform hover:scale-105" title="Gerai Alfamart Retail" onerror="this.onerror=null; this.outerHTML='<span class=\'text-xs font-black text-red-600 tracking-tight\'>ALFAMART</span>';">
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Manual Bank Transfer & Proof Upload -->
                        <div x-show="paymentTab === 'transfer'" x-transition:enter="transition ease-out duration-150" class="space-y-3" style="display: none;">
                            
                            <!-- Official Bank Accounts List (Realistic Debit/Credit Card UI) -->
                            <div class="space-y-2">
                                <div class="text-[10px] font-mono uppercase font-bold text-slate-500 flex items-center justify-between">
                                    <span class="flex items-center gap-1.5">
                                        <iconify-icon icon="solar:card-bold" class="text-sky-600 text-xs"></iconify-icon>
                                        <span>REKENING TUJUAN RESMI PT MSN</span>
                                    </span>
                                    <span class="text-sky-600 font-sans font-semibold text-[10px]">Klik salin untuk transfer</span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($bankAccounts as $bank)
                                        @php
                                            $bankKey = strtolower($bank['bank_name']);
                                            $bankLogo = null;
                                            $cardGradient = 'from-slate-900 via-slate-800 to-slate-900';
                                            $accentBorder = 'border-slate-700/80';

                                            if (str_contains($bankKey, 'bca')) {
                                                $bankLogo = 'bca.png';
                                                $cardGradient = 'from-[#081e3a] via-[#004282] to-[#00224d]';
                                                $accentBorder = 'border-sky-500/30';
                                            } elseif (str_contains($bankKey, 'mandiri')) {
                                                $bankLogo = 'mandiri.png';
                                                $cardGradient = 'from-[#0a1c2e] via-[#00315c] to-[#051321]';
                                                $accentBorder = 'border-amber-500/30';
                                            } elseif (str_contains($bankKey, 'bri')) {
                                                $bankLogo = 'bri.png';
                                                $cardGradient = 'from-[#031c36] via-[#004f98] to-[#021324]';
                                                $accentBorder = 'border-sky-400/30';
                                            } elseif (str_contains($bankKey, 'bni')) {
                                                $bankLogo = 'bni.png';
                                                $cardGradient = 'from-[#022329] via-[#005e6a] to-[#011417]';
                                                $accentBorder = 'border-teal-400/30';
                                            }

                                            $rawAcc = preg_replace('/\s+/', '', $bank['account_number']);
                                            $formattedAcc = trim(chunk_split($rawAcc, 4, ' '));
                                        @endphp
                                        
                                        <!-- Real ATM / Credit Card Design -->
                                        <div class="bank-atm-card bg-gradient-to-br {{ $cardGradient }} {{ $accentBorder }} border group">
                                            
                                            <!-- Glossy / Metallic Sheen Background Decor -->
                                            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                                            <div class="absolute -left-10 -bottom-10 w-28 h-28 bg-sky-400/10 rounded-full blur-xl pointer-events-none"></div>

                                            <!-- Top Row: EMV Chip & Bank Logo -->
                                            <div class="relative z-10 flex items-center justify-between gap-2">
                                                <!-- Realistic Gold Smart Chip -->
                                                <div class="bank-card-chip">
                                                    <div class="bank-card-chip-line"></div>
                                                    <div class="bank-card-chip-line"></div>
                                                    <div class="bank-card-chip-cross"></div>
                                                </div>

                                                <!-- Official Bank Logo Badge (Fixed Dimension for Perfect Uniformity) -->
                                                <div class="bank-card-badge">
                                                    @if($bankLogo)
                                                        <img src="{{ asset('images/logo/' . $bankLogo) }}" alt="{{ $bank['bank_name'] }}" class="{{ str_contains(strtolower($bankLogo), 'mandiri') ? 'logo-mandiri' : '' }}" onerror="this.onerror=null; this.outerHTML='<span class=\'text-[10px] font-mono font-black text-slate-800 uppercase tracking-wider\'>{{ $bank['bank_name'] }}</span>';">
                                                    @else
                                                        <span class="text-[10px] font-mono font-black text-slate-800 uppercase tracking-wider">{{ $bank['bank_name'] }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Middle Row: Spaced Card Account Number -->
                                            <div class="relative z-10 my-2 space-y-0.5">
                                                <div class="text-[8px] font-mono tracking-widest text-slate-300/80 uppercase font-semibold">Nomor Rekening Tujuan</div>
                                                <div class="font-mono font-black text-sm sm:text-base tracking-widest text-white drop-shadow-sm select-all">
                                                    {{ $formattedAcc }}
                                                </div>
                                            </div>

                                            <!-- Bottom Row: Cardholder Name & Quick Copy Button -->
                                            <div class="relative z-10 flex items-end justify-between gap-2 pt-1.5 border-t border-white/10">
                                                <div class="overflow-hidden pr-1">
                                                    <div class="text-[7px] font-mono uppercase tracking-wider text-slate-400">Atas Nama</div>
                                                    <div class="font-heading font-extrabold text-[11px] sm:text-xs text-slate-100 uppercase tracking-wide truncate">
                                                        {{ $bank['account_name'] }}
                                                    </div>
                                                </div>

                                                <button 
                                                    type="button" 
                                                    onclick="copyToClipboard('{{ $bank['account_number'] }}', 'No. Rekening {{ $bank['bank_name'] }}')"
                                                    class="copy-btn px-2.5 py-1 rounded-lg bg-white/15 hover:bg-white/30 border border-white/25 text-white text-[10px] font-heading font-bold flex items-center gap-1 shadow-2xs transition-all active:scale-95 shrink-0 cursor-pointer"
                                                    title="Salin No. Rekening"
                                                >
                                                    <iconify-icon icon="solar:copy-bold" class="text-[11px] text-sky-300"></iconify-icon>
                                                    <span>Salin</span>
                                                </button>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Upload Proof Form (Simplified: Bukti & Catatan Saja) -->
                            <form 
                                action="{{ route('portal.billing.transfer.confirm', urlencode($currentInvoice->kode_billing_layanan)) }}" 
                                method="POST" 
                                enctype="multipart/form-data" 
                                class="space-y-3 pt-2 border-t border-slate-100"
                                x-data="{ isSubmitting: false }"
                                @submit="if(isSubmitting) { $event.preventDefault(); return false; } isSubmitting = true;"
                            >
                                @csrf
                                <div class="text-xs font-heading font-bold text-slate-800 flex items-center gap-1.5">
                                    <iconify-icon icon="solar:upload-track-bold" class="text-emerald-600 text-sm"></iconify-icon>
                                    <span>Konfirmasi Bukti Transfer</span>
                                </div>

                                <!-- File Upload Box -->
                                <div>
                                    <label class="block text-slate-600 text-xs font-medium mb-1">Unggah Foto Resi / Bukti Struk (JPG, PNG, PDF max 5MB):</label>
                                    <div class="relative border border-dashed border-slate-300 hover:border-emerald-500 rounded-xl p-3 text-center bg-slate-50/60 hover:bg-emerald-50/20 transition-all cursor-pointer">
                                        <input 
                                            type="file" 
                                            name="proof_file" 
                                            accept="image/*,.pdf" 
                                            required 
                                            @change="filePreview = $event.target.files[0] ? $event.target.files[0].name : null"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        >
                                        <div class="flex flex-col items-center justify-center gap-0.5 pointer-events-none">
                                            <iconify-icon icon="solar:upload-line-duotone" class="text-2xl text-emerald-600"></iconify-icon>
                                            <div class="text-xs font-semibold text-slate-700">
                                                <span x-text="filePreview ? filePreview : 'Pilih Foto / Dokumen Bukti Transfer'"></span>
                                            </div>
                                            <p class="text-[10px] text-slate-400">Klik untuk mengambil foto struk / memilih file</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Catatan Opsional -->
                                <div>
                                    <label class="block text-slate-600 text-xs font-medium mb-1">Catatan Tambahan (Opsional):</label>
                                    <textarea name="notes" rows="2" placeholder="Contoh: Sudah ditransfer via BCA..." class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:bg-white focus:border-sky-500 text-xs resize-none"></textarea>
                                </div>

                                <!-- Submit Button with Loading State -->
                                <button 
                                    type="submit" 
                                    :disabled="isSubmitting"
                                    class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-heading font-extrabold text-xs sm:text-sm shadow-md shadow-emerald-500/20 active:scale-98 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed"
                                >
                                    <template x-if="!isSubmitting">
                                        <span class="inline-flex items-center gap-2">
                                            <iconify-icon icon="solar:plain-bold" class="text-sm"></iconify-icon>
                                            <span>Kirim Bukti Pembayaran</span>
                                        </span>
                                    </template>
                                    <template x-if="isSubmitting">
                                        <span class="inline-flex items-center gap-2">
                                            <iconify-icon icon="solar:spinner-line" class="animate-spin text-base"></iconify-icon>
                                            <span>Mengirim Bukti Pembayaran...</span>
                                        </span>
                                    </template>
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Dual Action Buttons: Cetak & WhatsApp Billing (Placed inside payment section) -->
                    @php
                        $waText = "Halo Tim Billing PT MSN,\nSaya ingin konfirmasi pembayaran tagihan internet:\n• ID Pelanggan: {$customer->customer_id}\n• No. Invoice: {$currentInvoice->invoice_number}\n• Nama: {$customer->name}\n• Total: {$currentInvoice->formatted_total}\n• Periode: {$currentInvoice->period}\n\nMohon dibantu proses pengecekan. Terima kasih!";
                        $waBillingUrl = "https://wa.me/" . ($billingWhatsapp ?: '6285188358385') . "?text=" . urlencode($waText);
                    @endphp

                    <div id="tour-step-billing-actions" class="pt-2.5 border-t border-slate-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <a 
                                href="{{ route('portal.billing.show', urlencode($currentInvoice->kode_billing_layanan)) }}" 
                                target="_blank"
                                class="py-2 px-3 rounded-xl bg-slate-50 hover:bg-sky-50 border border-slate-200 hover:border-sky-300 text-slate-700 hover:text-sky-700 font-heading font-semibold text-xs transition-all flex items-center justify-center gap-1.5 shadow-2xs text-center"
                            >
                                <iconify-icon icon="solar:printer-minimalistic-bold" class="text-slate-500 text-xs sm:text-sm"></iconify-icon>
                                <span>Cetak / Unduh Invoice</span>
                            </a>

                            <a 
                                href="{{ $waBillingUrl }}" 
                                target="_blank"
                                class="py-2 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-300/90 text-emerald-800 font-heading font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-2xs text-center"
                            >
                                <iconify-icon icon="logos:whatsapp-icon" class="text-sm sm:text-base"></iconify-icon>
                                <span>Chat WhatsApp Billing</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Riwayat Pembayaran & Tagihan -->
    <div class="portal-card rounded-2xl sm:rounded-3xl p-3.5 sm:p-5 space-y-3">
        <div id="tour-step-billing-history" class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                    <iconify-icon icon="solar:history-bold" class="text-sm sm:text-base"></iconify-icon>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-heading font-bold text-slate-900">
                        Riwayat Pembayaran & Tagihan
                    </h3>
                    <p class="text-[10px] sm:text-[11px] text-slate-500">
                        Daftar seluruh tagihan periode bulan berjalan dan bulan sebelumnya.
                    </p>
                </div>
            </div>
        </div>

        <!-- Mobile Card View (sm:hidden) -->
        <div class="sm:hidden space-y-2">
            @forelse($invoices as $inv)
                @php
                    $invConf = $confirmations->get($inv->kode_billing_layanan);
                    $isPending = ($invConf && $invConf->status === 'pending');
                    $isPayable = (!$inv->is_paid && !$isPending && $oldestUnpaidInvoice && $oldestUnpaidInvoice->kode_billing_layanan === $inv->kode_billing_layanan);
                @endphp
                <div class="p-3 rounded-xl bg-white border border-slate-200/80 shadow-2xs space-y-1.5">
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-mono text-xs font-bold text-slate-800">#{{ $inv->invoice_number }}</span>
                        @if($inv->is_paid)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                <span>LUNAS</span>
                            </span>
                        @elseif($isPending)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
                                <span>DIVERIFIKASI</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                <iconify-icon icon="solar:danger-triangle-bold"></iconify-icon>
                                <span>BELUM BAYAR</span>
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-100">
                        <div>
                            <div class="font-semibold text-slate-800 text-xs">{{ $inv->period }}</div>
                            <div class="text-[10px] text-slate-500">{{ $inv->package_name }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-mono font-bold text-sky-600 text-xs">{{ $inv->formatted_total }}</div>
                            <div class="text-[9px] text-slate-400 font-mono">Tempo: {{ $inv->due_date?->format('d/m/Y') }}</div>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100 space-y-1.5">
                        @if(!$inv->is_paid)
                            @if($isPayable)
                                <div class="grid grid-cols-2 gap-1.5">
                                    <button 
                                        type="button" 
                                        id="btnPayMobile-{{ $loop->index }}"
                                        onclick="payWithMidtrans('{{ $inv->kode_billing_layanan }}', 'btnPayMobile-{{ $loop->index }}')"
                                        class="w-full py-1.5 px-2 rounded-lg bg-sky-600 hover:bg-sky-700 text-white font-semibold text-[11px] flex items-center justify-center gap-1.5 shadow-2xs transition-all active:scale-95 cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 2L4 6.6V17.4L12 22L20 17.4V6.6L12 2Z" fill="white" fill-opacity="0.2"/>
                                            <path d="M12 3.8L18.8 7.7L12 11.6L5.2 7.7L12 3.8Z" fill="white"/>
                                            <path d="M5.2 9.2L11.2 12.6V19.8L5.2 16.4V9.2Z" fill="white" fill-opacity="0.8"/>
                                            <path d="M12.8 12.6L18.8 9.2V16.4L12.8 19.8V12.6Z" fill="white" fill-opacity="0.95"/>
                                        </svg>
                                        <span>Midtrans</span>
                                    </button>
                                    <button 
                                        type="button" 
                                        @click="modalInvoiceCode = '{{ $inv->kode_billing_layanan }}'; modalInvoiceAmount = '{{ (int)$inv->total_layanan }}'; modalInvoiceNumber = '{{ $inv->invoice_number }}'; modalPeriod = '{{ $inv->period }}'; showTransferModal = true"
                                        class="w-full py-1.5 px-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-[11px] flex items-center justify-center gap-1.5 shadow-2xs transition-all active:scale-95 cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 2L2 7V9H22V7L12 2Z"/>
                                            <path d="M4 11H7V18H4V11Z"/>
                                            <path d="M10.5 11H13.5V18H10.5V11Z"/>
                                            <path d="M17 11H20V18H17V11Z"/>
                                            <path d="M2 20H22V22H2V20Z"/>
                                        </svg>
                                        <span>Transfer</span>
                                    </button>
                                </div>
                            @elseif($isPending)
                                <div class="text-center py-1 bg-amber-50 rounded-lg border border-amber-200/80">
                                    <span class="inline-flex items-center gap-1 text-[11px] text-amber-900 font-medium">
                                        <iconify-icon icon="solar:clock-circle-bold" class="text-amber-600"></iconify-icon>
                                        <span>Menunggu verifikasi bukti transfer</span>
                                    </span>
                                </div>
                            @else
                                <div class="text-right">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-slate-100 text-slate-400 font-medium text-[10px] border border-slate-200" title="Harap lunasi tagihan periode {{ $oldestUnpaidInvoice?->period }} terlebih dahulu">
                                        <iconify-icon icon="solar:lock-bold" width="11"></iconify-icon>
                                        <span>Terkunci (Bayar {{ $oldestUnpaidInvoice?->period }} Dulu)</span>
                                    </span>
                                </div>
                            @endif
                        @endif
                        <a 
                            href="{{ route('portal.billing.show', urlencode($inv->kode_billing_layanan)) }}" 
                            target="_blank"
                            class="w-full py-1.5 px-2 rounded-lg bg-slate-100 hover:bg-sky-50 text-slate-700 hover:text-sky-700 font-semibold text-[11px] flex items-center justify-center gap-1 border border-slate-200/70 transition-all"
                        >
                            <iconify-icon icon="solar:document-text-bold" width="12"></iconify-icon>
                            <span>Lihat / Cetak Struk</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-4 text-center text-slate-400 text-xs">
                    Belum ada riwayat tagihan.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (hidden sm:block) -->
        <div class="hidden sm:block overflow-x-auto rounded-xl border border-slate-200/80 bg-white/70">
            <table class="w-full text-left text-xs table-auto">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/80 text-[10px] sm:text-[11px] font-mono font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-2.5 px-3.5 whitespace-nowrap min-w-[150px]">No. Invoice</th>
                        <th class="py-2.5 px-3.5 whitespace-nowrap min-w-[100px]">Periode</th>
                        <th class="py-2.5 px-3.5 whitespace-nowrap min-w-[160px]">Paket Layanan</th>
                        <th class="py-2.5 px-3.5 whitespace-nowrap min-w-[100px]">Jatuh Tempo</th>
                        <th class="py-2.5 px-3.5 text-right whitespace-nowrap min-w-[110px]">Total</th>
                        <th class="py-2.5 px-3.5 text-center whitespace-nowrap min-w-[110px]">Status</th>
                        <th class="py-2.5 px-3.5 text-center whitespace-nowrap min-w-[180px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-sans">
                    @forelse($invoices as $inv)
                        @php
                            $invConf = $confirmations->get($inv->kode_billing_layanan);
                            $isPending = ($invConf && $invConf->status === 'pending');
                            $isPayable = (!$inv->is_paid && !$isPending && $oldestUnpaidInvoice && $oldestUnpaidInvoice->kode_billing_layanan === $inv->kode_billing_layanan);
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-2.5 px-3.5 font-mono font-bold text-slate-800 whitespace-nowrap">
                                #{{ $inv->invoice_number }}
                            </td>
                            <td class="py-2.5 px-3.5 font-semibold text-slate-700 whitespace-nowrap">
                                {{ $inv->period }}
                            </td>
                            <td class="py-2.5 px-3.5 text-slate-600 text-xs whitespace-nowrap">
                                {{ $inv->package_name }}
                            </td>
                            <td class="py-2.5 px-3.5 font-mono text-xs text-slate-500 whitespace-nowrap">
                                {{ $inv->due_date?->format('d/m/Y') }}
                            </td>
                            <td class="py-2.5 px-3.5 text-right font-mono font-bold text-sky-600 whitespace-nowrap">
                                {{ $inv->formatted_total }}
                            </td>
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                @if($inv->is_paid)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                        <span>LUNAS</span>
                                    </span>
                                @elseif($isPending)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
                                        <span>DIVERIFIKASI</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <iconify-icon icon="solar:danger-triangle-bold"></iconify-icon>
                                        <span>BELUM BAYAR</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex flex-col items-center justify-center gap-1.5">
                                    @if(!$inv->is_paid)
                                        @if($isPayable)
                                            <div class="inline-flex items-center gap-1.5">
                                                <button 
                                                    type="button" 
                                                    id="btnPayHist-{{ $loop->index }}"
                                                    onclick="payWithMidtrans('{{ $inv->kode_billing_layanan }}', 'btnPayHist-{{ $loop->index }}')"
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-sky-600 hover:bg-sky-700 text-white font-semibold text-xs shadow-2xs transition-all disabled:opacity-60 cursor-pointer whitespace-nowrap"
                                                    title="Bayar tagihan ini via Midtrans"
                                                >
                                                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12 2L4 6.6V17.4L12 22L20 17.4V6.6L12 2Z" fill="white" fill-opacity="0.2"/>
                                                        <path d="M12 3.8L18.8 7.7L12 11.6L5.2 7.7L12 3.8Z" fill="white"/>
                                                        <path d="M5.2 9.2L11.2 12.6V19.8L5.2 16.4V9.2Z" fill="white" fill-opacity="0.8"/>
                                                        <path d="M12.8 12.6L18.8 9.2V16.4L12.8 19.8V12.6Z" fill="white" fill-opacity="0.95"/>
                                                    </svg>
                                                    <span>Midtrans</span>
                                                </button>
                                                <button 
                                                    type="button" 
                                                    @click="modalInvoiceCode = '{{ $inv->kode_billing_layanan }}'; modalInvoiceAmount = '{{ (int)$inv->total_layanan }}'; modalInvoiceNumber = '{{ $inv->invoice_number }}'; modalPeriod = '{{ $inv->period }}'; showTransferModal = true"
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-2xs transition-all cursor-pointer whitespace-nowrap"
                                                    title="Upload bukti transfer untuk tagihan ini"
                                                >
                                                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12 2L2 7V9H22V7L12 2Z"/>
                                                        <path d="M4 11H7V18H4V11Z"/>
                                                        <path d="M10.5 11H13.5V18H10.5V11Z"/>
                                                        <path d="M17 11H20V18H17V11Z"/>
                                                        <path d="M2 20H22V22H2V20Z"/>
                                                    </svg>
                                                    <span>Transfer</span>
                                                </button>
                                            </div>
                                        @elseif($isPending)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-800 font-medium text-xs border border-amber-200">
                                                <iconify-icon icon="solar:clock-circle-bold" width="12" class="text-amber-600"></iconify-icon>
                                                <span>Verifikasi Bukti</span>
                                            </span>
                                        @else
                                            <div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-400 font-medium text-xs border border-slate-200" title="Harap lunasi tagihan periode {{ $oldestUnpaidInvoice?->period }} terlebih dahulu">
                                                    <iconify-icon icon="solar:lock-bold" width="12"></iconify-icon>
                                                    <span>Terkunci</span>
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                    <a 
                                        href="{{ route('portal.billing.show', urlencode($inv->kode_billing_layanan)) }}" 
                                        target="_blank"
                                        class="inline-flex items-center justify-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-sky-50 text-slate-700 hover:text-sky-700 transition-colors font-semibold text-xs border border-slate-200/80 whitespace-nowrap {{ !$inv->is_paid && $isPayable ? 'w-full' : '' }}"
                                        title="Cetak struk resmi"
                                    >
                                        <iconify-icon icon="solar:document-text-bold" width="12"></iconify-icon>
                                        <span>Struk</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-slate-400">
                                <iconify-icon icon="solar:inbox-line" width="30" class="mx-auto mb-1.5 opacity-60"></iconify-icon>
                                <p>Belum ada riwayat tagihan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- Modal Upload Bukti Transfer untuk Invoice Riwayat -->
    <div 
        x-show="showTransferModal" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4 py-6 sm:py-8"
        style="display: none;"
    >
        <div 
            @click.outside="showTransferModal = false"
            class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-200 max-w-lg w-full p-4 sm:p-5 space-y-3 max-h-[calc(100dvh-4.5rem)] overflow-y-auto my-auto"
        >
            <!-- Header Modal -->
            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-600 flex items-center justify-center shrink-0 shadow-2xs">
                        <iconify-icon icon="solar:upload-track-bold" class="text-lg"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-sm font-heading font-extrabold text-slate-900 leading-tight">Upload Bukti Transfer Bank</h3>
                        <p class="text-[11px] text-slate-500">Invoice: <span class="font-mono font-bold text-sky-600" x-text="'#' + modalInvoiceNumber"></span></p>
                    </div>
                </div>
                <button 
                    type="button"
                    @click="showTransferModal = false" 
                    class="text-slate-400 hover:text-slate-700 hover:bg-slate-100 p-1.5 rounded-xl transition-colors cursor-pointer"
                    title="Tutup Modal"
                >
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>

            <!-- Rekening Resmi PT MSN (Compact Strip View) -->
            <div class="space-y-1.5">
                <div class="text-[10px] font-mono uppercase font-bold text-slate-400 tracking-wider flex items-center justify-between">
                    <span>Rekening Resmi Tujuan:</span>
                    <span class="text-sky-600 font-sans font-semibold text-[10px]">Klik salin nomor</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                    @foreach($bankAccounts as $bank)
                        @php
                            $mBankKey = strtolower($bank['bank_name']);
                            $mBankLogo = null;
                            $mCardGradient = 'from-slate-900 via-slate-800 to-slate-900';
                            $mAccentBorder = 'border-slate-700/80';

                            if (str_contains($mBankKey, 'bca')) {
                                $mBankLogo = 'bca.png';
                                $mCardGradient = 'from-[#081e3a] to-[#00224d]';
                                $mAccentBorder = 'border-sky-500/40';
                            } elseif (str_contains($mBankKey, 'mandiri')) {
                                $mBankLogo = 'mandiri.png';
                                $mCardGradient = 'from-[#0a1c2e] to-[#051321]';
                                $mAccentBorder = 'border-amber-500/40';
                            } elseif (str_contains($mBankKey, 'bri')) {
                                $mBankLogo = 'bri.png';
                                $mCardGradient = 'from-[#031c36] to-[#021324]';
                                $mAccentBorder = 'border-sky-400/40';
                            } elseif (str_contains($mBankKey, 'bni')) {
                                $mBankLogo = 'bni.png';
                                $mCardGradient = 'from-[#022329] to-[#011417]';
                                $mAccentBorder = 'border-teal-400/40';
                            }

                            $mRawAcc = preg_replace('/\s+/', '', $bank['account_number']);
                            $mFormattedAcc = trim(chunk_split($mRawAcc, 4, ' '));
                        @endphp
                        <div class="p-2.5 rounded-xl bg-gradient-to-r {{ $mCardGradient }} {{ $mAccentBorder }} border text-white shadow-xs flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="bank-card-badge-sm shrink-0">
                                    @if($mBankLogo)
                                        <img src="{{ asset('images/logo/' . $mBankLogo) }}" alt="{{ $bank['bank_name'] }}" class="{{ str_contains(strtolower($mBankLogo), 'mandiri') ? 'logo-mandiri' : '' }}" onerror="this.onerror=null; this.outerHTML='<span class=\'text-[9px] font-mono font-black text-slate-800 uppercase\'>{{ $bank['bank_name'] }}</span>';">
                                    @else
                                        <span class="text-[9px] font-mono font-black text-slate-800 uppercase">{{ $bank['bank_name'] }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="font-mono font-black text-xs tracking-wider text-white truncate select-all">{{ $mFormattedAcc }}</div>
                                    <div class="text-[8.5px] text-slate-300 truncate">a.n. {{ $bank['account_name'] }}</div>
                                </div>
                            </div>
                            <button 
                                type="button" 
                                onclick="copyToClipboard('{{ $bank['account_number'] }}', 'No. Rekening {{ $bank['bank_name'] }}')" 
                                class="copy-btn text-sky-300 hover:text-white font-bold ml-1 shrink-0 px-2 py-1 rounded-lg bg-white/15 hover:bg-white/30 transition-all cursor-pointer flex items-center gap-1 text-[10px]"
                            >
                                <iconify-icon icon="solar:copy-bold" class="text-[11px]"></iconify-icon>
                                <span>Salin</span>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Upload Form -->
            <form 
                :action="`{{ url('/portal/tagihan') }}/${encodeURIComponent(modalInvoiceCode)}/transfer-confirm`" 
                method="POST" 
                enctype="multipart/form-data" 
                class="space-y-2.5 pt-0.5"
                x-data="{ isModalSubmitting: false }"
                @submit="if(isModalSubmitting) { $event.preventDefault(); return false; } isModalSubmitting = true;"
            >
                @csrf
                <!-- File Upload Box with Drag/Drop Look & Reactive File Preview -->
                <div>
                    <label class="block text-slate-700 text-xs font-heading font-semibold mb-1">
                        Unggah Foto Resi / Bukti Struk (JPG, PNG, PDF max 5MB):
                    </label>
                    <div class="relative border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-xl p-2.5 text-center bg-slate-50/70 hover:bg-emerald-50/20 transition-all cursor-pointer group">
                        <input 
                            type="file" 
                            name="proof_file" 
                            accept="image/*,.pdf" 
                            required 
                            @change="modalFilePreview = $event.target.files[0] ? $event.target.files[0].name : null"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                        >
                        <div class="flex flex-col items-center justify-center gap-1 pointer-events-none py-1">
                            <iconify-icon icon="solar:upload-line-duotone" class="text-2xl text-emerald-600 group-hover:scale-110 transition-transform"></iconify-icon>
                            <div class="text-xs font-semibold text-slate-800">
                                <span x-text="modalFilePreview ? modalFilePreview : 'Klik untuk memilih Foto / Dokumen Resi'"></span>
                            </div>
                            <p class="text-[10px] text-slate-400">Mendukung JPG, PNG, atau PDF (Maks 5MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Notes Textarea -->
                <div>
                    <label class="block text-slate-700 text-xs font-heading font-semibold mb-0.5">Catatan Tambahan (Opsional):</label>
                    <textarea name="notes" rows="1" placeholder="Contoh: Sudah transfer via BCA..." class="w-full px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-xs focus:bg-white focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition-all resize-none"></textarea>
                </div>

                <!-- Modal Action Buttons -->
                <div class="pt-2 flex items-center justify-end gap-2 border-t border-slate-100">
                    <button 
                        type="button" 
                        @click="showTransferModal = false" 
                        class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-semibold text-xs transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        :disabled="isModalSubmitting"
                        class="px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-heading font-extrabold text-xs shadow-md shadow-emerald-600/20 active:scale-95 transition-all cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed flex items-center gap-1.5"
                    >
                        <template x-if="!isModalSubmitting">
                            <span class="inline-flex items-center gap-1.5">
                                <iconify-icon icon="solar:plain-bold" class="text-sm"></iconify-icon>
                                <span>Kirim Bukti Pembayaran</span>
                            </span>
                        </template>
                        <template x-if="isModalSubmitting">
                            <span class="inline-flex items-center gap-1.5">
                                <iconify-icon icon="solar:spinner-line" class="animate-spin text-sm"></iconify-icon>
                                <span>Mengirim...</span>
                            </span>
                        </template>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    async function payWithMidtrans(kodeBilling, btnId = null) {
        let btn = null;
        let originalContent = '';
        if (btnId) {
            btn = document.getElementById(btnId);
            if (btn) {
                originalContent = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<iconify-icon icon="solar:spinner-line" class="animate-spin inline-block mr-1.5" width="16"></iconify-icon><span>Menghubungkan Pembayaran...</span>';
            }
        }

        const endpoint = `{{ route('portal.billing.pay.direct') }}`;

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    kode_billing: kodeBilling
                })
            });

            const data = await response.json();

            if (data.success && data.redirect_url) {
                // Arahkan langsung ke halaman checkout Midtrans resmi
                // 100% kompatibel di Desktop & HP, QRIS responsif, e-Wallet deep-link tanpa kendala iframe/cookie
                window.location.href = data.redirect_url;
                return;
            }

            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }

            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: data.message || 'Gagal membuat sesi pembayaran Midtrans. Silakan hubungi CS.',
                confirmButtonColor: '#0ea5e9'
            });
        } catch (err) {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }
            console.error('Midtrans Request Error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Gangguan Server',
                text: 'Terjadi kendala saat menghubungi server pembayaran. Silakan coba sesaat lagi.',
                confirmButtonColor: '#0ea5e9'
            });
        }
    }
</script>
@endpush
