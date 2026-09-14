<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Laporan Absensi | PT.BABEN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #F8FAFC;
            color: #111827;
            font-family: "Poppins", Arial, sans-serif;
            margin: 0;
            padding: 32px;
        }

        .report-page {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
            padding: 32px;
        }

        .report-header {
            align-items: center;
            border-bottom: 2px solid #E5E7EB;
            display: flex;
            justify-content: space-between;
            gap: 24px;
            padding-bottom: 20px;
        }

        .brand-logo {
            height: 48px;
            object-fit: contain;
            width: 48px;
        }

        .brand-row {
            align-items: center;
            display: flex;
            gap: 14px;
        }

        .brand-name {
            color: #2563EB;
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 3px;
        }

        .report-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 6px;
        }

        .report-meta {
            color: #64748B;
            font-size: 12px;
            margin: 0;
            text-align: right;
        }

        p {
            color: #64748B;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
            font-size: 13px;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #E5E7EB;
            padding: 11px 12px;
            text-align: left;
        }

        th {
            background: #2563EB;
            color: #FFFFFF;
            font-size: 12px;
            letter-spacing: 0;
            text-transform: uppercase;
        }

        tbody tr:nth-child(even) {
            background: #F8FAFC;
        }

        .text-center {
            text-align: center;
        }

        .employee-name {
            font-weight: 600;
        }

        .status-pill {
            border-radius: 999px;
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 10px;
        }

        .status-complete {
            background: #DCFCE7;
            color: #166534;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-late {
            background: #FEE2E2;
            color: #991B1B;
        }

        .status-default {
            background: #E2E8F0;
            color: #334155;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 24px;
        }

        .summary-item {
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 14px;
            position: relative;
        }

        .summary-item::before {
            background: #2563EB;
            border-radius: 999px;
            content: "";
            height: 4px;
            left: 14px;
            position: absolute;
            right: 14px;
            top: 0;
        }

        .summary-item span {
            color: #64748B;
            display: block;
            font-size: 12px;
        }

        .summary-item strong {
            display: block;
            font-size: 22px;
            margin-top: 4px;
        }

        .report-footer {
            align-items: end;
            color: #64748B;
            display: flex;
            font-size: 12px;
            justify-content: space-between;
            margin-top: 28px;
        }

        .signature {
            color: #111827;
            min-width: 190px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #CBD5E1;
            margin-top: 54px;
            padding-top: 8px;
        }

        @media print {
            body {
                background: #FFFFFF;
                padding: 0;
            }

            .report-page {
                border: 0;
                border-radius: 0;
                box-shadow: none;
                padding: 18px;
            }
        }
    </style>
</head>
<body>
    <main class="report-page">
        <header class="report-header">
            <div class="brand-row">
                <img class="brand-logo" src="{{ asset('images/logo-pt-baben.png') }}" alt="Logo PT.BABEN">
                <div>
                    <h1 class="brand-name">PT.BABEN</h1>
                    <p>Laporan kehadiran karyawan</p>
                </div>
            </div>
            <div>
                <h2 class="report-title">Laporan Absensi</h2>
                <p class="report-meta">
                    Periode:
                    {{ $filters['tanggal'] ?? 'Semua tanggal' }}
                </p>
                <p class="report-meta">Dicetak: {{ now()->format('d/m/Y H:i:s') }}</p>
            </div>
        </header>

        <section class="summary">
            <div class="summary-item">
                <span>Total Entri</span>
                <strong>{{ $summary['total'] }}</strong>
            </div>
            <div class="summary-item">
                <span>Hadir Lengkap</span>
                <strong>{{ $summary['hadir_lengkap'] }}</strong>
            </div>
            <div class="summary-item">
                <span>Terlambat</span>
                <strong>{{ $summary['terlambat'] }}</strong>
            </div>
            <div class="summary-item">
                <span>Belum Pulang</span>
                <strong>{{ $summary['belum_pulang'] }}</strong>
            </div>
        </section>

        <table>
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
                    @php
                        $absensi = $karyawan->absensis->first();
                        $statusClass = match ($absensi?->status) {
                            'Hadir' => 'status-complete',
                            'Terlambat' => 'status-late',
                            default => 'status-default',
                        };
                    @endphp
                    <tr>
                        <td class="employee-name">{{ $karyawan->nama }}</td>
                        <td class="text-center">{{ $absensi?->tanggal ? \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y') : '-' }}</td>
                        <td class="text-center">{{ $absensi?->jam_masuk ?? '-' }}</td>
                        <td class="text-center">{{ $absensi?->jam_pulang ?? '-' }}</td>
                        <td class="text-center">
                            <span class="status-pill {{ $statusClass }}">{{ $absensi?->status ?? '-' }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data karyawan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <footer class="report-footer">
            <span>Dokumen dibuat otomatis oleh sistem PT.BABEN.</span>
            <div class="signature">
                <span>Admin</span>
                <div class="signature-line">PT.BABEN</div>
            </div>
        </footer>
    </main>

    <script>
        window.addEventListener('load', () => window.print());
    </script>
</body>
</html>
