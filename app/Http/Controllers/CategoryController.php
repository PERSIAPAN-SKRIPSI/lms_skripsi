<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query()->whereNull('parent_id')->orderByDesc('id'); // Start with parent categories

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter by subcategories (yes/no/all)
        if ($request->filled('has_subcategories')) {
            if ($request->input('has_subcategories') === 'yes') {
                $query->has('children'); // Categories WITH subcategories
            } elseif ($request->input('has_subcategories') === 'no') {
                $query->doesntHave('children'); // Categories WITHOUT subcategories
            }
            // 'all' case is handled by not adding any constraint
        }

        // Eager load the 'children' relationship to avoid N+1 query problems
        // when displaying the number of subcategories in the view.
        $categories = $query->with('children')->paginate(10)->withQueryString(); // Paginate with filter parameters

        return view('admin.categories.index', compact('categories'));
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
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            // Handle Icon - Bisa file upload atau URL
            if ($request->hasFile('icon_file')) {
                $validated['icon'] = $request->file('icon_file')->store('icons', 'public');
            } elseif ($request->filled('icon_url')) {
                $validated['icon'] = $request->icon_url;
            }

            // Handle Image - Bisa file upload atau URL
            if ($request->hasFile('image_file')) {
                $validated['image'] = $request->file('image_file')->store('images', 'public');
            } elseif ($request->filled('image_url')) {
                $validated['image'] = $request->image_url;
            }

            // Hapus key yang tidak digunakan
            unset($validated['icon_file'], $validated['icon_url'], $validated['image_file'], $validated['image_url']);

            Category::create($validated + ['slug' => Str::slug($validated['name'])]);
        });

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $courses = $category->courses()->paginate(10);
        return view('admin.categories.show', compact('category', 'courses'));
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
    // Di CategoryController, method update
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        DB::transaction(function () use ($request, $category) {
            $validated = $request->validated();

            // Handle Icon
            if ($request->hasFile('icon_file')) {
                // Hapus icon lama jika ada
                if ($category->icon && !filter_var($category->icon, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($category->icon);
                }
                $validated['icon'] = $request->file('icon_file')->store('icons', 'public');
            } elseif ($request->filled('icon_url')) {
                // Hapus icon lama jika ada
                if ($category->icon && !filter_var($category->icon, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($category->icon);
                }
                $validated['icon'] = $request->icon_url;
            }

            // Handle Image
            if ($request->hasFile('image_file')) {
                // Hapus image lama jika ada
                if ($category->image && !filter_var($category->image, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($category->image);
                }
                $validated['image'] = $request->file('image_file')->store('images', 'public');
            } elseif ($request->filled('image_url')) {
                // Hapus image lama jika ada
                if ($category->image && !filter_var($category->image, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($category->image);
                }
                $validated['image'] = $request->image_url;
            }

            $validated['slug'] = Str::slug($validated['name']);

            // Hapus key yang tidak digunakan
            unset($validated['icon_file'], $validated['icon_url'], $validated['image_file'], $validated['image_url']);

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
        DB::transaction(function () use ($category) {
            // Delete related file on storage
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            // Delete related data
            $category->delete();
        });

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Show form to index new sub-category
     */
    /**
     * Show form to index new sub-category
     */
    public function subIndex(Category $category)
    {
        $subCategories = $category->children()->latest()->get();
        return view('admin.categories.sub-categories.index', compact('category', 'subCategories'));
    }

    /**
     * Show form to create new sub-category
     */
    public function subCreate(Category $category)
    {
        $subCategories = $category->children()->latest()->get(); // Tambahkan ini
        return view('admin.categories.sub-categories.create', compact('category', 'subCategories')); // dan ini
    }

    /**
     * Store new sub-category
     */
    /**
     * Store new sub-category
     */
    public function subStore(Request $request, Category $category)
    {
        // Validasi untuk mendukung file dan URL
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url',
        ]);

        DB::transaction(function () use ($request, $category, $validated) {
            $createData = [
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'parent_id' => $category->id
            ];

            // Handle Icon
            if ($request->hasFile('icon_file')) {
                $createData['icon'] = $request->file('icon_file')->store('icons', 'public');
            } elseif ($request->filled('icon_url')) {
                $createData['icon'] = $request->icon_url;
            }

            // Handle Image
            if ($request->hasFile('image_file')) {
                $createData['image'] = $request->file('image_file')->store('images', 'public');
            } elseif ($request->filled('image_url')) {
                $createData['image'] = $request->image_url;
            }

            $category->children()->create($createData);
        });

        return redirect()->route('admin.categories.sub-categories.index', $category)
            ->with('success', 'Sub-kategori berhasil ditambahkan.');
    }

    /**
     * Show form to edit sub-category
     */
    public function subEdit(Category $category, string $subCategorySlug)
    {
        // Mengambil sub-category berdasarkan slug
        try {
            $subCategory = $category->children()->where('slug', $subCategorySlug)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404, 'Sub kategori tidak ditemukan');
        }

        return view('admin.categories.sub-categories.edit', compact('category', 'subCategory'));
    }

    /**
     * Update sub-category
     */
    // Di CategoryController, method update
    public function subUpdate(Request $request, Category $category, string $subCategorySlug)
    {
        try {
            $subCategory = $category->children()->where('slug', $subCategorySlug)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404, 'Sub kategori tidak ditemukan');
        }

        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url',
        ]);

        DB::transaction(function () use ($request, $subCategory, $validated) {
            $updateData = [
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name'])
            ];

            // Handle Icon
            if ($request->hasFile('icon_file')) {
                // Jika ada file upload baru
                if ($subCategory->icon && Storage::disk('public')->exists($subCategory->icon)) {
                    Storage::disk('public')->delete($subCategory->icon);
                }
                $updateData['icon'] = $request->file('icon_file')->store('icons', 'public');
            } elseif ($request->filled('icon_url')) {
                // Jika ada URL baru
                $updateData['icon'] = $request->icon_url;
            }

            // Handle Image
            if ($request->hasFile('image_file')) {
                // Jika ada file upload baru
                if ($subCategory->image && Storage::disk('public')->exists($subCategory->image)) {
                    Storage::disk('public')->delete($subCategory->image);
                }
                $updateData['image'] = $request->file('image_file')->store('images', 'public');
            } elseif ($request->filled('image_url')) {
                // Jika ada URL baru
                $updateData['image'] = $request->image_url;
            }

            $subCategory->update($updateData);
        });

        return redirect()->route('admin.categories.sub-categories.index', $category)
            ->with('success', 'Sub-kategori berhasil diperbarui.');
    }

    /**
     * Delete sub-category
     */
    // Hapus Sub-Kategori
    public function subDestroy(Category $category, $subCategorySlug)
    {
        $subCategory = Category::where('parent_id', $category->id)
            ->where('slug', $subCategorySlug)
            ->firstOrFail();

        DB::transaction(function () use ($subCategory) {
            if ($subCategory->icon) {
                Storage::disk('public')->delete($subCategory->icon);
            }
            if ($subCategory->image) {
                Storage::disk('public')->delete($subCategory->image);
            }
            $subCategory->delete();
        });

        return redirect()->route('admin.categories.sub-categories.index', $category)
            ->with('success', 'Sub-category deleted successfully.');
    }
}
