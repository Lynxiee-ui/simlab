<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoftwareLicense;
use App\Models\PengajuanKebutuhan;
use App\Models\JadwalPemeliharaan; // Tambahkan model ini
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
        // ================= DASHBOARD =================
    public function dashboard() {
        // Mengambil jumlah data dari setiap modul
        $totalLisensi = \App\Models\SoftwareLicense::count();
        $totalPengajuan = \App\Models\PengajuanKebutuhan::count();
        $totalJadwal = \App\Models\JadwalPemeliharaan::count();
        $totalLaporan = \App\Models\Laporan::count();
        $totalSop = \App\Models\SopDokumen::count();

        // Mengambil data terbaru untuk ditampilkan (opsional)
        $latestPengajuan = \App\Models\PengajuanKebutuhan::latest()->take(5)->get();
        $latestLisensi = \App\Models\SoftwareLicense::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalLisensi', 'totalPengajuan', 'totalJadwal', 'totalLaporan', 'totalSop',
            'latestPengajuan', 'latestLisensi'
        ));
    }
    // ================= MODUL 2 (Lisensi) =================
    public function indexLisensi() {
        $data = SoftwareLicense::all();
        return view('modul.lisensi', compact('data'));
    }

    public function storeLisensi(Request $request) {
        $request->validate([
            'nama' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_berakhir' => 'required',
        ]);

        SoftwareLicense::create([
            'nama_software' => $request->nama,
            'lisensi_key' => $request->lisensi_key,
            'tipe_lisensi' => $request->tipe_lisensi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => $request->status,
        ]);

        return redirect()->route('modul2.lisensi')->with('success', 'Lisensi berhasil ditambahkan!');
    }

    public function updateLisensi(Request $request, $id) {
        $request->validate([
            'nama' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_berakhir' => 'required',
        ]);

        $lisensi = SoftwareLicense::findOrFail($id);
        $lisensi->update([
            'nama_software' => $request->nama,
            'lisensi_key' => $request->lisensi_key,
            'tipe_lisensi' => $request->tipe_lisensi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => $request->status,
        ]);

        return redirect()->route('modul2.lisensi')->with('success', 'Lisensi berhasil diperbarui!');
    }

    public function destroyLisensi($id) {
        $lisensi = SoftwareLicense::findOrFail($id);
        $lisensi->delete();

        return redirect()->route('modul2.lisensi')->with('success', 'Lisensi berhasil dihapus!');
    }

    // ================= MODUL 3 (Pengajuan) =================
    public function indexPengajuan() {
        $data = PengajuanKebutuhan::all();
        return view('modul.pengajuan', compact('data'));
    }

    public function storePengajuan(Request $request) {
        $request->validate([
            'nama_pemohon' => 'required',
            'spesifikasi' => 'required',
            'alasan' => 'required',
        ]);

        PengajuanKebutuhan::create([
            'nama_pemohon' => $request->nama_pemohon,
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'spesifikasi' => $request->spesifikasi,
            'alasan' => $request->alasan,
            'status' => 'Pending',
        ]);

        return redirect()->route('modul3.pengajuan')->with('success', 'Pengajuan berhasil dibuat!');
    }

    public function updatePengajuan(Request $request, $id) {
        $request->validate([
            'nama_pemohon' => 'required',
            'spesifikasi' => 'required',
            'alasan' => 'required',
        ]);

        $pengajuan = PengajuanKebutuhan::findOrFail($id);
        $pengajuan->update([
            'nama_pemohon' => $request->nama_pemohon,
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'spesifikasi' => $request->spesifikasi,
            'alasan' => $request->alasan,
        ]);

        return redirect()->route('modul3.pengajuan')->with('success', 'Data pengajuan berhasil diperbarui!');
    }

    public function updateStatusPengajuan(Request $request, $id) {
        $pengajuan = PengajuanKebutuhan::findOrFail($id);
        $pengajuan->update([
            'status' => $request->status
        ]);

        return redirect()->route('modul3.pengajuan')->with('success', 'Status pengajuan berhasil diubah!');
    }

    public function destroyPengajuan($id) {
        $pengajuan = PengajuanKebutuhan::findOrFail($id);
        $pengajuan->delete();

        return redirect()->route('modul3.pengajuan')->with('success', 'Pengajuan berhasil dihapus!');
    }

    // ================= MODUL 5 (Jadwal Pemeliharaan) =================
    public function indexJadwal() {
        $data = JadwalPemeliharaan::all();
        return view('modul.jadwal', compact('data'));
    }

    public function storeJadwal(Request $request) {
        $request->validate([
            'nama_aset' => 'required',
            'tanggal_pelaksanaan' => 'required',
            'petugas' => 'required',
        ]);

        JadwalPemeliharaan::create([
            'nama_aset' => $request->nama_aset,
            'jenis' => $request->jenis,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'petugas' => $request->petugas,
            'catatan' => $request->catatan,
            'status' => 'Terjadwal',
        ]);

        return redirect()->route('modul5.jadwal')->with('success', 'Jadwal pemeliharaan berhasil dibuat!');
    }

    public function updateJadwal(Request $request, $id) {
        $request->validate([
            'nama_aset' => 'required',
            'tanggal_pelaksanaan' => 'required',
            'petugas' => 'required',
        ]);

        $jadwal = JadwalPemeliharaan::findOrFail($id);
        $jadwal->update([
            'nama_aset' => $request->nama_aset,
            'jenis' => $request->jenis,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'petugas' => $request->petugas,
            'catatan' => $request->catatan,
            'status' => $request->status,
        ]);

        return redirect()->route('modul5.jadwal')->with('success', 'Jadwal pemeliharaan berhasil diperbarui!');
    }

    public function destroyJadwal($id) {
        $jadwal = JadwalPemeliharaan::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('modul5.jadwal')->with('success', 'Jadwal pemeliharaan berhasil dihapus!');
    }


    // ================= MODUL 6: LAPORAN =================

    public function indexLaporan() {
        $data = \App\Models\Laporan::all();
        return view('modul.laporan', compact('data'));
    }

    public function storeLaporan(Request $request) {
        $request->validate([
            'judul_laporan' => 'required',
            'jenis_laporan' => 'required',
            'periode_awal' => 'required',
            'periode_akhir' => 'required',
        ]);

        \App\Models\Laporan::create([
            'judul_laporan' => $request->judul_laporan,
            'jenis_laporan' => $request->jenis_laporan,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
        ]);

        return redirect()->route('modul6.laporan')->with('success', 'Laporan berhasil dibuat!');
    }

    public function updateLaporan(Request $request, $id) {
        $request->validate([
            'judul_laporan' => 'required',
            'jenis_laporan' => 'required',
            'periode_awal' => 'required',
            'periode_akhir' => 'required',
        ]);

        $laporan = \App\Models\Laporan::findOrFail($id);
        $laporan->update([
            'judul_laporan' => $request->judul_laporan,
            'jenis_laporan' => $request->jenis_laporan,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
        ]);

        return redirect()->route('modul6.laporan')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroyLaporan($id) {
        $laporan = \App\Models\Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('modul6.laporan')->with('success', 'Laporan berhasil dihapus!');
    }

        // ================= MODUL 7: SOP & DOKUMEN =================

    public function indexSop() {
        $data = \App\Models\SopDokumen::all();
        return view('modul.sop', compact('data'));
    }

    public function storeSop(Request $request) {
        $request->validate([
            'judul_dokumen' => 'required',
            'kategori' => 'required',
            'versi' => 'required',
            'file' => 'required|mimes:pdf,doc,docx|max:2048', // Maks 2MB
        ]);

        // Simpan file ke folder public/storage
        $filePath = $request->file('file')->store('sop_dokumen', 'public');

        \App\Models\SopDokumen::create([
            'judul_dokumen' => $request->judul_dokumen,
            'kategori' => $request->kategori,
            'versi' => $request->versi,
            'file_path' => $filePath,
        ]);

        return redirect()->route('modul7.sop')->with('success', 'Dokumen SOP berhasil diupload!');
    }

    public function updateSop(Request $request, $id) {
        $sop = \App\Models\SopDokumen::findOrFail($id);
        
        $request->validate([
            'judul_dokumen' => 'required',
            'kategori' => 'required',
            'versi' => 'required',
        ]);

        $dataUpdate = [
            'judul_dokumen' => $request->judul_dokumen,
            'kategori' => $request->kategori,
            'versi' => $request->versi,
        ];

        // Jika user upload file baru
        if ($request->hasFile('file')) {
            $request->validate(['file' => 'mimes:pdf,doc,docx|max:2048']);
            // Hapus file lama
            Storage::disk('public')->delete($sop->file_path);
            // Simpan file baru
            $dataUpdate['file_path'] = $request->file('file')->store('sop_dokumen', 'public');
        }

        $sop->update($dataUpdate);
        return redirect()->route('modul7.sop')->with('success', 'Dokumen SOP berhasil diperbarui!');
    }

    public function destroySop($id) {
        $sop = \App\Models\SopDokumen::findOrFail($id);
        Storage::disk('public')->delete($sop->file_path);
        $sop->delete();

        return redirect()->route('modul7.sop')->with('success', 'Dokumen SOP berhasil dihapus!');
    }

    public function downloadSop($id) {
        $sop = \App\Models\SopDokumen::findOrFail($id);
        return Storage::disk('public')->download($sop->file_path);
    }
}