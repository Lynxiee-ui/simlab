@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Dashboard SIMLAB</h3>
            <p class="text-muted">Ringkasan data sistem informasi laboratorium</p>
        </div>
    </div>

    <!-- Kartu Statistik Utama -->
    <div class="row g-4 mb-4">
        <div class="col-md-4 col-lg-2">
            <div class="card stat-card card-total p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Lisensi</h6>
                        <h2 class="fw-bold mt-2">{{ $totalLisensi }}</h2>
                        <small>Modul 2</small>
                    </div>
                    <i class="bi bi-key fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="card stat-card card-aktif p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Pengajuan</h6>
                        <h2 class="fw-bold mt-2">{{ $totalPengajuan }}</h2>
                        <small>Modul 3</small>
                    </div>
                    <i class="bi bi-file-earmark-text fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="card stat-card card-expired p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Jadwal</h6>
                        <h2 class="fw-bold mt-2">{{ $totalJadwal }}</h2>
                        <small>Modul 5</small>
                    </div>
                    <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="card stat-card card-none p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Laporan</h6>
                        <h2 class="fw-bold mt-2">{{ $totalLaporan }}</h2>
                        <small>Modul 6</small>
                    </div>
                    <i class="bi bi-graph-up-arrow fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="card stat-card p-3 h-100" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">SOP</h6>
                        <h2 class="fw-bold mt-2">{{ $totalSop }}</h2>
                        <small>Modul 7</small>
                    </div>
                    <i class="bi bi-folder2-open fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Terbaru -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-secondary">Lisensi Terbaru</h5>
                    <a href="{{ route('modul2.lisensi') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Berakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestLisensi as $l)
                            <tr>
                                <td class="fw-bold">{{ $l->nama_software }}</td>
                                <td>
                                    @if($l->status == 'Aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($l->status == 'Menjelang Expired')
                                        <span class="badge bg-warning text-dark">Expired</span>
                                    @else
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>{{ $l->tanggal_berakhir }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-secondary">Pengajuan Terbaru</h5>
                    <a href="{{ route('modul3.pengajuan') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Pemohon</th>
                                <th>Jenis</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestPengajuan as $p)
                            <tr>
                                <td class="fw-bold">{{ $p->nama_pemohon }}</td>
                                <td>{{ $p->jenis_kebutuhan }}</td>
                                <td>
                                    @if($p->status == 'Disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($p->status == 'Pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection