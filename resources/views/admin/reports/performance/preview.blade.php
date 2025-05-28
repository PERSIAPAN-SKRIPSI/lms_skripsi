<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Preview Laporan Kinerja
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Ringkasan</h3>
                        <div class="mt-4 bg-gray-100 p-4 rounded-md">
                            <p><strong>Total Karyawan:</strong> {{ $reportData['summary']['total_employees'] }}</p>
                            <p><strong>Total Kursus:</strong> {{ $reportData['summary']['total_courses'] }}</p>
                            <p><strong>Total Percobaan Kuis:</strong> {{ $reportData['summary']['total_quiz_attempts'] }}</p>
                            <p><strong>Rata-rata Skor:</strong> {{ number_format($reportData['summary']['average_score'], 2) }}</p>
                            <p><strong>Tingkat Penyelesaian:</strong> {{ number_format($reportData['summary']['completion_rate'], 2) }}%</p>
                            @if($reportData['filters']['date_from'] || $reportData['filters']['date_to'])
                                <p><strong>Periode:</strong>
                                    {{ $reportData['filters']['date_from'] ? \Carbon\Carbon::parse($reportData['filters']['date_from'])->format('d/m/Y') : 'Awal' }}
                                    -
                                    {{ $reportData['filters']['date_to'] ? \Carbon\Carbon::parse($reportData['filters']['date_to'])->format('d/m/Y') : 'Sekarang' }}
                                </p>
                            @endif
                            <p><strong>Dibuat pada:</strong> {{ $reportData['generated_at']->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    @foreach($reportData['employees'] as $employee)
                        <div class="mb-6 p-4 bg-white rounded-md shadow">
                            <h4 class="font-bold text-lg">{{ $employee['info']['name'] }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                <div>
                                    <p><strong>Email:</strong> {{ $employee['info']['email'] }}</p>
                                    <p><strong>NIK:</strong> {{ $employee['info']['nik'] }}</p>
                                    <p><strong>Divisi:</strong> {{ $employee['info']['division'] ?? '-' }}</p>
                                    <p><strong>Posisi:</strong> {{ $employee['info']['position'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <h5 class="font-semibold">Performa Kuis</h5>
                                    <p><strong>Total Percobaan:</strong> {{ $employee['quiz_performance']['total_attempts'] }}</p>
                                    <p><strong>Rata-rata Skor:</strong> {{ number_format($employee['quiz_performance']['average_score'], 2) }}</p>
                                    <p><strong>Kuis Lulus:</strong> {{ $employee['quiz_performance']['passed_quizzes'] }}</p>
                                    <p><strong>Kuis Gagal:</strong> {{ $employee['quiz_performance']['failed_quizzes'] }}</p>
                                </div>
                            </div>

                            <h5 class="mt-4 font-semibold">Performa Kursus</h5>
                            <div class="mt-2 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kursus</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pendaftaran</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($employee['courses'] as $course)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $course['name'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $course['status'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($course['completion_percentage'], 2) }}%</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $course['enrolled_at'] ? \Carbon\Carbon::parse($course['enrolled_at'])->format('d/m/Y') : '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $course['completed_at'] ? \Carbon\Carbon::parse($course['completed_at'])->format('d/m/Y') : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-6">
                        <a href="{{ route('admin.reports.performance.download', $reportData['filters']) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Download PDF
                        </a>
                        <a href="{{ route('admin.reports.performance.index') }}"
                           class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
