<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    //
    /**
     * Menampilkan halaman beranda dengan daftar kursus yang tersedia
     */   public function index()
    {
        $categories = Category::all();
        $courses    = Course::all();
        return view('frontend.index', [
            'categories' => $categories,
            'courses'    => $courses,
        ]);
    }

    public function category(Category $category)
    {
        return view('frontend.category', [
            'category' => $category
        ]);
    }
    /**
     * Halaman checkout untuk kursus menggunakan koin.
     */
}
