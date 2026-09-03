@extends('layouts.dosen')

@section('content')
    <h3 class="fw-bold text-dark mb-4">SOP & Dokumen</h3>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0 text-secondary">Daftar Dokumen</h5>
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $d)
                        <tr>
                            <td class="fw-bold">{{ $d->judul_dokumen }}</td>
                            <td><span class="badge bg-secondary">{{ $d->kategori }}</span></td>
                            <td>v{{ $d->versi }}</td>
                            <td>
                                <a href="{{ route('dosen.modul7.download', $d->id) }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada dokumen SOP.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection