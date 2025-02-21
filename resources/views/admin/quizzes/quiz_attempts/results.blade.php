{{-- admin/quiz_attempts/results.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Quiz Results: {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Result Summary Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white">
                    <div class="flex flex-col md:flex-row justify-between">
                        <div class="mb-6 md:mb-0">
                            <h3 class="text-xl font-bold mb-2">Quiz Summary</h3>
                            <p class="text-gray-600 mb-4">{{ $quiz->description }}</p>

                            <div class="flex items-center mt-4">
                                <div class="mr-8">
                                    <p class="text-sm text-gray-500">Status</p>
                                    <p class="font-medium
                                        {{ $attempt->status === 'passed' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ ucfirst($attempt->status) }}
                                    </p>
                                </div>
                                <div class="mr-8">
                                    <p class="text-sm text-gray-500">Completion Time</p>
                                    <p class="font-medium">{{ $completionTime }} minutes</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Completed On</p>
                                    <p class="font-medium">{{ $attempt->completed_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-center">
                            <div class="inline-flex items-center justify-center w-32 h-32 rounded-full border-4
                                {{ $attempt->status === 'passed' ? 'border-green-500' : 'border-red-500' }}">
                                <div>
                                    <p class="text-3xl font-bold">{{ number_format($attempt->score, 1) }}%</p>
                                    <p class="text-sm text-gray-600">Your Score</p>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Passing: {{ $quiz->passing_score }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Questions</p>
                                <p class="text-xl font-bold">{{ $totalQuestions }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Correct Answers</p>
                                <p class="text-xl font-bold">{{ $correctAnswers }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Incorrect Answers</p>
                                <p class="text-xl font-bold">{{ $incorrectAnswers }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Answer Review -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Question Review</h3>
                </div>

                <div class="divide-y divide-gray-200">
                    @foreach($questions as $index => $question)
                    @php
                        $questionNumber = $index + 1;
                        $userAnswer = $userAnswers->get($question->id); // *** PENTING: Menggunakan get($question->id)
                        $isCorrect = $userAnswer ? $userAnswer->is_correct : false;
                        $answeredOptionId = $userAnswer ? $userAnswer->selected_option_id : null;
                        $correctOptionId = $question->options->where('is_correct', true)->first()->id;
                    @endphp

                    <div class="p-6 {{ $isCorrect ? 'bg-green-50' : 'bg-red-50' }}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full
                                    {{ $isCorrect ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $questionNumber }}
                                </span>
                            </div>
                            <div class="flex-grow">
                                <h4 class="text-md font-medium mb-3">{{ $question->question_text }}</h4>

                                <div class="space-y-2">
                                    @foreach($question->options as $option)
                                        <div class="flex items-center p-2 rounded
                                            {{ $option->id == $correctOptionId ? 'bg-green-100' :
                                               ($option->id == $answeredOptionId && !$isCorrect ? 'bg-red-100' : '') }}">
                                            <div class="mr-3">
                                                @if($option->id == $answeredOptionId)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5
                                                        {{ $isCorrect ? 'text-green-600' : 'text-red-600' }}"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                @elseif($option->id == $correctOptionId && !$isCorrect)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @else
                                                    <div class="h-5 w-5"></div>
                                                @endif
                                            </div>
                                            <p class="{{ $option->id == $correctOptionId ? 'font-medium' : '' }}">
                                                {{ $option->option_text }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between">
                <a href="{{ route('admin.quizzes.admin_start') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Back to Quizzes
                </a>

                <a href="{{ route('admin.quizzes.attempt.start', $quiz->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Retry Quiz
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
