<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizAttemptController extends Controller
{
    public function start(Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            // Check if there's an ongoing attempt
            $ongoingAttempt = QuizAttempt::where('user_id', Auth::id())
                ->where('quiz_id', $quiz->id)
                ->whereNull('completed_at')
                ->first();

            if ($ongoingAttempt) {
                return redirect()->route('quiz.attempt.continue', $ongoingAttempt->id);
            }

            // Create new attempt
            $attempt = QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'user_id' => Auth::id(),
                'started_at' => now(),
                'status' => 'in_progress'
            ]);

            DB::commit();
            return redirect()->route('quiz.attempt.continue', $attempt->id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in QuizAttemptController@start: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while starting the quiz.');
        }
    }

    public function submit(Request $request, QuizAttempt $attempt)
    {
        try {
            DB::beginTransaction();

            $score = 0;
            $totalQuestions = $attempt->quiz->questions->count();

            foreach ($request->answers as $questionId => $answerId) {
                $question = Question::find($questionId);
                $correctOption = $question->options()->where('is_correct', true)->first();

                if ($correctOption && $correctOption->id == $answerId) {
                    $score++;
                }
            }

            $finalScore = ($score / $totalQuestions) * 100;
            $passed = $finalScore >= $attempt->quiz->passing_score;

            $attempt->update([
                'score' => $finalScore,
                'status' => $passed ? 'passed' : 'failed',
                'completed_at' => now()
            ]);

            DB::commit();
            return redirect()->route('quiz.results', $attempt->id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in QuizAttemptController@submit: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while submitting your answers.');
        }
    }
}
