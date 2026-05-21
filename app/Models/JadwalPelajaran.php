<?php

namespace App\Models;

use App\Models\Pelajaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalPelajaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jadwal_pelajaran';

    protected $fillable = [
        'kelas_id', 'pelajaran_id', 'guru_id',
        'hari', 'jam_ke', 'jam_mulai', 'jam_selesai',
        'ruangan', 'tahun_pelajaran', 'semester', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'jam_ke'    => 'integer',
    ];

    public function kelas()     { return $this->belongsTo(Kelas::class); }
    public function pelajaran() { return $this->belongsTo(Pelajaran::class); }
    public function guru()      { return $this->belongsTo(Guru::class); }

    public function getDurasiAttribute(): string
    {
        return $this->jam_mulai . ' – ' . $this->jam_selesai;
    }

    public function scopeByKelas($query, $kelasId) { return $query->where('kelas_id', $kelasId); }
    public function scopeByHari($query, string $hari) { return $query->where('hari', $hari); }
    public function scopeAktif($query) { return $query->where('is_active', true); }
    public function scopeByTahun($query, string $tahun, string $semester)
    {
        return $query->where('tahun_pelajaran', $tahun)->where('semester', $semester);
    }

    public static function listHari(): array
    {
        return ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    }

    public static function listSemester(): array
    {
        return ['Ganjil', 'Genap'];
    }
}