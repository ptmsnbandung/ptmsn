<?php

namespace App\Models\Ims;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class UbahLayanan extends Model
{
    protected $connection = 'ims';
    protected $table = 'trx_ubah_layanan';
    protected $primaryKey = 'kode_trx_ubah_layanan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'nomor_internet', 'nomor_internet');
    }

    public function bandwithLama()
    {
        return $this->belongsTo(Bandwith::class, 'kode_bandwith_lama', 'kode_bandwith');
    }

    public function bandwithBaru()
    {
        return $this->belongsTo(Bandwith::class, 'kode_bandwith_baru', 'kode_bandwith');
    }
}
