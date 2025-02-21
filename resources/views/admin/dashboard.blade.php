<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </div>
    </x-slot>

    <div class="py-12" style="background-color: #F8F5F0;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Quizzes Card -->
                <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                    <div class="p-6 border-l-4 border-blue-500">
                        <div class="flex items-start">
                            <div class="p-3 rounded-md bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500 mt-3">{{ __('Total Quizzes') }}</p>
                        <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ $totalQuizzes }}</h3>
                    </div>
                </div>

                <!-- Quiz Attempts Card -->
                <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                    <div class="p-6 border-l-4 border-green-500">
                        <div class="flex items-start">
                            <div class="p-3 rounded-md bg-green-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500 mt-3">{{ __('Total Quiz Attempts') }}</p>
                        <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ $totalQuizAttempts }}</h3>
                    </div>
                </div>

                <!-- Average Score Card -->
                <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                    <div class="p-6 border-l-4 border-orange-500">
                        <div class="flex items-start">
                            <div class="p-3 rounded-md bg-orange-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500 mt-3">{{ __('Average Score') }}</p>
                        <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ number_format($averageQuizScore, 1) }}%</h3>
                    </div>
                </div>

                <!-- Passing Rate Card -->
                <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                    <div class="p-6 border-l-4 border-purple-500">
                        <div class="flex items-start">
                            <div class="p-3 rounded-md bg-purple-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500 mt-3">{{ __('Passing Rate') }}</p>
                        <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ number_format($quizPassingRate, 1) }}%</h3>
                    </div>
                </div>

                 <!-- Users Accessing Quizzes Card (New) -->
                <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                    <div class="p-6 border-l-4 border-indigo-500">
                        <div class="flex items-start">
                            <div class="p-3 rounded-md bg-indigo-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 01-9-5.197M15 21h-3m6 0h-3M9 15h3m-6 0h3" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500 mt-3">{{ __('Users Accessing Quizzes') }}</p>
                        <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ $totalUsersAccessingQuizzes }}</h3>
                    </div>
                </div>

                <!-- Users Attempting Quizzes Card (New) -->
                <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                    <div class="p-6 border-l-4 border-teal-500">
                        <div class="flex items-start">
                            <div class="p-3 rounded-md bg-teal-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500 mt-3">{{ __('Users Attempting Quizzes') }}</p>
                        <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ $uniqueUsersAttemptingQuizzes }}</h3>
                    </div>
                </div>

                <!-- Active Teachers Card (NEW) -->
                <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                    <div class="p-6 border-l-4 border-lime-500">
                        <div class="flex items-start">
                            <div class="p-3 rounded-md bg-lime-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-lime-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500 mt-3">{{ __('Active Teachers') }}</p>
                        <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ $activeTeachers }}</h3>
                    </div>
                </div>

                <!-- Pending Teachers Card (NEW) -->
                <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                    <div class="p-6 border-l-4 border-yellow-500">
                        <div class="flex items-start">
                            <div class="p-3 rounded-md bg-yellow-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500 mt-3">{{ __('Pending Teachers') }}</p>
                        <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ $pendingTeachers }}</h3>
                    </div>
                </div>

                <!-- Teachers Creating Courses Card (NEW) -->
                <div class="bg-white overflow-hidden shadow-xl rounded-xl md:col-span-2">
                    <div class="p-6 border-l-4 border-pink-500">
                        <div class="flex items-start">
                            <div class="p-3 rounded-md bg-pink-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2H16a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500 mt-3">{{ __('Teachers Creating Courses') }}</p>
                        <h3 class="text-4xl font-bold text-gray-800 mt-1">{{ $teachersCreatingCourses }}</h3>
                    </div>
                </div>


                <!-- Most & Least Attempted Quizzes -->
                <div class="col-span-full mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Most Attempted Quiz -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                        <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Most Attempted Quiz') }}</h3>
                        </div>
                        <div class="p-6">
                            @if ($mostAttemptedQuiz)
                                <div class="flex items-start">
                                    <div class="p-3 rounded-md bg-blue-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-xl font-bold text-gray-800">{{ __('Quiz ID:') }} {{ $mostAttemptedQuiz->quiz_id }}</div>
                                        <div class="mt-2 flex items-center">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $mostAttemptedQuiz->total_attempts }} {{ __('attempts') }}
                                            </span>
                                        </div>
                                        <p class="mt-3 text-sm text-gray-600">
                                            {{ __('This is your most popular quiz based on number of attempts.') }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-gray-500">{{ __('No quiz attempts recorded yet.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Least Attempted Quiz -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                        <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Least Attempted Quiz') }}</h3>
                        </div>
                        <div class="p-6">
                            @if ($leastAttemptedQuiz)
                                <div class="flex items-start">
                                    <div class="p-3 rounded-md bg-yellow-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-xl font-bold text-gray-800">{{ __('Quiz ID:') }} {{ $leastAttemptedQuiz->quiz_id }}</div>
                                        <div class="mt-2 flex items-center">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ $leastAttemptedQuiz->total_attempts }} {{ __('attempts') }}
                                            </span>
                                        </div>
                                        <p class="mt-3 text-sm text-gray-600">
                                            {{ __('This quiz needs more promotion to increase student participation.') }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-gray-500">{{ __('No quiz attempts recorded yet.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quiz Performance Charts -->
            <div class="mt-8 bg-white overflow-hidden shadow-xl rounded-xl">
                <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Quiz Score Distribution') }}</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Donut Chart for Score Distribution -->
                        <div>
                            <div class="flex justify-center">
                                <div class="relative w-60 h-60">
                                    <!-- Donut Chart SVG (Placeholder) -->
                                    <svg class="w-full h-full" viewBox="0 0 36 36">
                                        <!-- Background Ring -->
                                        <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#f1f5f9" stroke-width="3"></circle>

                                        <!-- Data Segments - Assuming score distribution -->
                                        <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#22c55e" stroke-width="3"
                                            stroke-dasharray="{{ min(($quizPassingRate ?? 0), 100) }} {{ 100 - min(($quizPassingRate ?? 0), 100) }}"
                                            stroke-dashoffset="25"></circle>
                                        <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#ef4444" stroke-width="3"
                                            stroke-dasharray="{{ 100 - min(($quizPassingRate ?? 0), 100) }} {{ min(($quizPassingRate ?? 0), 100) }}"
                                            stroke-dashoffset="{{ 100 - min(($quizPassingRate ?? 0), 100) + 25 }}"></circle>
                                        </svg>
                                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                                            <span class="text-4xl font-bold text-gray-800">{{ number_format($quizPassingRate, 0) }}%</span>
                                            <span class="text-sm text-gray-500">{{ __('Passing Rate') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6 space-y-3">
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                        <span class="text-sm text-gray-600">{{ __('Passed') }} ({{ number_format($quizPassingRate, 1) }}%)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                        <span class="text-sm text-gray-600">{{ __('Failed') }} ({{ number_format(100 - $quizPassingRate, 1) }}%)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Score Summary -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-700 mb-4">{{ __('Average Scores') }}</h4>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">{{ __('Overall Average') }}</span>
                                            <span class="text-sm font-medium text-gray-700">{{ number_format($averageQuizScore, 1) }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ min($averageQuizScore, 100) }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Additional score metrics can be added here -->
                                    <div class="p-4 bg-blue-50 rounded-lg mt-6">
                                        <h5 class="font-medium text-blue-900">{{ __('Quiz Summary') }}</h5>
                                        <ul class="mt-2 space-y-2 text-sm">
                                            <li class="flex justify-between">
                                                <span class="text-gray-600">{{ __('Total Quizzes') }}</span>
                                                <span class="font-medium">{{ $totalQuizzes }}</span>
                                            </li>
                                            <li class="flex justify-between">
                                                <span class="text-gray-600">{{ __('Total Attempts') }}</span>
                                                <span class="font-medium">{{ $totalQuizAttempts }}</span>
                                            </li>
                                            <li class="flex justify-between">
                                                <span class="text-gray-600">{{ __('Average Score') }}</span>
                                                <span class="font-medium">{{ number_format($averageQuizScore, 1) }}%</span>
                                            </li>
                                            <li class="flex justify-between">
                                                <span class="text-gray-600">{{ __('Attempts Per Quiz') }}</span>
                                                <span class="font-medium">{{ $totalQuizzes > 0 ? number_format($totalQuizAttempts / $totalQuizzes, 1) : 0 }}</span>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
