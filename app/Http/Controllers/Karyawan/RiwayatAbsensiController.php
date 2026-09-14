<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiwayatAbsensiController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if (! in_array(auth()->user()->role, ['direktur_utama', 'direktur', 'karyawan', 'office_boy'], true)) {
            return redirect()->route('admin.dashboard');
        }

        $data = $request->validate([
            'bulan' => ['nullable', 'date_format:Y-m'],
        ]);
        $bulanDipilih = $data['bulan'] ?? null;

        $queryRiwayat = Absensi::where('user_id', auth()->id());
        $bulanTersedia = (clone $queryRiwayat)
            ->select('tanggal')
            ->latest('tanggal')
            ->get()
            ->map(fn (Absensi $absensi) => $absensi->tanggal->format('Y-m'))
            ->unique()
            ->values();

        if ($bulanDipilih) {
            $bulan = Carbon::createFromFormat('!Y-m', $bulanDipilih);
            $queryRiwayat
                ->whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month);
        }

        $riwayat = $queryRiwayat
            ->latest('tanggal')
            ->latest('jam_masuk')
            ->get();

        $statistik = [
            'total_hadir' => $riwayat->count(),
            'lengkap' => $riwayat->where('status', 'Hadir')->whereNotNull('jam_pulang')->count(),
            'belum_pulang' => $riwayat->whereNull('jam_pulang')->whereIn('status', ['Hadir', 'Terlambat'])->count(),
        ];

        return view('karyawan.riwayat', compact('riwayat', 'statistik', 'bulanDipilih', 'bulanTersedia'));
    }
}