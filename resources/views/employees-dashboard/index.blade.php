<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Karyawan') }}
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
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md">
                                    <h4 class="font-semibold text-md mb-2">{{ $enrollment->course->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $enrollment->course->description ?? 'Tidak ada deskripsi' }}</p>
                                    <div class="mt-4">
                                        <a href="{{ route('employee.courses.show', $enrollment->course->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 dark:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-800 focus:bg-blue-700 dark:focus:bg-blue-800 active:bg-blue-900 dark:active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                            {{ __('Mulai Belajar') }}
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
