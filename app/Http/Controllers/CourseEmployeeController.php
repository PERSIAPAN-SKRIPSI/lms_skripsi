<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEmployee;
use App\Models\Chapter;
use App\Models\CourseVideo;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CourseEmployeeController extends Controller
{
    public function index(): View
    {
        $employeeId = Auth::id();
        $enrolledCourses = CourseEmployee::with([
            'course' => function ($query) {
                $query->with(['chapters.videos', 'teacher.user', 'category']);
            }
        ])
            ->where('user_id', $employeeId)
            ->where('is_approved', true)
            ->get();

        return view('employees-dashboard.courses.index', compact('enrolledCourses'));
    }

    public function show(Course $course): View
    {
        $employeeId = Auth::id();
        if (!$this->isEnrolledInCourse($employeeId, $course->id)) {
            abort(403, 'Anda tidak terdaftar dalam kursus ini.');
        }

        $totalDurationInSeconds = $course->chapters->flatMap->videos->sum('duration');
        $totalMinutes = floor($totalDurationInSeconds / 60);
        $remainingSeconds = $totalDurationInSeconds % 60;

        return view('employees-dashboard.courses.show', compact('course', 'totalMinutes', 'remainingSeconds'));
    }

    public function learn(Course $course): View
    {
        $employeeId = Auth::id();
        if (!$this->isEnrolledInCourse($employeeId, $course->id)) {
            abort(403, 'Anda tidak terdaftar dalam kursus ini.');
        }

        $course->load(['chapters.videos', 'chapters.quizzes']);
        $chapters = $course->chapters()->orderBy('order')->get();
        $firstVideo = $chapters->isNotEmpty() && $chapters->first()->videos->isNotEmpty()
            ? $chapters->first()->videos->sortBy('id')->first()
            : null;

        $courseProgress = $this->getCourseProgress($course, $employeeId);
        $overallProgress = $this->calculateOverallCourseProgress($course, $employeeId);

        return view('employees-dashboard.learn.course-player', compact(
            'course',
            'chapters',
            'firstVideo',
            'courseProgress',
            'overallProgress'
        ));
    }

    private function calculateOverallCourseProgress(Course $course, int $employeeId): array
    {
        $course->load(['chapters.videos', 'chapters.quizzes']);
        $courseEmployee = CourseEmployee::where('user_id', $employeeId)
            ->where('course_id', $course->id)
            ->first();

        $videoCompletions = $courseEmployee?->video_completions ?? [];

        $totalVideos = 0;
        $completedVideos = 0;
        $totalQuizzes = 0;
        $passedQuizzes = 0;

        foreach ($course->chapters as $chapter) {
            $totalVideos += $chapter->videos->count();

            foreach ($chapter->videos as $video) {
                if (in_array($video->id, $videoCompletions)) {
                    $completedVideos++;
                }
            }

            $totalQuizzes += $chapter->quizzes->count();

            foreach ($chapter->quizzes as $quiz) {
                $quizPassed = QuizAttempt::where('quiz_id', $quiz->id)
                    ->where('user_id', $employeeId)
                    ->where('status', 'passed')
                    ->exists();

                if ($quizPassed) {
                    $passedQuizzes++;
                }
            }
        }

        $totalItems = $totalVideos + $totalQuizzes;
        $completedItems = $completedVideos + $passedQuizzes;
        $percentage = ($totalItems > 0) ? floor(($completedItems / $totalItems) * 100) : 100;
        $percentage = min(100, $percentage);

        return [
            'percentage' => $percentage,
            'completed_items' => $completedItems,
            'total_items' => $totalItems
        ];
    }

    public function enroll(Request $request, Course $course)
    {
        $employee = Auth::user();
        if ($this->isEnrolledInCourse($employee->id, $course->id)) {
            return Redirect::back()->with('error', 'Anda sudah terdaftar dalam kursus ini.');
        }

        DB::beginTransaction();
        try {
            CourseEmployee::create([
                'user_id' => $employee->id,
                'course_id' => $course->id,
                'enrolled_at' => now(),
                'is_approved' => false,
            ]);
            DB::commit();
            return redirect()->route('employees-dashboard.dashboard')
                ->with('success', 'Pendaftaran kursus berhasil. Menunggu persetujuan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error enrolling in course: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Terjadi kesalahan saat mendaftar kursus. Silakan coba lagi.');
        }
    }

    public function updateLessonCompletion(Request $request)
    {
        $videoId = $request->input('video_id');
        $isCompleted = $request->input('is_completed');
        $userId = Auth::id();

        try {
            $video = CourseVideo::findOrFail($videoId);
            $chapter = Chapter::findOrFail($video->chapter_id);
            $course = Course::findOrFail($chapter->course_id);

            $courseEmployee = CourseEmployee::firstOrCreate(
                ['user_id' => $userId, 'course_id' => $course->id],
                ['start_date' => now()]
            );

            $videoCompletions = $courseEmployee->video_completions ?? [];

            if ($isCompleted && !in_array($videoId, $videoCompletions)) {
                $videoCompletions[] = $videoId;
            } elseif (!$isCompleted && in_array($videoId, $videoCompletions)) {
                $videoCompletions = array_diff($videoCompletions, [$videoId]);
            }

            $courseEmployee->video_completions = $videoCompletions;
            $courseEmployee->save();

            $nextStep = $this->determineNextStep($chapter, $videoCompletions, $course, $userId, $courseEmployee);

            return response()->json([
                'message' => $isCompleted ? 'Video ditandai selesai!' : 'Status video diperbarui.',
                'next_step' => $nextStep['step'],
                'quiz_id' => $nextStep['quiz_id'] ?? null
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui status: ' . $e->getMessage()], 500);
        }
    }

    private function determineNextStep(Chapter $chapter, array $videoCompletions, Course $course, int $userId, CourseEmployee $courseEmployee): array
    {
        $chapterVideos = $chapter->videos()->pluck('id')->toArray();
        $allVideosInChapterCompleted = count(array_intersect($chapterVideos, $videoCompletions)) === count($chapterVideos);

        if (!$allVideosInChapterCompleted) {
            return ['step' => 'chapter_video_list'];
        }

        $quiz = $chapter->quizzes()->first();
        if ($quiz) {
            return ['step' => 'quiz', 'quiz_id' => $quiz->id];
        }

        $nextChapter = Chapter::where('course_id', $course->id)
            ->where('order', '>', $chapter->order)
            ->orderBy('order')
            ->first();

        if ($nextChapter) {
            return ['step' => 'next_chapter'];
        }

        if ($this->isCourseFullyCompleted($course->chapters, $videoCompletions, $userId)) {
            $courseEmployee->is_completed = 1; // Ubah menjadi integer 1 (bukan timestamp)
            // Hapus baris yang mengatur status karena kolom tidak ada
            $courseEmployee->save();
            return ['step' => 'course_completed'];
        }

        return ['step' => 'chapter_video_list'];
    }

    public function submitQuiz(Request $request)
    {
        $quizId = $request->input('quiz_id');
        $answers = $request->input('answers', []);
        $userId = Auth::id();

        $quiz = Quiz::with('questions.options')->findOrFail($quizId);
        $course = Course::findOrFail($quiz->chapter->course_id);

        DB::beginTransaction();
        try {
            $attempt = $this->createQuizAttempt($quizId, $userId);
            $result = $this->processQuizAnswers($quiz, $answers, $attempt);
            DB::commit();

            return $this->handleQuizSubmissionResult($result, $quiz, $course, $userId, $attempt);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error submitting quiz: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memproses kuis.'], 500);
        }
    }

    public function showQuizInfo(Quiz $quiz): View
    {
        $quiz->loadCount('questions');
        return view('employees-dashboard.learn.quiz-info', compact('quiz'));
    }

    public function getQuiz(Quiz $quiz): View
    {
        $quiz = Quiz::with('questions.options', 'chapter.videos')->findOrFail($quiz->id);
        $videos = $quiz->chapter->videos;

        return view('employees-dashboard.learn.quiz', compact('quiz', 'videos'));
    }

    public function quizResults(QuizAttempt $quizAttempt): View
    {
        $quizAttempt->load(['quiz.questions.options', 'answers.question.options', 'answers.selectedOption']);
        $canRestartQuiz = $quizAttempt->status === 'failed';
        $quizHistory = $this->getQuizHistory($quizAttempt->quiz_id);

        return view('employees-dashboard.learn.quiz-results', compact('quizAttempt', 'canRestartQuiz', 'quizHistory'));
    }

    public function quizResultDetails(QuizAttempt $quizAttempt): View
    {
        $quizAttempt->load(['quiz.questions.options', 'answers.question.options', 'answers.selectedOption']);
        $canRestartQuiz = $quizAttempt->status === 'failed';

        return view('employees-dashboard.learn.quiz-result-details', compact('quizAttempt', 'canRestartQuiz'));
    }

    public function restartQuiz(Quiz $quiz)
    {
        $userId = Auth::id();
        $this->createQuizAttempt($quiz->id, $userId);

        return redirect()->route('employees-dashboard.get-quiz', $quiz->id);
    }

    private function getCourseProgress(Course $course, int $employeeId): array
    {
        $courseProgress = [];
        $courseEmployee = CourseEmployee::where('user_id', $employeeId)
            ->where('course_id', $course->id)
            ->first();
        $videoCompletions = $courseEmployee?->video_completions ?? [];

        foreach ($course->chapters as $chapter) {
            $chapterProgress = [
                'chapter_id' => $chapter->id,
                'videos' => [],
                'quizzes' => [],
            ];

            foreach ($chapter->videos as $video) {
                $chapterProgress['videos'][] = [
                    'video_id' => $video->id,
                    'is_completed' => in_array($video->id, $videoCompletions),
                ];
            }

            foreach ($chapter->quizzes as $quiz) {
                $quizPassed = QuizAttempt::where('quiz_id', $quiz->id)
                    ->where('user_id', $employeeId)
                    ->where('status', 'passed')
                    ->exists();

                $chapterProgress['quizzes'][] = [
                    'quiz_id' => $quiz->id,
                    'is_passed' => $quizPassed,
                ];
            }

            $courseProgress[] = $chapterProgress;
        }

        return $courseProgress;
    }

    private function isCourseFullyCompleted($courseChapters, $videoCompletions, $userId): bool
    {
        foreach ($courseChapters as $chapter) {
            if ($chapter->videos->isEmpty() && $chapter->quizzes->isEmpty()) {
                continue;
            }

            foreach ($chapter->videos as $video) {
                if (!in_array($video->id, $videoCompletions)) {
                    return false;
                }
            }

            foreach ($chapter->quizzes as $quiz) {
                $passedAttempt = QuizAttempt::where('quiz_id', $quiz->id)
                    ->where('user_id', $userId)
                    ->where('status', 'passed')
                    ->exists();

                if (!$passedAttempt) {
                    return false;
                }
            }
        }

        return true;
    }

    private function createQuizAttempt(int $quizId, int $userId): QuizAttempt
    {
        $attempt = new QuizAttempt();
        $attempt->quiz_id = $quizId;
        $attempt->user_id = $userId;
        $attempt->started_at = now();
        $attempt->status = 'in_progress';
        $attempt->save();
        return $attempt;
    }

    private function processQuizAnswers(Quiz $quiz, array $answers, QuizAttempt $attempt): array
    {
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;

        foreach ($quiz->questions as $question) {
            $questionId = $question->id;
            $answerInput = $answers[$questionId] ?? null;
            $isCorrect = false;
            $selectedOptionId = null;

            if ($question->question_type === 'multiple_choice' && $answerInput) {
                $selectedOptionId = $answerInput;
                $correctOption = $question->options()->where('is_correct', true)->first();
                if ($correctOption && $selectedOptionId == $correctOption->id) {
                    $isCorrect = true;
                    $correctAnswers++;
                }
            }

            QuizAnswer::create([
                'quiz_attempt_id' => $attempt->id,
                'question_id' => $questionId,
                'selected_option_id' => $selectedOptionId,
                'is_correct' => $isCorrect,
            ]);
        }

        $score = ($correctAnswers / $totalQuestions) * 100;
        $passed = $score >= $quiz->passing_score;

        return [
            'score' => $score,
            'passed' => $passed,
            'correctAnswers' => $correctAnswers,
            'totalQuestions' => $totalQuestions,
            'attempt' => $attempt
        ];
    }

    private function handleQuizSubmissionResult(array $result, Quiz $quiz, Course $course, int $userId, QuizAttempt $attempt)
    {
        $attempt->score = $result['score'];
        $attempt->status = $result['passed'] ? 'passed' : 'failed';
        $attempt->completed_at = now();
        $attempt->save();

        $chapter = $quiz->chapter;
        $courseChapters = $course->chapters()->orderBy('order')->get();
        $currentChapterIndex = $courseChapters->search(fn($ch) => $ch->id == $chapter->id);
        $isLastChapter = $currentChapterIndex == $courseChapters->count() - 1;

        if ($result['passed']) {
            $courseEmployee = $this->getCourseEmployee($userId, $course->id);
            if ($courseEmployee) {
                $videoCompletions = $courseEmployee->video_completions ?? [];

                $chapterVideoIds = $chapter->videos->pluck('id')->toArray();
                foreach ($chapterVideoIds as $videoId) {
                    if (!in_array($videoId, $videoCompletions)) {
                        $videoCompletions[] = $videoId;
                    }
                }
                $courseEmployee->video_completions = $videoCompletions;

                if ($isLastChapter) {
                    $courseEmployee->is_completed = $this->isCourseFullyCompleted($courseChapters, $videoCompletions, $userId);
                }
                $courseEmployee->save();
            }

            if ($isLastChapter) {
                return response()->json([
                    'score' => $result['score'],
                    'passed' => true,
                    'attempt_id' => $attempt->id,
                    'message' => 'Selamat! Anda lulus quiz dan kursus ini sudah selesai.',
                    'next_step' => 'course_completed',
                ]);
            } else {
                $nextChapter = $courseChapters->get($currentChapterIndex + 1);
                return response()->json([
                    'score' => $result['score'],
                    'passed' => true,
                    'attempt_id' => $attempt->id,
                    'message' => 'Selamat! Anda lulus quiz ini.',
                    'next_step' => 'next_chapter',
                    'next_chapter_id' => $nextChapter->id ?? null,
                ]);
            }
        } else {
            return response()->json([
                'score' => $result['score'],
                'passed' => false,
                'attempt_id' => $attempt->id,
                'message' => 'Anda belum lulus. Coba lagi.',
                'next_step' => 'quiz_failed',
            ]);
        }
    }

    private function getQuizHistory(int $quizId)
    {
        return QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quizId)
            ->orderBy('completed_at', 'desc')
            ->get();
    }

    private function isEnrolledInCourse(int $employeeId, int $courseId): bool
    {
        return CourseEmployee::where('user_id', $employeeId)
            ->where('course_id', $courseId)
            ->where('is_approved', true)
            ->exists();
    }

    private function getCourseEmployee(int $userId, int $courseId): ?CourseEmployee
    {
        return CourseEmployee::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();
    }
}
