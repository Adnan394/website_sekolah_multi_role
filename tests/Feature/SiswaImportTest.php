<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class SiswaImportTest extends TestCase
{
    public function test_admin_can_see_import_button_and_modal()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@test.com'],
            ['username' => 'admin_test', 'password' => bcrypt('password'), 'role' => 'Admin']
        );

        $response = $this->actingAs($admin)->get(route('siswa.index'));

        $response->assertStatus(200);
        $response->assertSee('Import Excel');
        $response->assertSee('modalImportExcel');
        $response->assertSee(route('siswa.download-template'));
    }

    public function test_admin_can_download_template()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test2@test.com'],
            ['username' => 'admin_test2', 'password' => bcrypt('password'), 'role' => 'Admin']
        );

        $response = $this->actingAs($admin)->get(route('siswa.download-template'));

        $response->assertStatus(200);
        $response->assertHeader('content-disposition');
    }

    public function test_admin_can_import_students()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);

        $admin = User::firstOrCreate(
            ['email' => 'admin_test3@test.com'],
            ['username' => 'admin_test3', 'password' => bcrypt('password'), 'role' => 'Admin']
        );

        $uniqueKey = time();
        $csvContent = "username,email,password,nama_lengkap,nisn,nis,jenis_kelamin\n" .
                      "siswa_{$uniqueKey},siswa_{$uniqueKey}@test.com,password123,Siswa Uji Coba,{$uniqueKey},NIS{$uniqueKey},L\n";

        $file = UploadedFile::fake()->createWithContent('siswa.csv', $csvContent);

        $response = $this->actingAs($admin)->post(route('siswa.import'), [
            'file' => $file
        ]);

        $response->assertRedirect(route('siswa.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'username' => "siswa_{$uniqueKey}",
            'email' => "siswa_{$uniqueKey}@test.com",
            'role' => 'siswa'
        ]);

        $this->assertDatabaseHas('siswa', [
            'nama_lengkap' => 'Siswa Uji Coba',
            'nisn' => (string)$uniqueKey,
            'nis' => "NIS{$uniqueKey}",
            'jenis_kelamin' => 'L'
        ]);
    }

    public function test_admin_can_access_edit_siswa_page()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test4@test.com'],
            ['username' => 'admin_test4', 'password' => bcrypt('password'), 'role' => 'Admin']
        );

        $siswa = Siswa::first();

        $response = $this->actingAs($admin)->get(route('siswa.edit', $siswa->id));

        $response->assertStatus(200);
        $response->assertSee('Edit Siswa');
        $response->assertSee($siswa->nama_lengkap);
    }

    public function test_admin_can_update_siswa()
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);

        $admin = User::firstOrCreate(
            ['email' => 'admin_test5@test.com'],
            ['username' => 'admin_test5', 'password' => bcrypt('password'), 'role' => 'Admin']
        );

        $siswa = Siswa::first();
        $newNama = 'Nama Terupdate ' . time();

        $response = $this->actingAs($admin)->put(route('siswa.update', $siswa->id), [
            'username' => $siswa->user->username,
            'email' => $siswa->user->email,
            'nama_lengkap' => $newNama,
            'nisn' => $siswa->nisn,
            'nis' => $siswa->nis,
            'jenis_kelamin' => 'L',
        ]);

        $response->assertRedirect(route('siswa.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('siswa', [
            'id' => $siswa->id,
            'nama_lengkap' => $newNama,
        ]);
    }

    public function test_admin_can_view_kelas_detail_with_relations()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test6@test.com'],
            ['username' => 'admin_test6', 'password' => bcrypt('password'), 'role' => 'Admin']
        );

        $kelas = \App\Models\Kelas::first();

        $response = $this->actingAs($admin)->get(route('kelas.show', $kelas->id));

        $response->assertStatus(200);
        $response->assertSee('Detail Kelas');
        $response->assertSee('Wali Kelas');
        $response->assertSee('Guru Mata Pelajaran');
        $response->assertSee('Daftar Siswa');
        $response->assertSee('Jadwal Pelajaran');
    }
}
