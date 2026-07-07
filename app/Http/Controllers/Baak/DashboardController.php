<?php
namespace App\Http\Controllers\Baak;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Beasiswa;
use App\Models\Pendaftaran;
class DashboardController extends Controller {
    public function index() {
        $stats = [
            'total_beasiswa' => Beasiswa::count(),
            'total_pendaftaran' => Pendaftaran::count(),
            'menunggu' => Pendaftaran::where('status_verifikasi', 'MENUNGGU')->count(),
            'lolos' => Pendaftaran::where('status_verifikasi', 'LOLOS')->count(),
        ];
        return view('baak.dashboard', compact('stats'));
    }
}
