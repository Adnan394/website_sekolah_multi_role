<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RaporPenilaianItem;
use App\Models\Siswa;

class RaporPenilaian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rapor_penilaian';
    protected $fillable = ['siswa_id','tahun_pelajaran','semester','nilai_total','created_by'];

    public function items()
    {
        return $this->hasMany(RaporPenilaianItem::class, 'rapor_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function recalculateTotal(): float
    {
        $weights = config('rapor.weights', [
            'materi' => 0.4,
            'tugas' => 0.3,
            'kehadiran' => 0.2,
            'keaktifan' => 0.1,
        ]);

        $total = 0.0;
        foreach ($weights as $jenis => $w) {
            $avg = $this->items()->where('jenis', $jenis)->avg('nilai') ?: 0;
            $total += ($avg * $w);
        }

        $this->update(['nilai_total' => $total]);
        return $total;
    }
}
