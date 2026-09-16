<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE absensis MODIFY status ENUM('Hadir', 'Terlambat', 'Izin', 'Sakit', 'Dinas Luar', 'Belum Pulang', 'Hadir Lengkap') NOT NULL DEFAULT 'Hadir'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE absensis MODIFY status ENUM('Belum Pulang', 'Hadir Lengkap', 'Terlambat', 'Izin', 'Sakit', 'Dinas Luar') NOT NULL DEFAULT 'Belum Pulang'");
    }
};