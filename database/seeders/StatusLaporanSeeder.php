<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusLaporan;

class StatusLaporanSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'nama_status' => 'pending',
                'label'       => 'Menunggu',
                'warna'       => 'warning',
                'deskripsi'   => 'Laporan baru, menunggu konfirmasi admin.',
            ],
            [
                'nama_status' => 'confirmed',
                'label'       => 'Dikonfirmasi',
                'warna'       => 'info',
                'deskripsi'   => 'Laporan telah dikonfirmasi oleh admin, menunggu penugasan petugas.',
            ],
            [
                'nama_status' => 'in_progress',
                'label'       => 'Sedang Dikerjakan',
                'warna'       => 'primary',
                'deskripsi'   => 'Laporan sedang ditangani oleh petugas kebersihan.',
            ],
            [
                'nama_status' => 'completed',
                'label'       => 'Selesai',
                'warna'       => 'success',
                'deskripsi'   => 'Laporan telah selesai ditangani.',
            ],
            [
                'nama_status' => 'rejected',
                'label'       => 'Ditolak',
                'warna'       => 'danger',
                'deskripsi'   => 'Laporan ditolak oleh admin karena tidak valid.',
            ],
        ];

        foreach ($statuses as $status) {
            StatusLaporan::updateOrCreate(
                ['nama_status' => $status['nama_status']],
                $status
            );
        }
    }
}
