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
            Auth::guard('web')->logout();
            return back()->withErrors(['nim_username' => 'Akun ini bukan mahasiswa. Silakan gunakan halaman login Admin.']);
        }

        $request->session()->regenerate();

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
     * Handle an incoming admin authentication request.
     */
    public function storeAdmin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        
        if (Auth::user()->role !== 'admin') {
            Auth::guard('web')->logout();
            return back()->withErrors(['nim_username' => 'Akun ini bukan administrator.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
