<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPemeliharaan extends Model
{
    protected $fillable = ['nama_aset', 'jenis', 'tanggal_pelaksanaan', 'petugas', 'catatan', 'status'];
}