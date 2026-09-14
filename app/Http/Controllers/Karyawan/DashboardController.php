<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\LokasiAbsen;
use App\Models\PengajuanIzinSakit;
use App\Services\AbsensiOtomatisService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private const WAKTU_WIB = 'Asia/Jakarta';
    public function __construct(private AbsensiOtomatisService $absensiOtomatis)
    {
    }

    public function index(): View|RedirectResponse
    {
        if (! in_array(auth()->user()->role, ['direktur_utama', 'direktur', 'karyawan', 'office_boy'], true)) {
            return redirect()->route('admin.dashboard');
        }

        $this->absensiOtomatis->tutupAbsensiYangBelumPulang();

        $today = Carbon::now(self::WAKTU_WIB)->toDateString();
        $bulanIni = Carbon::now(self::WAKTU_WIB);
        $absensiHariIni = Absensi::where('user_id', auth()->id())
            ->whereDate('tanggal', $today)
            ->first();
        $pengajuanHariIni = PengajuanIzinSakit::where('user_id', auth()->id())
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->where('status', 'Menunggu')
            ->first();

        $statistik = [
            'hari_hadir' => Absensi::where('user_id', auth()->id())
                ->whereYear('tanggal', $bulanIni->year)
                ->whereMonth('tanggal', $bulanIni->month)
                ->count(),
            'lengkap' => Absensi::where('user_id', auth()->id())
                ->whereYear('tanggal', $bulanIni->year)
                ->whereMonth('tanggal', $bulanIni->month)
                ->where('status', 'Hadir')
                ->count(),
            'belum_pulang' => Absensi::where('user_id', auth()->id())
                ->whereYear('tanggal', $bulanIni->year)
                ->whereMonth('tanggal', $bulanIni->month)
                ->whereNull('jam_pulang')
                ->whereIn('status', ['Hadir', 'Terlambat'])
                ->count(),
        ];

        $dashboardTitle = match (auth()->user()->role) {
            'direktur_utama' => 'Dashboard Direktur Utama',
            'direktur' => 'Dashboard Direktur',
            'office_boy' => 'Dashboard Office Boy',
            default => 'Dashboard Karyawan',
        };

        return view('karyawan.dashboard', compact('absensiHariIni', 'pengajuanHariIni', 'statistik', 'dashboardTitle'));
    }

    public function absenMasuk(Request $request): RedirectResponse
    {
        if (! in_array($request->user()->role, ['direktur_utama', 'direktur', 'karyawan', 'office_boy'], true)) {
            abort(403);
        }

        if ($pesanLokasi = $this->pesanLokasiTidakValid($request)) {
            return redirect()->route($this->dashboardRoute($request))->with('error', $pesanLokasi);
        }

        // Waktu absensi harus selalu mengikuti WIB, terlepas dari timezone PHP/server.
        $now = Carbon::now(self::WAKTU_WIB);
        $this->absensiOtomatis->tutupAbsensiYangBelumPulang();

        if ($now->hour < 7) {
            return redirect()->route($this->dashboardRoute($request))->with('error', 'Absen masuk tersedia mulai pukul 07:00.');
        }

        $absensi = Absensi::where('user_id', $request->user()->id)
            ->whereDate('tanggal', $now->toDateString())
            ->first();

        $pengajuanMenunggu = PengajuanIzinSakit::where('user_id', $request->user()->id)
            ->whereDate('tanggal_mulai', '<=', $now->toDateString())
            ->whereDate('tanggal_selesai', '>=', $now->toDateString())
            ->where('status', 'Menunggu')
            ->exists();

        if ($pengajuanMenunggu) {
            return redirect()->route($this->dashboardRoute($request))->with('error', 'Pengajuan izin, sakit, atau dinas luar Anda masih menunggu persetujuan admin.');
        }

        if ($absensi && $absensi->jam_masuk) {
            return redirect()->route($this->dashboardRoute($request))->with('error', 'Anda sudah absen masuk hari ini.');
        }

        Absensi::create([
            'user_id' => $request->user()->id,
            'tanggal' => $now->toDateString(),
            'jam_masuk' => $now->format('H:i:s'),
            'status' => $request->user()->role === 'office_boy'
                ? ($now->greaterThan($now->copy()->setTime(10, 0)) ? 'Terlambat' : 'Hadir')
                : ($now->greaterThan($now->copy()->setTime(12, 0)) ? 'Terlambat' : 'Hadir'),
        ]);

        return redirect()->route($this->dashboardRoute($request))->with('success', 'Absen masuk berhasil dicatat!');
    }

    public function absenPulang(Request $request): RedirectResponse
    {
        if (! in_array($request->user()->role, ['direktur_utama', 'direktur', 'karyawan', 'office_boy'], true)) {
            abort(403);
        }

        if ($pesanLokasi = $this->pesanLokasiTidakValid($request)) {
            return redirect()->route($this->dashboardRoute($request))->with('error', $pesanLokasi);
        }

        $now = Carbon::now(self::WAKTU_WIB);
        $this->absensiOtomatis->tutupAbsensiYangBelumPulang();
        $absensi = Absensi::where('user_id', $request->user()->id)
            ->whereDate('tanggal', $now->toDateString())
            ->first();

        if (! $absensi || ! $absensi->jam_masuk) {
            return redirect()->route($this->dashboardRoute($request))->with('error', 'Silakan absen masuk terlebih dahulu.');
        }

        if ($absensi->jam_pulang) {
            return redirect()->route($this->dashboardRoute($request))->with('error', 'Anda sudah absen pulang hari ini.');
        }

        try {
            // Do not leave the employee waiting for MySQL's default lock timeout.
            DB::statement('SET SESSION innodb_lock_wait_timeout = 3');

            $updated = Absensi::whereKey($absensi->id)
                ->whereNull('jam_pulang')
                ->update([
                    'jam_pulang' => $now->format('H:i:s'),
                    'status' => $absensi->status === 'Terlambat' ? 'Terlambat' : 'Hadir',
                ]);
        } catch (QueryException $exception) {
            return redirect()->route($this->dashboardRoute($request))->with(
                'error',
                'Absensi sedang diproses. Silakan coba lagi dalam beberapa saat.'
            );
        }

        if ($updated === 0) {
            return redirect()->route($this->dashboardRoute($request))->with('error', 'Anda sudah absen pulang hari ini.');
        }

        return redirect()->route($this->dashboardRoute($request))->with('success', 'Absen pulang berhasil dicatat!');
    }

    public function ajukanIzinSakit(Request $request): RedirectResponse
    {
        if (! in_array($request->user()->role, ['direktur_utama', 'direktur', 'karyawan', 'office_boy'], true)) {
            abort(403);
        }

        $data = $request->validate([
            'jenis' => ['required', 'in:Izin,Sakit,Dinas Luar'],
            'alasan' => ['nullable', 'string'],
        ]);
        $today = Carbon::now(self::WAKTU_WIB)->toDateString();
        $alasan = trim((string) ($data['alasan'] ?? ''));

        if (Absensi::where('user_id', $request->user()->id)->whereDate('tanggal', $today)->exists()) {
            return redirect()->route($this->dashboardRoute($request))->with('error', 'Absensi hari ini sudah tercatat.');
        }

        $pengajuan = PengajuanIzinSakit::firstOrCreate(
            ['user_id' => $request->user()->id, 'tanggal_mulai' => $today, 'tanggal_selesai' => $today],
            [
                'jenis' => $data['jenis'],
                'alasan' => $alasan !== '' ? $alasan : 'Pengajuan '.$data['jenis'].' melalui dashboard.',
                'status' => 'Menunggu',
            ]
        );

        if (! $pengajuan->wasRecentlyCreated) {
            return redirect()->route($this->dashboardRoute($request))->with('error', 'Pengajuan izin, sakit, atau dinas luar untuk hari ini sudah dibuat.');
        }

        return redirect()->route($this->dashboardRoute($request))->with('success', 'Pengajuan '.$data['jenis'].' berhasil dikirim dan menunggu persetujuan admin.');
    }

    private function dashboardRoute(Request $request): string
    {
        return match ($request->user()->role) {
            'direktur_utama' => 'dirut.dashboard',
            'direktur' => 'direktur.dashboard',
            'office_boy' => 'office-boy.dashboard',
            default => 'karyawan.dashboard',
        };
    }

    private function pesanLokasiTidakValid(Request $request): ?string
    {
        $data = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ], [
            'latitude.required' => 'Lokasi GPS diperlukan untuk melakukan absensi.',
            'longitude.required' => 'Lokasi GPS diperlukan untuk melakukan absensi.',
        ]);

        $lokasiAbsens = LokasiAbsen::all();
        if ($lokasiAbsens->isEmpty()) {
            return 'Lokasi absensi belum diatur oleh admin.';
        }

        foreach ($lokasiAbsens as $lokasi) {
            $jarak = $this->jarakDalamMeter(
                (float) $data['latitude'],
                (float) $data['longitude'],
                $lokasi->latitude,
                $lokasi->longitude
            );

            if ($jarak <= $lokasi->radius) {
                return null;
            }
        }

        return 'Absensi ditolak karena Anda berada di luar radius lokasi absensi.';
    }

    private function jarakDalamMeter(float $latitudeAwal, float $longitudeAwal, float $latitudeTujuan, float $longitudeTujuan): float
    {
        $latitude = deg2rad($latitudeTujuan - $latitudeAwal);
        $longitude = deg2rad($longitudeTujuan - $longitudeAwal);
        $a = sin($latitude / 2) ** 2
            + cos(deg2rad($latitudeAwal)) * cos(deg2rad($latitudeTujuan)) * sin($longitude / 2) ** 2;

        return 6371000 * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
