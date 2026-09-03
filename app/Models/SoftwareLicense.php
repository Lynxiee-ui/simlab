<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SoftwareLicense extends Model {
    protected $fillable = ['nama_software', 'lisensi_key', 'tipe_lisensi', 'tanggal_mulai', 'tanggal_berakhir', 'status'];
}