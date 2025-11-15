<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{config('app.name')}}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="split-login-container">
            <div class="login-panel image-panel d-none d-lg-flex">
                <div class="image-overlay"></div>
                <div class="panel-content">
                    <div class="panel-brand d-flex align-items-center gap-2 mb-auto">
                        <div class="brand-icon">E</div>
                        <div>
                            <p class="mb-0 fw-semibold text-uppercase small text-white-50">{{config ('app.name')}}</p>
                        </div>
                    </div>
                    <div class="panel-text mt-auto">
                        <p class="text-uppercase text-white-50 small mb-2">Selamat Datang</p>
                        <h2 class="fw-bold text-white">Bangun pengalaman belajar yang lebih baik.</h2>
                        <p class="text-white-50 mb-5">Kelola materi, tugas, serta analitik hanya dalam satu dashboard.</p>
                    </div>
                </div>
            </div>

            <div class="login-panel form-panel">
                <div class="orbit orbit-1"></div>
                <div class="orbit orbit-2"></div>
                <div class="orbit-dot dot-1"></div>
                <div class="orbit-dot dot-2"></div>
                <div class="form-card shadow-lg">
                    <h3 class="fw-bold text-center mb-1">Login</h3>
                    <p class="text-muted text-center mb-4">Masukkan kredensial akun Anda</p>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none small">Lupa password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 fs-5 rounded-3">
                            Login
                        </button>
                    </form>

                    <div class="alert alert-info">
                        <strong>Akun Demo:</strong><br>
                        <small>
                            <strong>Super Admin:</strong> admin@belajaringgris.com / admin123<br>
                            <strong>Guru:</strong> guru@belajaringgris.com / guru123<br>
                            <strong>Siswa:</strong> siswa@belajaringgris.com / siswa123
                        </small>
                    </div>
                    <p class="text-center text-muted small mb-0">Belum punya akses? Hubungi administrator sekolah Anda.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <style>
        .split-login-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f5f7fb;
            padding: 2rem;
            gap: 2rem;
        }

        @media (min-width: 992px) {
            .split-login-container {
                flex-direction: row;
                padding: 3rem;
            }
        }

        .login-panel {
            border-radius: 24px;
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .image-panel {
            background: linear-gradient(120deg, rgba(18, 85, 207, 0.8), rgba(80, 197, 255, 0.7)),
                url('{{ asset('assets/images/backgrounds/login-cover.jpg') }}') center/cover;
            min-height: 320px;
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(9, 34, 84, 0.9), rgba(24, 119, 242, 0.6));
        }

        .panel-content {
            position: relative;
            z-index: 1;
            padding: 2.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
        }

        .panel-text h2 {
            font-size: 2.25rem;
        }

        .form-panel {
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .form-card {
            width: 100%;
            max-width: 420px;
            border-radius: 24px;
            padding: 2.5rem;
            background: #fff;
            position: relative;
            z-index: 2;
        }

        .orbit {
            position: absolute;
            border-radius: 50%;
            border: 1px solid #dfe9ff;
        }

        .orbit-1 {
            width: 320px;
            height: 320px;
            top: 15%;
            right: 8%;
        }

        .orbit-2 {
            width: 220px;
            height: 220px;
            top: 25%;
            right: 18%;
        }

        .orbit-dot {
            position: absolute;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #1b48c6);
        }

        .dot-1 {
            top: 18%;
            right: 8%;
        }

        .dot-2 {
            bottom: 22%;
            right: 28%;
        }

        .btn-primary {
            background: linear-gradient(120deg, #0d6efd, #1a88ff);
            border: none;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(120deg, #0b5ed7, #1a76ff);
        }

        @media (max-width: 991.98px) {
            .split-login-container {
                padding: 1.5rem 1rem;
            }

            .login-panel {
                border-radius: 20px;
            }

            .form-card {
                padding: 2rem;
                box-shadow: none !important;
            }
        }
    </style>
</body>

</html>
