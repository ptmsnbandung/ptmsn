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
     * Relasi ke tiket gangguan di IMS
     */
    public function tickets()
    {
        return $this->hasMany(TiketGangguan::class, 'nomor_internet', 'nomor_internet')->orderBy('date_create', 'desc');
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
        return $this->nama_pelanggan;
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
}
