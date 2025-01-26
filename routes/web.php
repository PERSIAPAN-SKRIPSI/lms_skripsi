<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscribeTransactionController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/courses/{slug}', [FrontendController::class, 'showCourse'])->name('course.show');
Route::get('/category/{category:slug}', [FrontendController::class, 'category'])->name('frontend.category');

// Dashboard (requires authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout Routes
    Route::get('/checkout/{course}', [FrontendController::class, 'checkout'])->name('frontend.checkout');
    Route::post('/checkout/{course}/store', [FrontendController::class, 'checkoutStore'])->name('frontend.checkout.store');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin|teacher')->group(function () {

      // Category Routes (Admin only)
      Route::resource('categories', CategoryController::class)->middleware('role:admin');
       // Subcategories Routes (Admin only)
        Route::get('/categories/{category}/sub-categories', [CategoryController::class, 'subCategoriesIndex'])->middleware('role:admin')->name('categories.sub-categories.index');
        Route::get('/categories/{category}/sub-categories/create', [CategoryController::class, 'subCategoriesCreate'])->middleware('role:admin')->name('categories.sub-categories.create');
        Route::post('/categories/{category}/sub-categories', [CategoryController::class, 'subCategoriesStore'])->middleware('role:admin')->name('categories.sub-categories.store');
        Route::get('/categories/{category}/sub-categories/{subCategory}/edit', [CategoryController::class, 'subCategoriesEdit'])->middleware('role:admin')->name('categories.sub-categories.edit');
        Route::put('/categories/{category}/sub-categories/{subCategory}', [CategoryController::class, 'subCategoriesUpdate'])->middleware('role:admin')->name('categories.sub-categories.update');
        Route::delete('/categories/{category}/sub-categories/{subCategory}', [CategoryController::class, 'subCategoriesDestroy'])->middleware('role:admin')->name('categories.sub-categories.destroy');


          // Teacher Routes (Admin only)
        Route::resource('teachers', TeacherController::class)->middleware('role:admin');
        Route::put('teachers/{teacher}/activate', [TeacherController::class, 'activate'])->name('teachers.activate');

        // Course Routes (Admin and Teacher)
        Route::get('courses', [CourseController::class, 'index'])->name('courses.index');
        Route::get('courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('courses/create', [CourseController::class, 'store'])->name('courses.store');
        Route::get('courses/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
         Route::post('courses/update', [CourseController::class, 'update'])->name('courses.update');
         Route::put('courses/{course}/update-approval', [CourseController::class, 'updateApproval'])->middleware('role:admin')->name('courses.update-approval');
        // Course Content Routes (Admin and Teacher)
        Route::get('course-content/{course}/create-chapter', [CourseController::class, 'createChapterModal'])->name('course-content.create-chapter');
        Route::post('course-content/{course}/create-chapter', [CourseController::class, 'storeChapter'])->name('course-content.store-chapter');
        Route::get('course-content/{chapter}/edit-chapter', [CourseController::class, 'editChapterModal'])->name('course-content.edit-chapter');
        Route::post('course-content/{chapter}/edit-chapter', [CourseController::class, 'updateChapterModal'])->name('course-content.update-chapter');
          Route::delete('course-content/{chapter}/chapter', [CourseController::class, 'destroyChapter'])->name('course-content.destory-chapter');

        Route::get('course-content/create-lesson', [CourseController::class, 'createLesson'])->name('course-content.create-lesson');
        Route::post('course-content/create-lesson', [CourseController::class, 'storeLesson'])->name('course-content.store-lesson');

        Route::get('course-content/edit-lesson', [CourseController::class, 'editLesson'])->name('course-content.edit-lesson');
        Route::post('course-content/{id}/update-lesson', [CourseController::class, 'updateLesson'])->name('course-content.update-lesson');
        Route::delete('course-content/{id}/lesson', [CourseController::class, 'destroyLesson'])->name('course-content.destroy-lesson');


        Route::post('course-chapter/{chapter}/sort-lesson', [CourseController::class, 'sortLesson'])->name('course-chapter.sort-lesson');

        Route::get('course-content/{course}/sort-chapter', [CourseController::class, 'sortChapter'])->name('course-content.sort-chpater');
        Route::post('course-content/{course}/sort-chapter', [CourseController::class, 'updateSortChapter'])->name('course-content.update-sort-chpater');

        // Course Video Routes (Admin and Teacher)
          Route::get('/add/video/{course:id}', [CourseVideoController::class, 'create'])
                ->name('course.add.video');
            Route::post('/add/video/{course:id}', [CourseVideoController::class, 'store'])
                ->name('course.add.video.store');
          Route::resource('course_videos', CourseVideoController::class);
    });
});

require __DIR__ . '/auth.php';
