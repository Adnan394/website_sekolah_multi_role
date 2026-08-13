<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\Siswa;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profileData = null;

        if ($user->role == 'guru') {
            $profileData = Guru::where('user_id', $user->id)->first();
        } elseif ($user->role == 'siswa') {
            $profileData = Siswa::where('user_id', $user->id)->first();
        }

        return view('profile.index', compact('user', 'profileData'));
    }
}
