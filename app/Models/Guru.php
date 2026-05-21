<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guru';

    protected $fillable = [
        'user_id', 'nip', 'nuptk', 'nama_lengkap', 'gelar_depan', 'gelar_belakang',
        'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'status_pernikahan',
        'foto', 'no_hp', 'no_telp', 'email_pribadi',
        'alamat', 'rt', 'rw', 'kelurahan', 'kecamatan', 'kota', 'provinsi', 'kode_pos',
        'pendidikan_terakhir', 'jurusan', 'universitas', 'tahun_lulus',
        'status_kepegawaian', 'golongan', 'tmt_cpns', 'tmt_pns',
        'tanggal_bergabung', 'masa_kerja_tahun', 'masa_kerja_bulan',
        'jabatan', 'is_sertifikasi', 'tahun_sertifikasi', 'nomor_sertifikasi',
        'is_active', 'keterangan',
    ];

    protected $casts = [
        'tanggal_lahir'    => 'date',
        'tmt_cpns'         => 'date',
        'tmt_pns'          => 'date',
        'tanggal_bergabung'=> 'date',
        'is_sertifikasi'   => 'boolean',
        'is_active'        => 'boolean',
    ];

    // ──────────────────────────────────────────────────
    //  Relasi ke Users
    // ──────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ──────────────────────────────────────────────────
    //  Relasi ke Kelas (via pivot kelas_guru)
    // ──────────────────────────────────────────────────

    /** Semua kelas yang dipegang (wali kelas + guru mapel) */
    public function kelas()
    {
        return $this->belongsToMany(
            Kelas::class, 'kelas_guru', 'guru_id', 'kelas_id'
        )->withPivot('jabatan', 'pelajaran_id')->withTimestamps();
    }

    /** Kelas yang dipercaya sebagai wali kelas */
    public function waliKelas()
    {
        return $this->belongsToMany(
            Kelas::class, 'kelas_guru', 'guru_id', 'kelas_id'
        )->wherePivot('jabatan', 'wali_kelas')->withTimestamps();
    }

    /** Kelas-kelas yang diajar sebagai guru mapel */
    public function kelasMapel()
    {
        return $this->belongsToMany(
            Kelas::class, 'kelas_guru', 'guru_id', 'kelas_id'
        )->wherePivot('jabatan', 'guru_mapel')
         ->withPivot('pelajaran_id')
         ->withTimestamps();
    }

    // ──────────────────────────────────────────────────
    //  Scopes
    // ──────────────────────────────────────────────────
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByJabatan($query, string $jabatan)
    {
        return $query->where('jabatan', $jabatan);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status_kepegawaian', $status);
    }

    // ──────────────────────────────────────────────────
    //  Accessors
    // ──────────────────────────────────────────────────

    /** Nama lengkap dengan gelar: "Dr. Budi Santoso, S.Pd." */
    public function getNamaGelarAttribute(): string
    {
        $depan    = $this->gelar_depan  ? $this->gelar_depan . ' '  : '';
        $belakang = $this->gelar_belakang ? ', ' . $this->gelar_belakang : '';
        return $depan . $this->nama_lengkap . $belakang;
    }

    /** URL foto atau placeholder */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && file_exists(public_path('storage/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }
        $inisial = urlencode(substr($this->nama_lengkap, 0, 2));
        return "https://ui-avatars.com/api/?name={$inisial}&background=8B0000&color=fff&size=200";
    }

    /** Usia berdasarkan tanggal lahir */
    public function getUsiaAttribute(): ?int
    {
        return $this->tanggal_lahir
            ? $this->tanggal_lahir->age
            : null;
    }

    /** Alamat lengkap satu baris */
    public function getAlamatLengkapAttribute(): string
    {
        return collect([
            $this->alamat,
            $this->rt  ? "RT {$this->rt}"  : null,
            $this->rw  ? "RW {$this->rw}"  : null,
            $this->kelurahan,
            $this->kecamatan,
            $this->kota,
            $this->provinsi,
            $this->kode_pos,
        ])->filter()->implode(', ');
    }

    // ──────────────────────────────────────────────────
    //  Static helpers
    // ──────────────────────────────────────────────────
    public static function listJabatan(): array
    {
        return [
            'Kepala Sekolah', 'Wakil Kepala Sekolah',
            'Guru Kelas', 'Guru Mata Pelajaran',
            'Guru Pendamping', 'Tenaga Administrasi',
        ];
    }

    public static function listStatusKepegawaian(): array
    {
        return ['PNS', 'PPPK', 'GTT', 'Honor', 'Kontrak'];
    }

    public static function listPendidikan(): array
    {
        return ['SMA/SMK', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];
    }

    public static function listAgama(): array
    {
        return ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
    }
}