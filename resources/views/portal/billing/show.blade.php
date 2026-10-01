<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Invoice {{ $invoice->invoice_number }} — PT Media Solusi Network</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-icon.png') }}">
    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen py-3.5 sm:py-10 px-3 sm:px-4 text-slate-800">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-3xl mx-auto mb-3.5 sm:mb-5 flex flex-wrap items-center justify-between gap-2 sm:gap-3 no-print">
        <a href="{{ route('portal.billing.index') }}" class="inline-flex items-center gap-1.5 sm:gap-2 text-xs font-semibold text-slate-600 hover:text-sky-600 bg-white px-3 py-1.5 sm:px-3.5 sm:py-2 rounded-xl border border-slate-200 shadow-2xs transition-all">
            &larr; Kembali ke Portal Tagihan
        </a>
        <div class="flex items-center gap-2">
            @if(!$invoice->is_paid)
                <button 
                    type="button" 
                    id="btnPayInvoice"
                    onclick="payWithMidtrans('{{ $invoice->kode_billing_layanan }}')"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl shadow-md transition-all cursor-pointer disabled:opacity-60"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Bayar Sekarang (Midtrans)</span>
                </button>
            @endif
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 sm:gap-2 text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl shadow-md transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Official Invoice Container -->
    <div class="max-w-3xl mx-auto bg-white rounded-2xl sm:rounded-3xl shadow-xl border border-slate-200/80 p-4 sm:p-12 print-shadow-none relative overflow-hidden">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 sm:gap-6 pb-4 sm:pb-8 border-b border-slate-200">
            <div>
                <img src="{{ asset('images/logo/logo-msn.png') }}" alt="PT Media Solusi Network" class="h-10 w-auto mb-2">
                <div class="text-xs text-slate-500 space-y-0.5">
                    <p class="font-bold text-slate-700">PT MEDIA SOLUSI NETWORK</p>
                    <p>Internet Service Provider & IT Solutions</p>
                    <p>Bandung, Jawa Barat — Indonesia</p>
                    <p>Website: www.ptmsn.co.id</p>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <span class="inline-block px-3 py-1 rounded-full text-[11px] font-mono font-bold uppercase tracking-wider {{ $invoice->is_paid ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }} mb-2">
                    {{ $invoice->status_label }}
                </span>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 font-mono tracking-tight">{{ $invoice->invoice_number }}</h1>
                <p class="text-xs text-slate-500 mt-1">Tanggal: <strong class="text-slate-700">{{ $invoice->date_create?->format('d/m/Y') ?? date('d/m/Y') }}</strong></p>
                <p class="text-xs text-slate-500">Jatuh Tempo: <strong class="text-slate-700">{{ $invoice->due_date?->format('d/m/Y') }}</strong></p>
            </div>
        </div>

        <!-- Bill To & Account Details -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-6 border-b border-slate-200 text-xs">
            <div>
                <div class="font-mono uppercase font-bold text-slate-400 mb-1.5 text-[10px] tracking-wider">Ditagihkan Kepada:</div>
                <div class="font-bold text-slate-900 text-sm">{{ $customer->name }}</div>
                <div class="text-slate-600 mt-0.5">Nomor Internet: <strong class="font-mono text-slate-800">{{ $customer->customer_id }}</strong></div>
                <div class="text-slate-600">Telepon: {{ $customer->phone ?: '-' }}</div>
                <div class="text-slate-600 mt-1">Alamat: {{ $customer->address ?: '-' }}</div>
            </div>

            <div class="sm:text-right">
                <div class="font-mono uppercase font-bold text-slate-400 mb-1.5 text-[10px] tracking-wider">Periode Layanan:</div>
                <div class="font-bold text-slate-900 text-sm">{{ $invoice->period }}</div>
                <div class="text-slate-600 mt-0.5">Metode Bayar: {{ $invoice->payment_method ?: 'Online Payment / Midtrans' }}</div>
                @if($invoice->paid_at)
                    <div class="text-emerald-700 font-semibold mt-1">Dibayar pada: {{ $invoice->paid_at->format('d/m/Y H:i') }} WIB</div>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <div class="py-6">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-300 text-slate-500 font-mono uppercase text-[10px]">
                        <th class="py-2.5">Deskripsi Layanan</th>
                        <th class="py-2.5 text-center">Durasi</th>
                        <th class="py-2.5 text-right">Harga</th>
                        <th class="py-2.5 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-4">
                            <div class="font-bold text-slate-900 text-sm">{{ $invoice->package_name }}</div>
                            <div class="text-slate-500 text-[11px] mt-0.5">Koneksi Internet Dedicated Fiber Optic Unlimited Tanpa Batas Kuota (FUP)</div>
                        </td>
                        <td class="py-4 text-center text-slate-700 font-mono">1 Bulan</td>
                        <td class="py-4 text-right font-mono text-slate-700">{{ $invoice->formatted_amount }}</td>
                        <td class="py-4 text-right font-mono font-bold text-slate-900">{{ $invoice->formatted_amount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Summary Totals -->
        <div class="pt-4 border-t border-slate-200 flex justify-end">
            <div class="w-full sm:w-64 space-y-2 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal:</span>
                    <span class="font-mono font-semibold">{{ $invoice->formatted_amount }}</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>PPN / Biaya Admin:</span>
                    <span class="font-mono font-semibold">Rp 0</span>
                </div>
                <div class="pt-2 border-t border-slate-300 flex justify-between items-baseline font-bold text-slate-900">
                    <span class="text-sm">Total Tagihan:</span>
                    <span class="font-mono text-lg text-sky-600">{{ $invoice->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Bank Transfer Details (For Manual Payment) -->
        <div class="mt-8 pt-6 border-t border-slate-200 text-xs">
            <div class="font-mono uppercase font-bold text-slate-500 mb-2 text-[10px] tracking-wider">Rekening Resmi Pembayaran Transfer Bank:</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($bankAccounts as $bank)
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                        <div class="font-bold text-slate-800 text-xs flex items-center justify-between">
                            <span>{{ $bank['bank_name'] }}</span>
                            <span class="font-mono text-sky-600 font-extrabold text-sm">{{ $bank['account_number'] }}</span>
                        </div>
                        <div class="text-[11px] text-slate-500 mt-0.5">a.n. {{ $bank['account_name'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- WhatsApp Billing Direct Button -->
        @php
            $waMsg = "Halo Tim Billing PT MSN,\nSaya ingin konfirmasi pembayaran tagihan:\n• ID Pelanggan: {$customer->customer_id}\n• No. Invoice: {$invoice->invoice_number}\n• Nama: {$customer->name}\n• Total: {$invoice->formatted_total}\n• Periode: {$invoice->period}\n\nMohon bantuannya. Terima kasih!";
            $waBillingUrl = "https://wa.me/" . ($billingWhatsapp ?: '6285188358385') . "?text=" . urlencode($waMsg);
        @endphp
        <div class="mt-4 no-print flex flex-col sm:flex-row items-center justify-between gap-3 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200">
            <div class="text-xs text-emerald-900">
                <span class="font-bold block">Butuh bantuan atau ingin konfirmasi pembayaran?</span>
                <span class="text-[11px] text-emerald-700">Hubungi langsung bagian Keuangan & Billing PT MSN via WhatsApp.</span>
            </div>
            <a href="{{ $waBillingUrl }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-all whitespace-nowrap">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                <span>Hubungi Billing via WhatsApp</span>
            </a>
        </div>

        <!-- Footer / Notes -->
        <div class="mt-8 pt-6 border-t border-slate-200 text-[11px] text-slate-500 leading-relaxed">
            <p class="font-bold text-slate-700 mb-1">Catatan Pembayaran:</p>
            <p>1. Pembayaran tagihan dapat dilakukan melalui MyMSN (Customer Self-Care) resmi PT MSN via QRIS, Virtual Account Bank (BCA, Mandiri, BRI, BNI), atau Transfer Bank Langsung.</p>
            <p>2. Tagihan ini merupakan bukti sah penagihan dari PT Media Solusi Network dan diterbitkan secara elektronik oleh sistem.</p>
        </div>
    </div>

    @if(!$invoice->is_paid)
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>
        <script>
            function ensureSnapLoaded() {
                return new Promise((resolve) => {
                    if (typeof window.snap !== 'undefined' && typeof window.snap.pay === 'function') {
                        return resolve(true);
                    }
                    let existingScript = document.querySelector('script[src*="snap.js"]');
                    if (!existingScript) {
                        existingScript = document.createElement('script');
                        existingScript.src = '{{ $snapJsUrl }}';
                        existingScript.setAttribute('data-client-key', '{{ $clientKey }}');
                        document.head.appendChild(existingScript);
                    }
                    existingScript.onload = () => resolve(typeof window.snap !== 'undefined');
                    existingScript.onerror = () => resolve(false);
                    setTimeout(() => resolve(typeof window.snap !== 'undefined'), 2000);
                });
            }

            async function payWithMidtrans(kodeBilling) {
                const btn = document.getElementById('btnPayInvoice');
                const originalContent = btn ? btn.innerHTML : '';
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<iconify-icon icon="solar:spinner-line" class="animate-spin inline-block mr-1" width="16"></iconify-icon><span>Menghubungi Midtrans...</span>';
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

                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = originalContent;
                    }

                    if (data.success && (data.token || data.redirect_url)) {
                        await ensureSnapLoaded();

                        let snapTriggered = false;

                        if (typeof window.snap !== 'undefined' && typeof window.snap.pay === 'function' && data.token) {
                            try {
                                window.snap.pay(data.token, {
                                    onSuccess: function(result) {
                                        fetch(`{{ route('portal.billing.sync.direct') }}`, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                kode_billing: kodeBilling
                                            })
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
                                            text: 'Pembayaran gagal atau dibatalkan.',
                                            confirmButtonColor: '#0ea5e9'
                                        });
                                    },
                                    onClose: function() {
                                        console.log('Jendela popup Snap Midtrans ditutup.');
                                    }
                                });
                                snapTriggered = true;
                            } catch (snapErr) {
                                console.warn('Snap Popup Error, beralih ke Redirect URL:', snapErr);
                                snapTriggered = false;
                            }
                        }

                        if (!snapTriggered && data.redirect_url) {
                            window.location.href = data.redirect_url;
                        } else if (!snapTriggered && !data.redirect_url) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Kendala Tampilan',
                                text: 'Jendela pembayaran tidak dapat dimuat di perangkat ini. Silakan muat ulang halaman.',
                                confirmButtonColor: '#0ea5e9'
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: data.message || 'Gagal memproses pembayaran Midtrans.',
                            confirmButtonColor: '#0ea5e9'
                        });
                    }
                } catch (err) {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = originalContent;
                    }
                    console.error('Midtrans Request Error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gangguan Jaringan',
                        text: 'Terjadi kesalahan saat menghubungi server pembayaran.',
                        confirmButtonColor: '#0ea5e9'
                    });
                }
            }
        </script>
    @endif

</body>
</html>

