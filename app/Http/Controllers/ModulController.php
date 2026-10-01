<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoftwareLicense;
use App\Models\PengajuanKebutuhan;
use App\Models\JadwalPemeliharaan;
use App\Models\Laporan;
use App\Models\SopDokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ModulController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard() {
        $totalLisensi = SoftwareLicense::count();
        $totalPengajuan = PengajuanKebutuhan::count();
        $totalJadwal = JadwalPemeliharaan::count();
        $totalLaporan = Laporan::count();
        $totalSop = SopDokumen::count();

        $latestPengajuan = PengajuanKebutuhan::latest()->take(5)->get();
        $latestLisensi = SoftwareLicense::latest()->take(5)->get();
        $latestJadwal = JadwalPemeliharaan::latest()->take(5)->get();
        $latestLaporan = Laporan::latest()->take(5)->get();
        $latestSop = SopDokumen::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalLisensi', 'totalPengajuan', 'totalJadwal', 'totalLaporan', 'totalSop',
            'latestPengajuan', 'latestLisensi', 'latestJadwal', 'latestLaporan', 'latestSop'
        ));
    }

    // ================= MODUL 2: LISENSI =================
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
            'ruangan' => $request->ruangan,
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
            'ruangan' => $request->ruangan,
            'lisensi_key' => $request->lisensi_key,
            'tipe_lisensi' => $request->tipe_lisensi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => $request->status,
        ]);

        return redirect()->route('modul2.lisensi')->with('success', 'Lisensi berhasil diperbarui!');
    }

    public function destroyLisensi($id) {
        SoftwareLicense::findOrFail($id)->delete();
        return redirect()->route('modul2.lisensi')->with('success', 'Lisensi berhasil dihapus!');
    }

    // ================= MODUL 3: PENGAJUAN =================
    public function indexPengajuan() {
        $data = PengajuanKebutuhan::latest()->get();
        return view('modul.pengajuan', compact('data'));
    }

    public function storePengajuan(Request $request) {
        $request->validate([
            'spesifikasi' => 'required',
            'alasan' => 'required',
        ]);

        PengajuanKebutuhan::create([
            'user_id' => auth()->id(),
            'nama_pemohon' => auth()->user()->name,
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
        // Validasi: pastikan status dan alasan tidak kosong
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'alasan_verifikasi' => 'required|string|min:3',
        ]);

        $pengajuan = PengajuanKebutuhan::findOrFail($id);
        $pengajuan->update([
            'status' => $request->status,
            'alasan_verifikasi' => $request->alasan_verifikasi,
        ]);

        return redirect()->route('modul3.pengajuan')->with('success', 'Status pengajuan berhasil diubah menjadi: ' . $request->status);
    }

    public function destroyPengajuan($id) {
        PengajuanKebutuhan::findOrFail($id)->delete();
        return redirect()->route('modul3.pengajuan')->with('success', 'Pengajuan berhasil dihapus!');
    }

    // ================= MODUL 5: JADWAL =================
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

        return redirect()->route('modul5.jadwal')->with('success', 'Jadwal berhasil dibuat!');
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

        return redirect()->route('modul5.jadwal')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroyJadwal($id) {
        JadwalPemeliharaan::findOrFail($id)->delete();
        return redirect()->route('modul5.jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }

    // ================= MODUL 6: LAPORAN =================
    public function indexLaporan() {
        $data = Laporan::all();
        return view('modul.laporan', compact('data'));
    }

    public function storeLaporan(Request $request) {
        $request->validate([
            'judul_laporan' => 'required',
            'jenis_laporan' => 'required',
            'periode_awal' => 'required',
            'periode_akhir' => 'required',
        ]);

        Laporan::create([
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

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'judul_laporan' => $request->judul_laporan,
            'jenis_laporan' => $request->jenis_laporan,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
        ]);

        return redirect()->route('modul6.laporan')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroyLaporan($id) {
        Laporan::findOrFail($id)->delete();
        return redirect()->route('modul6.laporan')->with('success', 'Laporan berhasil dihapus!');
    }

    // ================= MODUL 7: SOP =================
    public function indexSop() {
        $data = SopDokumen::all();
        return view('modul.sop', compact('data'));
    }

    public function storeSop(Request $request) {
        $request->validate([
            'judul_dokumen' => 'required',
            'kategori' => 'required',
            'versi' => 'required',
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $request->file('file')->store('sop_dokumen', 'public');

        SopDokumen::create([
            'judul_dokumen' => $request->judul_dokumen,
            'kategori' => $request->kategori,
            'versi' => $request->versi,
            'file_path' => $filePath,
        ]);

        return redirect()->route('modul7.sop')->with('success', 'Dokumen SOP berhasil diupload!');
    }

    public function updateSop(Request $request, $id) {
        $sop = SopDokumen::findOrFail($id);
        
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

        if ($request->hasFile('file')) {
            $request->validate(['file' => 'mimes:pdf,doc,docx|max:2048']);
            Storage::disk('public')->delete($sop->file_path);
            $dataUpdate['file_path'] = $request->file('file')->store('sop_dokumen', 'public');
        }

        $sop->update($dataUpdate);
        return redirect()->route('modul7.sop')->with('success', 'Dokumen SOP berhasil diperbarui!');
    }

    public function destroySop($id) {
        $sop = SopDokumen::findOrFail($id);
        Storage::disk('public')->delete($sop->file_path);
        $sop->delete();
        return redirect()->route('modul7.sop')->with('success', 'Dokumen SOP berhasil dihapus!');
    }

    public function downloadSop($id) {
        $sop = SopDokumen::findOrFail($id);
        return Storage::disk('public')->download($sop->file_path);
    }
}