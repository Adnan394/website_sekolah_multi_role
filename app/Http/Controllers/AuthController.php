<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    

    /**
     * Menampilkan halaman form registrasi.
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Memproses data registrasi dan menyimpan pengguna baru.
     */
    public function register_store(Request $request)
    {
        $validated = $request->validate([
            'username'  => 'required|string|max:255|unique:users,username',
            'email'     => 'required|email|max:255|unique:users,email'
        ], [
            'username.required'  => 'Nama pengguna wajib diisi.',
            'username.unique'    => 'Nama pengguna sudah digunakan.',
            'email.required'     => 'Email wajib diisi.',
            'role.required'      => 'Peran wajib dipilih.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
        ]);

        $user = User::create([
            'username'  => $request['username'],
            'email'     => $request['email'],
            'role'      => $request['role'],
            'password'  => Hash::make($request['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/login')
            ->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $user->username . '!');
    }
    public function login() {
        return view('auth.login');
    }

    public function login_store(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/admin/dashboard')->with('success', 'Login Berhasil!');
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
                'password' => 'The provided credentials do not match our records.',
            ]);
        }
    } 

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}