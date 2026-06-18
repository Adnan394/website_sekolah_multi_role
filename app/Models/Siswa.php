<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswa';
    protected $fillable = [
        'user_id', 'nisn', 'nis', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 
        'jenis_kelamin', 'agama', 'foto', 'no_hp', 'alamat', 
        'tahun_masuk', 'is_active', 'keterangan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_active' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function kelas() {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa')
                    ->withPivot('nomor_absen', 'status', 'id')
                    ->withTimestamps();
    }

    public function getFotoUrlAttribute() {
        if ($this->foto && file_exists(storage_path('app/public/' . $this->foto))) {
            return asset('storage/files/' . $this->foto);
        }
        return "https://ui-avatars.com/api/?name=" . urlencode($this->nama_lengkap) . "&background=random";
    }

    public function scopeAktif($query) {
        return $query->where('is_active', true);
    }
}