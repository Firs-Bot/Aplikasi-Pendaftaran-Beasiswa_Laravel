<?php
namespace App\Http\Controllers\Baak;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller {
    public function exportPdf(Request $request) {
        $filter = $request->query('filter');
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
        
        return $pdf->download($filename);
    }
    public function index(Request $request) {
        $filter = $request->query('filter');
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
        $pendaftaran->update(['status_verifikasi' => $request->status_verifikasi]);
        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
