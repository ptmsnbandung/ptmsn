<?php

namespace App\Models\Ims;

use Illuminate\Database\Eloquent\Model;

class BatchjobRegister extends Model
{
    protected $connection = 'ims';
    protected $table = 'trx_batchjob_register';
    protected $primaryKey = 'nomor_internet';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Relasi ke data biodata penduduk / pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'nik_penduduk', 'nik_penduduk');
    }

    /**
     * Relasi ke paket bandwidth
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
        return $this->hasMany(TiketGangguan::class, 'nomor_internet', 'nomor_internet');
    }
}
