<?php

namespace App\Models\Ims;

use Illuminate\Database\Eloquent\Model;

class TiketGangguan extends Model
{
    protected $connection = 'ims';
    protected $table = 'trx_tiket_gangguan';
    protected $primaryKey = 'tiket';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Relasi ke nomor internet pendaftaran
     */
    public function batchjobRegister()
    {
        return $this->belongsTo(BatchjobRegister::class, 'nomor_internet', 'nomor_internet');
    }
}
