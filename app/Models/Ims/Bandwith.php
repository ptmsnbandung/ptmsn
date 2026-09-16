<?php

namespace App\Models\Ims;

use Illuminate\Database\Eloquent\Model;

class Bandwith extends Model
{
    protected $connection = 'ims';
    protected $table = 'm_bandwith';
    protected $primaryKey = 'kode_bandwith';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];
}
