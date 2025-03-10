<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\CourseEmployee;
use App\Models\Course;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $employeeId = Auth::id();

        $enrolledCourses = CourseEmployee::with('course')
            ->where('user_id', $employeeId)
            ->get();

        $enrolledCoursesCount = $enrolledCourses->count();
        $activeCoursesCount = $enrolledCourses->where('is_approved', true)->count();
        $pendingCoursesCount = $enrolledCourses->where('is_approved', false)->count();
        $totalCoursesCreated = Course::count();

        // Logika Quiz Score
        $quizAttempts = QuizAttempt::where('user_id', $employeeId)->get();
        $totalQuizzesAttempted = $quizAttempts->count();
        // Contoh: Rata-rata skor (jika ada quiz yang sudah dijawab)
        $averageQuizScore = $quizAttempts->avg('score') ?? 0; // ?? 0 untuk handle jika tidak ada quiz attempt

        return view('employees-dashboard.dashboard', compact(
            'enrolledCoursesCount',
            'activeCoursesCount',
            'pendingCoursesCount',
            'totalCoursesCreated',
            'totalQuizzesAttempted', // Kirim total quiz dijawab
            'averageQuizScore'      // Kirim rata-rata skor quiz
        ));
    }

    public function learningProgressIndex(): View
    {
        $employeeId = Auth::id();

        $enrolledCourses = CourseEmployee::with('course')
            ->where('user_id', $employeeId)
            ->where('is_approved', true)
            ->get();

        return view('employees-dashboard.learning-progress', compact('enrolledCourses'));
    }
}
