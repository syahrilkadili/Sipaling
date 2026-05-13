<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ─── Show Login Form ───────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }
        return view('auth.login');
    }

    // ─── Handle Login ──────────────────────────────────────────────────────────

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            return redirect()->route($user->getDashboardRoute())
                ->with('success', 'Selamat datang, ' . $user->name ?? $user->username . '!');
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['username' => 'Username atau password salah.']);
    }

    // ─── Show Register Form ────────────────────────────────────────────────────

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }
        return view('auth.register');
    }

    // ─── Handle Register ───────────────────────────────────────────────────────

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username', 'regex:/^[a-zA-Z0-9_]+$/'],
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['nullable', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'role'     => ['required', 'in:mahasiswa,petugas'],
        ], [
            'username.regex'  => 'Username hanya boleh berisi huruf, angka, dan underscore.',
            'username.unique' => 'Username sudah digunakan.',
            'email.unique'    => 'Email sudah digunakan.',
            'role.in'         => 'Role tidak valid.',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'name'     => $validated['name'],
            'email'    => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        Auth::login($user);

        return redirect()->route($user->getDashboardRoute())
            ->with('success', 'Akun berhasil dibuat. Selamat datang!');
    }

    // ─── Logout ────────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}
