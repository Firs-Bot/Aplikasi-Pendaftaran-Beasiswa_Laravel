<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nim_username' => ['required', 'string', 'max:255', 'unique:'.User::class, 'exists:master_mahasiswas,nim'],
            'password' => ['required', 'confirmed'],
        ], [
            'nim_username.exists' => 'NIM Anda belum terdaftar di Sistem Akademik Master (Tidak Valid).'
        ]);

        $master = \App\Models\MasterMahasiswa::where('nim', $request->nim_username)->first();

        $user = User::create([
            'nama_lengkap' => $master->nama_lengkap,
            'nim_username' => $request->nim_username,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        event(new Registered($user));

        return redirect(route('login', absolute: false))->with('status', 'Pendaftaran Berhasil! Silakan Login.');
    }
}
