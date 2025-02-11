<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    /**
     * Show the admin dashboard.
     */
    public function index(): View
    {
        // Ambil data yang dibutuhkan untuk dashboard admin
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $pendingTeachers = User::where('employment_status', 'teacher')->where('is_active', false)->count(); // Contoh: Jumlah teacher yang belum disetujui

        // Kirim data ke view
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalCourses' => $totalCourses,
            'pendingTeachers' => $pendingTeachers,
        ]);
    }
}
