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
                    <h3 class="text-lg font-bold mb-4">{{ __('Selamat Datang, ') }} {{ Auth::user()->name }}!</h3>

                    <p class="mb-4">{{ __('Ini adalah dashboard karyawan Anda. Di sini Anda dapat melihat ringkasan informasi kursus Anda dan mengakses kursus yang telah Anda ikuti.') }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"> <!-- Changed to grid-cols-4 -->
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Total Kursus yang Diikuti') }}</h4>
                            <p class="text-2xl font-bold text-blue-500 dark:text-blue-400">{{ $enrolledCoursesCount }}</p>
                        </div>

                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Kursus Aktif') }}</h4>
                            <p class="text-2xl font-bold text-green-500 dark:text-green-400">{{ $activeCoursesCount }}</p>
                        </div>

                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Kursus Menunggu Persetujuan') }}</h4>
                            <p class="text-2xl font-bold text-yellow-500 dark:text-yellow-400">{{ $pendingCoursesCount }}</p>
                        </div>

                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Total Course') }}</h4>
                            <p class="text-2xl font-bold text-indigo-500 dark:text-indigo-400">{{ $totalCoursesCreated }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('employees-dashboard.courses.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 dark:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-100 uppercase hover:bg-blue-700 dark:hover:bg-blue-500 focus:bg-blue-700 dark:focus:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Lihat Kursus Saya') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
