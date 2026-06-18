<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add jam_ke and created_by to absensi
        if (Schema::hasTable('absensi')) {
            if (! Schema::hasColumn('absensi', 'jam_ke')) {
                Schema::table('absensi', function (Blueprint $table) {
                    $table->unsignedTinyInteger('jam_ke')->default(1)->after('tanggal');
                });
            }
            if (! Schema::hasColumn('absensi', 'created_by')) {
                Schema::table('absensi', function (Blueprint $table) {
                    $table->unsignedBigInteger('created_by')->nullable()->after('keterangan')->index();
                });
            }
        }

        $tables = ['jadwal_pelajaran','materi_pembelajaran','jadwal_tugas','prestasi','berita','kontak_kamis'];
        foreach ($tables as $t) {
            if (Schema::hasTable($t) && ! Schema::hasColumn($t, 'created_by')) {
                Schema::table($t, function (Blueprint $table) use ($t) {
                    $table->unsignedBigInteger('created_by')->nullable()->after('id')->index();
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('absensi')) {
            Schema::table('absensi', function (Blueprint $table) {
                if (Schema::hasColumn('absensi', 'jam_ke')) $table->dropColumn('jam_ke');
                if (Schema::hasColumn('absensi', 'created_by')) $table->dropColumn('created_by');
            });
        }

        $tables = ['jadwal_pelajaran','materi_pembelajaran','jadwal_tugas','prestasi','berita','kontak_kamis'];
        foreach ($tables as $t) {
            if (Schema::hasTable($t) && Schema::hasColumn($t, 'created_by')) {
                Schema::table($t, function (Blueprint $table) use ($t) {
                    $table->dropColumn('created_by');
                });
            }
        }
    }
};
