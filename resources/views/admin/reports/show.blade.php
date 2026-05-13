@extends('layouts.app')
@section('title', 'Detail Laporan #' . $report->id)
@section('page-title', 'Detail Laporan')

@section('sidebar-nav')
<div class="nav-section-title">Menu Utama</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('admin.reports.index') }}" class="active"><i class="bi bi-file-earmark-text-fill"></i> Kelola Laporan</a></li>
    <li class="nav-item"><a href="{{ route('admin.users.index') }}"><i class="bi bi-people-fill"></i> Kelola Pengguna</a></li>
</ul>
@endsection

@section('content')
<div class="mb-3 fade-in">
    <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:10px">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row g-4">
    {{-- ── Report Detail ──────────────────────────────────────────── --}}
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
                            <div class="fw-600">{{ $report->mahasiswa?->name ?? '-' }} <span class="text-muted fw-normal">({{ $report->mahasiswa?->username }})</span></div>
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
                            <div class="fw-500">{{ $report->tanggal_lapor?->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:rgba(124,58,237,0.04);border:1px solid rgba(124,58,237,0.1)">
                            <div class="text-muted small fw-600 mb-1"><i class="bi bi-person-gear me-1"></i>Petugas</div>
                            <div class="fw-500">{!! $report->petugas?->name ?? '<span class="text-muted">Belum ditugaskan</span>' !!}</div>
                        </div>
                    </div>
                    @if($report->tanggal_disetujui)
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3" style="background:rgba(16,185,129,0.04);border:1px solid rgba(16,185,129,0.1)">
                            <div class="text-muted small fw-600 mb-1"><i class="bi bi-check-circle me-1"></i>Tanggal Disetujui</div>
                            <div class="fw-500">{{ $report->tanggal_disetujui->format('d M Y H:i') }}</div>
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
                    <p class="mb-0" style="line-height:1.8;color:#334155">{{ $report->deskripsi }}</p>
                </div>

                @if($report->foto_bukti)
                <div class="mb-4">
                    <div class="text-muted small fw-600 mb-2"><i class="bi bi-image me-1"></i>Foto Bukti</div>
                    <img src="{{ asset('storage/' . $report->foto_bukti) }}" alt="Foto Bukti"
                         class="img-fluid rounded-3" style="max-height:350px; object-fit:cover; width:100%; box-shadow:0 4px 20px rgba(0,0,0,0.1)"/>
                </div>
                @endif

                @if($report->catatan_admin)
                <div class="p-3 rounded-3 mb-3" style="background:linear-gradient(135deg,#fef3c7,#fde68a);border:1px solid rgba(245,158,11,0.2)">
                    <strong><i class="bi bi-chat-left-text me-1"></i>Catatan Admin:</strong><br>
                    <span style="color:#92400e">{{ $report->catatan_admin }}</span>
                </div>
                @endif
                @if($report->catatan_petugas)
                <div class="p-3 rounded-3" style="background:linear-gradient(135deg,#dbeafe,#bfdbfe);border:1px solid rgba(59,130,246,0.2)">
                    <strong><i class="bi bi-chat-left-text me-1"></i>Catatan Petugas:</strong><br>
                    <span style="color:#1e40af">{{ $report->catatan_petugas }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Admin Actions ──────────────────────────────────────────── --}}
    <div class="col-lg-4 fade-in">
        <div class="card">
            <div class="card-header"><i class="bi bi-gear-fill me-2" style="color:#10b981"></i>Aksi Admin</div>
            <div class="card-body d-grid gap-3">
                {{-- Confirm / Reject (when pending) --}}
                @if($report->statusLaporan?->nama_status === 'pending')
                <form action="{{ route('admin.reports.confirm', $report) }}" method="POST">
                    @csrf
                    <button class="btn btn-success w-100" style="border-radius:12px;padding:12px">
                        <i class="bi bi-check-circle-fill me-2"></i>Konfirmasi Laporan
                    </button>
                </form>
                <form action="{{ route('admin.reports.reject', $report) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <textarea name="catatan_admin" class="form-control @error('catatan_admin') is-invalid @enderror"
                                  rows="3" placeholder="Alasan penolakan (wajib)..." required></textarea>
                        @error('catatan_admin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button class="btn btn-danger w-100" style="border-radius:12px;padding:12px">
                        <i class="bi bi-x-circle-fill me-2"></i>Tolak Laporan
                    </button>
                </form>
                @endif

                {{-- Assign petugas (when confirmed) --}}
                @if($report->statusLaporan?->nama_status === 'confirmed')
                <form action="{{ route('admin.reports.assign', $report) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small">Tugaskan ke Petugas</label>
                        <select name="petugas_id" class="form-select @error('petugas_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($petugasList as $petugas)
                                <option value="{{ $petugas->id }}" {{ $report->petugas_id == $petugas->id ? 'selected' : '' }}>
                                    {{ $petugas->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('petugas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button class="btn btn-primary w-100" style="border-radius:12px;padding:12px">
                        <i class="bi bi-person-check-fill me-2"></i>Tugaskan Petugas
                    </button>
                </form>
                @endif

                {{-- Delete --}}
                <hr class="my-1" style="border-color:rgba(0,0,0,0.06)">
                <form action="{{ route('admin.reports.destroy', $report) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger w-100" style="border-radius:12px;padding:12px">
                        <i class="bi bi-trash3 me-2"></i>Hapus Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
