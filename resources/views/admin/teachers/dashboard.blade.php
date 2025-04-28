<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Teacher Dashboard') }}
            </h2>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                Last updated: {{ now()->format('d M Y, H:i') }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @else
                <!-- Welcome Card -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 overflow-hidden shadow-lg rounded-lg mb-6">
                    <div class="p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="text-blue-100">
                            Ringkasan aktivitas pembelajaran Anda.
                            @if($totalCourses > 0)
                                Anda memiliki {{ $totalCourses }} kursus dengan {{ $studentsCount }} siswa terdaftar.
                            @else
                                Mulai buat kursus pertama Anda sekarang.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Total Courses Card -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg transition duration-300 hover:shadow-md">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-3xl font-bold text-gray-800">{{ $totalCourses }}</div>
                                    <div class="text-gray-500">Total Kursus</div>
                                </div>
                                <div class="text-blue-500 p-3 bg-blue-100 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('admin.courses.index') }}" class="text-sm text-blue-600 hover:underline">Lihat semua kursus</a>
                            </div>
                        </div>
                    </div>

                    <!-- Active Courses Card -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg transition duration-300 hover:shadow-md">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-3xl font-bold text-gray-800">{{ $activeCourses }}</div>
                                    <div class="text-gray-500">Kursus Aktif</div>
                                </div>
                                <div class="text-green-500 p-3 bg-green-100 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="text-sm text-gray-600">{{ $activeCourses > 0 ? number_format(($activeCourses / $totalCourses) * 100, 0) : 0 }}% dari total kursus</span>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Courses Card -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg transition duration-300 hover:shadow-md">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-3xl font-bold text-gray-800">{{ $completedCourses }}</div>
                                    <div class="text-gray-500">Kursus Selesai</div>
                                </div>
                                <div class="text-purple-500 p-3 bg-purple-100 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="text-sm text-gray-600">{{ $completedCourses > 0 ? number_format(($completedCourses / $totalCourses) * 100, 0) : 0 }}% dari total kursus</span>
                            </div>
                        </div>
                    </div>

                    <!-- Students Count Card -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg transition duration-300 hover:shadow-md">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-3xl font-bold text-gray-800">{{ $studentsCount }}</div>
                                    <div class="text-gray-500">Jumlah Siswa</div>
                                </div>
                                <div class="text-amber-500 p-3 bg-amber-100 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="text-sm text-gray-600">{{ $totalCourses > 0 ? number_format($studentsCount / $totalCourses, 1) : 0 }} siswa per kursus</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Activity Column (2/3 Width) -->
                    <div class="lg:col-span-2">
                        <!-- Recent Courses List -->
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                            <div class="p-6 border-b border-gray-200">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-bold">Kursus Terbaru</h3>
                                    <a href="{{ route('admin.courses.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600 transition">
                                        Tambah Kursus
                                    </a>
                                </div>

                                @if ($recentCourses->count() > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white rounded-lg overflow-hidden">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kursus</th>
                                                    <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                                    <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                                    <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                                    <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @foreach ($recentCourses as $course)
                                                    <tr class="hover:bg-gray-50 transition">
                                                        <td class="py-3 px-4 text-sm">
                                                            <div class="font-medium text-gray-900">{{ $course->name }}</div>
                                                            <div class="text-xs text-gray-500">{{ $course->created_at->format('d M Y') }}</div>
                                                        </td>
                                                        <td class="py-3 px-4 text-sm text-gray-500">{{ Str::limit($course->description, 50) }}</td>
                                                        <td class="py-3 px-4 text-sm text-gray-500">{{ $course->duration }} menit</td>
                                                        <td class="py-3 px-4 text-sm text-gray-500">
                                                            {{ $course->employees()->count() }}
                                                        </td>
                                                        <td class="py-3 px-4 text-sm">
                                                            <div class="flex space-x-2">
                                                                <a href="{{ route('admin.courses.show', $course->id) }}" class="text-blue-500 hover:text-blue-700">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                </a>
                                                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="text-yellow-500 hover:text-yellow-700">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-4 text-right">
                                        <a href="{{ route('admin.courses.index') }}" class="text-sm text-blue-600 hover:underline">
                                            Lihat semua kursus →
                                        </a>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <p class="mt-2 text-gray-500">Belum ada kursus.</p>
                                        <a href="{{ route('admin.courses.create') }}" class="mt-3 inline-block px-4 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600 transition">
                                            Buat Kursus Pertama
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Recent Activity Section -->
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-xl font-bold mb-4">Aktivitas Terbaru</h3>

                                <div class="border-l-2 border-blue-500 pl-4 space-y-6">
                                    @if($recentCourses->count() > 0)
                                        @foreach($recentCourses as $index => $course)
                                            @if($index < 3)
                                                <div class="pb-4">
                                                    <div class="flex items-start">
                                                        <div class="bg-blue-100 p-2 rounded-full mr-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-medium">Kursus baru dibuat: <span class="text-blue-600">{{ $course->name }}</span></div>
                                                            <div class="text-xs text-gray-500">{{ $course->created_at->diffForHumans() }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        <!-- Enrollment Activity (Simulated) -->
                                        <div class="pb-4">
                                            <div class="flex items-start">
                                                <div class="bg-green-100 p-2 rounded-full mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium">{{ $studentsCount > 0 ? $studentsCount : 'Beberapa' }} siswa terdaftar di kursus Anda</div>
                                                    <div class="text-xs text-gray-500">Minggu ini</div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-gray-500 italic">Belum ada aktivitas terbaru.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Column (1/3 Width) -->
                    <div>
                        <!-- Teacher Profile Card -->
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="bg-gray-200 rounded-full h-16 w-16 flex items-center justify-center text-gray-600 text-xl font-bold mr-4">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ Auth::user()->name }}</h3>
                                        <p class="text-sm text-gray-500">Guru</p>
                                    </div>
                                </div>

                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ Auth::user()->email }}
                                    </div>
                                    @if(Auth::user()->teacher->specialization)
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ Auth::user()->teacher->specialization }}
                                    </div>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('profile.edit') }}" class="text-sm text-blue-600 hover:underline">
                                        Edit Profil
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Links Card -->
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4">Menu Cepat</h3>
                                <nav class="space-y-2">
                                    <a href="{{ route('admin.courses.create') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span>Tambah Kursus Baru</span>
                                    </a>
                                    <a href="{{ route('admin.courses.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <span>Kelola Kursus</span>
                                    </a>
                                    <a href="#" class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>Lihat Siswa</span>
                                    </a>
                                    <a href="#" class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        <span>Laporan dan Statistik</span>
                                    </a>
                                </nav>
                            </div>
                        </div>

                        <!-- Tips Card -->
                        <div class="bg-indigo-50 overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-2 text-indigo-700">Tips Mengajar</h3>
                                <p class="text-sm text-indigo-600 mb-4">Beberapa tips untuk meningkatkan kualitas pengajaran Anda:</p>
                                <ul class="text-sm text-indigo-600 space-y-2">
                                    <li class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Gunakan video pendek untuk menjelaskan konsep-konsep penting</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Tambahkan kuis untuk membantu siswa mengevaluasi pemahaman</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Berikan umpan balik yang konsisten dan konstruktif</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
