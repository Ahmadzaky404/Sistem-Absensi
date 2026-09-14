<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE absensis MODIFY status ENUM('Belum Pulang', 'Hadir Lengkap', 'Terlambat', 'Izin', 'Sakit') NOT NULL DEFAULT 'Belum Pulang'");

        Schema::create('pengajuan_izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('jenis', ['Izin', 'Sakit']);
            $table->text('alasan')->nullable();
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->text('keterangan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_izin');
    }
};