<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Teacher; // Ensure Teacher Model is imported
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(): View
    {
        // Statistik Kuis
        $totalQuizzes = Quiz::count();
        $totalQuizAttempts = QuizAttempt::count();
        $averageQuizScore = QuizAttempt::avg('score') ?? 0;
        $quizPassingRate = ($totalQuizAttempts > 0) ? (QuizAttempt::where('status', 'passed')->count() / $totalQuizAttempts) * 100 : 0;

        $mostAttemptedQuiz = QuizAttempt::select('quiz_id', DB::raw('COUNT(*) as total_attempts'))
            ->groupBy('quiz_id')
            ->orderByDesc('total_attempts')
            ->first();

        $leastAttemptedQuiz = QuizAttempt::select('quiz_id', DB::raw('COUNT(*) as total_attempts'))
            ->groupBy('quiz_id')
            ->orderBy('total_attempts')
            ->first();

        // Metrik User Access & Attempts (Baru Ditambahkan)
        $uniqueUsersAttemptingQuizzes = QuizAttempt::distinct('user_id')->count(); // Jumlah user unik yang mencoba kuis
        $totalUsersAccessingQuizzes = User::whereHas('quizAttempts')->count(); // Jumlah user yang pernah mencoba kuis (proxy untuk access)


        // Data lain (tetap ada, atau bisa disesuaikan)
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $pendingTeachers = User::where('employment_status', 'teacher')->where('is_active', false)->count();
        $activeTeachers = User::where('employment_status', 'teacher')->where('is_active', true)->count(); // Calculate active teachers
        $teachersCreatingCourses = Teacher::has('courses')->count(); // Calculate teachers creating courses


        // Kirim data ke view
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalCourses' => $totalCourses,
            'pendingTeachers' => $pendingTeachers,
            'activeTeachers' => $activeTeachers, // Pass activeTeachers to the view
            'teachersCreatingCourses' => $teachersCreatingCourses, // Pass teachersCreatingCourses to the view


            'totalQuizzes' => $totalQuizzes,
            'totalQuizAttempts' => $totalQuizAttempts,
            'averageQuizScore' => $averageQuizScore,
            'quizPassingRate' => $quizPassingRate,
            'mostAttemptedQuiz' => $mostAttemptedQuiz,
            'leastAttemptedQuiz' => $leastAttemptedQuiz,
            'uniqueUsersAttemptingQuizzes' => $uniqueUsersAttemptingQuizzes, // Data baru
            'totalUsersAccessingQuizzes' => $totalUsersAccessingQuizzes, // Data baru
        ]);
    }
}
