<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            $user = Auth::user();

              // Notifikasi sukses
        session()->flash('success', 'Login berhasil! Selamat datang di dashboard, ' . $user->name);

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'teacher') {
                return redirect()->intended(route('admin.teachers.dashboard'));
            } elseif ($user->role === 'employee') {
                return redirect()->intended(route('employee.dashboard'));
            }

            return redirect('/');
        }

        // Jika gagal
        return back()->withErrors([
            'email' => 'Kredensial tidak valid.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userName = Auth::user()->name;

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Flash message logout berhasil
        session()->flash('success', 'Logout berhasil! Sampai jumpa lagi, ' . $userName);

        return redirect('/');
    }
}
