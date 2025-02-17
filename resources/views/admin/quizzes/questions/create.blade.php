<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Question for Quiz: ') }} {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.questions.store', $quiz->id) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="question" class="block text-gray-700 text-sm font-bold mb-2">Question:</label>
                            <textarea name="question" id="question" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('question') }}</textarea>
                            @error('question') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="question_type" class="block text-gray-700 text-sm font-bold mb-2">Question Type:</label>
                            <select name="question_type" id="question_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="multiple_choice" {{ old('question_type') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="essay" {{ old('question_type') == 'essay' ? 'selected' : '' }}>Essay</option>
                                <!-- Add more question types as needed -->
                            </select>
                            @error('question_type') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Question</button>
                        <a href="{{ route('admin.questions.index', $quiz->id) }}" class="ml-4 text-gray-600 hover:text-gray-800">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
