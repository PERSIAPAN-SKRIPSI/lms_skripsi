<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $query = Course::with(['category', 'teacher', 'employee'])->orderByDesc('id');

        if ($user->hasRole('teacher')) {
            $query->whereHas('teacher', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $courses = $query->paginate(10);

        return view('admin.courses.index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers   = Teacher::all();
        $categories = Category::all();

        return view('admin.courses.create', [
            'teachers'   => $teachers,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();
     // Mengecek apakah course berhasil disimpan
        $teacher = Teacher::where('user_id', Auth::user()->id)->first();

        if (!$teacher) {
            return redirect()->route('admin.courses.index')->withErrors('Unaouthorized or invalid teacher');
        }

        try {
            DB::transaction(function () use ($request, $teacher) {
                $validated = $request->validated();

                if ($request->hasFile('thumbnail')) {
                    $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                } else {
                    $thumbnailPath = 'thumbnails/default.png'; // fallback jika tidak ada gambar
                }


                $validated['slug'] = Str::slug($validated['name']);
                $validated['thumbnail'] = $thumbnailPath;
                $validated['teacher_id'] = $teacher->id;

                $course = Course::create($validated);

                if (!empty($validated['course_keypoints'])) {
                    foreach ($validated['course_keypoints'] as $keypoint) {
                        $course->keypoints()->create(['name' => $keypoint]);
                    }
                }
            });
            return redirect()->route('admin.courses.index')->with('success', 'Course created successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.courses.index')->withErrors('Error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('admin.courses.show', [
            'course' => $course
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $teachers   = Teacher::all();
        $categories = Category::all();

        return view('admin.courses.edit', [
            'course'     => $course,
            'teachers'   => $teachers,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        DB::transaction(function () use ($request, $course) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                if ($course->thumbnail) {
                    Storage::disk('public')->delete($course->thumbnail);
                }
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail']  = $thumbnailPath;
            }

            $validated['slug'] = Str::slug($validated['name']);

            $course->update($validated);

            if (!empty($validated['course_keypoints'])) {
                $course->keypoints()->delete();
                foreach ($validated['course_keypoints'] as $keypoint) {
                    $course->keypoints()->create([
                        'name' => $keypoint
                    ]);
                }
            }
        });

        return redirect()->route('admin.courses.show', $course)->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        DB::beginTransaction();
        try {
            $course->delete();
            DB::commit();
            return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.courses.index')->with('error', 'Error occurred, please try again later');
        }
    }
}
