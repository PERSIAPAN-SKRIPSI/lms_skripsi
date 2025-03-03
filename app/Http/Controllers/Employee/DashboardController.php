<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\CourseEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $employeeId = Auth::id(); // Mendapatkan ID karyawan yang sedang login

        // Mendapatkan kursus yang diikuti karyawan melalui model CourseEmployee
        $enrolledCourses = CourseEmployee::with('course') // Eager load relasi 'course'
            ->where('user_id', $employeeId)
            ->where('is_approved', true) // Hanya menampilkan kursus yang disetujui (opsional)
            ->get();

        return view('employees-dashboard.index', compact('enrolledCourses'));
    }
    public function learningProgressIndex(): View // Method untuk "Learning Progress"
    {
        $employeeId = Auth::id();

        $enrolledCourses = CourseEmployee::with('course')
            ->where('user_id', $employeeId)
            ->where('is_approved', true)
            ->get();

        return view('employees-dashboard.learning-progress.index', compact('enrolledCourses')); // View untuk halaman Learning Progress
    }
}
