<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Ims\TiketGangguan;
use App\Models\Ims\UbahLayanan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Tampilkan semua daftar tiket gangguan & ubah layanan pelanggan
     */
    public function index(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $ticketsQuery = $customer->tickets();
        $ubahQuery = $customer->ubahLayanan();

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'open') {
                $ticketsQuery->whereIn('status', ['11', 'open', 'antrian']);
                $ubahQuery->whereIn('status_ubah_layanan', ['11', 'open', 'antrian']);
            } elseif ($status === 'in_progress') {
                $ticketsQuery->whereIn('status', ['12', 'in_progress', 'proses', 'konfirmasi']);
                $ubahQuery->whereIn('status_ubah_layanan', ['12', 'in_progress', 'proses']);
            } elseif ($status === 'resolved') {
                $ticketsQuery->whereIn('status', ['13', '14', 'resolved', 'done', 'close', 'closed']);
                $ubahQuery->whereIn('status_ubah_layanan', ['13', '14', 'resolved', 'done']);
            } else {
                $ticketsQuery->where('status', $status);
                $ubahQuery->where('status_ubah_layanan', $status);
            }
        }

        if ($request->filled('category')) {
            $cat = $request->category;
            if ($cat === '17') {
                $ticketsQuery->whereRaw('1 = 0');
            } else {
                $ticketsQuery->where('kat_tiket', $cat);
                $ubahQuery->whereRaw('1 = 0');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $ticketsQuery->where(function ($q) use ($search) {
                $q->where('tiket', 'like', "%{$search}%")
                  ->orWhere('indikasi', 'like', "%{$search}%")
                  ->orWhere('keluhan', 'like', "%{$search}%");
            });
            $ubahQuery->where(function ($q) use ($search) {
                $q->where('kode_trx_ubah_layanan', 'like', "%{$search}%")
                  ->orWhere('note_request', 'like', "%{$search}%");
            });
        }

        $allTickets = $ticketsQuery->get();
        $allUbah = $ubahQuery->get();

        $merged = $allTickets->concat($allUbah)->sortByDesc(function ($item) {
            return $item->created_at ? $item->created_at->timestamp : 0;
        })->values();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $tickets = new LengthAwarePaginator(
            $merged->forPage($page, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('portal.tickets.index', compact('tickets', 'customer'));
    }

    /**
     * Tampilkan form pembuatan laporan gangguan baru
     */
    public function create()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $customer->load(['pelanggan', 'bandwith']);
        }

        $packages = \App\Models\Package::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('price', 'asc')
            ->get();

        return view('portal.tickets.create', compact('customer', 'packages'));
    }

    /**
     * Simpan laporan gangguan baru ke database IMS (trx_tiket_gangguan)
     */
    public function store(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $katTiket = (string) ($request->input('kat_tiket', '11'));

        // Validasi kondisional berdasarkan kategori tiket
        $rules = [
            'kat_tiket' => ['required', 'string'],
        ];

        if ($katTiket === '12') {
            // Ubah Password WiFi
            $rules['wifi_ssid'] = ['required', 'string', 'max:50'];
            $rules['wifi_password'] = ['required', 'string', 'min:8', 'max:50'];
        } elseif ($katTiket === '17') {
            // Ubah Layanan (Upgrade / Downgrade)
            $rules['target_package_id'] = ['required'];
            $rules['change_type'] = ['required', 'string'];
        } elseif ($katTiket === '13') {
            // Cek Coverage / Relokasi
            $rules['new_address'] = ['required', 'string', 'min:10'];
            $rules['move_date'] = ['required', 'date'];
        } elseif ($katTiket === '15') {
            // Suspend Layanan
            $rules['suspend_start'] = ['required', 'date'];
            $rules['suspend_reason'] = ['required', 'string'];
        } elseif ($katTiket === '14') {
            // Terminasi
            $rules['termination_date'] = ['required', 'date'];
            $rules['termination_reason'] = ['required', 'string'];
            $rules['agree_return_device'] = ['accepted'];
        } else {
            // Default: 11 - Gangguan Layanan
            $rules['subject'] = ['nullable', 'string', 'max:200'];
            $rules['description'] = ['nullable', 'string', 'max:2000'];
        }

        $request->validate($rules, [
            'wifi_ssid.required' => 'Nama WiFi baru (SSID) wajib diisi.',
            'wifi_password.required' => 'Password WiFi baru wajib diisi.',
            'wifi_password.min' => 'Password WiFi baru minimal 8 karakter.',
            'target_package_id.required' => 'Pilih paket internet yang diinginkan.',
            'new_address.required' => 'Alamat lengkap lokasi baru wajib dicantumkan.',
            'move_date.required' => 'Rencana tanggal pindah wajib diisi.',
            'suspend_start.required' => 'Tanggal mulai suspend wajib diisi.',
            'suspend_reason.required' => 'Alasan suspend wajib dipilih/diisi.',
            'termination_date.required' => 'Tanggal efektif terminasi wajib diisi.',
            'termination_reason.required' => 'Alasan penghentian layanan wajib dipilih.',
            'agree_return_device.accepted' => 'Anda harus menyetujui penyerahan perangkat modem ONT milik PT MSN.',
        ]);

        // Konstruksi Indikasi (Subject) & Keluhan (Deskripsi) berdasarkan kategori
        $subject = '';
        $complaintLines = [];

        if ($katTiket === '12') {
            $ssid = trim($request->input('wifi_ssid'));
            $pass = trim($request->input('wifi_password'));
            $band = $request->input('wifi_band', 'Dual Band (2.4 GHz & 5 GHz)');
            $schedule = $request->input('wifi_schedule', 'Segera mungkin');
            $notes = trim($request->input('wifi_notes', ''));

            $subject = "Permintaan Ubah SSID & Password WiFi ({$ssid})";
            $complaintLines = [
                "[PERMINTAAN UBAH PASSWORD & SSID WIFI]",
                "• Nama WiFi Baru (SSID) : {$ssid}",
                "• Password Baru          : {$pass}",
                "• Frekuensi WiFi         : {$band}",
                "• Waktu Penerapan        : {$schedule}",
            ];
            if (!empty($notes)) {
                $complaintLines[] = "• Catatan Tambahan       : {$notes}";
            }
        } elseif ($katTiket === '17') {
            $packageId = $request->input('target_package_id');
            $targetPkg = \App\Models\Package::find($packageId);
            $packageName = $targetPkg ? "{$targetPkg->name} ({$targetPkg->speed} - {$targetPkg->formatted_price}/bln)" : 'Paket Pilihan';
            $changeType = $request->input('change_type', 'Upgrade Kecepatan');
            $effectiveDate = $request->input('effective_date', 'Mulai Periode Billing Berikutnya');
            $currentPkg = $customer->package->name ?? ($customer->bandwith->nama_bandwith ?? 'Broadband');
            $reason = trim($request->input('change_reason', ''));

            $subject = "Permintaan Ubah Layanan: {$changeType} ke {$targetPkg?->name}";
            $complaintLines = [
                "[PERMINTAAN UBAH LAYANAN INTERNET]",
                "• Jenis Permintaan       : {$changeType}",
                "• Paket Saat Ini         : {$currentPkg}",
                "• Paket Baru Tujuan      : {$packageName}",
                "• Tanggal Efektif        : {$effectiveDate}",
            ];
            if (!empty($reason)) {
                $complaintLines[] = "• Alasan Perubahan       : {$reason}";
            }
        } elseif ($katTiket === '13') {
            $newAddr = trim($request->input('new_address'));
            $maps = trim($request->input('location_maps', '-'));
            $moveDate = $request->input('move_date');
            $contact = trim($request->input('contact_person', $customer->phone));
            $notes = trim($request->input('relokasi_notes', ''));

            $subject = "Pengajuan Relokasi / Cek Coverage Alamat Baru";
            $complaintLines = [
                "[PENGAJUAN RELOKASI / CEK COVERAGE AREA]",
                "• Alamat Saat Ini        : " . ($customer->address ?? 'Alamat Terdaftar'),
                "• Alamat Baru Tujuan     : {$newAddr}",
                "• Link Maps / Patokan    : {$maps}",
                "• Rencana Tanggal Pindah : {$moveDate}",
                "• Kontak di Lokasi Baru  : {$contact}",
            ];
            if (!empty($notes)) {
                $complaintLines[] = "• Catatan Tambahan       : {$notes}";
            }
        } elseif ($katTiket === '15') {
            $start = $request->input('suspend_start');
            $end = $request->input('suspend_end', 'Sesuai konfirmasi lebih lanjut');
            $reason = $request->input('suspend_reason');
            $notes = trim($request->input('suspend_notes', ''));

            $subject = "Pengajuan Suspend Layanan Sementara (Mulai {$start})";
            $complaintLines = [
                "[PENGAJUAN SUSPEND LAYANAN SEMENTARA]",
                "• Tanggal Mulai Suspend  : {$start}",
                "• Estimasi Aktif Kembali : {$end}",
                "• Alasan Suspend         : {$reason}",
            ];
            if (!empty($notes)) {
                $complaintLines[] = "• Catatan Tambahan       : {$notes}";
            }
        } elseif ($katTiket === '14') {
            $date = $request->input('termination_date');
            $reason = $request->input('termination_reason');
            $notes = trim($request->input('termination_notes', ''));

            $subject = "Permohonan Terminasi Layanan Pelanggan";
            $complaintLines = [
                "[PERMOHONAN TERMINASI / BERHENTI BERLANGGANAN]",
                "• Tanggal Efektif Berhenti : {$date}",
                "• Alasan Penghentian       : {$reason}",
                "• Kesiapan Perangkat ONT   : Bersedia diserahterimakan kepada teknisi PT MSN",
            ];
            if (!empty($notes)) {
                $complaintLines[] = "• Saran & Evaluasi Layanan : {$notes}";
            }
        } else {
            // Kat 11 - Gangguan Layanan
            $gangguanType = $request->input('gangguan_type', 'Lampu LOS Modem Merah / Berkedip');
            $lampu = $request->input('indikator_lampu');
            $lampuStr = is_array($lampu) ? implode(', ', $lampu) : ($lampu ?: 'Tidak Diketahui');
            $restart = $request->input('restart_modem', 'Belum dicoba');
            $waktu = $request->input('waktu_mulai', 'Hari ini');
            $customSubject = trim($request->input('subject', ''));
            $customDesc = trim($request->input('description', ''));

            $subject = !empty($customSubject) ? $customSubject : "Gangguan: {$gangguanType}";
            $complaintLines = [
                "[LAPORAN GANGGUAN LAYANAN]",
                "• Jenis Kendala          : {$gangguanType}",
                "• Lampu Indikator Modem  : {$lampuStr}",
                "• Sudah Coba Restart ONT : {$restart}",
                "• Waktu Terjadi Kendala  : {$waktu}",
            ];
            if (!empty($customDesc)) {
                $complaintLines[] = "• Kronologi & Penjelasan : {$customDesc}";
            }
        }

        $keluhan = implode("\n", $complaintLines);
        if (empty($subject)) {
            $subject = 'Laporan Pelanggan';
        }

        // Jika kategori Ubah Layanan (17), HANYA simpan ke tabel trx_ubah_layanan IMS
        if ($katTiket === '17') {
            $packageId = $request->input('target_package_id');
            $targetPkg = \App\Models\Package::find($packageId);
            $speedNumber = (int) preg_replace('/[^0-9]/', '', $targetPkg?->speed ?? '20');
            $matchingBw = \App\Models\Ims\Bandwith::where('nominal_bandwith', $speedNumber)->where('hide', '0')->first()
                ?: \App\Models\Ims\Bandwith::where('nominal_bandwith', $speedNumber)->first();
            $kodeBandwithBaru = $matchingBw?->kode_bandwith ?: ($customer->pelanggan?->kode_bandwith ?: 'AG167632');

            $kodeTrxUbah = 'UB-' . $customer->nomor_internet . rand(1000, 9999);
            
            UbahLayanan::create([
                'kode_trx_ubah_layanan' => $kodeTrxUbah,
                'nomor_internet' => $customer->nomor_internet,
                'kode_bandwith_lama' => $customer->pelanggan?->kode_bandwith ?: ($customer->kode_bandwith ?: 'AG167632'),
                'kode_bandwith_baru' => $kodeBandwithBaru,
                'status_ubah_layanan' => '11', // Status 11 = Request
                'date_request' => date('Y-m-d'),
                'note_request' => $keluhan,
                'date_create' => now(),
                'user_create' => 'Portal Pelanggan',
                'hide' => '0',
            ]);

            // Sinkronkan juga ke database ims_v3 jika ada
            try {
                \Illuminate\Support\Facades\DB::statement("
                    INSERT INTO `ims_v3`.`trx_ubah_layanan` 
                    (`kode_trx_ubah_layanan`, `nomor_internet`, `kode_bandwith_lama`, `kode_bandwith_baru`, `status_ubah_layanan`, `date_request`, `note_request`, `date_create`, `user_create`, `hide`)
                    VALUES (?, ?, ?, ?, '11', ?, ?, NOW(), 'Portal Pelanggan', '0')
                ", [
                    $kodeTrxUbah,
                    $customer->nomor_internet,
                    $customer->pelanggan?->kode_bandwith ?: ($customer->kode_bandwith ?: 'AG167632'),
                    $kodeBandwithBaru,
                    date('Y-m-d'),
                    $keluhan
                ]);
            } catch (\Exception $exV3) {}

            return redirect()->route('portal.tickets.show', $kodeTrxUbah)
                ->with('success', "Permintaan Ubah Layanan ({$kodeTrxUbah}) berhasil dikirim ke sistem IMS! Tim administrasi layanan kami akan segera memproses penyesuaian paket Anda.");
        }

        // Untuk kategori gangguan teknis, WiFi, relokasi, dll: simpan ke tabel trx_tiket_gangguan
        $datePrefix = date('Ymd');
        $randomSuffix = rand(100, 999);
        $ticketNumber = $katTiket . '1' . $datePrefix . $randomSuffix;

        $ticket = TiketGangguan::create([
            'tiket' => $ticketNumber,
            'nomor_internet' => $customer->nomor_internet,
            'keluhan' => $keluhan,
            'indikasi' => $subject,
            'status' => '11', // Status 11 = Menunggu Verifikasi / Baru
            'kat_tiket' => $katTiket,
            'nomor_hp' => $customer->phone ?: ($customer->pelanggan?->nomor_hp ?? ''),
            'is_group' => '2',
            'group_wa' => null,
            'note' => 'Dikirim dari Portal Pelanggan Website',
            'date_create' => now(),
            'user_create' => 'Portal Pelanggan',
            'hide' => null,
        ]);

        $successMsg = match ($katTiket) {
            '12' => "Permintaan Ubah Password WiFi (#{$ticket->tiket}) berhasil dikirim ke sistem IMS! Tim teknisi NOC kami akan segera memperbarui konfigurasi modem ONT Anda.",
            '13' => "Pengajuan Relokasi Alamat (#{$ticket->tiket}) berhasil dikirim ke sistem IMS! Tim survei kami akan segera menghubungi Anda.",
            '14', '15' => "Permohonan administrasi layanan (#{$ticket->tiket}) berhasil dikirim ke sistem IMS! Tim kami akan segera menindaklanjuti.",
            default => "Laporan gangguan #{$ticket->tiket} berhasil dikirim ke sistem IMS! Tim teknisi NOC kami akan segera menindaklanjuti.",
        };

        return redirect()->route('portal.tickets.show', $ticket->tiket)
            ->with('success', $successMsg);
    }

    /**
     * Tampilkan detail laporan gangguan & pelacakan status
     */
    public function show($id)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        if (str_starts_with($id, 'UB-')) {
            $ticket = $customer->ubahLayanan()->where('kode_trx_ubah_layanan', $id)->firstOrFail();
        } else {
            $ticket = $customer->tickets()->where('tiket', $id)->first()
                ?: $customer->ubahLayanan()->where('kode_trx_ubah_layanan', $id)->firstOrFail();
        }

        return view('portal.tickets.show', compact('ticket', 'customer'));
    }

    /**
     * Tampilkan / stream gambar bukti screenshot yang diupload oleh NOC
     */
    public function showImage($filename)
    {
        $filename = basename($filename);

        $possibleDirs = [
            public_path('storage'),
            public_path('storage/ubah_layanan'),
            public_path('storage/proof-mutations'),
            public_path('uploads'),
            public_path('uploads/ubah_layanan'),
            public_path('assets/images'),
            public_path('images'),
            storage_path('app/public'),
            storage_path('app/public/proof-mutations'),
            storage_path('app/public/ubah_layanan'),
            'c:/xampp/htdocs/ims-new/public/storage/proof-mutations',
            'c:/xampp/htdocs/ims-new/storage/app/public/proof-mutations',
            'c:/xampp/htdocs/ims-new/storage/app/public',
            'c:/xampp/htdocs/ims-new/public/uploads',
            'c:/xampp/htdocs/ims2/public/uploads',
            'c:/xampp/htdocs/ims2/public/assets/images',
            'c:/xampp/htdocs/imscjp/storage/app/public',
            'c:/xampp/htdocs/adamjaya/public/uploads',
        ];

        foreach ($possibleDirs as $dir) {
            $fullPath = $dir . '/' . $filename;
            if (file_exists($fullPath) && is_file($fullPath)) {
                $mime = mime_content_type($fullPath) ?: 'image/jpeg';
                return response()->file($fullPath, [
                    'Content-Type' => $mime,
                    'Cache-Control' => 'public, max-age=86400',
                ]);
            }
        }

        // Jika ada konfigurasi URL server IMS terpusat
        $remoteBase = env('IMS_ASSETS_URL') ?: env('IMS_BASE_URL');
        if ($remoteBase) {
            return redirect(rtrim($remoteBase, '/') . '/' . $filename);
        }

        abort(404, 'Foto SS bukti NOC tidak ditemukan di direktori server lokal.');
    }
}

