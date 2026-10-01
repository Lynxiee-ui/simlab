@extends('layouts.dosen')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Pengajuan Kebutuhan</h3>
        <button class="btn btn-success px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahPengajuanModal">
            <i class="bi bi-plus-circle"></i> Buat Pengajuan
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-4"><div class="card stat-card card-total p-3"><h5>Total</h5><h2 class="fw-bold">{{ $data->count() }}</h2></div></div>
        <div class="col-md-4"><div class="card stat-card card-aktif p-3"><h5>Disetujui</h5><h2 class="fw-bold">{{ $data->where('status', 'Disetujui')->count() }}</h2></div></div>
        <div class="col-md-4"><div class="card stat-card card-none p-3"><h5>Pending</h5><h2 class="fw-bold">{{ $data->where('status', 'Pending')->count() }}</h2></div></div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0"><h5 class="mb-0 text-secondary">Daftar Pengajuan Saya</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Spesifikasi</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Tgl Pengajuan</th>
                            <th>Alasan Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $d)
                        <tr>
                            <td>{{ $d->spesifikasi }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($d->alasan, 30) }}</td>
                            <td>
                                @if($d->status == 'Disetujui') <span class="badge bg-success">Disetujui</span>
                                @elseif($d->status == 'Pending') <span class="badge bg-warning text-dark">Pending</span>
                                @else <span class="badge bg-danger">Ditolak</span> @endif
                            </td>
                            <td>{{ $d->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $d->alasan_verifikasi ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada pengajuan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="tambahPengajuanModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('dosen.modul3.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-success text-white"><h5 class="modal-title">Buat Pengajuan Baru</h5></div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pemohon</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name ?? 'Guest' }}" readonly>
                            <small class="text-muted">Nama otomatis dari akun yang login.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Kebutuhan</label>
                            <select name="jenis_kebutuhan" class="form-select">
                                <option value="Software">Software</option>
                                <option value="Hardware">Hardware</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Spesifikasi</label>
                            <input type="text" name="spesifikasi" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alasan</label>
                            <textarea name="alasan" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-success">Kirim</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection