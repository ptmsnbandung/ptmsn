<?php

namespace App\Models\Ims;

use Illuminate\Database\Eloquent\Model;

class BillingLayananDetail extends Model
{
    protected $connection = 'ims';
    protected $table = 'trx_billing_layanan_detail';
    protected $primaryKey = 'kode_billing_lay_detail';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];
}
