<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz Completion Monitoring') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Completion Statistics</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-100 rounded p-4">
                            <div class="text-sm font-medium text-gray-500">Users Completed All Quizzes</div>
                            <div class="text-2xl font-bold text-gray-800">{{ count($completedQuizzes) }}</div>
                        </div>
                        <div class="bg-gray-100 rounded p-4">
                            <div class="text-sm font-medium text-gray-500">Most Attempted Quiz</div>
                            <div class="text-xl font-bold text-gray-800">
                                @if ($mostAttemptedQuiz)
                                    Quiz ID: {{ $mostAttemptedQuiz->quiz_id }} ({{ $mostAttemptedQuiz->total_attempts }} attempts)
                                @else
                                    No attempts yet
                                @endif
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded p-4">
                            <div class="text-sm font-medium text-gray-500">Least Attempted Quiz</div>
                            <div class="text-xl font-bold text-gray-800">
                                @if ($leastAttemptedQuiz)
                                    Quiz ID: {{ $leastAttemptedQuiz->quiz_id }} ({{ $leastAttemptedQuiz->total_attempts }} attempts)
                                @else
                                    No attempts yet
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
