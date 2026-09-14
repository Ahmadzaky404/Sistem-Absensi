@extends('layouts.karyawan')

@section('title', $dashboardTitle)

@push('styles')
    <style>
        .attendance-card {
            background: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
            padding: 20px;
        }

        .attendance-icon {
            width: 46px;
            height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #2563EB;
            background: #DBEAFE;
            font-size: 18px;
        }

        .attendance-title {
            color: #111827;
            font-weight: 700;
            letter-spacing: 0;
        }

        .attendance-date {
            color: #64748B;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .attendance-status {
            border: 0;
            border-radius: 15px;
            margin: 16px auto 14px;
            padding: 14px;
            max-width: 430px;
            text-align: center;
        }

        .attendance-status-warning {
            background: #FEF3C7;
            color: #92400E;
        }

        .attendance-status-info {
            background: #DBEAFE;
            color: #1E3A8A;
        }

        .attendance-status-success {
            background: #DCFCE7;
            color: #166534;
        }

        .attendance-status-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-bottom: 8px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.72);
        }

        .attendance-status-warning .attendance-status-icon {
            color: #F59E0B;
        }

        .attendance-status-info .attendance-status-icon {
            color: #2563EB;
        }

        .attendance-status-success .attendance-status-icon {
            color: #16A34A;
        }

        .attendance-time {
            color: #111827;
            font-size: 1.4rem;
            font-weight: 700;
            line-height: 1.15;
        }

        .attendance-action {
            border: 0;
            border-radius: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 180px;
            min-height: 36px;
            margin-top: 12px;
            padding: 6px 12px;
        }

        .attendance-summary-card {
            background: #FFFFFF;
            border: 1px solid rgba(22, 101, 52, 0.12);
            border-radius: 12px;
            padding: 12px;
            text-align: center;
        }

        .attendance-summary-label {
            color: #64748B;
            font-size: 0.86rem;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .attendance-summary-time {
            color: #111827;
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .dashboard-side-stack {
            gap: 10px;
        }

        .dashboard-side-card {
            background: #FFFFFF;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
            padding: 12px 14px;
        }

        .dashboard-side-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .dashboard-side-icon {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 34px;
            border-radius: 50%;
            font-size: 14px;
        }

        .dashboard-side-icon-blue {
            color: #2563EB;
            background: #DBEAFE;
        }

        .dashboard-side-icon-green {
            color: #16A34A;
            background: #DCFCE7;
        }

        .dashboard-side-icon-yellow {
            color: #D97706;
            background: #FEF3C7;
        }

        .dashboard-side-title {
            color: #111827;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .dashboard-side-date {
            color: #64748B;
            font-size: 0.86rem;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .dashboard-side-time {
            color: #111827;
            font-size: 1.2rem;
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 0;
        }

        .dashboard-stat-list {
            display: grid;
            gap: 0;
        }

        .dashboard-stat-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 5px 0;
            border-bottom: 1px solid #EEF2F7;
        }

        .dashboard-stat-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .dashboard-stat-label {
            color: #64748B;
            font-size: 0.84rem;
            font-weight: 500;
            margin-bottom: 0;
        }

        .dashboard-stat-value {
            color: #111827;
            font-size: 1.08rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .quick-action-grid {
            display: grid;
            gap: 8px;
        }

        .quick-action-btn {
            min-height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 700;
        }

        @media (max-width: 575.98px) {
            .attendance-card {
                padding: 20px;
            }

            .attendance-time {
                font-size: 1.65rem;
            }

            .attendance-summary-card {
                padding: 14px 10px;
            }

            .attendance-summary-time {
                font-size: 1.05rem;
            }

            .dashboard-side-card {
                padding: 16px;
            }

            .dashboard-side-time {
                font-size: 1.35rem;
            }

        }
    </style>
@endpush

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title h3 mb-1">{{ $dashboardTitle }}</h1>
            <p class="text-secondary mb-0">Kelola absensi harian Anda secara real time.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-7">
            <div class="attendance-card h-100">
                <div class="text-center">
                    <span class="attendance-icon" aria-hidden="true">
                        <i class="fa-solid fa-clock"></i>
                    </span>
                    <h2 class="attendance-title h4 mt-3 mb-2">Absensi Hari Ini</h2>
                    <p class="attendance-date mb-0">{{ now()->format('l, d F Y') }}</p>
                </div>

                @if ($pengajuanHariIni)
                    <div class="attendance-status attendance-status-info">
                        <span class="attendance-status-icon" aria-hidden="true">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </span>
                        <p class="fw-semibold mb-1">Pengajuan {{ $pengajuanHariIni->jenis }} Menunggu Persetujuan</p>
                        <p class="mb-0">Admin akan memproses pengajuan Anda.</p>
                    </div>
                @elseif (! $absensiHariIni)
                    <div class="attendance-status attendance-status-warning">
                        <span class="attendance-status-icon" aria-hidden="true">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </span>
                        <p class="fw-semibold mb-0">Anda belum melakukan absensi hari ini</p>
                    </div>
                    <form method="POST" action="{{ route('karyawan.absen-masuk') }}" class="d-flex justify-content-center" data-attendance-form>
                        @csrf
                        <input type="hidden" name="latitude" data-latitude>
                        <input type="hidden" name="longitude" data-longitude>
                        <button type="submit" class="btn btn-success btn-lg w-auto attendance-action">
                            <i class="fa-solid fa-right-to-bracket me-2"></i>Absen Masuk
                        </button>
                    </form>
                    <div class="d-flex justify-content-center gap-2 flex-wrap mt-2">
                        <form method="POST" action="{{ route('karyawan.pengajuan-izin-sakit') }}" data-attendance-form>
                            @csrf
                            <input type="hidden" name="jenis" value="Izin">
                            <button type="submit" class="btn btn-warning attendance-action">
                                <i class="fa-solid fa-file-circle-exclamation me-2"></i>Ajukan Izin
                            </button>
                        </form>
                        <form method="POST" action="{{ route('karyawan.pengajuan-izin-sakit') }}" data-attendance-form>
                            @csrf
                            <input type="hidden" name="jenis" value="Sakit">
                            <button type="submit" class="btn btn-secondary attendance-action">
                                <i class="fa-solid fa-notes-medical me-2"></i>Ajukan Sakit
                            </button>
                        </form>
                        <form method="POST" action="{{ route('karyawan.pengajuan-izin-sakit') }}" data-attendance-form>
                            @csrf
                            <input type="hidden" name="jenis" value="Dinas Luar">
                            <button type="submit" class="btn btn-info attendance-action">
                                <i class="fa-solid fa-briefcase me-2"></i>Ajukan Dinas Luar
                            </button>
                        </form>
                    </div>
                @elseif (in_array($absensiHariIni->status, ['Izin', 'Sakit', 'Dinas Luar']))
                    <div class="attendance-status attendance-status-success">
                        <span class="attendance-status-icon" aria-hidden="true">
                            <i class="fa-solid fa-circle-check"></i>
                        </span>
                        <p class="fw-semibold mb-1">{{ $absensiHariIni->status }} Disetujui</p>
                        <p class="mb-0">Absensi {{ strtolower($absensiHariIni->status) }} Anda telah dicatat.</p>
                    </div>
                @elseif (! $absensiHariIni->jam_pulang)
                    <div class="attendance-status attendance-status-info">
                        <span class="attendance-status-icon" aria-hidden="true">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <p class="fw-semibold mb-2">Jam Masuk Tercatat</p>
                        <h3 class="attendance-time mb-0">{{ $absensiHariIni->jam_masuk }}</h3>
                    </div>
                    <form method="POST" action="{{ route('karyawan.absen-pulang') }}" class="d-flex justify-content-center" data-attendance-form>
                        @csrf
                        <input type="hidden" name="latitude" data-latitude>
                        <input type="hidden" name="longitude" data-longitude>
                        <button type="submit" class="btn btn-danger btn-lg w-auto attendance-action">
                            <i class="fa-solid fa-right-from-bracket me-2"></i>Absen Pulang
                        </button>
                    </form>
                @else
                    <div class="attendance-status attendance-status-success">
                        <span class="attendance-status-icon" aria-hidden="true">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <p class="fw-semibold mb-3">Absensi Hari Ini Lengkap!</p>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="attendance-summary-card">
                                    <p class="attendance-summary-label">Jam Masuk</p>
                                    <h3 class="attendance-summary-time">{{ $absensiHariIni->jam_masuk }}</h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="attendance-summary-card">
                                    <p class="attendance-summary-label">Jam Pulang</p>
                                    <h3 class="attendance-summary-time">{{ $absensiHariIni->jam_pulang }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-secondary text-center fw-semibold mb-0">Terima kasih sudah bekerja hari ini! &#127881;</p>
                @endif
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <div class="d-grid dashboard-side-stack">
                <div class="dashboard-side-card">
                    <div class="dashboard-side-header">
                        <span class="dashboard-side-icon dashboard-side-icon-blue" aria-hidden="true">
                            <i class="fa-solid fa-clock"></i>
                        </span>
                        <h2 class="dashboard-side-title">Waktu Saat Ini</h2>
                    </div>
                    <p class="dashboard-side-date" id="jakarta-date">Memuat tanggal...</p>
                    <h3 class="dashboard-side-time" id="jakarta-time">--:--:-- WIB</h3>
                </div>

                <div class="dashboard-side-card">
                    <div class="dashboard-side-header">
                        <span class="dashboard-side-icon dashboard-side-icon-green" aria-hidden="true">
                            <i class="fa-solid fa-chart-line"></i>
                        </span>
                        <h2 class="dashboard-side-title">Statistik Bulan Ini</h2>
                    </div>
                    <div class="dashboard-stat-list">
                        <div class="dashboard-stat-item">
                            <p class="dashboard-stat-label">Total Hari Hadir</p>
                            <h3 class="dashboard-stat-value">{{ $statistik['hari_hadir'] }}</h3>
                        </div>
                        <div class="dashboard-stat-item">
                            <p class="dashboard-stat-label">Hadir Lengkap</p>
                            <h3 class="dashboard-stat-value">{{ $statistik['lengkap'] }}</h3>
                        </div>
                        <div class="dashboard-stat-item">
                            <p class="dashboard-stat-label">Belum Pulang</p>
                            <h3 class="dashboard-stat-value">{{ $statistik['belum_pulang'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="dashboard-side-card">
                    <div class="dashboard-side-header">
                        <span class="dashboard-side-icon dashboard-side-icon-yellow" aria-hidden="true">
                            <i class="fa-solid fa-bolt"></i>
                        </span>
                        <h2 class="dashboard-side-title">Aksi Cepat</h2>
                    </div>
                    <div class="quick-action-grid">
                        <a href="{{ route('karyawan.riwayat') }}" class="btn btn-primary quick-action-btn">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <span>Riwayat Absensi</span>
                        </a>
                        <button type="button" class="btn btn-secondary quick-action-btn" onclick="window.location.reload()">
                            <i class="fa-solid fa-rotate-right"></i>
                            <span>Refresh Dashboard</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-attendance-form]').forEach((form) => {
            form.addEventListener('submit', (event) => {
                const latitude = form.querySelector('[data-latitude]');
                const longitude = form.querySelector('[data-longitude]');
                const button = form.querySelector('button[type="submit"]');

                if (latitude && longitude && !latitude.value && !longitude.value) {
                    event.preventDefault();

                    if (!navigator.geolocation) {
                        alert('Perangkat ini tidak mendukung pengambilan lokasi GPS.');
                        return;
                    }

                    if (button) {
                        button.disabled = true;
                        button.setAttribute('aria-disabled', 'true');
                    }

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            latitude.value = position.coords.latitude;
                            longitude.value = position.coords.longitude;
                            form.requestSubmit();
                        },
                        () => {
                            if (button) {
                                button.disabled = false;
                                button.removeAttribute('aria-disabled');
                            }
                            alert('Lokasi GPS wajib diizinkan untuk melakukan absensi.');
                        },
                        { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                    );

                    return;
                }

                if (button) {
                    button.disabled = true;
                    button.setAttribute('aria-disabled', 'true');
                }
            });
        });
    </script>
@endpush

@push('scripts')
    <script>
        const dateTarget = document.getElementById('jakarta-date');
        const timeTarget = document.getElementById('jakarta-time');
        // Gunakan waktu dari server WIB agar jam perangkat pengguna tidak memengaruhi dashboard.
        const serverJakartaTimestamp = {{ now('Asia/Jakarta')->getTimestamp() * 1000 }};
        const dashboardLoadedAt = performance.now();

        function updateJakartaClock() {
            const now = new Date(serverJakartaTimestamp + (performance.now() - dashboardLoadedAt));
            const dateText = new Intl.DateTimeFormat('id-ID', {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                timeZone: 'Asia/Jakarta'
            }).format(now);

            const timeText = new Intl.DateTimeFormat('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false,
                timeZone: 'Asia/Jakarta'
            }).format(now);

            dateTarget.textContent = dateText;
            timeTarget.textContent = `${timeText} WIB`;
        }

        updateJakartaClock();
        setInterval(updateJakartaClock, 1000);

    </script>
@endpush
