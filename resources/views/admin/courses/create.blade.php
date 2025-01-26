<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('New Courses') }}
            </h2>
            <a href="{{ route('admin.courses.index') }}"
                class="font-bold py-2 px-4 bg-gray-700 hover:bg-gray-800 text-white rounded-md">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

                @if($errors->any())
                @foreach($errors->all() as $error)
                <div class="py-3 w-full rounded-md bg-red-500 text-white">
                    {{$error}}
                </div>
                @endforeach
                @endif

                <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                            autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="thumbnail" :value="__('Thumbnail')" />
                        <x-text-input id="thumbnail" class="block mt-1 w-full" type="file" name="thumbnail"
                            autocomplete="thumbnail" />
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="path_trailer" :value="__('Path Trailer')" />
                        <x-text-input id="path_trailer" class="block mt-1 w-full" type="text" name="path_trailer"
                            :value="old('path_trailer')" autocomplete="path_trailer" />
                        <x-input-error :messages="$errors->get('path_trailer')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="category" :value="__('Category')" />

                        <select name="category_id" id="category_id"
                            class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="">Choose category</option>
                            @forelse($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @empty
                            @endforelse
                        </select>

                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="about" :value="__('About')" />
                        <textarea name="about" id="about" cols="30" rows="5"
                            class="border border-slate-300 rounded-xl w-full"></textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>

                    <hr class="my-5">

                    <div class="mt-4">

                        <div class="flex flex-col gap-y-5">
                            <x-input-label for="keypoints" :value="__('Keypoints')" />
                            @for ($i = 0; $i < 4; $i++) <input type="text"
                                class="py-3 rounded-lg border-slate-300 border" placeholder="Write your copywriting"
                                name="course_keypoints[]">
                                @endfor
                        </div>
                        <x-input-error :messages="$errors->get('keypoints')" class="mt-2" />
                    </div>

                    <div class="flex items-center mt-4">

                        <button type="submit" class="font-bold py-2 px-4 bg-indigo-700 text-white rounded-md">
                            Add New Course
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
