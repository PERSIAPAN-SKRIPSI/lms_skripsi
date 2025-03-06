<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $course->name }} - Detail
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-4">{{ $course->name }}</h3>

                    <img class="rounded-t-lg mb-4" src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->name }}" onerror="this.src='{{ asset('thumbnails/default.png') }}'" loading="lazy"/>

                    <p class="mb-3">{{ $course->description }}</p>

                    <p class="mb-3"><strong>Kategori:</strong> {{ $course->category->name }}</p>
                    <p class="mb-3"><strong>Guru:</strong> {{ $course->teacher->user->name }}</p>
                    <p class="mb-3"><strong>Durasi:</strong> {{ $course->duration }}</p>

                    <a href="{{ route('employees-dashboard.courses.learn', $course->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 dark:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-100 uppercase hover:bg-blue-700 dark:hover:bg-blue-500 focus:bg-blue-700 dark:focus:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Mulai Belajar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
