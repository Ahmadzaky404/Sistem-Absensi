@extends('layouts.admin')

@section('title', 'Kelola Karyawan')

@section('content')
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title h3 mb-1">Kelola Karyawan</h1>
            <p class="text-secondary mb-0">Kelola akun login karyawan PT.BABEN.</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKaryawan">
            <i class="fa-solid fa-plus me-2"></i>Tambah Karyawan
        </button>
    </div>

    <div class="soft-card p-4">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($karyawans as $karyawan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $karyawan->nama }}</td>
                            <td>{{ $karyawan->username }}</td>
                            <td>
                                @php
                                    $roleIcon = match ($karyawan->role) {
                                        'direktur_utama', 'direktur' => 'fa-user-tie',
                                        'office_boy' => 'fa-broom',
                                        default => 'fa-user',
                                    };
                                    $roleClass = match ($karyawan->role) {
                                        'direktur_utama' => 'text-bg-danger',
                                        'direktur' => 'text-bg-warning',
                                        'office_boy' => 'text-bg-success',
                                        default => 'text-bg-primary',
                                    };
                                @endphp
                                <span class="badge badge-status {{ $roleClass }}">
                                    <i class="fa-solid {{ $roleIcon }} me-1"></i>{{ $karyawan->role === 'direktur_utama' ? 'Direktur Utama' : str($karyawan->role)->replace('_', ' ')->title() }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalLihatKaryawan{{ $karyawan->id }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditKaryawan{{ $karyawan->id }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.karyawan.destroy', $karyawan) }}" data-confirm-delete>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-4">Belum ada data karyawan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalTambahKaryawan" tabindex="-1" aria-labelledby="modalTambahKaryawanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('admin.karyawan.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title h5 fw-bold" id="modalTambahKaryawanLabel">Tambah Karyawan</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div>
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="direktur_utama" @selected(old('role') === 'direktur_utama')>Direktur Utama</option>
                            <option value="direktur" @selected(old('role') === 'direktur')>Direktur</option>
                            <option value="karyawan" @selected(old('role') === 'karyawan')>Karyawan</option>
                            <option value="office_boy" @selected(old('role') === 'office_boy')>Office Boy</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @foreach ($karyawans as $karyawan)
        <div class="modal fade" id="modalLihatKaryawan{{ $karyawan->id }}" tabindex="-1" aria-labelledby="modalLihatKaryawanLabel{{ $karyawan->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title h5 fw-bold" id="modalLihatKaryawanLabel{{ $karyawan->id }}">Detail Karyawan</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4 text-secondary">No.</dt>
                            <dd class="col-sm-8">{{ $loop->iteration }}</dd>
                            <dt class="col-sm-4 text-secondary">Nama</dt>
                            <dd class="col-sm-8">{{ $karyawan->nama }}</dd>
                            <dt class="col-sm-4 text-secondary">Username</dt>
                            <dd class="col-sm-8">{{ $karyawan->username }}</dd>
                            <dt class="col-sm-4 text-secondary">Role</dt>
                            <dd class="col-sm-8">{{ $karyawan->role === 'direktur_utama' ? 'Direktur Utama' : str($karyawan->role)->replace('_', ' ')->title() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditKaryawan{{ $karyawan->id }}" tabindex="-1" aria-labelledby="modalEditKaryawanLabel{{ $karyawan->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form method="POST" action="{{ route('admin.karyawan.update', $karyawan) }}" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h2 class="modal-title h5 fw-bold" id="modalEditKaryawanLabel{{ $karyawan->id }}">Edit Karyawan</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama{{ $karyawan->id }}" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama{{ $karyawan->id }}" name="nama" value="{{ old('nama', $karyawan->nama) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="username{{ $karyawan->id }}" class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control" id="username{{ $karyawan->id }}" name="username" value="{{ old('username', $karyawan->username) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password{{ $karyawan->id }}" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password{{ $karyawan->id }}" name="password" placeholder="Kosongkan jika tidak diganti">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="role{{ $karyawan->id }}" class="form-label fw-semibold">Role</label>
                            <select class="form-select" id="role{{ $karyawan->id }}" name="role" required>
                                <option value="direktur_utama" @selected(old('role', $karyawan->role) === 'direktur_utama')>Direktur Utama</option>
                                <option value="direktur" @selected(old('role', $karyawan->role) === 'direktur')>Direktur</option>
                                <option value="karyawan" @selected(old('role', $karyawan->role) === 'karyawan')>Karyawan</option>
                                <option value="office_boy" @selected(old('role', $karyawan->role) === 'office_boy')>Office Boy</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
