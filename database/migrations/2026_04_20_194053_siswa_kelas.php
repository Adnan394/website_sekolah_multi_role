<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Siswa
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            
            // Identitas
            $table->string('nisn', 20)->unique()->nullable();
            $table->string('nis', 20)->unique()->nullable();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->nullable();
            
            // Kontak & Alamat
            $table->string('foto')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            
            // Status & Akademik
            $table->year('tahun_masuk')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabel Pivot Kelas Siswa
        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->string('nomor_absen', 5)->nullable();
            $table->enum('status', ['Aktif', 'Lulus', 'Pindah', 'Keluar'])->default('Aktif');
            $table->timestamps();
            
            // Unik agar siswa tidak double di satu kelas yang sama
            $table->unique(['kelas_id', 'siswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_siswa');
        Schema::dropIfExists('siswa');
    }
};