@extends('layouts.app')
@section('title', 'Dashboard Petugas')
@section('page-title', 'Dashboard Petugas')

@section('sidebar-nav')
<div class="nav-section-title">Menu</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item">
        <a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-fill"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('petugas.tasks') }}" class="{{ request()->routeIs('petugas.tasks*') ? 'active' : '' }}">
            <i class="bi bi-list-task"></i> Tugas Aktif
            @if($stats['aktif'] > 0)
                <span class="badge bg-warning text-dark ms-auto">{{ $stats['aktif'] }}</span>
            @endif
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('petugas.history') }}" class="{{ request()->routeIs('petugas.history') ? 'active' : '' }}">
            <i class="bi bi-check2-all"></i> Riwayat Kerja
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="mb-4 fade-in">
    <h4 class="fw-bold" style="color:#064e3b">
        Selamat Datang, {{ auth()->user()->name ?? auth()->user()->username }}! 🧹
    </h4>
    <p class="text-muted mb-0">Berikut adalah ringkasan tugas kebersihan Anda hari ini</p>
</div>

{{-- ── Stats ──────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-md-4 fade-in stagger-1">
        <div class="stat-card bg-blue-grad">
            <div class="stat-icon">📌</div>
            <div class="stat-value">{{ $stats['aktif'] }}</div>
            <div class="stat-label">Tugas Aktif</div>
        </div>
    </div>
    <div class="col-md-4 fade-in stagger-2">
        <div class="stat-card bg-purple-grad">
            <div class="stat-icon">✅</div>
            <div class="stat-value">{{ $stats['selesai'] }}</div>
            <div class="stat-label">Total Selesai</div>
        </div>
    </div>
    <div class="col-md-4 fade-in stagger-3">
        <div class="stat-card bg-green-grad">
            <div class="stat-icon">📊</div>
            <div class="stat-value">{{ $stats['total'] > 0 ? round(($stats['selesai']/$stats['total'])*100) : 0 }}%</div>
            <div class="stat-label">Tingkat Penyelesaian</div>
        </div>
    </div>
</div>

{{-- ── Active Tasks ───────────────────────────────────────────────── --}}
<div class="card fade-in">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-task me-2" style="color:#10b981"></i>Tugas Aktif Saya</span>
        <a href="{{ route('petugas.tasks') }}" class="btn btn-sm btn-green">
            <i class="bi bi-arrow-right me-1"></i>Lihat Semua
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Judul Laporan</th>
                        <th>Pelapor</th>
                        <th>Lokasi</th>
                        <th>Tanggal Lapor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeTasks as $task)
                    <tr>
                        <td class="ps-4 fw-600">{{ Str::limit($task->judul_laporan, 30) }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#d1fae5,#a7f3d0);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.65rem;color:#059669;flex-shrink:0">
                                    {{ strtoupper(substr($task->mahasiswa?->name ?? '-', 0, 1)) }}
                                </div>
                                <span class="small">{{ $task->mahasiswa?->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="text-muted small"><i class="bi bi-geo-alt me-1" style="color:#ef4444"></i>{{ Str::limit($task->lokasi, 20) }}</td>
                        <td class="text-muted small">{{ $task->tanggal_lapor?->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('petugas.tasks.show', $task) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;padding:5px 10px">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <form action="{{ route('petugas.tasks.complete', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" style="border-radius:8px;padding:5px 10px"
                                            onclick="return confirm('Tandai laporan ini sebagai selesai?')">
                                        <i class="bi bi-check2"></i> Selesai
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-5">
                        <div style="font-size:3rem">🎉</div>
                        <div class="fw-600 mt-2" style="color:#064e3b">Tidak ada tugas aktif</div>
                        <div class="small mt-1">Semua tugas sudah selesai!</div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
