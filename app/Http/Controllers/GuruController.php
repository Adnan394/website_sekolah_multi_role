<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    // ──────────────────────────────────────────────────
    //  INDEX
    // ──────────────────────────────────────────────────
    public function index(Request $request)
    {
        $tampilkan = $request->input('tampilkan', 'aktif');

        $query = match ($tampilkan) {
            'terhapus' => Guru::onlyTrashed()->with('user'),
            'semua'    => Guru::withTrashed()->with('user'),
            default    => Guru::with('user'),
        };

        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }
        if ($request->filled('status_kepegawaian')) {
            $query->where('status_kepegawaian', $request->status_kepegawaian);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%')
                  ->orWhere('nuptk', 'like', '%' . $request->search . '%');
            });
        }

        $guru           = $query->orderBy('nama_lengkap')->paginate(15)->withQueryString();
        $jumlahTerhapus = Guru::onlyTrashed()->count();
        $active = 'data_guru';

        return view('admin.guru.index', compact('guru', 'tampilkan', 'jumlahTerhapus', 'active'));
    }

    // ──────────────────────────────────────────────────
    //  CREATE  (Step 1 — tampilkan form)
    // ──────────────────────────────────────────────────
    public function create()
    {
        return view('admin.guru.create', [
            'jabatanList'          => Guru::listJabatan(),
            'statusKepegawaianList'=> Guru::listStatusKepegawaian(),
            'pendidikanList'       => Guru::listPendidikan(),
            'agamaList'            => Guru::listAgama(),
            'active'               => 'data_guru',
        ]);
    }

    // ──────────────────────────────────────────────────
    //  STORE  (Step 1 + Step 2 dalam satu transaksi)
    // ──────────────────────────────────────────────────
    public function store(Request $request)
    {
        // — Validasi Akun ————————————————————————————
        $request->validate($this->rulesAkun(), $this->messages());

        // — Validasi Data Guru ————————————————————————
        $request->validate($this->rulesGuru(), $this->messages());

        DB::transaction(function () use ($request) {

            // 1. Buat akun user
            $user = User::create([
                'username'   => $request->username,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'role'       => 'guru',
                'deskripsi'  => $request->deskripsi_akun,
            ]);

            // 2. Upload foto jika ada
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto-guru', 'public');
            }

            // 3. Simpan data guru
            Guru::create([
                'user_id'              => $user->id,
                'nip'                  => $request->nip ?: null,
                'nuptk'                => $request->nuptk ?: null,
                'nama_lengkap'         => $request->nama_lengkap,
                'gelar_depan'          => $request->gelar_depan,
                'gelar_belakang'       => $request->gelar_belakang,
                'tempat_lahir'         => $request->tempat_lahir,
                'tanggal_lahir'        => $request->tanggal_lahir,
                'jenis_kelamin'        => $request->jenis_kelamin,
                'agama'                => $request->agama,
                'status_pernikahan'    => $request->status_pernikahan,
                'foto'                 => $fotoPath,
                'no_hp'                => $request->no_hp,
                'no_telp'              => $request->no_telp,
                'email_pribadi'        => $request->email_pribadi,
                'alamat'               => $request->alamat,
                'rt'                   => $request->rt,
                'rw'                   => $request->rw,
                'kelurahan'            => $request->kelurahan,
                'kecamatan'            => $request->kecamatan,
                'kota'                 => $request->kota,
                'provinsi'             => $request->provinsi,
                'kode_pos'             => $request->kode_pos,
                'pendidikan_terakhir'  => $request->pendidikan_terakhir,
                'jurusan'              => $request->jurusan,
                'universitas'          => $request->universitas,
                'tahun_lulus'          => $request->tahun_lulus,
                'status_kepegawaian'   => $request->status_kepegawaian,
                'golongan'             => $request->golongan,
                'tmt_cpns'             => $request->tmt_cpns,
                'tmt_pns'              => $request->tmt_pns,
                'tanggal_bergabung'    => $request->tanggal_bergabung,
                'masa_kerja_tahun'     => $request->masa_kerja_tahun ?? 0,
                'masa_kerja_bulan'     => $request->masa_kerja_bulan ?? 0,
                'jabatan'              => $request->jabatan,
                'is_sertifikasi'       => $request->boolean('is_sertifikasi'),
                'tahun_sertifikasi'    => $request->tahun_sertifikasi,
                'nomor_sertifikasi'    => $request->nomor_sertifikasi,
                'is_active'            => $request->boolean('is_active', true),
                'keterangan'           => $request->keterangan,
            ]);
        });

        return redirect()->route('guru.index')
                         ->with('success', 'Data guru berhasil ditambahkan.');
    }

    // ──────────────────────────────────────────────────
    //  SHOW
    // ──────────────────────────────────────────────────
    public function show(Guru $guru)
    {
        $guru->load(['user', 'waliKelas', 'kelasMapel']);
        $active = 'data_guru';
        return view('admin.guru.show', compact('guru', 'active'));
    }

    // ──────────────────────────────────────────────────
    //  EDIT
    // ──────────────────────────────────────────────────
    public function edit(Guru $guru)
    {
        $guru->load('user');
        return view('admin.guru.edit', [
            'guru'                 => $guru,
            'jabatanList'          => Guru::listJabatan(),
            'statusKepegawaianList'=> Guru::listStatusKepegawaian(),
            'pendidikanList'       => Guru::listPendidikan(),
            'agamaList'            => Guru::listAgama(),
            'active'               => 'data_guru',
        ]);
    }

    // ──────────────────────────────────────────────────
    //  UPDATE
    // ──────────────────────────────────────────────────
    public function update(Request $request, Guru $guru)
    {
        // Validasi akun (password opsional saat edit)
        $request->validate($this->rulesAkunUpdate($guru->user_id), $this->messages());
        $request->validate($this->rulesGuru(), $this->messages());

        DB::transaction(function () use ($request, $guru) {

            // Update akun user
            $dataUser = [
                'username'  => $request->username,
                'email'     => $request->email,
                'deskripsi' => $request->deskripsi_akun,
            ];
            if ($request->filled('password')) {
                $dataUser['password'] = Hash::make($request->password);
            }
            $guru->user->update($dataUser);

            // Foto baru
            $fotoPath = $guru->foto;
            if ($request->hasFile('foto')) {
                if ($fotoPath) Storage::disk('public')->delete($fotoPath);
                $fotoPath = $request->file('foto')->store('foto-guru', 'public');
            }
            if ($request->boolean('hapus_foto') && $fotoPath) {
                Storage::disk('public')->delete($fotoPath);
                $fotoPath = null;
            }

            $guru->update([
                'nip'                  => $request->nip ?: null,
                'nuptk'                => $request->nuptk ?: null,
                'nama_lengkap'         => $request->nama_lengkap,
                'gelar_depan'          => $request->gelar_depan,
                'gelar_belakang'       => $request->gelar_belakang,
                'tempat_lahir'         => $request->tempat_lahir,
                'tanggal_lahir'        => $request->tanggal_lahir,
                'jenis_kelamin'        => $request->jenis_kelamin,
                'agama'                => $request->agama,
                'status_pernikahan'    => $request->status_pernikahan,
                'foto'                 => $fotoPath,
                'no_hp'                => $request->no_hp,
                'no_telp'              => $request->no_telp,
                'email_pribadi'        => $request->email_pribadi,
                'alamat'               => $request->alamat,
                'rt'                   => $request->rt,
                'rw'                   => $request->rw,
                'kelurahan'            => $request->kelurahan,
                'kecamatan'            => $request->kecamatan,
                'kota'                 => $request->kota,
                'provinsi'             => $request->provinsi,
                'kode_pos'             => $request->kode_pos,
                'pendidikan_terakhir'  => $request->pendidikan_terakhir,
                'jurusan'              => $request->jurusan,
                'universitas'          => $request->universitas,
                'tahun_lulus'          => $request->tahun_lulus,
                'status_kepegawaian'   => $request->status_kepegawaian,
                'golongan'             => $request->golongan,
                'tmt_cpns'             => $request->tmt_cpns,
                'tmt_pns'              => $request->tmt_pns,
                'tanggal_bergabung'    => $request->tanggal_bergabung,
                'masa_kerja_tahun'     => $request->masa_kerja_tahun ?? 0,
                'masa_kerja_bulan'     => $request->masa_kerja_bulan ?? 0,
                'jabatan'              => $request->jabatan,
                'is_sertifikasi'       => $request->boolean('is_sertifikasi'),
                'tahun_sertifikasi'    => $request->tahun_sertifikasi,
                'nomor_sertifikasi'    => $request->nomor_sertifikasi,
                'is_active'            => $request->boolean('is_active'),
                'keterangan'           => $request->keterangan,
            ]);
        });

        return redirect()->route('guru.show', $guru)
                         ->with('success', 'Data guru berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────────
    //  DESTROY (soft delete)
    // ──────────────────────────────────────────────────
    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')
                         ->with('success', 'Data guru berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────
    //  RESTORE
    // ──────────────────────────────────────────────────
    public function restore(int $id)
    {
        $guru = Guru::onlyTrashed()->findOrFail($id);
        $guru->restore();
        return redirect()->route('guru.index', ['tampilkan' => 'terhapus'])
                         ->with('success', "Data guru {$guru->nama_lengkap} berhasil dipulihkan.");
    }

    // ──────────────────────────────────────────────────
    //  FORCE DELETE
    // ──────────────────────────────────────────────────
    public function forceDelete(int $id)
    {
        $guru = Guru::onlyTrashed()->findOrFail($id);
        if ($guru->foto) Storage::disk('public')->delete($guru->foto);
        $nama = $guru->nama_lengkap;
        $guru->forceDelete();
        return redirect()->route('guru.index', ['tampilkan' => 'terhapus'])
                         ->with('success', "Data guru {$nama} berhasil dihapus permanen.");
    }

    // ──────────────────────────────────────────────────
    //  TOGGLE STATUS
    // ──────────────────────────────────────────────────
    public function toggleStatus(Guru $guru)
    {
        $guru->update(['is_active' => !$guru->is_active]);
        $status = $guru->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun guru berhasil {$status}.");
    }

    // ──────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ──────────────────────────────────────────────────
    private function rulesAkun(): array
    {
        return [
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    private function rulesAkunUpdate(int $userId): array
    {
        return [
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($userId)],
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    private function rulesGuru(): array
    {
        return [
            'nama_lengkap'        => 'required|string|max:150',
            'nip'                 => 'nullable|string|max:20',
            'nuptk'               => 'nullable|string|max:20',
            'tanggal_lahir'       => 'nullable|date',
            'jenis_kelamin'       => 'nullable|in:L,P',
            'agama'               => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'no_hp'               => 'nullable|string|max:20',
            'jabatan'             => 'required|string',
            'status_kepegawaian'  => 'required|string',
            'pendidikan_terakhir' => 'nullable|string',
            'foto'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tmt_cpns'            => 'nullable|date',
            'tmt_pns'             => 'nullable|date',
            'tanggal_bergabung'   => 'nullable|date',
            'masa_kerja_tahun'    => 'nullable|integer|min:0|max:50',
            'masa_kerja_bulan'    => 'nullable|integer|min:0|max:11',
            'tahun_lulus'         => 'nullable|digits:4',
            'tahun_sertifikasi'   => 'nullable|digits:4',
        ];
    }

    private function messages(): array
    {
        return [
            'username.required'       => 'Username wajib diisi.',
            'username.unique'         => 'Username sudah digunakan.',
            'email.required'          => 'Email wajib diisi.',
            'email.unique'            => 'Email sudah terdaftar.',
            'password.required'       => 'Password wajib diisi.',
            'password.min'            => 'Password minimal 8 karakter.',
            'password.confirmed'      => 'Konfirmasi password tidak cocok.',
            'nama_lengkap.required'   => 'Nama lengkap wajib diisi.',
            'jabatan.required'        => 'Jabatan wajib dipilih.',
            'status_kepegawaian.required' => 'Status kepegawaian wajib dipilih.',
            'foto.image'              => 'File harus berupa gambar.',
            'foto.max'                => 'Ukuran foto maksimal 2MB.',
            'masa_kerja_bulan.max'    => 'Masa kerja bulan maksimal 11.',
        ];
    }
}