<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz Performance Monitoring') }}
        </h2>
    </x-slot>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Total Quizzes Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-500 text-sm font-medium">{{ __('Total Quizzes') }}</h3>
                            <div class="bg-indigo-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <h2 class="text-3xl font-bold text-gray-800">{{ $totalQuizzes }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Available for employees') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Attempts Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-500 text-sm font-medium">{{ __('Total Attempts') }}</h3>
                            <div class="bg-emerald-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <h2 class="text-3xl font-bold text-gray-800">{{ $totalAttempts }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Quiz attempts by employees') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Average Score Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-500 text-sm font-medium">{{ __('Average Score') }}</h3>
                            <div class="bg-amber-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <h2 class="text-3xl font-bold text-gray-800">{{ number_format($averageScore, 1) }}%</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Across all attempts') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Passing Rate Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-500 text-sm font-medium">{{ __('Passing Rate') }}</h3>
                            <div class="bg-purple-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <h2 class="text-3xl font-bold text-gray-800">{{ number_format($passingRate, 1) }}%</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Success rate') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                <!-- Performance Chart -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">{{ __('Employee Performance by Quiz') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('Key metrics for each quiz') }}</p>
                    </div>
                    <div class="p-5">
                        <canvas id="radarChart" height="400"></canvas>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('Advanced Filters') }}</h3>
                </div>
                <div class="p-5">
                    <form id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="dateRange"
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date Range') }}</label>
                            <select id="dateRange" name="dateRange"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="7">{{ __('Last 7 Days') }}</option>
                                <option value="30">{{ __('Last 30 Days') }}</option>
                                <option value="90">{{ __('Last 90 Days') }}</option>
                                <option value="all" selected>{{ __('All Time') }}</option>
                            </select>
                        </div>

                        <div>
                            <label for="quizFilter"
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('Filter by Quiz') }}</label>
                            <select id="quizFilter" name="quizFilter"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="all" selected>{{ __('All Quizzes') }}</option>
                                @foreach($quizzes as $quiz)
                                    <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="statusFilter"
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('Status') }}</label>
                            <select id="statusFilter" name="statusFilter"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="all" selected>{{ __('All Statuses') }}</option>
                                <option value="passed">{{ __('Passed') }}</option>
                                <option value="failed">{{ __('Failed') }}</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Charts -->
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            Chart.register(ChartDataLabels);
            // Your JavaScript code for charts goes here
            // Radar Chart for Employee Quiz Performance
            document.addEventListener('DOMContentLoaded', function() {
                // Get the canvas element
                const radarChartCanvas = document.getElementById('radarChart');

                if (!radarChartCanvas) return;

                let radarChart; // Declare radarChart outside the filter function

                function createRadarChart(quizPerformanceData) {
                    // Extract the quiz names for labels
                    const quizNames = quizPerformanceData.map(item => item.quiz_name);

                    // Extract datasets
                    const attemptCountData = quizPerformanceData.map(item => item.attempt_count);
                    const correctAnswersData = quizPerformanceData.map(item => item.correct_answers_avg);
                    const timeRequiredData = quizPerformanceData.map(item => item.time_required_avg);
                    const employeeCountData = quizPerformanceData.map(item => item.employee_count);

                    // Destroy the previous chart instance if it exists
                    if (radarChart) {
                        radarChart.destroy();
                    }

                    // Create the radar chart
                    radarChart = new Chart(radarChartCanvas, {
                        type: 'radar',
                        data: {
                            labels: quizNames,
                            datasets: [{
                                    label: 'Number of Employees',
                                    data: employeeCountData,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgb(75, 192, 192)',
                                    pointBackgroundColor: 'rgb(75, 192, 192)',
                                    pointBorderColor: '#fff',
                                    pointHoverBackgroundColor: '#fff',
                                    pointHoverBorderColor: 'rgb(75, 192, 192)'
                                },
                                {
                                    label: 'Average Attempts per Employee',
                                    data: attemptCountData,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgb(255, 99, 132)',
                                    pointBackgroundColor: 'rgb(255, 99, 132)',
                                    pointBorderColor: '#fff',
                                    pointHoverBackgroundColor: '#fff',
                                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                                },
                                {
                                    label: 'Average Correct Answers',
                                    data: correctAnswersData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgb(54, 162, 235)',
                                    pointBackgroundColor: 'rgb(54, 162, 235)',
                                    pointBorderColor: '#fff',
                                    pointHoverBackgroundColor: '#fff',
                                    pointHoverBorderColor: 'rgb(54, 162, 235)'
                                },
                                {
                                    label: 'Average Time Required (mins)',
                                    data: timeRequiredData,
                                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                    borderColor: 'rgb(255, 159, 64)',
                                    pointBackgroundColor: 'rgb(255, 159, 64)',
                                    pointBorderColor: '#fff',
                                    pointHoverBackgroundColor: '#fff',
                                    pointHoverBorderColor: 'rgb(255, 159, 64)'
                                }
                            ]
                        },
                        options: {
                            elements: {
                                line: {
                                    borderWidth: 3
                                }
                            },
                            scales: {
                                r: {
                                    angleLines: {
                                        display: true
                                    },
                                    suggestedMin: 0
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Employee Quiz Performance Metrics',
                                    font: {
                                        size: 16
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed.r !== null) {
                                                label += context.parsed.r;
                                                if (context.dataset.label === 'Average Time Required (mins)') {
                                                    label += ' mins';
                                                }
                                            }
                                            return label;
                                        }
                                    }
                                },
                                 datalabels: {
                                    anchor: 'end',
                                    align: 'start',
                                    formatter: Math.round,
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            },
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                }

                // Initial chart creation with initial data
                createRadarChart({!! json_encode($quizPerformanceData) !!});

                // Function to handle filter changes
                function applyFilters() {
                    const dateRange = $('#dateRange').val();
                    const quizFilter = $('#quizFilter').val();
                    const statusFilter = $('#statusFilter').val();

                    // Make an AJAX request to get filtered data
                    $.ajax({
                        url: '{{ route('admin.quizzes.monitoring.performance.filter') }}', // Replace with your route
                        method: 'GET',
                        data: {
                            dateRange: dateRange,
                            quizFilter: quizFilter,
                            statusFilter: statusFilter
                        },
                        success: function(response) {
                            // Update the chart with the new data
                            createRadarChart(response.quizPerformanceData);

                            // Optionally, update the stats cards as well
                            $('.text-3xl[data-stat="totalQuizzes"]').text(response.totalQuizzes);
                            $('.text-3xl[data-stat="totalAttempts"]').text(response.totalAttempts);
                            $('.text-3xl[data-stat="averageScore"]').text(response.averageScore ? response.averageScore.toFixed(1) + '%' : '0%');
                            $('.text-3xl[data-stat="passingRate"]').text(response.passingRate ? response.passingRate.toFixed(1) + '%' : '0%');
                        },
                        error: function(error) {
                            console.error('Error fetching filtered data:', error);
                        }
                    });
                }

                // Attach the applyFilters function to the change event of each filter
                $('#dateRange, #quizFilter, #statusFilter').on('change', applyFilters);
            });
        </script>
    @endpush
</x-app-layout>
