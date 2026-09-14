<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Karyawan') | PT.BABEN</title>
    <script>
        try {
            document.documentElement.dataset.theme = localStorage.getItem('theme')
                || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        } catch (error) {
            document.documentElement.dataset.theme = 'light';
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        html {
            font-size: 80%;
        }

        :root {
            --primary-blue: #2563EB;
            --page-bg: #F5F7FB;
            --text-main: #111827;
            --text-muted: #64748B;
            --border-soft: #E5E7EB;
        }

        body {
            min-height: 100vh;
            background: var(--page-bg);
            color: var(--text-main);
            font-family: "Poppins", "Segoe UI", Arial, sans-serif;
            font-size: 0.92rem;
        }

        .container {
            max-width: 1180px;
        }

        .karyawan-navbar {
            background: #FFFFFF;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }

        .navbar-brand {
            color: var(--primary-blue);
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            font-weight: 700;
        }

        .navbar-logo {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .nav-link {
            color: #475569;
            font-weight: 500;
        }

        .nav-link.active,
        .nav-link:hover {
            color: var(--primary-blue);
        }

        .profile-avatar {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #FFFFFF;
            background: var(--primary-blue);
        }

        .karyawan-main {
            min-height: calc(100vh - 68px);
            padding: 24px 0;
        }

        .page-title {
            font-weight: 700;
            letter-spacing: 0;
            font-size: 1.5rem;
        }

        .soft-card {
            background: #FFFFFF;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
        }

        .soft-card.p-4 {
            padding: 1.15rem !important;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 18px;
        }

        .icon-blue {
            color: #2563EB;
            background: rgba(37, 99, 235, 0.1);
        }

        .icon-green {
            color: #16A34A;
            background: rgba(22, 163, 74, 0.1);
        }

        .icon-yellow {
            color: #D97706;
            background: rgba(217, 119, 6, 0.12);
        }

        .icon-purple {
            color: #7C3AED;
            background: rgba(124, 58, 237, 0.1);
        }

        .btn-primary {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: #1D4ED8;
            border-color: #1D4ED8;
        }

        .table {
            vertical-align: middle;
        }

        .table thead th {
            color: #475569;
            border-bottom-color: var(--border-soft);
            font-size: 0.86rem;
            font-weight: 600;
        }

        .badge-status {
            border-radius: 999px;
            padding: 0.32rem 0.58rem;
            font-weight: 600;
        }

        .theme-toggle {
            width: 34px;
            height: 34px;
            padding: 0;
            border-radius: 50%;
        }

        .swal2-popup {
            width: 20rem !important;
            padding: 1rem !important;
            font-size: 0.8rem !important;
        }

        .swal2-title { font-size: 1.1rem !important; }
        .swal2-html-container { font-size: 0.8rem !important; }
        .swal2-icon { width: 3em !important; height: 3em !important; margin: 0.65em auto 0.45em !important; }
        .swal2-confirm, .swal2-cancel { padding: 0.45em 1em !important; font-size: 0.8rem !important; }

        html[data-theme="dark"] body {
            --page-bg: #111827;
            --text-main: #E5E7EB;
            --text-muted: #94A3B8;
            --border-soft: #334155;
            background: var(--page-bg);
            color: var(--text-main);
        }

        html[data-theme="dark"] .karyawan-navbar,
        html[data-theme="dark"] .soft-card,
        html[data-theme="dark"] .attendance-card,
        html[data-theme="dark"] .dashboard-side-card {
            background: #1E293B;
            color: var(--text-main);
        }

        html[data-theme="dark"] .attendance-title,
        html[data-theme="dark"] .attendance-time,
        html[data-theme="dark"] .attendance-summary-time,
        html[data-theme="dark"] .dashboard-side-title,
        html[data-theme="dark"] .dashboard-side-time,
        html[data-theme="dark"] .dashboard-stat-value,
        html[data-theme="dark"] .nav-link,
        html[data-theme="dark"] .text-secondary,
        html[data-theme="dark"] .table {
            color: #E5E7EB !important;
        }

        html[data-theme="dark"] .attendance-summary-card {
            background: #0F172A;
            border-color: #334155;
        }

        html[data-theme="dark"] .table {
            --bs-table-bg: transparent;
            --bs-table-color: #E5E7EB;
            --bs-table-border-color: #334155;
        }

        @media (max-width: 575.98px) {
            .karyawan-main {
                padding: 18px 0;
            }

            .page-title {
                font-size: 1.3rem;
            }

            .soft-card.p-4 {
                padding: 1rem !important;
            }
        }
    </style>
    @include('layouts.partials.responsive-global')
    @include('layouts.partials.notification-icons')
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg karyawan-navbar sticky-top">
    <div class="container">
        @php
            $dashboardRoute = match (auth()->user()->role) {
                'direktur_utama' => 'dirut.dashboard',
                'direktur' => 'direktur.dashboard',
                'office_boy' => 'office-boy.dashboard',
                default => 'karyawan.dashboard',
            };
        @endphp
        <a class="navbar-brand" href="{{ route($dashboardRoute) }}">
            <img class="navbar-logo" src="{{ asset('images/logo-pt-baben.png') }}" alt="Logo PT.BABEN">
            <span>PT.BABEN</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#karyawanNavbar" aria-controls="karyawanNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="karyawanNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}" href="{{ route($dashboardRoute) }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('karyawan.riwayat') ? 'active' : '' }}" href="{{ route('karyawan.riwayat') }}">Riwayat Absensi</a>
                </li>
                <li class="nav-item">
                    <span class="nav-link">{{ auth()->user()->nama ?? auth()->user()->username }}</span>
                </li>
                <li class="nav-item">
                    <span class="profile-avatar" aria-label="Foto Profil">
                        <i class="fa-solid fa-user"></i>
                    </span>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-outline-secondary btn-sm theme-toggle" data-theme-toggle aria-label="Aktifkan mode gelap" title="Mode gelap">
                        <i class="fa-solid fa-moon" aria-hidden="true"></i>
                    </button>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fa-solid fa-right-from-bracket me-1"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="karyawan-main">
    <div class="container">
        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const applyTheme = (theme) => {
        document.documentElement.dataset.theme = theme;
        document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
            const dark = theme === 'dark';
            button.setAttribute('aria-label', dark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
            button.setAttribute('title', dark ? 'Mode terang' : 'Mode gelap');
            button.querySelector('i').className = `fa-solid fa-${dark ? 'sun' : 'moon'}`;
        });
    };

    applyTheme(document.documentElement.dataset.theme || 'light');
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const theme = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', theme);
            applyTheme(theme);
        });
    });

    const showNotification = (icon, title, text) => Swal.fire({
        icon,
        title,
        text,
        confirmButtonText: 'Oke',
        confirmButtonColor: '#2563EB',
    });

    @if (session('success'))
        showNotification('success', 'Berhasil', @json(session('success')));
    @endif

    @if (session('error'))
        showNotification('error', 'Gagal', @json(session('error')));
    @endif
</script>
@stack('scripts')
</body>
</html>
