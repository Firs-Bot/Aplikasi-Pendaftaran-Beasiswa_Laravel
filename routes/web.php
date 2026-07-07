<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
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
        } elseif (auth()->user()->role === 'baak') {
            return redirect()->route('baak.dashboard');
        }
        return redirect()->route('mhs.dashboard');
    })->name('dashboard');

    // Admin Routes (Super Admin)
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/users', [\App\Http\Controllers\Admin\DashboardController::class, 'users'])->name('users.index');
        Route::put('/users/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'destroyUser'])->name('users.destroy');
        
        Route::get('/beasiswa', [\App\Http\Controllers\Admin\DashboardController::class, 'beasiswas'])->name('beasiswa.index');
        Route::put('/beasiswa/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'updateBeasiswa'])->name('beasiswa.update');
        Route::delete('/beasiswa/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'destroyBeasiswa'])->name('beasiswa.destroy');
        
        Route::get('/pengumuman', [\App\Http\Controllers\Admin\DashboardController::class, 'pengumumans'])->name('pengumuman.index');
        Route::put('/pengumuman/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'updatePengumuman'])->name('pengumuman.update');
        Route::delete('/pengumuman/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'destroyPengumuman'])->name('pengumuman.destroy');
        
        Route::get('/pendaftaran', [\App\Http\Controllers\Admin\DashboardController::class, 'pendaftarans'])->name('pendaftaran.index');
        Route::put('/pendaftaran/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'updatePendaftaran'])->name('pendaftaran.update');
        Route::delete('/pendaftaran/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'destroyPendaftaran'])->name('pendaftaran.destroy');
    });

    // BAAK Routes
    Route::middleware('can:baak')->prefix('baak')->name('baak.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Baak\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('beasiswa', \App\Http\Controllers\Baak\BeasiswaController::class);
        Route::resource('pengumuman', \App\Http\Controllers\Baak\PengumumanController::class);
        Route::get('/pendaftaran/pdf', [\App\Http\Controllers\Baak\PendaftaranController::class, 'exportPdf'])->name('pendaftaran.pdf');
        Route::resource('pendaftaran', \App\Http\Controllers\Baak\PendaftaranController::class)->only(['index', 'update']);
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
