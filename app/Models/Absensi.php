<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'absensi';

    protected $fillable = [
        'kelas_id',
        'siswa_id',
        'tanggal',
        'status',       // Hadir, Sakit, Izin, Alfa, Belum Absen
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Helper: cek apakah sudah absen
    public function getSudahAbsenAttribute(): bool
    {
        return $this->status !== 'Belum Absen';
    }
}