<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attempt Quiz: ') }} {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.quizzes.attempt.submit', [$quiz->id, $attempt->id]) }}" method="POST">
                        @csrf

                        @foreach ($questions as $question)
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">{{ $question->question }}</label>

                                @if ($question->question_type == 'multiple_choice')
                                    @foreach ($question->options as $option)
                                        <div class="mb-2">
                                            <label class="inline-flex items-center">
                                                <input type="radio" class="form-radio h-5 w-5 text-blue-600" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required>
                                                <span class="ml-2 text-gray-700">{{ $option->option_text }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                @elseif ($question->question_type == 'essay')
                                    <textarea name="answers[{{ $question->id }}]" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                                @endif
                            </div>
                        @endforeach

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit Quiz</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
