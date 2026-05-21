<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');           // e.g. "1A", "2B"
            $table->tinyInteger('tingkat');          // 1 - 6
            $table->string('kode_kelas')->unique();  // e.g. "2024/2025-1A"
            $table->string('tahun_pelajaran', 9);    // e.g. "2024/2025"
            $table->string('semester')->default('Ganjil'); // Ganjil / Genap
            $table->integer('kapasitas')->default(30);
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};