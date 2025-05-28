<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Kinerja Employee') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-6">{{ __('Generate Laporan Kinerja') }}</h3>

                   <form id="reportForm" method="POST" action="{{ route('admin.performance.download') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Filter Kursus -->
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-900">{{ __('Filter Kursus') }}</h4>

                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="course_filter" value="all" class="form-radio" checked>
                                        <span class="ml-2">{{ __('Semua Kursus') }}</span>
                                    </label>
                                </div>

                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="course_filter" value="specific" class="form-radio">
                                        <span class="ml-2">{{ __('Kursus Tertentu') }}</span>
                                    </label>
                                </div>

                                <div id="courseSelection" class="ml-6 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Pilih Kursus') }}
                                    </label>
                                    <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-md p-3 space-y-2">
                                        @foreach($courses as $course)
                                            <label class="inline-flex items-center w-full">
                                                <input type="checkbox" name="course_ids[]" value="{{ $course->id }}" class="form-checkbox">
                                                <span class="ml-2 text-sm">{{ $course->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Employee -->
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-900">{{ __('Filter Employee') }}</h4>

                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="employee_filter" value="all" class="form-radio" checked>
                                        <span class="ml-2">{{ __('Semua Employee') }}</span>
                                    </label>
                                </div>

                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="employee_filter" value="specific" class="form-radio">
                                        <span class="ml-2">{{ __('Employee Tertentu') }}</span>
                                    </label>
                                </div>

                                <div id="employeeSelection" class="ml-6 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Pilih Employee') }}
                                    </label>
                                    <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-md p-3 space-y-2">
                                        @foreach($employees as $employee)
                                            <label class="inline-flex items-center w-full">
                                                <input type="checkbox" name="employee_ids[]" value="{{ $employee->id }}" class="form-checkbox">
                                                <span class="ml-2 text-sm">{{ $employee->name }} ({{ $employee->email }})</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Tanggal -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Tanggal Mulai') }}
                                </label>
                                <input type="date" name="date_from" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Tanggal Selesai') }}
                                </label>
                                <input type="date" name="date_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Format Output -->
                        <div class="mt-6">
                            <h4 class="font-medium text-gray-900 mb-3">{{ __('Format Laporan') }}</h4>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="format" value="pdf" class="form-radio" checked>
                                    <span class="ml-2">{{ __('PDF') }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex flex-col sm:flex-row gap-4">
                            <button type="button" id="previewBtn" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ __('Preview Data') }}
                            </button>

                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ __('Download Laporan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview Modal -->
            <div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Preview Data Laporan') }}</h3>
                            <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div id="previewContent" class="max-h-96 overflow-y-auto">
                            <!-- Preview content will be loaded here -->
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button id="closeModalBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                {{ __('Tutup') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle course filter toggle
            const courseRadios = document.querySelectorAll('input[name="course_filter"]');
            const courseSelection = document.getElementById('courseSelection');

            courseRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'specific') {
                        courseSelection.classList.remove('hidden');
                    } else {
                        courseSelection.classList.add('hidden');
                        // Uncheck all course checkboxes
                        const courseCheckboxes = courseSelection.querySelectorAll('input[type="checkbox"]');
                        courseCheckboxes.forEach(cb => cb.checked = false);
                    }
                });
            });

            // Handle employee filter toggle
            const employeeRadios = document.querySelectorAll('input[name="employee_filter"]');
            const employeeSelection = document.getElementById('employeeSelection');

            employeeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'specific') {
                        employeeSelection.classList.remove('hidden');
                    } else {
                        employeeSelection.classList.add('hidden');
                        // Uncheck all employee checkboxes
                        const employeeCheckboxes = employeeSelection.querySelectorAll('input[type="checkbox"]');
                        employeeCheckboxes.forEach(cb => cb.checked = false);
                    }
                });
            });

            // Handle preview button
            const previewBtn = document.getElementById('previewBtn');
            const previewModal = document.getElementById('previewModal');
            const previewContent = document.getElementById('previewContent');
            const closeModal = document.getElementById('closeModal');
            const closeModalBtn = document.getElementById('closeModalBtn');

            previewBtn.addEventListener('click', function() {
                const formData = new FormData(document.getElementById('reportForm'));

                // Show loading
                previewContent.innerHTML = '<div class="text-center py-4">Loading...</div>';
                previewModal.classList.remove('hidden');

                // Make AJAX request
               fetch('{{ route("admin.performance.preview") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayPreviewData(data.data);
                    } else {
                        previewContent.innerHTML = '<div class="text-red-600 text-center py-4">Error: ' + data.message + '</div>';
                    }
                })
                .catch(error => {
                    previewContent.innerHTML = '<div class="text-red-600 text-center py-4">Terjadi kesalahan saat memuat data.</div>';
                });
            });

            // Close modal handlers
            [closeModal, closeModalBtn].forEach(btn => {
                btn.addEventListener('click', function() {
                    previewModal.classList.add('hidden');
                });
            });

            // Close modal when clicking outside
            previewModal.addEventListener('click', function(e) {
                if (e.target === previewModal) {
                    previewModal.classList.add('hidden');
                }
            });

            function displayPreviewData(data) {
                let html = `
                    <div class="space-y-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 mb-2">Ringkasan Laporan</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="text-blue-700 font-medium">Total Employee:</span>
                                    <div class="text-blue-900 font-semibold">${data.summary.total_employees}</div>
                                </div>
                                <div>
                                    <span class="text-blue-700 font-medium">Total Kursus:</span>
                                    <div class="text-blue-900 font-semibold">${data.summary.total_courses}</div>
                                </div>
                                <div>
                                    <span class="text-blue-700 font-medium">Total Quiz Attempts:</span>
                                    <div class="text-blue-900 font-semibold">${data.summary.total_quiz_attempts}</div>
                                </div>
                                <div>
                                    <span class="text-blue-700 font-medium">Rata-rata Skor:</span>
                                    <div class="text-blue-900 font-semibold">${Math.round(data.summary.average_score * 10) / 10}%</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Sample Data Employee (5 pertama):</h4>
                            <div class="space-y-3">
                `;

                data.employees.slice(0, 5).forEach(employee => {
                    html += `
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="font-medium text-gray-900">${employee.info.name}</div>
                            <div class="text-sm text-gray-600">${employee.info.email}</div>
                            <div class="mt-2 grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span class="text-gray-500">Kursus Enrolled:</span>
                                    <span class="font-medium">${employee.overall_performance.courses_enrolled}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Kursus Selesai:</span>
                                    <span class="font-medium">${employee.overall_performance.courses_completed}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Total Quiz:</span>
                                    <span class="font-medium">${employee.quiz_performance.total_attempts}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Rata-rata Skor:</span>
                                    <span class="font-medium">${Math.round(employee.quiz_performance.average_score * 10) / 10}%</span>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += `
                            </div>
                        </div>
                    </div>
                `;

                previewContent.innerHTML = html;
            }

            // Form validation
            document.getElementById('reportForm').addEventListener('submit', function(e) {
                const courseFilter = document.querySelector('input[name="course_filter"]:checked').value;
                const employeeFilter = document.querySelector('input[name="employee_filter"]:checked').value;

                if (courseFilter === 'specific') {
                    const selectedCourses = document.querySelectorAll('input[name="course_ids[]"]:checked');
                    if (selectedCourses.length === 0) {
                        e.preventDefault();
                        alert('Silakan pilih minimal satu kursus.');
                        return;
                    }
                }

                if (employeeFilter === 'specific') {
                    const selectedEmployees = document.querySelectorAll('input[name="employee_ids[]"]:checked');
                    if (selectedEmployees.length === 0) {
                        e.preventDefault();
                        alert('Silakan pilih minimal satu employee.');
                        return;
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
