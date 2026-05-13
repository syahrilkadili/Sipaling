<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    /** Reports submitted by this user (as mahasiswa) */
    public function laporanSebagaiMahasiswa()
    {
        return $this->hasMany(Report::class, 'mahasiswa_id');
    }

    /** Reports assigned to this user (as petugas) */
    public function laporanSebagaiPetugas()
    {
        return $this->hasMany(Report::class, 'petugas_id');
    }

    // ─── Role Helpers ──────────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function getDashboardRoute(): string
    {
        return match ($this->role) {
            'admin'      => 'admin.dashboard',
            'petugas'    => 'petugas.dashboard',
            default      => 'mahasiswa.dashboard',
        };
    }
}
