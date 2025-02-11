<!-- resources/views/admin/categories/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Category') }}
            </h2>
            <a href="{{ route('admin.categories.index') }}"
                class="font-bold py-2 px-4 bg-gray-700 hover:bg-gray-800 text-white rounded-md">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="py-3 px-4 mb-4 rounded-lg bg-red-100 text-red-700">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                <form method="POST" action="{{ route('admin.categories.update', $category->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="mb-6">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="$category->name" required autofocus />
                    </div>

                    <!-- Icon Section -->
                    <div class="mb-6">
                        <x-input-label :value="__('Icon')" class="mb-2" />

                        <!-- Current Icon Preview -->
                        @if($category->icon)
                            <div class="mb-4">
                                <label class="text-sm text-gray-600 mb-2 block">Current Icon:</label>
                                <img src="{{ filter_var($category->icon, FILTER_VALIDATE_URL) ? $category->icon : Storage::url($category->icon) }}"
                                     alt="Current Icon"
                                     class="w-20 h-20 object-cover rounded-lg border">
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- File Upload -->
                            <div>
                                <label class="text-sm text-gray-600 mb-2 block">Upload Icon:</label>
                                <input type="file"
                                       name="icon_file"
                                       id="icon_file"
                                       class="w-full border rounded-lg p-2"
                                       accept="image/*">
                            </div>

                            <!-- URL Input -->
                            <div>
                                <label class="text-sm text-gray-600 mb-2 block">OR Icon URL:</label>
                                <input type="text"
                                       name="icon_url"
                                       id="icon_url"
                                       class="w-full border rounded-lg p-2"
                                       placeholder="https://example.com/icon.png"
                                       value="{{ filter_var($category->icon, FILTER_VALIDATE_URL) ? $category->icon : '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Image Section -->
                    <div class="mb-6">
                        <x-input-label :value="__('Image')" class="mb-2" />

                        <!-- Current Image Preview -->
                        @if($category->image)
                            <div class="mb-4">
                                <label class="text-sm text-gray-600 mb-2 block">Current Image:</label>
                                <img src="{{ filter_var($category->image, FILTER_VALIDATE_URL) ? $category->image : Storage::url($category->image) }}"
                                     alt="Current Image"
                                     class="w-32 h-32 object-cover rounded-lg border">
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- File Upload -->
                            <div>
                                <label class="text-sm text-gray-600 mb-2 block">Upload Image:</label>
                                <input type="file"
                                       name="image_file"
                                       id="image_file"
                                       class="w-full border rounded-lg p-2"
                                       accept="image/*">
                            </div>

                            <!-- URL Input -->
                            <div>
                                <label class="text-sm text-gray-600 mb-2 block">OR Image URL:</label>
                                <input type="text"
                                       name="image_url"
                                       id="image_url"
                                       class="w-full border rounded-lg p-2"
                                       placeholder="https://example.com/image.jpg"
                                       value="{{ filter_var($category->image, FILTER_VALIDATE_URL) ? $category->image : '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg">
                            Update Category
                        </button>
                    </div>
                </form>
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
