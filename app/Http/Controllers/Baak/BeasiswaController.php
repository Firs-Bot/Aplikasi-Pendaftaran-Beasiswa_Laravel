<?php
namespace App\Http\Controllers\Baak;
use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BeasiswaController extends Controller {
    public function index() {
        $beasiswas = Beasiswa::latest()->get();
        return view('baak.beasiswa.index', compact('beasiswas'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'nama_beasiswa' => 'required|string|max:255',
            'penyedia' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:5000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
        $validated['nama_beasiswa'] = strip_tags($validated['nama_beasiswa']);
        $validated['penyedia'] = strip_tags($validated['penyedia']);
        $validated['deskripsi'] = strip_tags($validated['deskripsi']);

        if($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        $beasiswa = Beasiswa::create($validated);
        Log::info('BAAK menambahkan beasiswa baru', [
            'user_id' => auth()->id(),
            'beasiswa_id' => $beasiswa->id,
            'ip' => $request->ip(),
        ]);
        return redirect()->route('baak.beasiswa.index')->with('success', 'Beasiswa berhasil ditambahkan.');
    }
    public function update(Request $request, Beasiswa $beasiswa) {
        $validated = $request->validate([
            'nama_beasiswa' => 'required|string|max:255',
            'penyedia' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:5000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
        $validated['nama_beasiswa'] = strip_tags($validated['nama_beasiswa']);
        $validated['penyedia'] = strip_tags($validated['penyedia']);
        $validated['deskripsi'] = strip_tags($validated['deskripsi']);

        if($request->hasFile('foto')) {
            if($beasiswa->foto) Storage::disk('public')->delete($beasiswa->foto);
            $validated['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        $beasiswa->update($validated);
        Log::info('BAAK memperbarui beasiswa', [
            'user_id' => auth()->id(),
            'beasiswa_id' => $beasiswa->id,
            'ip' => $request->ip(),
        ]);
        return redirect()->route('baak.beasiswa.index')->with('success', 'Beasiswa berhasil diperbarui.');
    }
    public function destroy(Beasiswa $beasiswa) {
        if($beasiswa->foto) Storage::disk('public')->delete($beasiswa->foto);
        $beasiswa->delete();
        Log::info('BAAK menghapus beasiswa', [
            'user_id' => auth()->id(),
            'beasiswa_id' => $beasiswa->id,
            'ip' => request()->ip(),
        ]);
        return redirect()->route('baak.beasiswa.index')->with('success', 'Beasiswa berhasil dihapus.');
    }
}
