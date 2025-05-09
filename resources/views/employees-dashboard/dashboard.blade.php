<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard Karyawan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Message --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden mb-8">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        {{ __('Selamat Datang,') }} {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('Berikut ringkasan aktivitas pembelajaran Anda.') }}
                    </p>
                </div>
            </div>

            {{-- Overview Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card: Enrolled Courses -->
                <div class="card-wrapper">
                    <div class="bg-sky-50 dark:bg-sky-900/20 p-6 rounded-2xl shadow-md border border-sky-200 dark:border-sky-700/50 transition-all hover:shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-sky-100 dark:bg-sky-900 p-3 rounded-full mr-4">
                                <svg class="h-6 w-6 text-sky-600 dark:text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-sky-700 dark:text-sky-300">{{ __('Total Kursus Diikuti') }}</p>
                                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $enrolledCoursesCount ?? 0 }}</h4>
                            </div>
                        </div>
                        <p class="text-xs text-sky-600 dark:text-sky-400 mb-3">{{ __('Jumlah total kursus yang terdaftar untuk Anda.') }}</p>
                    </div>
                </div>

                <!-- Card: Active Courses -->
                <div class="card-wrapper">
                    <div class="bg-green-50 dark:bg-green-900/20 p-6 rounded-2xl shadow-md border border-green-200 dark:border-green-700/50 transition-all hover:shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full mr-4">
                                <svg class="h-6 w-6 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-green-700 dark:text-green-300">{{ __('Kursus Aktif') }}</p>
                                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $activeCoursesCount ?? 0 }}</h4>
                            </div>
                        </div>
                        <p class="text-xs text-green-600 dark:text-green-400 mb-3">{{ __('Kursus yang telah disetujui dan dapat diakses.') }}</p>
                    </div>
                </div>

                <!-- Card: Pending Courses -->
                <div class="card-wrapper">
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 p-6 rounded-2xl shadow-md border border-yellow-200 dark:border-yellow-700/50 transition-all hover:shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full mr-4">
                                <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-yellow-700 dark:text-yellow-300">{{ __('Menunggu Persetujuan') }}</p>
                                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $pendingCoursesCount ?? 0 }}</h4>
                            </div>
                        </div>
                        <p class="text-xs text-yellow-600 dark:text-yellow-400 mb-3">{{ __('Kursus yang pendaftarannya menunggu approval.') }}</p>
                         <div class="text-right">
                           <a href="#" class="text-sm font-medium text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-200 transition duration-150 ease-in-out">
                              Cek Status →
                           </a>
                        </div>
                    </div>
                </div>

                <!-- Card: Total Quizzes Attempted -->
                <div class="card-wrapper">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-2xl shadow-md border border-blue-200 dark:border-blue-700/50 transition-all hover:shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full mr-4">
                                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-700 dark:text-blue-300">{{ __('Total Quiz Dijawab') }}</p>
                                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalQuizzesAttempted ?? 0 }}</h4>
                            </div>
                        </div>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mb-3">{{ __('Total percobaan menjawab quiz dari semua kursus.') }}</p>
                          <div class="text-right">
                             <a href="{{ route('employees-dashboard.learning-progress.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 transition duration-150 ease-in-out">
                                {{ __('Lihat Progress') }} →
                             </a>
                          </div>
                    </div>
                </div>

                <!-- Card: Average Quiz Score -->
                <div class="card-wrapper">
                    <div class="bg-lime-50 dark:bg-lime-900/20 p-6 rounded-2xl shadow-md border border-lime-200 dark:border-lime-700/50 transition-all hover:shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-lime-100 dark:bg-lime-900 p-3 rounded-full mr-4">
                                <svg class="h-6 w-6 text-lime-600 dark:text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-lime-700 dark:text-lime-300">{{ __('Rata-rata Skor Quiz') }}</p>
                                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($averageQuizScore ?? 0, 2) }}</h4>
                            </div>
                        </div>
                        <p class="text-xs text-lime-600 dark:text-lime-400 mb-3">{{ __('Rata-rata skor dari semua percobaan quiz.') }}</p>
                         <div class="text-right">
                            {{-- Link to the learning progress page --}}
                             <a href="{{ route('employees-dashboard.learning-progress.index') }}#analisis-skor" class="text-sm font-medium text-lime-600 dark:text-lime-400 hover:text-lime-800 dark:hover:text-lime-200 transition duration-150 ease-in-out">
                                {{ __('Lihat Detail Skor') }} →
                            </a>
                         </div>
                    </div>
                </div>

                <!-- Card: Total Courses Available -->
                <div class="card-wrapper">
                    <div class="bg-gray-50 dark:bg-gray-900/20 p-6 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700/50 transition-all hover:shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-gray-100 dark:bg-gray-900 p-3 rounded-full mr-4">
                                <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Total Kursus Tersedia') }}</p>
                                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalCoursesCreated ?? 0 }}</h4>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">{{ __('Jumlah kursus yang ada di platform.') }}</p>
                    </div>
                </div>

            </div> {{-- End Grid --}}

        </div> {{-- End max-w-7xl container --}}
    </div> {{-- End py-12 --}}
</x-app-layout>
<style>
    .card-wrapper {
        transition: transform 0.2s ease-in-out;
    }

    .card-wrapper:hover {
        transform: translateY(-4px);
    }

</style>
