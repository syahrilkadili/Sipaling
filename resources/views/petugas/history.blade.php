@extends('layouts.app')
@section('title', 'Riwayat Kerja')
@section('page-title', 'Riwayat Kerja')

@section('sidebar-nav')
<div class="nav-section-title">Menu</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item"><a href="{{ route('petugas.dashboard') }}"><i class="bi bi-house-fill"></i> Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('petugas.tasks') }}"><i class="bi bi-list-task"></i> Tugas Aktif</a></li>
    <li class="nav-item"><a href="{{ route('petugas.history') }}" class="active"><i class="bi bi-check2-all"></i> Riwayat Kerja</a></li>
</ul>
@endsection

@section('content')
<div class="card fade-in">
    <div class="card-header"><i class="bi bi-check2-all me-2" style="color:#10b981"></i>Riwayat Pekerjaan Selesai</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Judul Laporan</th>
                        <th>Pelapor</th>
                        <th>Lokasi</th>
                        <th>Tanggal Lapor</th>
                        <th>Tanggal Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td class="ps-4 fw-600">{{ Str::limit($report->judul_laporan, 30) }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#d1fae5,#a7f3d0);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.65rem;color:#059669;flex-shrink:0">
                                    {{ strtoupper(substr($report->mahasiswa?->name ?? '-', 0, 1)) }}
                                </div>
                                <span class="small">{{ $report->mahasiswa?->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="text-muted small"><i class="bi bi-geo-alt me-1" style="color:#ef4444"></i>{{ Str::limit($report->lokasi, 20) }}</td>
                        <td class="text-muted small">{{ $report->tanggal_lapor?->format('d M Y') }}</td>
                        <td>
                            <span class="badge" style="background:rgba(5,150,105,0.1);color:#059669">
                                <i class="bi bi-check-lg me-1"></i>
                                {{ $report->tanggal_selesai?->format('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('petugas.tasks.show', $report) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;padding:5px 10px">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">
                        <div style="font-size:2.5rem">📋</div>
                        <div class="fw-600 mt-2" style="color:#064e3b">Belum ada pekerjaan diselesaikan</div>
                        <div class="small mt-1">Selesaikan tugas aktif untuk melihat riwayat</div>
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
