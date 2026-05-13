@extends('layouts.app')
@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')

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
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square" style="color:#10b981"></i>
                <span>Edit Pengguna: <strong>{{ $user->name }}</strong></span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required/>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" value="{{ $user->username }}" disabled
                               style="background:rgba(16,185,129,0.04)"/>
                        <div class="form-text"><i class="bi bi-info-circle me-1"></i>Username tidak dapat diubah</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}"/>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Peran</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="mahasiswa" {{ old('role', $user->role) === 'mahasiswa' ? 'selected' : '' }}>🎓 Mahasiswa</option>
                            <option value="petugas"   {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>🧹 Petugas</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru <span class="text-muted fw-normal">(kosongkan jika tidak diubah)</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"/>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control"/>
                    </div>
                    <button type="submit" class="btn btn-green px-5"><i class="bi bi-check-lg me-2"></i>Perbarui</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
