<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Question Details for Quiz: ') }} {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Question Information</h3>

                    <div class="mb-2">
                        <span class="font-bold">Question:</span> {{ $question->question }}
                    </div>
                    <div class="mb-2">
                        <span class="font-bold">Question Type:</span> {{ $question->question_type }}
                    </div>

                    <a href="{{ route('admin.questions.edit', [$quiz->id, $question->id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Edit Question</a>
                    <a href="{{ route('admin.questions.index', $quiz->id) }}" class="text-gray-600 hover:text-gray-800">Back to Question List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
