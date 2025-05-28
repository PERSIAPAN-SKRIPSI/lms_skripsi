<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEmployee;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PerformanceReportController extends Controller
{
    /**
     * Menampilkan halaman laporan kinerja dengan filter
     */
    public function index()
    {
        try {
            // Ambil data untuk filter
            $courses = Course::select('id', 'name')->get();
            $employees = User::role('employee')
                ->select('id', 'name', 'email')
                ->orderBy('name')
                ->get();

            return view('admin.reports.performance.index', compact('courses', 'employees'));
        } catch (\Exception $e) {
            Log::error('Error in PerformanceReportController@index: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat halaman laporan.');
        }
    }

    /**
     * Generate dan download laporan kinerja dalam format PDF
     */
    public function downloadReport(Request $request)
    {
        try {
            $filters = $this->validateFilters($request);
            $reportData = $this->generateReportData($filters);

            // Generate PDF
            $pdf = Pdf::loadView('admin.reports.performance.download', $reportData);
            $pdf->setPaper('A4', 'landscape');

            $filename = $this->generateFilename($filters);

            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Error in PerformanceReportController@downloadReport: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat laporan PDF.');
        }
    }

    /**
     * Validasi dan sanitasi filter input
     */
    private function validateFilters(Request $request)
    {
        $validated = $request->validate([
            'course_filter' => 'nullable|string|in:all,specific',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:courses,id',
            'employee_filter' => 'nullable|string|in:all,specific',
            'employee_ids' => 'nullable|array',
            'employee_ids.*' => 'exists:users,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'format' => 'required|string|in:pdf',
        ]);

        // Set default values
        $validated['course_filter'] = $validated['course_filter'] ?? 'all';
        $validated['employee_filter'] = $validated['employee_filter'] ?? 'all';
        $validated['format'] = $validated['format'] ?? 'pdf';

        return $validated;
    }

    /**
     * Generate data laporan berdasarkan filter
     */
    private function generateReportData($filters)
    {
        // Query dasar untuk employees
        $employeesQuery = User::role('employee')
            ->with([
                'courses' => function ($query) use ($filters) {
                    if ($filters['course_filter'] === 'specific' && !empty($filters['course_ids'])) {
                        $query->whereIn('courses.id', $filters['course_ids']);
                    }
                },
                'quizAttempts' => function ($query) use ($filters) {
                    $query->with(['quiz' => function ($quizQuery) use ($filters) {
                        if ($filters['course_filter'] === 'specific' && !empty($filters['course_ids'])) {
                            $quizQuery->whereIn('course_id', $filters['course_ids']);
                        }
                    }]);

                    if (!empty($filters['date_from'])) {
                        $query->where('created_at', '>=', $filters['date_from']);
                    }
                    if (!empty($filters['date_to'])) {
                        $query->where('created_at', '<=', $filters['date_to'] . ' 23:59:59');
                    }
                }
            ]);

        // Filter employees jika diperlukan
        if ($filters['employee_filter'] === 'specific' && !empty($filters['employee_ids'])) {
            $employeesQuery->whereIn('id', $filters['employee_ids']);
        }

        $employees = $employeesQuery->get();

        // Generate detailed report data
        $reportData = [
            'filters' => $filters,
            'generated_at' => now(),
            'employees' => [],
            'summary' => [
                'total_employees' => 0,
                'total_courses' => 0,
                'total_quiz_attempts' => 0,
                'average_score' => 0,
                'completion_rate' => 0
            ]
        ];

        $totalScore = 0;
        $totalAttempts = 0;
        $totalCompletedCourses = 0;
        $totalEnrolledCourses = 0;

        foreach ($employees as $employee) {
            $employeeData = [
                'info' => [
                    'name' => $employee->name,
                    'email' => $employee->email,
                    'nik' => $employee->nik,
                    'division' => $employee->division,
                    'position' => $employee->position
                ],
                'courses' => [],
                'quiz_performance' => [
                    'total_attempts' => 0,
                    'average_score' => 0,
                    'passed_quizzes' => 0,
                    'failed_quizzes' => 0
                ],
                'overall_performance' => [
                    'courses_enrolled' => 0,
                    'courses_completed' => 0,
                    'completion_percentage' => 0
                ]
            ];

            // Process course data
            foreach ($employee->courses as $course) {
                $courseEnrollment = CourseEmployee::where('user_id', $employee->id)
                    ->where('course_id', $course->id)
                    ->first();

                $courseProgress = $this->calculateCourseProgress($courseEnrollment);

                $employeeData['courses'][] = [
                    'name' => $course->name,
                    'status' => $courseProgress['status'],
                    'completion_percentage' => $courseProgress['percentage'],
                    'enrolled_at' => $courseEnrollment ? $courseEnrollment->enrolled_at : null,
                    'completed_at' => $courseProgress['completed_at']
                ];

                $employeeData['overall_performance']['courses_enrolled']++;
                if ($courseProgress['status'] === 'Selesai') {
                    $employeeData['overall_performance']['courses_completed']++;
                    $totalCompletedCourses++;
                }
                $totalEnrolledCourses++;
            }

            // Calculate course completion percentage
            if ($employeeData['overall_performance']['courses_enrolled'] > 0) {
                $employeeData['overall_performance']['completion_percentage'] =
                    ($employeeData['overall_performance']['courses_completed'] /
                     $employeeData['overall_performance']['courses_enrolled']) * 100;
            }

            // Process quiz attempts
            $quizScores = [];
            foreach ($employee->quizAttempts as $attempt) {
                if ($attempt->quiz) {
                    $quizScores[] = $attempt->score;
                    $employeeData['quiz_performance']['total_attempts']++;

                    if ($attempt->status === 'passed') {
                        $employeeData['quiz_performance']['passed_quizzes']++;
                    } else {
                        $employeeData['quiz_performance']['failed_quizzes']++;
                    }

                    $totalScore += $attempt->score;
                    $totalAttempts++;
                }
            }

            // Calculate average quiz score
            if (!empty($quizScores)) {
                $employeeData['quiz_performance']['average_score'] = array_sum($quizScores) / count($quizScores);
            }

            $reportData['employees'][] = $employeeData;
        }

        // Calculate summary
        $reportData['summary']['total_employees'] = count($employees);
        $reportData['summary']['total_courses'] = Course::when(
            $filters['course_filter'] === 'specific' && !empty($filters['course_ids']),
            function ($query) use ($filters) {
                return $query->whereIn('id', $filters['course_ids']);
            }
        )->count();

        $reportData['summary']['total_quiz_attempts'] = $totalAttempts;
        $reportData['summary']['average_score'] = $totalAttempts > 0 ? $totalScore / $totalAttempts : 0;
        $reportData['summary']['completion_rate'] = $totalEnrolledCourses > 0 ?
            ($totalCompletedCourses / $totalEnrolledCourses) * 100 : 0;

        return $reportData;
    }

    /**
     * Calculate course progress
     */
    private function calculateCourseProgress($courseEnrollment)
    {
        if (!$courseEnrollment) {
            return [
                'status' => 'Belum Dimulai',
                'percentage' => 0,
                'completed_at' => null
            ];
        }

        if ($courseEnrollment->is_completed) {
            return [
                'status' => 'Selesai',
                'percentage' => 100,
                'completed_at' => $courseEnrollment->updated_at
            ];
        }

        // Calculate progress based on video completions
        $videoCompletions = $courseEnrollment->video_completions ?? [];
        if (empty($videoCompletions)) {
            return [
                'status' => 'Belum Dimulai',
                'percentage' => 0,
                'completed_at' => null
            ];
        }

        // Get total videos in course (you might need to adjust this based on your Course model)
        $totalVideos = $courseEnrollment->course->course_videos_count ?? count($videoCompletions);
        $completedVideos = count(array_filter($videoCompletions));

        $percentage = $totalVideos > 0 ? ($completedVideos / $totalVideos) * 100 : 0;

        return [
            'status' => $percentage > 0 ? 'Sedang Berlangsung' : 'Belum Dimulai',
            'percentage' => round($percentage, 2),
            'completed_at' => null
        ];
    }

    /**
     * Generate filename for the report
     */
    private function generateFilename($filters)
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $courseFilter = $filters['course_filter'] === 'all' ? 'semua-kursus' : 'kursus-terpilih';
        $employeeFilter = $filters['employee_filter'] === 'all' ? 'semua-karyawan' : 'karyawan-terpilih';

        return "laporan-kinerja_{$courseFilter}_{$employeeFilter}_{$timestamp}.pdf";
    }

    /**
     * Preview data sebelum generate PDF
     */
    public function previewReport(Request $request)
    {
        try {
            $filters = $this->validateFilters($request);
            $reportData = $this->generateReportData($filters);

            return response()->json([
                'success' => true,
                'data' => $reportData,
                'message' => 'Data berhasil dimuat'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in PerformanceReportController@previewReport: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat preview data.'
            ], 500);
        }
    }
}
