<?php

namespace App\Http\Controllers\Perpustakaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login-perpustakaan');
    }

    public function login_store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->role === 'Admin Perpustakaan') {
                return redirect()->route('perpustakaan.dashboard')->with('success', 'Login Berhasil!');
            }
            Auth::logout();
            return back()->withErrors([
                'email' => 'Anda tidak memiliki akses sebagai Admin Perpustakaan.',
            ]);
        } else {
            return back()->withErrors([
                'email' => 'Email atau Password salah.',
            ]);
        }
    }
}
