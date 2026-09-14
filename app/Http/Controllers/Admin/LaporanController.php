<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        abort_if($request->user()->role !== 'admin', 403);
        $filters = $this->filters($request);
        $laporan = $this->queryLaporan($filters)->get();

        return view('admin.laporan.index', ['laporan' => $laporan, 'summary' => $this->summary($laporan), 'filters' => $filters]);
    }

    public function exportExcel(Request $request): Response
    {
        abort_if($request->user()->role !== 'admin', 403);
        $filters = $this->filters($request);
        $laporan = $this->queryLaporan($filters)->get();
        $content = view('admin.laporan.excel', ['laporan' => $laporan, 'summary' => $this->summary($laporan), 'filters' => $filters])->render();

        return response($content, 200, ['Content-Type' => 'application/vnd.ms-excel; charset=UTF-8', 'Content-Disposition' => 'attachment; filename="laporan-absensi.xls"']);
    }

    public function cetakPdf(Request $request): View
    {
        abort_if($request->user()->role !== 'admin', 403);
        $filters = $this->filters($request);
        $laporan = $this->queryLaporan($filters)->get();

        return view('admin.laporan.cetak', ['laporan' => $laporan, 'summary' => $this->summary($laporan), 'filters' => $filters]);
    }

    private function queryLaporan(array $filters)
    {
        return User::whereIn('role', ['direktur_utama', 'direktur', 'karyawan', 'office_boy'])
            ->with(['absensis' => fn ($query) => $query->whereDate('tanggal', $filters['tanggal'])])
            ->orderBy('nama');
    }

    private function filters(Request $request): array
    {
        $filters = $request->validate([
            'hari' => ['nullable', 'integer', 'between:1,31'],
            'bulan' => ['nullable', 'integer', 'between:1,12'],
            'tahun' => ['nullable', 'integer', 'between:2020,2100'],
        ]);
        $dipilih = array_filter([$filters['hari'] ?? null, $filters['bulan'] ?? null, $filters['tahun'] ?? null], fn ($nilai) => $nilai !== null);

        if ($dipilih && count($dipilih) !== 3) {
            throw ValidationException::withMessages(['tanggal' => 'Pilih hari, bulan, dan tahun secara lengkap.']);
        }
        if ($dipilih && ! checkdate((int) $filters['bulan'], (int) $filters['hari'], (int) $filters['tahun'])) {
            throw ValidationException::withMessages(['tanggal' => 'Tanggal yang dipilih tidak valid.']);
        }
        if (! $dipilih) {
            $filters['hari'] = now()->day;
            $filters['bulan'] = now()->month;
            $filters['tahun'] = now()->year;
        }
        $filters['tanggal'] = sprintf('%04d-%02d-%02d', $filters['tahun'], $filters['bulan'], $filters['hari']);

        return $filters;
    }

    private function summary($laporan): array
    {
        $absensis = $laporan->map(fn ($karyawan) => $karyawan->absensis->first())->filter();

        return [
            'total' => $absensis->count(),
            'hadir_lengkap' => $absensis->where('status', 'Hadir')->whereNotNull('jam_pulang')->count(),
            'terlambat' => $absensis->where('status', 'Terlambat')->count(),
            'belum_pulang' => $absensis->whereNull('jam_pulang')->whereIn('status', ['Hadir', 'Terlambat'])->count(),
        ];
    }
}