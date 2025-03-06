<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\CourseEmployee;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
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

        return view('employees-dashboard.dashboard', compact(
            'enrolledCoursesCount',
            'activeCoursesCount',
            'pendingCoursesCount',
            'totalCoursesCreated'
        ));
    }

    public function learningProgressIndex(): View
    {
        $employeeId = Auth::id();

        $enrolledCourses = CourseEmployee::with('course')
            ->where('user_id', $employeeId)
            ->where('is_approved', true)
            ->get();

        return view('employees-dashboard.learn.learning-progress', compact('enrolledCourses'));
    }
}
