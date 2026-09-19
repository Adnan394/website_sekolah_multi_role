<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profileData = null;
        $isIncomplete = false;

        $role = strtolower($user->role ?? '');

        if ($role === 'guru') {
            $profileData = Guru::where('user_id', $user->id)->first();
            if (!$profileData || empty($profileData->nama_lengkap) || empty($profileData->nip) || empty($profileData->no_hp) || empty($profileData->alamat)) {
                $isIncomplete = true;
            }
        } elseif ($role === 'siswa') {
            $profileData = Siswa::where('user_id', $user->id)->first();
            if (!$profileData || empty($profileData->nama_lengkap) || empty($profileData->nisn) || empty($profileData->no_hp) || empty($profileData->alamat)) {
                $isIncomplete = true;
            }
        }

        return view('profile.index', compact('user', 'profileData', 'isIncomplete'), ['active' => 'profile']);
    }

    public function edit()
    {
        $user = Auth::user();
        $profileData = null;

        $role = strtolower($user->role ?? '');

        if ($role === 'guru') {
            $profileData = Guru::where('user_id', $user->id)->first();
        } elseif ($role === 'siswa') {
            $profileData = Siswa::where('user_id', $user->id)->first();
        }

        return view('profile.edit', compact('user', 'profileData'), ['active' => 'profile']);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $role = strtolower($user->role ?? '');

        // Validation for User account info
        $request->validate([
            'username'  => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:6|confirmed',
            'deskripsi' => 'nullable|string',
        ]);

        $userData = [
            'username'  => $request->username,
            'email'     => $request->email,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Role: Siswa
        if ($role === 'siswa') {
            $siswa = Siswa::where('user_id', $user->id)->first();
            $siswaId = $siswa ? $siswa->id : 'NULL';

            $request->validate([
                'nama_lengkap'  => 'required|string|max:255',
                'nisn'          => 'nullable|string|max:20|unique:siswa,nisn,' . $siswaId,
                'nis'           => 'nullable|string|max:20|unique:siswa,nis,' . $siswaId,
                'tempat_lahir'  => 'nullable|string|max:100',
                'tanggal_lahir' => 'nullable|date',
                'jenis_kelamin' => 'nullable|in:L,P',
                'agama'         => 'nullable|string',
                'no_hp'         => 'nullable|string|max:20',
                'alamat'        => 'nullable|string',
                'tahun_masuk'   => 'nullable|digits:4|integer',
                'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $siswaData = [
                'nama_lengkap'  => $request->nama_lengkap,
                'nisn'          => $request->nisn,
                'nis'           => $request->nis,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama'         => $request->agama,
                'no_hp'         => $request->no_hp,
                'alamat'        => $request->alamat,
                'tahun_masuk'   => $request->tahun_masuk,
            ];

            if ($request->hasFile('foto')) {
                if ($siswa && $siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                    Storage::disk('public')->delete($siswa->foto);
                }
                $siswaData['foto'] = $request->file('foto')->store('foto-siswa', 'public');
            }

            Siswa::updateOrCreate(['user_id' => $user->id], $siswaData);
        }
        // Role: Guru
        elseif ($role === 'guru') {
            $guru = Guru::where('user_id', $user->id)->first();
            $guruId = $guru ? $guru->id : 'NULL';

            $request->validate([
                'nama_lengkap'        => 'required|string|max:255',
                'nip'                 => 'nullable|string|max:20|unique:guru,nip,' . $guruId,
                'nuptk'               => 'nullable|string|max:20|unique:guru,nuptk,' . $guruId,
                'gelar_depan'         => 'nullable|string|max:20',
                'gelar_belakang'      => 'nullable|string|max:30',
                'tempat_lahir'        => 'nullable|string|max:100',
                'tanggal_lahir'       => 'nullable|date',
                'jenis_kelamin'       => 'nullable|in:L,P',
                'agama'               => 'nullable|string',
                'status_pernikahan'   => 'nullable|string',
                'no_hp'               => 'nullable|string|max:20',
                'no_telp'             => 'nullable|string|max:20',
                'email_pribadi'       => 'nullable|email|max:255',
                'alamat'              => 'nullable|string',
                'rt'                  => 'nullable|string|max:5',
                'rw'                  => 'nullable|string|max:5',
                'kelurahan'           => 'nullable|string|max:100',
                'kecamatan'           => 'nullable|string|max:100',
                'kota'                => 'nullable|string|max:100',
                'provinsi'            => 'nullable|string|max:100',
                'kode_pos'            => 'nullable|string|max:10',
                'pendidikan_terakhir' => 'nullable|string',
                'jurusan'             => 'nullable|string|max:150',
                'universitas'         => 'nullable|string|max:150',
                'tahun_lulus'         => 'nullable|digits:4|integer',
                'status_kepegawaian'  => 'nullable|string',
                'jabatan'             => 'nullable|string',
                'foto'                => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $guruData = [
                'nama_lengkap'        => $request->nama_lengkap,
                'nip'                 => $request->nip,
                'nuptk'               => $request->nuptk,
                'gelar_depan'         => $request->gelar_depan,
                'gelar_belakang'      => $request->gelar_belakang,
                'tempat_lahir'        => $request->tempat_lahir,
                'tanggal_lahir'       => $request->tanggal_lahir,
                'jenis_kelamin'       => $request->jenis_kelamin,
                'agama'               => $request->agama,
                'status_pernikahan'   => $request->status_pernikahan,
                'no_hp'               => $request->no_hp,
                'no_telp'             => $request->no_telp,
                'email_pribadi'       => $request->email_pribadi,
                'alamat'              => $request->alamat,
                'rt'                  => $request->rt,
                'rw'                  => $request->rw,
                'kelurahan'           => $request->kelurahan,
                'kecamatan'           => $request->kecamatan,
                'kota'                => $request->kota,
                'provinsi'            => $request->provinsi,
                'kode_pos'            => $request->kode_pos,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'jurusan'             => $request->jurusan,
                'universitas'         => $request->universitas,
                'tahun_lulus'         => $request->tahun_lulus,
                'status_kepegawaian'  => $request->status_kepegawaian,
                'jabatan'             => $request->jabatan,
            ];

            if ($request->hasFile('foto')) {
                if ($guru && $guru->foto && Storage::disk('public')->exists($guru->foto)) {
                    Storage::disk('public')->delete($guru->foto);
                }
                $guruData['foto'] = $request->file('foto')->store('foto-guru', 'public');
            }

            Guru::updateOrCreate(['user_id' => $user->id], $guruData);
        }

        return redirect()->route('profile.index')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}

