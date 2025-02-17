<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseEmployeeController;
use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizMonitoringController;

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/category', [FrontendController::class, 'category'])->name('frontend.pages.category');
Route::get('/category/{category:slug}', [FrontendController::class, 'categoryDetail'])->name('frontend.pages.category-detail');
Route::get('/courses/{slug}', [FrontendController::class, 'indexCourse'])->name('frontend.pages.course-detail');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin|teacher')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('employees', EmployeeController::class);
        Route::post('/teachers/check-documents', [TeacherController::class, 'checkDocuments'])->name('teachers.check-documents');
        Route::resource('teachers', TeacherController::class);
        Route::put('teachers/{teacher}/activate', [TeacherController::class, 'activate'])->name('teachers.activate');
        Route::resource('categories', CategoryController::class)->except(['show']);

        // Subcategories Routes
        Route::prefix('categories/{category:slug}')->name('categories.sub-categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'subIndex'])->name('index');
            Route::get('/create', [CategoryController::class, 'subCreate'])->name('create');
            Route::post('/', [CategoryController::class, 'subStore'])->name('store');
            Route::get('/{subCategory:slug}/edit', [CategoryController::class, 'subEdit'])->name('edit');
            Route::put('/{subCategory:slug}', [CategoryController::class, 'subUpdate'])->name('update');
            Route::delete('/{subCategory:slug}', [CategoryController::class, 'subDestroy'])->name('destroy');
        });

        // Course Routes
        Route::resource('courses', CourseController::class);

        Route::put('courses/{course}/update-approval', [CourseController::class, 'updateApproval'])->name('courses.update-approval');

        Route::resource('courses.videos', CourseVideoController::class)->except(['show', 'index']);

        // Course Content Routes
        Route::controller(CourseController::class)->name('courses.')->group(function () {
            Route::get('/{course}/create-chapter', 'createChapter')->name('create-chapter');
            Route::post('/{course}/create-chapter', 'storeChapter')->name('store-chapter');
            Route::get('/chapter/{chapter}/edit-chapter', 'editChapter')->name('edit-chapter');
            Route::post('/chapter/{chapter}/edit-chapter', 'updateChapter')->name('update-chapter');
            Route::delete('/chapter/{chapter}', 'destroyChapter')->name('destroy-chapter');
        });
       //route untuk quizzes
       Route::resource('quizzes', QuizController::class);
       Route::resource('quizzes/{quiz}/questions', QuestionController::class);
       Route::resource('quizzes/{quiz}/questions/{question}/options', QuestionOptionController::class);

       //route untuk quizzes
       Route::get('/quizzes/{quiz}/showQuestion/{id}', [QuizController::class, 'showQuestion'])->name('quizzes.showQuestion');
       // Route untuk QuizAttemptController
       Route::post('/quizzes/{quiz}/start', [QuizAttemptController::class, 'start'])->name('quizzes.attempt.start');
       Route::get('/quizzes/{quiz}/attempt/{attempt}', [QuizAttemptController::class, 'show'])->name('quizzes.attempt.show');
       Route::post('/quizzes/{quiz}/attempt/{attempt}/submit', [QuizAttemptController::class, 'submit'])->name('quizzes.attempt.submit');
       Route::get('/quizzes/{quiz}/attempt/{attempt}/results', [QuizAttemptController::class, 'results'])->name('quizzes.attempt.results');
        // Quiz Monitoring
        Route::prefix('quizzes/monitoring')->name('quizzes.monitoring.')->group(function () {
            Route::get('performance', [QuizMonitoringController::class, 'performance'])->name('performance');
            Route::get('completion', [QuizMonitoringController::class, 'completion'])->name('completion');
        });
        // Course Video Routes
        Route::controller(CourseVideoController::class)->name('courses.')->group(function () {
            Route::get('/{course}/add/video', 'create')->name('create.video');
            Route::post('/{course}/add/video', 'store')->name('store.video');
            Route::get('/video/{course_video}/edit', 'edit')->name('edit.video');
            Route::put('/video/{course_video}', 'update')->name('update.video');
            Route::delete('/video/{course_video}', 'destroy')->name('delete.video');
        });
    });

    // Teacher Routes
    Route::prefix('teacher')->name('teacher.')->middleware('role:teacher')->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

        // Course Video Routes
        Route::controller(CourseVideoController::class)->name('courses.')->group(function () {
            Route::get('/{course}/add/video', 'create')->name('create.video');
            Route::post('/{course}/add/video', 'store')->name('store.video');
            Route::get('/video/{course_video}/edit', 'edit')->name('edit.video');
            Route::put('/video/{course_video}', 'update')->name('update.video');
            Route::delete('/video/{course_video}', 'destroy')->name('delete.video');
        });

        // TEACHER Quiz Routes
        Route::resource('quizzes', QuizController::class); // GUNAKAN RESOURCE ROUTE
    });

    // Employee Routes
    Route::prefix('employee')->name('employee.')->middleware('role:employee')->group(function () {
        Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
        Route::get('/courses', [CourseEmployeeController::class, 'index'])->name('courses.index');
    });
});

require __DIR__ . '/auth.php';
