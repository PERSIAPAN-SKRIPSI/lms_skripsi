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
                        <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                <form method="POST" action="{{ route('admin.categories.update', $category->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="$category->name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="slug" :value="__('slug')" />
                        <x-text-input id="slug" class="block mt-1 w-full" type="text" slug="slug"
                            :value="$category->slug" required autofocus autocomplete="slug" />
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="icon" :value="__('Icon')" />
                        <x-text-input id="icon" class="block mt-1 w-full" type="file" name="icon" autofocus
                            autocomplete="icon" />
                        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                        <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}"
                            class="mt-2 h-20 w-20 object-cover rounded-full">
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Update Category
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
