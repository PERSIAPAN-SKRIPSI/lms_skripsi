<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kursus Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Kursus yang Anda Ikuti') }}</h3>

                    @if ($enrolledCourses->isEmpty())
                        <p>{{ __('Anda belum mengikuti kursus apapun.') }}</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($enrolledCourses as $enrollment)
                                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">
                                    <a href="{{ route('employees-dashboard.courses.show', $enrollment->course->id) }}">
                                        <img class="rounded-t-lg" src="{{ Storage::url($enrollment->course->thumbnail) }}" alt="{{ $enrollment->course->name }}" onerror="this.src='{{ asset('thumbnails/default.png') }}'" loading="lazy"/>
                                    </a>
                                    <div class="p-5">
                                        <a href="{{ route('employees-dashboard.courses.show', $enrollment->course->id) }}">
                                            <h5 class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white">{{ $enrollment->course->name }}</h5>
                                        </a>
                                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ Str::limit($enrollment->course->description, 100) }}</p>
                                        <a href="{{ route('employees-dashboard.courses.learn', $enrollment->course->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Mulai Belajar
                                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
