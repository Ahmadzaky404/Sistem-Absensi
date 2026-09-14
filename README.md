# Sistem-Absensi

Aplikasi Manajemen dan Sistem Absensi Karyawan berbasis Laravel dengan dukungan multi-role, geofencing lokasi absen (GPS), pengajuan izin/sakit/dinas luar, dan ekspor laporan.

## Fitur Utama
- **Autentikasi Multi-Role**: Admin, Direktur Utama, Direktur, Karyawan, dan Office Boy.
- **Pencatatan Presensi Real-Time**: Jam masuk, jam pulang, dan kalkulasi status kehadiran (Hadir, Terlambat, Belum Pulang).
- **Validasi Geofencing (GPS)**: Memastikan absensi hanya dapat dilakukan dalam radius lokasi kantor yang ditentukan.
- **Pengajuan Izin, Sakit & Dinas Luar**: Pengajuan online oleh karyawan dan verifikasi/persetujuan oleh Admin.
- **Dashboard Interaktif**: Statistik kehadiran harian/bulanan, aktivitas absensi terbaru, dan pemantauan pengajuan izin.
- **Rekap & Ekspor Laporan**: Unduh laporan kehadiran dalam format Excel dan cetak PDF.

## Persyaratan Sistem
- PHP >= 8.2
- Composer
- Node.js & NPM
- Database MySQL / MariaDB

## Panduan Instalasi
1. Clone repository:
   ```bash
   git clone https://github.com/AchmaddZacky/Sistem-Absensi.git
   cd Sistem-Absensi
   ```
2. Salin file konfigurasi environment:
   ```bash
   cp .env.example .env
   ```
3. Pasang dependensi project:
   ```bash
   composer install
   npm install
   ```
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Sesuaikan kredensial database di `.env`, lalu jalankan migrasi & seeder default:
   ```bash
   php artisan migrate --seed
   ```
6. Jalankan server lokal:
   ```bash
   npm run dev
   php artisan serve
   ```
7. Login Admin default (dari seeder):
   * **Username**: `admin`
   * **Password**: `admin12345`