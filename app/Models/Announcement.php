<?php
// [file name]: Announcement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Announcement extends Model
{
    protected $guarded = [];

    public function getCreatedAtLabelAttribute()
    {
        return Carbon::parse($this->created_at)->format('d M Y, H:i');
    }

    public function getShortContentAttribute()
    {
        return strlen($this->content) > 100 
            ? substr($this->content, 0, 100) . '...'
            : $this->content;
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo 
            ? asset('storage/' . $this->photo)
            : null;
    }
}