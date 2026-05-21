<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');

            $table->date('tanggal');
            $table->enum('status', ['Belum Absen','Hadir','Sakit','Izin','Alfa'])->default('Belum Absen');
            $table->text('keterangan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['kelas_id', 'siswa_id', 'tanggal'], 'absensi_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};