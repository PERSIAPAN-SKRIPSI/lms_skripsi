<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz Performance Monitoring') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Overall Performance') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-gray-100 rounded p-4">
                            <div class="text-sm font-medium text-gray-500">{{ __('Total Quizzes') }}</div>
                            <div class="text-2xl font-bold text-gray-800">{{ $totalQuizzes }}</div>
                        </div>
                        <div class="bg-gray-100 rounded p-4">
                            <div class="text-sm font-medium text-gray-500">{{ __('Total Attempts') }}</div>
                            <div class="text-2xl font-bold text-gray-800">{{ $totalAttempts }}</div>
                        </div>
                        <div class="bg-gray-100 rounded p-4">
                            <div class="text-sm font-medium text-gray-500">{{ __('Average Score') }}</div>
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($averageScore, 2) }}</div>
                        </div>
                        <div class="bg-gray-100 rounded p-4">
                            <div class="text-sm font-medium text-gray-500">{{ __('Passing Rate') }}</div>
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($passingRate, 2) }}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
