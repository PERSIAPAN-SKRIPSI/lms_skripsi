<x-app-layout>
    <x-slot name="header">
        <div class="bg-indigo-700 dark:bg-indigo-900 py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Admin Dashboard') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filter Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl mb-8 p-6">
                <form action="{{ route('admin.dashboard') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <!-- Date Range -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date Range:</label>
                            <div class="relative">
                                <input type="date" name="start_date" id="start_date" value="{{ $startDate ?? '' }}" class="mt-1 p-2 w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 sr-only md:not-sr-only"></label>
                            <div class="relative">
                                <input type="date" name="end_date" id="end_date" value="{{ $endDate ?? '' }}" class="mt-1 p-2 w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-2">
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                                Filter
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-gray-300 text-gray-700 rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Quizzes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl p-6 border-l-4 border-teal-500">
                    <div class="flex items-center">
                        <div class="bg-teal-100 dark:bg-teal-600 p-3 rounded-md">
                            <svg class="h-6 w-6 text-teal-500 dark:text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Quizzes') }}</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $totalQuizzes }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Quiz Attempts -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="bg-blue-100 dark:bg-blue-600 p-3 rounded-md">
                            <svg class="h-6 w-6 text-blue-500 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Quiz Attempts') }}</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $totalQuizAttempts }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Average Score -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="bg-green-100 dark:bg-green-600 p-3 rounded-md">
                            <svg class="h-6 w-6 text-green-500 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Average Score') }}</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ number_format($averageQuizScore, 1) }}%</h3>
                        </div>
                    </div>
                </div>

                <!-- Passing Rate -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="bg-purple-100 dark:bg-purple-600 p-3 rounded-md">
                            <svg class="h-6 w-6 text-purple-500 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Passing Rate') }}</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ number_format($quizPassingRate, 1) }}%</h3>
                        </div>
                    </div>
                </div>
            </div>

              <!-- Radar Chart -->
              <div class="bg-gray-800 dark:bg-gray-700 overflow-hidden shadow-md rounded-xl">
                <div class="px-6 py-5 bg-gray-700 dark:bg-gray-600 border-b border-gray-600 dark:border-gray-500">
                    <h3 class="text-lg font-semibold text-white dark:text-gray-300">{{ __('Quiz Performance Overview') }}</h3>
                </div>
                <div class="p-6">
                    <canvas id="radarChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const passingRate = {{ $quizPassingRate }};
    const averageScore = {{ $averageQuizScore }};
    const totalQuizzes = {{ $totalQuizzes }};
    const totalAttempts = {{ $totalQuizAttempts }};

    const data = {
        labels: ['Passing Rate', 'Average Score', 'Total Quizzes', 'Total Attempts'],
        datasets: [{
            label: 'Quiz Performance',
            data: [passingRate, averageScore, totalQuizzes, totalAttempts],
            backgroundColor: 'rgba(54, 162, 235, 0.3)',  // Warna latar belakang data
            borderColor: 'rgba(54, 162, 235, 1)',        // Warna garis data
            borderWidth: 2,
            pointBackgroundColor: 'rgba(54, 162, 235, 1)', // Warna titik data
            pointBorderColor: '#fff',                     // Warna border titik data
            pointHoverBackgroundColor: '#fff',              // Warna hover titik data
            pointHoverBorderColor: 'rgba(54, 162, 235, 1)', // Warna hover border titik data
            pointRadius: 5,                                // Ukuran titik data
            pointHoverRadius: 7                              // Ukuran hover titik data
        }]
    };

    const config = {
        type: 'radar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,                                   // Sesuaikan jika perlu
                    ticks: {
                        stepSize: 20,
                        color: 'rgba(200, 200, 200, 1)',         // Warna teks ticks
                        backdropColor: 'transparent'             // Latar belakang transparan
                    },
                    grid: {
                        color: 'rgba(200, 200, 200, 0.5)'      // Warna garis grid
                    },
                    pointLabels: {
                        color: 'rgba(200, 200, 200, 1)',         // Warna label
                        font: {
                            size: 14
                        }
                    }
                }
            },
            elements: {
                line: {
                    tension: 0.4                                // Tingkat kelengkungan garis
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    bodyColor: '#fff',
                    titleColor: '#fff'
                }
            }
        }
    };

    const myChart = new Chart(
        document.getElementById('radarChart'),
        config
    );
</script>
