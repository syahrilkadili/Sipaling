<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\StatusLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    private function currentUser()
    {
        return Auth::user();
    }

    // ─── Dashboard ─────────────────────────────────────────────────────────────

    public function dashboard()
    {
        $user = $this->currentUser();

        $stats = [
            'aktif'    => $user->laporanSebagaiPetugas()->inProgress()->count(),
            'selesai'  => $user->laporanSebagaiPetugas()->completed()->count(),
            'total'    => $user->laporanSebagaiPetugas()->count(),
        ];

        $activeTasks = $user->laporanSebagaiPetugas()
            ->with(['mahasiswa', 'statusLaporan'])
            ->inProgress()
            ->latest()
            ->take(5)
            ->get();

        return view('petugas.dashboard', compact('stats', 'activeTasks'));
    }

    // ─── Active Tasks ──────────────────────────────────────────────────────────

    public function tasks()
    {
        $tasks = $this->currentUser()
            ->laporanSebagaiPetugas()
            ->with(['mahasiswa', 'statusLaporan'])
            ->inProgress()
            ->latest()
            ->paginate(10);

        return view('petugas.tasks', compact('tasks'));
    }

    // ─── Complete a Report ─────────────────────────────────────────────────────

    public function complete(Request $request, Report $report)
    {
        // Ensure this report is assigned to the current petugas
        if ($report->petugas_id !== Auth::id()) {
            abort(403, 'Laporan ini bukan tanggung jawab Anda.');
        }

        $request->validate([
            'catatan_petugas' => ['nullable', 'string', 'max:500'],
        ]);

        $report->update([
            'status_laporan_id' => StatusLaporan::idOf(StatusLaporan::COMPLETED),
            'tanggal_selesai'   => now(),
            'catatan_petugas'   => $request->catatan_petugas,
        ]);

        return redirect()->route('petugas.tasks')
            ->with('success', 'Laporan berhasil ditandai selesai.');
    }

    // ─── Work History ──────────────────────────────────────────────────────────

    public function history()
    {
        $reports = $this->currentUser()
            ->laporanSebagaiPetugas()
            ->with(['mahasiswa', 'statusLaporan'])
            ->completed()
            ->latest('tanggal_selesai')
            ->paginate(10);

        return view('petugas.history', compact('reports'));
    }

    // ─── Show Task Detail ──────────────────────────────────────────────────────

    public function show(Report $report)
    {
        if ($report->petugas_id !== Auth::id()) {
            abort(403);
        }
        $report->load(['mahasiswa', 'statusLaporan']);
        return view('petugas.show', compact('report'));
    }
}
