<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('judul_laporan');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->string('foto_bukti')->nullable();
            $table->foreignId('status_laporan_id')->constrained('status_laporan')->onDelete('restrict');
            $table->timestamp('tanggal_lapor')->useCurrent();
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->text('catatan_petugas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
