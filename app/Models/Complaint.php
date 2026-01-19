<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $guarded = [];

    public function getStatusLabelAttribute() //status_label
    {
        return match ($this->status)
        {
            'new' => 'Baru',
            'processing' => 'Sedang diproses',
            'completed' => 'Selesai',
            default => 'Tidak Diketahui',
        };
    }

    public function getReportDateLabelAttribute() //report_date_label
    {
        return \Carbon\Carbon::parse($this->report_date)->format('d M Y, H:i:s');
    }

    public function getStatusColorAttribute()//status-color
    {
        return match ($this->status)
        {
            'new' => 'info',
            'processing' => 'warning',
            'completed' => 'success',
            default => 'secondary',
        };
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
