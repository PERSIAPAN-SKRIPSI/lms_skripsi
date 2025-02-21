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
        $categories = Category::whereNull('parent_id')
            ->withCount('courses') // Eager load jumlah kursus (opsional)
            ->get();

        $courses = Course::all(); //  Anda mungkin ingin membatasi atau mengurutkan ini

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
    public function CourseDetail(Course $course)
    {
        $course->load([
            'teacher.user',
            'chapters.videos',
            'keypoints',
            'category'
        ]);

        // Hanya tampilkan teacher yang aktif
        if ($course->teacher && !$course->teacher->is_active) {
            $course->teacher = null;
        }

        $categories = Category::whereNull('parent_id')
            ->withCount('courses')
            ->get();

        return view('frontend.pages.sections.course-detail', [
            'course' => $course,
            'categories' => $categories,
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
