<?php

namespace App\Models;

use App\Models\Ims\Bandwith;
use App\Models\Ims\Pelanggan;
use App\Models\Ims\TiketGangguan;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * Database connection khusus IMS v2
     */
    protected $connection = 'ims';

    /**
     * Tabel registrasi pelanggan di IMS
     */
    protected $table = 'trx_batchjob_register';

    /**
     * Primary key nomor internet pelanggan
     */
    protected $primaryKey = 'nomor_internet';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'pppoe_password',
        'ont_ps',
        'remember_token',
    ];

    /**
     * Relasi ke biodata penduduk / pelanggan di IMS
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'nik_penduduk', 'nik_penduduk');
    }

    /**
     * Relasi ke paket bandwidth di IMS
     */
    public function bandwith()
    {
        return $this->belongsTo(Bandwith::class, 'kode_bandwith', 'kode_bandwith');
    }

    /**
     * Relasi ke master status registrasi di IMS
     */
    public function statusRegistrasi()
    {
        return $this->belongsTo(\App\Models\Ims\StatusRegistrasi::class, 'status_reg', 'status_reg');
    }

    /**
     * Relasi ke tiket gangguan di IMS
     */
    public function tickets()
    {
        return $this->hasMany(TiketGangguan::class, 'nomor_internet', 'nomor_internet')->orderBy('date_create', 'desc');
    }

    public function ubahLayanan()
    {
        return $this->hasMany(\App\Models\Ims\UbahLayanan::class, 'nomor_internet', 'nomor_internet')->orderBy('date_create', 'desc');
    }

    public function imsTickets()
    {
        return $this->tickets();
    }

    /**
     * Relasi ke riwayat tagihan & pembayaran di database IMS (trx_billing_layanan)
     */
    public function billingLayanan()
    {
        return $this->hasMany(\App\Models\Ims\BillingLayanan::class, 'nomor_internet', 'nomor_internet')->orderBy('date_create', 'desc');
    }

    public function invoices()
    {
        return $this->billingLayanan();
    }

    // --- ACCESSOR PROPERTI AGAR SESUAI DENGAN TAMPILAN VIEW PORTAL ---

    public function getCustomerIdAttribute()
    {
        return $this->nomor_internet;
    }

    public function getNameAttribute()
    {
        $name = trim((string) ($this->nama_pelanggan ?: ($this->pelanggan?->nama_pelanggan ?? '')));
        return $name !== '' ? $name : ($this->nomor_internet ? 'Pelanggan #' . $this->nomor_internet : 'Pelanggan');
    }

    public function getInitialAttribute()
    {
        $name = trim((string) $this->name);
        if (preg_match('/[a-zA-Z0-9]/u', $name, $matches)) {
            return strtoupper($matches[0]);
        }
        return 'P';
    }

    public function getPhoneAttribute()
    {
        return $this->pelanggan?->nomor_hp ?? $this->pelanggan?->nomor_hp_2 ?? '';
    }

    public function getEmailAttribute()
    {
        return $this->pelanggan?->email ?? '';
    }

    public function getAddressAttribute()
    {
        return $this->alamat_pasang;
    }

    public function getStatusAttribute()
    {
        return ($this->is_suspend == '1' || $this->is_suspend == '0' || empty($this->is_suspend)) ? 'active' : 'suspended';
    }

    /**
     * Deskripsi status registrasi dari tabel m_status_registrasi kolom desc_registrasi
     */
    public function getStatusRegLabelAttribute()
    {
        if ($this->statusRegistrasi && !empty($this->statusRegistrasi->desc_registrasi)) {
            return $this->statusRegistrasi->desc_registrasi;
        }

        // Fallback jika belum ter-join / nilai status_reg numerik
        $statusReg = (string) ($this->status_reg ?? '');
        return match($statusReg) {
            '20' => 'Aktif',
            '11' => 'Menunggu verifikasi',
            '11.1' => 'Belum Valid',
            '12' => 'Data Input',
            '13' => 'Jadwal Survey Terbit',
            '13.1' => 'Reschedule Survey',
            '14' => 'Tidak Tercover Jaringan',
            '15' => 'Batal Pasang',
            '16' => 'Selesai Survey',
            '17' => 'Jadwal Instalasi Terbit',
            '17.1' => 'Reschedule Instalasi',
            '18' => 'Selesai Instalasi',
            '19' => 'Jadwal Aktivasi Terbit',
            '19.1' => 'Reschedule Aktivasi',
            '21' => 'Suspend',
            '21.1' => 'Req. Suspend',
            '22' => 'Re-update',
            '23' => 'Terminasi',
            '23.1' => 'Req. Terminasi',
            default => ($this->status === 'active' ? 'Aktif' : ucfirst($this->status)),
        };
    }

    /**
     * Styling badge status registrasi di hero backdrop
     */
    public function getStatusRegBadgeClassAttribute()
    {
        $statusReg = (string) ($this->status_reg ?? '');
        return match($statusReg) {
            '20' => 'bg-emerald-950/80 border-emerald-500/50 text-emerald-300',
            '11', '11.1', '12', '13', '13.1', '16', '17', '17.1', '18', '19', '19.1', '21.1', '22' => 'bg-amber-950/80 border-amber-500/50 text-amber-300',
            '14', '15', '21', '23', '23.1' => 'bg-rose-950/80 border-rose-500/50 text-rose-300',
            default => ($this->status === 'active' ? 'bg-emerald-950/80 border-emerald-500/50 text-emerald-300' : 'bg-slate-800 border-slate-700 text-slate-300')
        };
    }

    /**
     * Styling titik indikator status registrasi
     */
    public function getStatusRegDotClassAttribute()
    {
        $statusReg = (string) ($this->status_reg ?? '');
        return match($statusReg) {
            '20' => 'bg-emerald-400 animate-pulse',
            '11', '11.1', '12', '13', '13.1', '16', '17', '17.1', '18', '19', '19.1', '21.1', '22' => 'bg-amber-400 animate-pulse',
            '14', '15', '21', '23', '23.1' => 'bg-rose-400',
            default => ($this->status === 'active' ? 'bg-emerald-400 animate-pulse' : 'bg-slate-400')
        };
    }

    public function getBillingAmountAttribute()
    {
        return (float) ($this->bandwith?->harga_bandwith ?? 250000);
    }

    public function getDueDateAttribute()
    {
        return $this->periode_billing ?? 20;
    }

    public function getBillingStatusAttribute()
    {
        $latest = $this->billingLayanan->first();
        if ($latest) {
            return $latest->is_paid ? 'paid' : 'unpaid';
        }
        return ($this->is_suspend == '2' || $this->is_suspend == '1') ? 'paid' : 'unpaid';
    }

    public function getIpAddressAttribute()
    {
        return $this->ont_us ?? '10.20.104.22';
    }

    public function getPackageAttribute()
    {
        $speedNominal = $this->bandwith?->nominal_bandwith ?? '25';
        return (object) [
            'name' => 'Broadband ' . ($this->kode_bandwith ?? 'FTTH'),
            'speed' => (is_numeric($speedNominal) ? $speedNominal . ' Mbps' : $speedNominal),
            'price' => $this->billing_amount,
        ];
    }

    /**
     * Tandai pelanggan sudah login (update is_login = 1) di database
     */
    public function markAsLoggedIn(): bool
    {
        $this->is_login = 1;
        $nomorInternet = (string) $this->nomor_internet;

        if (!$nomorInternet) {
            return false;
        }

        // 1. Update via koneksi aktif model
        try {
            $this->getConnection()->table($this->getTable())
                ->where('nomor_internet', $nomorInternet)
                ->update(['is_login' => 1]);
        } catch (\Throwable $e) {
            //
        }

        // 2. Update via Model Eloquent
        try {
            $this->save();
        } catch (\Throwable $e) {
            //
        }

        // 3. Fallback: coba semua koneksi database yang terkonfigurasi (ims, mysql, default)
        $connections = array_unique([$this->getConnectionName(), config('database.default'), 'ims', 'mysql']);
        foreach ($connections as $connName) {
            if (!$connName) continue;
            try {
                \Illuminate\Support\Facades\DB::connection($connName)
                    ->statement("UPDATE `trx_batchjob_register` SET `is_login` = 1 WHERE `nomor_internet` = ?", [$nomorInternet]);
            } catch (\Throwable $e) {
                //
            }
            try {
                \Illuminate\Support\Facades\DB::connection($connName)
                    ->table('customers')
                    ->where('customer_id', $nomorInternet)
                    ->update(['is_login' => 1]);
            } catch (\Throwable $e) {
                //
            }
        }

        return true;
    }
}

