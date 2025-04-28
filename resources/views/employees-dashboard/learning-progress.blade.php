<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Learning Progress') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- Use space-y for consistent vertical spacing --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Quiz Performance Overview Cards -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        {{ __('Ringkasan Performa Quiz') }}
                    </h3>
                    <p class="text-sm text-gray-600 mb-6">
                        {{ __('Pantau perkembangan nilai quiz Anda dan tingkatkan keterampilan bersama kami.') }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Total Quiz Card -->
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 shadow-sm">
                            <div class="flex items-center mb-3">
                                <div class="bg-blue-100 text-blue-600 p-3 rounded-full mr-4">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path> {{-- Changed Icon slightly --}}
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-blue-700">{{ __('Total Quiz Dijawab') }}</p>
                                    <h4 class="text-2xl font-bold text-blue-900">{{ $totalQuizzesAttempted ?? 0 }}</h4>
                                </div>
                            </div>
                             <p class="text-xs text-blue-600 mb-3">{{ __('Total percobaan menjawab quiz.') }}</p>
                            <div class="text-right">
                                <a href="#riwayat-quiz" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out">
                                    {{ __('Lihat Riwayat') }} →
                                </a>
                            </div>
                        </div>

                        <!-- Average Score Card -->
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200 shadow-sm">
                           <div class="flex items-center mb-3">
                                <div class="bg-green-100 text-green-600 p-3 rounded-full mr-4">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-green-700">{{ __('Rata-rata Skor') }}</p>
                                    <h4 class="text-2xl font-bold text-green-900">{{ number_format($averageQuizScore ?? 0, 2) }}</h4>
                                </div>
                            </div>
                             <p class="text-xs text-green-600 mb-3">{{ __('Rata-rata skor dari semua percobaan.') }}</p>
                            <div class="text-right">
                                <a href="#analisis-skor" class="text-sm font-medium text-green-600 hover:text-green-800 transition duration-150 ease-in-out">
                                    {{ __('Lihat Grafik') }} →
                                </a>
                            </div>
                        </div>

                        <!-- Highest Score Card -->
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200 shadow-sm">
                            <div class="flex items-center mb-3">
                                <div class="bg-purple-100 text-purple-600 p-3 rounded-full mr-4">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-purple-700">{{ __('Skor Tertinggi') }}</p>
                                    <h4 class="text-2xl font-bold text-purple-900">{{ number_format($highestQuizScore ?? 0, 0) }}</h4>
                                </div>
                            </div>
                             <p class="text-xs text-purple-600 mb-3">{{ __('Nilai tertinggi dari semua percobaan.') }}</p>
                             <div class="text-right">
                                <a href="#performa-terbaik" class="text-sm font-medium text-purple-600 hover:text-purple-800 transition duration-150 ease-in-out">
                                    {{ __('Lihat Detail') }} →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quiz Performance Chart -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" id="analisis-skor">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-1">
                        {{ __('Grafik Performa Quiz per Kursus') }}
                    </h3>
                     <p class="text-sm text-gray-600 mb-4">
                        {{ __('Visualisasi skor tertinggi Anda pada setiap quiz unik, dikelompokkan per kursus.') }}
                    </p>
                    <div class="relative h-96 lg:h-[500px]"> {{-- Set adequate height --}}
                        <canvas id="quizPerformanceRadarChart"></canvas>
                    </div>
                     <p id="chart-fallback-message" class="text-center text-gray-500 mt-4 py-10" style="display: none;">
                        {{ __('Belum ada data skor quiz untuk ditampilkan pada grafik.') }}
                    </p>
                </div>
            </div>

            <!-- Performance by Course Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" id="performa-terbaik">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __('Detail Performa per Kursus') }}
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Kursus') }}</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Quiz Unik Dicoba') }}</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Total Percobaan') }}</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rata-rata Skor') }}</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Skor Tertinggi') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- Use null coalescing operator ?? [] for safety --}}
                                @forelse($scoresByCourse ?? [] as $courseScore)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $courseScore['course_name'] ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-700">{{ $courseScore['unique_quizzes_count'] ?? 0 }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-700">{{ $courseScore['attempts_count'] ?? 0 }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-700">{{ number_format($courseScore['average_score'] ?? 0, 2) }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center font-semibold text-gray-800">{{ number_format($courseScore['highest_score'] ?? 0, 0) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                                            {{ __('Belum ada data performa quiz berdasarkan kursus.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Quiz Attempts Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" id="riwayat-quiz">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __('Riwayat Quiz Terbaru (10 Terakhir)') }}
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Quiz') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Kursus') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Tanggal') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Skor') }}</th>
                                    {{-- Optional: Add Status Column --}}
                                    {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th> --}}
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($quizAttempts ?? [] as $attempt)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $attempt->quiz->title ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{-- Access course name safely --}}
                                            {{ $attempt->quiz?->chapter?->course?->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $attempt->created_at ? $attempt->created_at->format('d M Y, H:i') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                            {{-- Example: Conditional color based on score (assuming 70 is passing) --}}
                                            @php
                                                $score = $attempt->score ?? 0;
                                                // You might need to fetch passing_score if it varies per quiz
                                                $passingScore = $attempt->quiz->passing_score ?? 70;
                                                $isPass = $score >= $passingScore;
                                            @endphp
                                             <span class="{{ $isPass ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($score, 0) }}
                                            </span>
                                        </td>
                                        {{-- Optional: Status Cell --}}
                                         {{-- <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($isPass)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Lulus
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Gagal
                                                </span>
                                            @endif
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500"> {{-- Adjusted colspan if Status added --}}
                                            {{ __('Belum ada riwayat quiz.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div> {{-- End max-w-7xl container --}}
    </div> {{-- End py-12 --}}

    @push('scripts')
    {{-- Include Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script> {{-- Use specific version or latest stable --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radarCtx = document.getElementById('quizPerformanceRadarChart');
            const fallbackMessageEl = document.getElementById('chart-fallback-message');

            // Safely parse JSON data from PHP, defaulting to empty arrays
            const radarLabels = @json($chartLabels ?? []);
            const radarDatasets = @json($chartData ?? []);

            // Only proceed if canvas exists and we have data
            if (radarCtx && radarLabels.length > 0 && radarDatasets.length > 0) {
                // Hide fallback message if chart will be rendered
                if(fallbackMessageEl) fallbackMessageEl.style.display = 'none';

                new Chart(radarCtx, {
                    type: 'radar',
                    data: {
                        labels: radarLabels,   // Quiz titles
                        datasets: radarDatasets // Data per course
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // Allow chart to fill container height
                        scales: {
                            r: { // Radial axis (score)
                                beginAtZero: true,
                                suggestedMin: 0,
                                suggestedMax: 100, // Adjust if max score differs
                                ticks: {
                                    stepSize: 20,
                                    backdropColor: 'rgba(255, 255, 255, 0.7)', // Semi-transparent background for ticks
                                    color: '#6b7280', // text-gray-500
                                },
                                pointLabels: { // Labels around the chart (Quiz Titles)
                                    font: { size: 11 },
                                    color: '#374151', // text-gray-700
                                },
                                grid: { color: '#e5e7eb' }, // gray-200
                                angleLines: { color: '#d1d5db' } // gray-300
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#1f2937', // text-gray-800
                                    padding: 20 // Add some padding below chart
                                }
                            },
                            tooltip: {
                                backgroundColor: '#1f2937', // Tooltip background
                                titleColor: '#ffffff',      // Tooltip title color
                                bodyColor: '#e5e7eb',       // Tooltip body color
                                padding: 10,
                                cornerRadius: 4,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || ''; // Course name
                                        if (label) { label += ': '; }

                                        const score = context.parsed?.r; // Use optional chaining
                                        if (score !== null && score !== undefined) {
                                            // Display 'N/A' if score is 0 (our convention for 'not taken')
                                            label += (score > 0 ? score.toFixed(0) : 'N/A');
                                        } else {
                                            label += 'N/A'; // Fallback
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        elements: {
                            line: { borderWidth: 2 },
                            point: { radius: 3, hoverRadius: 5 }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                    }
                });
            } else if (fallbackMessageEl) {
                // Show fallback message if no data or canvas missing
                fallbackMessageEl.style.display = 'block';
                if (radarCtx) radarCtx.style.display = 'none'; // Hide the canvas element
            }
        });
    </script>
    @endpush
</x-app-layout>
