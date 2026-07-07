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
