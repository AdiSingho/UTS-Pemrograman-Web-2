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
        Schema::create('tugas', function (Blueprint $table) {
        $table->id();
        $table->string('deskripsi'); // Untuk nama tugasnya
        $table->date('tanggal_target'); // Kapan tugas harus selesai (buat fitur laporan)
        $table->boolean('is_selesai')->default(false); // Status (Selesai/Belum)
        $table->date('tanggal_selesai')->nullable(); // Tanggal kapan tugas diselesaikan
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
