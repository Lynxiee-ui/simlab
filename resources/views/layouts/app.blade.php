<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMLAB - Sistem Informasi Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #2c3e50 0%, #3498db 100%); color: white; }
        .sidebar h4 { font-weight: 700; margin-bottom: 30px; letter-spacing: 1px; }
        .nav-link { color: rgba(255,255,255,0.8); margin-bottom: 5px; border-radius: 8px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background-color: rgba(255,255,255,0.2); color: white; }
        .nav-link i { margin-right: 10px; }
        
        .stat-card { border: none; border-radius: 15px; color: white; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card-total { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-aktif { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .card-expired { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .card-none { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

        .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .btn-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; }
        .btn-gradient:hover { color: white; opacity: 0.9; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar p-3">
            <h4 class="text-center"><i class="bi bi-cpu"></i> SIMLAB</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('modul2.*') ? 'active' : '' }}" href="{{ route('modul2.lisensi') }}"><i class="bi bi-key"></i>Lisensi</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('modul3.*') ? 'active' : '' }}" href="{{ route('modul3.pengajuan') }}"><i class="bi bi-file-earmark-text"></i>Pengajuan</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('modul5.*') ? 'active' : '' }}" href="{{ route('modul5.jadwal') }}"><i class="bi bi-calendar-check"></i>Jadwal</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('modul6.*') ? 'active' : '' }}" href="{{ route('modul6.laporan') }}"><i class="bi bi-graph-up-arrow"></i>Laporan</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('modul7.*') ? 'active' : '' }}" href="{{ route('modul7.sop') }}"><i class="bi bi-folder2-open"></i>SOP</a>
                </li>

                <!-- INFO USER & LOGOUT -->
                <li class="nav-item mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.2);">
                    <div class="text-white px-3 mb-2">
                        <small class="d-block opacity-75">Login sebagai:</small>
                        <strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
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

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

@yield('modals')

<!-- PENTING: Yield untuk scripts -->
@yield('scripts')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>