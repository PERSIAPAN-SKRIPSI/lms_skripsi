<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="py-3 w-full rounded-3xl bg-red-500 text-white mb-4">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                <form method="POST" action="{{ route('admin.courses.update', $course->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $course->name }}" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="thumbnail" :value="__('Thumbnail')" />
                        <input type="file" id="thumbnail" name="thumbnail" class="block mt-1 w-full">
                        <p class="text-sm text-slate-400">Current Thumbnail: {{ $course->thumbnail }}</p>
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="">Choose category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="about" :value="__('About')" />
                        <textarea name="about" id="about" cols="30" rows="5" class="border border-slate-300 rounded-xl w-full">{{ $course->about }}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="price_in_coins" :value="__('Price in Coins')" />
                        <x-text-input id="price_in_coins" class="block mt-1 w-full" type="number" name="price_in_coins" value="{{ $course->price_in_coins }}" required min="0" />
                        <x-input-error :messages="$errors->get('price_in_coins')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="keypoints" :value="__('Keypoints')" />
                        <div class="flex flex-col gap-y-2">
                            @foreach($course->keypoints as $keypoint)
                                <input type="text" class="py-3 rounded-lg border border-slate-300" name="course_keypoints[]" value="{{ $keypoint->content }}">
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('course_keypoints')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Update Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
