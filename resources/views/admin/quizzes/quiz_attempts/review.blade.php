{{-- admin/quiz_attempts/review.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Review Answers: {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-2">Review Your Answers</h3>
                        <p class="text-gray-600">Please review your answers before submitting the quiz. You can go back and change any answer if needed.</p>
                    </div>

                    <div class="space-y-6 mb-8">
                        @foreach($quiz->questions as $index => $question)
                            @php
                                $answer = $answers->where('question_id', $question->id)->first();
                                $selectedOption = $answer ? $answer->selectedOption : null;
                            @endphp

                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mr-4">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 text-indigo-800">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="text-md font-medium mb-3">{{ $question->question_text }}</h4>

                                        @if($selectedOption)
                                            <div class="p-3 border-l-4 border-indigo-500 bg-indigo-50">
                                                <p class="font-medium">Your answer:</p>
                                                <p>{{ $selectedOption->option_text }}</p>
                                            </div>
                                        @else
                                            <div class="p-3 border-l-4 border-yellow-500 bg-yellow-50">
                                                <p class="text-yellow-700">You haven't answered this question yet.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form method="POST" action="{{ route('quizzes.attempt.finalize', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}">
                        @csrf
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">Once submitted, you won't be able to change your answers.</p>

                            <div class="flex space-x-4">
                                <a href="{{ route('quizzes.attempt.show', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                                    Go Back
                                </a>

                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    Submit Quiz
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
