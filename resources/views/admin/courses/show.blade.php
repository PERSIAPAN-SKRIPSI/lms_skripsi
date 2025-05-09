<x-app-layout>
    <x-slot name="header">
        <div class="md:flex md:flex-row md:justify-between md:items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Course Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="p-6 sm:p-10">

                    <!-- Course Information -->
                    <div class="mb-8">
                        <div class="md:flex md:items-center md:justify-between">
                            <div class="flex items-center mb-4 md:mb-0">
                                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->name }}"
                                    class="w-24 h-20 object-cover rounded-lg shadow-sm mr-4 transition-transform transform hover:scale-105">
                                <div>
                                    <h2
                                        class="text-2xl font-semibold text-gray-900 transition-colors hover:text-indigo-600">
                                        {{ $course->name }}</h2>
                                    <p class="text-gray-600 text-sm transition-colors hover:text-indigo-500">
                                        {{ $course->category->name }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <div>
                                    <p class="text-gray-500 text-sm">Students</p>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $course->employees->count() }}</h3>
                                </div>

                                @role('admin|teacher')
                                    <a href="{{ route('admin.courses.edit', $course) }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold text-sm transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v5h-5l8.322-8.322" />
                                        </svg>
                                        Edit Course
                                    </a>
                                @endrole
                                @role('admin')
                                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this course?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-semibold text-sm transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.913-2.132-2.096-2.188a48.107 48.107 0 00-3.475-.32m-11.8 0v-.916c0-1.18.913-2.132-2.096-2.188a48.107 48.107 0 003.475-.32m0 0a50.667 50.667 0 01-9.432 2.533L5.16 17.576a2.25 2.25 0 012.244 2.077h11.324a2.25 2.25 0 012.244-2.077L18.838 7.533z" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                @endrole
                            </div>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-300">

                   <!-- Course Content Management -->
