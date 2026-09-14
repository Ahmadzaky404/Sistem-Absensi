<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KaryawanController extends Controller
{
    private const ROLES = ['direktur_utama', 'direktur', 'karyawan', 'office_boy'];

    public function index(): View
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $karyawans = User::whereIn('role', self::ROLES)->latest('id')->get();

        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if($request->user()->role !== 'admin', 403);

        $request->merge([
            'nama' => trim((string) $request->input('nama')),
            'username' => trim((string) $request->input('username')),
        ]);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', Rule::in(self::ROLES)],
        ]);

        User::create([
            'nama' => $data['nama'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function update(Request $request, User $karyawan): RedirectResponse
    {
        abort_if($request->user()->role !== 'admin', 403);
        abort_unless(in_array($karyawan->role, self::ROLES, true), 404);

        $request->merge([
            'nama' => trim((string) $request->input('nama')),
            'username' => trim((string) $request->input('username')),
        ]);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($karyawan->id),
            ],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', Rule::in(self::ROLES)],
        ]);

        $karyawan->fill([
            'nama' => $data['nama'],
            'username' => $data['username'],
            'role' => $data['role'],
        ]);

        if (! empty($data['password'])) {
            $karyawan->password = Hash::make($data['password']);
        }

        $karyawan->save();

        return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(User $karyawan): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        abort_unless(in_array($karyawan->role, self::ROLES, true), 404);

        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan berhasil dihapus.');
    }
}