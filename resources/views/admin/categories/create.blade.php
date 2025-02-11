<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Add New Category') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-6 bg-white">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="icon_file" class="block text-sm font-medium text-gray-700">Icon (File)</label>
                            <input type="file" name="icon_file" id="icon_file"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                            <img id="icon_preview" src="#" alt="Icon Preview" class="mt-2 w-10 h-10 rounded-lg object-cover hidden">
                            @error('icon_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Or, enter URL:</p>
                            <input type="url" name="icon_url" id="icon_url" value="{{ old('icon_url') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm" placeholder="http://example.com/icon.png">
                            @error('icon_url')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="image_file" class="block text-sm font-medium text-gray-700">Image (File)</label>
                            <input type="file" name="image_file" id="image_file"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                            <img id="image_preview" src="#" alt="Image Preview" class="mt-2 w-16 h-12 rounded-lg object-cover hidden">
                            @error('image_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Or, enter URL:</p>
                            <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm" placeholder="http://example.com/image.png">
                            @error('image_url')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.categories.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150 mr-4">
                                Back
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-500 to-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-teal-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition ease-in-out duration-150">
                                Add Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Icon Preview
        document.getElementById('icon_file').addEventListener('change', function(e) {
            let reader = new FileReader();
            let preview = document.getElementById('icon_preview');
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        });

        // Image Preview
        document.getElementById('image_file').addEventListener('change', function(e) {
            let reader = new FileReader();
            let preview = document.getElementById('image_preview');
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
    @endpush
</x-app-layout>
