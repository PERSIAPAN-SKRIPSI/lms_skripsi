<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Edit Option for Question: ') }} <span class="text-indigo-600">{{ $question->question }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-6 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900">
                        Edit Option
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.quizzes.questions.options.update', [$quiz->id, $question->id, $option->id]) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="option_text" class="block text-sm font-medium text-gray-700">
                                Option Text
                            </label>
                            <div class="mt-1">
                                <input type="text" name="option_text" id="option_text"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    value="{{ old('option_text', $option->option_text) }}" required>
                            </div>
                            @error('option_text') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="is_correct" class="block text-sm font-medium text-gray-700">
                                Is Correct
                            </label>
                            <div class="mt-1">
                                <select name="is_correct" id="is_correct"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    required>
                                    <option value="0" {{ old('is_correct', $option->is_correct) == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_correct', $option->is_correct) == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            @error('is_correct') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.quizzes.questions.options.index', [$quiz->id, $question->id]) }}"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm font-semibold text-sm rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Option
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
