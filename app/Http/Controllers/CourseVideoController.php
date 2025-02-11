<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\Chapter; // Pastikan model Chapter di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCourseVideoRequest;

class CourseVideoController extends Controller
{
    public function index()
    {
        return;
    }

    public function create(Course $course)
    {
        $chapters = $course->chapters;
        return view('admin.course_videos.create', [
            'course' => $course,
            'chapters' => $chapters,
        ]);
    }


    public function store(StoreCourseVideoRequest $request, Course $course)
    {
        return DB::transaction(function () use ($request, $course) {

            $validated = $request->validated();
            $validated['course_id'] = $course->id;
            $validated['chapter_id'] = $request->input('chapter_id');

            // Tidak perlu menangani upload file!
            CourseVideo::create($validated);

            return redirect()->route('admin.courses.show', $course)
                ->with('success', 'Course video created successfully');
        });
    }


    public function show(CourseVideo $courseVideo)
    {
        // return view(...) //JIKA dibutuhkan
    }


    public function edit(Course $course, CourseVideo $video)
{
    // Ensure the video belongs to the specified course
    if ($video->course_id !== $course->id) {
        abort(404);
    }

    $chapters = $course->chapters;

    return view('admin.course_videos.edit', [
        'courseVideo' => $video,
        'course' => $course,
        'chapters' => $chapters,
    ]);
}
    public function update(StoreCourseVideoRequest $request, Course $course, CourseVideo $video)
    {
        return DB::transaction(function () use ($request, $course, $video) {
            $validated = $request->validated();

             // Tidak perlu menangani upload file!
            $video->update($validated);
            return redirect()->route('admin.courses.show',  $video->course)
                ->with('success', 'Course video updated successfully');

        });

    }

    public function destroy(Course $course, CourseVideo $video)
   {
    DB::beginTransaction();
    try{
       $video->delete();
       DB::commit();
      return redirect()->route('admin.courses.show', $video->course)
                ->with('success', 'Video successfully deleted');
    }catch(\Exception $e){
       DB::rollBack();
      return redirect()->route('admin.courses.show', $video->course)
            ->with('error', 'Something went wrong');
       }
    }
}
