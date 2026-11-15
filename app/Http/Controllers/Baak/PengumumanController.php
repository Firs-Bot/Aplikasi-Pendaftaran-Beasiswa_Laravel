<?php
namespace App\Http\Controllers\Baak;
use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller {
    public function index() {
        $pengumumen = Pengumuman::latest()->get();
        return view('baak.pengumuman.index', compact('pengumumen'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:10000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
        $validated['judul'] = strip_tags($validated['judul']);
        $validated['isi'] = strip_tags($validated['isi']);
        $validated['tanggal'] = date('Y-m-d');
        if($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('uploads', 'public');
        }
        $pengumuman = Pengumuman::create($validated);
        Log::info('BAAK menambahkan pengumuman baru', [
            'user_id' => auth()->id(),
            'pengumuman_id' => $pengumuman->id,
            'ip' => $request->ip(),
        ]);
        return redirect()->route('baak.pengumuman.index')->with('success', 'Pengumuman ditambahkan.');
    }
    public function update(Request $request, Pengumuman $pengumuman) {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:10000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
        $validated['judul'] = strip_tags($validated['judul']);
        $validated['isi'] = strip_tags($validated['isi']);
        if($request->hasFile('gambar')) {
            if($pengumuman->gambar) Storage::disk('public')->delete($pengumuman->gambar);
            $validated['gambar'] = $request->file('gambar')->store('uploads', 'public');
        }
        $pengumuman->update($validated);
        Log::info('BAAK memperbarui pengumuman', [
            'user_id' => auth()->id(),
            'pengumuman_id' => $pengumuman->id,
            'ip' => $request->ip(),
        ]);
        return redirect()->route('baak.pengumuman.index')->with('success', 'Pengumuman diperbarui.');
    }
    public function destroy(Pengumuman $pengumuman) {
        if($pengumuman->gambar) Storage::disk('public')->delete($pengumuman->gambar);
        $pengumuman->delete();
        Log::info('BAAK menghapus pengumuman', [
            'user_id' => auth()->id(),
            'pengumuman_id' => $pengumuman->id,
            'ip' => request()->ip(),
        ]);
        return redirect()->route('baak.pengumuman.index')->with('success', 'Pengumuman dihapus.');
    }
}
