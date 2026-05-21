<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    protected $table = 'kurikulum';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'file_pdf',
        'tahun_ajaran',
        'status'
    ];
}