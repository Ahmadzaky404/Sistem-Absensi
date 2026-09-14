<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'karyawan', 'office_boy', 'direktur', 'direktur_utama') NOT NULL");
        DB::table('users')->where('role', 'direktur')->update(['role' => 'direktur_utama']);
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'direktur_utama')->update(['role' => 'direktur']);
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'karyawan', 'office_boy', 'direktur') NOT NULL");
    }
};