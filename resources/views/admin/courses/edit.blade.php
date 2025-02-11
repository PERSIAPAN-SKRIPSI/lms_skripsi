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
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $course->name) }}" required autofocus />
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
                                <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="teacher_id" :value="__('Teacher')" />
                        <select name="teacher_id" id="teacher_id" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="">Choose Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id', $course->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="about" :value="__('About')" />
                        <textarea name="about" id="about" cols="30" rows="5" class="border border-slate-300 rounded-xl w-full">{{ old('about', $course->about) }}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="keypoints" :value="__('Keypoints')" />
                        <div class="flex flex-col gap-y-2">
                            @foreach($course->keypoints as $keypoint)
                                <x-text-input type="text" class="py-3 rounded-lg border border-slate-300" name="course_keypoints[]" value="{{ old('course_keypoints.' . $loop->index, $keypoint->name) }}" />
                            @endforeach
                        </div>
                         <x-input-error :messages="$errors->get('course_keypoints')" class="mt-2" />
                     </div>

                    <div class="mt-4">
                        <x-input-label for="demo_video_storage" :value="__('Demo Video Storage')" />
                        <select name="demo_video_storage" id="demo_video_storage" class="py-3 rounded-lg pl-3 w-full border border-slate-300" required>
                            <option value="" disabled {{ is_null(old('demo_video_storage')) ? 'selected' : '' }}>Select Storage Type</option>
                            <option value="upload" {{ old('demo_video_storage', $course->demo_video_storage) == 'upload' ? 'selected' : '' }}>Upload</option>
                            <option value="youtube" {{ old('demo_video_storage', $course->demo_video_storage) == 'youtube' ? 'selected' : '' }}>Youtube</option>
                            <option value="external_link" {{ old('demo_video_storage', $course->demo_video_storage) == 'external_link' ? 'selected' : '' }}>External Link</option>
                        </select>
                        <x-input-error :messages="$errors->get('demo_video_storage')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="demo_video_source" :value="__('Demo Video Source')" />
                        @if (old('demo_video_storage', $course->demo_video_storage) == 'upload')
                            <input type="file" id="demo_video_source_file" name="demo_video_source_file" class="block mt-1 w-full" />
                        @else
                            <x-text-input id="demo_video_source" class="block mt-1 w-full" type="text" name="demo_video_source" value="{{ old('demo_video_source', $course->demo_video_source) }}" />
                        @endif
                        <x-input-error :messages="$errors->get('demo_video_source')" class="mt-2" />
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
