<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizMonitoringController extends Controller
{
    public function performance() // Method Performance yang lebih sederhana
    {
        $totalQuizzes = Quiz::count();
        $totalAttempts = QuizAttempt::count();
        $averageScore = QuizAttempt::avg('score') ?? 0;
        $passingRate = ($totalAttempts > 0) ? (QuizAttempt::where('status', 'passed')->count() / $totalAttempts) * 100 : 0;

        return view('admin.quizzes.monitoring.performance', compact(
            'totalQuizzes',
            'totalAttempts',
            'averageScore',
            'passingRate'
        ));
    }

    public function completion() // Method Completion yang lebih sederhana
    {
        $completedQuizzesCount = User::whereHas('quizAttempts', function ($query) {
            $query->whereNotNull('completed_at');
        })->count();

        $mostAttemptedQuiz = QuizAttempt::select('quiz_id', DB::raw('COUNT(*) as total_attempts'))
            ->groupBy('quiz_id')
            ->orderByDesc('total_attempts')
            ->first();

        $leastAttemptedQuiz = QuizAttempt::select('quiz_id', DB::raw('COUNT(*) as total_attempts'))
            ->groupBy('quiz_id')
            ->orderBy('total_attempts')
            ->first();


        return view('admin.quizzes.monitoring.completion', compact(
            'completedQuizzesCount',
            'mostAttemptedQuiz',
            'leastAttemptedQuiz'
        ));
    }
    public function userAttempts()
    {
        try {
            $userQuizAttempts = User::with(['quizAttempts' => function ($query) {
                    $query->with('quiz') // Eager load quiz relation
                        ->orderBy('created_at', 'desc'); // Order attempts by latest first
                }])
                ->get();

            return view('admin.quizzes.monitoring.user_attempts', compact('userQuizAttempts'));
        } catch (\Exception $e) {
            Log::error('Error in QuizMonitoringController@userAttempts: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading user quiz attempt data.');
        }
    }
}
