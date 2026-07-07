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
            'email' => 'required|email',
            'no_hp' => 'required|string',
            'penghasilan_ortu' => 'required|in:< 500000,500000 - 1000000,1000000 - 1500000,1500000 - 2000000,> 2000000',
            'sktm' => 'required|mimes:pdf|max:2048',
            'transkrip' => 'required|mimes:pdf|max:2048',
            'aktif_kuliah' => 'required|mimes:pdf|max:2048',
            'ktp' => 'required|mimes:pdf|max:2048',
            'ktm' => 'required|mimes:pdf|max:2048',
            'krs' => 'required|mimes:pdf|max:2048',
            'tidak_menerima_beasiswa' => 'required|mimes:pdf|max:2048',
        ]);
        
        $validated['file_sktm'] = $request->file('sktm')->store('uploads/dokumen', 'public');
        $validated['file_transkrip'] = $request->file('transkrip')->store('uploads/dokumen', 'public');
        $validated['file_aktif_kuliah'] = $request->file('aktif_kuliah')->store('uploads/dokumen', 'public');
        $validated['file_ktp'] = $request->file('ktp')->store('uploads/dokumen', 'public');
        $validated['file_ktm'] = $request->file('ktm')->store('uploads/dokumen', 'public');
        $validated['file_krs'] = $request->file('krs')->store('uploads/dokumen', 'public');
        $validated['file_tidak_menerima_beasiswa'] = $request->file('tidak_menerima_beasiswa')->store('uploads/dokumen', 'public');
        
        $validated['user_id'] = auth()->id();
        $validated['status_verifikasi'] = 'MENUNGGU';
        
        Pendaftaran::create($validated);
        
        return redirect()->route('mhs.dashboard')->with('success', 'Pendaftaran berhasil disubmit.');
    }
    
    public function update(Request $request, Pendaftaran $pendaftaran) {
        if($pendaftaran->user_id !== auth()->id()) abort(403);
        
        $validated = $request->validate([
            'nama_lengkap' => 'required|string',
            'email' => 'required|email',
            'no_hp' => 'required|string',
            'penghasilan_ortu' => 'required|in:< 500000,500000 - 1000000,1000000 - 1500000,1500000 - 2000000,> 2000000',
            'sktm' => 'nullable|mimes:pdf|max:2048',
            'transkrip' => 'nullable|mimes:pdf|max:2048',
            'aktif_kuliah' => 'nullable|mimes:pdf|max:2048',
            'ktp' => 'nullable|mimes:pdf|max:2048',
            'ktm' => 'nullable|mimes:pdf|max:2048',
            'krs' => 'nullable|mimes:pdf|max:2048',
            'tidak_menerima_beasiswa' => 'nullable|mimes:pdf|max:2048',
        ]);
        
        if($request->hasFile('sktm')) {
            if($pendaftaran->file_sktm) Storage::disk('public')->delete($pendaftaran->file_sktm);
            $validated['file_sktm'] = $request->file('sktm')->store('uploads/dokumen', 'public');
        }
        if($request->hasFile('transkrip')) {
            if($pendaftaran->file_transkrip) Storage::disk('public')->delete($pendaftaran->file_transkrip);
            $validated['file_transkrip'] = $request->file('transkrip')->store('uploads/dokumen', 'public');
        }
        if($request->hasFile('aktif_kuliah')) {
            if($pendaftaran->file_aktif_kuliah) Storage::disk('public')->delete($pendaftaran->file_aktif_kuliah);
            $validated['file_aktif_kuliah'] = $request->file('aktif_kuliah')->store('uploads/dokumen', 'public');
        }
        if($request->hasFile('ktp')) {
            if($pendaftaran->file_ktp) Storage::disk('public')->delete($pendaftaran->file_ktp);
            $validated['file_ktp'] = $request->file('ktp')->store('uploads/dokumen', 'public');
        }
        if($request->hasFile('ktm')) {
            if($pendaftaran->file_ktm) Storage::disk('public')->delete($pendaftaran->file_ktm);
            $validated['file_ktm'] = $request->file('ktm')->store('uploads/dokumen', 'public');
        }
        if($request->hasFile('krs')) {
            if($pendaftaran->file_krs) Storage::disk('public')->delete($pendaftaran->file_krs);
            $validated['file_krs'] = $request->file('krs')->store('uploads/dokumen', 'public');
        }
        if($request->hasFile('tidak_menerima_beasiswa')) {
            if($pendaftaran->file_tidak_menerima_beasiswa) Storage::disk('public')->delete($pendaftaran->file_tidak_menerima_beasiswa);
            $validated['file_tidak_menerima_beasiswa'] = $request->file('tidak_menerima_beasiswa')->store('uploads/dokumen', 'public');
        }
        
        $pendaftaran->update($validated);
        return redirect()->route('mhs.dashboard')->with('success', 'Data pendaftaran diperbarui.');
    }
}
