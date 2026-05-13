@extends('layouts.auth')
@section('title', 'Login')

@section('auth-content')
<div class="tab-nav">
    <button class="tab-btn active" onclick="showTab('login', this)">Masuk</button>
    <button class="tab-btn" onclick="showTab('register', this)">Daftar</button>
</div>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" style="background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#065f46;border:none;font-size:0.85rem">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" style="background:linear-gradient(135deg,#fee2e2,#fecaca);color:#991b1b;border:none;font-size:0.85rem">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ── Login Form ──────────────────────────────────────────────── --}}
<div class="form-panel active" id="panel-login">
    <h5 style="font-weight:800;color:#064e3b;font-size:1.3rem;margin-bottom:4px">Selamat Datang Kembali 👋</h5>
    <p class="text-muted small mb-4">Masuk dengan akun SIPALING Anda</p>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-person me-1"></i>Username</label>
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                   value="{{ old('username') }}" placeholder="Masukkan username" required autofocus autocomplete="username"/>
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-lock me-1"></i>Password</label>
            <div class="position-relative">
                <input type="password" name="password" id="loginPassword"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Masukkan password" required autocomplete="current-password"/>
                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted pe-3"
                        onclick="togglePassword('loginPassword', this)" style="text-decoration:none;z-index:5">
                    <i class="bi bi-eye"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label small text-muted" for="remember">Ingat saya</label>
        </div>
        <button type="submit" class="btn-submit">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
        </button>
    </form>
</div>

{{-- ── Register Form ───────────────────────────────────────────── --}}
<div class="form-panel" id="panel-register">
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
</div>

@push('scripts')
<script>
function showTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.form-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('panel-' + tab).classList.add('active');
}
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
// If there are validation errors from register, switch to register tab
@if($errors->any() && old('name'))
    document.addEventListener('DOMContentLoaded', () => {
        showTab('register', document.querySelectorAll('.tab-btn')[1]);
    });
@endif
</script>
@endpush
@endsection
