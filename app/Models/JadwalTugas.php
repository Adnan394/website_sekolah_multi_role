<?php

namespace App\Models;

use App\Models\Pelajaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalTugas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jadwal_tugas';

    protected $fillable = [
        'kelas_id', 'pelajaran_id', 'guru_id',
        'judul_tugas', 'deskripsi', 'file_tugas',
        'tanggal_mulai', 'tenggat_waktu',
        'tipe_pengumpulan', 'nilai_maksimal', 'is_published',
    ];

    protected $casts = [
        'tanggal_mulai'  => 'datetime',
        'tenggat_waktu'  => 'datetime',
        'is_published'   => 'boolean',
        'nilai_maksimal' => 'integer',
    ];

    public function kelas()     { return $this->belongsTo(Kelas::class); }
    public function pelajaran() { return $this->belongsTo(Pelajaran::class); }
    public function guru()      { return $this->belongsTo(Guru::class); }

    public function getIsExpiredAttribute(): bool
    {
        return $this->tenggat_waktu && $this->tenggat_waktu->isPast();
    }

    public function getStatusLabelAttribute(): string
    {
        if (!$this->is_published)      return 'Draft';
        if ($this->is_expired)         return 'Berakhir';
        if ($this->tanggal_mulai->isFuture()) return 'Belum Dimulai';
        return 'Aktif';
    }

    public function scopePublished($query)  { return $query->where('is_published', true); }
    public function scopeByKelas($query, $kelasId) { return $query->where('kelas_id', $kelasId); }
    public function scopeAktif($query)
    {
        return $query->where('is_published', true)
                     ->where('tanggal_mulai', '<=', now())
                     ->where('tenggat_waktu', '>=', now());
    }

    public static function listTipePengumpulan(): array
    {
        return ['File', 'Teks', 'Link', 'Offline'];
    }
}