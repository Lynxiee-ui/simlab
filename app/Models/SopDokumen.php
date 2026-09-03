<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SopDokumen extends Model
{
    protected $fillable = ['judul_dokumen', 'kategori', 'versi', 'file_path'];
}