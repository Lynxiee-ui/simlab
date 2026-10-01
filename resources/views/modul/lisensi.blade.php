@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Manajemen Lisensi Software</h3>
        <button class="btn btn-gradient px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahLisensiModal">
            <i class="bi bi-plus-circle"></i> Tambah Lisensi
        </button>
    </div>

    <div class="row">
        <div class="col-md-3"><div class="card stat-card card-total p-3"><h5>Total</h5><h2 class="fw-bold">{{ $data->count() }}</h2></div></div>
        <div class="col-md-3"><div class="card stat-card card-aktif p-3"><h5>Aktif</h5><h2 class="fw-bold">{{ $data->where('status', 'Aktif')->count() }}</h2></div></div>
        <div class="col-md-3"><div class="card stat-card card-expired p-3"><h5>Expired</h5><h2 class="fw-bold">{{ $data->where('status', 'Menjelang Expired')->count() }}</h2></div></div>
        <div class="col-md-3"><div class="card stat-card card-none p-3"><h5>Non-Aktif</h5><h2 class="fw-bold">{{ $data->where('status', 'Non-Aktif')->count() }}</h2></div></div>
    </div>

    <div class="card card-custom">
        <div class="card-header bg-white border-0 pt-3"><h5 class="mb-0 text-secondary">Daftar Software</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Software</th>
                            <th>Ruangan</th>
                            <th>Lisensi Key</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Masa Berlaku</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $d)
                        <tr>
                            <td class="fw-bold">{{ $d->nama_software }}</td>
                            <td><span class="badge bg-info">{{ $d->ruangan ?? '-' }}</span></td>
                            <td><code>{{ $d->lisensi_key }}</code></td>
                            <td><span class="badge bg-info text-dark">{{ $d->tipe_lisensi }}</span></td>
                            <td>
                                @if($d->status == 'Aktif') <span class="badge bg-success">Aktif</span>
                                @elseif($d->status == 'Menjelang Expired') <span class="badge bg-warning text-dark">Menjelang Expired</span>
                                @else <span class="badge bg-secondary">Non-Aktif</span> @endif
                            </td>
                            <td>{{ $d->tanggal_mulai }} s/d {{ $d->tanggal_berakhir }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editLisensiModal{{ $d->id }}"><i class="bi bi-pencil-square"></i></button>
                                <form action="{{ route('modul2.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data lisensi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="tambahLisensiModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('modul2.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white"><h5 class="modal-title">Tambah Lisensi Baru</h5></div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Software</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ruangan</label>
                            <input type="text" name="ruangan" class="form-control" placeholder="Contoh: Lab Komputer 1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Lisensi Key</label>
                            <input type="text" name="lisensi_key" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipe Lisensi</label>
                                <select name="tipe_lisensi" class="form-select">
                                    <option value="Bulanan">Bulanan</option>
                                    <option value="Tahunan">Tahunan</option>
                                    <option value="Perpetual">Perpetual</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Menjelang Expired">Menjelang Expired</option>
                                    <option value="Non-Aktif">Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="form-label fw-bold">Tanggal Mulai</label><input type="date" name="tanggal_mulai" class="form-control" required></div>
                            <div class="col-md-6 mb-3"><label class="form-label fw-bold">Tanggal Berakhir</label><input type="date" name="tanggal_berakhir" class="form-control" required></div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>

    @foreach($data as $d)
    <div class="modal fade" id="editLisensiModal{{ $d->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('modul2.update', $d->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header bg-warning text-dark"><h5 class="modal-title">Edit Lisensi</h5></div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Software</label>
                            <input type="text" name="nama" class="form-control" value="{{ $d->nama_software }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ruangan</label>
                            <input type="text" name="ruangan" class="form-control" value="{{ $d->ruangan }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Lisensi Key</label>
                            <input type="text" name="lisensi_key" class="form-control" value="{{ $d->lisensi_key }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipe Lisensi</label>
                                <select name="tipe_lisensi" class="form-select">
                                    <option value="Bulanan" {{ $d->tipe_lisensi == 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="Tahunan" {{ $d->tipe_lisensi == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                                    <option value="Perpetual" {{ $d->tipe_lisensi == 'Perpetual' ? 'selected' : '' }}>Perpetual</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="Aktif" {{ $d->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Menjelang Expired" {{ $d->status == 'Menjelang Expired' ? 'selected' : '' }}>Menjelang Expired</option>
                                    <option value="Non-Aktif" {{ $d->status == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="form-label fw-bold">Tanggal Mulai</label><input type="date" name="tanggal_mulai" class="form-control" value="{{ $d->tanggal_mulai }}" required></div>
                            <div class="col-md-6 mb-3"><label class="form-label fw-bold">Tanggal Berakhir</label><input type="date" name="tanggal_berakhir" class="form-control" value="{{ $d->tanggal_berakhir }}" required></div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-warning">Update</button></div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endsection