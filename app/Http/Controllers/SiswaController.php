<?php 

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    public function destroy(Siswa $siswa)
    {
        DB::transaction(function () use ($siswa) {
            $siswa->user()->delete(); // Hapus akun juga
            $siswa->delete();
        });
        return back()->with('success', 'Data siswa berhasil dihapus.');
    }
}