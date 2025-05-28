<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kinerja Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            color: #007bff;
            font-size: 24px;
        }

        .header .subtitle {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }

        .filter-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }

        .filter-info h3 {
            margin: 0 0 10px 0;
            color: #007bff;
            font-size: 16px;
        }

        .filter-row {
            display: inline-block;
            width: 48%;
            vertical-align: top;
            margin-right: 2%;
        }

        .summary-section {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .summary-section h3 {
            margin: 0 0 15px 0;
            color: #1976d2;
            font-size: 18px;
        }

        .summary-grid {
            display: table;
            width: 100%;
        }

        .summary-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
            border-right: 1px solid #90caf9;
        }

        .summary-item:last-child {
            border-right: none;
        }

        .summary-item .value {
            font-size: 20px;
            font-weight: bold;
            color: #1976d2;
            display: block;
        }

        .summary-item .label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        .employee-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .employee-header {
            background-color: #f5f5f5;
            padding: 12px;
            border-radius: 5px 5px 0 0;
            border-bottom: 2px solid #007bff;
        }

        .employee-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .employee-info {
            color: #666;
            font-size: 11px;
            margin-top: 2px;
        }

        .performance-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .performance-row {
            display: table-row;
        }

        .performance-cell {
            display: table-cell;
            padding: 15px;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }

        .performance-cell h4 {
            margin: 0 0 10px 0;
            color: #495057;
            font-size: 14px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }

        .stat-item {
            margin-bottom: 8px;
            font-size: 11px;
        }

        .stat-label {
            color: #6c757d;
            display: inline-block;
            width: 60%;
        }

        .stat-value {
            font-weight: bold;
            color: #333;
        }

        .courses-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }

        .courses-table th,
        .courses-table td {
            border: 1px solid #dee2e6;
            padding: 6px;
            text-align: left;
        }

        .courses-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }

        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-progress {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-not-started {
            background-color: #f8d7da;
            color: #721c24;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }

        .page-break {
            page-break-before: always;
        }

        @media print {
            body {
                margin: 0;
                padding: 15px;
            }

            .header {
                margin-bottom: 20px;
            }

            .employee-section {
                page-break-inside: avoid;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN KINERJA EMPLOYEE</h1>
        <div class="subtitle">
            Dibuat pada: {{ $generated_at->format('d F Y H:i') }} WIB
        </div>
    </div>

    <!-- Filter Information -->
    <div class="filter-info">
        <h3>Informasi Filter</h3>
        <div class="filter-row">
            <strong>Filter Kursus:</strong>
            {{ $filters['course_filter'] === 'all' ? 'Semua Kursus' : 'Kursus Terpilih' }}
            @if($filters['course_filter'] === 'specific' && isset($filters['course_ids']))
                ({{ count($filters['course_ids']) }} kursus)
            @endif
        </div>
        <div class="filter-row">
            <strong>Filter Employee:</strong>
            {{ $filters['employee_filter'] === 'all' ? 'Semua Employee' : 'Employee Terpilih' }}
            @if($filters['employee_filter'] === 'specific' && isset($filters['employee_ids']))
                ({{ count($filters['employee_ids']) }} employee)
            @endif
        </div>
        @if(isset($filters['date_from']) || isset($filters['date_to']))
            <div style="margin-top: 10px;">
                <strong>Periode:</strong>
                @if(isset($filters['date_from']))
                    {{ \Carbon\Carbon::parse($filters['date_from'])->format('d F Y') }}
                @else
                    Awal
                @endif
                s/d
                @if(isset($filters['date_to']))
                    {{ \Carbon\Carbon::parse($filters['date_to'])->format('d F Y') }}
                @else
                    Sekarang
                @endif
            </div>
        @endif
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <h3>Ringkasan Laporan</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <span class="value">{{ $summary['total_employees'] }}</span>
                <div class="label">Total Employee</div>
            </div>
            <div class="summary-item">
                <span class="value">{{ $summary['total_courses'] }}</span>
                <div class="label">Total Kursus</div>
            </div>
            <div class="summary-item">
                <span class="value">{{ $summary['total_quiz_attempts'] }}</span>
                <div class="label">Total Quiz Attempts</div>
            </div>
            <div class="summary-item">
                <span class="value">{{ number_format($summary['average_score'], 1) }}%</span>
                <div class="label">Rata-rata Skor Quiz</div>
            </div>
            <div class="summary-item">
                <span class="value">{{ number_format($summary['completion_rate'], 1) }}%</span>
                <div class="label">Tingkat Penyelesaian</div>
            </div>
        </div>
    </div>

    <!-- Employee Details -->
    @foreach($employees as $index => $employee)
        @if($index > 0 && $index % 2 === 0)
            <div class="page-break"></div>
        @endif

        <div class="employee-section">
            <div class="employee-header">
                <div class="employee-name">{{ $employee['info']['name'] }}</div>
                <div class="employee-info">
                    {{ $employee['info']['email'] }}
                    @if(isset($employee['info']['nik']) && $employee['info']['nik'])
                        | NIK: {{ $employee['info']['nik'] }}
                    @endif
                    @if(isset($employee['info']['division']) && $employee['info']['division'])
                        | {{ $employee['info']['division'] }}
                    @endif
                    @if(isset($employee['info']['position']) && $employee['info']['position'])
                        | {{ $employee['info']['position'] }}
                    @endif
                </div>
            </div>

            <div class="performance-grid">
                <div class="performance-row">
                    <!-- Overall Performance -->
                    <div class="performance-cell" style="width: 30%;">
                        <h4>Kinerja Keseluruhan</h4>
                        <div class="stat-item">
                            <span class="stat-label">Kursus Enrolled:</span>
                            <span class="stat-value">{{ $employee['overall_performance']['courses_enrolled'] }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Kursus Selesai:</span>
                            <span class="stat-value">{{ $employee['overall_performance']['courses_completed'] }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Tingkat Penyelesaian:</span>
                            <span class="stat-value">{{ number_format($employee['overall_performance']['completion_percentage'], 1) }}%</span>
                        </div>
                    </div>

                    <!-- Quiz Performance -->
                    <div class="performance-cell" style="width: 30%;">
                        <h4>Performa Quiz</h4>
                        <div class="stat-item">
                            <span class="stat-label">Total Attempts:</span>
                            <span class="stat-value">{{ $employee['quiz_performance']['total_attempts'] }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Quiz Lulus:</span>
                            <span class="stat-value">{{ $employee['quiz_performance']['passed_quizzes'] }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Quiz Gagal:</span>
                            <span class="stat-value">{{ $employee['quiz_performance']['failed_quizzes'] }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Rata-rata Skor:</span>
                            <span class="stat-value">{{ number_format($employee['quiz_performance']['average_score'], 1) }}%</span>
                        </div>
                    </div>

                    <!-- Course Details -->
                    <div class="performance-cell" style="width: 40%;">
                        <h4>Detail Kursus</h4>
                        @if(count($employee['courses']) > 0)
                            <table class="courses-table">
                                <thead>
                                    <tr>
                                        <th>Nama Kursus</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee['courses'] as $course)
                                        <tr>
                                            <td>{{ Str::limit($course['name'], 25) }}</td>
                                            <td>
                                                <span class="status-badge
                                                    @if($course['status'] === 'Selesai') status-completed
                                                    @elseif($course['status'] === 'Sedang Berlangsung') status-progress
                                                    @else status-not-started
                                                    @endif
                                                ">
                                                    {{ $course['status'] }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($course['completion_percentage'], 0) }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div style="text-align: center; color: #666; font-style: italic;">
                                Belum ada kursus yang diikuti
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Footer -->
    <div class="footer">
        <div>Laporan ini dibuat secara otomatis oleh sistem</div>
        <div>{{ config('app.name') }} - {{ now()->format('Y') }}</div>
    </div>
</body>
</html>
