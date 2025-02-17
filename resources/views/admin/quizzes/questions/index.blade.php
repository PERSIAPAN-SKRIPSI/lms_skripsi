<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pertanyaan untuk Quiz: ') }} {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Daftar Pertanyaan</h3>
                        <a href="{{ route('admin.questions.create', $quiz->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Pertanyaan Baru</a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Pertanyaan</th>
                                    <th class="px-4 py-2 text-left">Tipe Pertanyaan</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($questions as $question)
                                    <tr>
                                        <td class="px-4 py-2">{{ $question->question }}</td>
                                        <td class="px-4 py-2">{{ $question->question_type }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('admin.questions.show', [$quiz->id, $question->id]) }}" class="text-blue-500 hover:text-blue-700">Lihat</a>
                                            <a href="{{ route('admin.questions.edit', [$quiz->id, $question->id]) }}" class="text-green-500 hover:text-green-700 ml-2">Edit</a>
                                            <form action="{{ route('admin.questions.destroy', [$quiz->id, $question->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-2" onclick="return confirm('Anda yakin ingin menghapus pertanyaan ini?')">Hapus</button>
                                            </form>
                                            <a href="{{ route('admin.options.index', [$quiz->id, $question->id]) }}" class="text-purple-500 hover:text-purple-700 ml-2">Opsi</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-2" colspan="4">Tidak ada pertanyaan untuk quiz ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.quizzes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali ke Daftar Quiz</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
