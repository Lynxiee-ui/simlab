@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Repository SOP & Dokumen</h3>
        <button class="btn btn-gradient px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahSopModal">
            <i class="bi bi-upload"></i> Upload Dokumen
        </button>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card stat-card card-total p-3">
                <h5>Total Dokumen</h5>
                <h2 class="fw-bold">{{ $data->count() }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card card-aktif p-3">
                <h5>SOP Operasional</h5>
                <h2 class="fw-bold">{{ $data->where('kategori', 'SOP Operasional')->count() }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card card-none p-3">
                <h5>Panduan Teknis</h5>
                <h2 class="fw-bold">{{ $data->where('kategori', 'Panduan Teknis')->count() }}</h2>
            </div>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0 text-secondary">Daftar Dokumen SOP</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Judul Dokumen</th>
                            <th>Kategori</th>
                            <th>Versi</th>
                            <th>File</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $d)
                        <tr>
                            <td class="fw-bold">{{ $d->judul_dokumen }}</td>
                            <td><span class="badge bg-secondary">{{ $d->kategori }}</span></td>
                            <td>v{{ $d->versi }}</td>
                            <td>
                                <a href="{{ route('modul7.download', $d->id) }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editSopModal{{ $d->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('modul7.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada dokumen SOP.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="tambahSopModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('modul7.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-upload"></i> Upload Dokumen Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Dokumen</label>
                            <input type="text" name="judul_dokumen" class="form-control" placeholder="Contoh: SOP Penggunaan Server" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori (Dropdown)</label>
                                <select name="kategori" class="form-select">
                                    <option value="SOP Operasional">SOP Operasional</option>
                                    <option value="Panduan Teknis">Panduan Teknis</option>
                                    <option value="Dokumen Legal">Dokumen Legal</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Versi</label>
                                <input type="text" name="versi" class="form-control" placeholder="1.0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">File (PDF/DOC)</label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($data as $d)
    <div class="modal fade" id="editSopModal{{ $d->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('modul7.update', $d->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Dokumen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Dokumen</label>
                            <input type="text" name="judul_dokumen" class="form-control" value="{{ $d->judul_dokumen }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori (Dropdown)</label>
                                <select name="kategori" class="form-select">
                                    <option value="SOP Operasional" {{ $d->kategori == 'SOP Operasional' ? 'selected' : '' }}>SOP Operasional</option>
                                    <option value="Panduan Teknis" {{ $d->kategori == 'Panduan Teknis' ? 'selected' : '' }}>Panduan Teknis</option>
                                    <option value="Dokumen Legal" {{ $d->kategori == 'Dokumen Legal' ? 'selected' : '' }}>Dokumen Legal</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Versi</label>
                                <input type="text" name="versi" class="form-control" value="{{ $d->versi }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ganti File (Kosongkan jika tetap)</label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx">
                            <small class="text-muted">File saat ini: {{ basename($d->file_path) }}</small>
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