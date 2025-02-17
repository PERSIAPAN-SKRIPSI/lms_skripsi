<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz Results: ') }} {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Quiz Results</h3>

                    <div class="mb-2">
                        <span class="font-bold">Score:</span> {{ $attempt->score }}
                    </div>
                    <div class="mb-2">
                        <span class="font-bold">Status:</span> {{ $attempt->status }}
                    </div>

                    <a href="{{ route('admin.quizzes.index') }}" class="text-gray-600 hover:text-gray-800">Back to Quiz List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
