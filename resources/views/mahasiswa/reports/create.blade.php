@extends('layouts.app')
@section('title', 'Buat Laporan')
@section('page-title', 'Buat Laporan Baru')

@section('sidebar-nav')
<div class="nav-section-title">Menu</div>
<ul class="nav flex-column list-unstyled">
    <li class="nav-item"><a href="{{ route('mahasiswa.dashboard') }}"><i class="bi bi-house-fill"></i> Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('mahasiswa.reports.create') }}" class="active"><i class="bi bi-plus-circle-fill"></i> Buat Laporan</a></li>
    <li class="nav-item"><a href="{{ route('mahasiswa.history') }}"><i class="bi bi-clock-history"></i> Riwayat Laporan</a></li>
</ul>
@endsection

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle-fill me-2" style="color:#10b981"></i>Form Laporan Kebersihan Baru
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('mahasiswa.reports.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-pencil me-1" style="color:#10b981"></i>Judul Laporan <span class="text-danger">*</span></label>
                        <input type="text" name="judul_laporan"
                               class="form-control @error('judul_laporan') is-invalid @enderror"
                               value="{{ old('judul_laporan') }}"
                               placeholder="Contoh: Sampah Menumpuk di Gedung A" required/>
                        @error('judul_laporan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-geo-alt me-1" style="color:#ef4444"></i>Lokasi <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi"
                               class="form-control @error('lokasi') is-invalid @enderror"
                               value="{{ old('lokasi') }}"
                               placeholder="Contoh: Gedung A Lantai 2, Dekat Toilet" required/>
                        @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-text-paragraph me-1" style="color:#2563eb"></i>Deskripsi Masalah <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" rows="5"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Jelaskan masalah kebersihan secara detail (minimal 20 karakter)..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text"><i class="bi bi-info-circle me-1"></i>Minimal 20 karakter. Semakin detail semakin baik.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><i class="bi bi-camera me-1" style="color:#7c3aed"></i>Foto Bukti <span class="text-muted fw-normal">(opsional)</span></label>
                        <div class="upload-area p-4 text-center rounded-3" id="uploadArea"
                             style="border:2px dashed rgba(16,185,129,0.3);background:rgba(16,185,129,0.02);cursor:pointer;transition:all 0.3s ease"
                             onclick="document.getElementById('foto_bukti').click()"
                             ondragover="event.preventDefault();this.style.borderColor='#10b981';this.style.background='rgba(16,185,129,0.06)'"
                             ondragleave="this.style.borderColor='rgba(16,185,129,0.3)';this.style.background='rgba(16,185,129,0.02)'"
                             ondrop="event.preventDefault();document.getElementById('foto_bukti').files=event.dataTransfer.files;previewImage(document.getElementById('foto_bukti'));this.style.borderColor='rgba(16,185,129,0.3)';this.style.background='rgba(16,185,129,0.02)'">
                            <input type="file" name="foto_bukti" id="foto_bukti"
                                   class="d-none @error('foto_bukti') is-invalid @enderror"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   onchange="previewImage(this)"/>
                            <div id="uploadPlaceholder">
                                <i class="bi bi-cloud-arrow-up" style="font-size:2.5rem;color:#10b981"></i>
                                <div class="mt-2 fw-500" style="color:#064e3b">Klik atau seret foto ke sini</div>
                                <div class="text-muted small mt-1">JPG, PNG, WEBP — Maks 5 MB</div>
                            </div>
                            <div id="imgPreview" class="d-none">
                                <img id="previewImg" src="" alt="Preview" class="img-fluid rounded-3" style="max-height:250px"/>
                                <div class="mt-2 small text-muted">Klik untuk mengganti foto</div>
                            </div>
                        </div>
                        @error('foto_bukti') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-green px-5">
                            <i class="bi bi-send-fill me-2"></i>Kirim Laporan
                        </button>
                        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary" style="border-radius:10px">Batal</a>
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
    const placeholder = document.getElementById('uploadPlaceholder');
    const img = document.getElementById('previewImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
