<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Pelajaran;

class MateriPembelajaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materi_pembelajaran';

    protected $fillable = [
        'kelas_id', 'pelajaran_id', 'guru_id',
        'judul', 'deskripsi', 'file_materi', 'link_materi',
        'tipe', 'tanggal_upload', 'is_published',
    ];

    protected $casts = [
        'tanggal_upload' => 'date',
        'is_published'   => 'boolean',
    ];

    public function kelas()      { return $this->belongsTo(Kelas::class); }
    public function pelajaran()  { return $this->belongsTo(Pelajaran::class); }
    public function guru()       { return $this->belongsTo(Guru::class); }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_materi
            ? asset('storage/' . $this->file_materi)
            : null;
    }

    public function scopePublished($query)  { return $query->where('is_published', true); }
    public function scopeByKelas($query, $kelasId) { return $query->where('kelas_id', $kelasId); }

    public static function listTipe(): array
    {
        return ['Dokumen', 'Video', 'Link', 'Teks'];
    }
}