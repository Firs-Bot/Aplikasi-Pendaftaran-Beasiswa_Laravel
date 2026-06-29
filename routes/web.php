<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BeasiswaController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PendaftaranController as AdminPendaftaran;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;
use App\Http\Controllers\Mahasiswa\PendaftaranController as MahasiswaPendaftaran;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Redirect based on role
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('mhs.dashboard');
    })->name('dashboard');

    // Admin Routes
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('beasiswa', BeasiswaController::class);
        Route::resource('pengumuman', PengumumanController::class);
        Route::get('/pendaftaran/pdf', [AdminPendaftaran::class, 'exportPdf'])->name('pendaftaran.pdf');
        Route::resource('pendaftaran', AdminPendaftaran::class)->only(['index', 'update']);
    });

    // Mahasiswa Routes
    Route::middleware('can:mahasiswa')->prefix('mahasiswa')->name('mhs.')->group(function () {
        Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])->name('dashboard');
        Route::resource('pendaftaran', MahasiswaPendaftaran::class)->only(['index', 'store', 'update']);
    });
});

Route::get('/api/check-nim/{nim}', function ($nim) {
    $mahasiswa = \App\Models\MasterMahasiswa::where('nim', $nim)->first();
    if ($mahasiswa) {
        return response()->json(['success' => true, 'data' => $mahasiswa]);
    }
    return response()->json(['success' => false, 'message' => 'NIM tidak terdaftar di data master kampus'], 404);
})->name('api.check-nim');

require __DIR__.'/auth.php';
