<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rapor_penilaian_items', function (Blueprint $table) {
            if (! Schema::hasColumn('rapor_penilaian_items', 'pelajaran_id')) {
                $table->foreignId('pelajaran_id')->nullable()->after('materi_id')
                      ->constrained('pelajaran')
                      ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('rapor_penilaian_items', function (Blueprint $table) {
            if (Schema::hasColumn('rapor_penilaian_items', 'pelajaran_id')) {
                $table->dropConstrainedForeignId('pelajaran_id');
            }
        });
    }
};
