<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Invoice {{ $invoice->invoice_number }} — PT Media Solusi Network</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="bg-slate-100 min-h-screen py-6 sm:py-10 px-4 text-slate-800">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-3xl mx-auto mb-5 flex flex-wrap items-center justify-between gap-3 no-print">
        <a href="{{ route('portal.billing.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-sky-600 bg-white px-3.5 py-2 rounded-xl border border-slate-200 shadow-sm transition-all">
            &larr; Kembali ke Portal Tagihan
        </a>
        <div class="flex items-center gap-2">
            @if(!$invoice->is_paid)
                <button 
                    type="button" 
                    id="btnPayInvoice"
                    onclick="payWithMidtrans('{{ $invoice->kode_billing_layanan }}')"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-xl shadow-md transition-all cursor-pointer disabled:opacity-60"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Bayar Sekarang (Midtrans)</span>
                </button>
            @endif
            <button onclick="window.print()" class="inline-flex items-center gap-2 text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 px-4 py-2 rounded-xl shadow-md transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Official Invoice Container -->
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl border border-slate-200/80 p-8 sm:p-12 print-shadow-none relative overflow-hidden">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start gap-6 pb-8 border-b border-slate-200">
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

        <!-- Footer / Notes -->
        <div class="mt-10 pt-6 border-t border-slate-200 text-[11px] text-slate-500 leading-relaxed">
            <p class="font-bold text-slate-700 mb-1">Catatan Pembayaran:</p>
            <p>1. Pembayaran tagihan dapat dilakukan melalui Portal Pelanggan resmi PT MSN via QRIS, Virtual Account Bank (BCA, Mandiri, BRI, BNI), atau Gerai Retail.</p>
            <p>2. Tagihan ini merupakan bukti sah penagihan dari PT Media Solusi Network dan diterbitkan secara elektronik oleh sistem.</p>
        </div>
    </div>

    @if(!$invoice->is_paid)
        <script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>
        <script>
            function payWithMidtrans(kodeBilling) {
                const btn = document.getElementById('btnPayInvoice');
                const originalContent = btn ? btn.innerHTML : '';
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span>Memproses Midtrans...</span>';
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
                                    alert('Pembayaran berhasil dikonfirmasi! Halaman akan diperbarui.');
                                    window.location.reload();
                                },
                                onPending: function(result) {
                                    alert('Transaksi Anda sedang diproses / menunggu pembayaran.');
                                    window.location.reload();
                                },
                                onError: function(result) {
                                    alert('Pembayaran gagal atau dibatalkan.');
                                }
                            });
                        } else if (data.redirect_url) {
                            window.open(data.redirect_url, '_blank');
                        }
                    } else {
                        alert(data.message || 'Gagal memproses pembayaran Midtrans.');
                    }
                })
                .catch(err => {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = originalContent;
                    }
                    alert('Terjadi kesalahan saat menghubungi server pembayaran.');
                });
            }
        </script>
    @endif

</body>
</html>

