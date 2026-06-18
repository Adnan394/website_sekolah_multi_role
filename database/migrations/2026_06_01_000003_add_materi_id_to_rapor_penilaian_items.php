<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rapor_penilaian_items', function (Blueprint $table) {
            if (! Schema::hasColumn('rapor_penilaian_items', 'materi_id')) {
                $table->foreignId('materi_id')->nullable()->after('guru_id')
                      ->constrained('materi_pembelajaran')
                      ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('rapor_penilaian_items', function (Blueprint $table) {
            if (Schema::hasColumn('rapor_penilaian_items', 'materi_id')) {
                $table->dropConstrainedForeignId('materi_id');
            }
        });
    }
};
