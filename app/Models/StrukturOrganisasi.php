<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    protected $table = 'struktur_organisasi';

    protected $fillable = [
        'nama',
        'jabatan',
        'foto',
        'parent_id',
        'urutan'
    ];

    public function children()
    {
        return $this->hasMany(StrukturOrganisasi::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(StrukturOrganisasi::class, 'parent_id');
    }
}