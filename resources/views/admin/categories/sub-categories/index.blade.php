<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Subcategories for ') }} {{ $category->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Alert Messages (Improved with Alpine.js) -->
           @if (session()->has('success') || session()->has('error'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition:enter="transform ease-out duration-300 transition"
                     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="rounded-md p-4 mb-4 shadow-lg border {{ session('success') ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}"
                     role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @if(session('success'))
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium {{ session('success') ? 'text-green-800' : 'text-red-800' }}">
                                {{ session('success') ?? session('error') }}
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button @click="show = false" type="button" class="{{ session('success') ? 'text-green-500 hover:text-green-600' : 'text-red-500 hover:text-red-600' }} rounded-md p-1.5 inline-flex focus:outline-none focus:ring-2 focus:ring-offset-2 {{ session('success') ? 'focus:ring-green-600' : 'focus:ring-red-600' }}">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Content Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="p-6 bg-white">
                    <!-- Header Section -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
                        <h3 class="text-xl font-semibold text-gray-900">Subcategories of {{ $category->name }}</h3>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.categories.sub-categories.create', $category) }}"
                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-500 to-teal-600 border border-transparent rounded-lg font-medium text-sm text-white shadow-sm hover:from-teal-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Subcategory
                            </a>
                            <a href="{{ route('admin.categories.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-lg font-medium text-sm text-gray-700 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                Back to Categories
                            </a>
                        </div>
                    </div>

                    <!-- Subcategories Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                     <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($subCategories as $subCategory)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $subCategory->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600">{{ $subCategory->slug }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($subCategory->icon)
                                                <img src="{{ filter_var($subCategory->icon, FILTER_VALIDATE_URL) ? $subCategory->icon : Storage::url($subCategory->icon) }}"
                                                     alt="Icon"
                                                     class="w-10 h-10 rounded-full object-cover shadow-sm"
                                                     onerror="this.onerror=null; this.src='{{ asset('images/placeholder-icon.png') }}';">
                                            @else
                                            <!-- Placeholder Icon -->
                                               <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                           @if ($subCategory->image)
                                                <img src="{{ filter_var($subCategory->image, FILTER_VALIDATE_URL) ? $subCategory->image : Storage::url($subCategory->image) }}"
                                                     alt="Image"
                                                     class="w-16 h-12 rounded-lg object-cover shadow-sm"
                                                     onerror="this.onerror=null; this.src='{{ asset('images/placeholder-image.png') }}';">
                                            @else
                                              <!-- Placeholder Image -->
                                                <div class="w-16 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end space-x-3">
                                                <a href="{{ route('admin.categories.sub-categories.edit', [$category, $subCategory->slug]) }}"
                                                   class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                                   title="Edit Subcategory">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.categories.sub-categories.destroy', [$category, $subCategory->slug]) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      x-data="{
                                                        confirmDelete() {
                                                            return window.confirm('Are you sure you want to delete this subcategory?');
                                                        }
                                                      }">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            @click.prevent="if(confirmDelete()) $el.closest('form').submit()"
                                                            class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                            title="Delete Subcategory">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center space-y-4">
                                                <div class="rounded-full bg-gray-100 p-3">
                                                   <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-medium text-gray-500">No subcategories found for {{ $category->name }}.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
          // Automatically hide alerts after 5 seconds (5000 milliseconds)
          setTimeout(function() {
            let alert = document.querySelector('[x-data="{ show: true }"]');
              if(alert) {
                  alert.style.display = 'none';
              }
          }, 5000);
      });
    </script>
    @endpush
</x-app-layout>
