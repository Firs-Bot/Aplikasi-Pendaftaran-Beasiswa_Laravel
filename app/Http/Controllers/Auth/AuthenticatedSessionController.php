<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the mahasiswa login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming mahasiswa authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        
        if (Auth::user()->role !== 'mahasiswa') {
            \Illuminate\Support\Facades\Log::warning('Percobaan login mahasiswa dengan akun non-mahasiswa', [
                'nim_username' => $request->nim_username,
                'role' => Auth::user()->role,
                'ip' => $request->ip(),
            ]);
            Auth::guard('web')->logout();
            return back()->withErrors(['nim_username' => 'Akun ini bukan mahasiswa. Silakan gunakan halaman login Admin.']);
        }

        $request->session()->regenerate();

        \Illuminate\Support\Facades\Log::info('Login mahasiswa berhasil', [
            'user_id' => Auth::id(),
            'nim_username' => Auth::user()->nim_username,
            'ip' => $request->ip(),
        ]);

        return redirect()->intended(route('mhs.dashboard', absolute: false));
    }

    /**
     * Display the admin login view.
     */
    public function createAdmin(): View
    {
        return view('auth.admin-login');
    }

    /**
     * Handle an incoming staff (admin/baak) authentication request.
     */
    public function storeAdmin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        
        if (!in_array(Auth::user()->role, ['admin', 'baak'])) {
            \Illuminate\Support\Facades\Log::warning('Percobaan login admin dengan akun mahasiswa', [
                'nim_username' => $request->nim_username,
                'role' => Auth::user()->role,
                'ip' => $request->ip(),
            ]);
            Auth::guard('web')->logout();
            return back()->withErrors(['nim_username' => 'Akun ini bukan administrator atau staf BAAK.']);
        }

        $request->session()->regenerate();

        \Illuminate\Support\Facades\Log::info('Login staf/admin berhasil', [
            'user_id' => Auth::id(),
            'nim_username' => Auth::user()->nim_username,
            'role' => Auth::user()->role,
            'ip' => $request->ip(),
        ]);

        if (Auth::user()->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        
        return redirect()->intended(route('baak.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        \Illuminate\Support\Facades\Log::info('Logout pengguna', [
            'user_id' => Auth::id(),
            'nim_username' => Auth::user()?->nim_username,
            'ip' => $request->ip(),
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
