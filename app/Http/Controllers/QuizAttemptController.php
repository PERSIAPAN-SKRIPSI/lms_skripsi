<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer; // Pastikan model ini ada
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
                'start_time' => now(),
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

    // QuizAttemptController.php

    public function submit(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        try {
            DB::beginTransaction();

            // Verifikasi bahwa ini adalah percobaan pengguna
            if ($attempt->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized access to this attempt.');
            }

            // Validasi input
            $request->validate([
                'answers' => 'required|array',
                'answers.*' => 'required|exists:question_options,id'
            ]);

            // Log jawaban yang diterima
            Log::info('Jawaban yang diterima:', $request->input('answers'));

            // Proses jawaban dan simpan
            $correctAnswersCount = 0; // Hitung jumlah jawaban yang benar
            foreach ($request->input('answers') as $questionId => $optionId) {
                $question = Question::findOrFail($questionId);
                $correctOption = $question->options()->where('is_correct', true)->first();
                $isCorrect = ($correctOption && $correctOption->id == $optionId);

                // Simpan jawaban
                QuizAnswer::updateOrCreate(
                    [
                        'quiz_attempt_id' => $attempt->id,
                        'question_id' => $questionId,
                    ],
                    [
                        'selected_option_id' => $optionId,
                        'is_correct' => $isCorrect,
                    ]
                );

                if ($isCorrect) {
                    $correctAnswersCount++;
                }
            }

            // Hitung skor
            $totalQuestions = $quiz->questions->count();
            $finalScore = ($totalQuestions > 0) ? (($correctAnswersCount / $totalQuestions) * 100) : 0;
            $passed = $finalScore >= $quiz->passing_score;

            // Update percobaan
            $attempt->update([
                'score' => $finalScore,
                'status' => $passed ? 'passed' : 'failed',
                'completed_at' => now(),
            ]);

            DB::commit();

            // Redirect ke halaman hasil
            return redirect()->route('admin.quizzes.attempt.results', [
                'quiz' => $quiz->id,
                'attempt' => $attempt->id
            ])->with('success', 'Quiz completed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in QuizAttemptController@submit: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while submitting your answers: ' . $e->getMessage());
        }
    }
    public function adminStart(Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            // Check if there's an ongoing attempt by the logged-in admin
            $ongoingAttempt = QuizAttempt::where('user_id', Auth::id())
                ->where('quiz_id', $quiz->id)
                ->whereNull('completed_at')
                ->first();

            if ($ongoingAttempt) {
                // Redirect to showing the existing attempt
                return redirect()->route('admin.quizzes.attempt.show', [
                    'quiz' => $quiz->id,
                    'attempt' => $ongoingAttempt->id
                ])->with('message', 'Anda sudah memulai kuis ini.  Lanjutkan dari bagian terakhir!');
            }

            // Create new attempt
            $attempt = QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'user_id' => Auth::id(), // Gunakan ID admin yang login
                'start_time' => now(),
                'status' => 'in_progress'
            ]);

            DB::commit();

            // Redirect to view the attempt (menampilkan pertanyaan pertama)
            return redirect()->route('admin.quizzes.showQuestion', [
                'quiz' => $quiz->id,
                'id' => $quiz->questions()->first()->id // Atau logic lain untuk pertanyaan pertama
            ])->with('success', 'Kuis berhasil dimulai!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in QuizAttemptController@adminStart: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memulai kuis: ' . $e->getMessage());
        }
    }

    public function show(Quiz $quiz, QuizAttempt $attempt)
    {
        try {
            // Make sure this attempt belongs to current user
            if ($attempt->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized access to this attempt.');
            }

            // If attempt is completed, redirect to results
            if ($attempt->completed_at) {
                return redirect()->route('admin.quizzes.attempt.results', [
                    'quiz' => $quiz->id,
                    'attempt' => $attempt->id
                ]);
            }

            // Get answered question IDs
            $answeredQuestionIds = QuizAnswer::where('quiz_attempt_id', $attempt->id)
                ->pluck('question_id')
                ->toArray();

            // Get the first unanswered question
            $currentQuestion = $quiz->questions()
                ->whereNotIn('id', $answeredQuestionIds)
                ->first();

            // If all questions answered but not marked complete, redirect to submit
            if (!$currentQuestion) {
                return view('admin.quizzes.attempt_review', [
                    'quiz' => $quiz,
                    'attempt' => $attempt,
                    'answers' => $attempt->answers
                ]);
            }

            // Calculate progress
            $totalQuestions = $quiz->questions->count();
            $answeredCount = count($answeredQuestionIds);
            $progress = ($totalQuestions > 0) ? (($answeredCount / $totalQuestions) * 100) : 0;

            return view('admin.quizzes.attempt', [
                'quiz' => $quiz,
                'attempt' => $attempt,
                'currentQuestion' => $currentQuestion,
                'totalQuestions' => $totalQuestions,
                'answeredCount' => $answeredCount,
                'progress' => $progress
            ]);
        } catch (\Exception $e) {
            Log::error('Error in QuizAttemptController@show: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while viewing the quiz attempt: ' . $e->getMessage());
        }
    }

    /**
     * Display quiz attempt results
     */
    public function results(Quiz $quiz, QuizAttempt $attempt)
    {
        try {
            // Verify this is the user's attempt
            if ($attempt->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized access to this attempt.');
            }

            // Cek apakah sedang dalam proses prevent redirect loop
            $preventLoop = session('prevent_redirect_loop');

            // Jika attempt belum selesai (completed_at null) dan bukan dalam prevent loop
            if (!$attempt->completed_at && !$preventLoop) {
                // Cek apakah quiz sudah dijawab semua
                $answeredCount = QuizAnswer::where('quiz_attempt_id', $attempt->id)->count();
                $totalQuestions = $quiz->questions->count();

                if ($answeredCount >= $totalQuestions) {
                    // Quiz sudah dijawab semua, finalisasi secara otomatis
                    $correctAnswers = QuizAnswer::where('quiz_attempt_id', $attempt->id)
                        ->where('is_correct', true)
                        ->count();
                    $score = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;
                    $passed = $score >= $quiz->passing_score;

                    // Update attempt selesai
                    $attempt->update([
                        'completed_at' => now(),
                        'score' => $score,
                        'status' => $passed ? 'passed' : 'failed'
                    ]);

                    // Refresh model data
                    $attempt->refresh();

                    // Set session untuk mencegah redirect loop
                    session(['prevent_redirect_loop' => true]);
                } else {
                    // Quiz belum selesai dijawab, redirect ke attempt show
                    return redirect()->route('admin.quizzes.attempt.show', [
                        'quiz' => $quiz->id,
                        'attempt' => $attempt->id
                    ])->with('info', 'Silakan selesaikan kuis terlebih dahulu.');
                }
            } else if ($preventLoop) {
                // Hapus session prevent loop untuk request berikutnya
                session()->forget('prevent_redirect_loop');
            }

            // Get all questions with answers
            $questions = $quiz->questions()->with(['options'])->get();

            // Get user's answers - tambahkan defensive programming
            $userAnswers = QuizAnswer::where('quiz_attempt_id', $attempt->id)
                ->with(['question', 'selectedOption'])
                ->get();

            // Key jawaban berdasarkan question_id
            $userAnswers = $userAnswers->isEmpty() ? collect() : $userAnswers->keyBy('question_id');

            // Calculate stats dengan defensive programming
            $totalQuestions = $questions->count();
            $correctAnswers = $userAnswers->where('is_correct', true)->count();
            $incorrectAnswers = $totalQuestions - $correctAnswers;

            // Hitung completion time dengan defensive programming
            $completionTime = $attempt->completed_at
                ? $attempt->completed_at->diffInMinutes($attempt->start_time)
                : 0;

                return view('admin.quizzes.quiz_attempts.results',[
                'quiz' => $quiz,
                'attempt' => $attempt,
                'questions' => $questions,
                'userAnswers' => $userAnswers,
                'totalQuestions' => $totalQuestions,
                'correctAnswers' => $correctAnswers,
                'incorrectAnswers' => $incorrectAnswers,
                'completionTime' => $completionTime,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in QuizAttemptController@results: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat melihat hasil: ' . $e->getMessage());
        }
    }
    /**
     * Submit final quiz answers and complete the attempt
     */
    public function finalize(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        try {
            DB::beginTransaction();

            // Verify this is the user's attempt
            if ($attempt->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized access to this attempt.');
            }

            // Check if all questions are answered
            $answeredCount = QuizAnswer::where('quiz_attempt_id', $attempt->id)->count();
            $totalQuestions = $quiz->questions->count();

            if ($answeredCount < $totalQuestions) {
                DB::rollBack();
                return back()->with('warning', 'Please answer all questions before submitting.');
            }

            // Calculate final score
            $correctAnswers = QuizAnswer::where('quiz_attempt_id', $attempt->id)
                ->where('is_correct', true)
                ->count();
            $finalScore = ($correctAnswers / $totalQuestions) * 100;
            $passed = $finalScore >= $quiz->passing_score;

            // Update attempt as completed
            $attempt->update([
                'score' => $finalScore,
                'status' => $passed ? 'passed' : 'failed',
                'completed_at' => now()
            ]);

            DB::commit();
            return redirect()->route('admin.quizzes.attempt.results', [
                'quiz' => $quiz->id,
                'attempt' => $attempt->id
            ])->with('success', 'Quiz completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in QuizAttemptController@finalize: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while finalizing the quiz: ' . $e->getMessage());
        }
    }
}
