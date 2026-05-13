<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'petugas_id',
        'judul_laporan',
        'deskripsi',
        'lokasi',
        'foto_bukti',
        'status_laporan_id',
        'tanggal_lapor',
        'tanggal_disetujui',
        'tanggal_selesai',
        'catatan_admin',
        'catatan_petugas',
    ];

    protected $casts = [
        'tanggal_lapor'      => 'datetime',
        'tanggal_disetujui'  => 'datetime',
        'tanggal_selesai'    => 'datetime',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    /** The mahasiswa who submitted this report */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    /** The petugas assigned to this report */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    /** The status of this report */
    public function statusLaporan()
    {
        return $this->belongsTo(StatusLaporan::class, 'status_laporan_id');
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeByStatus($query, string $namaStatus)
    {
        return $query->whereHas('statusLaporan', fn($q) => $q->where('nama_status', $namaStatus));
    }

    public function scopePending($query)
    {
        return $query->byStatus(StatusLaporan::PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->byStatus(StatusLaporan::CONFIRMED);
    }

    public function scopeInProgress($query)
    {
        return $query->byStatus(StatusLaporan::IN_PROGRESS);
    }

    public function scopeCompleted($query)
    {
        return $query->byStatus(StatusLaporan::COMPLETED);
    }

    public function scopeRejected($query)
    {
        return $query->byStatus(StatusLaporan::REJECTED);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    public function isPending(): bool
    {
        return $this->statusLaporan?->nama_status === StatusLaporan::PENDING;
    }

    public function isEditable(): bool
    {
        return $this->isPending();
    }

    public function getFotoBuktiUrlAttribute(): ?string
    {
        return $this->foto_bukti
            ? asset('storage/' . $this->foto_bukti)
            : null;
    }
}
