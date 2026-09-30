@extends('portal.layouts.app')

@section('title', 'Tagihan & Pembayaran')

@section('content')
<div class="space-y-3.5 sm:space-y-6" x-data="{ 
    paymentTab: 'midtrans', 
    showTransferModal: false, 
    modalInvoiceCode: '', 
    modalInvoiceAmount: '', 
    modalInvoiceNumber: '',
    modalPeriod: '',
    filePreview: null 
}">

    <!-- Header Section -->
    <div class="flex items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-1.5 text-[11px] font-mono text-slate-500 mb-0.5">
                <a href="{{ route('portal.dashboard') }}" class="hover:text-sky-600 transition-colors">Portal</a>
                <span>/</span>
                <span class="text-sky-600 font-bold">Tagihan</span>
            </div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">
                Tagihan & Pembayaran
            </h1>
        </div>

        <!-- ID Pelanggan Pill -->
        <button 
            type="button" 
            onclick="copyToClipboard('{{ $customer->customer_id }}', 'ID Pelanggan {{ $customer->customer_id }}')"
            class="copy-btn px-3 py-1.5 rounded-xl bg-white/90 border border-slate-200/90 shadow-2xs hover:border-sky-400 flex items-center gap-1.5 shrink-0"
            title="Klik untuk menyalin ID"
        >
            <iconify-icon icon="solar:hashtag-bold" class="text-sky-500 text-xs"></iconify-icon>
            <span class="text-xs font-mono font-bold text-slate-800">{{ $customer->customer_id }}</span>
            <iconify-icon icon="solar:copy-linear" class="text-[11px] text-slate-400"></iconify-icon>
        </button>
    </div>

    <!-- Quick Action Banner for WA Confirmation -->
    @if(session('wa_confirm_url'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-300/80 text-emerald-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <iconify-icon icon="solar:check-circle-bold" class="text-xl"></iconify-icon>
                </div>
                <div class="text-xs">
                    <span class="font-bold text-sm block text-emerald-950">Bukti Transfer Berhasil Dikirim!</span>
                    <span class="text-emerald-800">Ingin konfirmasi instan? Klik tombol untuk membuka chat dengan Tim Billing PT MSN via WhatsApp.</span>
                </div>
            </div>
            <a href="{{ session('wa_confirm_url') }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs shadow-md shadow-emerald-600/20 transition-all active:scale-95 shrink-0 text-center">
                <iconify-icon icon="solar:chat-round-dots-bold" class="text-base"></iconify-icon>
                <span>Buka WhatsApp Billing</span>
            </a>
        </div>
    @endif

    <!-- Active Invoice Card -->
    <div class="portal-card rounded-2xl sm:rounded-3xl p-4 sm:p-7 relative overflow-hidden space-y-4 sm:space-y-6">
        
        <!-- Header Strip: No Invoice, Periode & Status -->
        <div class="flex items-center justify-between gap-2 pb-3 sm:pb-4 border-b border-slate-200/80 flex-wrap">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="px-2.5 py-1 rounded-lg bg-sky-50 border border-sky-200/80 font-mono text-xs font-bold text-sky-700">
                    #{{ $currentInvoice->invoice_number }}
                </span>
                <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-heading font-semibold text-slate-700">
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
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-heading font-bold bg-amber-50 text-amber-800 border border-amber-300">
                            <iconify-icon icon="solar:clock-circle-bold" class="text-amber-600 text-sm animate-pulse"></iconify-icon>
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

        <!-- Body Grid: Package & Service Details -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 items-start">
            
            <!-- Left Info: Package & Subscriber Details (6 Cols) -->
            <div class="lg:col-span-6 space-y-3.5">
                <div>
                    <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-400">Layanan Berlangganan</span>
                    <h2 class="text-base sm:text-xl font-heading font-extrabold text-slate-900 leading-snug mt-0.5">
                        {{ $currentInvoice->package_name }}
                    </h2>
                    <div class="flex items-center gap-1.5 text-xs text-sky-600 font-medium mt-1">
                        <iconify-icon icon="solar:bolt-circle-bold" class="text-sm shrink-0"></iconify-icon>
                        <span>Kecepatan Simetris Fiber Optic Unlimited</span>
                    </div>
                </div>

                <!-- Detail Meta Box -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/80 text-xs">
                    <div class="space-y-0.5">
                        <span class="text-slate-400 text-[11px] block">Jatuh Tempo:</span>
                        <span class="font-mono font-bold {{ $currentInvoice->is_paid ? 'text-slate-700' : 'text-rose-600' }}">
                            {{ $currentInvoice->due_date?->translatedFormat('d F Y') ?? 'Tgl ' . $customer->due_date . ' / bln' }}
                        </span>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-slate-400 text-[11px] block">Nama Pelanggan:</span>
                        <span class="font-heading font-semibold text-slate-800 truncate block">{{ $customer->name }}</span>
                    </div>
                    <div class="sm:col-span-2 space-y-0.5 pt-1.5 border-t border-slate-200/60">
                        <span class="text-slate-400 text-[11px] block">Alamat Pemasangan:</span>
                        <span class="text-slate-700 text-[11px] leading-relaxed block">{{ $customer->address ?: '-' }}</span>
                    </div>
                </div>

                <!-- Price Breakdown Box -->
                <div class="p-3.5 sm:p-4 rounded-2xl bg-white/90 border border-slate-200/90 shadow-2xs space-y-2">
                    <div class="text-[11px] font-mono uppercase text-slate-400 font-bold tracking-wider pb-1.5 border-b border-slate-100">
                        Rincian Tagihan
                    </div>

                    <div class="space-y-1.5 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Paket (1 Bulan)</span>
                            <span class="font-mono font-semibold text-slate-800">{{ $currentInvoice->formatted_amount }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Admin & Pajak</span>
                            <span class="font-mono font-semibold text-emerald-600">Termasuk (Rp 0)</span>
                        </div>
                        <div class="pt-2 border-t border-slate-100 flex justify-between items-baseline">
                            <span class="font-heading font-bold text-slate-800 text-xs sm:text-sm">Total Tagihan:</span>
                            <span class="font-heading font-black text-lg sm:text-2xl text-sky-600 tracking-tight">
                                {{ $currentInvoice->formatted_total }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Button: Print & Contact WA Billing -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1">
                    <a 
                        href="{{ route('portal.billing.show', urlencode($currentInvoice->kode_billing_layanan)) }}" 
                        target="_blank"
                        class="py-2.5 px-3 rounded-xl bg-slate-50 hover:bg-sky-50 border border-slate-200 hover:border-sky-300 text-slate-700 hover:text-sky-700 font-heading font-semibold text-xs transition-all flex items-center justify-center gap-1.5 shadow-2xs text-center"
                    >
                        <iconify-icon icon="solar:printer-minimalistic-bold" class="text-slate-500 text-sm"></iconify-icon>
                        <span>Cetak / Unduh Invoice</span>
                    </a>

                    @php
                        $waText = "Halo Tim Billing PT MSN,\nSaya ingin konfirmasi pembayaran tagihan internet:\n• ID Pelanggan: {$customer->customer_id}\n• No. Invoice: {$currentInvoice->invoice_number}\n• Nama: {$customer->name}\n• Total: {$currentInvoice->formatted_total}\n• Periode: {$currentInvoice->period}\n\nMohon dibantu proses pengecekan. Terima kasih!";
                        $waBillingUrl = "https://wa.me/" . ($billingWhatsapp ?: '6289696629955') . "?text=" . urlencode($waText);
                    @endphp

                    <a 
                        href="{{ $waBillingUrl }}" 
                        target="_blank"
                        class="py-2.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-800 font-heading font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-2xs text-center"
                    >
                        <iconify-icon icon="solar:chat-round-dots-bold" class="text-emerald-600 text-sm"></iconify-icon>
                        <span>Chat WhatsApp Billing</span>
                    </a>
                </div>

            </div>

            <!-- Right Info: Payment Methods & Actions (6 Cols) -->
            <div class="lg:col-span-6 space-y-3.5">
                
                @if(!$currentInvoice->is_paid)
                    <!-- Payment Methods Selector Card -->
                    <div class="p-3.5 sm:p-5 rounded-2xl sm:rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
                        
                        <!-- Tabs Header -->
                        <div>
                            <span class="text-[10px] font-mono uppercase font-bold text-slate-400 tracking-wider block mb-2">PILIH CARA PEMBAYARAN</span>
                            <div class="grid grid-cols-2 gap-1.5 p-1 rounded-2xl bg-slate-100/90 border border-slate-200/80">
                                <button 
                                    type="button" 
                                    @click="paymentTab = 'midtrans'"
                                    :class="paymentTab === 'midtrans' ? 'bg-white text-sky-700 shadow-xs font-extrabold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                                    class="py-2 px-2.5 rounded-xl text-xs font-heading transition-all flex items-center justify-center gap-1.5"
                                >
                                    <iconify-icon icon="solar:bolt-circle-bold" class="text-sm text-sky-500"></iconify-icon>
                                    <span>Otomatis (Midtrans)</span>
                                </button>
                                <button 
                                    type="button" 
                                    @click="paymentTab = 'transfer'"
                                    :class="paymentTab === 'transfer' ? 'bg-white text-sky-700 shadow-xs font-extrabold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                                    class="py-2 px-2.5 rounded-xl text-xs font-heading transition-all flex items-center justify-center gap-1.5"
                                >
                                    <iconify-icon icon="solar:card-recive-bold" class="text-sm text-emerald-500"></iconify-icon>
                                    <span>Transfer Bank</span>
                                </button>
                            </div>
                        </div>

                        <!-- Tab 1: Midtrans Payment -->
                        <div x-show="paymentTab === 'midtrans'" x-transition:enter="transition ease-out duration-150" class="space-y-3">
                            <div class="p-3.5 rounded-2xl bg-gradient-to-br from-sky-50 to-blue-50/50 border border-sky-100 text-xs space-y-2">
                                <div class="flex items-center gap-2 font-heading font-bold text-sky-900">
                                    <iconify-icon icon="solar:shield-check-bold" class="text-sky-600 text-base"></iconify-icon>
                                    <span>Verifikasi Otomatis 24 Jam</span>
                                </div>
                                <p class="text-slate-600 leading-relaxed text-[11px]">
                                    Bayar praktis melalui QRIS (Gopay, OVO, Dana, ShopeePay), Virtual Account Bank (BCA, Mandiri, BRI, BNI), atau Gerai Retail tanpa perlu konfirmasi manual.
                                </p>
                            </div>

                            <button 
                                type="button" 
                                id="btnPayMain"
                                onclick="payWithMidtrans('{{ $currentInvoice->kode_billing_layanan }}', 'btnPayMain')"
                                class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white font-heading font-extrabold text-sm shadow-md shadow-sky-500/20 active:scale-98 transition-all flex items-center justify-center gap-2 text-center disabled:opacity-60 cursor-pointer"
                            >
                                <iconify-icon icon="solar:card-recive-bold" class="text-lg"></iconify-icon>
                                <span>Bayar Sekarang (Midtrans)</span>
                            </button>

                            <!-- Channel Badges -->
                            <div class="pt-2 border-t border-slate-100 flex items-center gap-1.5 flex-wrap justify-center text-[10px] font-mono font-bold text-slate-600">
                                <span class="px-2 py-0.5 rounded-md bg-slate-50 border border-slate-200">QRIS</span>
                                <span class="px-2 py-0.5 rounded-md bg-slate-50 border border-slate-200">BCA VA</span>
                                <span class="px-2 py-0.5 rounded-md bg-slate-50 border border-slate-200">Mandiri VA</span>
                                <span class="px-2 py-0.5 rounded-md bg-slate-50 border border-slate-200">BRI VA</span>
                                <span class="px-2 py-0.5 rounded-md bg-slate-50 border border-slate-200">BNI VA</span>
                                <span class="px-2 py-0.5 rounded-md bg-slate-50 border border-slate-200">Alfamart</span>
                            </div>
                        </div>

                        <!-- Tab 2: Manual Bank Transfer & Proof Upload -->
                        <div x-show="paymentTab === 'transfer'" x-transition:enter="transition ease-out duration-150" class="space-y-4" style="display: none;">
                            
                            <!-- Official Bank Accounts List -->
                            <div class="space-y-2">
                                <div class="text-[11px] font-mono uppercase font-bold text-slate-500 flex items-center justify-between">
                                    <span>Rekening Tujuan PT MSN:</span>
                                    <span class="text-sky-600 font-sans font-semibold text-[10px]">Klik tombol untuk salin</span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($bankAccounts as $bank)
                                        <div class="p-3 rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 text-white shadow-xs space-y-1.5 relative overflow-hidden">
                                            <div class="flex items-center justify-between">
                                                <span class="px-2 py-0.5 rounded-md bg-white/20 text-[10px] font-mono font-extrabold uppercase tracking-wider text-sky-200">
                                                    {{ $bank['bank_name'] }}
                                                </span>
                                                <button 
                                                    type="button" 
                                                    onclick="copyToClipboard('{{ $bank['account_number'] }}', 'No. Rekening {{ $bank['bank_name'] }}')"
                                                    class="copy-btn text-[10px] font-heading font-semibold text-sky-300 hover:text-white flex items-center gap-1 bg-white/10 hover:bg-white/20 px-2 py-0.5 rounded-lg transition-all"
                                                    title="Salin No. Rekening"
                                                >
                                                    <iconify-icon icon="solar:copy-linear" class="text-xs"></iconify-icon>
                                                    <span>Salin</span>
                                                </button>
                                            </div>
                                            <div class="font-mono font-black text-sm tracking-wider text-white select-all">
                                                {{ $bank['account_number'] }}
                                            </div>
                                            <div class="text-[10px] text-slate-300 truncate">
                                                a.n. {{ $bank['account_name'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Existing Confirmation Status if Any -->
                            @if(isset($activeConf) && $activeConf)
                                <div class="p-3.5 rounded-2xl bg-amber-50/90 border border-amber-200/90 text-xs space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1.5 font-heading font-bold text-amber-900">
                                            <iconify-icon icon="solar:clock-circle-bold" class="text-amber-600 text-base"></iconify-icon>
                                            <span>Bukti Transfer Telah Diunggah</span>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-md bg-amber-200 text-amber-900 font-mono text-[10px] font-bold uppercase">
                                            {{ $activeConf->status }}
                                        </span>
                                    </div>
                                    <div class="text-slate-600 text-[11px] space-y-0.5">
                                        <p>Pengirim: <strong class="text-slate-800">{{ $activeConf->bank_sender }} (a.n {{ $activeConf->sender_name }})</strong></p>
                                        <p>Nominal: <strong class="text-slate-800">{{ $activeConf->formatted_amount }}</strong> &bull; Tgl: {{ $activeConf->transfer_date?->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="pt-1 flex items-center gap-2">
                                        <a href="{{ $activeConf->proof_url }}" target="_blank" class="text-[11px] font-heading font-bold text-sky-600 hover:underline flex items-center gap-1">
                                            <iconify-icon icon="solar:eye-bold" class="text-xs"></iconify-icon>
                                            <span>Lihat Bukti yang Dikirim</span>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <!-- Upload Proof Form -->
                            <form 
                                action="{{ route('portal.billing.transfer.confirm', urlencode($currentInvoice->kode_billing_layanan)) }}" 
                                method="POST" 
                                enctype="multipart/form-data" 
                                class="space-y-3 pt-2 border-t border-slate-100"
                            >
                                @csrf
                                <div class="text-xs font-heading font-bold text-slate-800 flex items-center gap-1.5">
                                    <iconify-icon icon="solar:upload-track-bold" class="text-emerald-600 text-base"></iconify-icon>
                                    <span>Formulir Konfirmasi Bukti Transfer</span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                    <!-- Bank Tujuan -->
                                    <div>
                                        <label class="block text-slate-500 text-[11px] font-medium mb-1">Transfer ke Bank:</label>
                                        <select name="bank_destination" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:bg-white focus:border-sky-500 text-xs font-semibold">
                                            @foreach($bankAccounts as $bank)
                                                <option value="{{ $bank['bank_name'] }} - {{ $bank['account_number'] }}">
                                                    {{ $bank['bank_name'] }} ({{ $bank['account_number'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Bank Pengirim -->
                                    <div>
                                        <label class="block text-slate-500 text-[11px] font-medium mb-1">Bank Pengirim Anda:</label>
                                        <input type="text" name="bank_sender" placeholder="Contoh: BCA / Mandiri / BRI" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:bg-white focus:border-sky-500 text-xs">
                                    </div>

                                    <!-- Atas Nama Pengirim -->
                                    <div>
                                        <label class="block text-slate-500 text-[11px] font-medium mb-1">Atas Nama Rekening Pengirim:</label>
                                        <input type="text" name="sender_name" value="{{ $customer->name }}" placeholder="Nama di rekening pengirim" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:bg-white focus:border-sky-500 text-xs">
                                    </div>

                                    <!-- Jumlah Transfer -->
                                    <div>
                                        <label class="block text-slate-500 text-[11px] font-medium mb-1">Jumlah Ditransfer (Rp):</label>
                                        <input type="number" name="transfer_amount" value="{{ (int)$currentInvoice->total_layanan }}" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:bg-white focus:border-sky-500 text-xs font-mono font-bold">
                                    </div>

                                    <!-- Tanggal Transfer -->
                                    <div class="sm:col-span-2">
                                        <label class="block text-slate-500 text-[11px] font-medium mb-1">Tanggal Transfer:</label>
                                        <input type="date" name="transfer_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:bg-white focus:border-sky-500 text-xs">
                                    </div>
                                </div>

                                <!-- File Upload Box -->
                                <div>
                                    <label class="block text-slate-500 text-[11px] font-medium mb-1">Unggah Foto Resi / Bukti Struk (JPG, PNG, PDF max 5MB):</label>
                                    <div class="relative border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-2xl p-3 sm:p-4 text-center bg-slate-50/60 hover:bg-emerald-50/20 transition-all cursor-pointer">
                                        <input 
                                            type="file" 
                                            name="proof_file" 
                                            accept="image/*,.pdf" 
                                            required 
                                            @change="filePreview = $event.target.files[0] ? $event.target.files[0].name : null"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        >
                                        <div class="flex flex-col items-center justify-center gap-1 pointer-events-none">
                                            <iconify-icon icon="solar:upload-line-duotone" class="text-2xl text-emerald-600"></iconify-icon>
                                            <div class="text-xs font-semibold text-slate-700">
                                                <span x-text="filePreview ? filePreview : 'Pilih Foto / Dokumen Bukti Transfer'"></span>
                                            </div>
                                            <p class="text-[10px] text-slate-400">Klik di sini untuk mengambil foto struk atau memilih file</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Catatan Opsional -->
                                <div>
                                    <label class="block text-slate-500 text-[11px] font-medium mb-1">Catatan Tambahan (Opsional):</label>
                                    <textarea name="notes" rows="1" placeholder="Contoh: Sudah ditransfer dari m-Banking BCA" class="w-full px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:bg-white focus:border-sky-500 text-xs"></textarea>
                                </div>

                                <!-- Submit Button -->
                                <button 
                                    type="submit" 
                                    class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-heading font-extrabold text-xs sm:text-sm shadow-md shadow-emerald-500/20 active:scale-98 transition-all flex items-center justify-center gap-2 cursor-pointer"
                                >
                                    <iconify-icon icon="solar:plain-bold" class="text-base"></iconify-icon>
                                    <span>Kirim Bukti Pembayaran</span>
                                </button>
                            </form>
                        </div>

                    </div>
                @else
                    <!-- Lunas Box -->
                    <div class="p-6 rounded-3xl bg-emerald-50 border border-emerald-200 text-center space-y-2">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center mx-auto shadow-md shadow-emerald-500/20">
                            <iconify-icon icon="solar:check-circle-bold" class="text-2xl"></iconify-icon>
                        </div>
                        <h3 class="text-base font-heading font-extrabold text-emerald-900">Tagihan Telah Lunas</h3>
                        <p class="text-xs text-emerald-700 leading-relaxed max-w-sm mx-auto">
                            Terima kasih! Pembayaran tagihan periode ini telah terkonfirmasi. Layanan internet Anda aktif lancar tanpa kendala.
                        </p>
                    </div>
                @endif

            </div>

        </div>

    </div>

    <!-- Riwayat Pembayaran & Tagihan -->
    <div class="portal-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 space-y-3.5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                    <iconify-icon icon="solar:history-bold" class="text-base"></iconify-icon>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-heading font-bold text-slate-900">
                        Riwayat Pembayaran & Tagihan
                    </h3>
                    <p class="text-[11px] text-slate-500">
                        Daftar seluruh tagihan periode bulan berjalan dan bulan sebelumnya.
                    </p>
                </div>
            </div>
        </div>

        <!-- Mobile Card View (sm:hidden) -->
        <div class="sm:hidden space-y-2.5">
            @forelse($invoices as $inv)
                @php
                    $invConf = $confirmations->get($inv->kode_billing_layanan);
                @endphp
                <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs space-y-2">
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-mono text-xs font-bold text-slate-800">#{{ $inv->invoice_number }}</span>
                        @if($inv->is_paid)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                <span>LUNAS</span>
                            </span>
                        @elseif($invConf && $invConf->status === 'pending')
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
                            <div class="font-semibold text-slate-800">{{ $inv->period }}</div>
                            <div class="text-[10px] text-slate-500">{{ $inv->package_name }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-mono font-extrabold text-sky-600">{{ $inv->formatted_total }}</div>
                            <div class="text-[10px] text-slate-400 font-mono">Tempo: {{ $inv->due_date?->format('d/m/Y') }}</div>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-1.5 flex-wrap">
                        @if(!$inv->is_paid)
                            <button 
                                type="button" 
                                id="btnPayMobile-{{ $loop->index }}"
                                onclick="payWithMidtrans('{{ $inv->kode_billing_layanan }}', 'btnPayMobile-{{ $loop->index }}')"
                                class="px-2.5 py-1.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-xs flex items-center gap-1 shadow-2xs transition-all active:scale-95"
                            >
                                <iconify-icon icon="solar:bolt-circle-bold" width="13"></iconify-icon>
                                <span>Midtrans</span>
                            </button>
                            <button 
                                type="button" 
                                @click="modalInvoiceCode = '{{ $inv->kode_billing_layanan }}'; modalInvoiceAmount = '{{ (int)$inv->total_layanan }}'; modalInvoiceNumber = '{{ $inv->invoice_number }}'; modalPeriod = '{{ $inv->period }}'; showTransferModal = true"
                                class="px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs flex items-center gap-1 shadow-2xs transition-all active:scale-95"
                            >
                                <iconify-icon icon="solar:upload-track-bold" width="13"></iconify-icon>
                                <span>Upload Bukti</span>
                            </button>
                        @endif
                        <a 
                            href="{{ route('portal.billing.show', urlencode($inv->kode_billing_layanan)) }}" 
                            target="_blank"
                            class="px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-sky-50 text-slate-700 hover:text-sky-700 font-semibold text-xs flex items-center gap-1 transition-all"
                        >
                            <iconify-icon icon="solar:document-text-bold" width="13"></iconify-icon>
                            <span>Struk</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-slate-400 text-xs">
                    Belum ada riwayat tagihan.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (hidden sm:block) -->
        <div class="hidden sm:block overflow-x-auto rounded-2xl border border-slate-200/80 bg-white/70">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/80 text-[11px] font-mono font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">No. Invoice</th>
                        <th class="py-3 px-4">Periode</th>
                        <th class="py-3 px-4">Paket Layanan</th>
                        <th class="py-3 px-4">Jatuh Tempo</th>
                        <th class="py-3 px-4 text-right">Total</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-sans">
                    @forelse($invoices as $inv)
                        @php
                            $invConf = $confirmations->get($inv->kode_billing_layanan);
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-slate-800">
                                #{{ $inv->invoice_number }}
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-700">
                                {{ $inv->period }}
                            </td>
                            <td class="py-3 px-4 text-slate-600 text-xs">
                                {{ $inv->package_name }}
                            </td>
                            <td class="py-3 px-4 font-mono text-xs text-slate-500">
                                {{ $inv->due_date?->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-sky-600">
                                {{ $inv->formatted_total }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($inv->is_paid)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-mono font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                        <span>LUNAS</span>
                                    </span>
                                @elseif($invConf && $invConf->status === 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-mono font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
                                        <span>DIVERIFIKASI</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-mono font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <iconify-icon icon="solar:danger-triangle-bold"></iconify-icon>
                                        <span>BELUM BAYAR</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                    @if(!$inv->is_paid)
                                        <button 
                                            type="button" 
                                            id="btnPayHist-{{ $loop->index }}"
                                            onclick="payWithMidtrans('{{ $inv->kode_billing_layanan }}', 'btnPayHist-{{ $loop->index }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-xs shadow-2xs transition-all disabled:opacity-60"
                                            title="Bayar tagihan ini via Midtrans"
                                        >
                                            <iconify-icon icon="solar:bolt-circle-bold" width="13"></iconify-icon>
                                            <span>Midtrans</span>
                                        </button>
                                        <button 
                                            type="button" 
                                            @click="modalInvoiceCode = '{{ $inv->kode_billing_layanan }}'; modalInvoiceAmount = '{{ (int)$inv->total_layanan }}'; modalInvoiceNumber = '{{ $inv->invoice_number }}'; modalPeriod = '{{ $inv->period }}'; showTransferModal = true"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-2xs transition-all"
                                            title="Upload bukti transfer untuk tagihan ini"
                                        >
                                            <iconify-icon icon="solar:upload-track-bold" width="13"></iconify-icon>
                                            <span>Transfer</span>
                                        </button>
                                    @endif
                                    <a 
                                        href="{{ route('portal.billing.show', urlencode($inv->kode_billing_layanan)) }}" 
                                        target="_blank"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 hover:bg-sky-100 text-slate-700 hover:text-sky-700 transition-colors font-semibold text-xs"
                                        title="Cetak struk resmi"
                                    >
                                        <iconify-icon icon="solar:document-text-bold" width="13"></iconify-icon>
                                        <span>Struk</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                <iconify-icon icon="solar:inbox-line" width="36" class="mx-auto mb-2 opacity-60"></iconify-icon>
                                <p>Belum ada riwayat tagihan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4"
        style="display: none;"
    >
        <div 
            @click.outside="showTransferModal = false"
            class="bg-white rounded-3xl shadow-2xl border border-slate-200 max-w-lg w-full p-5 sm:p-6 space-y-4 max-h-[90vh] overflow-y-auto"
        >
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <iconify-icon icon="solar:upload-track-bold" class="text-lg"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-sm font-heading font-extrabold text-slate-900">Upload Bukti Transfer Bank</h3>
                        <p class="text-[11px] text-slate-500">Invoice: <span class="font-mono font-bold text-sky-600" x-text="'#' + modalInvoiceNumber"></span></p>
                    </div>
                </div>
                <button @click="showTransferModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-xl">
                    <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                </button>
            </div>

            <!-- Rekening PT MSN -->
            <div class="grid grid-cols-2 gap-2 text-xs">
                @foreach($bankAccounts as $bank)
                    <div class="p-2.5 rounded-xl bg-slate-900 text-white space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-mono font-bold text-sky-300 uppercase">{{ $bank['bank_name'] }}</span>
                            <button type="button" onclick="copyToClipboard('{{ $bank['account_number'] }}', 'No Rekening')" class="text-[9px] text-slate-300 hover:text-white underline">Salin</button>
                        </div>
                        <div class="font-mono font-bold text-xs select-all">{{ $bank['account_number'] }}</div>
                        <div class="text-[9px] text-slate-400 truncate">{{ $bank['account_name'] }}</div>
                    </div>
                @endforeach
            </div>

            <form 
                :action="`{{ url('/portal/tagihan') }}/${encodeURIComponent(modalInvoiceCode)}/transfer-confirm`" 
                method="POST" 
                enctype="multipart/form-data" 
                class="space-y-3"
            >
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                    <div>
                        <label class="block text-slate-500 text-[11px] font-medium mb-1">Transfer ke Bank:</label>
                        <select name="bank_destination" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-xs font-semibold">
                            @foreach($bankAccounts as $bank)
                                <option value="{{ $bank['bank_name'] }} - {{ $bank['account_number'] }}">
                                    {{ $bank['bank_name'] }} ({{ $bank['account_number'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-500 text-[11px] font-medium mb-1">Bank Pengirim Anda:</label>
                        <input type="text" name="bank_sender" placeholder="Contoh: BCA / Mandiri / BRI" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-xs">
                    </div>
                    <div>
                        <label class="block text-slate-500 text-[11px] font-medium mb-1">Atas Nama Rekening Pengirim:</label>
                        <input type="text" name="sender_name" value="{{ $customer->name }}" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-xs">
                    </div>
                    <div>
                        <label class="block text-slate-500 text-[11px] font-medium mb-1">Jumlah Ditransfer (Rp):</label>
                        <input type="number" name="transfer_amount" :value="modalInvoiceAmount" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-xs font-mono font-bold">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-slate-500 text-[11px] font-medium mb-1">Tanggal Transfer:</label>
                        <input type="date" name="transfer_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-xs">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-500 text-[11px] font-medium mb-1">Foto Bukti Resi Transfer (JPG, PNG, PDF max 5MB):</label>
                    <input type="file" name="proof_file" accept="image/*,.pdf" required class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <div>
                    <label class="block text-slate-500 text-[11px] font-medium mb-1">Catatan Tambahan (Opsional):</label>
                    <textarea name="notes" rows="1" placeholder="Catatan transaksi..." class="w-full px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 text-xs"></textarea>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" @click="showTransferModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs shadow-md transition-all">
                        Kirim Bukti Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>
<script>
    function payWithMidtrans(kodeBilling, btnId = null) {
        let btn = null;
        let originalContent = '';
        if (btnId) {
            btn = document.getElementById(btnId);
            if (btn) {
                originalContent = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<iconify-icon icon="solar:spinner-line" class="animate-spin inline-block mr-1" width="16"></iconify-icon><span>Memproses Midtrans...</span>';
            }
        }

        const endpoint = `{{ url('/portal/tagihan') }}/${encodeURIComponent(kodeBilling)}/pay`;

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }

            if (data.success && data.token) {
                if (typeof window.snap !== 'undefined') {
                    window.snap.pay(data.token, {
                        onSuccess: function(result) {
                            fetch(`{{ url('/portal/tagihan') }}/${encodeURIComponent(kodeBilling)}/sync`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            }).finally(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pembayaran Berhasil!',
                                    text: 'Pembayaran tagihan Anda berhasil dikonfirmasi. Halaman akan dimuat ulang.',
                                    confirmButtonColor: '#0ea5e9'
                                }).then(() => window.location.reload());
                            });
                        },
                        onPending: function(result) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Menunggu Pembayaran',
                                text: 'Instruksi pembayaran telah dibuat. Silakan selesaikan pembayaran sesuai panduan Midtrans.',
                                confirmButtonColor: '#0ea5e9'
                            }).then(() => window.location.reload());
                        },
                        onError: function(result) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Pembayaran Dibatalkan',
                                text: 'Pembayaran gagal diproses atau telah dibatalkan.',
                                confirmButtonColor: '#0ea5e9'
                            });
                        },
                        onClose: function() {
                            console.log('Jendela popup Snap Midtrans ditutup.');
                        }
                    });
                } else if (data.redirect_url) {
                    window.open(data.redirect_url, '_blank');
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Siap Membayar',
                        text: 'Sistem pembayaran Midtrans siap diproses.',
                        confirmButtonColor: '#0ea5e9'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: data.message || 'Gagal memproses pembayaran Midtrans. Mohon periksa konfigurasi server.',
                    confirmButtonColor: '#0ea5e9'
                });
            }
        })
        .catch(err => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }
            console.error('Midtrans Request Error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Gangguan Server',
                text: 'Terjadi kendala saat menghubungi server pembayaran.',
                confirmButtonColor: '#0ea5e9'
            });
        });
    }
</script>
@endpush
