<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\CourseEmployee;
use App\Models\Course;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    /**
     * Display the main employee dashboard.
     * (Unchanged as requested)
     */
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

        $quizAttempts = QuizAttempt::where('user_id', $employeeId)->get();
        $totalQuizzesAttempted = $quizAttempts->count();
        $averageQuizScore = $quizAttempts->avg('score') ?? 0;

        return view('employees-dashboard.dashboard', compact(
            'enrolledCoursesCount',
            'activeCoursesCount',
            'pendingCoursesCount',
            'totalCoursesCreated',
            'totalQuizzesAttempted',
/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Display the learning progress index for the authenticated employee.
     *
     * This method retrieves the employee's enrolled courses and valid quiz attempts,
     * calculates overall metrics such as the total number of quizzes attempted, average score,
     * and highest score. It prepares data for displaying performance tables per course and
     * a radar chart visualization. The radar chart labels are unique quiz titles attempted,
     * and datasets represent the highest scores per quiz for each course.
     *
     * @return \Illuminate\View\View
     */

/*******  59e0af06-75f8-4a65-a670-008152103794  *******/            'averageQuizScore'
        ));
    }

    // =========================================================================
    // Learning Progress Section
    // =========================================================================

    public function learningProgressIndex(): View
    {
        $employeeId = Auth::id();

        $validQuizAttempts = $this->getValidQuizAttemptsForProgress($employeeId);
        $metrics = $this->calculateOverallMetrics($validQuizAttempts);
        $scoresByCourseTableData = $this->prepareScoresByCourseTableData($validQuizAttempts);
        list($radarChartLabels, $radarChartDatasets) = $this->prepareRadarChartData($validQuizAttempts);
        $recentAttempts = $validQuizAttempts->sortByDesc('created_at')->take(10);

        return view('employees-dashboard.learning-progress', [
            'quizAttempts'          => $recentAttempts,
            'totalQuizzesAttempted' => $metrics['total'],
            'averageQuizScore'      => $metrics['average'],
            'highestQuizScore'      => $metrics['highest'],
            'scoresByCourse'        => $scoresByCourseTableData,
            'chartLabels'           => $radarChartLabels,
            'chartData'             => $radarChartDatasets,
        ]);
    }

    // --- Private Helper Methods ---

    private function getValidQuizAttemptsForProgress(int $employeeId): Collection
    {
        return QuizAttempt::with([
                'quiz:id,title,chapter_id',
                'quiz.chapter:id,course_id',
                'quiz.chapter.course:id,name'
            ])
            ->where('user_id', $employeeId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->filter(fn($attempt) => $attempt->quiz && $attempt->quiz->chapter && $attempt->quiz->chapter->course);
    }

    private function calculateOverallMetrics(Collection $attempts): array
    {
        if ($attempts->isEmpty()) {
            return ['total' => 0, 'average' => 0, 'highest' => 0];
        }
        return [
            'total'   => $attempts->count(),
            'average' => round($attempts->avg('score') ?? 0, 2),
            'highest' => round($attempts->max('score') ?? 0, 2),
        ];
    }

    private function prepareScoresByCourseTableData(Collection $attempts): Collection
    {
        return $attempts->groupBy('quiz.chapter.course.id')
            ->map(function (Collection $attemptsInCourse) {
                $course = $attemptsInCourse->first()->quiz->chapter->course;
                return [
                    'course_id'        => $course->id,
                    'course_name'      => $course->name ?? 'Unknown Course',
                    'attempts_count'   => $attemptsInCourse->count(),
                    'unique_quizzes_count' => $attemptsInCourse->unique('quiz_id')->count(),
                    'average_score'    => round($attemptsInCourse->avg('score') ?? 0, 2),
                    'highest_score'    => round($attemptsInCourse->max('score') ?? 0, 2),
                ];
            })
            ->sortBy('course_name');
    }

    private function prepareRadarChartData(Collection $attempts): array
    {
        if ($attempts->isEmpty()) {
            return [[], []];
        }

        $radarChartLabels = $attempts->map(fn($attempt) => $attempt->quiz->title)
            ->unique()->values()->toArray();

        $radarChartDatasets = [];
        $attemptsByCourse = $attempts->groupBy('quiz.chapter.course.id');
        $colors = $this->getChartColorPalette(count($attemptsByCourse));
        $colorIndex = 0;

        foreach ($attemptsByCourse as $courseId => $attemptsInCourse) {
            $highestScoresPerQuizId = $attemptsInCourse->groupBy('quiz_id')
                ->map(fn(Collection $quizAttempts) => $quizAttempts->max('score'));

            $courseName = $attemptsInCourse->first()->quiz->chapter->course->name ?? 'Unknown Course';

            $scoresData = [];
            foreach ($radarChartLabels as $labelQuizTitle) {
                $score = 0;
                $attemptWithTitleInCourse = $attemptsInCourse->firstWhere('quiz.title', $labelQuizTitle);
                 if ($attemptWithTitleInCourse) {
                    $score = $highestScoresPerQuizId->get($attemptWithTitleInCourse->quiz_id) ?? 0;
                }
                $scoresData[] = round($score, 0);
            }

            $selectedColor = $colors[$colorIndex % count($colors)];
            $radarChartDatasets[] = [
                'label'                     => $courseName,
                'data'                      => $scoresData,
                'fill'                      => true,
                'backgroundColor'           => $selectedColor['bg'],
                'borderColor'               => $selectedColor['border'],
                'pointBackgroundColor'      => $selectedColor['border'],
                'pointBorderColor'          => '#fff',
                'pointHoverBackgroundColor' => '#fff',
                'pointHoverBorderColor'     => $selectedColor['border'],
            ];
            $colorIndex++;
        }

        return [$radarChartLabels, $radarChartDatasets];
    }

    private function getChartColorPalette(int $numberOfDatasets): array
    {
        $baseColors = [
            ['border' => 'rgb(54, 162, 235)', 'bg' => 'rgba(54, 162, 235, 0.2)'],
            ['border' => 'rgb(255, 99, 132)', 'bg' => 'rgba(255, 99, 132, 0.2)'],
            ['border' => 'rgb(75, 192, 192)', 'bg' => 'rgba(75, 192, 192, 0.2)'],
            ['border' => 'rgb(255, 205, 86)', 'bg' => 'rgba(255, 205, 86, 0.2)'],
            ['border' => 'rgb(153, 102, 255)', 'bg' => 'rgba(153, 102, 255, 0.2)'],
            ['border' => 'rgb(255, 159, 64)', 'bg' => 'rgba(255, 159, 64, 0.2)'],
            ['border' => 'rgb(101, 163, 13)', 'bg' => 'rgba(101, 163, 13, 0.2)'],
            ['border' => 'rgb(244, 63, 94)',  'bg' => 'rgba(244, 63, 94, 0.2)'],
        ];

        $palette = [];
        if ($numberOfDatasets <= 0) return $palette;

        for ($i = 0; $i < $numberOfDatasets; $i++) {
            $palette[] = $baseColors[$i % count($baseColors)];
        }
        return $palette;
    }

}
