<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class KelasSiswa extends Pivot
{
    protected $table = 'kelas_siswa';

    protected $fillable = [
        'kelas_id',
        'siswa_id',
        'nomor_absen',
        'status'
    ];

    public $timestamps = true;
}