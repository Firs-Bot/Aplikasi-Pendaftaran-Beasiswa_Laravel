<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Beasiswa;
use App\Models\Pengumuman;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'beasiswas' => Beasiswa::count(),
            'pengumumans' => Pengumuman::count(),
            'pendaftarans' => Pendaftaran::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = addcslashes($request->string('search')->toString(), '%_');
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nim_username', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function beasiswas(Request $request)
    {
        $query = Beasiswa::query();

        if ($request->filled('search')) {
            $search = addcslashes($request->string('search')->toString(), '%_');
            $query->where(function($q) use ($search) {
                $q->where('nama_beasiswa', 'like', "%{$search}%")
                  ->orWhere('penyedia', 'like', "%{$search}%");
            });
        }

        $beasiswas = $query->latest()->get();
        return view('admin.beasiswa', compact('beasiswas'));
    }

    public function pengumumans(Request $request)
    {
        $query = Pengumuman::query();

        if ($request->filled('search')) {
            $search = addcslashes($request->string('search')->toString(), '%_');
            $query->where('judul', 'like', "%{$search}%");
        }

        $pengumumans = $query->latest()->get();
        return view('admin.pengumuman', compact('pengumumans'));
    }

    public function pendaftarans(Request $request)
    {
        $query = Pendaftaran::with(['user', 'beasiswa']);

        if ($request->filled('search')) {
            $search = addcslashes($request->string('search')->toString(), '%_');
            $query->where('nama_lengkap', 'like', "%{$search}%");
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status_verifikasi', $request->status);
        }

        $pendaftarans = $query->latest()->get();
        return view('admin.pendaftaran', compact('pendaftarans'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim_username' => 'required|string|max:100|unique:users,nim_username,' . $id,
            'role' => 'required|in:mahasiswa,baak,admin',
            'password' => ['nullable', 'string', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $validated['nama_lengkap'] = strip_tags($validated['nama_lengkap']);
        $validated['nim_username'] = strip_tags($validated['nim_username']);

        if ($request->filled('password')) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        \Illuminate\Support\Facades\Log::info('Admin memperbarui data pengguna', [
            'admin_id' => auth()->id(),
            'target_user_id' => $user->id,
            'ip' => $request->ip(),
        ]);
        return back()->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function updateBeasiswa(Request $request, $id)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        $validated = $request->validate([
            'nama_beasiswa' => 'required|string|max:255',
            'penyedia' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:5000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $validated['nama_beasiswa'] = strip_tags($validated['nama_beasiswa']);
        $validated['penyedia'] = strip_tags($validated['penyedia']);
        $validated['deskripsi'] = strip_tags($validated['deskripsi']);

        if ($request->hasFile('foto')) {
            if ($beasiswa->foto) \Illuminate\Support\Facades\Storage::disk('public')->delete($beasiswa->foto);
            $validated['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        $beasiswa->update($validated);
        \Illuminate\Support\Facades\Log::info('Admin memperbarui data beasiswa', [
            'admin_id' => auth()->id(),
            'beasiswa_id' => $beasiswa->id,
            'ip' => $request->ip(),
        ]);
        return back()->with('success', 'Beasiswa berhasil diperbarui.');
    }

    public function updatePengumuman(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:10000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $validated['judul'] = strip_tags($validated['judul']);
        $validated['isi'] = strip_tags($validated['isi']);

        if ($request->hasFile('gambar')) {
            if ($pengumuman->gambar) \Illuminate\Support\Facades\Storage::disk('public')->delete($pengumuman->gambar);
            $validated['gambar'] = $request->file('gambar')->store('uploads', 'public');
        }

        $pengumuman->update($validated);
        \Illuminate\Support\Facades\Log::info('Admin memperbarui pengumuman', [
            'admin_id' => auth()->id(),
            'pengumuman_id' => $pengumuman->id,
            'ip' => $request->ip(),
        ]);
        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function updatePendaftaran(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'jurusan' => 'required|string|max:255',
            'penghasilan_ortu' => 'required|in:< 500000,500000 - 1000000,1000000 - 1500000,1500000 - 2000000,> 2000000',
            'status_verifikasi' => 'required|in:MENUNGGU,SEDANG DITINJAU,LOLOS,DITOLAK',
            'file_sktm' => 'nullable|file|mimes:pdf|max:2048',
            'file_transkrip' => 'nullable|file|mimes:pdf|max:2048',
            'file_aktif_kuliah' => 'nullable|file|mimes:pdf|max:2048',
            'file_ktp' => 'nullable|file|mimes:pdf|max:2048',
            'file_ktm' => 'nullable|file|mimes:pdf|max:2048',
            'file_krs' => 'nullable|file|mimes:pdf|max:2048',
            'file_tidak_menerima_beasiswa' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $validated['nama_lengkap'] = strip_tags($validated['nama_lengkap']);
        $validated['nim'] = strip_tags($validated['nim']);
        $validated['no_hp'] = strip_tags($validated['no_hp']);
        $validated['jurusan'] = strip_tags($validated['jurusan']);

        $fileFields = [
            'file_sktm',
            'file_transkrip',
            'file_aktif_kuliah',
            'file_ktp',
            'file_ktm',
            'file_krs',
            'file_tidak_menerima_beasiswa',
        ];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($pendaftaran->$field) {
                    \Illuminate\Support\Facades\Storage::disk('local')->delete($pendaftaran->$field);
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($pendaftaran->$field);
                }
                $validated[$field] = $request->file($field)->store('uploads/dokumen', 'local');
            }
        }

        $pendaftaran->update($validated);
        \Illuminate\Support\Facades\Log::info('Admin memperbarui data pendaftaran', [
            'admin_id' => auth()->id(),
            'pendaftaran_id' => $pendaftaran->id,
            'status_verifikasi' => $pendaftaran->status_verifikasi,
            'ip' => $request->ip(),
        ]);
        return back()->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak bisa menghapus akun Super Admin.');
        }
        $user->delete();
        \Illuminate\Support\Facades\Log::info('Admin menghapus pengguna', [
            'admin_id' => auth()->id(),
            'deleted_user_id' => $id,
            'ip' => request()->ip(),
        ]);
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function destroyBeasiswa($id)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        if ($beasiswa->foto) \Illuminate\Support\Facades\Storage::disk('public')->delete($beasiswa->foto);
        $beasiswa->delete();
        \Illuminate\Support\Facades\Log::info('Admin menghapus beasiswa', [
            'admin_id' => auth()->id(),
            'deleted_beasiswa_id' => $id,
            'ip' => request()->ip(),
        ]);
        return back()->with('success', 'Beasiswa berhasil dihapus.');
    }

    public function destroyPengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        if ($pengumuman->gambar) \Illuminate\Support\Facades\Storage::disk('public')->delete($pengumuman->gambar);
        $pengumuman->delete();
        \Illuminate\Support\Facades\Log::info('Admin menghapus pengumuman', [
            'admin_id' => auth()->id(),
            'deleted_pengumuman_id' => $id,
            'ip' => request()->ip(),
        ]);
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function destroyPendaftaran($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $fileFields = [
            'file_sktm',
            'file_transkrip',
            'file_aktif_kuliah',
            'file_ktp',
            'file_ktm',
            'file_krs',
            'file_tidak_menerima_beasiswa',
        ];
        foreach ($fileFields as $field) {
            if ($pendaftaran->$field) {
                \Illuminate\Support\Facades\Storage::disk('local')->delete($pendaftaran->$field);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pendaftaran->$field);
            }
        }
        $pendaftaran->delete();
        \Illuminate\Support\Facades\Log::info('Admin menghapus pendaftaran', [
            'admin_id' => auth()->id(),
            'deleted_pendaftaran_id' => $id,
            'ip' => request()->ip(),
        ]);
        return back()->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
