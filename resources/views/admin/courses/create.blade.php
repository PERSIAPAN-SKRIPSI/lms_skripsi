<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('New Course') }}
            </h2>
            <a href="{{ route('admin.courses.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Whoops!</strong>
                        <span class="block sm:inline">There were some problems with your input.</span>
                        <ul class="mt-3 list-disc list-inside">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                                required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="thumbnail" :value="__('Thumbnail')" />
                            <x-text-input id="thumbnail" class="block mt-1 w-full" type="file" name="thumbnail"
                                 autocomplete="thumbnail" />
                            <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                        </div>

                          <div class="mb-4">
                            <x-input-label for="teacher_id" :value="__('Teacher')" />
                            <select name="teacher_id" id="teacher_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Choose Teacher</option>
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select name="category_id" id="category_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Choose category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="about" :value="__('About')" />
                            <textarea name="about" id="about" cols="30" rows="5"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('about') }}</textarea>
                            <x-input-error :messages="$errors->get('about')" class="mt-2" />
                        </div>


                        <div class="mb-4">
                            <x-input-label for="demo_video_storage" :value="__('Demo Video Source')" />
                            <select name="demo_video_storage" id="demo_video_storage"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Source</option>
                                <option value="upload" {{ old('demo_video_storage') == 'upload' ? 'selected' : '' }}>Upload</option>
                                <option value="youtube" {{ old('demo_video_storage') == 'youtube' ? 'selected' : '' }}>YouTube Link</option>
                                <option value="external_link" {{ old('demo_video_storage') == 'external_link' ? 'selected' : '' }}>External Link</option>
                            </select>
                            <x-input-error :messages="$errors->get('demo_video_storage')" class="mt-2"/>
                        </div>

                        <div class="mb-4" id="demo_video_source_container">
                            <x-input-label for="demo_video_source" :value="__('Demo Video Source')" />
                            {{-- Input field for file upload (initially hidden) --}}
                            <input type="file" name="demo_video_source_file" id="demo_video_source_file"
                                class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                accept="video/mp4,video/mpeg,video/quicktime,video/x-msvideo">

                            {{-- Input field for text (YouTube/External Link) --}}
                            <x-text-input type="text" name="demo_video_source" id="demo_video_source_text"
                                class="hidden mt-1 w-full" :value="old('demo_video_source')" />

                               <x-input-error :messages="$errors->get('demo_video_source')" class="mt-2"/>
                                 <x-input-error :messages="$errors->get('demo_video_source_file')" class="mt-2"/>
                        </div>

                         <div class="mb-4">
                            <x-input-label for="duration" :value="__('Duration')" />
                            <x-text-input id="duration" class="block mt-1 w-full" type="text" name="duration" :value="old('duration')"  autocomplete="duration"/>
                              <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                        </div>
                          <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea name="description" id="description" cols="30" rows="5"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="course_keypoints" :value="__('Keypoints')" />
                            <div class="grid grid-cols-1 gap-4">
                                @if(isset($course) && $course->keypoints)
                                    @foreach($course->keypoints as $key => $keypoint)
                                         <x-text-input type="text" name="course_keypoints[]" :value="old('course_keypoints.' . $key, $keypoint->name)"
                                         placeholder="Keypoint {{ $key + 1 }}" class="mt-1 block w-full" />
                                    @endforeach

                                    @for ($i = count($course->keypoints); $i < 4; $i++)
                                        <x-text-input type="text" name="course_keypoints[]" :value="old('course_keypoints.' . $i)"
                                            placeholder="Keypoint {{ $i + 1 }}" class="mt-1 block w-full" />
                                    @endfor
                                @else
                                    @for ($i = 0; $i < 4; $i++)
                                        <x-text-input type="text" name="course_keypoints[]" :value="old('course_keypoints.' . $i)"
                                            placeholder="Keypoint {{ $i + 1 }}" class="mt-1 block w-full" />
                                    @endfor
                                @endif
                            </div>
                             <x-input-error :messages="$errors->get('course_keypoints')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Add New Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const demoVideoStorageSelect = document.getElementById('demo_video_storage');
        const demoVideoSourceFile = document.getElementById('demo_video_source_file');
        const demoVideoSourceText = document.getElementById('demo_video_source_text');
        const demoVideoSourceContainer = document.getElementById('demo_video_source_container');


        function toggleSourceInput() {
            if (demoVideoStorageSelect.value === 'upload') {
                demoVideoSourceFile.classList.remove('hidden');
                demoVideoSourceText.classList.add('hidden');
                demoVideoSourceText.value = ''; // Clear text input
            }  else if (demoVideoStorageSelect.value === 'youtube' || demoVideoStorageSelect.value === 'external_link' ) {
                demoVideoSourceFile.classList.add('hidden');
                demoVideoSourceText.classList.remove('hidden');
                    demoVideoSourceFile.value = null;
            } else {
                demoVideoSourceFile.classList.add('hidden');
                demoVideoSourceText.classList.add('hidden');
                demoVideoSourceFile.value = null;
                demoVideoSourceText.value = '';
            }
        }
            toggleSourceInput();

        demoVideoStorageSelect.addEventListener('change', toggleSourceInput);
    });
</script>

</x-app-layout>
