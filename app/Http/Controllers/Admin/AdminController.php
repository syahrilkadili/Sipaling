<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\StatusLaporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ── Statistics ─────────────────────────────────────────────────────────
        $stats = [
            'total'       => Report::count(),
            'pending'     => Report::pending()->count(),
            'confirmed'   => Report::confirmed()->count(),
            'in_progress' => Report::inProgress()->count(),
            'completed'   => Report::completed()->count(),
            'rejected'    => Report::rejected()->count(),
        ];

        $totalUsers = User::count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalPetugas   = User::where('role', 'petugas')->count();

        // ── Recent Reports ─────────────────────────────────────────────────────
        $recentReports = Report::with(['mahasiswa', 'statusLaporan'])
            ->latest()
            ->take(5)
            ->get();

        // ── Chart Data: last 7 days report count ───────────────────────────────
        $chartData = Report::select(
                DB::raw("DATE(tanggal_lapor) as date"),
                DB::raw("COUNT(*) as total")
            )
            ->where('tanggal_lapor', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ── Status Distribution for Pie Chart ─────────────────────────────────
        $statusDistribution = StatusLaporan::withCount('reports')->get();

        // ── Top Petugas ────────────────────────────────────────────────────────
        $topPetugas = User::where('role', 'petugas')
            ->withCount(['laporanSebagaiPetugas as selesai' => fn($q) => $q->completed()])
            ->orderByDesc('selesai')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'totalUsers', 'totalMahasiswa', 'totalPetugas',
            'recentReports', 'chartData', 'statusDistribution', 'topPetugas'
        ));
    }
}
