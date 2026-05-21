<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontakKami extends Model
{
    protected $table = 'kontak_kami';

    protected $fillable = [
        'nama_tempat',
        'alamat',
        'telepon',
        'email',
        'maps_embed',
        'facebook',
        'instagram',
        'youtube',
        'logo'
    ];
}