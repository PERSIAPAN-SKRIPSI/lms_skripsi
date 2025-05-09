<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request; // Tambahkan ini
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(Request $request): View
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Statistik Kuis (dengan filter tanggal)
        $totalQuizzes = Quiz::count();
        $totalQuizAttempts = QuizAttempt::when($startDate, function ($query, $startDate) use ($endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate ?? now()]);
            })->count();

        $averageQuizScore = QuizAttempt::when($startDate, function ($query, $startDate) use ($endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate ?? now()]);
            })->avg('score') ?? 0;

        $quizPassingRate = 0;
        $filteredQuizAttemptsCount = QuizAttempt::when($startDate, function ($query, $startDate) use ($endDate) {
            return $query->whereBetween('created_at', [$startDate, $endDate ?? now()]);
        })->count();

        if ($filteredQuizAttemptsCount > 0) {
            $passedQuizAttemptsCount = QuizAttempt::where('status', 'passed')
                ->when($startDate, function ($query, $startDate) use ($endDate) {
                    return $query->whereBetween('created_at', [$startDate, $endDate ?? now()]);
                })->count();
            $quizPassingRate = ($passedQuizAttemptsCount / $filteredQuizAttemptsCount) * 100;
        }


        // Data lain (tetap ada, atau bisa disesuaikan)
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $pendingTeachers = User::where('employment_status', 'teacher')->where('is_active', false)->count();
        $activeTeachers = User::where('employment_status', 'teacher')->where('is_active', true)->count();
        $teachersCreatingCourses = Teacher::has('courses')->count();

        // Kirim data ke view
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalCourses' => $totalCourses,
            'pendingTeachers' => $pendingTeachers,
            'activeTeachers' => $activeTeachers,
            'teachersCreatingCourses' => $teachersCreatingCourses,

            'totalQuizzes' => $totalQuizzes,
            'totalQuizAttempts' => $totalQuizAttempts,
            'averageQuizScore' => $averageQuizScore,
            'quizPassingRate' => $quizPassingRate,

            'startDate' => $startDate, // Kirim tanggal ke view
            'endDate' => $endDate,     // Kirim tanggal ke view
        ]);
    }
}
