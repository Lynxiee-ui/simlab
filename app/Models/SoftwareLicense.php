<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareLicense extends Model
{
    protected $fillable = ['nama_software', 'ruangan', 'lisensi_key', 'tipe_lisensi', 'status'];
}