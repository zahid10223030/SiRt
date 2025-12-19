<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16);
            $table->string('nama', 100);
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir', 100);
            $table->text('alamat');
            $table->string('agama', 50)->nullable();
            $table->enum('status_perkawinan', ['belum_menikah', 'menikah', 'cerai_hidup', 'cerai_mati']);
            $table->string('pekerjaan', 100)->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->enum('status', ['aktif', 'pindah', 'meninggal'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
