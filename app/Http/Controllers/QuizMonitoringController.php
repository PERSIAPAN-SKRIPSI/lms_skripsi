<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizMonitoringController extends Controller
{
    public function performance()
    {
        // Get basic stats for dashboard cards
        $totalQuizzes = Quiz::count();
        $totalAttempts = QuizAttempt::count();
        $averageScore = QuizAttempt::avg('score');
        $passingRate = $totalAttempts > 0 ? (QuizAttempt::where('status', 'passed')->count() / $totalAttempts) * 100 : 0;
        $quizzes = Quiz::all(); // Fetch quizzes for the filter dropdown

        // Get data for radar chart - Quiz performance by employees
        $quizPerformanceData = $this->getQuizPerformanceData();

        return view('admin.quizzes.monitoring.performance', compact(
            'totalQuizzes',
            'totalAttempts',
            'averageScore',
            'passingRate',
            'quizPerformanceData',
            'quizzes'
        ));
    }

    // Helper function to get quiz performance data (moved logic here)
    private function getQuizPerformanceData($dateRange = 'all', $quizFilter = 'all', $statusFilter = 'all')
    {
        $query = Quiz::select('quizzes.id', 'quizzes.title as quiz_name')
            ->withCount(['attempts' => function($query) use ($dateRange, $quizFilter, $statusFilter) {
                $query->whereHas('user', function($q) {
                    $q->whereHas('roles', function($r) {
                        $r->where('name', 'employee');
                    });
                });

                 // Apply date range filter
                 if ($dateRange !== 'all') {
                    $startDate = Carbon::now()->subDays((int)$dateRange);
                    $query->where('created_at', '>=', $startDate);
                }

                // Apply quiz filter
                if ($quizFilter !== 'all') {
                    $query->where('quiz_id', $quizFilter);
                }

                // Apply status filter
                if ($statusFilter !== 'all') {
                    $query->where('status', $statusFilter);
                }

            }])
            ->with(['attempts' => function($query) use ($dateRange, $quizFilter, $statusFilter) {
                $query->whereHas('user', function($q) {
                    $q->whereHas('roles', function($r) {
                        $r->where('name', 'employee');
                    });
                });
                // Apply date range filter
                if ($dateRange !== 'all') {
                    $startDate = Carbon::now()->subDays((int)$dateRange);
                    $query->where('created_at', '>=', $startDate);
                }

                // Apply quiz filter
                if ($quizFilter !== 'all') {
                    $query->where('quiz_id', $quizFilter);
                }

                // Apply status filter
                if ($statusFilter !== 'all') {
                    $query->where('status', $statusFilter);
                }
            }]);

        $quizzes = $query->get(); // Corrected variable name

        return $quizzes->map(function($quiz) {
            // Count unique employees who attempted this quiz
            $employeeCount = $quiz->attempts->pluck('user_id')->unique()->count();

            // Calculate average attempts per employee
            $attemptCount = $employeeCount > 0 ? $quiz->attempts_count / $employeeCount : 0;

            // Calculate average correct answers
            $correctAnswersAvg = 0;
            if ($quiz->attempts->count() > 0) {
                $totalCorrectAnswers = $quiz->attempts->sum(function($attempt) {
                    return $attempt->answers->where('is_correct', true)->count();
                });
                $correctAnswersAvg = $totalCorrectAnswers / $quiz->attempts->count();
            }

            // Calculate average time required (in minutes)
            $timeRequiredAvg = 0;
            $attemptsWithTime = $quiz->attempts->filter(function($attempt) {
                return $attempt->started_at && $attempt->completed_at;
            });

            if ($attemptsWithTime->count() > 0) {
                $totalMinutes = $attemptsWithTime->sum(function($attempt) {
                    $startTime = Carbon::parse($attempt->started_at);
                    $endTime = Carbon::parse($attempt->completed_at);
                    return $endTime->diffInMinutes($startTime);
                });
                $timeRequiredAvg = $totalMinutes / $attemptsWithTime->count();
            }

            return [
                'quiz_name' => $quiz->quiz_name,
                'employee_count' => $employeeCount,
                'attempt_count' => round($attemptCount, 1),
                'correct_answers_avg' => round($correctAnswersAvg, 1),
                'time_required_avg' => round($timeRequiredAvg, 1)
            ];
        });
    }

    public function performanceFilter(Request $request)
    {
        $dateRange = $request->input('dateRange', 'all');
        $quizFilter = $request->input('quizFilter', 'all');
        $statusFilter = $request->input('statusFilter', 'all');

        // Get filtered quiz performance data
        $quizPerformanceData = $this->getQuizPerformanceData($dateRange, $quizFilter, $statusFilter);

        // Recalculate stats based on filtered data
        $totalQuizzes = Quiz::count();  // Not changing with the filters
        $filteredAttemptsQuery = QuizAttempt::query();

        if ($dateRange !== 'all') {
            $startDate = Carbon::now()->subDays((int)$dateRange);
            $filteredAttemptsQuery->where('created_at', '>=', $startDate);
        }

        if ($quizFilter !== 'all') {
            $filteredAttemptsQuery->where('quiz_id', $quizFilter);
        }

        if ($statusFilter !== 'all') {
            $filteredAttemptsQuery->where('status', $statusFilter);
        }

        $totalAttempts = $filteredAttemptsQuery->count(); // Apply all filters

        $averageScore = $totalAttempts > 0 ? $filteredAttemptsQuery->avg('score') : 0;

        $passingRate = $totalAttempts > 0 ? ($filteredAttemptsQuery->where('status', 'passed')->count() / $totalAttempts) * 100 : 0;
         // Format the average score and passing rate

        return response()->json([
            'quizPerformanceData' => $quizPerformanceData,
            'totalQuizzes' => $totalQuizzes,
            'totalAttempts' => $totalAttempts,
            'averageScore' => number_format($averageScore, 1), // Correctly format
            'passingRate' => number_format($passingRate, 1),     // Correctly format
        ]);
    }

   public function completion()
    {
        $completedQuizzesCount = QuizAttempt::whereNotNull('completed_at')->count();

        $mostAttemptedQuiz = QuizAttempt::select('quiz_id', DB::raw('COUNT(*) as total_attempts'))
            ->groupBy('quiz_id')
            ->orderByDesc('total_attempts')
            ->with('quiz')
            ->first();

        $leastAttemptedQuiz = QuizAttempt::select('quiz_id', DB::raw('COUNT(*) as total_attempts'))
            ->groupBy('quiz_id')
            ->orderBy('total_attempts')
            ->with('quiz')
            ->first();

        // Data untuk chart quiz attempts
        $quizAttempts = Quiz::select('quizzes.id', 'quizzes.title as quiz_title')
            ->leftJoin('quiz_attempts', 'quizzes.id', '=', 'quiz_attempts.quiz_id')
            ->selectRaw('quizzes.title as quiz_title, quizzes.id as quiz_id, COUNT(quiz_attempts.id) as attempt_count')
            ->groupBy('quizzes.id', 'quizzes.title')
            ->with(['attempts' => function ($query) {
                $query->with('user'); // Eager load users for each attempt
            }])
            ->get();

        $quizAttempts = $quizAttempts->map(function ($quiz) {
            $userNames = $quiz->attempts->pluck('user.name')->unique()->toArray();
            return [
                'quiz_title' => $quiz->quiz_title,
                'attempt_count' => (int)$quiz->attempt_count,
                'users' => $userNames,
            ];
        });

        return view('admin.quizzes.monitoring.completion', compact(
            'completedQuizzesCount',
            'mostAttemptedQuiz',
            'leastAttemptedQuiz',
            'quizAttempts'
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
