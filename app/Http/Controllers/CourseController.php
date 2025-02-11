<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\Category;
use App\Models\Chapter; // Import Chapter model
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;  // Import Rule


class CourseController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil parameter filter dari request
        $search = $request->input('search');
        $category = $request->input('category');
        $sort = $request->input('sort', 'latest'); // Default ke 'latest'

        // Query dasar dengan relasi
        $query = Course::with(['category', 'teacher', 'employees']);

        // Filter berdasarkan role Teacher
        if ($user->hasRole('teacher')) {
            $query->whereHas('teacher', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        // Filter berdasarkan pencarian (search)
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Filter berdasarkan kategori
        if ($category) {
            $query->where('category_id', $category);
        }

        // Sorting
        if ($sort === 'oldest') {
            $query->orderBy('id', 'asc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $courses = $query->paginate(10);
        $categories = Category::all();

        return view('admin.courses.index', [
            'courses' => $courses,
            'categories' => $categories,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only allow teachers to create courses.  Get *all* teachers,
        // or restrict based on logged-in user, depending on your needs.
        $teachers = Teacher::with('user')->get(); // Or filter as needed.
        $categories = Category::all();

        return view('admin.courses.create', [
            'teachers' => $teachers,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        // No need to check for teacher here, validation is done in StoreCourseRequest.

        $validated = $request->validated();

        DB::transaction(function () use ($request, $validated) {

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            } else {
                $thumbnailPath = 'thumbnails/default.png'; // Consider removing this default.
            }
            $validated['thumbnail'] = $thumbnailPath;
            $validated['slug'] = Str::slug($validated['name']);

            // Handle demo video
            if ($validated['demo_video_storage'] === 'upload') {
                if ($request->hasFile('demo_video_source_file')) {
                    $validated['demo_video_source'] = $request->file('demo_video_source_file')->store('course_videos', 'public');
                } else {
                    $validated['demo_video_source'] = null; // Or handle the missing file case.
                }
            } // else:  demo_video_source is already set by the FormRequest.


            $course = Course::create($validated);

            if (!empty($validated['course_keypoints'])) {
                foreach ($validated['course_keypoints'] as $keypoint) {
                    if ($keypoint) {  // Prevent empty keypoints.
                        $course->keypoints()->create([
                            'name' => $keypoint
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['teacher', 'category', 'employees', 'chapters.videos']);

        $totalStudents = $course->employees->count();
        return view('admin.courses.show', [
            'course' => $course,
             'totalStudents' => $totalStudents
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        // Authorization check (already done in route, but good to have here too).
        if (Auth::user()->hasRole('teacher') && $course->teacher->user_id != Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $teachers = Teacher::with('user')->get(); // Or filter as needed
        $categories = Category::all();

        return view('admin.courses.edit', [
            'course' => $course,
            'teachers' => $teachers,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
{
    // Authorization check (already done in route).
    if (Auth::user()->hasRole('teacher') && $course->teacher->user_id != Auth::user()->id) {
        abort(403, 'Unauthorized action.');
    }

    $validated = $request->validated();

    DB::transaction(function () use ($request, $course, $validated) {

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']);

        // Handle demo video
        if ($validated['demo_video_storage'] === 'upload') {
            if ($request->hasFile('demo_video_source_file')) {
                // Delete old video, if it exists and is a file.
                if ($course->demo_video_source && $course->demo_video_storage === 'upload' && Storage::disk('public')->exists($course->demo_video_source)) {
                    Storage::disk('public')->delete($course->demo_video_source);
                }
                $validated['demo_video_source'] = $request->file('demo_video_source_file')->store('course_videos', 'public');
            }
        } else {
            // If changing from upload to link, delete the old file.
            if ($course->demo_video_storage === 'upload' && $course->demo_video_source && Storage::disk('public')->exists($course->demo_video_source)) {
                Storage::disk('public')->delete($course->demo_video_source);
            }
            // demo_video_source is already set by the FormRequest
        }

        $course->update($validated);

        // Sync keypoints (efficiently)
        $existingKeypoints = $course->keypoints->pluck('keypoint')->toArray();
        $newKeypoints = $request->input('course_keypoints', []);
        $keypointsToKeep = [];

        foreach ($newKeypoints as $keypoint) {
            if (!empty($keypoint)) {
                if (in_array($keypoint, $existingKeypoints)) {
                    $keypointsToKeep[] = $keypoint;  // Keep existing.
                } else {
                    $course->keypoints()->create(['keypoint' => $keypoint]); // Add new.
                    $keypointsToKeep[] = $keypoint;
                }
            }
        }

        $course->keypoints()->whereNotIn('keypoint', $keypointsToKeep)->delete(); // Delete removed.


    });

    return redirect()->route('admin.courses.show', $course)->with('success', 'Course updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
  public function destroy(Course $course)
    {
        if (Auth::user()->hasRole('teacher') && $course->teacher->user_id != Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }
        DB::beginTransaction();
        try {
            // Delete associated resources first!  This is crucial.
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            if ($course->demo_video_source && $course->demo_video_storage === "upload") {
                Storage::disk('public')->delete($course->demo_video_source);
            }

            $course->keypoints()->delete(); // Delete keypoints.
            $course->chapters()->delete();   // Delete chapters (and their videos).
            $course->employees()->detach(); // Detach employees.
            $course->delete();          // Finally, delete the course.

            DB::commit();
            return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error deleting course: " . $e->getMessage()); // Log the error
            return redirect()->route('admin.courses.index')->with('error', 'Error occurred, please try again later.  Details: ' . $e->getMessage());
        }
    }

    // Logic Untuk Chapter
    public function createChapterModal(Course $course)
    {
        // Authorization: Ensure the teacher owns the course.
        if (Auth::user()->hasRole('teacher') && $course->teacher->user_id != Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.courses.create-chapter', compact('course'));
    }

    public function storeChapter(Request $request, Course $course)
    {
          // Authorization: Ensure the teacher owns the course.
        if (Auth::user()->hasRole('teacher') && $course->teacher->user_id != Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name' => 'required|string',
            'order' => 'nullable|integer|min:0',
        ]);

        // Determine the order.  If not provided, place it at the end.
        $order = $request->input('order');
        if ($order === null) {
            $order = $course->chapters()->max('order') + 1;
        }

        $chapter = $course->chapters()->create([
            'name' => $request->name,
            'order' => $order, // Use the determined order.
            'slug' => Str::slug($request->name)
        ]);


        return redirect()->route('admin.courses.show', $course)->with('success', 'Chapter created successfully');
    }

    public function editChapterModal(Chapter $chapter)
    {
         // Authorization: Ensure the teacher owns the course.
        if (Auth::user()->hasRole('teacher') && $chapter->course->teacher->user_id != Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.courses.edit-chapter', compact('chapter'));
    }

    public function updateChapter(Request $request, Chapter $chapter)  // Corrected method name
{
    // Authorization: Ensure the teacher owns the course.
    if (Auth::user()->hasRole('teacher') && $chapter->course->teacher->user_id != Auth::user()->id) {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'name' => 'required|string',
        'order' => 'nullable|integer|min:0',
    ]);

    $chapter->update([
        'name' => $request->name,
        'order' => $request->order,
        'slug' => Str::slug($request->name)
    ]);

    return redirect()->route('admin.courses.show', $chapter->course)->with('success', 'Chapter updated successfully');
}

    public function destroyChapter(Chapter $chapter)
    {
         // Authorization: Ensure the teacher owns the course.
        if (Auth::user()->hasRole('teacher') && $chapter->course->teacher->user_id != Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }
        $course = $chapter->course;

        // Delete associated videos FIRST.
        foreach ($chapter->videos as $video) {
             if ($video->path_video && Storage::disk('public')->exists($video->path_video)) {
                  Storage::disk('public')->delete($video->path_video);
             }
            $video->delete();
        }

        $chapter->delete();

        return redirect()->route('admin.courses.show', $course)->with('success', 'Chapter deleted successfully');
    }

    // Employee Enroll logic
    public function enrollCourse(Request $request, Course $course)
    {
        $user = Auth::user();

        // Removed the isPro() check.  You can implement a different
        // authorization method (e.g., a permission check) if needed.

        // Check if user already enrolled (either approved or pending).
        if ($course->employees()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'You are already enrolled or have a pending enrollment request for this course.');
        }

        // Attach with is_approved = false (pending).
        $course->employees()->attach($user, ['enrolled_at' => now(), 'is_approved' => false]);

        return back()->with('success', 'Enrollment request sent successfully. Please wait for approval.');
    }
    // Approve course
    public function updateApproval(Request $request, Course $course)
    {
        // Authorization check (usually, only admins or teachers of the course can approve).
        if (!Auth::user()->hasRole('admin') && !(Auth::user()->hasRole('teacher') && $course->teacher->user_id == Auth::user()->id))
        {
             abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'is_approved' => 'required|boolean',
        ]);

        $userId = $request->user_id;
        $isApproved = $request->is_approved;

        // Ensure the user is actually enrolled.
        if (!$course->employees()->where('user_id', $userId)->exists()) {
            return back()->with('error', 'User is not enrolled in this course.');
        }

        $course->employees()->updateExistingPivot($userId, ['is_approved' => $isApproved]);

        return back()->with('success', 'User enrollment status updated successfully.');
    }
}
