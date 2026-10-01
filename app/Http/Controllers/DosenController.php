<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanKebutuhan;
use App\Models\SopDokumen;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function indexModul3() {
        // Dosen hanya melihat pengajuannya sendiri
        $data = PengajuanKebutuhan::where('user_id', auth()->id())->latest()->get();
        return view('dosen.modul3', compact('data'));
    }

    public function storeModul3(Request $request) {
        $request->validate([
            'spesifikasi' => 'required',
            'alasan' => 'required',
        ]);

        PengajuanKebutuhan::create([
            'user_id' => auth()->id(),
            'nama_pemohon' => auth()->user()->name, // <-- Nama Otomatis
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'spesifikasi' => $request->spesifikasi,
            'alasan' => $request->alasan,
            'status' => 'Pending',
        ]);

        return redirect()->route('dosen.modul3')->with('success', 'Pengajuan berhasil dikirim!');
    }

    public function indexModul7() {
        $data = SopDokumen::all();
        return view('dosen.modul7', compact('data'));
    }

    public function downloadModul7($id) {
        $sop = SopDokumen::findOrFail($id);
        return Storage::disk('public')->download($sop->file_path);
    }
}