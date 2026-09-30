<?php

namespace App\Models\Ims;

use Illuminate\Database\Eloquent\Model;

class StatusRegistrasi extends Model
{
    protected $connection = 'ims';
    protected $table = 'm_status_registrasi';
    protected $primaryKey = 'status_reg';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];
}
