<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Category Details') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('admin.categories.edit', $category->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Edit
                </a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center space-x-4">
                        @if ($category->image)
                             <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                class="w-20 h-20 object-cover rounded-full">
                        @endif
                        <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}"
                            class="w-20 h-20 object-cover rounded-full">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $category->name }}</h3>
                            <p class="text-gray-500">{{ $category->slug }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-lg font-bold">Courses</h4>
                        <ul class="space-y-2 mt-2">
                            @foreach ($courses as $course)
                                <li>
                                    <a href="#"
                                        class="text-blue-500 hover:text-blue-700 transition-colors duration-150">
                                        {{ $course->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
