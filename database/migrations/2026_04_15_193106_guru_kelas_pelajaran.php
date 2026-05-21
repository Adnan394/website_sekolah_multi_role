<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Master Pelajaran (harus sebelum kelas_guru) ────────
        Schema::create('pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pelajaran', 20)->unique();
            $table->string('nama_pelajaran', 150);
            $table->enum('kategori', [
                'Wajib', 'Muatan Lokal', 'Pengembangan Diri', 'Ekstrakurikuler'
            ])->default('Wajib');
            $table->unsignedTinyInteger('tingkat_min')->default(1)->comment('Berlaku mulai kelas');
            $table->unsignedTinyInteger('tingkat_max')->default(6)->comment('Berlaku sampai kelas');
            $table->unsignedTinyInteger('jam_per_minggu')->default(2);
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // ── 2. Pivot: Guru ↔ Kelas ─────────────────────────────────
        Schema::create('kelas_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');
            $table->enum('jabatan', ['wali_kelas', 'guru_mapel'])->default('guru_mapel');
            $table->foreignId('pelajaran_id')->nullable()->constrained('pelajaran')->onDelete('set null');
            $table->timestamps();
            $table->unique(['kelas_id', 'guru_id', 'jabatan', 'pelajaran_id'], 'unique_kelas_guru');
        });

        // ── 3. Materi Pembelajaran ─────────────────────────────────
        Schema::create('materi_pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('pelajaran_id')->constrained('pelajaran')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');
            $table->string('judul', 200);
            $table->text('deskripsi')->nullable();
            $table->string('file_materi')->nullable()->comment('Path file upload');
            $table->string('link_materi')->nullable()->comment('URL eksternal / Google Drive');
            $table->enum('tipe', ['Dokumen', 'Video', 'Link', 'Teks'])->default('Teks');
            $table->date('tanggal_upload');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // ── 4. Jadwal Tugas ────────────────────────────────────────
        Schema::create('jadwal_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('pelajaran_id')->constrained('pelajaran')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');
            $table->string('judul_tugas', 200);
            $table->text('deskripsi')->nullable();
            $table->string('file_tugas')->nullable();
            $table->datetime('tanggal_mulai');
            $table->datetime('tenggat_waktu');
            $table->enum('tipe_pengumpulan', ['File', 'Teks', 'Link', 'Offline'])->default('File');
            $table->unsignedTinyInteger('nilai_maksimal')->default(100);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // ── 5. Jadwal Pelajaran ────────────────────────────────────
        Schema::create('jadwal_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('pelajaran_id')->constrained('pelajaran')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');
            $table->enum('hari', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'])
                  ->default('Senin');
            $table->unsignedTinyInteger('jam_ke');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruangan', 50)->nullable();
            $table->string('tahun_pelajaran', 9);
            $table->string('semester')->default('Ganjil');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Cegah bentrok: kelas + hari + jam yang sama
            $table->unique(['kelas_id', 'hari', 'jam_ke', 'tahun_pelajaran', 'semester'], 'unique_jadwal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pelajaran');
        Schema::dropIfExists('jadwal_tugas');
        Schema::dropIfExists('materi_pembelajaran');
        Schema::dropIfExists('kelas_guru');
        Schema::dropIfExists('pelajaran');
    }
};