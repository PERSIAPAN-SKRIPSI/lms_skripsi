<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz Completion Monitoring') }}
        </h2>
    </x-slot>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <!-- Completed Quizzes Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-500 text-sm font-medium">{{ __('Completed Quizzes') }}</h3>
                            <div class="bg-green-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <h2 class="text-3xl font-bold text-gray-800">{{ $completedQuizzesCount }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Total quizzes completed by users') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Most Attempted Quiz Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-500 text-sm font-medium">{{ __('Most Attempted Quiz') }}</h3>
                            <div class="bg-blue-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14.72M13 10l6.86 6.86M7 16v5a1 1 0 001 1h9a1 1 0 001-1v-5m-1-10l6.99 6.99" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            @if($mostAttemptedQuiz)
                                <h2 class="text-xl font-bold text-gray-800">{{ $mostAttemptedQuiz->quiz->title }}</h2>
                                <p class="text-sm text-gray-500 mt-1">{{ __('Attempted') }}
                                    {{ $mostAttemptedQuiz->total_attempts }} {{ __('times') }}</p>
                            @else
                                <h2 class="text-xl font-bold text-gray-800">{{ __('N/A') }}</h2>
                                <p class="text-sm text-gray-500 mt-1">{{ __('No quizzes attempted yet') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Least Attempted Quiz Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-500 text-sm font-medium">{{ __('Least Attempted Quiz') }}</h3>
                            <div class="bg-red-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 15l-3-3m0 0l3-3m-3 3h8M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            @if($leastAttemptedQuiz)
                                <h2 class="text-xl font-bold text-gray-800">{{ $leastAttemptedQuiz->quiz->title }}</h2>
                                <p class="text-sm text-gray-500 mt-1">{{ __('Attempted') }}
                                    {{ $leastAttemptedQuiz->total_attempts }} {{ __('times') }}</p>
                            @else
                                <h2 class="text-xl font-bold text-gray-800">{{ __('N/A') }}</h2>
                                <p class="text-sm text-gray-500 mt-1">{{ __('No quizzes attempted yet') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('Quiz Attempts Distribution') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('Proportion of attempts for each quiz and participating users') }}</p>
                </div>
                <div class="p-5">
                    <canvas id="quizAttemptsChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.0/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const quizAttemptsChartCanvas = document.getElementById('quizAttemptsChart');

                if (!quizAttemptsChartCanvas) return;

                // Get quiz attempts data from server
                const quizAttemptsData = {!! json_encode($quizAttempts) !!};

                // Extract quiz titles and attempt counts
                const quizTitles = quizAttemptsData.map(item => item.quiz_title);
                const attemptCounts = quizAttemptsData.map(item => item.attempt_count);

                // Generate dynamic background colors
                const backgroundColors = quizTitles.map(() => {
                    const r = Math.floor(Math.random() * 200 + 50); // Keep within a decent range
                    const g = Math.floor(Math.random() * 200 + 50);
                    const b = Math.floor(Math.random() * 200 + 50);
                    return `rgba(${r}, ${g}, ${b}, 0.7)`;
                });

                // Create the polar area chart
                const quizAttemptsChart = new Chart(quizAttemptsChartCanvas, {
                    type: 'polarArea',
                    data: {
                        labels: quizTitles,
                        datasets: [{
                            label: 'Number of Attempts',
                            data: attemptCounts,
                            backgroundColor: backgroundColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            r: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                },
                                title: {
                                    display: false, // Hide radial axis title
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom' // Display legend at the bottom
                            },
                            title: {
                                display: false // Hide chart title (already have section title)
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += context.formattedValue;

                                        const dataIndex = context.dataIndex;
                                        const users = quizAttemptsData[dataIndex].users;

                                        if (users && users.length > 0) {
                                            label += '\nUsers: ' + users.join(', ');
                                        } else {
                                            label += '\nNo users attempted this quiz.';
                                        }

                                        return label;
                                    }
                                }
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
