<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Dirut | PT.BABEN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html { font-size: 80%; }
        body { background: #f5f7fb; color: #111827; font-family: Poppins, sans-serif; }
        .navbar { background: #fff; box-shadow: 0 10px 30px rgba(15,23,42,.05); }
        .brand { align-items: center; color: #2563eb; display: inline-flex; font-weight: 700; gap: 0.55rem; }
        .brand-logo { height: 32px; object-fit: contain; width: 32px; }
        .card { border: 0; border-radius: 12px; box-shadow: 0 10px 26px rgba(15,23,42,.06); font-size: .9rem; }
        .card.p-4 { padding: 1rem !important; }
        .card h2 { font-size: 1.5rem; }
        .stat-icon { background: #dbeafe; border-radius: 10px; color: #2563eb; font-size: 16px; padding: 10px; }
    </style>
    @include('layouts.partials.responsive-global')
</head>
<body>
    <nav class="navbar py-3">
        <div class="container">
            <span class="brand"><img class="brand-logo" src="{{ asset('images/logo-pt-baben.png') }}" alt="Logo PT.BABEN">PT.BABEN</span>
            <div class="d-flex align-items-center gap-3">
                <span class="fw-semibold">{{ auth()->user()->nama }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-primary btn-sm">Logout</button></form>
            </div>
        </div>
    </nav>
    <main class="container py-4">
        <h1 class="h3 fw-bold mb-1">Dashboard Dirut</h1>
        <p class="text-secondary mb-4">Ringkasan kehadiran PT.BABEN.</p>
        <div class="row g-4">
            <div class="col-12 col-md-6 col-xl-3"><div class="card h-100 p-4"><div class="d-flex justify-content-between align-items-center"><div><p class="text-secondary mb-1">Total Karyawan</p><h2 class="mb-0 fw-bold">{{ $totalKaryawan }}</h2></div><span class="stat-icon">👥</span></div></div></div>
            <div class="col-12 col-md-6 col-xl-3"><div class="card h-100 p-4"><div class="d-flex justify-content-between align-items-center"><div><p class="text-secondary mb-1">Hadir Hari Ini</p><h2 class="mb-0 fw-bold">{{ $hadirHariIni }}</h2></div><span class="stat-icon">✓</span></div></div></div>
            <div class="col-12 col-md-6 col-xl-3"><div class="card h-100 p-4"><div class="d-flex justify-content-between align-items-center"><div><p class="text-secondary mb-1">Belum Absen</p><h2 class="mb-0 fw-bold">{{ $belumAbsen }}</h2></div><span class="stat-icon">◷</span></div></div></div>
            <div class="col-12 col-md-6 col-xl-3"><div class="card h-100 p-4"><div class="d-flex justify-content-between align-items-center"><div><p class="text-secondary mb-1">Absensi Bulan Ini</p><h2 class="mb-0 fw-bold">{{ $absensiBulanIni }}</h2></div><span class="stat-icon">▣</span></div></div></div>
        </div>
    </main>
</body>
</html>
