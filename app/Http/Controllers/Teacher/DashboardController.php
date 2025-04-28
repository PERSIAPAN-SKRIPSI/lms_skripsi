<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEmployee;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the teacher dashboard.
     */
    public function index(): View
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            Log::error('Teacher record not found for user: ' . Auth::id());
            return view('admin.teachers.dashboard', [
                'error' => 'Profil Guru tidak ditemukan. Silakan hubungi administrator.',
                'totalCourses' => 0,
                'activeCourses' => 0,
                'completedCourses' => 0,
                'recentCourses' => collect(),
                'studentsCount' => 0
            ]);
        }

        try {
            // Get all courses by this teacher
            $courses = Course::where('teacher_id', $teacher->id)->get();
            $totalCourses = $courses->count();

            // For active courses, we'll count those with enrolled students
            $coursesWithStudents = $courses->filter(function($course) {
                return $course->employees()->count() > 0;
            });
            $activeCourses = $coursesWithStudents->count();

            // For completed courses, count courses where at least one student has completed it
            $completedCourses = 0;
            foreach ($courses as $course) {
                $hasCompletedStudents = CourseEmployee::where('course_id', $course->id)
                    ->where('is_completed', 1)
                    ->exists();

                if ($hasCompletedStudents) {
                    $completedCourses++;
                }
            }

            $recentCourses = Course::where('teacher_id', $teacher->id)
                ->latest('created_at')
                ->take(5)
                ->get();

            // Get total students enrolled in this teacher's courses
            $studentsCount = 0;
            foreach ($courses as $course) {
                $studentsCount += $course->employees()->count();
            }

        } catch (\Exception $e) {
            Log::error('Failed to retrieve course data for teacher: ' . json_encode($teacher) . ' - ' . $e->getMessage());
            return view('admin.teachers.dashboard', [
                'error' => 'Terjadi kesalahan saat mengambil data kursus. Silakan coba lagi nanti.',
                'totalCourses' => 0,
                'activeCourses' => 0,
                'completedCourses' => 0,
                'recentCourses' => collect(),
                'studentsCount' => 0
            ]);
        }

        return view('admin.teachers.dashboard', [
            'totalCourses' => $totalCourses,
            'activeCourses' => $activeCourses,
            'completedCourses' => $completedCourses,
            'recentCourses' => $recentCourses,
            'studentsCount' => $studentsCount,
        ]);
    }
}
