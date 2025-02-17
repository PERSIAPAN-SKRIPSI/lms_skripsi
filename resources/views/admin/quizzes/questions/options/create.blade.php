<x-app-layout>
    <x-slot name="header">
        <h2
            class="font-semibold text-xl text-gray-800 leading-tight
            {{ __('Create Option for Question: ') }} {{ $question->question }}"
        >
        </h2>
    </x-slot>

    <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form action="{{ route('admin.options.store', [$quiz->id, $question->id]) }}"
                            method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="option_text" class="block text-gray-700 text-sm font-bold mb-2">Option
                                    Text:</label>
                                <input type="text" name="option_text" id="option_text"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    value="{{ old('option_text') }}" required>
                                @error('option_text')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="is_correct" class="block text-gray-700 text-sm font-bold mb-2">Is
                                    Correct:</label>
                                <select name="is_correct" id="is_correct"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                                    <option value="0" {{ old('is_correct') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_correct') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                                @error('is_correct')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create
                                Option</button>
                            <a href="{{ route('admin.options.index', [$quiz->id, $question->id]) }}"
                                class="ml-4 text-gray-600 hover:text-gray-800">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
            </div>
</x-app-layout>
