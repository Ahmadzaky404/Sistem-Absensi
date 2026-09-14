<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LokasiAbsen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LokasiAbsenController extends Controller
{
    public function index(): View
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        return view('admin.lokasi_absen', [
            'lokasiAbsens' => LokasiAbsen::orderBy('nama_lokasi')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if($request->user()->role !== 'admin', 403);
        LokasiAbsen::create($this->validatedData($request));

        return redirect()->route('admin.lokasi-absen.index')->with('success', 'Lokasi absensi berhasil ditambahkan.');
    }

    public function update(Request $request, LokasiAbsen $lokasiAbsen): RedirectResponse
    {
        abort_if($request->user()->role !== 'admin', 403);
        $lokasiAbsen->update($this->validatedData($request));

        return redirect()->route('admin.lokasi-absen.index')->with('success', 'Lokasi absensi berhasil diperbarui.');
    }

    public function destroy(Request $request, LokasiAbsen $lokasiAbsen): RedirectResponse
    {
        abort_if($request->user()->role !== 'admin', 403);
        $lokasiAbsen->delete();

        return redirect()->route('admin.lokasi-absen.index')->with('success', 'Lokasi absensi berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'nama_lokasi' => ['required', 'string', 'max:100'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius' => ['required', 'integer', 'min:10', 'max:100000'],
        ]);
    }
}
