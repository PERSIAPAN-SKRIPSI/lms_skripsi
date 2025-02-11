<x-app-layout>
    <x-slot name="header">
        <div class="bg-[#3B60E4]">
            <!-- Menggunakan warna biru yang lebih solid -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Manage Courses</h1>
                        <p class="text-white/80">Organize and manage your educational content</p>
                    </div>
                    @role('teacher')
                        <a href="{{ route('admin.courses.create') }}"
                            class="group inline-flex items-center px-6 py-3 bg-white text-[#3B60E4] hover:bg-white/90 font-medium rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add New Course
                        </a>
                    @endrole
                </div>

                <!-- Filter Section -->
                <form action="{{ route('admin.courses.index') }}" method="GET">
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <!-- Search -->
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-white/70" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text"
                                    class="block w-full pl-12 pr-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/70 focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-300 focus:placeholder-white/50"
                                    placeholder="Search in your courses..." style="color: rgb(255, 255, 255);"
                                    name="search" value="{{ request('search') }}">
                            </div>
                        </div>


                        <!-- Sort By -->
                        <div class="w-full sm:w-48">
                            <select
                                class="block w-full py-2.5 pl-3 pr-10 border border-gray-200 rounded-lg bg-gray-50 text-gray-700
                       focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                name="sort">
                                <option value="latest" class="text-black"
                                    {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="oldest" class="text-black"
                                    {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            </select>
                        </div>

                        <!-- Category -->
                        <div class="w-full sm:w-48">
                            <select
                                class="block w-full py-2.5 pl-3 pr-10 border border-gray-200 rounded-lg bg-gray-50 text-gray-700
                       focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                name="category">
                                <option value="" class="text-black">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" class="text-black"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full sm:w-48">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-300">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Modern Course Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @if (count($courses) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($courses as $course)
                        <div
                            class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <!-- Course Image with Overlay -->
                            <div class="relative h-48">
                                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->name }}"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-100/90 text-blue-800 backdrop-blur-sm">
                                        {{ $course->category->name }}
                                    </span>
                                </div>
                            </div>

                            <!-- Enhanced Course Info -->
                            <div class="p-6">
                                <h3
                                    class="font-bold text-gray-900 text-lg mb-3 group-hover:text-blue-600 transition-colors duration-300">
                                    {{ $course->name }}
                                </h3>

                                <div class="flex items-center gap-6 text-sm text-gray-500 mb-6">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.318l-1.318 2.674-2.946.428 2.132 2.08-.503 2.94L12 11.49l2.635 1.386-.503-2.94 2.132-2.08-2.946-.428L12 4.318z" />
                                        </svg>
                                        <span class="font-medium">{{ $course->employees->count() }} students</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <span class="font-medium">{{ $course->chapters->count() }} chapters</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <a href="{{ route('admin.courses.show', $course) }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg font-medium transition-colors duration-300">
                                        Manage Course
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                    @role('admin')
                                        <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this course?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endrole
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">No courses found</h3>
                    <p class="text-gray-500 text-lg">Start by creating your first course</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
