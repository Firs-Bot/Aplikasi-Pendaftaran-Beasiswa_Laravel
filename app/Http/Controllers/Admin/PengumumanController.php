<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller {
    public function index() {
        $pengumumen = Pengumuman::latest()->get();
        return view('admin.pengumuman.index', compact('pengumumen'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'judul' => 'required|string',
            'isi' => 'required|string',
            'gambar' => 'nullable|image'
        ]);
        $validated['tanggal'] = date('Y-m-d');
        if($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('uploads', 'public');
        }
        Pengumuman::create($validated);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman ditambahkan.');
    }
    public function update(Request $request, Pengumuman $pengumuman) {
        $validated = $request->validate([
            'judul' => 'required|string',
            'isi' => 'required|string',
            'gambar' => 'nullable|image'
        ]);
        if($request->hasFile('gambar')) {
            if($pengumuman->gambar) Storage::disk('public')->delete($pengumuman->gambar);
            $validated['gambar'] = $request->file('gambar')->store('uploads', 'public');
        }
        $pengumuman->update($validated);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman diperbarui.');
    }
    public function destroy(Pengumuman $pengumuman) {
        if($pengumuman->gambar) Storage::disk('public')->delete($pengumuman->gambar);
        $pengumuman->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman dihapus.');
    }
}
