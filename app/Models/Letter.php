<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $guarded = [];

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Tidak Diketahui',
        };
    }

    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            'surat_keterangan' => 'Surat Keterangan',
            'surat_izin' => 'Surat Izin',
            'surat_rekomendasi' => 'Surat Rekomendasi',
            'surat_pengantar' => 'Surat Pengantar',
            default => 'Surat',
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }

    public function getRequestDateLabelAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->format('d M Y, H:i:s');
    }

    public function getProcessedDateLabelAttribute()
    {
        return $this->processed_at 
            ? \Carbon\Carbon::parse($this->processed_at)->format('d M Y, H:i:s')
            : 'Belum diproses';
    }

    // Relasi ke resident
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}