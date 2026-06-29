<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pengumuman;
class HomeController extends Controller {
    public function index() {
        $pengumuman = Pengumuman::orderBy('tanggal', 'desc')->take(6)->get();
        return view('home', compact('pengumuman'));
    }
}
