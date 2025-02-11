<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Video') }}
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

                <form method="POST" action="{{ route('admin.courses.videos.update', ['course' => $course, 'video' => $courseVideo]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                      <div class="mt-4">
                        <x-input-label for="name" :value="__('Video Name')" />
                         <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                           value="{{ old('name', $courseVideo->name) }}" required autofocus autocomplete="name" />
                         <x-input-error :messages="$errors->get('name')" class="mt-2" />
                      </div>

                     <div class="mt-4">
                         <x-input-label for="path_video" :value="__('Path Video (URL)')" />
                         <x-text-input id="path_video" class="block mt-1 w-full" type="text" name="path_video" :value="old('path_video', $courseVideo->path_video)" autocomplete="path_video" />
                        <x-input-error :messages="$errors->get('path_video')" class="mt-2" />
                    </div>

                  <div class="mt-4">
                      <x-input-label for="chapter_id" :value="__('Chapter')" />
                        <select name="chapter_id" id="chapter_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                           <option value="">-- Pilih Chapter --</option>
                              @foreach ($chapters as $chapter)
                                 <option value="{{ $chapter->id }}" {{ old('chapter_id', $courseVideo->chapter_id) == $chapter->id ? 'selected' : '' }}>
                                      {{ $chapter->name }}
                                   </option>
                             @endforeach
                         </select>
                         <x-input-error :messages="$errors->get('chapter_id')" class="mt-2" />
                  </div>


                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Update Video
                        </button>
                    </div>
                </form>
                <div>
                    @if ($courseVideo->path_video)
                        <p class="mt-4">Current Video:</p>
                        <iframe width="560" height="315" src="{{ $courseVideo->path_video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    @else
                     <p>No Video</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
