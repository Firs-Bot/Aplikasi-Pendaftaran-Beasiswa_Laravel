<?php
namespace App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller {
    public function index() {
        $pendaftarans = Pendaftaran::with('beasiswa')->where('user_id', auth()->id())->latest()->get();
        return view('mahasiswa.riwayat', compact('pendaftarans'));
    }

    public function store(Request $request) {
        $hasActive = Pendaftaran::where('user_id', auth()->id())
            ->whereIn('status_verifikasi', ['MENUNGGU', 'SEDANG DITINJAU'])
            ->exists();

        if ($hasActive) {
            return back()->with('error', 'Anda masih memiliki pendaftaran yang sedang menunggu atau ditinjau.');
        }

        $validated = $request->validate([
            'beasiswa_id' => 'required|exists:beasiswas,id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'jurusan' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => ['required', 'string', 'max:25', 'regex:/^[0-9+\-\s()]{8,25}$/'],
            'penghasilan_ortu' => 'required|in:< 500000,500000 - 1000000,1000000 - 1500000,1500000 - 2000000,> 2000000',
            'sktm' => 'required|file|mimes:pdf|max:2048',
            'transkrip' => 'required|file|mimes:pdf|max:2048',
            'aktif_kuliah' => 'required|file|mimes:pdf|max:2048',
            'ktp' => 'required|file|mimes:pdf|max:2048',
            'ktm' => 'required|file|mimes:pdf|max:2048',
            'krs' => 'required|file|mimes:pdf|max:2048',
            'tidak_menerima_beasiswa' => 'required|file|mimes:pdf|max:2048',
        ]);
        
        $validated['nama_lengkap'] = strip_tags(auth()->user()->nama_lengkap);
        $validated['nim'] = strip_tags(auth()->user()->nim_username);
        $validated['jurusan'] = strip_tags($validated['jurusan']);
        $validated['no_hp'] = strip_tags($validated['no_hp']);

        $validated['file_sktm'] = $request->file('sktm')->store('uploads/dokumen', 'local');
        $validated['file_transkrip'] = $request->file('transkrip')->store('uploads/dokumen', 'local');
        $validated['file_aktif_kuliah'] = $request->file('aktif_kuliah')->store('uploads/dokumen', 'local');
        $validated['file_ktp'] = $request->file('ktp')->store('uploads/dokumen', 'local');
        $validated['file_ktm'] = $request->file('ktm')->store('uploads/dokumen', 'local');
        $validated['file_krs'] = $request->file('krs')->store('uploads/dokumen', 'local');
        $validated['file_tidak_menerima_beasiswa'] = $request->file('tidak_menerima_beasiswa')->store('uploads/dokumen', 'local');
        
        $validated['user_id'] = auth()->id();
        $validated['status_verifikasi'] = 'MENUNGGU';
        
        $pendaftaran = Pendaftaran::create($validated);

        Log::info('Pendaftaran beasiswa baru disubmit', [
            'pendaftaran_id' => $pendaftaran->id,
            'user_id' => auth()->id(),
            'beasiswa_id' => $pendaftaran->beasiswa_id,
            'ip' => $request->ip(),
        ]);
        
        return redirect()->route('mhs.dashboard')->with('success', 'Pendaftaran berhasil disubmit.');
    }
    
    public function update(Request $request, Pendaftaran $pendaftaran) {
        if ($pendaftaran->user_id !== auth()->id()) {
            Log::warning('Percobaan IDOR update pendaftaran mahasiswa lain', [
                'user_id' => auth()->id(),
                'pendaftaran_id' => $pendaftaran->id,
                'owner_id' => $pendaftaran->user_id,
                'ip' => $request->ip(),
            ]);
            abort(403);
        }

        if ($pendaftaran->status_verifikasi !== 'MENUNGGU') {
            abort(403, 'Pendaftaran yang sudah ditinjau atau diverifikasi tidak dapat diubah.');
        }
        
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'no_hp' => ['required', 'string', 'max:25', 'regex:/^[0-9+\-\s()]{8,25}$/'],
            'penghasilan_ortu' => 'required|in:< 500000,500000 - 1000000,1000000 - 1500000,1500000 - 2000000,> 2000000',
            'sktm' => 'nullable|file|mimes:pdf|max:2048',
            'transkrip' => 'nullable|file|mimes:pdf|max:2048',
            'aktif_kuliah' => 'nullable|file|mimes:pdf|max:2048',
            'ktp' => 'nullable|file|mimes:pdf|max:2048',
            'ktm' => 'nullable|file|mimes:pdf|max:2048',
            'krs' => 'nullable|file|mimes:pdf|max:2048',
            'tidak_menerima_beasiswa' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $validated['nama_lengkap'] = strip_tags(auth()->user()->nama_lengkap);
        $validated['no_hp'] = strip_tags($validated['no_hp']);
        
        $fileMap = [
            'sktm' => 'file_sktm',
            'transkrip' => 'file_transkrip',
            'aktif_kuliah' => 'file_aktif_kuliah',
            'ktp' => 'file_ktp',
            'ktm' => 'file_ktm',
            'krs' => 'file_krs',
            'tidak_menerima_beasiswa' => 'file_tidak_menerima_beasiswa',
        ];

        foreach ($fileMap as $input => $column) {
            if ($request->hasFile($input)) {
                if ($pendaftaran->$column) {
                    Storage::disk('local')->delete($pendaftaran->$column);
                    Storage::disk('public')->delete($pendaftaran->$column);
                }
                $validated[$column] = $request->file($input)->store('uploads/dokumen', 'local');
            }
        }
        
        $pendaftaran->update($validated);

        Log::info('Pendaftaran beasiswa diperbarui oleh mahasiswa', [
            'pendaftaran_id' => $pendaftaran->id,
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
        ]);

        return redirect()->route('mhs.dashboard')->with('success', 'Data pendaftaran diperbarui.');
    }

    public function downloadDokumen(Pendaftaran $pendaftaran, string $jenis) {
        $allowed = [
            'sktm' => 'file_sktm',
            'transkrip' => 'file_transkrip',
            'aktif_kuliah' => 'file_aktif_kuliah',
            'ktp' => 'file_ktp',
            'ktm' => 'file_ktm',
            'krs' => 'file_krs',
            'tidak_menerima_beasiswa' => 'file_tidak_menerima_beasiswa',
        ];

        if (! isset($allowed[$jenis])) {
            abort(404);
        }

        $user = auth()->user();
        if (! in_array($user->role, ['admin', 'baak'], true) && $pendaftaran->user_id !== $user->id) {
            Log::warning('Percobaan akses dokumen tidak sah (IDOR)', [
                'user_id' => $user->id,
                'pendaftaran_id' => $pendaftaran->id,
                'jenis' => $jenis,
                'ip' => request()->ip(),
            ]);
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        $column = $allowed[$jenis];
        $path = $pendaftaran->$column;
        if (! $path) {
            abort(404);
        }

        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->response($path);
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->response($path);
        }

        abort(404, 'Berkas tidak ditemukan.');
    }
}
