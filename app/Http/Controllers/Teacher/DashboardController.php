<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User; // Import Model User
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Show the teacher dashboard.
     */
    public function index(): View
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            Log::error('Teacher record not found for user: ' . Auth::id());
            return view('admin.teachers.dashboard', [
                'error' => 'Profil Guru tidak ditemukan. Silakan hubungi administrator.',
                'totalCourses' => 0,
                'activeCourses' => 0,
                'completedCourses' => 0,
                'recentCourses' => collect(),
                'studentsCount' => 0
            ]);
        }

        try {
            $totalCourses = Course::where('teacher_id', $teacher)->count();
            $activeCourses = Course::where('teacher_id', $teacher)->where('is_active', true)->count(); // Misalnya, ada kolom is_active di tabel courses
            $completedCourses = 0; // Logika untuk menentukan kursus yang sudah "selesai" (misalnya, berdasarkan tanggal selesai atau status)
            $recentCourses = Course::where('teacher_id', $teacher)->latest()->take(5)->get();

            // Ambil jumlah total student yang mengikuti kursus teacher ini
            $studentsCount = 0;
             $courses = Course::where('teacher_id', $teacher)->get(); // Ambil semua course
            foreach ($courses as $course) {
                $studentsCount += $course->employees()->count();  // Menghitung employees di setiap course.
            }

        } catch (\Exception $e) {
            Log::error('Failed to retrieve course data for teacher: ' . $teacher . ' - ' . $e->getMessage());
            return view('admin.teachers.dashboard', [
                'error' => 'Terjadi kesalahan saat mengambil data kursus. Silakan coba lagi nanti.',
                'totalCourses' => 0,
                 'activeCourses' => 0,
                'completedCourses' => 0,
                'recentCourses' => collect(),
                 'studentsCount' => 0
            ]);
        }

        return view('admin.teachers.dashboard', [
            'totalCourses' => $totalCourses,
            'activeCourses' => $activeCourses,
            'completedCourses' => $completedCourses,
            'recentCourses' => $recentCourses,
            'studentsCount' => $studentsCount,
        ]);
    }

}
