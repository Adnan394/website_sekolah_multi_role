<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tugas_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_tugas_id')->constrained('jadwal_tugas')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->enum('status', ['Belum Mengumpulkan','Sudah Mengumpulkan','Dinilai'])->default('Belum Mengumpulkan');
            $table->string('file_upload')->nullable();
            $table->string('link_upload')->nullable();
            $table->unsignedTinyInteger('nilai')->nullable();
            $table->text('komentar')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['jadwal_tugas_id', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas_siswa');
    }
};