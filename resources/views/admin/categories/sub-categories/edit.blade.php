<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Sub Kategori untuk: ') }} {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST"
                          action="{{ route('admin.categories.sub-categories.update', [$category, $subCategory->slug]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Sub Kategori</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $subCategory->name) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Icon Section -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Icon Sub Kategori</label>

                            <!-- Current Icon Preview -->
                            @if($subCategory->icon)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Current Icon:</p>
                                    <img src="{{ filter_var($subCategory->icon, FILTER_VALIDATE_URL) ? $subCategory->icon : Storage::url($subCategory->icon) }}"
                                         alt="Current Icon"
                                         class="h-20 w-20 object-cover rounded-lg border">
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- File Upload -->
                                <div>
                                    <label class="block text-sm text-gray-600 mb-2">Upload Icon:</label>
                                    <input type="file"
                                           name="icon_file"
                                           id="icon_file"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           accept="image/*">
                                </div>

                                <!-- URL Input -->
                                <div>
                                    <label class="block text-sm text-gray-600 mb-2">OR Icon URL:</label>
                                    <input type="text"
                                           name="icon_url"
                                           id="icon_url"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           placeholder="https://example.com/icon.png"
                                           value="{{ filter_var($subCategory->icon, FILTER_VALIDATE_URL) ? $subCategory->icon : '' }}">
                                </div>
                            </div>
                            @error('icon_file')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                            @error('icon_url')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Section -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Image Sub Kategori</label>

                            <!-- Current Image Preview -->
                            @if($subCategory->image)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                                    <img src="{{ filter_var($subCategory->image, FILTER_VALIDATE_URL) ? $subCategory->image : Storage::url($subCategory->image) }}"
                                         alt="Current Image"
                                         class="h-32 w-32 object-cover rounded-lg border">
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- File Upload -->
                                <div>
                                    <label class="block text-sm text-gray-600 mb-2">Upload Image:</label>
                                    <input type="file"
                                           name="image_file"
                                           id="image_file"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           accept="image/*">
                                </div>

                                <!-- URL Input -->
                                <div>
                                    <label class="block text-sm text-gray-600 mb-2">OR Image URL:</label>
                                    <input type="text"
                                           name="image_url"
                                           id="image_url"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           placeholder="https://example.com/image.jpg"
                                           value="{{ filter_var($subCategory->image, FILTER_VALIDATE_URL) ? $subCategory->image : '' }}">
                                </div>
                            </div>
                            @error('image_file')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                            @error('image_url')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-between">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan
                            </button>
                            <a href="{{ route('admin.categories.sub-categories.index', $category) }}"
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Icon handling
            const iconFile = document.getElementById('icon_file');
            const iconUrl = document.getElementById('icon_url');

            iconFile.addEventListener('change', function() {
                if (this.value) iconUrl.value = '';
            });

            iconUrl.addEventListener('input', function() {
                if (this.value) iconFile.value = '';
            });

            // Image handling
            const imageFile = document.getElementById('image_file');
            const imageUrl = document.getElementById('image_url');

            imageFile.addEventListener('change', function() {
                if (this.value) imageUrl.value = '';
            });

            imageUrl.addEventListener('input', function() {
                if (this.value) imageFile.value = '';
            });
        });
    </script>
    @endpush
</x-app-layout>
