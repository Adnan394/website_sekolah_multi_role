<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Guru;
use App\Models\MateriPembelajaran;
use App\Models\Pelajaran;
use App\Models\RaporPenilaian;

class RaporPenilaianItem extends Model
{
    use HasFactory;

    protected $table = 'rapor_penilaian_items';
    protected $fillable = ['rapor_id','guru_id','jenis','nilai','materi_id','pelajaran_id','komentar','created_by'];

    public function rapor()
    {
        return $this->belongsTo(RaporPenilaian::class, 'rapor_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function materi()
    {
        return $this->belongsTo(MateriPembelajaran::class, 'materi_id');
    }

    public function pelajaran()
    {
        return $this->belongsTo(Pelajaran::class, 'pelajaran_id');
    }
}
