<?php

namespace Database\Seeders;

use App\Models\Letter;
use Illuminate\Database\Seeder;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Letter::create([
            'resident_id' => 1,
            'type' => 'surat_keterangan',
            'purpose' => 'Untuk keperluan administrasi KTP',
            'content' => 'Saya membutuhkan surat keterangan untuk mengurus KTP baru karena KTP lama hilang.',
            'status' => 'pending',
        ]);
        
        $this->command->info('Satu data surat dengan status pending berhasil ditambahkan untuk resident ID 1.');
    }
}