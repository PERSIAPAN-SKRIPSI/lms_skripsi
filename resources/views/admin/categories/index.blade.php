<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between px-6 py-4">
            <h2 class="text-3xl font-semibold text-gray-900 leading-tight">
                {{ __('Categories') }}
            </h2>
            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gray-800 rounded-xl hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                New Category
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Filter Section -->
            <div class="mb-8 bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Filter Categories</h3>
                <form action="{{ route('admin.categories.index') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Name:</label>
                        <input type="text" name="name" id="name" value="{{ request('name') }}"
                            class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="has_subcategories"
                            class="block text-sm font-medium text-gray-700 mb-1.5">With Subcategories:</label>
                        <select name="has_subcategories" id="has_subcategories"
                            class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 focus:outline-none">
                            <option value="" @selected('' == request('has_subcategories'))>All</option>
                            <option value="yes" @selected('yes' == request('has_subcategories'))>Yes</option>
                            <option value="no" @selected('no' == request('has_subcategories'))>No</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 lg:col-span-1 lg:flex lg:items-end">
                        <button type="submit"
                            class="inline-flex items-center justify-center w-full px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-xl shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                            class="inline-flex items-center justify-center w-full px-6 py-3 mt-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200 lg:mt-0 lg:ml-2">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
            <!-- End Filter Section -->

            <div class="overflow-hidden bg-white rounded-3xl shadow-md">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-sm font-semibold text-left text-gray-700">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3.5 text-sm font-semibold text-left text-gray-700">
                                    Slug
                                </th>
                                <th scope="col" class="px-6 py-3.5 text-sm font-semibold text-left text-gray-700">
                                    Icon
                                </th>
                                <th scope="col" class="px-6 py-3.5 text-sm font-semibold text-left text-gray-700">
                                    Image
                                </th>
                                <th scope="col" class="px-6 py-3.5 text-sm font-semibold text-left text-gray-700">
                                    Subcategories
                                </th>
                                <th scope="col" class="relative px-6 py-3.5">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-base font-medium text-gray-900 whitespace-nowrap">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        @if ($category->icon)
                                            <img src="{{ filter_var($category->icon, FILTER_VALIDATE_URL) ? $category->icon : Storage::url($category->icon) }}"
                                                alt="Icon" class="object-cover w-8 h-8 rounded-full  menu-icon" style="width: 32px; height: 32px;">
                                        @else
                                            <div
                                                class="flex items-center justify-center w-8 h-8 text-gray-400 bg-gray-100 rounded-full">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        @if ($category->image)
                                            <img src="{{ filter_var($category->image, FILTER_VALIDATE_URL) ? $category->image : Storage::url($category->image) }}"
                                                alt="Image" class="object-cover w-16 h-16 rounded-xl">
                                        @else
                                            <div
                                                class="flex items-center justify-center w-16 h-16 text-gray-400 bg-gray-100 rounded-xl">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                        <a href="{{ route('admin.categories.sub-categories.index', $category) }}"
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200">
                                            {{ $category->children()->count() }} Subs
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                class="text-gray-600 hover:text-gray-800 transition-colors"
                                                title="Edit Category">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-500 hover:text-red-700 transition-colors"
                                                    title="Delete Category">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-8 text-sm font-medium text-center text-gray-500 whitespace-nowrap">
                                        No categories found matching your filter criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Custom Pagination -->
                <div class="flex justify-center items-center py-6 px-4">
                    <nav role="navigation" aria-label="Pagination Navigation">
                        <ul class="flex items-center space-x-2">

                            <!-- Previous Page Link -->
                            @if ($categories->onFirstPage())
                            <li class="disabled" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-xl cursor-default select-none">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </li>
                            @else
                                <li>
                                    <a href="{{ $categories->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </li>
                            @endif

                            <!-- Pagination Elements -->
                            @foreach ($categories->getUrlRange(max(1, $categories->currentPage() - 2), min($categories->lastPage(), $categories->currentPage() + 2)) as $page => $url)
                                @if ($page == $categories->currentPage())
                                <li aria-current="page">
                                    <span class="z-10 inline-flex items-center px-4 py-2 text-sm font-medium bg-blue-100 border border-blue-500 text-blue-700 rounded-xl">
                                        {{ $page }}
                                    </span>
                                </li>
                                @else
                                <li>
                                    <a href="{{ $url }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-100 transition-colors" aria-label="Go to page {{ $page }}">
                                        {{ $page }}
                                    </a>
                                </li>
                                @endif
                            @endforeach

                            <!-- Next Page Link -->
                            @if ($categories->hasMorePages())
                            <li>
                                <a href="{{ $categories->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>
                            @else
                            <li class="disabled" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-xl cursor-default select-none">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
