@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('sidebar-nav')
<div class="nav-section-title">Menu Utama</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text-fill"></i> Kelola Laporan
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Kelola Pengguna
        </a>
    </li>
</ul>
@endsection

@section('content')
{{-- ── Welcome Banner ─────────────────────────────────────────────── --}}
<div class="mb-4 fade-in">
    <h4 class="fw-bold" style="color:#064e3b">
        Selamat Datang, Admin! 🛡️
    </h4>
    <p class="text-muted mb-0">Pantau & kelola seluruh aktivitas sistem pelaporan kampus</p>
</div>

{{-- ── Stat Cards ─────────────────────────────────────────────────── --}}
<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3 fade-in stagger-1">
        <div class="stat-card bg-green-grad">
            <div class="stat-icon">📋</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Laporan</div>
        </div>
    </div>
    <div class="col-6 col-lg-3 fade-in stagger-2">
        <div class="stat-card bg-orange-grad">
            <div class="stat-icon">⏳</div>
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label">Menunggu Konfirmasi</div>
        </div>
    </div>
    <div class="col-6 col-lg-3 fade-in stagger-3">
        <div class="stat-card bg-blue-grad">
            <div class="stat-icon">🔧</div>
            <div class="stat-value">{{ $stats['in_progress'] }}</div>
            <div class="stat-label">Sedang Dikerjakan</div>
        </div>
    </div>
    <div class="col-6 col-lg-3 fade-in stagger-4">
        <div class="stat-card bg-purple-grad">
            <div class="stat-icon">✅</div>
            <div class="stat-value">{{ $stats['completed'] }}</div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>
</div>

{{-- ── Second Row: Users + Chart ──────────────────────────────────── --}}
<div class="row g-4 mb-4">
    <div class="col-md-4 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3" style="color:#064e3b">
                    <i class="bi bi-people-fill me-2" style="color:#10b981"></i>Statistik Pengguna
                </h6>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:linear-gradient(135deg,#d1fae5,#a7f3d0)">
                        <i class="bi bi-person-badge fs-4" style="color:#059669"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-3" style="color:#064e3b">{{ $totalUsers }}</div>
                        <div class="text-muted small">Total Pengguna</div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="fw-600" style="color:#064e3b">🎓 Mahasiswa</span>
                        <strong style="color:#059669">{{ $totalMahasiswa }}</strong>
                    </div>
                    <div class="progress" style="height:8px">
                        <div class="progress-bar" style="width:{{ $totalUsers ? ($totalMahasiswa/$totalUsers*100) : 0 }}%;background:linear-gradient(90deg,#059669,#34d399)"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="fw-600" style="color:#064e3b">🧹 Petugas</span>
                        <strong style="color:#2563eb">{{ $totalPetugas }}</strong>
                    </div>
                    <div class="progress" style="height:8px">
                        <div class="progress-bar" style="width:{{ $totalUsers ? ($totalPetugas/$totalUsers*100) : 0 }}%;background:linear-gradient(90deg,#2563eb,#60a5fa)"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3" style="color:#064e3b">
                    <i class="bi bi-bar-chart-fill me-2" style="color:#10b981"></i>Laporan 7 Hari Terakhir
                </h6>
                <canvas id="chartLaporan" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ── Third Row: Recent Reports (Full Width) ───────────────────────── --}}
<div class="row g-4 mb-4">
    <div class="col-12 fade-in">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2" style="color:#10b981"></i>Laporan Terbaru</span>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-green">
                    <i class="bi bi-arrow-right me-1"></i>Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Judul</th>
                                <th>Mahasiswa</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentReports as $report)
                            <tr>
                                <td class="ps-4">
                                    <a href="{{ route('admin.reports.show', $report) }}" class="text-decoration-none fw-600" style="color:#1e293b">
                                        {{ Str::limit($report->judul_laporan, 30) }}
                                    </a>
                                </td>
                                <td>{{ $report->mahasiswa?->name ?? '-' }}</td>
                                <td><span class="text-muted small"><i class="bi bi-geo-alt me-1" style="color:#ef4444"></i>{{ Str::limit($report->lokasi, 20) }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $report->statusLaporan?->warna ?? 'secondary' }}">
                                        {{ $report->statusLaporan?->label ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $report->tanggal_lapor?->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-5">
                                <div style="font-size:2.5rem">📭</div>
                                <div class="mt-2">Belum ada laporan</div>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Fourth Row: Distribusi Status (Full Width, grows downward) ──── --}}
<div class="row g-4">
    <div class="col-12 fade-in">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-pie-chart-fill me-2" style="color:#10b981"></i>Distribusi Status Laporan</span>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div style="max-width:300px;margin:0 auto">
                            <canvas id="chartStatus"></canvas>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row g-3 mt-3 mt-md-0">
                            @php $statusColors = ['#f59e0b','#06b6d4','#3b82f6','#10b981','#ef4444']; @endphp
                            @foreach($statusDistribution as $i => $status)
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:rgba(0,0,0,0.02);border:1px solid rgba(0,0,0,0.05)">
                                    <div style="width:12px;height:12px;border-radius:4px;background:{{ $statusColors[$i % 5] }};flex-shrink:0"></div>
                                    <div class="flex-grow-1">
                                        <div class="small fw-600" style="color:#1e293b">{{ $status->label }}</div>
                                        <div class="text-muted" style="font-size:0.75rem">{{ $status->reports_count }} laporan</div>
                                    </div>
                                    <div class="fw-bold fs-5" style="color:{{ $statusColors[$i % 5] }}">{{ $status->reports_count }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ── Bar Chart ──────────────────────────────────────────────────────
const chartData = @json($chartData);
new Chart(document.getElementById('chartLaporan'), {
    type: 'bar',
    data: {
        labels: chartData.map(d => d.date),
        datasets: [{
            label: 'Laporan',
            data: chartData.map(d => d.total),
            backgroundColor: 'rgba(16,185,129,0.2)',
            borderColor: '#10b981',
            borderWidth: 2, borderRadius: 8,
            hoverBackgroundColor: 'rgba(16,185,129,0.4)',
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(0,0,0,0.04)' } },
            x: { grid: { display: false } }
        },
        animation: { duration: 1200, easing: 'easeOutQuart' }
    }
});

// ── Doughnut Chart ─────────────────────────────────────────────────
const statusData = @json($statusDistribution);
new Chart(document.getElementById('chartStatus'), {
    type: 'doughnut',
    data: {
        labels: statusData.map(s => s.label),
        datasets: [{
            data: statusData.map(s => s.reports_count),
            backgroundColor: ['#f59e0b','#06b6d4','#3b82f6','#10b981','#ef4444'],
            borderWidth: 3, borderColor: '#fff',
            hoverOffset: 8,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: { position: 'bottom', labels: { font: { size: 11, family: 'Plus Jakarta Sans' }, padding: 16, usePointStyle: true, pointStyleWidth: 8 } }
        },
        animation: { animateRotate: true, duration: 1500 }
    }
});
</script>
@endpush
