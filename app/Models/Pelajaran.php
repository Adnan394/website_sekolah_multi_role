<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelajaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pelajaran';

    protected $fillable = [
        'kode_pelajaran', 'nama_pelajaran', 'kategori',
        'tingkat_min', 'tingkat_max', 'jam_per_minggu',
        'deskripsi', 'is_active',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'tingkat_min' => 'integer',
        'tingkat_max' => 'integer',
    ];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_guru', 'pelajaran_id', 'kelas_id')
                    ->withPivot('guru_id', 'jabatan')->withTimestamps();
    }

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class);
    }

    public function materiPembelajaran()
    {
        return $this->hasMany(MateriPembelajaran::class);
    }

    public function jadwalTugas()
    {
        return $this->hasMany(JadwalTugas::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUntukTingkat($query, int $tingkat)
    {
        return $query->where('tingkat_min', '<=', $tingkat)
                     ->where('tingkat_max', '>=', $tingkat);
    }

    public static function listKategori(): array
    {
        return ['Wajib', 'Muatan Lokal', 'Pengembangan Diri', 'Ekstrakurikuler'];
    }
}