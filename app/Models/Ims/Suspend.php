<?php

namespace App\Models\Ims;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Suspend extends Model
{
    protected $connection = 'ims';
    protected $table = 'trx_suspend';
    protected $primaryKey = 'kode_suspend';
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
        return $this->kode_suspend;
    }

    public function getTiketAttribute()
    {
        return $this->kode_suspend;
    }

    public function getTicketNumberAttribute()
    {
        return $this->kode_suspend;
    }

    public function getKatTiketAttribute()
    {
        return '15';
    }

    public function getCategoryLabelAttribute(): string
    {
        return 'Request Suspend';
    }

    public function getSubjectAttribute()
    {
        $startStr = $this->suspend_start ? Carbon::parse($this->suspend_start)->isoFormat('D MMM Y') : null;
        return "Pengajuan Request Suspend Layanan" . ($startStr ? " (Mulai {$startStr})" : " Sementara");
    }

    public function getDescriptionAttribute()
    {
        return $this->desc_suspend;
    }

    public function getStatusAttribute($value)
    {
        return $this->status_suspend;
    }

    public function getStatusLabelAttribute(): string
    {
        $st = (string) $this->status_suspend;
        return match ($st) {
            '11' => 'Req. Suspend (Menunggu Verifikasi)',
            '12' => 'Suspend Aktif',
            '18' => 'Req. Unsuspend',
            '13' => 'Selesai (Unsuspend)',
            '14' => 'Cancel Suspend',
            '15', '16' => 'Dialihkan ke Terminasi',
            default => 'Req. Suspend',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        $st = (string) $this->status_suspend;
        return match ($st) {
            '13' => 'bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-xs',
            '12' => 'bg-rose-50 text-rose-700 border border-rose-200 shadow-xs',
            '18' => 'bg-sky-50 text-sky-700 border border-sky-200 shadow-xs',
            '14' => 'bg-slate-50 text-slate-700 border border-slate-200 shadow-xs',
            default => 'bg-amber-50 text-amber-700 border border-amber-200 shadow-xs',
        };
    }

    public function getTechnicianNameAttribute()
    {
        return $this->user_update ?: ($this->desc_suspend_cancel ? 'Tim Layanan & NOC PT MSN' : null);
    }

    public function getResolutionNotesAttribute()
    {
        return $this->desc_suspend_cancel ?: null;
    }

    public function getSolusiAttribute()
    {
        return $this->desc_suspend_cancel ?: null;
    }

    public function getPenangananAttribute()
    {
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
