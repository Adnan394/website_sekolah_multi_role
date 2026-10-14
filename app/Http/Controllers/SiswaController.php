<?php 

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use App\Exports\SiswaTemplateExport;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['user', 'kelas']);
        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('nisn', 'like', "%{$request->search}%");
        }
        $siswa = $query->latest()->paginate(15);
        $active = 'data_siswa';
        return view('admin.siswa.index', compact('siswa', 'active'));
    }

    public function downloadTemplate()
    {
        return Excel::download(new SiswaTemplateExport, 'template_import_siswa.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file.required' => 'File Excel wajib diunggah.',
            'file.file' => 'File yang diunggah tidak valid.',
            'file.mimes' => 'Format file harus berupa Excel (.xlsx, .xls) atau CSV (.csv).',
            'file.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        try {
            $import = new SiswaImport();
            Excel::import($import, $request->file('file'));

            $imported = $import->getImportedCount();
            $errors = $import->getErrors();
            $skipped = $import->getSkippedCount();

            if ($imported === 0 && count($errors) > 0) {
                return redirect()->route('siswa.index')->with('error', 'Gagal mengimpor data siswa: ' . implode(' | ', array_slice($errors, 0, 3)));
            }

            if (count($errors) > 0) {
                $pesan = "{$imported} siswa berhasil diimpor. {$skipped} data dilewati: " . implode(' | ', array_slice($errors, 0, 3));
                if (count($errors) > 3) {
                    $pesan .= ' (dan ' . (count($errors) - 3) . ' lainnya)';
                }
                return redirect()->route('siswa.index')->with('warning', $pesan);
            }

            return redirect()->route('siswa.index')->with('success', "Berhasil mengimpor {$imported} data siswa.");
        } catch (\Throwable $th) {
            return redirect()->route('siswa.index')->with('error', 'Gagal memproses file Excel: ' . $th->getMessage());
        }
    }

    public function create()
    {
        return view('admin.siswa.create', ['active' => 'data_siswa']);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'nama_lengkap' => 'required',
                'nisn' => 'nullable|unique:siswa,nisn',
                'foto' => 'nullable|image|max:2048'
            ]);

            DB::transaction(function () use ($request) {
                $user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'siswa',
                ]);

                $fotoPath = $request->hasFile('foto') 
                    ? $request->file('foto')->store('foto-siswa', 'public') 
                    : null;

                Siswa::create(array_merge($request->all(), [
                    'user_id' => $user->id,
                    'foto' => $fotoPath
                ]));
            });

            return redirect()->route('siswa.index')->with('success', 'Siswa dan Akun berhasil dibuat.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['user', 'kelas']);
        $active = 'data_siswa';
        return view('admin.siswa.show', compact('siswa', 'active'));
    }

    public function edit(Siswa $siswa)
    {
        $siswa->load('user');
        $active = 'data_siswa';
        return view('admin.siswa.edit', compact('siswa', 'active'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        try {
            $siswa->load('user');

            $request->validate([
                'username' => 'required|unique:users,username,' . $siswa->user_id,
                'email' => 'required|email|unique:users,email,' . $siswa->user_id,
                'password' => 'nullable|min:8|confirmed',
                'nama_lengkap' => 'required',
                'nisn' => 'nullable|unique:siswa,nisn,' . $siswa->id,
                'nis' => 'nullable|unique:siswa,nis,' . $siswa->id,
                'jenis_kelamin' => 'nullable|in:L,P',
                'foto' => 'nullable|image|max:2048'
            ]);

            DB::transaction(function () use ($request, $siswa) {
                // Update user account
                $userData = [
                    'username' => $request->username,
                    'email' => $request->email,
                ];
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                $siswa->user->update($userData);

                // Update foto siswa
                $fotoPath = $siswa->foto;
                if ($request->hasFile('foto')) {
                    if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                        Storage::disk('public')->delete($fotoPath);
                    }
                    $fotoPath = $request->file('foto')->store('foto-siswa', 'public');
                }

                if ($request->boolean('hapus_foto') && $fotoPath) {
                    if (Storage::disk('public')->exists($fotoPath)) {
                        Storage::disk('public')->delete($fotoPath);
                    }
                    $fotoPath = null;
                }

                // Update data siswa
                $siswa->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'nisn' => $request->nisn ?: null,
                    'nis' => $request->nis ?: null,
                    'tempat_lahir' => $request->tempat_lahir ?: null,
                    'tanggal_lahir' => $request->tanggal_lahir ?: null,
                    'jenis_kelamin' => $request->jenis_kelamin ?: null,
                    'agama' => $request->agama ?: null,
                    'no_hp' => $request->no_hp ?: null,
                    'alamat' => $request->alamat ?: null,
                    'tahun_masuk' => $request->tahun_masuk ?: null,
                    'is_active' => $request->has('is_active') ? (bool)$request->is_active : $siswa->is_active,
                    'foto' => $fotoPath,
                ]);
            });

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function destroy(Siswa $siswa)
    {
        DB::transaction(function () use ($siswa) {
            $siswa->user()->delete(); // Hapus akun juga
            $siswa->delete();
        });
        return back()->with('success', 'Data siswa berhasil dihapus.');
    }
}