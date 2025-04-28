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
    /**
     * Display the employee's enrolled courses dashboard.
     */
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

    /**
     * Display details of a specific course for an enrolled employee.
     */
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

    /**
     * Display the course player for learning modules.
     */
    public function learn(Course $course): View
    {
        $employeeId = Auth::id();
        if (!$this->isEnrolledInCourse($employeeId, $course->id)) {
            abort(403, 'Anda tidak terdaftar dalam kursus ini.');
        }

        $chapters = Chapter::with(['videos', 'quizzes.questions.options'])
            ->where('course_id', $course->id)
            ->orderBy('order')
            ->get();

        $firstVideo = $chapters->isNotEmpty() && $chapters->first()->videos->isNotEmpty()
            ? $chapters->first()->videos->first()
            : null;

        $courseProgress = $this->getCourseProgress($course, $employeeId);

        return view('employees-dashboard.learn.course-player', compact('course', 'chapters', 'firstVideo', 'courseProgress'));
    }

    /**
     * Enroll an employee in a course.
     */
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
            return redirect()->route('employees-dashboard.dashboard')->with('success', 'Pendaftaran kursus berhasil. Menunggu persetujuan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error enrolling in course: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return Redirect::back()->with('error', 'Terjadi kesalahan saat mendaftar kursus. Silakan coba lagi.');
        }
    }

    /**
     * Get lesson content (video details).
     */
    public function getLessonContent(Request $request)
    {
        $videoId = $request->input('video_id');
        $video = CourseVideo::find($videoId);

        if (!$video) {
            return response()->json(['error' => 'Video tidak ditemukan.'], 404);
        }

        return response()->json(['video' => $video]);
    }

    /**
     * Update watch history (currently just a placeholder).
     */
    public function updateWatchHistory(Request $request)
    {
        $videoId = $request->input('video_id');
        $userId = Auth::id();
        $courseVideo = CourseVideo::find($videoId);

        if (!$courseVideo) {
            return response()->json(['error' => 'Video not found'], 404);
        }
        if (!$this->isEnrolledInCourse($userId, $courseVideo->course_id)) {
            return response()->json(['error' => 'Anda tidak terdaftar dalam kursus ini.'], 403);
        }

        // In real implementation, save watch history to database here
        return response()->json(['message' => 'Watch history updated successfully']);
    }

    /**
     * Update lesson completion status when a video is marked as complete.
     */
    public function updateLessonCompletion(Request $request)
    {
        $videoId = $request->input('video_id');
        $userId = Auth::id();
        $isCompleted = $request->input('is_completed');

        $courseVideo = CourseVideo::find($videoId);
        if (!$courseVideo) {
            return response()->json(['error' => 'Video tidak ditemukan.'], 404);
        }
        if (!$this->isEnrolledInCourse($userId, $courseVideo->course_id)) {
            return response()->json(['error' => 'Anda tidak terdaftar dalam kursus ini.'], 403);
        }

        $courseEmployee = $this->getCourseEmployee($userId, $courseVideo->course_id);
        if (!$courseEmployee) {
            return response()->json(['error' => 'Data pendaftaran kursus tidak ditemukan.'], 404);
        }

        $videoCompletions = $courseEmployee->video_completions ?? [];
        $videoCompletions = $this->updateVideoCompletionList($videoCompletions, $videoId, $isCompleted);
        $courseEmployee->video_completions = $videoCompletions;
        $courseEmployee->save();

        return $this->handleLessonCompletionNextStep($courseVideo, $courseEmployee);
    }

    /**
     * Submit quiz answers and process the quiz.
     */
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
            Log::error('Error submitting quiz: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Terjadi kesalahan saat memproses kuis.'], 500);
        }
    }

    /**
     * Display quiz information page.
     */
    public function showQuizInfo(Quiz $quiz): View
    {

        $quiz->loadCount('questions');
        return view('employees-dashboard.learn.quiz-info', compact('quiz'));
    }

    /**
     * Display the quiz page.
     */
    public function getQuiz(Quiz $quiz): View
    {
        $quiz = Quiz::with('questions.options', 'chapter.videos')->findOrFail($quiz->id);
        $videos = $quiz->chapter->videos;

        return view('employees-dashboard.learn.quiz', compact('quiz', 'videos'));
    }

    /**
     * Display quiz results summary page.
     */
    public function quizResults(QuizAttempt $quizAttempt): View
    {
        $quizAttempt->load(['quiz.questions.options', 'answers.question.options', 'answers.selectedOption']);
        $canRestartQuiz = $quizAttempt->status === 'failed';
        $quizHistory = $this->getQuizHistory($quizAttempt->quiz_id);

        return view('employees-dashboard.learn.quiz-results', compact('quizAttempt', 'canRestartQuiz', 'quizHistory'));
    }

    /**
     * Display detailed quiz result page.
     */
    public function quizResultDetails(QuizAttempt $quizAttempt): View
    {
        $quizAttempt->load(['quiz.questions.options', 'answers.question.options', 'answers.selectedOption']);
        $canRestartQuiz = $quizAttempt->status === 'failed';

        return view('employees-dashboard.learn.quiz-result-details', compact('quizAttempt', 'canRestartQuiz'));
    }

    /**
     * Restart a failed quiz attempt.
     */
    public function restartQuiz(Quiz $quiz)
    {
        $userId = Auth::id();
        $attempt = $this->createQuizAttempt($quiz->id, $userId);

        return redirect()->route('employees-dashboard.get-quiz', $quiz->id);
    }

    /**
     * Get course progress data for an employee.
     */
    private function getCourseProgress(Course $course, int $employeeId): array
    {
        $courseEmployee = CourseEmployee::where('user_id', $employeeId)
            ->where('course_id', $course->id)
            ->first();

        if (!$courseEmployee || !$courseEmployee->video_completions) {
            return [];
        }

        $progress = [];
        foreach ($course->chapters as $chapter) {
            $chapterProgress = [
                'chapter_id' => $chapter->id,
                'videos' => [],
                'quizzes' => []
            ];

            foreach ($chapter->videos as $video) {
                $isCompleted = in_array($video->id, $courseEmployee->video_completions);

                $chapterProgress['videos'][] = [
                    'video_id' => $video->id,
                    'is_completed' => $isCompleted
                ];


            }


            foreach ($chapter->quizzes as $quiz) {

                $attempt = QuizAttempt::where('quiz_id', $quiz->id)->where('user_id', $employeeId)
                    ->orderBy('created_at', 'desc')->first();


                $isPassed = ($attempt && $attempt->status === 'passed');

                $chapterProgress['quizzes'][] = [
                    'quiz_id' => $quiz->id,
                    'is_passed' => $isPassed
                ];


            }

            $progress[] = $chapterProgress;
        }
        return $progress;
    }
    /**
     * Handle the next step after a lesson (video) is completed.
     */
    private function handleLessonCompletionNextStep(CourseVideo $video, CourseEmployee $courseEmployee)
    {
        $chapter = $video->chapter;
        $course = $chapter->course;
        $userId = $courseEmployee->user_id;

        $nextVideo = CourseVideo::where('chapter_id', $chapter->id)
            ->where('id', '>', $video->id)
            ->orderBy('id', 'asc')
            ->first();

        if ($nextVideo) {
            return response()->json(['message' => 'Lesson marked as completed', 'next_step' => 'chapter_video_list']);
        }


        $nextQuiz = Quiz::where('chapter_id', $chapter->id)->first();
        if ($nextQuiz) {

            return response()->json(['message' => 'Bab selesai. Silakan lanjutkan ke kuis.', 'next_step' => 'quiz', 'quiz_id' => $nextQuiz->id]);
        }


        $nextChapter = Chapter::where('course_id', $course->id)
            ->where('order', '>', $chapter->order)
            ->orderBy('order', 'asc')
            ->first();


        if ($nextChapter) {

            return response()->json(['message' => 'Bab selesai. Silakan lanjutkan ke bab selanjutnya.', 'next_step' => 'next_chapter']);
        }


        $courseEmployee->is_completed = true;
        $courseEmployee->save();

        return response()->json(['message' => 'Kursus selesai!', 'next_step' => 'course_completed']);
    }

    /**
     * Handle the next step after a chapter is completed.
     */
    private function handleChapterCompletionNextStep(Chapter $chapter, CourseEmployee $courseEmployee)
    {
        Log::info('[handleChapterCompletionNextStep] Start - Chapter ID: ' . $chapter->id . ', CourseEmployee ID: ' . $courseEmployee->id);
        $course = $chapter->course;
        $courseChapters = $course->chapters()->orderBy('order')->get();
        $currentChapterIndex = $courseChapters->search(fn($ch) => $ch->id == $chapter->id);

        Log::info('[handleChapterCompletionNextStep] Current Chapter Index: ' . $currentChapterIndex . ', Total Chapters: ' . $courseChapters->count());

        if ($currentChapterIndex == $courseChapters->count() - 1) {
            Log::info('[handleChapterCompletionNextStep] Last chapter, checking course completion.');
            if ($this->isCourseFullyCompleted($courseChapters, $courseEmployee->video_completions ?? [])) {
                $courseEmployee->is_completed = true;
                $courseEmployee->save();
                Log::info('[handleChapterCompletionNextStep] Course fully completed. Updated course_employees.is_completed to true.');
                return response()->json(['message' => 'Chapter terakhir selesai, kursus selesai!', 'next_step' => 'course_completed']);
            } else {
                Log::info('[handleChapterCompletionNextStep] Chapter last, but course not fully completed (videos missing in other chapters).');
                return response()->json(['message' => 'Chapter terakhir selesai, tetapi ada video yang belum dicentang di chapter lain atau kuis belum lulus.', 'next_step' => 'next_chapter']); // Pesan diubah agar lebih informatif
            }
        } else {
            $nextChapter = $courseChapters->get($currentChapterIndex + 1);
            Log::info('[handleChapterCompletionNextStep] Not last chapter, next step: next_chapter, Next Chapter ID: ' . ($nextChapter->id ?? 'null'));
            return response()->json([
                'message' => 'Chapter selesai, selanjutnya chapter berikutnya.',
                'next_step' => 'next_chapter',
                'next_chapter_id' => $nextChapter->id ?? null,
            ]);
        }
    }
    /**
     * Check if all videos in all chapters of the course are completed.
     */
    /**
     * Check if all videos in all chapters of the course are completed and all quizzes are passed.
     */
    private function isCourseFullyCompleted($courseChapters, $videoCompletions): bool
    {
        Log::info('[isCourseFullyCompleted] Start - Checking course completion, Video Completions: ' . json_encode($videoCompletions));
        $userId = Auth::id();

        foreach ($courseChapters as $chapter) {
            Log::info('[isCourseFullyCompleted] Checking Chapter: ' . $chapter->name . ' (ID: ' . $chapter->id . ')');

            // Jika chapter tidak memiliki video dan tidak memiliki kuis, anggap selesai
            if ($chapter->videos->isEmpty() && $chapter->quizzes->isEmpty()) {
                Log::info('[isCourseFullyCompleted] Chapter has no videos or quizzes - COMPLETED.');
                continue; // Lanjut ke chapter berikutnya
            }

            // Periksa penyelesaian video jika ada video
            foreach ($chapter->videos as $video) {
                Log::info('[isCourseFullyCompleted] Checking video: ' . $video->name . ' (ID: ' . $video->id . '), Completed: ' . (in_array($video->id, $videoCompletions) ? 'yes' : 'no'));
                if (!in_array($video->id, $videoCompletions)) {
                    Log::info('[isCourseFullyCompleted] Video not completed: ' . $video->name . ' - Course NOT complete.');
                    return false; // Jika ada video yang belum selesai, kursus belum selesai
                }
            }

            // Periksa penyelesaian kuis jika ada kuis
            foreach ($chapter->quizzes as $quiz) {
                Log::info('[isCourseFullyCompleted] Checking quiz: ' . $quiz->title . ' (ID: ' . $quiz->id . ')');
                $passedAttempt = QuizAttempt::where('quiz_id', $quiz->id)
                    ->where('user_id', $userId)
                    ->where('status', 'passed')
                    ->exists();

                Log::info('[isCourseFullyCompleted] Quiz passed: ' . ($passedAttempt ? 'yes' : 'no'));
                if (!$passedAttempt) {
                    Log::info('[isCourseFullyCompleted] Quiz not passed: ' . $quiz->title . ' - Course NOT complete.');
                    return false; // Jika ada kuis yang belum lulus, kursus belum selesai
                }
            }

            Log::info('[isCourseFullyCompleted] Chapter videos and quizzes (if any) completed - Chapter COMPLETED.');
        }

        Log::info('[isCourseFullyCompleted] All chapters completed, returning true - Course COMPLETE.');
        return true; // Semua chapter (dengan atau tanpa konten) dianggap selesai
    }

    /**
     * Update the video completion list based on user action.
     */
    private function updateVideoCompletionList(array $videoCompletions, int $videoId, bool $isCompleted): array
    {
        if ($isCompleted) {
            if (!in_array($videoId, $videoCompletions)) {
                $videoCompletions[] = $videoId;
            }
        } else {
            $videoCompletions = array_diff($videoCompletions, [$videoId]);
        }
        return $videoCompletions;
    }
    /**
     * Create a new quiz attempt for a user.
     */
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
    /**
     * Process quiz answers and calculate score.
     */
    private function processQuizAnswers(Quiz $quiz, array $answers, QuizAttempt $attempt): array
    {
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;

        foreach ($quiz->questions as $question) {
            $questionId = $question->id;
            $answerInput = $answers[$questionId] ?? null;
            $isCorrect = false;
            $selectedOptionId = null;
            $essayAnswer = null;

            if ($question->question_type === 'multiple_choice') {
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

        return ['score' => $score, 'passed' => $passed, 'correctAnswers' => $correctAnswers, 'totalQuestions' => $totalQuestions, 'attempt' => $attempt];
    }

    /**
     * Handle the result after quiz submission.
     */
    private function handleQuizSubmissionResult(array $result, Quiz $quiz, Course $course, int $userId, QuizAttempt $attempt)
    {
        $attempt->score = $result['score'];
        $attempt->status = $result['passed'] ? 'passed' : 'failed';
        $attempt->completed_at = now();
        $attempt->save();

        $chapter = $quiz->chapter;
        $courseChapters = $course->chapters()->orderBy('order')->get();
        $currentChapterIndex = $courseChapters->search(fn($ch) => $ch->id == $chapter->id);

        if ($result['passed']) {
            // Tandai semua video di chapter saat ini sebagai selesai (opsional, tergantung kebutuhan)
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

                // Periksa apakah ini chapter terakhir setelah kuis lulus
                if ($currentChapterIndex == $courseChapters->count() - 1) {
                    $courseEmployee->is_completed = $this->isCourseFullyCompleted($courseChapters, $videoCompletions); // Pastikan status kursus diperbarui dengan benar
                }
                $courseEmployee->save();
                Log::info('[handleQuizSubmissionResult] Updated video completions after passing quiz: ' . json_encode($videoCompletions));
            }


            if ($currentChapterIndex == $courseChapters->count() - 1) {
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
    /**
     * Get quiz history for a quiz.
     */
    private function getQuizHistory(int $quizId)
    {
        return QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quizId)
            ->orderBy('completed_at', 'desc')
            ->get();
    }

    /**
     * Check if an employee is enrolled in a course.
     */
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
