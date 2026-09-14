@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title h3 mb-1">Dashboard Admin</h1>
            <p class="text-secondary mb-0">Selamat datang, {{ auth()->user()->nama ?? auth()->user()->username }}.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="soft-card h-100 p-4">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-secondary mb-1">Total Karyawan</p>
                        <h2 class="fw-bold mb-0">{{ $totalKaryawan }}</h2>
                    </div>
                    <div class="stat-icon icon-blue">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="soft-card h-100 p-4">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-secondary mb-1">Hadir Hari Ini</p>
                        <h2 class="fw-bold mb-0">{{ $hadirHariIni }}</h2>
                    </div>
                    <div class="stat-icon icon-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="soft-card h-100 p-4">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-secondary mb-1">Belum Absen</p>
                        <h2 class="fw-bold mb-0">{{ $belumAbsen }}</h2>
                    </div>
                    <div class="stat-icon icon-red">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="soft-card h-100 p-4">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-secondary mb-1">Absensi Bulan Ini</p>
                        <h2 class="fw-bold mb-0">{{ $absensiBulanIni }}</h2>
                    </div>
                    <div class="stat-icon icon-purple">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-4">
            <div class="soft-card p-3 mb-3">
                <h2 class="h6 fw-bold mb-2">Aksi Cepat</h2>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.karyawan.index') }}" class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-user-plus me-2"></i>Tambah Karyawan
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa-solid fa-file-lines me-2"></i>Lihat Laporan
                    </a>
                </div>
            </div>
            <div class="soft-card p-2">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h2 class="h6 fw-bold mb-0">Grafik Kehadiran Hari Ini</h2>
                    <i class="fa-solid fa-chart-line text-primary fs-5" aria-hidden="true"></i>
                </div>
                @include('admin.partials.grafik-kehadiran')
            </div>
        </div>
        <div class="col-12 col-xl-8">
            <div class="soft-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h5 fw-bold mb-0">Pengajuan Izin, Sakit & Dinas Luar</h2>
                    <span class="badge text-bg-warning">{{ $pengajuanMenunggu->count() }} menunggu</span>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Nama</th><th>Tanggal</th><th>Jenis</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($pengajuanMenunggu as $pengajuan)
                                <tr>
                                    <td class="fw-semibold">{{ $pengajuan->user->nama ?? '-' }}</td>
                                    <td>{{ optional($pengajuan->tanggal_mulai)->format('d/m/Y') }}</td>
                                    <td>{{ $pengajuan->jenis }}</td>
                                    <td class="text-end"><form method="POST" action="{{ route('admin.pengajuan-izin-sakit.setujui', $pengajuan) }}">@csrf <button type="submit" class="btn btn-sm btn-success">Setujui</button></form></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-secondary py-4">Tidak ada pengajuan yang menunggu.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="soft-card p-4 h-100">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="h5 fw-bold mb-0">Aktivitas Hari Ini</h2>
                </div>
                <div class="table-responsive" style="max-height: 270px; overflow-y: auto;">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aktivitasTerbaru as $aktivitas)
                                @php($absensiHariIni = $aktivitas->absensis->first())
                                <tr>
                                    <td class="fw-semibold">{{ $aktivitas->nama }}</td>
                                    <td>{{ $absensiHariIni?->tanggal?->format('d/m/Y') ?? '-' }}</td>
                                    <td>{{ $absensiHariIni?->jam_masuk ?? '-' }}</td>
                                    <td>{{ $absensiHariIni?->status ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-secondary py-4">Belum ada aktivitas absensi hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
