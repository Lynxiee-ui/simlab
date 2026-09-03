@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Pengajuan Kebutuhan Semester</h3>
        <button class="btn btn-gradient px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahPengajuanModal">
            <i class="bi bi-plus-circle"></i> Buat Pengajuan
        </button>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card stat-card card-total p-3">
                <h5>Total Pengajuan</h5>
                <h2 class="fw-bold">{{ $data->count() }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card card-aktif p-3">
                <h5>Disetujui</h5>
                <h2 class="fw-bold">{{ $data->where('status', 'Disetujui')->count() }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card card-expired p-3">
                <h5>Pending</h5>
                <h2 class="fw-bold">{{ $data->where('status', 'Pending')->count() }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card card-none p-3">
                <h5>Ditolak</h5>
                <h2 class="fw-bold">{{ $data->where('status', 'Ditolak')->count() }}</h2>
            </div>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0 text-secondary">Daftar Pengajuan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Pemohon</th>
                            <th>Jenis</th>
                            <th>Spesifikasi</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th class="text-center">Verifikasi & Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $d)
                        <tr>
                            <td class="fw-bold">{{ $d->nama_pemohon }}</td>
                            <td>
                                @if($d->jenis_kebutuhan == 'Software')
                                    <span class="badge bg-primary">Software</span>
                                @else
                                    <span class="badge bg-secondary">Hardware</span>
                                @endif
                            </td>
                            <td>{{ $d->spesifikasi }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($d->alasan, 30) }}</td>
                            <td>
                                @if($d->status == 'Disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($d->status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($d->status == 'Pending')
                                    <form action="{{ route('modul3.status', $d->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Disetujui">
                                        <button class="btn btn-sm btn-outline-success" title="Setujui"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    <form action="{{ route('modul3.status', $d->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Ditolak">
                                        <button class="btn btn-sm btn-outline-danger" title="Tolak"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                @endif

                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPengajuanModal{{ $d->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('modul3.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data pengajuan.</td></tr>
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
                <form action="{{ route('modul3.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Buat Pengajuan Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pemohon</label>
                            <input type="text" name="nama_pemohon" class="form-control" placeholder="Nama Guru/Siswa" required>
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
                            <input type="text" name="spesifikasi" class="form-control" placeholder="Contoh: Laptop i7 16GB RAM" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alasan</label>
                            <textarea name="alasan" class="form-control" rows="3" placeholder="Jelaskan alasan pengajuan" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($data as $d)
    <div class="modal fade" id="editPengajuanModal{{ $d->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('modul3.update', $d->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pemohon</label>
                            <input type="text" name="nama_pemohon" class="form-control" value="{{ $d->nama_pemohon }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Kebutuhan</label>
                            <select name="jenis_kebutuhan" class="form-select">
                                <option value="Software" {{ $d->jenis_kebutuhan == 'Software' ? 'selected' : '' }}>Software</option>
                                <option value="Hardware" {{ $d->jenis_kebutuhan == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Spesifikasi</label>
                            <input type="text" name="spesifikasi" class="form-control" value="{{ $d->spesifikasi }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alasan</label>
                            <textarea name="alasan" class="form-control" rows="3" required>{{ $d->alasan }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endsection