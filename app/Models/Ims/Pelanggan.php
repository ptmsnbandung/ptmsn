<?php

namespace App\Models\Ims;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $connection = 'ims';
    protected $table = 'm_pelanggan';
    protected $primaryKey = 'nik_penduduk';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Relasi ke pendaftaran batchjob internet pelanggan
     */
    public function batchjobRegisters()
    {
        return $this->hasMany(BatchjobRegister::class, 'nik_penduduk', 'nik_penduduk');
    }
}
