{{-- resources/views/admin/quizzes/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Quiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.quizzes.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Course Selection --}}
                        <div>
                            <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Course
                            </label>
                            <select id="course_id" name="course_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select a course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Chapter Selection (Dynamic, populated via JavaScript) --}}
                        <div>
                            <label for="chapter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Chapter
                            </label>
                            <select name="chapter_id" id="chapter_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="">Select Chapter</option>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}"
                                        {{ old('chapter_id') == $chapter->id ? 'selected' : '' }}>{{ $chapter->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('chapter_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quiz Title --}}
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Quiz Title
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Enter quiz title">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quiz Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Enter quiz description">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quiz Settings --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="passing_score"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Passing Score (%)
                                </label>
                                <input type="number" name="passing_score" id="passing_score"
                                    value="{{ old('passing_score', 70) }}" min="0" max="100" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('passing_score')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="duration"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Duration (minutes)
                                </label>
                                <input type="number" name="duration" id="duration" value="{{ old('duration', 30) }}"
                                    min="1" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('duration')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Active Status --}}
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active') ? 'checked' : '' }}
                                class="rounded border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Make this quiz active
                            </label>
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.quizzes.index') }}"
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Display Questions (Only if a quiz is created) --}}
        @isset($quiz)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Questions for Quiz: {{ $quiz->title }}</h3>

                    @forelse($questions as $question)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow p-6 mb-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">
                                    {{ $question->question }}
                                </h4>
                                <div class="mt-2 space-y-1">
                                    @foreach ($question->options as $option)
                                    <div class="flex items-center">
                                        <span
                                            class="w-5 h-5 flex items-center justify-center rounded-full {{ $option->is_correct ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} dark:bg-opacity-20">
                                            {{ $loop->iteration }}
                                        </span>
                                        <span
                                            class="ml-2 text-gray-700 dark:text-gray-300 {{ $option->is_correct ? 'font-medium' : '' }}">
                                            {{ $option->option_text }}
                                        </span>
                                        @if ($option->is_correct)
                                        <span
                                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                            Correct Answer
                                        </span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex space-x-2">
                                <a href="#"
                                    class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="#" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this question?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 dark:text-gray-400">No questions added yet.</p>
                    @endforelse

                    {{-- Tombol untuk menambahkan pertanyaan --}}
                   <a href="{{ route('admin.quizzes.questions.create', $quiz) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Add your first question
                   </a>
                </div>
            </div>
        </div>
        @endisset
    </div>
</x-app-layout>
