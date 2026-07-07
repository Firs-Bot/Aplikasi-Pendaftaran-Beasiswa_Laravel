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

    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function beasiswas()
    {
        $beasiswas = Beasiswa::latest()->get();
        return view('admin.beasiswa', compact('beasiswas'));
    }

    public function pengumumans()
    {
        $pengumumans = Pengumuman::latest()->get();
        return view('admin.pengumuman', compact('pengumumans'));
    }

    public function pendaftarans()
    {
        $pendaftarans = Pendaftaran::with(['user', 'beasiswa'])->latest()->get();
        return view('admin.pendaftaran', compact('pendaftarans'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'nama_lengkap' => 'required|string',
            'nim_username' => 'required|string|unique:users,nim_username,' . $id,
            'role' => 'required|in:mahasiswa,baak,admin',
            'password' => 'nullable|string|min:8'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return back()->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function updateBeasiswa(Request $request, $id)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        $validated = $request->validate([
            'nama_beasiswa' => 'required|string',
            'penyedia' => 'required|string',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image'
        ]);

        if ($request->hasFile('foto')) {
            if ($beasiswa->foto) \Illuminate\Support\Facades\Storage::disk('public')->delete($beasiswa->foto);
            $validated['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        $beasiswa->update($validated);
        return back()->with('success', 'Beasiswa berhasil diperbarui.');
    }

    public function updatePengumuman(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string',
            'isi' => 'required|string',
            'gambar' => 'nullable|image'
        ]);

        if ($request->hasFile('gambar')) {
            if ($pengumuman->gambar) \Illuminate\Support\Facades\Storage::disk('public')->delete($pengumuman->gambar);
            $validated['gambar'] = $request->file('gambar')->store('uploads', 'public');
        }

        $pengumuman->update($validated);
        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function updatePendaftaran(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $validated = $request->validate([
            'nama_lengkap' => 'required|string',
            'nim' => 'required|string',
            'email' => 'required|email',
            'no_hp' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'jurusan' => 'required|string',
            'ipk' => 'required|numeric',
            'penghasilan_ortu' => 'required|string',
            'status_verifikasi' => 'required|string',
            'catatan_verifikasi' => 'nullable|string',
            'file_lampiran' => 'nullable|file|mimes:pdf|max:2048',
            'surat_aktif' => 'nullable|file|mimes:pdf|max:2048',
            'ktp' => 'nullable|file|mimes:pdf|max:2048',
            'ktm' => 'nullable|file|mimes:pdf|max:2048',
            'krs' => 'nullable|file|mimes:pdf|max:2048',
            'surat_sktm' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $fileFields = ['file_lampiran', 'surat_aktif', 'ktp', 'ktm', 'krs', 'surat_sktm'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($pendaftaran->$field) \Illuminate\Support\Facades\Storage::disk('public')->delete($pendaftaran->$field);
                $validated[$field] = $request->file($field)->store('uploads/dokumen', 'public');
            }
        }

        $pendaftaran->update($validated);
        return back()->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak bisa menghapus akun Super Admin.');
        }
        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function destroyBeasiswa($id)
    {
        Beasiswa::findOrFail($id)->delete();
        return back()->with('success', 'Beasiswa berhasil dihapus.');
    }

    public function destroyPengumuman($id)
    {
        Pengumuman::findOrFail($id)->delete();
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function destroyPendaftaran($id)
    {
        Pendaftaran::findOrFail($id)->delete();
        return back()->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
