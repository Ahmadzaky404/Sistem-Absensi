@extends('layouts.admin')

@section('title', 'Laporan Absensi')

@push('styles')
    <style>
        .laporan-table-scroll {
            scrollbar-color: #94A3B8 #E2E8F0;
            scrollbar-width: thin;
        }

        .laporan-table-scroll::-webkit-scrollbar {
            width: 10px;
        }

        .laporan-table-scroll::-webkit-scrollbar-track {
            background: #E2E8F0;
            border-radius: 999px;
        }

        .laporan-table-scroll::-webkit-scrollbar-thumb {
            background: #94A3B8;
            border: 2px solid #E2E8F0;
            border-radius: 999px;
        }

        .laporan-table-scroll::-webkit-scrollbar-thumb:hover {
            background: #64748B;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title h3 mb-1">Laporan Absensi</h1>
            <p class="text-secondary mb-0">Pantau dan ekspor riwayat absensi karyawan.</p>
        </div>
    </div>

    <div class="soft-card p-4 mb-4">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3 align-items-end">
            <div class="col-12 col-md-2">
                <label for="hari" class="form-label fw-semibold">Hari</label>
                <select class="form-select" id="hari" name="hari">
                    <option value="">Pilih hari</option>
                    @foreach (range(1, 31) as $hari)
                        <option value="{{ $hari }}" @selected(($filters['hari'] ?? null) == $hari)>{{ $hari }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <label for="bulan" class="form-label fw-semibold">Bulan</label>
                <select class="form-select" id="bulan" name="bulan">
                    <option value="">Pilih bulan</option>
                    @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $nomor => $namaBulan)
                        <option value="{{ $nomor + 1 }}" @selected(($filters['bulan'] ?? null) == $nomor + 1)>{{ $namaBulan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2">
                <label for="tahun" class="form-label fw-semibold">Tahun</label>
                <select class="form-select" id="tahun" name="tahun">
                    <option value="">Pilih tahun</option>
                    @foreach (range(now()->year + 1, 2020) as $tahun)
                        <option value="{{ $tahun }}" @selected(($filters['tahun'] ?? null) == $tahun)>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-5">
                <div class="d-flex flex-nowrap gap-2 overflow-auto pb-1">
                    <button type="submit" class="btn btn-primary text-nowrap flex-fill">
                        <i class="fa-solid fa-filter me-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.laporan.export-excel', request()->query()) }}" class="btn btn-success text-nowrap flex-fill">
                        <i class="fa-solid fa-file-excel me-2"></i>Export Excel
                    </a>
                    <a href="{{ route('admin.laporan.cetak-pdf', request()->query()) }}" class="btn btn-purple text-nowrap flex-fill" target="_blank">
                        <i class="fa-solid fa-file-pdf me-2"></i>Cetak PDF
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="soft-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-secondary mb-1">Total Entri</p>
                        <h2 class="fw-bold mb-0">{{ $summary['total'] }}</h2>
                    </div>
                    <div class="stat-icon icon-blue">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="soft-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-secondary mb-1">Hadir Lengkap</p>
                        <h2 class="fw-bold mb-0">{{ $summary['hadir_lengkap'] }}</h2>
                    </div>
                    <div class="stat-icon icon-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="soft-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-secondary mb-1">Terlambat</p>
                        <h2 class="fw-bold mb-0">{{ $summary['terlambat'] }}</h2>
                    </div>
                    <div class="stat-icon icon-red">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="soft-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-secondary mb-1">Belum Pulang</p>
                        <h2 class="fw-bold mb-0">{{ $summary['belum_pulang'] }}</h2>
                    </div>
                    <div class="stat-icon icon-purple">
                        <i class="fa-solid fa-door-open"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="soft-card p-4">
        <div class="table-responsive laporan-table-scroll" style="max-height: 240px; overflow-y: auto;">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan as $karyawan)
                        @php($absensi = $karyawan->absensis->first())
                        <tr>
                            <td class="fw-semibold">{{ $karyawan->nama }}</td>
                            <td>{{ $absensi?->tanggal?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $absensi?->jam_masuk ?? '-' }}</td>
                            <td>{{ $absensi?->jam_pulang ?? '-' }}</td>
                            <td><span class="badge badge-status text-bg-light">{{ $absensi?->status ?? '-' }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-4">Belum ada data karyawan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
