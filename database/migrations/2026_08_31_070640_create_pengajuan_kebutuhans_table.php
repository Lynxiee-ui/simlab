<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_kebutuhans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemohon');
            $table->enum('jenis_kebutuhan', ['Software', 'Hardware'])->default('Software');
            $table->string('spesifikasi');
            $table->text('alasan');
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_kebutuhans');
    }
};