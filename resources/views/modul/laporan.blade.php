@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Manajemen Laporan</h3>
        <button class="btn btn-gradient px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahLaporanModal">
            <i class="bi bi-plus-circle"></i> Buat Laporan
        </button>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card stat-card card-total p-3">
                <h5>Total Laporan</h5>
                <h2 class="fw-bold">{{ $data->count() }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card card-aktif p-3">
                <h5>Inventory</h5>
                <h2 class="fw-bold">{{ $data->where('jenis_laporan', 'Inventory')->count() }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card card-expired p-3">
                <h5>Maintenance</h5>
                <h2 class="fw-bold">{{ $data->where('jenis_laporan', 'Maintenance')->count() }}</h2>
            </div>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0 text-secondary">Daftar Laporan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Judul Laporan</th>
                            <th>Jenis Laporan</th>
                            <th>Periode</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $d)
                        <tr>
                            <td class="fw-bold">{{ $d->judul_laporan }}</td>
                            <td>
                                @if($d->jenis_laporan == 'Inventory')
                                    <span class="badge bg-primary">Inventory</span>
                                @elseif($d->jenis_laporan == 'Keuangan')
                                    <span class="badge bg-success">Keuangan</span>
                                @else
                                    <span class="badge bg-warning text-dark">Maintenance</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($d->periode_awal)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($d->periode_akhir)->format('d M Y') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editLaporanModal{{ $d->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('modul6.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada laporan yang dibuat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="tambahLaporanModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('modul6.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Buat Laporan Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Laporan</label>
                            <input type="text" name="judul_laporan" class="form-control" placeholder="Contoh: Laporan Bulanan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Laporan (Dropdown)</label>
                            <select name="jenis_laporan" class="form-select">
                                <option value="Inventory">Inventory</option>
                                <option value="Keuangan">Keuangan</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Periode Awal</label>
                                <input type="date" name="periode_awal" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Periode Akhir</label>
                                <input type="date" name="periode_akhir" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($data as $d)
    <div class="modal fade" id="editLaporanModal{{ $d->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('modul6.update', $d->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Laporan</label>
                            <input type="text" name="judul_laporan" class="form-control" value="{{ $d->judul_laporan }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Laporan (Dropdown)</label>
                            <select name="jenis_laporan" class="form-select">
                                <option value="Inventory" {{ $d->jenis_laporan == 'Inventory' ? 'selected' : '' }}>Inventory</option>
                                <option value="Keuangan" {{ $d->jenis_laporan == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                                <option value="Maintenance" {{ $d->jenis_laporan == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Periode Awal</label>
                                <input type="date" name="periode_awal" class="form-control" value="{{ $d->periode_awal }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Periode Akhir</label>
                                <input type="date" name="periode_akhir" class="form-control" value="{{ $d->periode_akhir }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endsection