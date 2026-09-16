@extends('layouts.karyawan')

@section('title', 'Riwayat Absensi')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title h3 mb-1">Riwayat Absensi</h1>
            <p class="text-secondary mb-0">Daftar absensi yang tercatat untuk akun Anda.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <div class="soft-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-secondary mb-1">Total Hari Hadir</p>
                        <h2 class="fw-bold mb-0">{{ $statistik['total_hadir'] }}</h2>
                    </div>
                    <div class="stat-icon icon-blue">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="soft-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-secondary mb-1">Absensi Lengkap</p>
                        <h2 class="fw-bold mb-0">{{ $statistik['lengkap'] }}</h2>
                    </div>
                    <div class="stat-icon icon-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="soft-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-secondary mb-1">Belum Pulang</p>
                        <h2 class="fw-bold mb-0">{{ $statistik['belum_pulang'] }}</h2>
                    </div>
                    <div class="stat-icon icon-yellow">
                        <i class="fa-solid fa-door-open"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="soft-card p-4">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-3">
            <h2 class="h5 fw-bold mb-0">Riwayat Absensi Saya</h2>
            <form method="GET" action="{{ route('karyawan.riwayat') }}" class="d-flex align-items-center gap-2">
                <label for="bulan" class="visually-hidden">Filter bulan</label>
                <select id="bulan" name="bulan" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua riwayat</option>
                    @foreach ($bulanTersedia as $bulan)
                        <option value="{{ $bulan }}" @selected($bulanDipilih === $bulan)>
                            {{ \Carbon\Carbon::createFromFormat('!Y-m', $bulan)->locale('id')->translatedFormat('F Y') }}
                        </option>
                    @endforeach
                </select>
                <noscript><button type="submit" class="btn btn-sm btn-primary">Terapkan</button></noscript>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $absensi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($absensi->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $absensi->jam_masuk ?? '-' }}</td>
                            <td>{{ $absensi->jam_pulang ?? '-' }}</td>
                            <td>
                                @php
                                    $badge = match ($absensi->status) {
                                        'Hadir', 'Hadir Lengkap' => 'text-bg-success',
                                        'Terlambat' => 'text-bg-danger',
                                        'Belum Pulang' => 'text-bg-warning',
                                        default => 'text-bg-secondary',
                                    };
                                @endphp
                                <span class="badge badge-status {{ $badge }}">{{ $absensi->status ?? '-' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-4">Belum ada riwayat absensi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
