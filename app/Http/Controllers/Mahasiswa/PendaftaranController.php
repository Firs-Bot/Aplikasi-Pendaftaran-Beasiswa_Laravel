<?php
namespace App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller {
    public function index() {
        $pendaftarans = Pendaftaran::with('beasiswa')->where('user_id', auth()->id())->latest()->get();
        return view('mahasiswa.riwayat', compact('pendaftarans'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'beasiswa_id' => 'required|exists:beasiswas,id',
            'nama_lengkap' => 'required|string',
            'nim' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'jurusan' => 'required|string',
            'ipk' => 'required|numeric',
            'email' => 'required|email',
            'no_hp' => 'required|string',
            'sktm' => 'required|mimes:pdf|max:2048',
            'rekomendasi' => 'required|mimes:pdf|max:2048',
            'transkrip' => 'required|mimes:pdf|max:2048',
        ]);
        
        $validated['file_sktm'] = $request->file('sktm')->store('uploads/dokumen', 'public');
        $validated['file_rekomendasi'] = $request->file('rekomendasi')->store('uploads/dokumen', 'public');
        $validated['file_transkrip'] = $request->file('transkrip')->store('uploads/dokumen', 'public');
        
        $validated['user_id'] = auth()->id();
        $validated['status_verifikasi'] = 'MENUNGGU';
        
        Pendaftaran::create($validated);
        
        return redirect()->route('mhs.dashboard')->with('success', 'Pendaftaran berhasil disubmit.');
    }
    
    public function update(Request $request, Pendaftaran $pendaftaran) {
        if($pendaftaran->user_id !== auth()->id()) abort(403);
        
        $validated = $request->validate([
            'nama_lengkap' => 'required|string',
            'ipk' => 'required|numeric',
            'email' => 'required|email',
            'no_hp' => 'required|string',
            'sktm' => 'nullable|mimes:pdf|max:2048',
            'rekomendasi' => 'nullable|mimes:pdf|max:2048',
            'transkrip' => 'nullable|mimes:pdf|max:2048',
        ]);
        
        if($request->hasFile('sktm')) {
            if($pendaftaran->file_sktm) Storage::disk('public')->delete($pendaftaran->file_sktm);
            $validated['file_sktm'] = $request->file('sktm')->store('uploads/dokumen', 'public');
        }
        if($request->hasFile('rekomendasi')) {
            if($pendaftaran->file_rekomendasi) Storage::disk('public')->delete($pendaftaran->file_rekomendasi);
            $validated['file_rekomendasi'] = $request->file('rekomendasi')->store('uploads/dokumen', 'public');
        }
        if($request->hasFile('transkrip')) {
            if($pendaftaran->file_transkrip) Storage::disk('public')->delete($pendaftaran->file_transkrip);
            $validated['file_transkrip'] = $request->file('transkrip')->store('uploads/dokumen', 'public');
        }
        
        $pendaftaran->update($validated);
        return redirect()->route('mhs.dashboard')->with('success', 'Data pendaftaran diperbarui.');
    }
}
