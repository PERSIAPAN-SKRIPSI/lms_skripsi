<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kursus Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8">
                    <h3 class="font-semibold text-2xl text-gray-900 dark:text-white mb-8">{{ __('Kursus yang Anda Ikuti') }}</h3>

                    @if ($enrolledCourses->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">{{ __('Anda belum mengikuti kursus apapun.') }}</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
                                @endphp
                                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col relative">
                                    <a href="{{ route('employees-dashboard.courses.show', $course->slug) }}" class="block hover:opacity-90 transition-opacity duration-200">
                                        <img class="h-60 w-full object-cover" src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->name }}" onerror="this.src='{{ asset('thumbnails/default.png') }}'" loading="lazy"/> {{-- **Perubahan di sini: h-60** --}}
                                    </a>

                                    <div class="absolute top-4 right-4">
                                        <span class="bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full uppercase tracking-wider">
                                            {{ $course->category->name }}
                                        </span>
                                    </div>

                                    <div class="p-6 flex-1 flex flex-col justify-between">
                                        <div>
                                            <a href="{{ route('employees-dashboard.courses.show', $course->slug) }}" class="block">
                                                <h5 class="mb-4 text-xl font-bold tracking-tight text-gray-900 dark:text-white hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-200">{{ $course->name }}</h5>
                                            </a>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4">{{ $course->description }}</p>
                                        </div>

                                        <div class="mb-4">
                                            <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm mb-2">
                                                <i class="fas fa-clock mr-2 w-4 h-4"></i> {{ $totalMinutes }} menit
                                            </div>
                                            <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm mb-2">
                                                <i class="fas fa-film mr-2 w-4 h-4"></i> {{ $totalVideos }} Video
                                            </div>
                                            <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                                <i class="fas fa-list-alt mr-2 w-4 h-4"></i> {{ $totalChapters }} Chapter
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between mt-auto">
                                            <a href="{{ route('employees-dashboard.courses.learn', $course->slug) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 dark:from-blue-500 dark:to-purple-500 dark:hover:from-blue-600 dark:hover:to-purple-600 transition-all duration-200">
                                                Mulai Belajar
                                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                                </svg>
                                            </a>
                                            <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                                <i class="fas fa-user-tie mr-2 w-4 h-4"></i> {{ $course->teacher->user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</x-app-layout>
