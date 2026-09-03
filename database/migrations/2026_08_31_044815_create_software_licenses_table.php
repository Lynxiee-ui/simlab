<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('software_licenses', function (Blueprint $table) {
            $table->id();
            $table->string('nama_software');
            $table->string('lisensi_key')->nullable();
            $table->enum('tipe_lisensi', ['Bulanan', 'Tahunan', 'Perpetual'])->default('Tahunan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->enum('status', ['Aktif', 'Menjelang Expired', 'Non-Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('software_licenses'); }
};