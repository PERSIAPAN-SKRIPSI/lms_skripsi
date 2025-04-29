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

            if ($user->hasRole('admin')) {
                Alert::success('Selamat Datang!', 'Anda masuk sebagai Admin.');
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('teacher')) {
                Alert::success('Selamat Datang!', 'Anda masuk sebagai Guru.');
                return redirect()->route('admin.teacher.dashboard');
            } elseif ($user->hasRole('employee')) {
                Alert::success('Selamat Datang!', 'Anda masuk sebagai Karyawan.');
                return redirect()->route('employees-dashboard.dashboard');
            }
        }

        // Jika tidak ada role yang cocok atau user belum login, arahkan ke dashboard default
        Alert::info('Selamat Datang!', 'Anda masuk sebagai Pengguna Umum.');
        return redirect()->route('frontend.index'); // Atau route default lainnya
    }
}
