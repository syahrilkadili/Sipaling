@extends('layouts.auth')
@section('title', 'Daftar')

@section('auth-content')
<div class="tab-nav">
    <a href="{{ route('login') }}" class="tab-btn" style="text-decoration:none;text-align:center">Masuk</a>
    <button class="tab-btn active">Daftar</button>
</div>

<h5 style="font-weight:800;color:#064e3b;font-size:1.3rem;margin-bottom:4px">Buat Akun Baru ✨</h5>
<p class="text-muted small mb-4">Daftar sebagai mahasiswa atau petugas</p>

<form method="POST" action="{{ route('register.post') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name') }}" placeholder="Nama lengkap Anda" required/>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
               value="{{ old('username') }}" placeholder="Pilih username unik" required autocomplete="username"/>
        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Email <span class="text-muted fw-normal">(opsional)</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" placeholder="email@contoh.com"/>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Peran</label>
        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
            <option value="">-- Pilih Peran --</option>
            <option value="mahasiswa" {{ old('role') === 'mahasiswa' ? 'selected' : '' }}>🎓 Mahasiswa</option>
            <option value="petugas"   {{ old('role') === 'petugas'   ? 'selected' : '' }}>🧹 Petugas Kebersihan</option>
        </select>
        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               placeholder="Min. 6 karakter" required autocomplete="new-password"/>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-4">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control"
               placeholder="Ulangi password" required/>
    </div>
    <button type="submit" class="btn-submit">
        <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
    </button>
</form>
@endsection
