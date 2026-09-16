<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE absensis MODIFY status ENUM('Hadir', 'Terlambat', 'Izin', 'Sakit', 'Dinas Luar', 'Belum Pulang', 'Hadir Lengkap') NOT NULL DEFAULT 'Hadir'");
        if (Schema::hasTable('pengajuan_izin')) {
            DB::statement("ALTER TABLE pengajuan_izin MODIFY jenis ENUM('Izin', 'Sakit', 'Dinas Luar') NOT NULL");
        } elseif (Schema::hasTable('pengajuan_izin_sakits')) {
            DB::statement("ALTER TABLE pengajuan_izin_sakits MODIFY jenis ENUM('Izin', 'Sakit', 'Dinas Luar') NOT NULL");
        }
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE absensis MODIFY status ENUM('Hadir', 'Terlambat', 'Izin', 'Sakit', 'Belum Pulang', 'Hadir Lengkap') NOT NULL DEFAULT 'Hadir'");
        if (Schema::hasTable('pengajuan_izin')) {
            DB::statement("ALTER TABLE pengajuan_izin MODIFY jenis ENUM('Izin', 'Sakit') NOT NULL");
        } elseif (Schema::hasTable('pengajuan_izin_sakits')) {
            DB::statement("ALTER TABLE pengajuan_izin_sakits MODIFY jenis ENUM('Izin', 'Sakit') NOT NULL");
        }
    }
};