<x-app-layout>
    <x-slot name="header">
        <div class="bg-indigo-700 dark:bg-indigo-800 py-4 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Dasbor Admin') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Form Filter -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg mb-8 p-6">
                <form action="{{ route('admin.dashboard') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate ?? '' }}"
                                   class="mt-1 p-2 w-full border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate ?? '' }}"
                                   class="mt-1 p-2 w-full border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div class="hidden lg:block lg:col-span-1"></div>
                        <div class="md:col-span-2 lg:col-span-1 flex flex-col sm:flex-row sm:items-center sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Filter
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto text-center px-5 py-2.5 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md shadow-sm hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sub-header untuk Rentang Tanggal -->
            @if ($startDate || $endDate)
            <div class="mb-6 text-center sm:text-left">
                <p class="text-md font-semibold text-gray-700 dark:text-gray-300">
                    Menampilkan Data Kuis Karyawan untuk: <span class="text-indigo-600 dark:text-indigo-400">{{ $dateRangeDisplay }}</span>
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Total keseluruhan sistem (seperti 'Total Kuis') tidak terpengaruh oleh filter tanggal ini.
                </p>
            </div>
            @endif

            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Kuis (Keseluruhan Sistem) -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Total Kuis') }}</p>
                            <h3 class="mt-1 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalQuizzesSystem }}</h3>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ $totalActiveQuizzesSystem }} Aktif
                            </p>
                        </div>
                        <div class="bg-teal-100 dark:bg-teal-800 p-3 rounded-md ml-2">
                            <svg class="h-6 w-6 text-teal-500 dark:text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">Jumlah keseluruhan sistem</p>
                </div>

                <!-- Percobaan Kuis (Karyawan, Terfilter) -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg p-5">
                     <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Percobaan Karyawan') }}</p>
                            <h3 class="mt-1 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalQuizAttemptsEmployeeFiltered }}</h3>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Oleh {{ $totalUniqueEmployeeAttemptersFiltered }} karyawan unik
                            </p>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-800 p-3 rounded-md ml-2">
                             <svg class="h-6 w-6 text-blue-500 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                        @if ($startDate || $endDate) Terfilter @else Semua waktu (karyawan) @endif
                    </p>
                </div>

                <!-- Skor Rata-rata (Karyawan, Terfilter) -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Rata-rata Skor Karyawan') }}</p>
                            <h3 class="mt-1 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($averageQuizScoreEmployeeFiltered, 1) }}%</h3>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Dari {{ $totalQuizAttemptsEmployeeFiltered }} percobaan
                            </p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-800 p-3 rounded-md ml-2">
                            <svg class="h-6 w-6 text-green-500 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                    </div>
                     <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                        @if ($startDate || $endDate) Terfilter @else Semua waktu (karyawan) @endif
                    </p>
                </div>

                <!-- Tingkat Kelulusan (Karyawan, Terfilter) -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Tingkat Lulus Karyawan') }}</p>
                            <h3 class="mt-1 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($quizPassingRateEmployeeFiltered, 1) }}%</h3>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Dari {{ $totalQuizAttemptsEmployeeFiltered }} percobaan
                            </p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-800 p-3 rounded-md ml-2">
                            <svg class="h-6 w-6 text-purple-500 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                     <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                        @if ($startDate || $endDate) Terfilter @else Semua waktu (karyawan) @endif
                    </p>
                </div>
            </div>

            <!-- Grafik Radar Sederhana -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ __('Ringkasan Kuis Karyawan') }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Metrik utama kuis untuk karyawan.
                        <span id="radarDateRangeInfoSimple" class="block text-xs">
                            @if ($startDate || $endDate)
                                Terfilter:
                                @if ($startDate) Mulai {{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMM YY') }} @endif
                                @if ($endDate) {{ $startDate ? 's/d ' : 'Hingga ' }} {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMM YY') }} @endif
                            @else
                                Data semua waktu.
                            @endif
                        </span>
                    </p>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="relative h-72 sm:h-80 md:h-[350px] min-h-[280px]">
                        <canvas id="simpleRadarChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passingRate = parseFloat({{ $quizPassingRate }});
        const averageScore = parseFloat({{ $averageQuizScore }});
        const totalEmployeeAttempts = parseInt({{ $totalQuizAttempts }});

        const employeeAttempters = @json($employeeAttemptersDetails);
        const startDate = "{{ $startDate ?? '' }}";
        const endDate = "{{ $endDate ?? '' }}";

        const isDarkMode = document.documentElement.classList.contains('dark');

        const themeColors = {
            main: isDarkMode ? 'rgba(99, 102, 241, 0.9)' : 'rgba(79, 70, 229, 0.9)',
            background: isDarkMode ? 'rgba(99, 102, 241, 0.3)' : 'rgba(79, 70, 229, 0.3)',
            grid: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.07)',
            ticks: isDarkMode ? 'rgba(209, 213, 219, 0.5)' : 'rgba(107, 114, 128, 0.5)',
            pointLabel: isDarkMode ? 'rgba(229, 231, 235, 0.7)' : 'rgba(55, 65, 81, 0.7)',
            tooltipBg: isDarkMode ? 'rgba(31, 41, 55, 0.9)' : 'rgba(17, 24, 39, 0.9)',
            pointBorder: isDarkMode ? '#1f2937' : '#fff',
        };

        const chartLabelsSimple = [
            'Tingkat Lulus (%)',
            'Rata-rata Skor (%)',
            'Total Percobaan'
        ];
        const chartDataValuesSimple = [
            passingRate,
            averageScore,
            totalEmployeeAttempts
        ];

        const dataSimple = {
            labels: chartLabelsSimple,
            datasets: [{
                label: 'Kinerja', // Label dataset
                data: chartDataValuesSimple,
                backgroundColor: themeColors.background,
                borderColor: themeColors.main,
                borderWidth: 1.5,
                pointBackgroundColor: themeColors.main,
                pointBorderColor: themeColors.pointBorder,
                pointHoverBackgroundColor: themeColors.pointBorder,
                pointHoverBorderColor: themeColors.main,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        };

        const configSimple = {
            type: 'radar',
            data: dataSimple,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        beginAtZero: true,
                        angleLines: { color: themeColors.grid, lineWidth: 0.5 },
                        grid: { color: themeColors.grid, lineWidth: 0.5 },
                        pointLabels: {
                            color: themeColors.pointLabel,
                            font: { size: 11, weight: 'normal' }
                        },
                        ticks: {
                            color: themeColors.ticks,
                            backdropColor: 'transparent',
                            maxTicksLimit: 5,
                        }
                    }
                },
                elements: { line: { tension: 0.1 } },
                plugins: {
                    legend: { display: false }, // Sembunyikan legenda jika hanya satu dataset
                    tooltip: {
                        enabled: true,
                        backgroundColor: themeColors.tooltipBg,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 10,
                        boxPadding: 3,
                        usePointStyle: true,
                        callbacks: {
                            title: function(tooltipItems) { return tooltipItems[0]?.label || ''; },
                            label: function(context) {
                                let value = context.parsed.r;
                                if (context.label.includes('%')) {
                                    value = value.toFixed(1) + '%';
                                } else {
                                    value = Math.round(value);
                                }
                                return `${context.dataset.label}: ${value}`;
                            },
                            afterBody: function(tooltipItems) {
                                const currentItem = tooltipItems[0];
                                if (currentItem && currentItem.label === chartLabelsSimple[2]) { // 'Total Percobaan'
                                    if (employeeAttempters && employeeAttempters.length > 0) {
                                        let userList = ['\nKaryawan yang Mencoba:'];
                                        employeeAttempters.slice(0, 5).forEach(user => {
                                            userList.push(`• ${user.name}`);
                                        });
                                        if (employeeAttempters.length > 5) {
                                            userList.push(`  ...dan ${employeeAttempters.length - 5} lainnya`);
                                        }
                                        return userList;
                                    } else if (totalEmployeeAttempts === 0 && (startDate || endDate)) {
                                        return ['\nTidak ada percobaan pada periode ini.'];
                                    } else if (totalEmployeeAttempts === 0) {
                                        return ['\nTidak ada percobaan.'];
                                    }
                                }
                                return [];
                            }
                        }
                    }
                }
            }
        };

        const simpleRadarChartCanvas = document.getElementById('simpleRadarChart');
        if (simpleRadarChartCanvas) {
            new Chart(simpleRadarChartCanvas, configSimple);
        } else {
            console.error("Elemen canvas dengan ID 'simpleRadarChart' tidak ditemukan.");
        }
    });
</script>
