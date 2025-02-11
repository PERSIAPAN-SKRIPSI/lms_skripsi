<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Total Courses Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="text-2xl font-bold">{{ $totalCourses }}</div>
                            <div class="text-gray-500">Total Courses</div>
                        </div>
                    </div>

                    <!-- Active Courses Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="text-2xl font-bold">{{ $activeCourses }}</div>
                            <div class="text-gray-500">Active Courses</div>
                        </div>
                    </div>

                    <!-- Completed Courses Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="text-2xl font-bold">{{ $completedCourses }}</div>
                            <div class="text-gray-500">Completed Courses</div>
                        </div>
                    </div>
                    <!-- Students Count Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="text-2xl font-bold">{{ $studentsCount }}</div>
                            <div class="text-gray-500">Jumlah Student</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Courses List -->
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-xl font-bold mb-4">Recent Courses</h3>
                        @if ($recentCourses->count() > 0)
                            <ul>
                                @foreach ($recentCourses as $course)
                                    <li class="py-2">
                                        <a href="{{ route('courses.show', $course->id) }}" class="text-blue-500 hover:underline">{{ $course->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No recent courses.</p>
                        @endif
                    </div>
                </div>

            @endif
        </div>
    </div>
</x-app-layout>
