<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    /**
     * Redirect user to the appropriate dashboard based on their role.
     */
    public function index(): RedirectResponse
    {
        // Periksa apakah user sudah login
        if (Auth::check()) {
            $user = Auth::user();

            // Cek apakah alert sudah ditampilkan sebelumnya
            if (!session()->has('welcome_alert_shown')) {
                if ($user->hasRole('admin')) {
                    Alert::success('Selamat Datang!', 'Anda masuk sebagai Admin.');
                    session()->put('welcome_alert_shown', true);
                    return redirect()->route('admin.dashboard');
                } elseif ($user->hasRole('teacher')) {
                    Alert::success('Selamat Datang!', 'Anda masuk sebagai Guru.');
                    session()->put('welcome_alert_shown', true);
                    return redirect()->route('admin.teacher.dashboard');
                } elseif ($user->hasRole('employee')) {
                    Alert::success('Selamat Datang!', 'Anda masuk sebagai Karyawan.');
                    session()->put('welcome_alert_shown', true);
                    return redirect()->route('employees-dashboard.dashboard');
                }
            } else {
                // Jika alert sudah ditampilkan, langsung redirect tanpa alert
                if ($user->hasRole('admin')) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->hasRole('teacher')) {
                    return redirect()->route('admin.teacher.dashboard');
                } elseif ($user->hasRole('employee')) {
                    return redirect()->route('employees-dashboard.dashboard');
                }
            }
        }

        // Jika tidak ada role yang cocok atau user belum login, arahkan ke dashboard default
        if (!session()->has('welcome_alert_shown')) {
            Alert::info('Selamat Datang!', 'Anda masuk sebagai Pengguna Umum.');
            session()->put('welcome_alert_shown', true);
        }
        return redirect()->route('frontend.index'); // Atau route default lainnya
    }
}
