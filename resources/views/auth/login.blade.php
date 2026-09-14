<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin | PT.BABEN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            min-height: 100vh;
            background: #F5F7FB;
            font-family: "Poppins", "Segoe UI", Arial, sans-serif;
        }

        .login-page {
            min-height: 100vh;
            background: #F5F7FB;
        }

        .login-card {
            width: min(100%, 320px);
            border: 0;
            border-radius: 12px;
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.08);
        }

        .login-icon {
            width: 68px;
            height: 68px;
            object-fit: contain;
        }

        .form-control,
        .input-group-text {
            border-color: #E5E7EB;
            padding-block: 0.45rem;
        }

        .input-group-text {
            color: #64748B;
            background: #F8FAFC;
        }

        .form-control:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.12);
        }

        .btn-login {
            background: #2563EB;
            border-color: #2563EB;
            padding-block: 0.45rem;
            font-weight: 600;
        }

        .btn-login:hover,
        .btn-login:focus {
            background: #1D4ED8;
            border-color: #1D4ED8;
        }

        .swal2-popup { width: 20rem !important; padding: 1rem !important; font-size: 0.8rem !important; }
        .swal2-title { font-size: 1.1rem !important; }
        .swal2-html-container { font-size: 0.8rem !important; }
        .swal2-icon { width: 3em !important; height: 3em !important; margin: 0.65em auto 0.45em !important; }
        .swal2-confirm { padding: 0.45em 1em !important; font-size: 0.8rem !important; }
    </style>
    @include('layouts.partials.responsive-global')
    @include('layouts.partials.notification-icons')
</head>
<body>
<main class="login-page d-flex align-items-center justify-content-center px-3 py-5">
    <section class="card login-card">
        <div class="card-body p-2 p-sm-3">
            <div class="text-center mb-3">
                <img class="login-icon mb-2" src="{{ asset('images/logo-pt-baben.png') }}" alt="Logo PT.BABEN">
                <h1 class="h5 fw-bold mb-1">PT.BABEN</h1>
                <p class="text-secondary mb-0">Masuk ke akun Anda</p>
            </div>

            <form method="POST" action="{{ route('login.post') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label fw-semibold">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control @error('username') is-invalid @enderror"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            autocomplete="username"
                            autofocus
                            required
                        >
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-login w-100">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                </button>
            </form>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('logout_success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('logout_success')),
            confirmButtonColor: '#2563EB'
        });
    @endif

    @if (session('login_error'))
        Swal.fire({
            icon: 'error',
            title: 'Login gagal',
            text: @json(session('login_error')),
            confirmButtonColor: '#2563EB'
        });
    @endif
</script>
</body>
</html>
