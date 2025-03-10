<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold mb-5 text-gray-800 dark:text-gray-100">{{ __('Selamat Datang, ') }} {{ Auth::user()->name }}!</h3>

                    <p class="mb-8 text-gray-600 dark:text-gray-400">{{ __('Pantau perkembangan kursus Anda dan tingkatkan keterampilan bersama kami.') }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Kartu Total Kursus yang Diikuti -->
                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                            <div class="px-6 py-4">
                                <div class="flex items-center mb-3">
                                    <div class="bg-blue-500 rounded-md p-2 mr-3">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5 5 5-5m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Kursus Diikuti') }}</h4>
                                </div>
                                <p class="text-3xl font-bold text-blue-600 dark:text-blue-300">{{ $enrolledCoursesCount }}</p>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Total kursus yang telah Anda ikuti.') }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700 text-right">
                                <a href="{{ route('employees-dashboard.courses.index') }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200 text-sm font-medium">{{ __('Lihat Detail') }} <span aria-hidden="true">→</span></a>
                            </div>
                        </div>

                        <!-- Kartu Kursus Aktif -->
                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                            <div class="px-6 py-4">
                                <div class="flex items-center mb-3">
                                    <div class="bg-green-500 rounded-md p-2 mr-3">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Kursus Aktif') }}</h4>
                                </div>
                                <p class="text-3xl font-bold text-green-600 dark:text-green-300">{{ $activeCoursesCount }}</p>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Kursus yang disetujui dan sedang Anda pelajari.') }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700 text-right">
                                <a href="{{ route('employees-dashboard.courses.index') }}" class="text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-200 text-sm font-medium">{{ __('Lihat Detail') }} <span aria-hidden="true">→</span></a>
                            </div>
                        </div>

                        <!-- Kartu Kursus Menunggu Persetujuan -->
                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                            <div class="px-6 py-4">
                                <div class="flex items-center mb-3">
                                    <div class="bg-yellow-500 rounded-md p-2 mr-3">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Menunggu Persetujuan') }}</h4>
                                </div>
                                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-300">{{ $pendingCoursesCount }}</p>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Kursus yang menunggu persetujuan admin.') }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700 text-right">
                                <span class="text-yellow-500 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-200 text-sm font-medium">{{ __('Menunggu') }} <span aria-hidden="true">→</span></span>
                            </div>
                        </div>

                        <!-- Kartu Total Course Dibuat -->
                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                            <div class="px-6 py-4">
                                <div class="flex items-center mb-3">
                                    <div class="bg-indigo-500 rounded-md p-2 mr-3">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Total Course Dibuat') }}</h4>
                                </div>
                                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-300">{{ $totalCoursesCreated }}</p>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Total kursus yang tersedia di platform.') }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700 text-right">
                                <span class="text-indigo-500 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-200 text-sm font-medium">{{ __('Informasi') }} <span aria-hidden="true">→</span></span>
                            </div>
                        </div>

                        <!-- Kartu Total Quiz Dijawab -->
                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                            <div class="px-6 py-4">
                                <div class="flex items-center mb-3">
                                    <div class="bg-purple-500 rounded-md p-2 mr-3">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m-2 0H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2h-3.586a2 2 0 01-2-2v-2.414A2 2 0 0010.586 15H11a2 2 0 002-2v-2.414a2 2 0 00-2-2H9z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Total Quiz Dijawab') }}</h4>
                                </div>
                                <p class="text-3xl font-bold text-purple-600 dark:text-purple-300">
                                    {{ $totalQuizzesAttempted ?? '0' }}
                                </p>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Total quiz yang telah Anda jawab</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700 text-right">
                                <span class="text-purple-500 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-200 text-sm font-medium">{{ __('Riwayat Quiz') }} <span aria-hidden="true">→</span></span>
                            </div>
                        </div>

                        <!-- Kartu Rata-rata Skor Quiz -->
                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                            <div class="px-6 py-4">
                                <div class="flex items-center mb-3">
                                    <div class="bg-pink-500 rounded-md p-2 mr-3">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Rata-rata Skor Quiz') }}</h4>
                                </div>
                                <p class="text-3xl font-bold text-pink-600 dark:text-pink-300">
                                    {{ number_format($averageQuizScore ?? 0, 2) }}
                                </p>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Rata-rata skor dari semua quiz.') }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700 text-right">
                                <span class="text-pink-500 hover:text-pink-700 dark:text-pink-400 dark:hover:text-pink-200 text-sm font-medium">{{ __('Analisis Skor') }} <span aria-hidden="true">→</span></span>
                            </div>
                        </div>

                    </div>

                    <div class="mt-10 text-center">
                        <a href="{{ route('employees-dashboard.courses.index') }}" class="inline-flex items-center px-5 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-600">
                            {{ __('Lihat Semua Kursus Saya') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
