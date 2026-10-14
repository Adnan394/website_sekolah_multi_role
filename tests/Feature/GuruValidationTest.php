<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruValidationTest extends TestCase
{
    public function test_duplicate_nip_returns_validation_error()
    {
        $admin = User::firstOrCreate(
            ['username' => 'test_admin_guru'],
            ['email' => 'test_admin_guru@school.test', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        // Ensure at least one guru with known NIP exists
        $userGuru = User::firstOrCreate(
            ['username' => 'existing_guru_1'],
            ['email' => 'existing_guru_1@school.test', 'password' => bcrypt('password'), 'role' => 'guru']
        );

        $existingGuru = Guru::firstOrCreate(
            ['nip' => '198501012010011001'],
            [
                'user_id' => $userGuru->id,
                'nuptk' => '1234567890123456',
                'nama_lengkap' => 'Guru Eksisting',
                'jabatan' => 'Guru Kelas',
                'status_kepegawaian' => 'PNS',
            ]
        );

        $response = $this->actingAs($admin)->post('/admin/guru', [
            'username' => 'guru_baru_duplikat',
            'email' => 'guru_baru_duplikat@school.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_lengkap' => 'Guru Duplikat',
            'nip' => '198501012010011001', // duplicate NIP
            'jabatan' => 'Guru Kelas',
            'status_kepegawaian' => 'PNS',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nip' => 'NIP sudah terdaftar untuk guru lain.']);
    }

    public function test_duplicate_nuptk_returns_validation_error()
    {
        $admin = User::firstOrCreate(
            ['username' => 'test_admin_guru'],
            ['email' => 'test_admin_guru@school.test', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        $userGuru2 = User::firstOrCreate(
            ['username' => 'existing_guru_2'],
            ['email' => 'existing_guru_2@school.test', 'password' => bcrypt('password'), 'role' => 'guru']
        );

        Guru::firstOrCreate(
            ['nuptk' => '1234567890123456'],
            [
                'user_id' => $userGuru2->id,
                'nama_lengkap' => 'Guru NUPTK Eksisting',
                'jabatan' => 'Guru Kelas',
                'status_kepegawaian' => 'PNS',
            ]
        );

        $response = $this->actingAs($admin)->post('/admin/guru', [
            'username' => 'guru_baru_nuptk',
            'email' => 'guru_baru_nuptk@school.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_lengkap' => 'Guru Duplikat NUPTK',
            'nuptk' => '1234567890123456', // duplicate NUPTK
            'jabatan' => 'Guru Kelas',
            'status_kepegawaian' => 'PNS',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nuptk' => 'NUPTK sudah terdaftar untuk guru lain.']);
    }

    public function test_update_guru_can_keep_own_nip()
    {
        $admin = User::firstOrCreate(
            ['username' => 'test_admin_guru'],
            ['email' => 'test_admin_guru@school.test', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        $existingGuru = Guru::where('nip', '198501012010011001')->first();

        $response = $this->actingAs($admin)->put("/admin/guru/{$existingGuru->id}", [
            'username' => $existingGuru->user->username,
            'email' => $existingGuru->user->email,
            'nama_lengkap' => 'Nama Baru Guru',
            'nip' => '198501012010011001', // same NIP should not error
            'jabatan' => 'Guru Kelas',
            'status_kepegawaian' => 'PNS',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertEquals('Nama Baru Guru', $existingGuru->fresh()->nama_lengkap);
    }
}
