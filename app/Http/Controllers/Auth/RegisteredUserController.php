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
            'nim_username' => ['required', 'string', 'max:30', 'regex:/^[A-Za-z0-9]+$/', 'unique:'.User::class, 'exists:master_mahasiswas,nim'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nim_username.exists' => 'NIM Anda belum terdaftar di Sistem Akademik Master (Tidak Valid).',
            'nim_username.regex' => 'Format NIM hanya boleh berisi huruf dan angka.',
        ]);

        $master = \App\Models\MasterMahasiswa::where('nim', $request->nim_username)->firstOrFail();

        $user = User::create([
            'nama_lengkap' => strip_tags($master->nama_lengkap),
            'nim_username' => $master->nim,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        \Illuminate\Support\Facades\Log::info('Registrasi akun mahasiswa baru', [
            'user_id' => $user->id,
            'nim_username' => $user->nim_username,
            'ip' => $request->ip(),
        ]);

        event(new Registered($user));

        return redirect(route('login', absolute: false))->with('status', 'Pendaftaran Berhasil! Silakan Login.');
    }
}
