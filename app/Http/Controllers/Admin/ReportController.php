<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\StatusLaporan;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /** List all reports with filters */
    public function index(Request $request)
    {
        $query = Report::with(['mahasiswa', 'petugas', 'statusLaporan'])->latest();

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }
        if ($request->filled('search')) {
            $query->where('judul_laporan', 'like', '%' . $request->search . '%');
        }

        $reports  = $query->paginate(15)->withQueryString();
        $statuses = StatusLaporan::all();

        return view('admin.reports.index', compact('reports', 'statuses'));
    }

    /** Show single report */
    public function show(Report $report)
    {
        $report->load(['mahasiswa', 'petugas', 'statusLaporan']);
        $petugasList = User::where('role', 'petugas')->get();
        return view('admin.reports.show', compact('report', 'petugasList'));
    }

    /** Confirm a pending report */
    public function confirm(Report $report)
    {
        $report->update([
            'status_laporan_id' => StatusLaporan::idOf(StatusLaporan::CONFIRMED),
            'tanggal_disetujui' => now(),
        ]);

        return back()->with('success', 'Laporan #' . $report->id . ' berhasil dikonfirmasi.');
    }

    /** Reject a report */
    public function reject(Request $request, Report $report)
    {
        $request->validate([
            'catatan_admin' => ['required', 'string', 'max:500'],
        ]);

        $report->update([
            'status_laporan_id' => StatusLaporan::idOf(StatusLaporan::REJECTED),
            'catatan_admin'     => $request->catatan_admin,
        ]);

        return back()->with('success', 'Laporan #' . $report->id . ' telah ditolak.');
    }

    /** Assign petugas to a confirmed report */
    public function assign(Request $request, Report $report)
    {
        $request->validate([
            'petugas_id' => ['required', 'exists:users,id'],
        ]);

        $petugas = User::where('id', $request->petugas_id)
                       ->where('role', 'petugas')
                       ->firstOrFail();

        $report->update([
            'petugas_id'        => $petugas->id,
            'status_laporan_id' => StatusLaporan::idOf(StatusLaporan::IN_PROGRESS),
        ]);

        return back()->with('success', 'Laporan berhasil ditugaskan ke ' . $petugas->name . '.');
    }

    /** Delete a report */
    public function destroy(Report $report)
    {
        if ($report->foto_bukti) {
            \Storage::disk('public')->delete($report->foto_bukti);
        }
        $report->delete();

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
