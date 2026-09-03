<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_pemeliharaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aset');
            $table->enum('jenis', ['Preventive', 'Corrective'])->default('Preventive');
            $table->date('tanggal_pelaksanaan');
            $table->string('petugas');
            $table->text('catatan')->nullable();
            $table->enum('status', ['Terjadwal', 'Selesai'])->default('Terjadwal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pemeliharaans');
    }
};