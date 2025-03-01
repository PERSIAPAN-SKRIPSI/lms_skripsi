<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import untuk error handling

class FrontendController extends Controller
{
    /**
     * Menampilkan halaman beranda dengan daftar kursus yang tersedia
     */
    public function index()
    {
        // Ambil kategori parent yang memiliki setidaknya satu kursus terkait
        $categories = Category::whereNull('parent_id')
            ->has('courses')
            ->withCount('courses')
            ->get();

        // Ambil semua kursus, eager load teacher, dan hitung videos dan employees
        $courses = Course::with('teacher')
            ->withCount('videos') // Hitung jumlah videos (lessons)
            ->withCount('employees') // Hitung jumlah employees (students) yang enrolled
            ->latest() // Tambahkan latest() untuk urutan terbaru (opsional)
            ->get();

        return view('frontend.pages.index', [
            'categories' => $categories,
            'courses' => $courses,
        ]);
    }

    /**
     * Menampilkan halaman daftar kategori
     */
    public function Category()
    {
        // Ambil kategori induk saja, dengan jumlah kursus dan subkategorinya
        $categories = Category::withCount('courses')
            ->with([
                'children' => function ($query) {
                    $query->withCount('courses'); // Eager load jumlah kursus untuk subkategori
                }
            ])
            ->whereNull('parent_id') // Hanya kategori induk
            ->latest()
            ->paginate(12);

        return view('frontend.pages.sections.category', compact('categories'));
    }



    /**
     * Menampilkan halaman detail kategori dengan daftar kursus yang tersedia dalam kategori tersebut
     *  dan juga sub kategorinya
     */
    public function CategoryDetail(string $categorySlug)
    {
        try {
            // Coba ambil kategori berdasarkan slug, termasuk subkategori jika ada.
            $category = Category::with([
                'children' => function ($query) {
                    $query->withCount('courses'); // Hitung kursus di subkategori
                }
            ])
                ->where('slug', $categorySlug)
                ->firstOrFail();

            // Ambil kursus untuk kategori ini *dan* subkategorinya
            $courses = Course::with('teacher.user', 'category') // Load the category relationship
                ->withCount('students')
                ->where(function ($query) use ($category) {
                    $query->where('category_id', $category->id)
                        ->orWhereIn('category_id', $category->children->pluck('id'));
                })
                ->paginate(12);

            $categories = Category::with('children')->where('parent_id', null)->get(); // Add this line

            return view('frontend.pages.sections.category-detail', compact('category', 'courses', 'categories')); // Update to include categories

        } catch (ModelNotFoundException $e) {
            // Handle jika kategori tidak ditemukan
            abort(404, 'Category not found');
        }
    }
/**
 * Prepare demo videos for course detail page
 *
 * @param Course $course
 * @return array
 */
private function prepareDemoVideos(Course $course)
{
    $chapterDemoVideos = [];
    $maxDemoDuration = 120; // 2 menit dalam detik

    foreach ($course->chapters as $chapter) {
        $firstVideo = $chapter->videos->first();

        if ($firstVideo) {
            // Batasi durasi video menjadi maksimal 2 menit
            $endTime = min($firstVideo->duration, $maxDemoDuration);

            // Buat URL dengan parameter waktu
            $videoUrl = "https://www.youtube.com/embed/{$firstVideo->path_video}?start=0&end={$endTime}";

            $chapterDemoVideos[] = [
                'chapter_name' => $chapter->name,
                'video_id' => $firstVideo->path_video,
                'video_name' => $firstVideo->name,
                'video_url' => $videoUrl,
                'duration' => $endTime,
                'duration_formatted' => $this->formatDurationForDisplay($endTime)
            ];
        }
    }

    return $chapterDemoVideos;
}

/**
 * Format duration in seconds to readable format
 *
 * @param int $seconds
 * @return string
 */
private function formatDurationForDisplay($seconds)
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

/**
 * Course detail page with demo videos
 */
public function CourseDetail(Course $course)
{
    $course->load([
        'teacher.user',
        'chapters.videos',
        'keypoints',
        'category'
    ]);

    // Hitung jumlah course yang dibuat oleh teacher
    if ($course->teacher) {
        $course->teacher->courses_count = Course::where('teacher_id', $course->teacher->id)->count();
    }

    // Hanya tampilkan teacher yang aktif
    if ($course->teacher && !$course->teacher->is_active) {
        $course->teacher = null;
    }

    $categories = Category::whereNull('parent_id')
        ->withCount('courses')
        ->get();

    // Siapkan video demo
    $chapterDemoVideos = $this->prepareDemoVideos($course);

    return view('frontend.pages.sections.course-detail', [
        'course' => $course,
        'categories' => $categories,
        'chapterDemoVideos' => $chapterDemoVideos,
    ]);
}
/**
 * Menampilkan halaman detail kursus.
 */


    /**
     * Menampilkan halaman daftar subkategori (opsional).
     */
    public function subcategory(string $categorySlug) // Ubah parameter menjadi slug
    {
        try {
            $category = Category::where('slug', $categorySlug)->firstOrFail(); // Ambil category

            // Pastikan $category adalah subkategori (memiliki parent_id)
            if ($category->parent_id === null) {
                abort(404, 'Subcategory not found'); // Atau redirect ke halaman kategori induk
            }


            $subcategories = $category->children()->withCount('courses')->get();


            // return view('frontend.pages.subcategory', compact('category', 'subcategories')); // Ganti ke view yang benar
            return view('frontend.pages.category-detail', compact('category', 'subcategories'));

        } catch (ModelNotFoundException $e) {
            abort(404, 'Subcategory not found');
        }
    }
}
