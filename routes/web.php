<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;

use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\CourseEmployeeController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\EnrollCourseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizMonitoringController;
use Illuminate\Support\Facades\Artisan;

Route::get('/create-storage-folder', function () {
    try {
        // Path untuk direktori storage
        $publicPath = public_path('storage');
        $storagePath = storage_path('app/public');

        // Buat direktori storage/app/public jika belum ada
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
            echo "Created directory: {$storagePath}<br>";
        }

        // Hapus folder public/storage jika sudah ada (untuk mencegah error)
        if (is_dir($publicPath)) {
            // Hapus symlink yang sudah ada
            if (is_link($publicPath)) {
                unlink($publicPath);
                echo "Removed existing symlink<br>";
            }
            // Atau hapus folder jika bukan symlink
            else {
                rmdir($publicPath);
                echo "Removed existing directory<br>";
            }
        }

        // Coba gunakan Artisan command untuk membuat symlink
        Artisan::call('storage:link');
        echo "Artisan command executed: " . Artisan::output() . "<br>";

        // Verifikasi apakah link berhasil dibuat
        if (is_link($publicPath) || is_dir($publicPath)) {
            return "Storage link created successfully!";
        } else {
            return "Failed to create storage link. Please check server permissions.";
        }
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/category', [FrontendController::class, 'Category'])->name('frontend.pages.category');
Route::get('/category/{category:slug}', [FrontendController::class, 'CategoryDetail'])->name('frontend.pages.category-detail');
Route::get('/courses', [FrontendController::class, 'Courses'])->name('frontend.pages.courses'); // Ubah controller jadi FrontendController dan action jadi Courses
Route::get('/courses/{course:slug}', [FrontendController::class, 'CourseDetail'])->name('frontend.pages.course-detail');
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
            Route::put('/chapter/{chapter}/edit-chapter', 'updateChapter')->name('update-chapter');
            Route::delete('/chapter/{chapter}', 'destroyChapter')->name('destroy-chapter');
        });
        //route untuk quizzes
        Route::resource('quizzes', QuizController::class)->except(['show']);

        Route::resource('quizzes/{quiz}/questions', QuestionController::class);
        Route::resource('quizzes/{quiz}/questions/{question}/options', QuestionOptionController::class);

        //route untuk quizzes
        Route::get('/quizzes/{quiz}/showQuestion/{id}', [QuizController::class, 'showQuestion'])->name('quizzes.showQuestion');
        // Percobaan Kuis (Quiz Attempts) - Fokus Utama untuk Admin
        Route::get('/quizzes/{quiz}/start', [QuizAttemptController::class, 'adminStart'])
            ->name('quizzes.attempt.start'); // Admin memulai kuis
        Route::get('/quizzes/{quiz}/attempt/{attempt}', [QuizAttemptController::class, 'show'])->name('quizzes.attempt.show'); // Menampilkan kuis yang sedang berjalan (pertanyaan)
        Route::post('/quizzes/{quiz}/attempt/{attempt}/submit', [QuizAttemptController::class, 'submit'])->name('quizzes.attempt.submit'); // Submit jawaban
        Route::get('/quizzes/{quiz}/attempt/{attempt}/results', [QuizAttemptController::class, 'results'])->name('quizzes.attempt.results'); // Hasil kuis
        Route::post('/quizzes/{quiz}/attempt/{attempt}/finalize', [QuizAttemptController::class, 'finalize'])->name('quizzes.attempt.finalize'); //Finalisasi jawaban
        Route::get('/quizzes/admin-start', [QuizController::class, 'showQuizzesToStart'])->name('quizzes.admin_start'); // Daftar kuis untuk admin
        Route::get('/quizzes/{quiz}/question/{id}', [QuizController::class, 'showQuestion'])->name('quizzes.question.show'); // Menampilkan pertanyaan
        // Quiz Monitoring
        Route::prefix('quizzes/monitoring')->name('quizzes.monitoring.')->group(function () {
            Route::get('performance', [QuizMonitoringController::class, 'performance'])->name('performance');
            Route::get('completion', [QuizMonitoringController::class, 'completion'])->name('completion');
            Route::get('user-attempts', [QuizMonitoringController::class, 'userAttempts'])->name('user-attempts'); // Route baru
        });
        // Course Video Routes
        Route::controller(CourseVideoController::class)->name('courses.')->group(function () {
            Route::get('/{course}/add/video', 'create')->name('create.video');
            Route::post('/{course}/add/video', 'store')->name('store.video');
            Route::get('/video/{course_video}/edit', 'edit')->name('edit.video');
            Route::put('/video/{course_video}', 'update')->name('update.video');
            Route::delete('/video/{course_video}', 'destroy')->name('delete.video');
        });

        // Teacher Routes - REMOVED DUPLICATE TEACHER ROUTES
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

            // Employee Courses Routes
            Route::prefix('employee-courses')->name('employee-courses.')->group(function () {
                Route::get('/', [TeacherController::class, 'employeeCoursesIndex'])->name('index');
                Route::get('/{enrollCourse}/approve', [TeacherController::class, 'showApproveEmployeeCourseForm'])->name('approve-form');
                Route::post('/{enrollCourse}/approve', [TeacherController::class, 'approveEmployeeCourse'])->name('approve');
                Route::post('/{enrollCourse}/reject', [TeacherController::class, 'rejectEmployeeCourse'])->name('reject');
            });
        });

        // TEACHER Quiz Routes
        Route::resource('quizzes', QuizController::class); // GUNAKAN RESOURCE ROUTE
        // Employee Course Management Routes - NOW USING TeacherController
        Route::prefix('employee-courses')->name('employee-courses.')->group(function () {
            Route::get('/', [TeacherController::class, 'employeeCoursesIndex'])->name('index'); // Daftar kursus employee untuk approval - TeacherController
            Route::post('/{enrollCourse}/approve', [TeacherController::class, 'approveEmployeeCourse'])->name('approve');
            Route::post('/{enrollCourse}/reject', [TeacherController::class, 'rejectEmployeeCourse'])->name('reject');
            Route::get('/{enrollCourse}/approve', [TeacherController::class, 'showApproveEmployeeCourseForm'])->name('approve-form'); // Also check approve-form route
        });
    });


    // Employee Routes

        // Employee Routes
    Route::prefix('employee')->name('employees-dashboard.')->middleware('role:employee')->group(function () {
            // Dashboard & Learning Progress
            Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
            Route::get('/learning-progress', [EmployeeDashboardController::class, 'learningProgressIndex'])->name('learning-progress.index');

            // Available Courses & Enrollment
            Route::controller(CourseEmployeeController::class)->group(function () {
                Route::get('/courses', 'index')->name('courses.index');
                // Ubah rute ini untuk menggunakan slug
                Route::get('/courses/{course:slug}', 'show')->name('courses.show');
                Route::post('/courses/{course}/enroll', 'enroll')->name('courses.enroll'); // Biarkan rute enroll menggunakan ID
                // Ubah rute ini untuk menggunakan slug
                Route::get('/courses/{course:slug}/learn', 'learn')->name('courses.learn');
                Route::get('/get-lesson-content', 'getLessonContent')->name('get-lesson-content');
                Route::post('/update-watch-history', 'updateWatchHistory')->name('update-watch-history');
                Route::post('/update-lesson-completion', 'updateLessonCompletion')->name('update-lesson-completion');
                // Quiz Routes
            Route::get('/get-quiz/{quiz}', 'getQuiz')->name('get-quiz');
            Route::get('/quiz-info/{quiz}', 'showQuizInfo')->name('quiz-info'); // Route baru untuk informasi kuis
            Route::post('/submit-quiz', 'submitQuiz')->name('submit-quiz');
            // Add this new route for quiz-result-details
            Route::get('/quiz-results/{quizAttempt}/details', 'quizResultDetails')->name('quiz-result-details');
            Route::get('/quiz-results/{quizAttempt}', 'quizResults')->name('quiz-results');
        });

    });

});

require __DIR__ . '/auth.php';
