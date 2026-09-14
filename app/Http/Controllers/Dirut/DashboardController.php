<?php

namespace App\Http\Controllers\Dirut;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        abort_if(auth()->user()->role !== 'direktur_utama', 403);

        $today = Carbon::now();
        $totalKaryawan = User::whereIn('role', ['direktur', 'karyawan', 'office_boy'])->count();
        $hadirHariIni = Absensi::whereDate('tanggal', $today->toDateString())
            ->whereNotIn('status', ['Izin', 'Sakit', 'Dinas Luar'])
            ->count();

        return view('dirut.dashboard', [
            'totalKaryawan' => $totalKaryawan,
            'hadirHariIni' => $hadirHariIni,
            'belumAbsen' => max($totalKaryawan - $hadirHariIni, 0),
            'absensiBulanIni' => Absensi::whereYear('tanggal', $today->year)
                ->whereMonth('tanggal', $today->month)
                ->count(),
        ]);
    }
}