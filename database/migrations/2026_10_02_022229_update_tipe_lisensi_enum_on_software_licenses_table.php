<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah ENUM untuk menambahkan opsi 'Gratis'
        DB::statement("ALTER TABLE software_licenses MODIFY COLUMN tipe_lisensi ENUM('Bulanan', 'Tahunan', 'Perpetual', 'Gratis') DEFAULT 'Tahunan'");
    }

    public function down(): void
    {
        // Kembalikan ke ENUM awal
        DB::statement("ALTER TABLE software_licenses MODIFY COLUMN tipe_lisensi ENUM('Bulanan', 'Tahunan', 'Perpetual') DEFAULT 'Tahunan'");
    }
};