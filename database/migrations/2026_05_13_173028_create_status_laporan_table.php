<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_laporan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_status')->unique(); // pending, confirmed, in_progress, completed, rejected
            $table->string('label');                 // Human-readable label
            $table->string('warna')->default('secondary'); // Bootstrap color class
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_laporan');
    }
};
