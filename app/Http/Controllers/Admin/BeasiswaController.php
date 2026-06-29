<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeasiswaController extends Controller {
    public function index() {
        $beasiswas = Beasiswa::latest()->get();
        return view('admin.beasiswa.index', compact('beasiswas'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'nama_beasiswa' => 'required|string',
            'penyedia' => 'required|string',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image'
        ]);
        if($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        Beasiswa::create($validated);
        return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil ditambahkan.');
    }
    public function update(Request $request, Beasiswa $beasiswa) {
        $validated = $request->validate([
            'nama_beasiswa' => 'required|string',
            'penyedia' => 'required|string',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image'
        ]);
        if($request->hasFile('foto')) {
            if($beasiswa->foto) Storage::disk('public')->delete($beasiswa->foto);
            $validated['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        $beasiswa->update($validated);
        return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil diperbarui.');
    }
    public function destroy(Beasiswa $beasiswa) {
        if($beasiswa->foto) Storage::disk('public')->delete($beasiswa->foto);
        $beasiswa->delete();
        return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil dihapus.');
    }
}
