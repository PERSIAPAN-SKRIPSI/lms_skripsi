<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Video to Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

                <div class="item-card flex flex-row gap-y-10 justify-between items-center">
                    <div class="flex flex-row items-center gap-x-3">
                        <img src="{{ Storage::url($course->thumbnail) }}" alt="" class="rounded-2xl object-cover w-[120px] h-[90px]">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $course->title }}</h3>
                            <p class="text-slate-500 text-sm">{{ $course->category->name }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Teacher</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{ $course->teacher->user->name }}</h3>
                    </div>
                </div>

                <hr class="my-5">

                <form method="POST" action="{{ route('admin.courses.videos.store', $course) }}" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="path_video" :value="__('Path Video (URL)')" />
                        <x-text-input id="path_video" class="block mt-1 w-full" type="text" name="path_video" :value="old('path_video')" autocomplete="path_video" />
                        <x-input-error :messages="$errors->get('path_video')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="chapter_id" :value="__('Chapter')" />
                        <select name="chapter_id" id="chapter_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Pilih Chapter --</option>
                            @foreach ($chapters as $chapter)
                                <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('chapter_id')" class="mt-2" />
                    </div>

                    <div class="flex items-center mt-4">
                        <button type="submit" class="font-bold py-2 px-4 bg-indigo-700 hover:bg-indigo-800 text-white rounded-md">
                            Add New Video
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
