<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight animate-fade-in">
            {{ __('Quiz Completion Monitoring') }}
        </h2>
    </x-slot>

    <!-- Main Content -->
    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section with Animation -->
            <div class="mb-10 p-6 bg-white rounded-xl shadow-lg transform transition-all duration-500 hover:scale-102 hover:shadow-2xl animate-pulse-once">
                <h3 class="text-xl font-bold text-indigo-700">{{ __('Welcome to Quiz Insights!') }}</h3>
                <p class="mt-2 text-gray-600">Track quiz completions, identify popular quizzes, and analyze user engagement with interactive visuals.</p>
            </div>

         <!-- Stats Cards Row with Animation -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
    <!-- Completed Quizzes Card (Ikon Dipertahankan) -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 animate-slide-up">
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-white">
            <div class="flex items-center justify-between">
                <h3 class="text-gray-600 text-sm font-medium">{{ __('Completed Quizzes') }}</h3>
                <div class="bg-green-100 p-2 rounded-full animate-pulse-slow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <h2 class="text-4xl font-extrabold text-green-700">{{ $completedQuizzesCount }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Total quizzes completed by users') }}</p>
            </div>
        </div>
    </div>

    <!-- Most Attempted Quiz Card (Ikon Baru: Trending Up) -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 animate-slide-up delay-200">
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
            <div class="flex items-center justify-between">
                <h3 class="text-gray-600 text-sm font-medium">{{ __('Most Attempted Quiz') }}</h3>
                <div class="bg-blue-100 p-2 rounded-full animate-pulse-slow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                @if($mostAttemptedQuiz && $mostAttemptedQuiz->quiz)
                    <h2 class="text-xl font-bold text-blue-700">{{ $mostAttemptedQuiz->quiz->title }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ __('Attempted') }} {{ $mostAttemptedQuiz->total_attempts }} {{ __('times') }}</p>
                @else
                    <h2 class="text-xl font-bold text-gray-400">{{ __('N/A') }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ __('No quizzes attempted yet') }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Least Attempted Quiz Card (Ikon Baru: Trending Down) -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 animate-slide-up delay-400">
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-red-50 to-white">
            <div class="flex items-center justify-between">
                <h3 class="text-gray-600 text-sm font-medium">{{ __('Least Attempted Quiz') }}</h3>
                <div class="bg-red-100 p-2 rounded-full animate-pulse-slow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                @if($leastAttemptedQuiz && $leastAttemptedQuiz->quiz)
                    <h2 class="text-xl font-bold text-red-700">{{ $leastAttemptedQuiz->quiz->title }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ __('Attempted') }} {{ $leastAttemptedQuiz->total_attempts }} {{ __('times') }}</p>
                @else
                    <h2 class="text-xl font-bold text-gray-400">{{ __('N/A') }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ __('No quizzes attempted yet') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

            <!-- Chart Section with Modern Design -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 hover:shadow-2xl animate-grow">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white">
                    <h3 class="text-lg font-semibold text-indigo-800">{{ __('Quiz Attempts Distribution') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Explore the proportion of attempts for each quiz and see participating users.') }}</p>
                </div>
                <div class="p-6">
                    <div class="relative" style="height: 400px;">
                        <canvas id="quizAttemptsChart" class="w-full h-full"></canvas>
                    </div>
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

                const quizAttemptsData = {!! json_encode($quizAttempts) !!};

                const quizTitles = quizAttemptsData.map(item => item.quiz_title || 'Untitled Quiz');
                const attemptCounts = quizAttemptsData.map(item => item.attempt_count);

                const backgroundColors = quizTitles.map(() => {
                    const r = Math.floor(Math.random() * 200 + 50);
                    const g = Math.floor(Math.random() * 200 + 50);
                    const b = Math.floor(Math.random() * 200 + 50);
                    return `rgba(${r}, ${g}, ${b}, 0.7)`;
                });

                const quizAttemptsChart = new Chart(quizAttemptsChartCanvas, {
                    type: 'polarArea',
                    data: {
                        labels: quizTitles,
                        datasets: [{
                            label: 'Number of Attempts',
                            data: attemptCounts,
                            backgroundColor: backgroundColors,
                            borderColor: backgroundColors.map(color => color.replace('0.7', '1')),
                            borderWidth: 2,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 14
                                    },
                                    color: '#4B5563'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) label += ': ';
                                        label += context.formattedValue;

                                        const dataIndex = context.dataIndex;
                                        const users = quizAttemptsData[dataIndex].users || [];

                                        if (users.length > 0) {
                                            label += '\nUsers: ' + users.join(', ');
                                        } else {
                                            label += '\nNo users attempted this quiz.';
                                        }
                                        return label;
                                    }
                                },
                                backgroundColor: '#1F2937',
                                titleColor: '#FFFFFF',
                                bodyColor: '#FFFFFF'
                            }
                        },
                        scales: {
                            r: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    color: '#6B7280'
                                },
                                grid: {
                                    color: '#E5E7EB'
                                }
                            }
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeOutBounce'
                        }
                    }
                });
            });

            // Custom Animations
            document.querySelectorAll('.animate-slide-up').forEach((el, index) => {
                el.style.transitionDelay = `${index * 0.2}s`;
            });

            document.querySelector('.animate-grow').style.transitionDelay = '0.6s';

            const animateFadeIn = document.querySelector('.animate-fade-in');
            if (animateFadeIn) animateFadeIn.style.animationDelay = '0.2s';

            const animatePulseOnce = document.querySelector('.animate-pulse-once');
            if (animatePulseOnce) animatePulseOnce.style.animation = 'pulse 2s 1';

            const animatePulseSlow = document.querySelectorAll('.animate-pulse-slow');
            animatePulseSlow.forEach(el => {
                el.style.animation = 'pulse 3s infinite';
            });
        </script>

        <style>
            @keyframes slideUp {
                from { transform: translateY(20px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }

            @keyframes grow {
                from { transform: scale(0.9); opacity: 0; }
                to { transform: scale(1); opacity: 1; }
            }

            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.1); }
                100% { transform: scale(1); }
            }

            .animate-slide-up {
                animation: slideUp 0.5s ease-out forwards;
            }

            .animate-grow {
                animation: grow 0.6s ease-out forwards;
            }

            .animate-fade-in {
                animation: fadeIn 0.5s ease-in-out forwards;
            }

            .animate-pulse-once {
                animation: pulse 2s 1;
            }

            .animate-pulse-slow {
                animation: pulse 3s infinite;
            }
        </style>
    @endpush
</x-app-layout>
