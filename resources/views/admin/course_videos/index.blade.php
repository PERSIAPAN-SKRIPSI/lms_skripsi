<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Videos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <a href="{{ route('admin.courses.videos.create', $course) }}"
                           class="bg-indigo-700 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">
                            Add New Video
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-6 text-left">Name</th>
                                    <th class="py-3 px-6 text-left">Chapter</th>
                                    <th class="py-3 px-6 text-left">Duration</th>
                                    <th class="py-3 px-6 text-left">Preview</th>
                                    <th class="py-3 px-6 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($videos as $video)
                                    <tr>
                                        <td class="py-4 px-6">{{ $video->name }}</td>
                                        <td class="py-4 px-6">{{ $video->chapter->name }}</td>
                                        <td class="py-4 px-6">{{ $video->duration }}</td>
                                        <td class="py-4 px-6">
                                            @php
                                                $videoId = extractYouTubeId($video->path_video);
                                            @endphp
                                            @if($videoId)
                                                <a href="https://youtube.com/watch?v={{ $videoId }}"
                                                   target="_blank"
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    Preview
                                                </a>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.courses.videos.edit', ['course' => $course, 'video' => $video]) }}"
                                                   class="text-blue-600 hover:text-blue-900">
                                                    Edit
                                                </a>
                                                <form method="POST"
                                                      action="{{ route('admin.courses.videos.destroy', ['course' => $course, 'video' => $video]) }}"
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this video?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
