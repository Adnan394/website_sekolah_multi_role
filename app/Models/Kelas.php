<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'kode_kelas',
        'tahun_pelajaran',
        'semester',
        'kapasitas',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tingkat'   => 'integer',
        'kapasitas' => 'integer',
    ];

    // ──────────────────────────────────────────────────
    //  Scopes
    // ──────────────────────────────────────────────────

    /** Hanya kelas aktif */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    /** Filter berdasarkan tahun pelajaran */
    public function scopeTahunPelajaran($query, string $tahun)
    {
        return $query->where('tahun_pelajaran', $tahun);
    }

    /** Filter berdasarkan tingkat */
    public function scopeTingkat($query, int $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }

    // ──────────────────────────────────────────────────
    //  Relasi — akan dipakai saat module guru/siswa/
    //            pelajaran sudah dibuat
    // ──────────────────────────────────────────────────

    /**
     * Wali kelas (1 guru per kelas per tahun ajaran).
     * Relasi ini menggunakan pivot table kelas_guru dengan
     * kolom tambahan: jabatan (wali_kelas | guru_mapel)
     */
    public function guru()
    {
        return $this->belongsToMany(
            \App\Models\Guru::class,
            'kelas_guru',
            'kelas_id',
            'guru_id'
        )->withPivot('jabatan')->withTimestamps();
    }

    public function waliKelas()
    {
        return $this->belongsToMany(
            \App\Models\Guru::class,
            'kelas_guru',
            'kelas_id',
            'guru_id'
        )->wherePivot('jabatan', 'wali_kelas')->withTimestamps();
    }

    public function guruMapel()
    {
        return $this->belongsToMany(
            \App\Models\Guru::class,
            'kelas_guru',
            'kelas_id',
            'guru_id'
        )->wherePivot('jabatan', 'guru_mapel')
         ->withPivot('pelajaran_id')
         ->withTimestamps();
    }

    /**
     * Siswa yang terdaftar di kelas ini (via pivot kelas_siswa).
     */
    // public function siswa()
    // {
    //     return $this->belongsToMany(
    //         \App\Models\Siswa::class,
    //         'kelas_siswa',
    //         'kelas_id',
    //         'siswa_id'
    //     )->withPivot('nomor_absen', 'status')
    //      ->withTimestamps();
    // }

    
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa')
                    ->using(KelasSiswa::class)
                    ->withPivot('nomor_absen', 'status')
                    ->withTimestamps();
    }

    /**
     * Pelajaran yang diajarkan di kelas ini.
     */
    public function pelajaran()
    {
        return $this->belongsToMany(
            \App\Models\Pelajaran::class,
            'kelas_pelajaran',
            'kelas_id',
            'pelajaran_id'
        )->withPivot('guru_id', 'jadwal')
         ->withTimestamps();
    }

    // ──────────────────────────────────────────────────
    //  Accessors
    // ──────────────────────────────────────────────────

    /** Nama lengkap kelas: "Kelas 1A – 2024/2025 (Ganjil)" */
    public function getNamaLengkapAttribute(): string
    {
        return "Kelas {$this->nama_kelas} – {$this->tahun_pelajaran} ({$this->semester})";
    }

    /** Jumlah siswa aktif */
    public function getJumlahSiswaAttribute(): int
    {
        // Aktif setelah modul siswa tersedia
        // return $this->siswa()->wherePivot('status', 'aktif')->count();
        return 0;
    }

    // ──────────────────────────────────────────────────
    //  Helper statics
    // ──────────────────────────────────────────────────

    /** Generate kode unik: "2024/2025-1A-Ganjil" */
    public static function generateKode(string $tahun, string $namaKelas, string $semester): string
    {
        return "{$tahun}-{$namaKelas}-{$semester}";
    }

    /** Daftar semester yang tersedia */
    public static function listSemester(): array
    {
        return ['Ganjil', 'Genap'];
    }

    /** Daftar tingkat kelas SD */
    public static function listTingkat(): array
    {
        return [1, 2, 3, 4, 5, 6];
    }

}