<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizMonitoringController extends Controller
{
    public function performance()
    {
        try {
            $performanceStats = QuizAttempt::with(['quiz', 'user'])
                ->select(
                    'quiz_id',
                    DB::raw('AVG(score) as average_score'),
                    DB::raw('COUNT(*) as total_attempts'),
                    DB::raw('COUNT(CASE WHEN status = "passed" THEN 1 END) as passed_count')
                )
                ->groupBy('quiz_id')
                ->paginate(10);

            return view('quiz-monitoring.performance', compact('performanceStats'));
        } catch (\Exception $e) {
            Log::error('Error in QuizMonitoringController@performance: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading quiz performance data.');
        }
    }

    public function completion()
    {
        try {
            $completionStats = Quiz::withCount([
                'attempts',
                'attempts as completed_count' => function ($query) {
                    $query->whereNotNull('completed_at');
                },
                'attempts as passed_count' => function ($query) {
                    $query->where('status', 'passed');
                }
            ])->paginate(10);

            return view('quiz-monitoring.completion', compact('completionStats'));
        } catch (\Exception $e) {
            Log::error('Error in QuizMonitoringController@completion: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading quiz completion data.');
        }
    }
}
