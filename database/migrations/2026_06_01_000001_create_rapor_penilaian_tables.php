<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapor_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->string('tahun_pelajaran')->nullable();
            $table->string('semester')->nullable();
            $table->float('nilai_total')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rapor_penilaian_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapor_id')->constrained('rapor_penilaian')->cascadeOnDelete();
            $table->foreignId('guru_id')->nullable()->constrained('guru')->nullOnDelete();
            $table->string('jenis'); // materi, tugas, kehadiran, keaktifan
            $table->float('nilai')->nullable();
            $table->text('komentar')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapor_penilaian_items');
        Schema::dropIfExists('rapor_penilaian');
    }
};
