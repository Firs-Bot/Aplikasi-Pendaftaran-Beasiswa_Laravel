<?php
namespace App\Http\Controllers\Baak;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PendaftaranController extends Controller {
    public function exportPdf(Request $request) {
        $allowedFilters = ['MENUNGGU', 'SEDANG DITINJAU', 'LOLOS', 'DITOLAK'];
        $filter = $request->query('filter');
        if (! in_array($filter, $allowedFilters, true)) {
            $filter = null;
        }

        $query = Pendaftaran::with(['beasiswa', 'user'])->orderBy('id', 'desc');
        
        if($filter) {
            $query->where('status_verifikasi', $filter);
        }
        
        $pendaftarans = $query->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('baak.pendaftaran.pdf', compact('pendaftarans', 'filter'));
        
        // Atur ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'landscape');
        
        $filename = 'Laporan_Pendaftar_Beasiswa';
        if($filter) {
            $filename .= '_' . str_replace(' ', '_', $filter);
        }
        $filename .= '_' . date('Y-m-d') . '.pdf';

        Log::info('BAAK mengekspor laporan PDF pendaftaran', [
            'user_id' => auth()->id(),
            'filter' => $filter ?? 'SEMUA',
            'ip' => $request->ip(),
        ]);
        
        return $pdf->download($filename);
    }
    public function index(Request $request) {
        $allowedFilters = ['MENUNGGU', 'SEDANG DITINJAU', 'LOLOS', 'DITOLAK'];
        $filter = $request->query('filter');
        if (! in_array($filter, $allowedFilters, true)) {
            $filter = null;
        }

        $query = Pendaftaran::with('beasiswa')->orderBy('id', 'desc');
        if($filter) {
            $query->where('status_verifikasi', $filter);
        }
        $pendaftarans = $query->get();
        return view('baak.pendaftaran.index', compact('pendaftarans', 'filter'));
    }
    public function update(Request $request, Pendaftaran $pendaftaran) {
        $request->validate([
            'status_verifikasi' => 'required|in:SEDANG DITINJAU,LOLOS,DITOLAK'
        ]);
        if(in_array($pendaftaran->status_verifikasi, ['LOLOS', 'DITOLAK'])) {
            return back()->with('error', 'Status pendaftaran sudah final dan tidak dapat diubah.');
        }
        $oldStatus = $pendaftaran->status_verifikasi;
        $pendaftaran->update(['status_verifikasi' => $request->status_verifikasi]);
        Log::info('BAAK memperbarui status verifikasi pendaftaran', [
            'user_id' => auth()->id(),
            'pendaftaran_id' => $pendaftaran->id,
            'old_status' => $oldStatus,
            'new_status' => $request->status_verifikasi,
            'ip' => $request->ip(),
        ]);
        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
