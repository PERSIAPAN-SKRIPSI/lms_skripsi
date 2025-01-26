<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Video to Courses') }}
            </h2>
            <a href="{{ route('admin.courses.show', $courseVideo->course) }}"
                class="font-bold py-2 px-4 bg-gray-700 hover:bg-gray-800 text-white rounded-md">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">
                <div class="item-card flex flex-row gap-y-10 justify-between items-center">
                    <div class="flex flex-row items-center gap-x-3">
                        <img src="{{ Storage::url($courseVideo->course->thumbnail) }}" alt=""
                            class="rounded-2xl object-cover w-[120px] h-[90px]">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $courseVideo->course->name }}</h3>
                            <p class="text-slate-500 text-sm">{{ $courseVideo->course->category->name }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Teacher</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{ $courseVideo->course->teacher->user->name }}</h3>
                    </div>
                </div>

                <hr class="my-5">

                <form method="POST" action="{{ route('admin.course_videos.update', $courseVideo) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name') ?: $courseVideo->name"
                            autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="path_video" :value="__('Path Video')" />
                        <x-text-input id="path_video" class="block mt-1 w-full" type="text" name="path_video"
                            :value="old('path_video') ?: $courseVideo->path_video" autocomplete="path_video" />
                        <x-input-error :messages="$errors->get('path_video')" class="mt-2" />
                    </div>

                    <div class="flex items-center mt-4">
                        <button type="submit"
                            class="font-bold py-2 px-4 bg-indigo-700 hover:bg-indigo-800 text-white rounded-md">
                            Update Video
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
