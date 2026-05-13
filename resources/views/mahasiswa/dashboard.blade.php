@extends('layouts.app')
@section('title', 'Dashboard Mahasiswa')
@section('page-title', 'Dashboard Mahasiswa')

@section('sidebar-nav')
<div class="nav-section-title">Menu</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item">
        <a href="{{ route('mahasiswa.dashboard') }}" class="{{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-fill"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('mahasiswa.reports.create') }}" class="{{ request()->routeIs('mahasiswa.reports.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle-fill"></i> Buat Laporan
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('mahasiswa.history') }}" class="{{ request()->routeIs('mahasiswa.history') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Riwayat Laporan
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="mb-4 fade-in">
    <h4 class="fw-bold" style="color:#064e3b">
        Halo, {{ auth()->user()->name ?? auth()->user()->username }}! 👋
    </h4>
    <p class="text-muted mb-0">Pantau dan kelola laporan kebersihan lingkungan kampus Anda</p>
</div>

{{-- ── Stats ──────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3 fade-in stagger-1">
        <div class="stat-card bg-green-grad">
            <div class="stat-icon">📋</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Laporan</div>
        </div>
    </div>
    <div class="col-6 col-md-3 fade-in stagger-2">
        <div class="stat-card bg-orange-grad">
            <div class="stat-icon">⏳</div>
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label">Menunggu</div>
        </div>
    </div>
    <div class="col-6 col-md-3 fade-in stagger-3">
        <div class="stat-card bg-blue-grad">
            <div class="stat-icon">🔧</div>
            <div class="stat-value">{{ $stats['in_progress'] }}</div>
            <div class="stat-label">Dikerjakan</div>
        </div>
    </div>
    <div class="col-6 col-md-3 fade-in stagger-4">
        <div class="stat-card bg-purple-grad">
            <div class="stat-icon">✅</div>
            <div class="stat-value">{{ $stats['completed'] }}</div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>
</div>

{{-- ── Quick Action + Table ───────────────────────────────────────── --}}
<div class="row g-4 mb-4">
    <div class="col-md-4 fade-in">
        <div class="card h-100 text-center" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:1px solid rgba(16,185,129,0.15)">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-5">
                <div style="width:70px;height:70px;border-radius:20px;background:linear-gradient(135deg,#059669,#34d399);display:flex;align-items:center;justify-content:center;font-size:2rem;box-shadow:0 8px 25px rgba(5,150,105,0.3);margin-bottom:16px">📝</div>
                <h6 class="fw-bold mb-1" style="color:#064e3b">Buat Laporan Baru</h6>
                <p class="text-muted small mb-4">Laporkan masalah kebersihan di kampus</p>
                <a href="{{ route('mahasiswa.reports.create') }}" class="btn btn-green px-4">
                    <i class="bi bi-plus-lg me-1"></i>Buat Laporan
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-8 fade-in">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2" style="color:#10b981"></i>Laporan Terbaru Saya</span>
                <a href="{{ route('mahasiswa.history') }}" class="btn btn-sm btn-outline-success" style="border-radius:10px">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Judul</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentReports as $report)
                            <tr>
                                <td class="ps-4 fw-600">{{ Str::limit($report->judul_laporan, 25) }}</td>
                                <td class="text-muted small"><i class="bi bi-geo-alt me-1" style="color:#ef4444"></i>{{ Str::limit($report->lokasi, 20) }}</td>
                                <td>
                                    <span class="badge bg-{{ $report->statusLaporan?->warna ?? 'secondary' }}">
                                        {{ $report->statusLaporan?->label ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $report->tanggal_lapor?->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('mahasiswa.reports.show', $report) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;padding:4px 10px">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-5">
                                <div style="font-size:2rem">📭</div>
                                <div class="mt-2">Belum ada laporan. <a href="{{ route('mahasiswa.reports.create') }}" style="color:#059669">Buat sekarang →</a></div>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
