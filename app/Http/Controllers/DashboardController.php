<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

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
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('teacher')) {
                return redirect()->route('admin.teacher.dashboard');
            } elseif ($user->hasRole('employee')) {
                return redirect()->route('employees-dashboard.dashboard');
            }
        }

        // Jika tidak ada role yang cocok atau user belum login, arahkan ke dashboard default
        return redirect()->route('frontend.index'); // Atau route default lainnya
    }
}
