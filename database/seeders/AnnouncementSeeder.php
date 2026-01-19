<?php
// [file name]: AnnouncementSeeder.php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        Announcement::create([
            'title' => 'Pengumuman Penting RT',
            'content' => 'Akan diadakan kerja bakti pada hari Minggu, 20 Januari 2026 pukul 07.00 WIB di lingkungan RT 05.',
            'is_pinned' => true,
            'pinned_at' => now(),
        ]);

        Announcement::create([
            'title' => 'Pembagian Sembako',
            'content' => 'Pembagian sembako untuk warga kurang mampu akan dilaksanakan pada tanggal 25 Januari 2026.',
        ]);
    }
}