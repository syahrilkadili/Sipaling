@extends('layouts.app')
@section('title', 'Edit Laporan')
@section('page-title', 'Edit Laporan')

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
<div class="row justify-content-center fade-in">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil-square me-2" style="color:#10b981"></i>Edit Laporan #{{ $report->id }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('mahasiswa.reports.update', $report) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                        <input type="text" name="judul_laporan" class="form-control @error('judul_laporan') is-invalid @enderror"
                               value="{{ old('judul_laporan', $report->judul_laporan) }}" required/>
                        @error('judul_laporan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                               value="{{ old('lokasi', $report->lokasi) }}" required/>
                        @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $report->deskripsi) }}</textarea>
                        @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Foto Bukti</label>
                        @if($report->foto_bukti)
                        <div class="mb-3 p-3 rounded-3" style="background:rgba(16,185,129,0.04);border:1px solid rgba(16,185,129,0.1)">
                            <img src="{{ asset('storage/' . $report->foto_bukti) }}" alt="Foto saat ini"
                                 class="img-fluid rounded-3" style="max-height:180px"/>
                            <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Foto saat ini. Upload baru untuk mengganti.</div>
                        </div>
                        @endif
                        <input type="file" name="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp" onchange="previewImage(this)"/>
                        @error('foto_bukti') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div id="imgPreview" class="mt-2 d-none">
                            <img id="previewImg" src="" alt="Preview" class="img-fluid rounded-3" style="max-height:200px"/>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-green px-5"><i class="bi bi-check-lg me-2"></i>Perbarui</button>
                        <a href="{{ route('mahasiswa.history') }}" class="btn btn-outline-secondary" style="border-radius:10px">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imgPreview');
    const img = document.getElementById('previewImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; preview.classList.remove('d-none'); };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
