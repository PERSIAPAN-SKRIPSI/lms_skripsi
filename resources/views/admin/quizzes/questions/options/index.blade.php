<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Question Options for Question: ') }} {{ $question->question }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">List of Options</h3>
                        <a href="{{ route('admin.options.create', [$quiz->id, $question->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add New Option</a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Option Text</th>
                                    <th class="px-4 py-2 text-left">Is Correct</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($options as $option)
                                    <tr>
                                        <td class="px-4 py-2">{{ $option->option_text }}</td>
                                        <td class="px-4 py-2">{{ $option->is_correct ? 'Yes' : 'No' }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('admin.options.show', [$quiz->id, $question->id, $option->id]) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                            <a href="{{ route('admin.options.edit', [$quiz->id, $question->id, $option->id]) }}" class="text-green-500 hover:text-green-700 ml-2">Edit</a>
                                            <form action="{{ route('admin.options.destroy', [$quiz->id, $question->id, $option->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-2" colspan="4">No options for this question.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.questions.index', $quiz->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back to Question List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
