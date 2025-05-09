<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kursus Saya') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-md p-6 border border-gray-200 dark:border-gray-700 transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="rounded-full bg-sky-100 dark:bg-sky-900 p-3 mr-4">
                            <i class="fas fa-graduation-cap text-xl text-sky-600 dark:text-sky-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Kursus</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $enrolledCourses->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-md p-6 border border-gray-200 dark:border-gray-700 transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="rounded-full bg-green-100 dark:bg-green-900 p-3 mr-4">
                            <i class="fas fa-clock text-xl text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Sedang Berjalan</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                                {{ $enrolledCourses->filter(function($enrollment) {
                                    return !$enrollment->is_completed;
                                })->count() }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-md p-6 border border-gray-200 dark:border-gray-700 transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="rounded-full bg-yellow-100 dark:bg-yellow-900 p-3 mr-4">
                            <i class="fas fa-trophy text-xl text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Selesai</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                                {{ $enrolledCourses->filter(function($enrollment) {
                                    return $enrollment->is_completed;
                                })->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Course Section -->
            @if (!$enrolledCourses->isEmpty())
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Lanjutkan Belajar</h3>

                @php
                    // Get the first in-progress course (not completed)
                    $featuredCourse = $enrolledCourses->firstWhere('is_completed', false);

                    // If all courses are completed, use the first course
                    if (!$featuredCourse) {
                        $featuredCourse = $enrolledCourses->first();
                    }

                    $course = $featuredCourse->course;

                    // Calculate total videos in the course
                    $totalVideos = 0;
                    foreach ($course->chapters as $chapter) {
                        $totalVideos += $chapter->videos->count();
                    }

                    // Calculate completed videos
                    $completedVideos = 0;
                    if ($featuredCourse->video_completions) {
                        $completedVideos = count($featuredCourse->video_completions);
                    }

                    // Calculate progress percentage
                    $progressPercentage = $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0;
                @endphp

                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="md:flex items-center">
                        <div class="md:w-2/3 p-6">
                            <span class="inline-block bg-sky-100 text-sky-700 dark:bg-sky-900 dark:text-sky-300 text-xs font-medium px-3 py-1 rounded-full uppercase tracking-wider mb-4">
                                {{ $course->category->name }}
                            </span>
                            <h4 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">
                                {{ $course->name }}
                            </h4>
                            <div class="flex items-center text-gray-600 dark:text-gray-400 mb-4">
                                <i class="fas fa-user-tie mr-2"></i>
                                <span>{{ $course->teacher->user->name }}</span>
                            </div>

                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-6">
                                <div class="bg-sky-500 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                            </div>

                            <div class="flex items-center justify-between text-gray-500 dark:text-gray-400 text-sm mb-6">
                                <span>{{ $progressPercentage }}% selesai</span>
                                <span>{{ $completedVideos }} dari {{ $totalVideos }} video</span>
                            </div>

                            <a href="{{ route('employees-dashboard.courses.learn', $course->slug) }}" class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50 transition-colors duration-300">
                                Lanjutkan
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="md:w-1/3">
                            <img class="h-full w-full object-cover" src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->name }}" onerror="this.src='{{ asset('thumbnails/default.png') }}'">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Main Content -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                        {{ __('Semua Kursus') }}
                    </h3>
                    <div class="flex items-center space-x-2">
                        <button class="text-gray-500 dark:text-gray-400 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
                            <i class="fas fa-th-large text-lg"></i>
                        </button>
                        <button class="text-gray-500 dark:text-gray-400 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
                            <i class="fas fa-list text-lg"></i>
                        </button>
                    </div>
                </div>

                @if ($enrolledCourses->isEmpty())
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-md p-12 text-center border border-gray-200 dark:border-gray-700">
                        <div class="flex flex-col items-center">
                            <div class="rounded-full bg-sky-100 dark:bg-sky-900 p-6 mb-4">
                                <i class="fas fa-book-open text-3xl text-sky-600 dark:text-sky-400"></i>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Kursus</h4>
                            <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
                                Anda belum mengikuti kursus apapun. Jelajahi katalog kursus untuk mulai belajar.
                            </p>
                            <a href="{{ route('employees-dashboard.courses.index') }}" class="inline-flex items-center px-5 py-3 text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50 transition-colors duration-300">
                                Jelajahi Kursus
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($enrolledCourses as $enrollment)
                            @php
                                $course = $enrollment->course;
                                $totalDurationInSeconds = 0;
                                $totalChapters = $course->chapters->count();
                                $totalVideos = 0;

                                foreach ($course->chapters as $chapter) {
                                    $totalVideos += $chapter->videos->count();
                                    foreach ($chapter->videos as $video) {
                                        $totalDurationInSeconds += $video->duration;
                                    }
                                }
                                $totalMinutes = floor($totalDurationInSeconds / 60);
                                $remainingSeconds = $totalDurationInSeconds % 60;

                                // Calculate completion percentage based on completed videos
                                $completedVideos = 0;
                                if ($enrollment->video_completions) {
                                    $completedVideos = count($enrollment->video_completions);
                                }

                                $progress = $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0;
                            @endphp
                            <div class="course-card bg-white dark:bg-gray-900 rounded-2xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 transition-all hover:shadow-xl hover:-translate-y-1">
                                <div class="relative">
                                    <a href="{{ route('employees-dashboard.courses.show', $course->slug) }}" class="block">
                                        <img class="h-60 w-full object-cover" src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->name }}" onerror="this.src='{{ asset('thumbnails/default.png') }}'" loading="lazy">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent pointer-events-none"></div>
                                    </a>
                                    <span class="absolute top-4 left-4 inline-block bg-white dark:bg-gray-900 text-sky-600 dark:text-sky-400 text-xs font-medium px-3 py-1.5 rounded-full shadow-md uppercase tracking-wider">
                                        {{ $course->category->name }}
                                    </span>
                                    <div class="absolute bottom-0 left-0 right-0 p-4">
                                        <div class="flex justify-between items-center text-white">
                                            <div class="flex items-center">
                                                <i class="fas fa-clock mr-2"></i>
                                                <span class="text-sm">{{ $totalMinutes }} menit</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-video mr-2"></i>
                                                <span class="text-sm">{{ $totalVideos }} video</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <a href="{{ route('employees-dashboard.courses.show', $course->slug) }}" class="block">
                                        <h5 class="text-xl font-semibold text-gray-900 dark:text-white hover:text-sky-600 dark:hover:text-sky-400 transition-colors duration-200 mb-3 line-clamp-1">
                                            {{ $course->name }}
                                        </h5>
                                    </a>

                                    <div class="flex items-center mb-4">
                                        <img class="w-8 h-8 rounded-full mr-2 object-cover" src="{{ $course->teacher->user->profile_photo_url }}" alt="{{ $course->teacher->user->name }}">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $course->teacher->user->name }}</span>
                                    </div>

                                    <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4">
                                        {{ $course->description }}
                                    </p>

                                    <div class="mb-4">
                                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                                            <span>Progress</span>
                                            <span>{{ $progress }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-sky-500 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('employees-dashboard.courses.learn', $course->slug) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50 transition-colors duration-300">
                                            {{ $enrollment->is_completed ? 'Lihat Kembali' : 'Lanjutkan' }}
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</x-app-layout>

<style>
    .course-card {
        backface-visibility: hidden;
        will-change: transform;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }

    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .line-clamp-3 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }
</style>
