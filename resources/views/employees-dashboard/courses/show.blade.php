<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $course->name }} - Detail
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8">
                    <div class="md:flex md:items-start md:space-x-8">
                        <div class="md:w-1/2 lg:w-1/3 mb-6 md:mb-0">
                            <img class="rounded-xl shadow-md w-full h-auto" src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->name }}" onerror="this.src='{{ asset('thumbnails/default.png') }}'" loading="lazy"/>
                        </div>
                        <div class="md:w-1/2 lg:w-2/3">
                            <h3 class="font-semibold text-3xl text-gray-900 dark:text-white mb-5">{{ $course->name }}</h3>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed line-clamp-3 mb-6">{{ $course->description }}</p>

                            <div class="grid grid-cols-2 gap-4 mb-6 text-gray-600 dark:text-gray-400 text-sm">
                                <div><i class="fas fa-clock mr-2"></i> Durasi: <span class="font-medium text-gray-800 dark:text-gray-200">{{ $totalMinutes }} min {{ $remainingSeconds }} sec</span></div>
                                <div><i class="fas fa-film mr-2"></i> Video: <span class="font-medium text-gray-800 dark:text-gray-200">{{ $course->chapters->sum(function ($chapter) { return $chapter->videos->count(); }) }}</span></div>
                                <div><i class="fas fa-list-alt mr-2"></i> Chapter: <span class="font-medium text-gray-800 dark:text-gray-200">{{ $course->chapters->count() }}</span></div>
                                <div><i class="fas fa-user-tie mr-2"></i> Guru: <span class="font-medium text-gray-800 dark:text-gray-200">{{ $course->teacher->user->name }}</span></div>
                                <div><i class="fas fa-tag mr-2"></i> Kategori: <span class="font-medium text-gray-800 dark:text-gray-200">{{ $course->category->name }}</span></div>
                            </div>

                            <div class="flex justify-start">
                                <a href="{{ route('employees-dashboard.courses.learn', $course->slug) }}" class="inline-flex items-center px-6 py-3 text-sm font-semibold text-center text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 dark:from-blue-500 dark:to-purple-500 dark:hover:from-blue-600 dark:hover:to-purple-600 transition-all duration-200">
                                    Mulai Belajar
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</x-app-layout>