<div>
    <div class="md:flex md:items-center md:justify-between mb-4">
        <div>
            <h3 class="text-xl font-semibold text-gray-900 transition-colors hover:text-indigo-600">
                Course Content</h3>
            <p class="text-gray-500 text-sm transition-colors hover:text-indigo-500">Manage
                Chapters, Videos & Quizzes</p>
        </div>
        @role('admin|teacher')
            <a href="{{ route('admin.courses.create-chapter', $course) }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-semibold text-sm transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add New Chapter
            </a>
        @endrole
    </div>

    <!-- Chapters List -->
    <div class="space-y-4">
        @forelse ($course->chapters as $chapter)
        <div x-data="{ open: false }" class="bg-gray-50 rounded-lg shadow-sm p-4 hover:shadow-md transition duration-200">
            <div class="md:flex md:items-center md:justify-between cursor-pointer" @click="open = !open">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-800 transition-colors hover:text-indigo-600">
                        {{ $chapter->name }}</h4>
                </div>

                <div class="mt-2 md:mt-0 flex items-center space-x-2">
                    @role('admin|teacher')
                        <a href="{{ route('admin.courses.edit-chapter', $chapter) }}"
                            class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v5h-5l8.322-8.322" />
                            </svg>
                            Edit
                        </a>
                        <form method="POST"
                            action="{{ route('admin.courses.destroy-chapter', $chapter) }}"
                            onsubmit="return confirm('Are you sure you want to delete this chapter?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.913-2.132-2.096-2.188a48.107 48.107 0 00-3.475-.32m-11.8 0v-.916c0-1.18.913-2.132-2.096-2.188a48.107 48.107 0 003.475-.32m0 0a50.667 50.667 0 01-9.432 2.533L5.16 17.576a2.25 2.25 0 012.244 2.077h11.324a2.25 2.25 0 012.244-2.077L18.838 7.533z" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    @endrole
                </div>
            </div>

            <div x-show="open" class="mt-4" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">
                <!-- Content Tabs -->
                <div class="border-b border-gray-200 mb-4">
                    <nav class="-mb-px flex space-x-6">
                        <button
                            class="tab-button border-blue-500 text-blue-600 whitespace-nowrap pb-3 px-1 border-b-2 font-medium text-sm"
                            data-tab="videos-{{ $chapter->id }}">
                            Videos
                        </button>
                        <button
                            class="tab-button border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap pb-3 px-1 border-b-2 font-medium text-sm"
                            data-tab="quizzes-{{ $chapter->id }}">
                            Quizzes
                        </button>
                    </nav>
                </div>

                <!-- Videos Content -->
                <div id="videos-{{ $chapter->id }}" class="tab-content">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @forelse($chapter->videos as $video)
                            <div
                                class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-200">
                                <div class="relative w-full aspect-video">
                                    <iframe width="100%" height="100%"
                                        class="absolute inset-0"
                                        src="https://www.youtube-nocookie.com/embed/{{ $video->path_video }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen></iframe>
                                </div>
                                <div class="p-3">
                                    <h5
                                        class="text-md font-semibold text-gray-900 transition-colors hover:text-indigo-600">
                                        {{ $video->name }}</h5>
                                    <p class="text-gray-600 text-xs mb-1">
                                        {{ $video->course->name }}</p>
                                    <p class="text-gray-500 text-xs">Duration:
                                        {{ $video->duration ?? 'N/A' }}</p>
                                    <p class="text-gray-700 text-sm mt-2 line-clamp-2">
                                        {{ $video->description ?? '' }}</p>

                                    @role('admin|teacher')
                                        <div class="mt-3 flex space-x-2">
                                            <a href="{{ route('admin.courses.videos.edit', ['course' => $course, 'video' => $video]) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm transition duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="w-4 h-4 mr-2">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v5h-5l8.322-8.322" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form method="POST"
                                                action="{{ route('admin.courses.videos.destroy', ['course' => $course, 'video' => $video]) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this video?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm transition duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.913-2.132-2.096-2.188a48.107 48.107 0 00-3.475-.32m-11.8 0v-.916c0-1.18.913-2.132-2.096-2.188a48.107 48.107 0 003.475-.32m0 0a50.667 50.667 0 01-9.432 2.533L5.16 17.576a2.25 2.25 0 012.244 2.077h11.324a2.25 2.25 0 012.244-2.077L18.838 7.533z" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endrole
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full text-center">No videos in this
                                chapter yet.</p>
                        @endforelse
                    </div>
                    @role('admin|teacher')
                        <div class="mt-4 text-right">
                            <a href="{{ route('admin.courses.create', ['course' => $course->id]) }}"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md font-semibold text-sm transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-4 h-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Add Video
                            </a>
                        </div>
                    @endrole
                </div>

                <!-- Quizzes Content -->
                <div id="quizzes-{{ $chapter->id }}" class="tab-content hidden">
                    <div class="space-y-4">
                        @forelse($chapter->quizzes as $quiz)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                                <div class="p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h5
                                                class="text-md font-semibold text-gray-900 transition-colors hover:text-indigo-600">
                                                {{ $quiz->title }}</h5>
                                            <div class="mt-1 text-sm text-gray-500">
                                                <p>Questions: {{ $quiz->questions()->count() }}</p>
                                                <p>Duration: {{ $quiz->duration }} minutes</p>
                                                <p>Passing Score: {{ $quiz->passing_score }}%</p>
                                            </div>
                                        </div>

                                        <div class="flex space-x-2">
                                            @role('admin|teacher')
                                                <a href="{{ route('admin.quizzes.edit', $quiz->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm transition duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v5h-5l8.322-8.322" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form method="POST"
                                                    action="{{ route('admin.quizzes.destroy', $quiz->id) }}"
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm transition duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor"
                                                            class="w-4 h-4 mr-2">
                                                            <path stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.913-2.132-2.096-2.188a48.107 48.107 0 00-3.475-.32m-11.8 0v-.916c0-1.18.913-2.132-2.096-2.188a48.107 48.107 0 003.475-.32m0 0a50.667 50.667 0 01-9.432 2.533L5.16 17.576a2.25 2.25 0 012.244 2.077h11.324a2.25 2.25 0 012.244-2.077L18.838 7.533z" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('quizzes.attempt.start', $quiz->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm transition duration-200">
                                                    Take Quiz
                                                </a>
                                            @endrole
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center">No quizzes in this chapter yet.
                            </p>
                        @endforelse
                    </div>
                    @role('admin|teacher')
                        <div class="mt-4 text-right">
                            <a href="{{ route('admin.quizzes.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md font-semibold text-sm transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-4 h-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Add Quiz
                            </a>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
        @empty
            <p class="text-gray-500 text-center">No chapters yet.</p>
        @endforelse
    </div>
</div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    const chapter = this.closest('.bg-gray-50');

                    // Update tab buttons
                    chapter.querySelectorAll('.tab-button').forEach(btn => {
                        btn.classList.remove('border-blue-500', 'text-blue-600');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });
                    this.classList.remove('border-transparent', 'text-gray-500');
                    this.classList.add('border-blue-500', 'text-blue-600');

                    // Update content visibility
                    chapter.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.add('hidden');
                    });
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });
        });
        document.addEventListener('alpine:init', () => {
        Alpine.data('courseContent', () => ({
            open: false,
        }));
    });
    </script>

</x-app-layout>
