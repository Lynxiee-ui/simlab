<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Dosen - SIMLAB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { 
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); 
            min-height: 100vh;
        }
        .register-card { 
            max-width: 480px; 
            margin: 60px auto; 
            border-radius: 20px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.3); 
            border-top: 6px solid #11998e;
            background: #fff;
        }
        .dosen-icon {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: white;
            font-size: 2rem;
            box-shadow: 0 10px 20px rgba(17, 153, 142, 0.4);
        }
        .btn-dosen {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-dosen:hover { 
            color: white; 
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(17, 153, 142, 0.4);
        }
        .input-group-text { 
            cursor: pointer; 
            background-color: #f8f9fa; 
        }
        .input-group-text:hover { background-color: #e9ecef; }
        .form-control:focus {
            border-color: #11998e;
            box-shadow: 0 0 0 0.25rem rgba(17, 153, 142, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card register-card p-4">
            <div class="text-center mb-4">
                <div class="dosen-icon mb-3">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <h3 class="fw-bold" style="color: #11998e;">DAFTAR DOSEN</h3>
                <p class="text-muted mb-0">Khusus untuk Dosen SIMLAB</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold" style="color: #11998e;">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Dr. Budi Santoso" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" style="color: #11998e;">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@kampus.ac.id" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" style="color: #11998e;">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Minimal 6 karakter" required>
                        <span class="input-group-text" onclick="togglePassword('passwordInput', 'eyeIcon1')">
                            <i class="bi bi-eye" id="eyeIcon1"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" style="color: #11998e;">Konfirmasi Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="confirmInput" class="form-control" placeholder="Ulangi password" required>
                        <span class="input-group-text" onclick="togglePassword('confirmInput', 'eyeIcon2')">
                            <i class="bi bi-eye" id="eyeIcon2"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-dosen w-100">
                    <i class="bi bi-check-circle"></i> Daftar sebagai Dosen
                </button>
            </form>

            <p class="text-center mt-3 mb-0">
                Sudah punya akun? <a href="{{ route('login') }}" style="color: #11998e;" class="fw-bold">Login di sini</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            }
        }
    </script>
</body>
</html>