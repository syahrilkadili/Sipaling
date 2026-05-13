@extends('layouts.app')
@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('sidebar-nav')
<div class="nav-section-title">Menu Utama</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('admin.reports.index') }}"><i class="bi bi-file-earmark-text-fill"></i> Kelola Laporan</a></li>
    <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="active"><i class="bi bi-people-fill"></i> Kelola Pengguna</a></li>
</ul>
@endsection

@section('content')
<div class="card fade-in">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="bi bi-people-fill me-2" style="color:#10b981"></i>Daftar Pengguna</span>
        <div class="d-flex gap-2 flex-wrap">
            <form class="d-flex gap-2" method="GET">
                <select name="role" class="form-select form-select-sm" style="width:140px;border-radius:10px" onchange="this.form.submit()">
                    <option value="">Semua Peran</option>
                    <option value="mahasiswa" {{ request('role') === 'mahasiswa' ? 'selected' : '' }}>🎓 Mahasiswa</option>
                    <option value="petugas"   {{ request('role') === 'petugas'   ? 'selected' : '' }}>🧹 Petugas</option>
                </select>
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}" style="border-radius:10px 0 0 10px"/>
                    <button class="btn btn-green" type="submit" style="border-radius:0 10px 10px 0"><i class="bi bi-search"></i></button>
                </div>
            </form>
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-green">
                <i class="bi bi-plus-lg me-1"></i>Tambah
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Peran</th>
                        <th>Laporan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#d1fae5,#a7f3d0);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8rem;color:#059669;flex-shrink:0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="fw-600">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $user->username }}</td>
                        <td class="text-muted small">{{ $user->email ?? '-' }}</td>
                        <td>
                            @if($user->role === 'mahasiswa')
                                <span class="badge" style="background:rgba(5,150,105,0.1);color:#059669">🎓 Mahasiswa</span>
                            @else
                                <span class="badge" style="background:rgba(37,99,235,0.1);color:#2563eb">🧹 Petugas</span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            @if($user->role === 'mahasiswa')
                                {{ $user->laporan_sebagai_mahasiswa_count }} laporan
                            @else
                                {{ $user->laporan_sebagai_petugas_count }} tugas
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;padding:5px 10px">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" style="border-radius:8px;padding:5px 10px"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">
                        <div style="font-size:2.5rem">👥</div>
                        <div class="mt-2">Tidak ada pengguna ditemukan</div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-transparent border-top-0 p-3">{{ $users->links() }}</div>
    @endif
</div>
@endsection
