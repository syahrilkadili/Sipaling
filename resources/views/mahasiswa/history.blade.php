@extends('layouts.app')
@section('title', 'Riwayat Laporan')
@section('page-title', 'Riwayat Laporan Saya')

@section('sidebar-nav')
<div class="nav-section-title">Menu</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item"><a href="{{ route('mahasiswa.dashboard') }}"><i class="bi bi-house-fill"></i> Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('mahasiswa.reports.create') }}"><i class="bi bi-plus-circle-fill"></i> Buat Laporan</a></li>
    <li class="nav-item"><a href="{{ route('mahasiswa.history') }}" class="active"><i class="bi bi-clock-history"></i> Riwayat Laporan</a></li>
</ul>
@endsection

@section('content')
<div class="card fade-in">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="bi bi-clock-history me-2" style="color:#10b981"></i>Riwayat Laporan</span>
        <div class="d-flex gap-2 flex-wrap">
            <form class="d-flex gap-2" method="GET">
                <select name="status" class="form-select form-select-sm" style="width:155px;border-radius:10px" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $s)
                        <option value="{{ $s->nama_status }}" {{ request('status') === $s->nama_status ? 'selected' : '' }}>
                            {{ $s->label }}
                        </option>
                    @endforeach
                </select>
            </form>
            <a href="{{ route('mahasiswa.reports.create') }}" class="btn btn-sm btn-green">
                <i class="bi bi-plus-lg me-1"></i>Buat Laporan
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Judul</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Petugas</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td class="ps-4 fw-600">{{ Str::limit($report->judul_laporan, 30) }}</td>
                        <td class="text-muted small"><i class="bi bi-geo-alt me-1" style="color:#ef4444"></i>{{ Str::limit($report->lokasi, 22) }}</td>
                        <td>
                            <span class="badge bg-{{ $report->statusLaporan?->warna ?? 'secondary' }}">
                                {{ $report->statusLaporan?->label ?? '-' }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $report->petugas?->name ?? '-' }}</td>
                        <td class="text-muted small">{{ $report->tanggal_lapor?->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('mahasiswa.reports.show', $report) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;padding:5px 10px">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @if($report->isEditable())
                                <a href="{{ route('mahasiswa.reports.edit', $report) }}" class="btn btn-sm btn-outline-warning" style="border-radius:8px;padding:5px 10px">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('mahasiswa.reports.destroy', $report) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus laporan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" style="border-radius:8px;padding:5px 10px"><i class="bi bi-trash3"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">
                        <div style="font-size:2.5rem">📭</div>
                        <div class="mt-2">Belum ada laporan. <a href="{{ route('mahasiswa.reports.create') }}" style="color:#059669">Buat sekarang →</a></div>
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
