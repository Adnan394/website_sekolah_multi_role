<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id();

            // ── Relasi ke users ──────────────────────────────────
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('users')
                  ->onDelete('cascade');

            // ── Identitas Utama ──────────────────────────────────
            $table->string('nip', 20)->nullable()->unique()->comment('Nomor Induk Pegawai');
            $table->string('nuptk', 20)->nullable()->unique()->comment('Nomor Unik Pendidik & Tenaga Kependidikan');
            $table->string('nama_lengkap');
            $table->string('gelar_depan', 20)->nullable();   // Prof., Dr., dll
            $table->string('gelar_belakang', 30)->nullable(); // S.Pd., M.Pd., dll
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])
                  ->nullable();
            $table->enum('status_pernikahan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])
                  ->nullable();
            $table->string('foto')->nullable();

            // ── Kontak ───────────────────────────────────────────
            $table->string('no_hp', 20)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->string('email_pribadi')->nullable();

            // ── Alamat ───────────────────────────────────────────
            $table->text('alamat')->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();

            // ── Pendidikan ───────────────────────────────────────
            $table->enum('pendidikan_terakhir', ['SMA/SMK', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])
                  ->nullable();
            $table->string('jurusan', 150)->nullable();
            $table->string('universitas', 150)->nullable();
            $table->year('tahun_lulus')->nullable();

            // ── Kepegawaian ──────────────────────────────────────
            $table->enum('status_kepegawaian', ['PNS', 'PPPK', 'GTT', 'Honor', 'Kontrak'])
                  ->default('GTT')
                  ->comment('GTT = Guru Tidak Tetap');
            $table->string('golongan', 10)->nullable()->comment('Untuk PNS, misal: III/a');
            $table->date('tmt_cpns')->nullable()->comment('Tanggal mulai CPNS');
            $table->date('tmt_pns')->nullable()->comment('Tanggal mulai PNS');
            $table->date('tanggal_bergabung')->nullable();
            $table->unsignedTinyInteger('masa_kerja_tahun')->default(0);
            $table->unsignedTinyInteger('masa_kerja_bulan')->default(0);

            // ── Tugas & Jabatan ──────────────────────────────────
            $table->enum('jabatan', [
                'Kepala Sekolah',
                'Wakil Kepala Sekolah',
                'Guru Kelas',
                'Guru Mata Pelajaran',
                'Guru Pendamping',
                'Tenaga Administrasi',
            ])->default('Guru Kelas');

            // ── Sertifikasi ──────────────────────────────────────
            $table->boolean('is_sertifikasi')->default(false);
            $table->year('tahun_sertifikasi')->nullable();
            $table->string('nomor_sertifikasi', 50)->nullable();

            // ── Status ───────────────────────────────────────────
            $table->boolean('is_active')->default(true);
            $table->text('keterangan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};