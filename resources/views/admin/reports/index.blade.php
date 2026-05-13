@extends('layouts.app')
@section('title', 'Kelola Laporan')
@section('page-title', 'Kelola Laporan')

@section('sidebar-nav')
<div class="nav-section-title">Menu Utama</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('admin.reports.index') }}" class="active"><i class="bi bi-file-earmark-text-fill"></i> Kelola Laporan</a></li>
    <li class="nav-item"><a href="{{ route('admin.users.index') }}"><i class="bi bi-people-fill"></i> Kelola Pengguna</a></li>
</ul>
@endsection

@section('content')
<div class="card fade-in">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="bi bi-file-earmark-text-fill me-2" style="color:#10b981"></i>Daftar Laporan</span>
        <form class="d-flex gap-2 flex-wrap" method="GET">
            <select name="status" class="form-select form-select-sm" style="width:165px;border-radius:10px" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach($statuses as $s)
                    <option value="{{ $s->nama_status }}" {{ request('status') === $s->nama_status ? 'selected' : '' }}>
                        {{ $s->label }}
                    </option>
                @endforeach
            </select>
            <div class="input-group input-group-sm" style="width:210px">
                <input type="text" name="search" class="form-control" placeholder="Cari judul..." value="{{ request('search') }}" style="border-radius:10px 0 0 10px"/>
                <button class="btn btn-green" type="submit" style="border-radius:0 10px 10px 0"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Judul</th>
                        <th>Mahasiswa</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td class="ps-4 text-muted fw-500">{{ $report->id }}</td>
                        <td class="fw-600">{{ Str::limit($report->judul_laporan, 35) }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#d1fae5,#a7f3d0);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.65rem;color:#059669;flex-shrink:0">
                                    {{ strtoupper(substr($report->mahasiswa?->name ?? '-', 0, 1)) }}
                                </div>
                                <span class="small">{{ $report->mahasiswa?->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="text-muted small"><i class="bi bi-geo-alt me-1" style="color:#ef4444"></i>{{ Str::limit($report->lokasi, 22) }}</td>
                        <td>
                            <span class="badge bg-{{ $report->statusLaporan?->warna ?? 'secondary' }}">
                                {{ $report->statusLaporan?->label ?? '-' }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $report->tanggal_lapor?->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;padding:5px 10px">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">
                        <div style="font-size:2.5rem">📭</div>
                        <div class="mt-2">Tidak ada laporan ditemukan</div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($reports->hasPages())
    <div class="card-footer bg-transparent border-top-0 p-3">{{ $reports->links() }}</div>
    @endif
</div>
@endsection
