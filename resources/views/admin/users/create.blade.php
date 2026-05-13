@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')

@section('sidebar-nav')
<div class="nav-section-title">Menu Utama</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('admin.reports.index') }}"><i class="bi bi-file-earmark-text-fill"></i> Kelola Laporan</a></li>
    <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="active"><i class="bi bi-people-fill"></i> Kelola Pengguna</a></li>
</ul>
@endsection

@section('content')
<div class="mb-3 fade-in">
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:10px">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>
<div class="row justify-content-center fade-in">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-plus-fill me-2" style="color:#10b981"></i>Tambah Pengguna Baru
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required/>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                               value="{{ old('username') }}" placeholder="Pilih username unik" required/>
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
                            <option value="petugas"   {{ old('role') === 'petugas' ? 'selected' : '' }}>🧹 Petugas</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 6 karakter" required/>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required/>
                    </div>
                    <button type="submit" class="btn btn-green px-5"><i class="bi bi-check-lg me-2"></i>Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
