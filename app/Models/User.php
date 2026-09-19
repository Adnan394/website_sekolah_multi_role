<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi secara massal (mass assignment).
     * Disesuaikan dengan struktur tabel `users`.
     */
    protected $fillable = [
        'username',
        'email',
        'role',
        'deskripsi',
        'password',
    ];

    /**
     * Kolom yang disembunyikan saat model diubah ke array/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Helper untuk mengecek peran pengguna.
     * Contoh penggunaan: if (auth()->user()->hasRole('guru')) { ... }
     */
    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }
}