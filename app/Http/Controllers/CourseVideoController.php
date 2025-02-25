<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCourseVideoRequest; // Gunakan request yang sudah dibuat
use Google_Client;
use Google_Service_YouTube;
use Illuminate\Support\Facades\Log;

class CourseVideoController extends Controller
{
    public function index()
    {
        $videos = CourseVideo::with(['course', 'chapter'])->latest()->get();
        return view('admin.course_videos.index', compact('videos'));
    }

    public function create(Course $course)
    {
        $chapters = $course->chapters;
        return view('admin.course_videos.create', [
            'course' => $course,
            'chapters' => $chapters,
        ]);
    }


    public function show(Course $course, CourseVideo $video)
    {
        if ($video->course_id !== $course->id) {
            abort(404);
        }

        return view('admin.course_videos.show', [
            'course' => $course,
            'video' => $video
        ]);
    }

    public function edit(Course $course, CourseVideo $video)
    {
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



    public function destroy(Course $course, CourseVideo $video)
    {
        try {
            DB::beginTransaction();

            if ($video->course_id !== $course->id) {
                throw new \Exception('Invalid video for this course');
            }

            $video->delete();

            DB::commit();

            return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Video successfully deleted');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.courses.show', $course)
            ->with('error', 'Failed to delete video: ' . $e->getMessage());
        }
    }

    public function store(Request $request, Course $course)
    {
        try {
            return DB::transaction(function () use ($request, $course) {
                // Validate basic fields
                $validated = $request->validate([
                    'name' => ['required', 'string', 'min:3', 'max:255'],
                    'path_video' => ['required', 'string', 'max:255'], // Pastikan validasi tetap ada
                    'chapter_id' => 'required|exists:chapters,id',
                ]);

                $validated['course_id'] = $course->id;

                // Extract or validate YouTube video ID
                $videoId = $this->getYoutubeVideoId($validated['path_video']);
                if (!$videoId) {
                    throw new \Exception('Invalid YouTube URL or ID provided');
                }

                // Get video duration
                $duration = $this->getYoutubeVideoDuration($videoId);
                if (!$duration) {
                    throw new \Exception('Could not fetch video duration');
                }

                // Add duration to validated data
                $validated['duration'] = $this->convertDurationToSeconds($duration);
                $validated['path_video'] = $videoId; // Simpan ID video saja

                // Create the video record
                $video = CourseVideo::create($validated);

                return redirect()->route('admin.courses.show', $course)
                    ->with('success', 'Course video created successfully. Duration: ' . $this->formatDuration($validated['duration']));
            });
        } catch (\Exception $e) {
            Log::error('Error creating video:', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Failed to create video: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, Course $course, CourseVideo $video)
    {
        try {
            return DB::transaction(function () use ($request, $course, $video) {
                // Validate basic fields
                $validated = $request->validate([
                    'name' => ['required', 'string', 'min:3', 'max:255'],
                    'path_video' => ['required', 'string', 'max:255'],
                    'chapter_id' => 'required|exists:chapters,id',
                ]);

                // Extract or validate YouTube video ID
                $videoId = $this->getYoutubeVideoId($validated['path_video']);
                if (!$videoId) {
                    throw new \Exception('Invalid YouTube URL or ID provided');
                }

                // Check if video ID changed OR if duration is missing
                if ($video->path_video !== $videoId || !$video->duration) {
                    $duration = $this->getYoutubeVideoDuration($videoId);
                    if (!$duration) {
                        throw new \Exception('Could not fetch video duration');
                    }

                    $validated['duration'] = $this->convertDurationToSeconds($duration);
                } else {
                    // If video ID is the same and duration exists, keep the old duration
                    $validated['duration'] = $video->duration;
                }

                $validated['path_video'] = $videoId; // Simpan ID video saja
                $video->update($validated);

                return redirect()->route('admin.courses.show', $course)
                    ->with('success', 'Course video updated successfully. Duration: ' . $this->formatDuration($video->duration));
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update video: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function getYoutubeVideoId($url)
    {
        // Check if the URL is an ID (11 characters)
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url; // Return the URL as ID
        }

        $patterns = [
            '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=))([a-zA-Z0-9_-]{11})/',
            '/(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            '/(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
    private function getYoutubeVideoDuration($videoId)
    {
        try {
            $client = new Google_Client();
            $client->setDeveloperKey(config('services.youtube.api_key'));

            $youtube = new Google_Service_YouTube($client);
            $response = $youtube->videos->listVideos('contentDetails', ['id' => $videoId]);

            if (empty($response->items)) {
                Log::error('No video details found for ID: ' . $videoId);
                return null;
            }

            return $response->items[0]->contentDetails->duration;
        } catch (\Exception $e) {
            Log::error('YouTube API Error:', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function convertDurationToSeconds($youtubeDuration)
    {
        preg_match('/PT(\d+H)?(\d+M)?(\d+S)?/', $youtubeDuration, $matches);

        $hours = isset($matches[1]) ? intval(trim($matches[1], 'H')) : 0;
        $minutes = isset($matches[2]) ? intval(trim($matches[2], 'M')) : 0;
        $seconds = isset($matches[3]) ? intval(trim($matches[3], 'S')) : 0;

        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }

    public function formatDuration($seconds)
    {
        if ($seconds < 60) {
            return sprintf("0:%02d", $seconds);
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        if ($minutes < 60) {
            return sprintf("%d:%02d", $minutes, $remainingSeconds);
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        return sprintf("%d:%02d:%02d", $hours, $remainingMinutes, $remainingSeconds);
    }

}
