<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Quiz Attempt Monitoring') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ __('User Quiz Attempts') }}</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('User') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Quiz Title') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Attempts Count') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Attempt History') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($userQuizAttempts as $user)
                                    @foreach ($user->quizAttempts->groupBy('quiz_id') as $quizId => $attemptsForQuiz)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $user->email }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    @if($attemptsForQuiz->first()->quiz)
                                                    {{ $attemptsForQuiz->first()->quiz->title }}
                                                @else
                                                    Quiz Not Found
                                                @endif
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ __('Quiz ID:') }} {{ $quizId }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $attemptsForQuiz->count() }} {{ __('Attempts') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex flex-col">
                                                    @foreach ($attemptsForQuiz as $attempt)
                                                        <div class="mb-1">
                                                            {{ __('Attempted at:') }} {{ $attempt->created_at->format('M d, Y H:i') }}
                                                            <span class="font-medium @if($attempt->status === 'passed') text-green-600 @else text-red-600 @endif">
                                                                ({{ ucfirst($attempt->status) }}, {{ __('Score:') }} {{ number_format($attempt->score, 1) }}%)
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap" colspan="4">
                                            <div class="text-center text-gray-500">
                                                {{ __('No user quiz attempts found.') }}
                                            </div>
                                        </td>
                                    </tr>
                                @endempty
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
