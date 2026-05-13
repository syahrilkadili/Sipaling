<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\StatusLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
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
            'total'       => $user->laporanSebagaiMahasiswa()->count(),
            'pending'     => $user->laporanSebagaiMahasiswa()->pending()->count(),
            'in_progress' => $user->laporanSebagaiMahasiswa()->inProgress()->count(),
            'completed'   => $user->laporanSebagaiMahasiswa()->completed()->count(),
            'rejected'    => $user->laporanSebagaiMahasiswa()->rejected()->count(),
        ];

        $recentReports = $user->laporanSebagaiMahasiswa()
            ->with('statusLaporan')
            ->latest()
            ->take(5)
            ->get();

        return view('mahasiswa.dashboard', compact('stats', 'recentReports'));
    }

    // ─── Report History ────────────────────────────────────────────────────────

    public function history(Request $request)
    {
        $query = $this->currentUser()
            ->laporanSebagaiMahasiswa()
            ->with(['statusLaporan', 'petugas']);

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        $reports  = $query->latest()->paginate(10)->withQueryString();
        $statuses = StatusLaporan::all();

        return view('mahasiswa.history', compact('reports', 'statuses'));
    }

    // ─── Create Report ─────────────────────────────────────────────────────────

    public function create()
    {
        return view('mahasiswa.reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_laporan' => ['required', 'string', 'max:200'],
            'deskripsi'     => ['required', 'string', 'min:20'],
            'lokasi'        => ['required', 'string', 'max:255'],
            'foto_bukti'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'foto_bukti.image'   => 'File harus berupa gambar.',
            'foto_bukti.mimes'   => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'foto_bukti.max'     => 'Ukuran gambar maksimal 5 MB.',
            'deskripsi.min'      => 'Deskripsi minimal 20 karakter.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')
                ->store('laporan/foto', 'public');
        }

        Report::create([
            'mahasiswa_id'     => Auth::id(),
            'judul_laporan'    => $validated['judul_laporan'],
            'deskripsi'        => $validated['deskripsi'],
            'lokasi'           => $validated['lokasi'],
            'foto_bukti'       => $fotoPath,
            'status_laporan_id'=> StatusLaporan::idOf(StatusLaporan::PENDING),
            'tanggal_lapor'    => now(),
        ]);

        return redirect()->route('mahasiswa.history')
            ->with('success', 'Laporan berhasil dikirim dan sedang menunggu konfirmasi admin.');
    }

    // ─── Edit Report ───────────────────────────────────────────────────────────

    public function edit(Report $report)
    {
        $this->authorizeReport($report);

        if (!$report->isEditable()) {
            return back()->with('error', 'Laporan hanya dapat diedit saat berstatus Menunggu.');
        }

        return view('mahasiswa.reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $this->authorizeReport($report);

        if (!$report->isEditable()) {
            return back()->with('error', 'Laporan tidak dapat diedit pada status ini.');
        }

        $validated = $request->validate([
            'judul_laporan' => ['required', 'string', 'max:200'],
            'deskripsi'     => ['required', 'string', 'min:20'],
            'lokasi'        => ['required', 'string', 'max:255'],
            'foto_bukti'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $fotoPath = $report->foto_bukti;
        if ($request->hasFile('foto_bukti')) {
            // Delete old photo
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto_bukti')
                ->store('laporan/foto', 'public');
        }

        $report->update([
            'judul_laporan' => $validated['judul_laporan'],
            'deskripsi'     => $validated['deskripsi'],
            'lokasi'        => $validated['lokasi'],
            'foto_bukti'    => $fotoPath,
        ]);

        return redirect()->route('mahasiswa.history')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    // ─── Delete Report ─────────────────────────────────────────────────────────

    public function destroy(Report $report)
    {
        $this->authorizeReport($report);

        if (!$report->isEditable()) {
            return back()->with('error', 'Laporan hanya dapat dihapus saat berstatus Menunggu.');
        }

        if ($report->foto_bukti) {
            Storage::disk('public')->delete($report->foto_bukti);
        }
        $report->delete();

        return redirect()->route('mahasiswa.history')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    // ─── Show Single Report ────────────────────────────────────────────────────

    public function show(Report $report)
    {
        $this->authorizeReport($report);
        $report->load(['statusLaporan', 'petugas']);
        return view('mahasiswa.reports.show', compact('report'));
    }

    // ─── Authorization Helper ──────────────────────────────────────────────────

    private function authorizeReport(Report $report): void
    {
        if ($report->mahasiswa_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }
    }
}
