<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminPerpusController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'Admin Perpustakaan')->latest()->get();
        return view('admin.admin_perpus.index', compact('admins'), ['active' => 'admin_perpus']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Admin Perpustakaan',
        ]);

        return redirect()->route('admin-perpus.index')->with('success', 'Admin Perpustakaan berhasil ditambahkan.');
    }

    public function update(Request $request, User $admin_perpu)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin_perpu->id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin_perpu->update($data);

        return redirect()->route('admin-perpus.index')->with('success', 'Admin Perpustakaan berhasil diperbarui.');
    }

    public function destroy(User $admin_perpu)
    {
        $admin_perpu->delete();
        return redirect()->route('admin-perpus.index')->with('success', 'Admin Perpustakaan berhasil dihapus.');
    }
}
