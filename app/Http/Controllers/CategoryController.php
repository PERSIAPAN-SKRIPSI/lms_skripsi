<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderByDesc('id')->get();
        return view('admin.categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {


        DB::transaction(function () use ($request) {
            //untuk memvalidasi sebuah request yang ada di storecategory
            $validated = $request->validated();

            $iconPath = $request->file('icon')->store('icons', 'public');
            $validated['icon'] = $iconPath;

            $category = Category::create($validated + ['slug' => Str::slug($validated['name'])]);
        });

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori baru berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $courses = $category->courses()->paginate(10); // Mengambil daftar kursus yang ada di kategori tersebut
        return view('admin.categories.show', compact('category', 'courses')); // Mengirimkan data ke view
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        DB::transaction(function () use ($request, $category) {
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }

            $iconPath = $request->file('icon')->store('icons', 'public');
            $validated['icon'] = $iconPath;

            $validated['slug'] = Str::slug($validated['name']);
            $category->update($validated);
        });

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
