<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resident_id');
            $table->enum('type', [
                'surat_keterangan',
                'surat_izin',
                'surat_rekomendasi',
                'surat_pengantar'
            ]);
            $table->string('purpose');
            $table->text('content')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable(); // untuk catatan admin saat approve/reject
            $table->string('file_path')->nullable(); // untuk file surat yang sudah jadi
            $table->timestamp('processed_at')->nullable(); // tanggal diproses admin
            $table->timestamps();

            // Foreign key ke residents
            $table->foreign('resident_id')
                  ->references('id')
                  ->on('residents')
                  ->onDelete('cascade');
            
            // Index untuk performa
            $table->index('resident_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};