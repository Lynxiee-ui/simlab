<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = ['judul_laporan', 'jenis_laporan', 'periode_awal', 'periode_akhir'];
}