<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('search')) {
            $query->where(fn($q) =>
                $q->where('username', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%')
            );
        }

        // Admin cannot list other admins (or can see all – your choice)
        $users = $query->where('role', '!=', 'admin')
                       ->withCount([
                           'laporanSebagaiMahasiswa',
                           'laporanSebagaiPetugas',
                       ])
                       ->latest()
                       ->paginate(15)
                       ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username', 'regex:/^[a-zA-Z0-9_]+$/'],
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['nullable', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'role'     => ['required', 'in:mahasiswa,petugas'],
        ]);

        User::create([
            'username' => $validated['username'],
            'name'     => $validated['name'],
            'email'    => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:100', 'unique:users,email,' . $user->id],
            'role'  => ['required', 'in:mahasiswa,petugas'],
        ]);

        $user->update($validated);

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Password::min(6)]]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun admin.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
