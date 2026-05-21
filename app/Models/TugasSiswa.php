<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TugasSiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tugas_siswas';

    protected $fillable = [
        'jadwal_tugas_id',
        'siswa_id',
        'status',       // Belum Mengumpulkan, Sudah Mengumpulkan, Dinilai
        'file_upload',  // file yang diunggah siswa
        'link_upload',  // optional link
        'nilai',        // nilai dari guru
        'komentar',     // komentar guru
    ];

    protected $casts = [
        'nilai' => 'integer',
    ];

    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswa::class);
    }

    public function jadwalTugas()
    {
        return $this->belongsTo(\App\Models\JadwalTugas::class);
    }

    public static function listStatus(): array
    {
        return ['Belum Mengumpulkan', 'Sudah Mengumpulkan', 'Dinilai'];
    }
}