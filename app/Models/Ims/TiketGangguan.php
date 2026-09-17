<?php

namespace App\Models\Ims;

use App\Models\Customer;
use Carbon\Carbon;
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
     * Relasi ke nomor internet pelanggan
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'nomor_internet', 'nomor_internet');
    }

    public function getIdAttribute()
    {
        return $this->tiket;
    }

    public function getTicketNumberAttribute()
    {
        return $this->tiket;
    }

    public function getSubjectAttribute()
    {
        return $this->indikasi ?: ($this->keluhan ? \Illuminate\Support\Str::limit($this->keluhan, 60) : 'Laporan Gangguan');
    }

    public function getDescriptionAttribute()
    {
        return $this->keluhan;
    }

    public function getCategoryAttribute()
    {
        return $this->kat_tiket;
    }

    public function getPriorityAttribute(): string
    {
        return 'Normal';
    }

    public function getPhotoPathAttribute()
    {
        return null;
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ((string) $this->kat_tiket) {
            '11' => 'Gangguan Layanan',
            '12' => 'Ubah Password',
            '13' => 'Cek Coverage Area',
            '14' => 'Terminasi',
            '15' => 'Suspend Layanan',
            '16' => 'Pemasangan Baru',
            '17' => 'Ubah Layanan',
            default => $this->kat_tiket ?: 'Gangguan Layanan',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        $st = (string) $this->status;
        if ($st === '13' || $st === '14' || $st === 'resolved' || $st === 'done' || $st === 'close' || $st === 'closed') {
            return 'Selesai';
        }
        if ($st === '12' || $st === 'in_progress' || $st === 'proses' || $st === 'konfirmasi') {
            return 'Sedang Ditangani';
        }
        return 'Menunggu Verifikasi';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        $st = (string) $this->status;
        if ($st === '13' || $st === '14' || $st === 'resolved' || $st === 'done' || $st === 'close' || $st === 'closed') {
            return 'bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-xs';
        }
        if ($st === '12' || $st === 'in_progress' || $st === 'proses' || $st === 'konfirmasi') {
            return 'bg-sky-50 text-sky-700 border border-sky-200 shadow-xs';
        }
        return 'bg-amber-50 text-amber-700 border border-amber-200 shadow-xs';
    }

    public function getTechnicianNameAttribute()
    {
        if (!empty($this->user_update)) {
            return trim($this->user_update);
        }
        if (!empty($this->solusi) || !empty($this->penanganan)) {
            return 'Tim NOC PT MSN';
        }
        return null;
    }

    public function getResolutionNotesAttribute()
    {
        if (!empty($this->solusi)) {
            return trim($this->solusi);
        }
        if (!empty($this->penanganan)) {
            return trim($this->penanganan);
        }
        if (!empty($this->tindakan)) {
            return trim($this->tindakan);
        }
        if (!empty($this->note) && $this->note !== 'Dikirim dari Portal Pelanggan Website') {
            return trim($this->note);
        }
        return null;
    }

    public function getCreatedAtAttribute()
    {
        return !empty($this->date_create) ? Carbon::parse($this->date_create) : now();
    }

    public function getResolvedAtAttribute()
    {
        return !empty($this->date_update) ? Carbon::parse($this->date_update) : null;
    }
}
