<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tambahkan parameter remember
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Dapatkan user yang login
            $user = Auth::user();

            // Notifikasi sukses
            Alert::success('Berhasil!', 'Login berhasil! Selamat datang, ' . $user->name);

            // Redirect ke dashboard
            return redirect()->route('dashboard');
        }

        // Jika gagal
        Alert::error('Gagal!', 'Kredensial tidak valid. Periksa email dan password Anda.');
        return back()->withInput()->withErrors([
            'email' => 'Kredensial tidak valid.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */ public function destroy(Request $request): RedirectResponse
    {
        $userName = Auth::user()->name;

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Flash message logout berhasil
        Alert::success('Berhasil!', 'Logout berhasil! Sampai jumpa lagi, ' . $userName);

        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
