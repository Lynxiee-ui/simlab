<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PengajuanKebutuhan extends Model {
    protected $fillable = ['user_id', 'nama_pemohon', 'jenis_kebutuhan', 'spesifikasi', 'alasan', 'status', 'alasan_verifikasi'];
}