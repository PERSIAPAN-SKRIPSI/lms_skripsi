<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Quiz: {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 h-1">
                    <div class="bg-indigo-600 h-1" style="width: {{ $progress }}%"></div>
                </div>

                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <span class="text-sm text-gray-500">Question {{ $answeredCount + 1 }} of {{ $totalQuestions }}</span>
                        </div>

                        @if($quiz->duration)
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium">Time remaining: <span id="timer">--:--</span>/<span class="total-duration">{{ sprintf('%02d:%02d', floor($quiz->duration), ($quiz->duration - floor($quiz->duration)) * 60) }}</span></span>
                        </div>
                        @endif
                    </div>

                    @if ($currentQuestion)
                        <h3 class="text-lg font-semibold mb-4">{{ $currentQuestion->question_text }}</h3>

                        <form id="answer-form" method="POST" action="{{ route('admin.quizzes.attempt.submit', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}">
                            @csrf
                            <div class="space-y-3 mt-6">
                                @foreach ($currentQuestion->options as $option)
                                    <div class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                                        <input type="radio"
                                               id="option_{{ $option->id }}"
                                               name="answers[{{ $currentQuestion->id }}]"
                                               value="{{ $option->id }}"
                                               class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <label for="option_{{ $option->id }}" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer w-full">
                                            {{ $option->option_text }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex justify-end mt-8">
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Submit Answer
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mx-auto mb-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <h3 class="text-xl font-semibold mb-2">Quiz Complete!</h3>
                            <p class="text-gray-600 mb-6">You have answered all questions in this quiz.</p>

                            <a href="{{ route('admin.quizzes.attempt.results', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}"
                               class="inline-flex items-center px-5 py-2.5 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-900 focus:ring ring-green-300 transition">
                                View Results
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quiz Information -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Quiz Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Total Questions</p>
                            <p class="font-medium">{{ $totalQuestions }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Passing Score</p>
                            <p class="font-medium">{{ $quiz->passing_score }}%</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Started</p>
                            <p class="font-medium">
                                {{ $attempt->started_at ? $attempt->started_at->format('M d, Y H:i') : 'Not started yet' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Duration</p>
                            <p class="font-medium">{{ $quiz->duration }} minutes</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Progress</p>
                            <p class="font-medium">{{ $answeredCount }} of {{ $totalQuestions }} questions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($quiz->duration)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get start time from sessionStorage or use time from database
            let startTime = parseInt(sessionStorage.getItem('quizStartTime_{{ $quiz->id }}'));
            if (!startTime) {
                startTime = new Date('{{ $attempt->started_at }}').getTime();
                sessionStorage.setItem('quizStartTime_{{ $quiz->id }}', startTime);
            }

            const durationMinutes = {{ $quiz->duration }};
            const durationMs = durationMinutes * 60 * 1000;
            const endTime = startTime + durationMs;

            function updateTimer() {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance <= 0) {
                    clearInterval(timerInterval);
                    document.getElementById('timer').textContent = "00:00";
                    document.getElementById('answer-form').submit();
                    return;
                }

                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('timer').textContent =
                    (minutes < 10 ? '0' + minutes : minutes) + ':' +
                    (seconds < 10 ? '0' + seconds : seconds);
            }

            updateTimer();
            const timerInterval = setInterval(updateTimer, 1000);
        });
    </script>
    @endif
</x-app-layout>
