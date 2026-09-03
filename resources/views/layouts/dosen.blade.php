<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Dosen - SIMLAB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #11998e 0%, #38ef7d 100%); color: white; }
        .sidebar h4 { font-weight: 700; margin-bottom: 30px; letter-spacing: 1px; }
        .nav-link { color: rgba(255,255,255,0.8); margin-bottom: 5px; border-radius: 8px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background-color: rgba(255,255,255,0.2); color: white; }
        .nav-link i { margin-right: 10px; }
        
        .stat-card { border: none; border-radius: 15px; color: white; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card-total { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-aktif { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .card-none { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR DOSEN -->
        <div class="col-md-3 col-lg-2 sidebar p-3">
            <h4 class="text-center"><i class="bi bi-mortarboard"></i> Portal Dosen</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dosen.modul3') ? 'active' : '' }}" href="{{ route('dosen.modul3') }}">
                        <i class="bi bi-file-earmark-text"></i> Pengajuan Kebutuhan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dosen.modul7') ? 'active' : '' }}" href="{{ route('dosen.modul7') }}">
                        <i class="bi bi-folder2-open"></i> SOP & Dokumen
                    </a>
                </li>
            </ul>
        </div>

        <!-- KONTEN UTAMA -->
        <div class="col-md-9 col-lg-10 p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

@yield('modals')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>