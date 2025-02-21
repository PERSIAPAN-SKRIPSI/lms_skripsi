<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Quiz: {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if ($question)
                        <h3 class="text-lg font-semibold mb-4">Question</h3>
                        <p class="mb-4">{{ $question->question_text }}</p>

                        <form method="POST" action="{{ route('admin.quizzes.attempt.submit', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}">
                            @csrf
                            @foreach ($question->options as $option)
                                <div class="flex items-center mb-2">
                                    <input type="radio" id="option_{{ $option->id }}" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="mr-2">
                                    <label for="option_{{ $option->id }}" class="text-gray-700">{{ $option->option_text }}</label>
                                </div>

                            @endforeach

                            <div class="flex justify-end mt-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Submit Answer
                                </button>
                            </div>
                        </form>
                    @else
                        <p>You have completed the quiz!</p>
                        <a href="{{ route('admin.quizzes.attempt.results', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}" class="text-blue-500">View Results</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
