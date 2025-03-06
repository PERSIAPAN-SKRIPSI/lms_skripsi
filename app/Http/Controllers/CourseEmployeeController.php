<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEmployee;
use App\Models\Chapter;
use App\Models\CourseVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CourseEmployeeController extends Controller
{

    public function index(): View
    {
        $employeeId = Auth::id();
        $enrolledCourses = CourseEmployee::with('course')
            ->where('user_id', $employeeId)
            ->where('is_approved', true)
            ->get();

        return view('employees-dashboard.courses.index', compact('enrolledCourses'));
    }

    public function show(Course $course): View
    {
        $employeeId = Auth::id();
        $isEnrolled = CourseEmployee::where('user_id', $employeeId)
            ->where('course_id', $course->id)
            ->where('is_approved', true)
            ->exists();

        if (!$isEnrolled) {
            abort(403, 'Anda tidak terdaftar dalam kursus ini.');
        }

        return view('employees-dashboard.courses.show', compact('course'));
    }


    public function learn(Course $course): View
    {
        $employeeId = Auth::id();

        $isEnrolled = CourseEmployee::where('user_id', $employeeId)
            ->where('course_id', $course->id)
            ->where('is_approved', true)
            ->exists();

        // dd($isEnrolled, $employeeId, $course->id); // Tambahkan dd() di sini

        if (!$isEnrolled) {
            abort(403, 'Anda tidak terdaftar dalam kursus ini.');
        }

        $chapters = Chapter::with('videos')->where('course_id', $course->id)->orderBy('order')->get();
        $firstVideo = $chapters->first()->videos->first();
        return view('employees-dashboard.learn.course-player', compact('course', 'chapters', 'firstVideo'));
    }


    public function enroll(Request $request, Course $course)
    {
        $employee = Auth::user();

        $isEnrolled = CourseEmployee::where('user_id', $employee->id)
            ->where('course_id', $course->id)
            ->exists();

        if ($isEnrolled) {
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
            return Redirect::back()->with('error', 'Terjadi kesalahan saat mendaftar kursus. Silakan coba lagi.');
        }
    }

    public function getLessonContent(Request $request)
    {
        $videoId = $request->input('video_id');

        $video = CourseVideo::find($videoId);

        if (!$video) {
            return response()->json(['error' => 'Video tidak ditemukan.'], 404);
        }

        return response()->json(['video' => $video]);
    }

    public function updateWatchHistory(Request $request)
    {
        $videoId = $request->input('video_id');
        $userId = Auth::id();
        $currentTime = $request->input('current_time');

        $courseVideo = CourseVideo::find($videoId);

        if (!$courseVideo) {
            return response()->json(['error' => 'Video not found'], 404);
        }

        $course = $courseVideo->course;

        $isEnrolled = CourseEmployee::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->where('is_approved', true)
            ->exists();

        if (!$isEnrolled) {
            return response()->json(['error' => 'Anda tidak terdaftar dalam kursus ini.'], 403);
        }

        return response()->json(['message' => 'Watch history updated successfully']);
    }

    public function updateLessonCompletion(Request $request)
    {
        $videoId = $request->input('video_id');
        $userId = Auth::id();

        $courseVideo = CourseVideo::find($videoId);

        if (!$courseVideo) {
            return response()->json(['error' => 'Video not found'], 404);
        }

        $course = $courseVideo->course;

        $isEnrolled = CourseEmployee::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->where('is_approved', true)
            ->exists();

        if (!$isEnrolled) {
            return response()->json(['error' => 'Anda tidak terdaftar dalam kursus ini.'], 403);
        }
        return response()->json(['message' => 'Lesson completed successfully']);
    }
}
