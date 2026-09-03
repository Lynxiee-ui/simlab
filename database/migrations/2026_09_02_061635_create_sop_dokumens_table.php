<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sop_dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('judul_dokumen');
            $table->enum('kategori', ['SOP Operasional', 'Panduan Teknis', 'Dokumen Legal'])->default('SOP Operasional');
            $table->string('versi');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sop_dokumens');
    }
};