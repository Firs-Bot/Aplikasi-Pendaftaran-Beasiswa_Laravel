<?php
namespace App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function index() {
        $beasiswas = Beasiswa::latest()->get();
        $pendaftarans = Pendaftaran::with('beasiswa')->where('user_id', auth()->id())->latest()->get();
        return view('mahasiswa.dashboard', compact('beasiswas', 'pendaftarans'));
    }
}
