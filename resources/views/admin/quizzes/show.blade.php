<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Quiz Information</h3>

                    <div class="mb-2">
                        <span class="font-bold">Title:</span> {{ $quiz->title }}
                    </div>
                    <div class="mb-2">
                        <span class="font-bold">Course:</span> {{ $quiz->course->name }}
                    </div>
                    <div class="mb-2">
                        <span class="font-bold">Chapter:</span> {{ $quiz->chapter->name }}
                    </div>
                    <div class="mb-2">
                        <span class="font-bold">Passing Score:</span> {{ $quiz->passing_score }}
                    </div>

                    <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Edit Quiz</a>
                    <a href="{{ route('admin.quizzes.index') }}" class="text-gray-600 hover:text-gray-800">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
