<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusLaporan extends Model
{
    protected $table = 'status_laporan';

    protected $fillable = ['nama_status', 'label', 'warna', 'deskripsi'];

    // ─── Status Constants ──────────────────────────────────────────────────────
    const PENDING     = 'pending';
    const CONFIRMED   = 'confirmed';
    const IN_PROGRESS = 'in_progress';
    const COMPLETED   = 'completed';
    const REJECTED    = 'rejected';

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function reports()
    {
        return $this->hasMany(Report::class, 'status_laporan_id');
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    public static function idOf(string $namaStatus): int
    {
        return static::where('nama_status', $namaStatus)->value('id');
    }
}
