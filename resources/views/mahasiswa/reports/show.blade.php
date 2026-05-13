@extends('layouts.app')
@section('title', 'Detail Laporan')
@section('page-title', 'Detail Laporan')

@section('sidebar-nav')
<div class="nav-section-title">Menu</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item"><a href="{{ route('mahasiswa.dashboard') }}"><i class="bi bi-house-fill"></i> Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('mahasiswa.reports.create') }}"><i class="bi bi-plus-circle-fill"></i> Buat Laporan</a></li>
    <li class="nav-item"><a href="{{ route('mahasiswa.history') }}" class="active"><i class="bi bi-clock-history"></i> Riwayat Laporan</a></li>
</ul>
@endsection

@section('content')
<div class="mb-3 fade-in">
    <a href="{{ route('mahasiswa.history') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:10px">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>
<div class="row g-4">
    <div class="col-lg-8 fade-in">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-file-earmark-text-fill me-2" style="color:#10b981"></i>Laporan #{{ $report->id }}</span>
                <span class="badge bg-{{ $report->statusLaporan?->warna ?? 'secondary' }}" style="font-size:0.82rem;padding:6px 14px">
                    {{ $report->statusLaporan?->label ?? '-' }}
                </span>
            </div>
            <div class="card-body">
                <h5 class="fw-bold mb-4" style="color:#064e3b">{{ $report->judul_laporan }}</h5>
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:rgba(239,68,68,0.04);border:1px solid rgba(239,68,68,0.1)">
                            <div class="text-muted small fw-600 mb-1"><i class="bi bi-geo-alt me-1"></i>Lokasi</div>
                            <div class="fw-600">{{ $report->lokasi }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:rgba(37,99,235,0.04);border:1px solid rgba(37,99,235,0.1)">
                            <div class="text-muted small fw-600 mb-1"><i class="bi bi-calendar3 me-1"></i>Tanggal Lapor</div>
                            <div class="fw-500">{{ $report->tanggal_lapor?->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                    @if($report->petugas)
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:rgba(124,58,237,0.04);border:1px solid rgba(124,58,237,0.1)">
                            <div class="text-muted small fw-600 mb-1"><i class="bi bi-person-gear me-1"></i>Petugas Ditugaskan</div>
                            <div class="fw-500">{{ $report->petugas->name }}</div>
                        </div>
                    </div>
                    @endif
                    @if($report->tanggal_selesai)
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:rgba(16,185,129,0.04);border:1px solid rgba(16,185,129,0.1)">
                            <div class="text-muted small fw-600 mb-1"><i class="bi bi-flag me-1"></i>Tanggal Selesai</div>
                            <div class="fw-500">{{ $report->tanggal_selesai->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="mb-4">
                    <div class="text-muted small fw-600 mb-2"><i class="bi bi-text-paragraph me-1"></i>Deskripsi</div>
                    <p style="line-height:1.8;color:#334155">{{ $report->deskripsi }}</p>
                </div>
                @if($report->foto_bukti)
                <div class="mb-3">
                    <div class="text-muted small fw-600 mb-2"><i class="bi bi-image me-1"></i>Foto Bukti</div>
                    <img src="{{ asset('storage/' . $report->foto_bukti) }}" alt="Foto Bukti"
                         class="img-fluid rounded-3" style="max-height:300px;width:100%;object-fit:cover;box-shadow:0 4px 20px rgba(0,0,0,0.1)"/>
                </div>
                @endif
                @if($report->catatan_admin)
                <div class="p-3 rounded-3 mb-3" style="background:linear-gradient(135deg,#fef3c7,#fde68a);border:1px solid rgba(245,158,11,0.2)">
                    <strong><i class="bi bi-chat-left-text me-1"></i>Catatan Admin:</strong>
                    <span style="color:#92400e"> {{ $report->catatan_admin }}</span>
                </div>
                @endif
                @if($report->catatan_petugas)
                <div class="p-3 rounded-3" style="background:linear-gradient(135deg,#dbeafe,#bfdbfe);border:1px solid rgba(59,130,246,0.2)">
                    <strong><i class="bi bi-chat-left-text me-1"></i>Catatan Petugas:</strong>
                    <span style="color:#1e40af"> {{ $report->catatan_petugas }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4 fade-in">
        @if($report->isEditable())
        <div class="card">
            <div class="card-header"><i class="bi bi-gear-fill me-2" style="color:#10b981"></i>Aksi</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('mahasiswa.reports.edit', $report) }}" class="btn btn-outline-primary" style="border-radius:12px;padding:12px">
                    <i class="bi bi-pencil-square me-2"></i>Edit Laporan
                </a>
                <form action="{{ route('mahasiswa.reports.destroy', $report) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger w-100" style="border-radius:12px;padding:12px"><i class="bi bi-trash3 me-2"></i>Hapus Laporan</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
