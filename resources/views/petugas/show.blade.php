@extends('layouts.app')
@section('title', 'Detail Tugas')
@section('page-title', 'Detail Tugas')

@section('sidebar-nav')
<div class="nav-section-title">Menu</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item"><a href="{{ route('petugas.dashboard') }}"><i class="bi bi-house-fill"></i> Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('petugas.tasks') }}" class="active"><i class="bi bi-list-task"></i> Tugas Aktif</a></li>
    <li class="nav-item"><a href="{{ route('petugas.history') }}"><i class="bi bi-check2-all"></i> Riwayat Kerja</a></li>
</ul>
@endsection

@section('content')
<div class="mb-3 fade-in">
    <a href="{{ route('petugas.tasks') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:10px">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Tugas
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
                        <div class="p-3 rounded-3" style="background:rgba(16,185,129,0.04);border:1px solid rgba(16,185,129,0.1)">
                            <div class="text-muted small fw-600 mb-1"><i class="bi bi-person me-1"></i>Pelapor</div>
                            <div class="fw-600">{{ $report->mahasiswa?->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:rgba(239,68,68,0.04);border:1px solid rgba(239,68,68,0.1)">
                            <div class="text-muted small fw-600 mb-1"><i class="bi bi-geo-alt me-1"></i>Lokasi</div>
                            <div class="fw-600">{{ $report->lokasi }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:rgba(37,99,235,0.04);border:1px solid rgba(37,99,235,0.1)">
                            <div class="text-muted small fw-600 mb-1"><i class="bi bi-calendar3 me-1"></i>Tanggal Lapor</div>
                            <div class="fw-500">{{ $report->tanggal_lapor?->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:rgba(124,58,237,0.04);border:1px solid rgba(124,58,237,0.1)">
                            <div class="text-muted small fw-600 mb-1"><i class="bi bi-check-circle me-1"></i>Tanggal Disetujui</div>
                            <div class="fw-500">{{ $report->tanggal_disetujui?->format('d M Y, H:i') ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="text-muted small fw-600 mb-2"><i class="bi bi-text-paragraph me-1"></i>Deskripsi Masalah</div>
                    <p class="mb-0" style="line-height:1.8;color:#334155">{{ $report->deskripsi }}</p>
                </div>

                @if($report->foto_bukti)
                <div class="mb-3">
                    <div class="text-muted small fw-600 mb-2"><i class="bi bi-image me-1"></i>Foto Bukti</div>
                    <img src="{{ asset('storage/' . $report->foto_bukti) }}" alt="Foto Bukti"
                         class="img-fluid rounded-3" style="max-height:350px;width:100%;object-fit:cover;box-shadow:0 4px 20px rgba(0,0,0,0.1)"/>
                </div>
                @endif

                @if($report->catatan_admin)
                <div class="p-3 rounded-3" style="background:linear-gradient(135deg,#fef3c7,#fde68a);border:1px solid rgba(245,158,11,0.2)">
                    <i class="bi bi-chat-left-text me-2"></i>
                    <strong>Catatan Admin:</strong>
                    <span style="color:#92400e"> {{ $report->catatan_admin }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4 fade-in">
        @if($report->statusLaporan?->nama_status === 'in_progress')
        <div class="card">
            <div class="card-header"><i class="bi bi-check2-circle me-2" style="color:#10b981"></i>Selesaikan Tugas</div>
            <div class="card-body">
                <p class="text-muted small mb-3">Tambahkan catatan sebelum menandai laporan ini sebagai selesai.</p>
                <form action="{{ route('petugas.tasks.complete', $report) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small">Catatan Penyelesaian <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea name="catatan_petugas" rows="4"
                                  class="form-control @error('catatan_petugas') is-invalid @enderror"
                                  placeholder="Deskripsikan tindakan yang telah dilakukan...">{{ old('catatan_petugas') }}</textarea>
                        @error('catatan_petugas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success w-100" style="border-radius:12px;padding:12px"
                            onclick="return confirm('Tandai laporan ini sebagai selesai?')">
                        <i class="bi bi-check2-all me-2"></i>Tandai Selesai
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="card text-center">
            <div class="card-body py-5">
                <div style="width:70px;height:70px;border-radius:20px;background:linear-gradient(135deg,#059669,#34d399);display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 16px;box-shadow:0 8px 25px rgba(5,150,105,0.3)">✅</div>
                <div class="fw-bold fs-5" style="color:#064e3b">Laporan Selesai</div>
                <div class="text-muted small mt-2">
                    Diselesaikan pada {{ $report->tanggal_selesai?->format('d M Y, H:i') }}
                </div>
                @if($report->catatan_petugas)
                <div class="p-3 rounded-3 text-start mt-3" style="background:linear-gradient(135deg,#dbeafe,#bfdbfe);border:1px solid rgba(59,130,246,0.2)">
                    <strong class="small"><i class="bi bi-chat-left-text me-1"></i>Catatan Anda:</strong>
                    <div class="small mt-1" style="color:#1e40af">{{ $report->catatan_petugas }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
