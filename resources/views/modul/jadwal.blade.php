@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Jadwal Pemeliharaan Server & Jaringan</h3>
        <button class="btn btn-gradient px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
            <i class="bi bi-plus-circle"></i> Tambah Jadwal
        </button>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card stat-card card-total p-3">
                <h5>Total Jadwal</h5>
                <h2 class="fw-bold">{{ $data->count() }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card card-aktif p-3">
                <h5>Terjadwal</h5>
                <h2 class="fw-bold">{{ $data->where('status', 'Terjadwal')->count() }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card card-expired p-3">
                <h5>Selesai</h5>
                <h2 class="fw-bold">{{ $data->where('status', 'Selesai')->count() }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card card-none p-3">
                <h5>Preventive</h5>
                <h2 class="fw-bold">{{ $data->where('jenis', 'Preventive')->count() }}</h2>
            </div>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0 text-secondary">Daftar Jadwal Pemeliharaan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Aset</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Petugas</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $d)
                        <tr>
                            <td class="fw-bold">{{ $d->nama_aset }}</td>
                            <td>
                                @if($d->jenis == 'Preventive')
                                    <span class="badge bg-info text-dark">Preventive</span>
                                @else
                                    <span class="badge bg-danger">Corrective</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($d->tanggal_pelaksanaan)->format('d M Y') }}</td>
                            <td>{{ $d->petugas }}</td>
                            <td>
                                @if($d->status == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark">Terjadwal</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editJadwalModal{{ $d->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('modul5.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada jadwal pemeliharaan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="tambahJadwalModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('modul5.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Jadwal Pemeliharaan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Aset / Server</label>
                            <input type="text" name="nama_aset" class="form-control" placeholder="Contoh: Server Utama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Pemeliharaan</label>
                            <select name="jenis" class="form-select">
                                <option value="Preventive">Preventive</option>
                                <option value="Corrective">Corrective</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal_pelaksanaan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Petugas</label>
                            <input type="text" name="petugas" class="form-control" placeholder="Nama Teknisi" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Opsional: Catatan tambahan"></textarea>
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
    <div class="modal fade" id="editJadwalModal{{ $d->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('modul5.update', $d->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Jadwal Pemeliharaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Aset / Server</label>
                            <input type="text" name="nama_aset" class="form-control" value="{{ $d->nama_aset }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Pemeliharaan</label>
                            <select name="jenis" class="form-select">
                                <option value="Preventive" {{ $d->jenis == 'Preventive' ? 'selected' : '' }}>Preventive</option>
                                <option value="Corrective" {{ $d->jenis == 'Corrective' ? 'selected' : '' }}>Corrective</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal_pelaksanaan" class="form-control" value="{{ $d->tanggal_pelaksanaan }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Petugas</label>
                            <input type="text" name="petugas" class="form-control" value="{{ $d->petugas }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="Terjadwal" {{ $d->status == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                                <option value="Selesai" {{ $d->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3">{{ $d->catatan }}</textarea>
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