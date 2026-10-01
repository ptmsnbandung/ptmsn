<?php

namespace App\Models\Ims;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Terminasi extends Model
{
    protected $connection = 'ims';
    protected $table = 'trx_terminasi';
    protected $primaryKey = 'kode_trx_terminasi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'nomor_internet', 'nomor_internet');
    }

    public function getIdAttribute()
    {
        return $this->kode_trx_terminasi;
    }

    public function getTiketAttribute()
    {
        return $this->kode_trx_terminasi;
    }

    public function getTicketNumberAttribute()
    {
        return $this->kode_trx_terminasi;
    }

    public function getKatTiketAttribute()
    {
        return '14';
    }

    public function getCategoryLabelAttribute(): string
    {
        return 'Request Terminasi';
    }

    public function getSubjectAttribute()
    {
        $dateStr = $this->date_collect_start ? Carbon::parse($this->date_collect_start)->isoFormat('D MMM Y') : null;
        return "Pengajuan Request Terminasi Layanan" . ($dateStr ? " (Rencana: {$dateStr})" : "");
    }

    public function getDescriptionAttribute()
    {
        return $this->note_termin;
    }

    public function getStatusAttribute($value)
    {
        return $this->status_terminasi;
    }

    public function getStatusLabelAttribute(): string
    {
        $st = (string) $this->status_terminasi;
        return match ($st) {
            '11' => 'Req. Terminasi (Menunggu Verifikasi)',
            '12' => 'Collecting (Pengambilan Perangkat)',
            '12.1' => 'Reschedule Collecting',
            '13' => 'Perangkat Telah Diterima',
            '14' => 'Terminasi Selesai',
            '15' => 'Pending Terminasi',
            '16' => 'Cancel Terminasi',
            '17' => 'Req. Batal Terminasi',
            default => 'Req. Terminasi',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        $st = (string) $this->status_terminasi;
        return match ($st) {
            '14' => 'bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-xs',
            '12', '12.1', '13' => 'bg-sky-50 text-sky-700 border border-sky-200 shadow-xs',
            '16' => 'bg-slate-50 text-slate-700 border border-slate-200 shadow-xs',
            default => 'bg-amber-50 text-amber-700 border border-amber-200 shadow-xs',
        };
    }

    public function getTechnicianNameAttribute()
    {
        return $this->team_collect ?: ($this->user_update ?: ($this->note_termin_closing ? 'Tim Layanan PT MSN' : null));
    }

    public function getResolutionNotesAttribute()
    {
        return $this->note_termin_closing ?: ($this->note_collect_finish ?: ($this->note_collect_start ?: null));
    }

    public function getSolusiAttribute()
    {
        return $this->note_termin_closing ?: null;
    }

    public function getPenangananAttribute()
    {
        return $this->note_collect_start ?: ($this->note_schedule ?? null);
    }

    public function getCreatedAtAttribute()
    {
        return !empty($this->date_create) ? Carbon::parse($this->date_create) : now();
    }

    public function getResolvedAtAttribute()
    {
        return !empty($this->date_closing) ? Carbon::parse($this->date_closing) : (!empty($this->date_update) ? Carbon::parse($this->date_update) : null);
    }
}
