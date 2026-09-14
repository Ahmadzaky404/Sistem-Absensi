<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        body {
            color: #111827;
            font-family: Arial, sans-serif;
        }

        .brand {
            color: #2563EB;
            font-size: 22px;
            font-weight: 700;
        }

        .title {
            font-size: 18px;
            font-weight: 700;
        }

        .muted {
            color: #64748B;
            font-size: 12px;
        }

        .summary-label {
            background: #F8FAFC;
            color: #475569;
            font-weight: 700;
        }

        .summary-value {
            color: #111827;
            font-size: 16px;
            font-weight: 700;
        }

        table {
            border-collapse: collapse;
        }

        th {
            background: #2563EB;
            color: #FFFFFF;
            font-weight: 700;
            text-align: center;
        }

        td,
        th {
            border: 1px solid #CBD5E1;
            padding: 8px;
        }

        .center {
            text-align: center;
        }

        .status {
            font-weight: 700;
            text-align: center;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="5" class="brand">PT.BABEN</td>
        </tr>
        <tr>
            <td colspan="5" class="title">Laporan Absensi Karyawan</td>
        </tr>
        <tr>
            <td colspan="5" class="muted">
                Periode:
                {{ $filters['tanggal'] ?? 'Semua tanggal' }}
            </td>
        </tr>
        <tr>
            <td colspan="5" class="muted">Dicetak: {{ now()->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td class="summary-label">Total Entri</td>
            <td class="summary-label">Hadir Lengkap</td>
            <td class="summary-label">Terlambat</td>
            <td class="summary-label">Belum Pulang</td>
            <td class="summary-label">Total Karyawan</td>
        </tr>
        <tr>
            <td class="summary-value center">{{ $summary['total'] }}</td>
            <td class="summary-value center">{{ $summary['hadir_lengkap'] }}</td>
            <td class="summary-value center">{{ $summary['terlambat'] }}</td>
            <td class="summary-value center">{{ $summary['belum_pulang'] }}</td>
            <td class="summary-value center">{{ $laporan->count() }}</td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <th>Nama Karyawan</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Status</th>
        </tr>
        @forelse ($laporan as $karyawan)
            @php($absensi = $karyawan->absensis->first())
            <tr>
                <td>{{ $karyawan->nama }}</td>
                <td class="center">{{ $absensi?->tanggal?->format('d/m/Y') ?? '-' }}</td>
                <td class="center">{{ $absensi?->jam_masuk ?? '-' }}</td>
                <td class="center">{{ $absensi?->jam_pulang ?? '-' }}</td>
                <td class="status">{{ $absensi?->status ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="center">Belum ada data karyawan.</td>
            </tr>
        @endforelse
    </table>
</body>
</html>
