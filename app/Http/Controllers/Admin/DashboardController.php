<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\PengajuanIzinSakit;
use App\Models\User;
use App\Services\AbsensiOtomatisService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private AbsensiOtomatisService $absensiOtomatis) {}

    public function index(): View
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        $today = Carbon::now();
        $tanggalHariIni = $today->toDateString();
        $mulaiBulan = $today->copy()->startOfMonth()->toDateString();
        $akhirBulan = $today->copy()->endOfMonth()->toDateString();
        $totalKaryawan = User::whereIn('role', ['direktur_utama', 'direktur', 'karyawan', 'office_boy'])->count();
        $absensiHariIni = Absensi::where('tanggal', $tanggalHariIni)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
        $hadirHariIni = $absensiHariIni->except(['Izin', 'Sakit', 'Dinas Luar'])->sum();
        $izinAtauSakitHariIni = $absensiHariIni->only(['Izin', 'Sakit', 'Dinas Luar'])->sum();
        $belumAbsen = max($totalKaryawan - $hadirHariIni - $izinAtauSakitHariIni, 0);
        $absensiBulanIni = Absensi::whereBetween('tanggal', [$mulaiBulan, $akhirBulan])->count();
        $aktivitasTerbaru = User::whereIn('role', ['direktur_utama', 'direktur', 'karyawan', 'office_boy'])
            ->select(['id', 'nama', 'username'])
            ->with(['absensis' => fn ($query) => $query->where('tanggal', $tanggalHariIni)])
            ->orderBy('nama')
            ->get();
        $pengajuanMenunggu = PengajuanIzinSakit::with(['user:id,nama'])
            ->where('status', 'Menunggu')
            ->oldest('created_at')
            ->get();
        $kategoriGrafik = ['Hadir', 'Izin', 'Sakit', 'Dinas Luar'];
        $grafikKehadiran = ['labels' => [], 'series' => array_fill_keys($kategoriGrafik, [])];

        $grafikKehadiran['labels'][] = $today->format('d/m');
        foreach ($kategoriGrafik as $kategori) {
            $grafikKehadiran['series'][$kategori][] = $kategori === 'Hadir'
                ? $hadirHariIni
                : $absensiHariIni->get($kategori, 0);
        }

        return view('admin.dashboard', compact('totalKaryawan', 'hadirHariIni', 'izinAtauSakitHariIni', 'belumAbsen', 'absensiBulanIni', 'aktivitasTerbaru', 'pengajuanMenunggu', 'grafikKehadiran'));
    }

    public function setujuiPengajuan(PengajuanIzinSakit $pengajuan): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        try {
            DB::transaction(function () use ($pengajuan) {
                $pengajuan = PengajuanIzinSakit::lockForUpdate()->findOrFail($pengajuan->id);
                if ($pengajuan->status !== 'Menunggu') abort(422, 'Pengajuan ini sudah diproses.');
                if (Absensi::where('user_id', $pengajuan->user_id)->whereBetween('tanggal', [$pengajuan->tanggal_mulai, $pengajuan->tanggal_selesai])->exists()) abort(422, 'Absensi karyawan untuk tanggal ini sudah tercatat.');
                $tanggalMulai = $pengajuan->tanggal_mulai->copy();
                $tanggalSelesai = $pengajuan->tanggal_selesai->copy();
                while ($tanggalMulai->lte($tanggalSelesai)) {
                    Absensi::create(['user_id' => $pengajuan->user_id, 'tanggal' => $tanggalMulai->toDateString(), 'status' => $pengajuan->jenis]);
                    $tanggalMulai->addDay();
                }
                $pengajuan->update(['status' => 'Disetujui', 'keterangan_admin' => 'Pengajuan disetujui.']);
            });
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $exception) {
            return redirect()->route('admin.dashboard')->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.dashboard')->with('success', 'Pengajuan berhasil disetujui dan absensi karyawan telah dicatat.');
    }
}
